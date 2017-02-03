<?php

function dbs_connect()
{
   static $link;
   $link = mysqli_init();

	$servers=3;
	$user="notebro_sdb";
	$pass="nBdBnologinsdb2";
	$database="notebro_temp";
	$hosts=["172.31.2.33","172.31.4.253","172.31.1.219"];
	$port="3306";
	
	$i=rand(0,($servers-1));
	
    $con = mysqli_real_connect($link, $hosts[$i], $user, $pass, $database);

    // If connection was not successful, handle the error
    if($con === false)
	{
       // Handle error - notify administrator, log to a file, show an error screen, etc.
       return mysqli_connect_error();
    }
    return $link;
}
$cons=dbs_connect();
?>