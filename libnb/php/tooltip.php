<?php
require("../../etc/con_db.php");
$id = intval($_GET['id']);

if (!$con) 
{
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,$GLOBALS['global_notebro_site']);
$sql="SELECT text FROM tooltip WHERE id = '".$id."'";
$result = mysqli_query($con,$sql);

$rows = array();
$r = mysqli_fetch_assoc($result);
$rows[] = $r;
echo $rows[0]["text"];
	
mysqli_close($con);

?>
