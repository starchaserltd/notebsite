<?php
if(isset($_GET['q'])){ $q=filter_var($_GET['q'], FILTER_VALIDATE_INT); if($q===FALSE){ $q=-1; } } else { $q=-1;}
if($q>=0)
{
	require("../../../../etc/con_db.php");
	require("../../../../etc/rates_conf.php");
	
	mysqli_select_db($con,$global_notebro_db);
	$sql="SELECT * FROM MDB WHERE id = '".$q."'";
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
		if(stripos($rows[0]['msc'],"optimus")===false && stripos($rows[0]['msc'],"enduro")===false) { $rows[0]['optimus']=0; } else {$rows[0]['optimus']=1;}
		$rows[0]['msc']=str_replace(",", ", ",$rows[0]['msc']);
		$rows[0]['interface']=str_replace(",", ", ",$rows[0]['interface']);
		$rows[0]['hdd']=str_replace(",", ", ",$rows[0]['hdd']);

		if(!$rows[0]['msc']) { $rows[0]['msc']="-"; }
		if(!$rows[0]['ram'] || $rows[0]['ram']=="0") { $rows[0]['ram']="Soldered"; }
		if(!$rows[0]['interface']) { $rows[0]['interface']="-"; }
		if(!$rows[0]['hdd']) { $rows[0]['hdd']="-"; }
		if(strcasecmp("NONE",$rows[0]['netw'])==0) { $rows[0]['netw']=ucfirst(strtolower($rows[0]['netw'])); }
		
		switch ($rows[0]['gpu'])
		{
			case "1":
				$rows[0]['gpu'] = 'On board';
				break;
			case "2":
				$rows[0]['gpu'] ="Replaceable";
				break;
			case "3":
				$rows[0]['gpu'] ="MXM Replaceable";
				break;
		}

		$rows[0]['confrate'] = round($rows[0]['rating'],3)*$mdb_i/100;	
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
