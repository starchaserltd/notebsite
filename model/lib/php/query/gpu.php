<?php
require("../../../../etc/con_db.php");
require("../../../../etc/rates_conf.php");

if(isset($_GET['q'])){ $q = intval($_GET['q']); } else {$q=-1;}
if($q>=0)
{
	mysqli_select_db($con,"notebro_db");
	$sql="SELECT * FROM GPU WHERE id = '".$q."'";
	$result = mysqli_query($con,$sql);

	$rows = array();

	while($r = mysqli_fetch_assoc($result)) 
	{
		 while($elm=each($r))
		{
			if(is_numeric($r[$elm["key"]]))
			{ $r[$elm["key"]]+=0; }
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
			case ($rows[0]['power']<10):
				$rows[0]['class']="Basic/Integrated";
				break;
			case ($rows[0]['power']>=10 && $rows[0]['power']<20):
				$rows[0]['class']="Basic/Multimedia";
				break;
			case ($rows[0]['power']>=20 && $rows[0]['power']<35):
				$rows[0]['class']="Budget/Casual Gaming";
				break;
			case ($rows[0]['power']>=35 && $rows[0]['power']<55):
				$rows[0]['class']="Midrange";
				break;
			case ($rows[0]['power']>=55 && $rows[0]['power']<76):
				$rows[0]['class']="Highend";
				break;
			case ($rows[0]['power']>=76 && $rows[0]['power']<105):
				$rows[0]['class']="Extreme";
				break;
			case ($rows[0]['power']>=105 && $rows[0]['power']<500):
				$rows[0]['class']="Desktop";
				break;
			default:
				$rows[0]['class']="Undefined";
				break;
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
	if($rows[0]['arch']=="Pascal"){$rows[0]["power"]/=1.5;}
	$rows[0]['bat']=floatval($rows[0]["power"])/8;
	if(!$rows[0]['typegpu']) { $rows[0]['power']="-"; }

	$rows[0]['rating']=sprintf("%.1f", round($rows[0]['rating'],1));
	print json_encode($rows[0]);
	mysqli_close($con);
}
?>