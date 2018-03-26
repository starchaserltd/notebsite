<?php
if(isset($_GET['c'])){ $c=$_GET['c']; if(stripos($c,"undefined")==FALSE){ $conf = explode("-",$c);}else{$c=0;} } else {$conf=array(); $c=0;}

if($c)
{
	$rows = array(); require("../../../../etc/con_sdb.php"); 
	$sql="SELECT id,price,err FROM notebro_temp.all_conf_".$conf[0]." WHERE model=".$conf[0]." AND cpu=".$conf[1]." AND display=".$conf[2]." AND mem=".$conf[3]." AND hdd=".$conf[4]." AND shdd=".$conf[5]." AND gpu=".$conf[6]." AND wnet=".$conf[7]." AND odd=".$conf[8]." AND mdb=".$conf[9]." AND chassis=".$conf[10]." AND acum=".$conf[11]." AND war=".$conf[12]." AND sist=".$conf[13]." LIMIT 1";
	$result = mysqli_query($cons,$sql);
	if($result!==FALSE)
	{
		$confdata = mysqli_fetch_row($result);
		$rows["cid"]=$confdata[0];
		$rows["cprice"]=$confdata[1];
		$rows["cerr"]=$confdata[2];
	}
	mysqli_close($cons);
	print json_encode($rows);
}	
?>