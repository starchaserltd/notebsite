<?php
if(isset($_GET['q'])){ $q=filter_var($_GET['q'], FILTER_VALIDATE_INT); if($q===FALSE){ $q=-1; } } else { $q=-1;}
if($q>=0)
{
	require("../../../../etc/con_db.php");
	require("../../../../etc/rates_conf.php");
	
	mysqli_select_db($con,$global_notebro_db);
	$sql="SELECT * FROM SIST WHERE id = '".$q."'";
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
		$rows[0]['confrate'] = round($rows[0]['rating'],3)*$sist_i/100;	
		
		if(!$rows[0]['msc']) { $rows[0]['msc']="-"; }
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