<?php
require("../../etc/con_db.php"); $return=0;
if(isset($_GET["ref"])&&$_GET["ref"]!="")
{
	$usertag=mysqli_real_escape_string($con,filter_var($_GET["ref"], FILTER_SANITIZE_STRING));
	$result=mysqli_query($con,"SELECT * FROM `notebro_buy`.`TAGS` WHERE usertag='".$usertag."' LIMIT 1");
	if($result && mysqli_num_rows($result)>0){ $return=1; }
}
echo $return;
?>