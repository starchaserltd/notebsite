<?php
	$valuetype[11]=array();
	$hdd_type = array(); $displayhresmin = "1";	$displayhresmax = "99999"; 	$displayvresmin = "1"; 	$displayvresmax = "99999"; 	$mdbslotsel0 = 'selected="selected"';
	$sel="SELECT name,type FROM notebro_site.nomen WHERE type=25"; $result = mysqli_query($con, $sel); $lvaluetype[25]=array(); $valuetype[51]=[150];
	while($rand = mysqli_fetch_assoc($result)) { $valuetype[intval($rand["type"])][]=$rand["name"]; } mysqli_free_result($result);
	
	if(isset($_GET['s_prod']))
	{	foreach ($_GET['s_prod'] as $element)
		{	$producer.='<option selected="selected">'.$element.'</option>'; }
	}
	
	/***************************   LAPTOP TYPE********************************/
	switch ($_GET['type']) 
	{
        case "1": //normal
			$model_minclass=0;$model_maxclass =1;
			$cputdpmin = 7; 
			$cputdpmax = 45; 
			$chassisweightmin= 1.9;
			$chassisweightmax=3;
			$chassisthicmin=18;
			$chassisthicmax=40;
			$hdd_type=["HDD","SSD","SSHD"];
			$gputype=1;
			$mdbwwan = 1;
			$gputypesel[0]='selected="selected"';
			$valuetype[25]=array_diff($valuetype[25],["No OS","Android 8"]);
			break;
		case "2":		//ultraportable
			$model_minclass=0; $model_maxclass=1;
			$cputdpmin = 0;
			$cputdpmax = 25;
			$mdbwwan = 0;
			$chassisweightmax=2.1;
			$chassisthicmax = 23;
			$valuetype[54]=["EMMC","SSD"];
			$valuetype[25]=array_diff($valuetype[25],["No OS","Android 8"]);
			$gputype=1; $gputypesel[0]='selected="selected"'; $gputypesel[2]='selected="selected"';
			break;
		case "3":		//business
			$model_minclass=1; $model_maxclass=4;
			$cputdpmin = 4;
			$cputdpmax = 45;
			$gpupowermax=30;
			$mdbwwan = 0;
			$chassisweightmax=3;
			$chassisthicmax=40;
			$gputype=1; $gputypesel[0]='selected="selected"'; $gputypesel[3]='selected="selected"';	
			$valuetype[54]=["HDD","SSD","SSHD"]; 
			$valuetype[25]=array_diff($valuetype[25],["Chrome OS 1","Android 8","No OS"]);
			break;
		case "4":		// gaming
			$model_minclass=0; $model_maxclass=1;
			$cputdpmin = 15;
			$cputdpmax = 300;
			$mdbwwan = 1;
			$chassisthicmin = 10;
			$valuetype[54]=["HDD","SSD","SSHD"]; 
			$valuetype[25]= ["Windows 10 Pro","Windows 10 Home","Windows 10 S"]; 
			break;
		case "5":		// cad/3d design
			$model_minclass=1; $model_maxclass=4;
			$cputdpmin = 15;
			$cputdpmax = 300;
			$gpupowermin=30;
			$chassisthicmin = 10;
			$valuetype[54]=["SSD","SSHD"];
			$gputype = 1; $gputypesel[3] = 'selected="selected"';
			$mdbwwan = 0;
			$valuetype[25]= ["Windows 10 Pro","Windows 10 Home"]; 	 
			break;
			
		case "99":// All
			$model_minclass=-1; $model_maxclass=-1;
			$valuetype[25]=array_diff($valuetype[25],["No OS"]);
			$mdbwwan = 0;
			break;
	}
	
