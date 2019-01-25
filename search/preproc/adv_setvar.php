<?php
require_once("conv/init.php");
$sel="SELECT name FROM notebro_site.nomen WHERE type=16 OR type=21 OR type=31 OR type=35 or type=81";
mysqli_multi_query($con, $sel);
$result=mysqli_use_result($con);
$rand = mysqli_fetch_all($result);
if(isset($_GET['reset'])){$reset=intval($_GET['reset']);}
if(isset($_GET['sort_by'])){$sort_by=clean_string($_GET['sort_by']);}
$cpufreqmaxi=floatval($rand[0][0]); $cputdpmindb=floatval($rand[1][0]); $dispsizemindb=floatval($rand[2][0]); $memcapmindb=floatval($rand[3][0]); $gpumaxdatei=intval($rand[4][0]);
$display_hresmax = "200000";
$display_vresmax = "200000";
/**************************************************************/
/***** CONVERTING VARIABLES FROM SIMPLE TO ADVANCED SEARCH ****/
/**************************************************************/

if(isset($_GET['s_memmin']))
{
	$issimple=intval($_GET['s_memmin']);
	if ($issimple) 
	{ include ("conv/simpletoadv.php"); }
}
/********************************************************************/
/* CONVERTING VARIABLES FROM ADVANCED SEARCH TO ADVANCED SEARCH */	
/********************************************************************/

elseif (isset($_GET['advsearch']))
{ include ("conv/advtoadv.php"); }
/*******************************************************************/	
/* CONVERTING VARIABLES FROM QUIZ TO ADVANCED SEARCH */	
/*******************************************************************/

elseif (isset($_GET['quizsearch']) && $_GET['quizsearch'])
{ include ("conv/quiztoadv.php"); }
/*******************************************************************/	
/* CONVERTING VARIABLES FROM BROWSE BY TO ADVANCED SEARCH */	
/*******************************************************************/

elseif (isset($_GET['browse_by']) && $_GET['browse_by'])
{ include ("conv/browsetoadv.php"); }
else
{
/**** IF WE HAVE NO INCOMING VALUES WE NEED TO SET SOME DEFAULTS ****/
	$gputype = 2;
	$gputypechecked[0]='checked="checked"';

	if(isset($hddcapmin) && $hddcapmin) { $totalcapmin=$hddcapmin; $hddcapmin=0; }
	else { $totalcapmin=0; }
	
	$mdbslotsel0 = "selected";
	if(empty($_SESSION['exchcode'])||$reset){ $excode="USD"; } else { $excode=$_SESSION['exchcode']; }
	if($excode=="EUR"||$excode=="GBP"){ $regions='<option selected="selected">Europe</option>';}
}

/*******************************************************************/	
/* FINALLY SETTING DEFAULT DATABASE VALUES FOR VARIABLES THAT ARE NOT SET*/	
/*******************************************************************/
include ("conv/default_values.php");
include ("conv/genjsvar.php");
?>