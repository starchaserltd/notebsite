<?php
if(isset($_GET['q'])){ $q=filter_var($_GET['q'], FILTER_VALIDATE_INT); if($q===FALSE){ $q=-1; } } else { $q=-1;}
if($q>=0)
{
	require("../../../../etc/con_db.php");
	require("../../../../etc/rates_conf.php");
	
	mysqli_select_db($con,$global_notebro_db);
	$sql="SELECT * FROM DISPLAY WHERE id = '".$q."'";
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
		$msc=array(); 
		if($rows[0]['msc']!=null&&$rows[0]['msc']!="")
		{
			$rows[0]['msc']=str_replace(",", ", ",$rows[0]['msc']);
			$msc=explode(",",$rows[0]['msc']);
		}
		if(intval($rows[0]['hz'])>60){$msc["hz"]=$rows[0]['hz']."Hz";}
		if(intval($rows[0]['hdr'])>0){$msc["hdr"]="HDR";}
		if(count($msc)>0)
		{ $msc=array_unique($msc); $rows[0]['msc']=implode(", ",$msc); }
		else
		{ $rows[0]['msc']="-";}
		
		switch ($rows[0]['touch'])
		{
			case 1:
				$rows[0]['touch'] ="Yes";
				break;
			case 2:
				$rows[0]['touch'] = 'No';
				break;
		}
		
		if(stripos($rows[0]["backt"],"OLED")!==FALSE || stripos($rows[0]["backt"],"mLED")!==FALSE)
		{ $rows[0]['bat']=((floatval($rows[0]["size"])*0.10)+(pow((intval($rows[0]["hres"])*intval($rows[0]["vres"])),0.5)*0.00255-3.4))*0.6; }
		else
		{ $rows[0]['bat']=((floatval($rows[0]["size"])*0.10)+(pow((intval($rows[0]["hres"])*intval($rows[0]["vres"])),0.5)*0.00255-3.4))*0.7; }
		
		if($rows[0]['touch']=="Yes"){ $rows[0]['bat']+=(floatval($rows[0]["size"])*floatval($rows[0]["size"]))/400; }
				
		//$rows[0]['price']=round($rows[0]['price'],2);
		$rows[0]['price']=0;
		$rows[0]['confrate'] = round($rows[0]['rating'],3)*$display_i/100;
	}

	$rows[0]['rating']=sprintf("%.1f", round($rows[0]['rating'],1));
	print json_encode($rows[0]);
	mysqli_close($con);
}
else
{ header('X-PHP-Response-Code: 204', true, 204); }
?>