/***************************   CPU ********************************/
if(isset($_GET['cpu_type']))
{
	$producer=""; $cpumsc="";
	foreach($_GET['cpu_type'] as $el)
	{
		switch($el)
		{
			case "1":
			{
				array_push($valuetype[11],"INTEL");
				break;
			}
			case "2":
			{
				array_push($valuetype[11],"INTEL");
				$cpumsc.='<option selected="selected">Intel Core i3</option>';
				break;
			}
			case "3":
			{
				array_push($valuetype[11],"INTEL");
				$cpumsc.='<option selected="selected">Intel Core i5</option>';
				break;
			}
			case "4":
			{
				array_push($valuetype[11],"INTEL");
				$cpumsc.='<option selected="selected">Intel Core i7/i9</option>';
				$cpumsc.='<option selected="selected">Intel Xeon</option>';
				break;
			}
			case "5":
			{
				array_push($valuetype[11],"AMD");
				break;
			}
			case "6":
			{
				array_push($valuetype[11],"AMD");
				$cpumsc.='<option selected="selected">AMD Ryzen</option>';
				break;
			}
			case "7":
			{
				$cpumsc.='<option selected="selected">Multithreading</option>';
				break;
			}
			case "8":
			{
				$cpucoremin=4;
				break;
			}
			case "9":
			{
				if($cpucoremin<4){$cpucoremin=6;}
				break;
			}
			case "10":
			{
				if($cpucoremin<4){$cpucoremin=8;}
				break;
			}
		}
	}
	$valuetype[11]= array_unique($valuetype[11]);
}


if(isset($_GET['s_memmin'])) { $memcapmin=intval($_GET['s_memmin']); }
if(isset($_GET['s_memmax'])) { $memcapmax=intval($_GET['s_memmax']); }

if(isset($_GET['ssd'])) { $valuetype[54]=["SSD"]; }
if(isset($_GET['s_hddmin'])) { $hddcapmin=intval($_GET['s_hddmin']); }
if(isset($_GET['s_hddmax'])) { $hddcapmax=intval($_GET['s_hddmax']); }

if(isset($_GET['s_dispsizemin'])) { $displaysizemin=floatval($_GET['s_dispsizemin']); }
if(isset($_GET['s_dispsizemax'])) { $displaysizemax=floatval($_GET['s_dispsizemax']); }

if(isset($_GET['display_type']))
{
	$display_backt=array(); $displaymsc=""; $chassisstuff="";
	foreach($_GET['display_type'] as $el)
	{
		switch($el)
		{
			case "1":
			{
				$displaymsc.='<option selected="selected">LED IPS</option>';
				$displaymsc.='<option selected="selected">OLED</option>';
				$displaymsc.='<option selected="selected">mLED</option>';
				$displaymsc.='<option selected="selected">LED IPS PenTile</option>';
				break;
			}
			case "2":
			{
				$displaymsc.='<option selected="selected">LED TN WVA</option>';
				$displaymsc.='<option selected="selected">120Hz</option>';
				$displaymsc.='<option selected="selected">144Hz</option>';
				$displaymsc.='<option selected="selected">240Hz</option>';
				break;
			}
			case "3":
			{
				$displayvresmin=1080;
				break;
			}
			case "4":
			{
				if($displayvresmin!=1080) { $displayvresmin=1280; }
				break;
			}
			case "5":
			{
				if($displayvresmin!=1080 && $displayvresmin!=1280 ) { $displayvresmin=1920; }
				break;
			}
			case "6":
			{
				$displaymsc.='<option selected="selected">80% sRGB or better</option>';
				break;
			}
			case "7":
			{
				$ntcheck = "checked";
				break;
			}
			case "8":
			{
				$tcheck = "checked";
				break;
			}
			case "9":
			{
				$chassisstuff.='<option selected="selected">Stylus</option>';
				break;
			}
		}
	}
}

