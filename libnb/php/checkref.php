<?php
function checkref($usertag)
{
	require_once("../../etc/con_db.php"); $return=0;
	$usertag=mysqli_real_escape_string($con,filter_var($usertag, FILTER_SANITIZE_STRING));
	$result=mysqli_query($con,"SELECT * FROM `notebro_buy`.`TAGS` WHERE usertag='".$usertag."' LIMIT 1");
	if($result && mysqli_num_rows($result)>0){ $return=1; }
	return $return;
}
if(isset($_GET["ref"])&&$_GET["ref"]!="")
{ echo checkref($_GET["ref"]); }
else
{ echo 0; }
?>