<?php
require("../../../../etc/con_db.php");
require("../../../../etc/rates_conf.php");

if(isset($_GET['q'])){ $q = intval($_GET['q']); } else {$q=-1;}
if($q>=0)
{
	mysqli_select_db($con,"notebro_db");
	$sql="SELECT * FROM WAR WHERE id = '".$q."'";
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

		if(!$rows[0]['msc']) { $rows[0]['msc']="-"; }
		
		switch ($rows[0]['typewar'])
		{
			case 1:
				$rows[0]['typewar'] ="Next-Business-Day";
				break;
			case 2:
				$rows[0]['typewar'] = 'Standard';
				break;
		}
		$rows[0]['confrate'] = round($rows[0]['rating'],3)*$war_i/100;	
	}
	$rows[0]['price']=round($rows[0]['price'],2);
	$row[0]['rating']=0;
	print json_encode($rows[0]);
	mysqli_close($con);
}
?>
