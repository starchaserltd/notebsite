<?php
require_once("conv/init.php");
$sel="SELECT name FROM notebro_site.nomen WHERE type=16 OR type=21 OR type=31 OR type=35 or type=81";
//echo $sel;
mysqli_multi_query($con, $sel);
$result=mysqli_use_result($con);
$rand = mysqli_fetch_all($result);
$cpufreqmaxi=floatval($rand[0][0]); $cputdpmindb=floatval($rand[1][0]); $dispsizemindb=floatval($rand[2][0]); $memcapmindb=floatval($rand[3][0]); $gpumaxdatei=intval($rand[4][0]);
$display_hresmax = "200000";
$display_vresmax = "200000";
/**************************************************************/
/***** CONVERTING VARIABLES FROM SIMPLE TO ADVANCED SEARCH ****/
/**************************************************************/

if(isset($_GET['performfocus']))
{
	$issimple=$_GET['performfocus'];
	if ($issimple) 
	{	
		include ("conv/simpletoadv.php");
	}
}
/********************************************************************/
/* CONVERTING VARIABLES FROM ADVANCED SEARCH TO ADVANCED SEARCH */	
/********************************************************************/

else if (isset($_GET['advsearch']))
{
	include ("conv/advtoadv.php");
}
/*******************************************************************/	
/* CONVERTING VARIABLES FROM QUIZ TO ADVANCED SEARCH */	
/*******************************************************************/

else if (isset($_GET['quizsearch']) && $_GET['quizsearch'])
{
	include ("conv/quiztoadv.php");
}
/*******************************************************************/	
/* CONVERTING VARIABLES FROM BROWSE BY TO ADVANCED SEARCH */	
/*******************************************************************/

else if (isset($_GET['browse_by']) && $_GET['browse_by'])
{
	include ("conv/browsetoadv.php");
}
/**** IF WE HAVE NO INCOMING VALUES WE NEED TO SET SOME DEFAULTS ****/
else
{
	$gputype = 2;
	$gputypechecked[0]='checked="checked"';

	if(isset($hddcapmin) && $hddcapmin) { $totalcapmin=$hddcapmin; $hddcapmin=0; }
	else { $totalcapmin=0; }
	
	$mdbslotsel0 = "selected";
}

/*******************************************************************/	
/* FINALLY SETTING DEFAULT DATABASE VALUES FOR VARIABLES THAT ARE NOT SET*/	
/*******************************************************************/
include ("conv/default_values.php");
include ("conv/genjsvar.php");
?>