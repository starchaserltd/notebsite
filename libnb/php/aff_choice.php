<?php
require_once("../../etc/con_db.php");
require_once("../../etc/conf.php");
if(isset($_POST['choice']))
{
	$choice=intval($_POST['choice']);
	mysqli_query($con,"INSERT INTO `".$GLOBALS['global_notebro_site']."`.`affil_choice` (`choice`) VALUES ('".$choice."')");
	mysqli_close($con);
}

?>