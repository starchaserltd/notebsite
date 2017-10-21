<?php
require_once("../etc/con_db.php");
$prod_id = $_GET['prod'];// adaugata de mine 

$sql = "SELECT name FROM notebro_site.nomen WHERE type=70 OR type=71"; 
$result = mysqli_fetch_all(mysqli_query($con,$sql));
$bdgmin=$result[0][0]*0.9;
$bdgmax=$result[1][0]*1.1;
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
		$model_minclass=0; $model_maxclass=1;
		$cputdpmin = 7;
		$cputdpmax = 45;
		$displaysizemin=14;
		$displaysizemax=17.3;
		$displayvresmin = 1080;
		$classiclap_check = "checked";
		$memcapmin=8;
		$mdbwwan = 1;
		$mdbwwansel1 = "selected";
		$chassisweightmin= 1.90;
		$chassisweightmax=3;
		$chassisthicmin=18;
		$chassisthicmax=40;
		$gputype=1; $gputypesel[0]="selected";
		$mdbslotsel0 = "selected";		
		$valuetype[54]=["HDD","SSD","SSHD"]; 
		$totalcapmin = 120; $hddcapmin=$totalcapmin;
		$valuetype[25]= ["Windows 10 Pro","macOS 10.13","Windows 10 Home","Windows 10 Pro","Chrome OS 1","Windows 10 S","Linux Ubuntu 14.4","Linux Ubuntu 16.04"]; 
		break;
	}
	case "ultraportable":
	{
		$model_minclass=0; $model_maxclass=1;
		$cputdpmin = 0;
		$cputdpmax = 25;
		$memcapmin=8;
		$displayvresmin = 1080;
		$mdbslotsel0 = "selected";
		$mdbwwan = 0;
		$mdbwwansel0 = "selected";
		$chassisweightmax=2.1;
		$chassisthicmax = 23;
		$valuetype[54]=["EMMC","SSD"];
		$totalcapmin = 120; $hddcapmin=$totalcapmin;
		$valuetype[25]= ["Windows 10 Pro","macOS 10.13","Windows 10 Home","Windows 10 Pro","Chrome OS 1","Windows 10 S","Linux Ubuntu 14.4","Linux Ubuntu 16.04"]; 
		$gputype=1; $gputypesel[0]="selected"; $gputypesel[2]="selected";
		break;
	}
	case "budget":
	{	
		$model_minclass=0; $model_maxclass=1;
		$cputdpmin = 0;
		$cputdpmax = 15;
		$cputurbomax = 3.0;
		$displayvresmax = 1080;
		$memcapmax=8;
		$mdbwwan = 1;
		$mdbslotsel0 = "selected";
		$chassisweightmax=2.8;
		$chassisthicmin=16;
		$gputype=1; $gputypesel[0]="selected";
		$valuetype[25]= ["Windows 10 Home","Chrome OS 1","Windows 10 S","Linux Ubuntu 14.4","Linux Ubuntu 16.04","No OS","Android 6"]; 
		break;
	}
	
	case "business":
	{	
		$model_minclass=1; $model_maxclass=4;
		$cputdpmin = 4;
		$cputdpmax = 45;
		$displaysizemin=13;
		$displaysizemax=17.3;
		$displayvresmin = 1080;
		$gpupowermax=30;
		$memcapmin=8;
		$mdbwwan = 0;
		$mdbwwansel0 = "selected";
		$chassisweightmax=3;
		$chassisthicmax=40;
		$gputype=1; $gputypesel[0]="selected"; $gputypesel[3]="selected";
		$mdbslotsel0 = "selected";		
		$valuetype[54]=["HDD","SSD","SSHD"]; 
		$totalcapmin = 120; $hddcapmin=$totalcapmin;
		$valuetype[25]= ["Windows 10 Pro","macOS 10.13","Windows 10 Home","Windows 10 S","Linux Ubuntu 14.4","Linux Ubuntu 16.04"]; 
		break;
	}
	case "gaming":
	{
		$model_minclass=0; $model_maxclass=1;
		$cputdpmin = 30;
		$cpu_tdpmax = 300;
		$gpupowermin=59;
		$displaysizemin=13;
		$displaysizemax=17.3;
		$displayvresmin=1080;
		$gputype = 1; $gputypesel[2]="selected";	$gputypesel[4]="selected";	
		$mdbwwan = 1;
		$memcapmin=8;
		$mdbwwansel1 = "selected";
		$mdbslotsel0 = "selected";	
		$chassisthicmin = 10;
		$valuetype[54]=["HDD","SSD","SSHD"]; 
		$totalcapmin = 250; $hddcapmin=$totalcapmin;
		$valuetype[25]= ["Windows 10 Pro","Windows 10 Home","Windows 10 Pro","Windows 10 S"]; 
		break;
	}
	case "professional":
	{
		$model_minclass=1; $model_maxclass=4;
		$cputdpmin = 30;
		$cputdpmax = 300;
		$displaysizemin=13;
		$displaysizemax=17.3;
		$displayvresmin=1080;
		$gpupowermin=30;
		$chassisthicmin = 10;
		$valuetype[54]=["SSD","SSHD"];
		$totalcapmin = 250; $hddcapmin=$totalcapmin;
		$gputype = 1; $gputypesel[3] = "selected";
		$mdbwwan = 0;
		$memcapmin=8;
		$mdbslotsel0 = "selected";
		$mdbwwansel0 = "selected";
		$valuetype[25]= ["Windows 10 Pro","Windows 10 Home"]; 
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
		$displaysizemax=21;
		$display_touch[] = "1"; $display_touch[] ="2";
		$gputype = 2;
		$mdbwwan = 1;
		$mdbslotsel0 = "selected";
		$mdbwwansel0 = "selected";
		break;
	}	
}

$family="";
if ($model_minclass <= 0 && $model_maxclass>=3) 
{
	$family.='<option selected="selected">All business families</option>';
	$family.='<option selected="selected">All consumer families</option>';
}
else if ($model_minclass>=1 && $model_maxclass>=3) {$family.='<option selected="selected">All business families</option>';}
else if ($model_minclass>=0 && $model_maxclass<=1) {$family.='<option selected="selected">All consumer families</option>';}
?>