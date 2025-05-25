<?php
function db_connect()
{
   static $link;
   $link = mysqli_init();
	
	#GRANT SELECT ON `stch_retail_data`.`hp_price_data` TO 'hp_data_select'@'%' IDENTIFIED BY 'mFBW2epYWWltIuKRzgom';
	$user="hp_data_select";
	$pass="mFBW2epYWWltIuKRzgom";
	$database="stch_retail_data";
	$host="192.168.254.201";
	$port="13306";
			 
    $con = mysqli_real_connect($link, $host, $user, $pass, $database, $port);

    // If connection was not successful, handle the error
    if($con === false)
	{
       // Handle error - notify administrator, log to a file, show an error screen, etc.
       return mysqli_connect_error();
    }
	mysqli_set_charset($link,'utf8');
    return $link;
}

$rcon=db_connect();

if(!defined('__DB_ROOT__')){ define('__DB_ROOT__', dirname(dirname(__FILE__))); }
require_once(__DB_ROOT__."/libnb/php/db_utils.php");
?>
