<?php
if(isset($_GET['q'])){ $q=filter_var($_GET['q'], FILTER_VALIDATE_INT); if($q===FALSE){ $q=-1; } } else { $q=-1;}
if($q>=0)
{
	require("../../../../etc/con_db.php");
	require("../../../../etc/rates_conf.php");
	
	mysqli_select_db($con,$global_notebro_db);
	$sql="SELECT * FROM HDD WHERE id = '".$q."'";
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
		$rows[0]['confrate'] = round($rows[0]['rating'],3)*$shdd_i/100;	
			
		if(!$rows[0]['msc']) { $rows[0]['msc']="-"; }	
		if(!$rows[0]['rpm']) { $rows[0]['rpm']="-"; }
	}
	switch($rows[0]["type"])
	{
		case "SSD":
		$rows[0]['bat']=0.5;
		break;
		case "HDD":
		$rows[0]['bat']=1;
		break;
		case "SSHD":
		$rows[0]['bat']=0.9;
		break;
		case "EMMC":
		$rows[0]['bat']=0.3;
		break;													
	}
	//$rows[0]['price']=round($rows[0]['price'],2);
	$rows[0]['price']=0;
	$rows[0]['rating']=0;
	print json_encode($rows[0]);
	mysqli_close($con);
}
else
{ header('X-PHP-Response-Code: 204', true, 204); }
?>
