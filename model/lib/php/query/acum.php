<?php
if(isset($_GET['q'])){ $q=filter_var($_GET['q'], FILTER_VALIDATE_INT); if($q===FALSE){ $q=-1; } } else { $q=-1;}
if($q>=0)
{
	require("../../../../etc/con_db.php");
	require("../../../../etc/rates_conf.php");
	mysqli_select_db($con,$global_notebro_db);
	$sql="SELECT * FROM ACUM WHERE id = '".$q."'";
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
		$rows[0]['msc'] = str_replace(",", ", ", (string) $rows[0]['msc']);
		if(!$rows[0]['msc']) { $rows[0]['msc']="-"; }
		if(!$rows[0]['tipc']) { $rows[0]['tipc']="-"; }
		if(!$rows[0]['nrc']) { $rows[0]['nrc']="-"; }
		if(!$rows[0]['cap']) { $rows[0]['cap']="-"; }
		//$rows[0]['price']=round($rows[0]['price'],2);
		$rows[0]['price']=0;
		
		$rows[0]['confrate'] = round($rows[0]['rating'],3)*$acum_i/100;	
	}
	//$rows[0]['rating']=sprintf("%.1f", round($rows[0]['rating'],1));
	$rows[0]['rating']=0;
	print json_encode($rows[0]);
	mysqli_close($con);
}
else
{ header('X-PHP-Response-Code: 204', true, 204); }
?>