/***************************  GRAPHIC NEED********************************/
if(isset($_GET['graphics']))
{	$gpumodel="";
	foreach($_GET['graphics'] as $el)
	{
		switch ($el)
		{
			case "1":	//essential
			{
				if (($_GET['type'])==4) //GAMING
				{
					$gpupowermin = 20;
					$gpumemmin = 1024;
					$gputype=1;
					$gputypesel[1]='selected="selected"';
				}
				else if (($_GET['type'])==5) //PROFESIONAL
				{
					$gpupowermin = 25;
					$gpumemmin = 1024;
					$result=mysqli_query($con, "SELECT model FROM notebro_db.GPU WHERE rating<=30 AND typegpu=3 AND power>=25");
					while($row=mysqli_fetch_row($result)) { $gpumodel.='<option selected="selected">'.$row[0].'</option>'; } mysqli_free_result($result);
					$gputype=1;
					$gputypesel[3]='selected="selected"';
				}
				else //ALL
				{
					$gpupowermax = 50;
					$gputype=1;
					$gputypesel[3]='selected="selected"';
					$gputypesel[0]='selected="selected"';
				}
				break;
			}
		
			case "2":		//AVERAGE
			{
				if (($_GET['type'])==4) //GAMING
				{
					$gpumemmin = 2048;
					$gputype=1;
					$gputypesel[2]='selected="selected"';
				}
				else if (($_GET['type'])==5) //PROFESIONAL
				{
					$gpumemmin = 2048;
					$result=mysqli_query($con, "SELECT model FROM notebro_db.GPU WHERE rating<=50 AND rating>=25 AND typegpu=3 AND power>=25");
					while($row=mysqli_fetch_row($result)) { $gpumodel.='<option selected="selected">'.$row[0].'</option>'; } mysqli_free_result($result);
					$gputype=1;
					$gputypesel[3]='selected="selected"';
				}
				else //ALL
				{
					$gpupowermin = 55;
					$gpupowermax = 80;
					$gputype=1;
					$gputypesel[3]='selected="selected"';
					$gputypesel[2]='selected="selected"';
				}
				break;
			}
			
			case "3":		//HIGH PERFORMANCE
			{
				if (($_GET['type'])==4) //GAMING
				{
					$gputype=1;
					$gputypesel[4]='selected="selected"';
				}
				else if (($_GET['type'])==5) //PROFESIONAL
				{
					$gpumemmin = 2048;
					$result=mysqli_query($con, "SELECT model FROM notebro_db.GPU WHERE rating>=50 AND typegpu=3 AND power>=25");
					while($row=mysqli_fetch_row($result)) { $gpumodel.='<option selected="selected">'.$row[0].'</option>'; } mysqli_free_result($result);
					$gputype=1;
					$gputypesel[3]='selected="selected"';
				}
				else //ALL
				{
					$gpupowermin = 69;
					$gputype=1;
					$gputypesel[3]='selected="selected"';
					$gputypesel[4]='selected="selected"';
				}
				break;
			}
		}
	}
}

$mdbwwansel0 = '';	
if ($mdbwwan ==1) {	$mdbwwansel1 = 'selected="selected"'; }
else if ($mdbwwan == 2) {	$mdbwwansel2 = 'selected="selected"'; }
else {	$mdbwwansel0 = 'selected="selected"'; }

//regional search
if(isset($_GET['region_type']))
{
	$regions=""; $waryearsset=true;
	foreach($_GET['region_type'] as $el)
	{
		if($el==1){ $regions.='<option selected="selected">United States</option>'; $waryearsmin=1; }
		elseif ($el==2){ $regions.='<option selected="selected">Europe</option>'; $waryearsmin=2; }
	}
}

if(isset($_GET['exchange'])&&is_string($_GET['exchange']))
{
	$excode=clean_string($_GET['exchange']);
	$sel2 = "SELECT convr FROM notebro_site.exchrate WHERE code='".$excode."'";
	$result = mysqli_query($con,$sel2);
	$value=mysqli_fetch_array($result);
	$exch=floatval($value[0]);
}

if(isset($_GET['bdgmin'])){ $bdgmin = floatval($_GET['bdgmin'])/$exch; }else{$bdgmin=-10;}
if(isset($_GET['bdgmax'])){ $bdgmax = floatval($_GET['bdgmax'])/$exch; }else{$bdgmax=-10;}
	
if($hddcapmin)
{
	$totalcapmin=$hddcapmin;
	$hddcapmin=0;
}
else
{ $totalcapmin=0; }

$totalcapmax=$hddcapmax;
	
$family="";
if ($model_minclass <= 0 && $model_maxclass>=3) 
{
	$family='';
}
elseif ($model_minclass>=1 && $model_maxclass>=3) {$family.='<option selected="selected">All business families</option>';}
elseif ($model_minclass>=0 && $model_maxclass<=1) {$family.='<option selected="selected">All consumer families</option>';}
?>