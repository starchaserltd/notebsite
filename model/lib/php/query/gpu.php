<?php
if(isset($_GET['q'])){ $q=filter_var($_GET['q'], FILTER_VALIDATE_INT); if($q===FALSE){ $q=-1; } } else { $q=-1;}
if($q>=0)
{
	require("../../../../etc/con_db.php");
	require("../../../../etc/rates_conf.php");
	
	mysqli_select_db($con,$global_notebro_db);
	$sql="SELECT * FROM GPU WHERE id = '".$q."'";
	$result = mysqli_query($con,$sql);

	$rows = array();

	while($r = mysqli_fetch_assoc($result)) 
	{
		foreach ($r as $key => $value) {
			if (is_numeric($value)) {
				$r[$key] += 0;          // cast numeric strings to numbers
			}
		}

		$rows[] = $r;
		$rows[0]['msc']=str_replace(",", ", ",$rows[0]['msc']);
		
		if($rows[0]['bspeed'])
		{ 
			if($rows[0]['msc'])
			{ $rows[0]['msc']="Boost Frequency ".$rows[0]['bspeed']." MHz, ".$rows[0]['msc']; }
			else
			{ $rows[0]['msc']="Boost Frequency ".$rows[0]['bspeed']." MHz"; }
		}
		if(strcmp($rows[0]['prod'],"INTEL")==0){$rows[0]['prod']=ucfirst(strtolower($rows[0]['prod']));}
		
		$rows[0]['confrate'] = round($rows[0]['rating'],3)*$gpu_i/100;	

		if(!$rows[0]['msc']) { $rows[0]['msc']="-"; }
			
		switch (true)
		{
			case ($rows[0]['power']<10): 						   { $rows[0]['class']="Basic/Integrated"; break; }
			case ($rows[0]['power']>=10 && $rows[0]['power']<=25): { $rows[0]['class']="Basic/Multimedia"; break; }
			case ($rows[0]['power']>25 && $rows[0]['power']<45):   { $rows[0]['class']="Budget/Casual gaming"; break; }
			case ($rows[0]['power']>=45 && $rows[0]['power']<70):  { $rows[0]['class']="Low mid-range"; break; }
			case ($rows[0]['power']>=70 && $rows[0]['power']<90):  { $rows[0]['class']="Mid-range"; break; }
			case ($rows[0]['power']>=90 && $rows[0]['power']<500): { $rows[0]['class']="High-end"; break; }
			default: 											   { $rows[0]['class']="Undefined"; break; }
		}
		
		switch ($rows[0]['sharem'])
		{
			case 1:
				$rows[0]['sharem']="No";
				break;
			case 2:
				$rows[0]['sharem']="Yes";
				break;
			default:
				$rows[0]['class']="Unspecified";
				break;
		}
	}
		//$rows[0]['price']=round($rows[0]['price'],2);
	$row[0]['price']=0;
	$rows[0]['bat']=floatval($rows[0]["power"])/8;
	if($rows[0]['arch']=="Pascal" || $rows[0]['arch']=="Turing"){$rows[0]["bat"]/=1.5;}
	if(!$rows[0]['typegpu']) { $rows[0]['power']="-"; $rows[0]["bat"]=0.2; }

	$rows[0]['rating']=sprintf("%.1f", round($rows[0]['rating'],1));
	print json_encode($rows[0]);
	mysqli_close($con);
}
else
{ header('X-PHP-Response-Code: 204', true, 204); }
?>