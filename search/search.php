<?php
require_once("../etc/conf.php");
if (!isset($_SERVER['HTTP_REFERER']) || stripos($_SERVER['HTTP_REFERER'],$site_name) ==FALSE) 
{	$actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	header("Location: http://".str_replace($site_name."/",$site_name."/?",$actual_link)."");
	die();
}
require_once("../etc/session.php");
require_once("../libnb/php/urlproc.php");
require_once("proc/init.php");
$absolute_url = str_replace($web_address,"",full_url( $_SERVER ));
$absolute_url=explode("&page=",$absolute_url,2);

//THIS is a security key to prevent unauthorised access of code, basically we allow this script to work only when it has been accessed by another php page 
if(strcmp("kMuGLmlIzCWmkNbtksAh",$_SESSION['auth'])==0)
{
	//$_SESSION['auth']=0;
	require_once("../etc/con_db.php");
	
	/********************************************************************/
	/* GENERIC SEARCH VARIABLES */	
	/********************************************************************/
	if(isset($_GET['advsearch'])) { $isadvanced=$_GET['advsearch']; }
	if(isset($_GET['performfocus'])) { $issimple=$_GET['performfocus']; }
	
	if(isset($_GET['sort_by'])){ $sort_by=$_GET['sort_by']; }
	else { $sort_by="value"; }
	$name_button=""; $performance_button=""; $value_button=""; $price_button="";
	//SET PARAMETERS FOR ORDERING
	switch($sort_by) 
	{
		case "performance":
		{
			$orderby =  "ORDER BY rating DESC";
			$orderby_index = "USE INDEX FOR ORDER BY (rating)";
			$performance_button = " active";
			$sort_func = "sort_func_by_rating";
			break;
		}
		case "value":
		{
			$orderby = "ORDER BY value DESC";
			$orderby_index = "USE INDEX FOR ORDER BY (value)";
			$value_button = " active";
			$sort_func = "sort_func_by_value";
			break;
		}
		case "price":
		{
			$orderby = "ORDER BY price ASC";
			$orderby_index = "USE INDEX FOR ORDER BY (price)";
			$price_button = " active";
			$sort_func = "sort_func_by_price";
			break;
		}
		case "name":
		{
			$orderby =  "";
			$name_button = " active";
			$sort_func = "id";
			break;
		}
		default:
		{
			$orderby = "ORDER BY value DESC";
			$orderby_index = "USE INDEX FOR ORDER BY (value_desc)";
			$value_button = " active";
			$sort_func = "sort_func_by_value";
			break;
		}
	}

	if((isset($_GET['exchange']) && is_string($_GET['exchange']))||(isset($_GET['exchadv']) && is_string($_GET['exchadv'])))
	{
		if(isset($_GET['exchange'])){ $excode=$_GET['exchange']; }
		if(isset($_GET['exchadv'])){ $excode=$_GET['exchadv']; }
		$sel2 = "SELECT convr,code,sign, ROUND( convr, 5 ) FROM notebro_site.exchrate WHERE code='".$excode."' LIMIT 1";
	}
	else
	{
		$sel2 = "SELECT convr,code,sign, ROUND( convr, 5 ) FROM notebro_site.exchrate WHERE code='USD' LIMIT 1";
	}
	
	$result = mysqli_query($con,$sel2);
	$value=mysqli_fetch_array($result);
	$exch=floatval($value[0]);
	$exchsign=$value["sign"];
	$exchcode=$value["code"];
	$_SESSION['exchcode']=$exchcode;
	$_SESSION['exch']=$exch;
	$_SESSION['exchsign']=$value["sign"];
	
	if(isset($_GET['page'])){$page=$_GET['page'];} 
	else {$page=1;}
	
	if(isset($_GET['detailed'])) { $isdetailed=(is_numeric($_GET['detailed'])) ? intval($_GET['detailed']) : NULL; }
	
	/********************************************************************/
	/* CHECKING IF DOING SIMPLE SEARCH */	
	/********************************************************************/

	if ($issimple) 
	{	
	include ("preproc/s_search_varproc.php");
	}

	/********************************************************************/
	/* CHECKING IF DOING ADVANCED SEARCH */	
	/********************************************************************/

	else if ( isset($_GET['advsearch']) && $_GET['advsearch'])
	{
		include ("preproc/adv_search_varproc.php");
	}
	
	/********************************************************************/
	/* CHECKING IF DOING QUIZ SEARCH */	
	/********************************************************************/

	else if ( isset($_GET['quizsearch']) && $_GET['quizsearch'])
	{
		include ("preproc/quiz_search_varproc.php");
	}
	/********************************************************************/
	/* CHECKING IF DOING BROWSE SEARCH */	
	/********************************************************************/

	else if ($_GET['browse_by'])
	{
		include ("preproc/b_search_varproc.php");
	}
	

	require("proc/search_filters.php");
/*
	$result = mysqli_query($GLOBALS['con'], "SELECT code,sign, ROUND( convr, 5 ) rounded FROM notebro_site.exchrate HAVING rounded = $exch"); 
	$item = mysqli_fetch_array($result);
	$exchsign=$item["sign"];
	$exchcode=$item["code"];
	$_SESSION['exchcode']=$exchcode;
	$_SESSION['exch']=$exch;
*/
	include("results.php");
	exit();
}
else
{
	echo "Heh! What are you trying to do?";
}
?>