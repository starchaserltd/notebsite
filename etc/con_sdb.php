<?php

function dbs_connect()
{
   static $link;
   $link = mysqli_init();

	$servers=1;
	$user="YOUR_DB_USER;
	$pass="YOUR_DB_PASSWORD;
	$database="notebro_temp";
	$hosts=["0.0.0.0","0.0.0.0","0.0.0.0"];
	$port="13306";
	
	$i=rand(0,($servers-1));
	
    $con = mysqli_real_connect($link, $hosts[$i], $user, $pass, $database, $port);

    // If connection was not successful, handle the error
    if($con === false)
	{
       // Handle error - notify administrator, log to a file, show an error screen, etc.
       return mysqli_connect_error();
    }
    return $link;
}
$cons=dbs_connect();
if(!defined('__DB_ROOT__')){ define('__DB_ROOT__', dirname(dirname(__FILE__))); }
require_once(__DB_ROOT__."/libnb/php/db_utils.php");
?>
