<?php
require("../../../../etc/con_db.php");
require("../../../../etc/rates_conf.php");

if(isset($_GET['q'])){ $q = intval($_GET['q']); } else {$q=-1;}
if($q>=0)
{
	mysqli_select_db($con,"notebro_db");
	$sql="SELECT * FROM MDB WHERE id = '".$q."'";
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
?>
