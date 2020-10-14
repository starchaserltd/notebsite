<!DOCTYPE html>
<html>
	<head>
	<style>
		table, th, td { border: 1px solid black; }
	</style>
	</head>
	<body style="background-color:#a8649b" >
<?php
error_reporting(E_ALL);
require_once("../etc/conf.php");
require_once("../etc/con_rdb.php");
require_once("../etc/con_db.php");
require_once("../etc/con_sdb.php");
?>
<?php

#GET SDB LIST
if(isset($_GET["prod"]) && intval($_GET["prod"]==1))
{
	$servers=file('/var/www/vault/etc/sservers', FILE_SKIP_EMPTY_LINES);
	$i=0;
	foreach($servers as $line)
	{ $servers[$i]=explode(" ",trim(preg_replace('/\s+/', ' ', $line))); $i++; }
	unset($servers[1][0]);
	$hosts=$servers[1];
}
else
{
	$hosts=["86.123.134.38"];
}

if(isset($_GET["id"])&&isset($_GET["price"]))
{
	$ok_to_go=False;
	$conf_id=strval($_GET["id"]);
	$SELECT_1="SELECT `model` FROM `notebro_temp`.`all_conf` WHERE `id`='".$conf_id."' LIMIT 1";
	$temp_result=mysqli_query($cons,$SELECT_1);
	if(have_results($temp_result))
	{
		$temp_row=mysqli_fetch_assoc($temp_result);
		$model_id=$temp_row["model"];
		$ok_to_go=True;
		unset($temp_row);
		mysqli_free_result($temp_result);
	}
	else
	{ echo "Wrong conf id!<br>"; }
	
	$price=intval($_GET["price"]);
	if($price<100)
	{ $ok_to_go=False; echo "Wrong price!<br>"; }
	
	if(isset($_GET["retailer"]))
	{
		$retailer=strval($_GET["retailer"]);
	}
	else
	{ $ok_to_go=False; }

	$price_try=False;
	if(isset($_GET["retailer_pid"]))
	{
		$retailer_pid=strval($_GET["retailer_pid"]);
		$SELECT_TEST="SELECT * FROM `notebro_buy`.`FIXED_CONF_PRICES` WHERE `retailer`='".$retailer."' AND `retailer_pid`='".$retailer_pid."' LIMIT 1";
		$temp_result=mysqli_query($con,$SELECT_TEST);
		if(have_results($temp_result))
		{
			//Do nothing
			mysqli_free_result($temp_result);
		}
		else
		{
			$price_try=True;
			echo "Could not identify the retailer_pid, trying by price.<br>";
		}
	}
	else
	{ $price_try=True; }
	
	if($ok_to_go and $price_try)
	{
		if(isset($_GET["org_price"]))
		{
			$org_price=intval($_GET["org_price"]);
			$SELECT_TEST="SELECT `retailer_pid` FROM `notebro_buy`.`FIXED_CONF_PRICES` WHERE `retailer`='".$retailer."' AND `price`='".$org_price."'";
			$temp_result=mysqli_query($con,$SELECT_TEST);
			if(have_results($temp_result))
			{
				if(mysqli_num_rows($temp_result)!=1)
				{
					$ok_to_go=False;
					echo "More than one retailer pid identified with this price.<br>";
				}
				else
				{
					$temp_row=mysqli_fetch_assoc($temp_result);
					$retailer_pid=$temp_row["retailer_pid"];
					unset($temp_row);
				}
				mysqli_free_result($temp_result);
			}
			else
			{
				$ok_to_go=False; echo "Unable to identify retailer.<br>";
			}
		}
		else
		{ $ok_to_go=False; echo "No original price provided.<br>"; }
	}
	
	
	$conf_data=NULL;
	if($ok_to_go)
	{
		$SELECT_2="SELECT * FROM `notebro_temp`.`all_conf_".$model_id."` WHERE `id`='".$conf_id."' LIMIT 1";
		$temp_result=mysqli_query($cons,$SELECT_2);
		if(have_results($temp_result))
		{
			$conf_data=mysqli_fetch_assoc($temp_result);
			$ok_to_go=True;
			mysqli_free_result($temp_result);
		}
		else
		{ $ok_to_go=False; echo "Got model but no conf data!<br>"; }
	}
	$comp_list=["cpu","display","mem","hdd","shdd","gpu","wnet","odd","mdb","chassis","acum","war","sist"];
	if($ok_to_go)
	{
		$links=array();
		$scon_data=dbs_connect("get_con_data");
		foreach($hosts as $host)
		{
			$link=NULL;
			$link=mysqli_init();
			$scon=mysqli_real_connect($link, $host, $scon_data["user"], $scon_data["pass"], $scon_data["db"], $scon_data["port"]);
			// If connection was not successful, handle the error
			if($scon === false) 
			{
			   // Handle error - notify administrator, log to a file, show an error screen, etc.
			   return mysqli_connect_error(); 
			}
			else
			{
				$links[]=$link;
			}
			unset($link);
		}

		#UPDATE SEARCH SERVERS
		$SQL_UPDATE="UPDATE `all_conf_".$model_id."` SET `price`='".$price."', `value`=(`rating`/".$price.") WHERE `all_conf_".$model_id."`.`id` ='".$conf_id."'"; 
		foreach($links as $link)
		{
			if(mysqli_query($link,$SQL_UPDATE))
			{
				if(mysqli_affected_rows($link)>0)
				{
					echo "Update succesful on ssever!<br>";
				}
				else
				{ echo "Unable to update, some parameters are not set correctly"; }
			}
			else
			{
				echo "Update error!<br>";
				echo $SQL_UPDATE."<br>";
				echo mysqli_error($link);
				echo "<br>";
			}
		}
		
		#UPDATE BUY LINK
		$SQL_UPDATE="UPDATE `notebro_buy`.`FIXED_CONF_PRICES` SET `price`='".$price."' WHERE `model`='".$model_id."' AND `retailer`='".$retailer."' AND `retailer_pid`='".$retailer_pid."' ";
		foreach($comp_list as $comp)
		{
			$SQL_UPDATE=$SQL_UPDATE." AND `".$comp."`='".$conf_data[$comp]."'";
		}
		echo $SQL_UPDATE; echo "<br>";
		if(mysqli_query($con,$SQL_UPDATE))
		{
				if(mysqli_affected_rows($con)>0)
				{
					echo "Update succesful fixed server!<br>";
				}
				else
				{ echo "Unable to update, some parameters are not set correctly, e.g. retailer_pid does not match config id!<br>"; }
		}
		else
		{
			echo "Update error!<br>";
			echo $SQL_UPDATE."<br>";
			var_dump(mysqli_error($con));
			echo "<br>";
		}
	}
}
else
{ echo "Missing price and/or conf!"; }
?>
</html>






