<?php
require_once("../etc/con_db.php");
if(isset($_GET['prod'])){ $prod_id = $_GET['prod']; }
$sql = "SELECT name FROM notebro_site.nomen WHERE type=70 OR type=71 OR type=25"; 
$result = mysqli_fetch_all(mysqli_query($con,$sql));
$i=0;
while(isset($result[$i][0]))
{
	$valuetype[25][]=$result[$i][0];
	$i++;
}
$bdgmin=$result[$i-2][0]*0.9;
$bdgmax=$result[$i-1][0]*1.1;
$browse_by = $_GET['browse_by']; $producer=""; $regions='<option selected="selected">All</option>';
$model_minclass=0; $model_maxclass=99; $totalcapmax=2048; $memcapmax=32;
switch ($browse_by) 
{
	case "prod":
	{
		if($_GET['prod']){	$producer.='<option selected="selected">'.$_GET['prod'].'</option>'; }
		$valuetype[25]=array_diff($valuetype[25],["No OS"]);
		$prod_model = $_GET['prod'];
		$mdbslotsel0 = 'selected="selected"';
		$nrhdd = 1;
		$gputype = 2;
		$mdbwwan = 0;
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
		$chassisweightmin= 1.90;
		$chassisweightmax=3;
		$chassisthicmin=18;
		$chassisthicmax=40;
		$gputype=1; $gputypesel[0]='selected="selected"';
		$mdbslotsel0 = 'selected="selected"';	
		$valuetype[54]=["HDD","SSD","SSHD"]; 
		$totalcapmin = 120; $hddcapmin=$totalcapmin;
		$valuetype[25]=array_diff($valuetype[25],["No OS","Android 6"]);
		break;
	}
	case "ultraportable":
	{
		$model_minclass=0; $model_maxclass=1;
		$cputdpmin = 0;
		$cputdpmax = 25;
		$memcapmin=8;
		$displayvresmin = 1080;
		$mdbslotsel0 = 'selected="selected"';
		$mdbwwan = 0;
		$chassisweightmax=2.1;
		$chassisthicmax = 23;
		$valuetype[54]=["EMMC","SSD"];
		$totalcapmin = 120; $hddcapmin=$totalcapmin;
		$valuetype[25]=array_diff($valuetype[25],["No OS","Android 6"]);
		$gputype=1; $gputypesel[0]='selected="selected"'; $gputypesel[2]='selected="selected"';
		break;
	}
	case "budget":
	{	
		$model_minclass=0; $model_maxclass=1;
		$cputdpmin = 0;
		$cputdpmax = 15;
		$cpufreqmax = 3.0;
		$displayvresmax = 1080;
		$memcapmax=8;
		$mdbwwan = 1;
		$mdbslotsel0 ='selected="selected"';
		$chassisweightmax=2.8;
		$chassisthicmin=16;
		$gputype=1; $gputypesel[0]='selected="selected"';
		$valuetype[25]=array_diff($valuetype[25],["No OS","Windows 10 Pro","macOS 10.13"]);
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
		$chassisweightmax=3;
		$chassisthicmax=40;
		$gputype=1; $gputypesel[0]='selected="selected"'; $gputypesel[3]='selected="selected"';
		$mdbslotsel0 = 'selected="selected"';	
		$valuetype[54]=["HDD","SSD","SSHD"]; 
		$totalcapmin = 120; $hddcapmin=$totalcapmin;
		$valuetype[25]=array_diff($valuetype[25],["Chrome OS 1","Android 6","No OS"]);
		break;
	}
	case "gaming":
	{
		$model_minclass=0; $model_maxclass=1;
		$cputdpmin = 15;
		$cputdpmax = 300;
		$gpupowermin=59;
		$displaysizemin=13;
		$displaysizemax=17.3;
		$displayvresmin=1080;
		$gputype = 1; $gputypesel[2]='selected="selected"';	$gputypesel[4]='selected="selected"';
		$mdbwwan = 1;
		$memcapmin=8;
		$mdbslotsel0 = 'selected="selected"';
		$chassisthicmin = 10;
		$valuetype[54]=["HDD","SSD","SSHD"]; 
		$totalcapmin = 250; $hddcapmin=$totalcapmin;
		$valuetype[25]= ["Windows 10 Pro","Windows 10 Home","Windows 10 S"]; 
		break;
	}
	case "professional":
	{
		$model_minclass=1; $model_maxclass=4;
		$cputdpmin = 15;
		$cputdpmax = 300;
		$displaysizemin=13;
		$displaysizemax=17.3;
		$displayvresmin=1080;
		$gpupowermin=30;
		$chassisthicmin = 10;
		$valuetype[54]=["SSD","SSHD"];
		$totalcapmin = 250; $hddcapmin=$totalcapmin;
		$gputype = 1; $gputypesel[3] = 'selected="selected"';
		$mdbwwan = 0;
		$memcapmin=8;
		$mdbslotsel0 = 'selected="selected"';
		$valuetype[25]= ["Windows 10 Pro","Windows 10 Home"]; 
		break;
	}
	case "smalldisplay":
	{
		$model_minclass=-1; $model_maxclass=-1;
		$displaysizemin=10;
		$displaysizemax=13.9;
		$display_touch[] = "1"; $display_touch[] ="2"; 
		$gputype = 2;
		$mdbwwan = 0;
		$mdbslotsel0 = 'selected="selected"';
		$valuetype[25]=array_diff($valuetype[25],["No OS"]);
		break;
	}
	case "mediumdisplay":
	{
		$model_minclass=-1; $model_maxclass=-1;
		$displaysizemin=14;
		$displaysizemax=16.4;
		$display_touch[] = "1"; $display_touch[] ="2"; 
		$gputype = 2;
		$mdbwwan = 0;
		$mdbslotsel0 = 'selected="selected"';
		$valuetype[25]=array_diff($valuetype[25],["No OS"]);
		break;
	}
	case "largedisplay":
	{
		$model_minclass=-1; $model_maxclass=-1;
		$displaysizemin=17;
		$displaysizemax=21;
		$display_touch[] = "1"; $display_touch[] ="2";
		$gputype = 2;
		$mdbwwan = 0;
		$mdbslotsel0 = 'selected="selected"';
		$valuetype[25]=array_diff($valuetype[25],["No OS"]);
		break;
	}	
}

$mdbwwansel0 = '';	
if ($mdbwwan ==1) {	$mdbwwansel1 = 'selected="selected"'; }
else if ($mdbwwan == 2) {	$mdbwwansel2 = 'selected="selected"'; }
else {	$mdbwwansel0 = 'selected="selected"'; }

$family="";
if ($model_minclass <= 0 && $model_maxclass>=3) 
{ }
elseif ($model_minclass>=1 && $model_maxclass>=3) {$family.='<option selected="selected">All business families</option>';}
elseif ($model_minclass>=0 && $model_maxclass<=1) {$family.='<option selected="selected">All consumer families</option>';}
?>