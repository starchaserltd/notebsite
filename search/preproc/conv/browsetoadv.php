<?php
require_once("../etc/con_db.php");
$sql = "SELECT name FROM notebro_site.nomen WHERE type=70 OR type=71"; 
$result = mysqli_fetch_all(mysqli_query($con,$sql));
$bdgmin=$result[0][0];
$bdgmax=$result[1][0];
$browse_by = $_GET['browse_by']; $producer="";	
switch ($browse_by) 
{
	case "prod":
	{
		if($_GET['prod']){	$producer.='<option selected="selected">'.$_GET['prod'].'</option>'; }
		$prod_model = $_GET['prod'];
		$mdbslotsel0 = "selected"; //plus
		$nrhdd = 1;
		$gputype = 2;
		$mdbwwan = 0;
		$mdbwwansel0 = "selected";
		break;
	}		
	case "mainstream":
	{	
		$cputdpmin = 4;
		$displaysizemin=14;
		$displaysizemax=17.3;
		$display_touch[] = "1"; $display_touch[] ="2"; 
		$cputdpmax = 35;
		$mdbwwan = 1;
		$mdbwwansel1 = "selected";
		$chassisweightmin= 1.80;
		$chassisweightmax=3;
		$chassisthicmin=10;
		$chassisthicmax=30;
		$gputype=1;
		$gputypesel[0]="selected";
		$nrhdd = 1;
		$mdbslotsel0 = "selected";		
		break;
	}
	case "ultraportable":
	{
		$mdbslotsel0 = "selected";
		$mdbwwan = 0;
		$mdbwwansel0 = "selected";
		$cputdpmin = 0;
		$cputdpmax = 25;
		$chassisweightmax=2;
		$chassisthicmax = 19;
		$gputype=1;
		$gputypesel[0]="selected";
		$gputypesel[2]="selected";
		break;
	}
	case "gaming":
	{
		$cputdpmin = 30;
		$cpu_tdpmax = 300;
		$gpupowermin=30;
		$gputype = 1;
		$gputypesel[1]="selected";
		$gputypesel[2]="selected";
		$gputypesel[4]="selected";	
		$display_touch[] = "1"; $display_touch[] ="2";
		$mdbwwan = 0;
		$mdbwwansel1 = "selected";
		$mdbslotsel0 = "selected";
		$chassisthicmin = 10;
		break;
	}
	case "professional":
	{
		$cputdpmin = 15;
		$cputdpmax = 300;
		$gpupowermin=20;
		$display_touch[] = "1"; $display_touch[] ="2";
		$gputype = 1;
		$gputypesel[0] = "selected";
		$gputypesel[3] = "selected";
		$mdbwwan = 0;
		$mdbslotsel0 = "selected";
		$mdbwwansel0 = "selected";
		break;
	}
	case "smalldisplay":
	{
		$displaysizemin=10;
		$displaysizemax=13.95;
		$display_touch[] = "1"; $display_touch[] ="2"; 
		$gputype = 2;
		$mdbwwan = 1;
		$mdbslotsel0 = "selected";
		$mdbwwansel0 = "selected";
		break;
	}
	case "mediumdisplay":
	{
		$displaysizemin=14;
		$displaysizemax=16.95;
		$display_touch[] = "1"; $display_touch[] ="2"; 
		$gputype = 2;
		$mdbwwan = 1;
		$mdbslotsel0 = "selected";
		$mdbwwansel0 = "selected";
		break;
	}
	case "largedisplay":
	{
		$displaysizemin=17;
		$displaysizemax=18.7;
		$display_touch[] = "1"; $display_touch[] ="2";
		$gputype = 2;
		$mdbwwan = 1;
		$mdbslotsel0 = "selected";
		$mdbwwansel0 = "selected";
		break;
	}	
}
?>