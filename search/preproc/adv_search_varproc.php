<?php
//some variable initialisation
$cpu_tdpmin = 0.01; $gpu_powermin = 0; $gpu_maxmemmin = 1; //$hdd_capmin = $totalcapmin;
$war_yearsmin = 0.01; $acum_capmin = 0.01; $sist_pricemax = 1; $remove_sd=0; $remove_msd=0; $cpu_ldmin="1900"; $cpu_ldmax="5900"; $gpu_ldmin="1900"; $gpu_ldmax="5900"; $display_hz=30;
$odd_speedmin = 0; $mem_capmin = 1; $mdb_ratemin = 0; $chassis_weightmin = 0.01; $addmsc=array(); $regions_name = array(); $display_srgb = 0; $chassis_addpi=array(); $regions=array(); $war_typewar=array(); $chassis_addpi=array();
$isadvanced = 1; 

$to_search = array(
	"model"   => 1,
    "acum"    => 1,
    "chassis" => 1,
    "cpu"     => 1,
    "display" => 1,
    "gpu"     => 1,
    "hdd"     => 1,
    "mdb"     => 1,
    "mem"     => 1,
    "odd"     => 1,
    "prod"    => 1,
    "shdd"    => 1, 
    "sist"    => 1,
    "war"     => 1,
    "wnet"    => 1,
	"regions" => 1
);

// BUDGET min si max
if(isset($_GET['bdgminadv'])){ $budgetmin = (floatval($_GET['bdgminadv'])/$exch)-1; }
if(isset($_GET['bdgmaxadv'])){ $budgetmax = (floatval($_GET['bdgmaxadv'])/$exch)+1; }
if(isset($_GET['Producer_prod'])) { array_walk($_GET['Producer_prod'],'clean_string'); $prod_model = $_GET['Producer_prod']; }
if(isset($_GET['Family_fam'] ))
{
	foreach ($_GET['Family_fam'] as $element)
	{
		//var_dump($element);

		switch($element)
		{
			case "All business families":
			{
				if($model_minclass>1 && $model_minclass!=-1){ $model_minclass=1; }
				elseif ($model_minclass==-1) { $model_minclass=1; }
				
				if($model_maxclass<3 && $model_maxclass>100){ $model_maxclass=3; }
				elseif ($model_maxclass>100) { $model_maxclass=3; } 
				$model_advclass=1;
				break;
			}
			case "All consumer families":
			{
				if($model_minclass>0 && $model_minclass!=-1){ $model_minclass=0; }
				elseif ($model_minclass==-1) { $model_minclass=0; }
				
				if($model_maxclass<1 && $model_maxclass>100){ $model_maxclass=1; }
				elseif ($model_maxclass>100) { $model_maxclass=1; } 
				$model_advclass=1;
				break;
			}
			default : {	$fam_model[]=$element; }
		}
	}
}

/* *** CPU *** */
if(isset($_GET['CPU_prod_id'])) { array_walk($_GET['CPU_prod_id'],'clean_string');  $cpu_prod = $_GET['CPU_prod_id']; }

//THE CPU MODEL IS SPECIAL SO IT NEEDS SOME TRIMMING AND REBUILDING	
if(isset($_GET['CPU_model_id']))
{	
	array_walk($_GET['CPU_model_id'],'clean_string'); $cpu_model=$_GET['CPU_model_id'];
	$i=0;
	
	foreach ($cpu_model as $x)
	{
		$x=preg_replace("/[ ]\([0-9\.]+\/10\)/", "", $x);
		$newmodel=explode(" ",$x);
		$j=0;
		$cpu_model[$i]="";
		
		foreach($newmodel as $y)
		{
			if($j)
			{ $cpu_model[$i].=$y; }
			$cpu_model[$i].=" ";
			$j=1;
		}
		
		$cpu_model[$i]=substr($cpu_model[$i], 1);
		$cpu_model[$i]=substr($cpu_model[$i], 0, -1);
		$i++;
	}
}

//CPU Socket
if(isset($_GET['CPU_socket_id']))
{ array_walk($_GET['CPU_socket_id'],'clean_string'); $cpu_socket = $_GET['CPU_socket_id']; }

// CPU miscellaneous
if(isset($_GET['CPU_msc_id']))
{ array_walk($_GET['CPU_msc_id'],'clean_string'); $cpu_misc = $_GET['CPU_msc_id']; }
foreach($cpu_misc  as $key=>$el)
{
	if(stripos($el,"threading")!==FALSE){$cpu_misc[$key]="HT/SMT";}
}
// CPU Launch date
if(isset($_GET['launchdatemin']))
{ $cpu_ldmin = $_GET['launchdatemin']; }
$cpu_ldmin=$cpu_ldmin."-01-01";

if(isset($_GET['launchdatemax']))
{ $cpu_ldmax = $_GET['launchdatemax']; }
$cpu_ldmax=$cpu_ldmax."-12-31";

// CPU nr cores
if(isset($_GET['nrcoresmin']))
{ $cpu_coremin = intval($_GET['nrcoresmin']); }
if(isset($_GET['nrcoresmax']))
{ $cpu_coremax = intval($_GET['nrcoresmax']); }

// CPU TDP
if(isset($_GET['cputdpmin']))
{ $cpu_tdpmin = floatval($_GET['cputdpmin']); }
if(isset($_GET['cputdpmax']))
{ $cpu_tdpmax = floatval($_GET['cputdpmax']);	}		

// CPU Frequency
if(isset($_GET['cpufreqmin']))
{ $cpu_turbomin = floatval($_GET['cpufreqmin']); }
if(isset($_GET['cpufreqmax']))
{ $cpu_turbomax = floatval($_GET['cpufreqmax']); }

// CPU Lithography
if(isset($_GET['cputechmin']))
{ $cpu_techmin = floatval($_GET['cputechmax']); }
if(isset($_GET['cputechmax']))
{ $cpu_techmax = floatval($_GET['cputechmin']); }
			

/* *** GPU *** */
 $gpu_typelist=array();
if(isset($_GET['gputype']))
{
	$typegpu=intval($_GET['gputype']);
	if($typegpu==0)
	{ $gpu_typelist[]=0;}

	if($typegpu==2)
	{ $gpu_typelist[]=0; $gpu_typelist[]=1; $gpu_typelist[]=2; $gpu_typelist[]=3; $gpu_typelist[]=4; }
}
else
{
	$typegpu=0; $gpu_typelist[]=0;
}

if($typegpu==1)
{
	if(isset($_GET['gputype2']))
	{
		foreach($_GET['gputype2'] as $x)
		{
			switch(intval($x))
			{
				case 0: { $gpu_typelist[]=0; $gpu_typelist[]=1; break; }
				case 1: { $gpu_typelist[]=1; break; }
				case 2: { $gpu_typelist[]=2; break; }
				case 3: { $gpu_typelist[]=3; break; }
				case 4: { $gpu_typelist[]=4; break; }
				case 10: { $gpu_typelist[]=0; $gpu_ratemin=6; break; }
				default: { $gpu_typelist[]=0; $gpu_typelist[]=1; break; }
			}
		}
	}
	else
	{
		$gpu_typelist[]=1;
	}
}
$gpu_typelist=array_unique($gpu_typelist);

if (isset($_GET['GPU_prod_id']))
{ array_walk($_GET['GPU_prod_id'],'clean_string'); $gpu_prod = $_GET['GPU_prod_id']; }

if (isset($_GET['gpupowermin']))
{ $gpu_powermin = floatval($_GET['gpupowermin']); }
if (isset($_GET['gpupowermax']))
{ $gpu_powermax = floatval($_GET['gpupowermax']); }

if (isset($_GET['GPU_model_id']))
{ array_walk($_GET['GPU_model_id'],'clean_string'); $gpu_model = $_GET['GPU_model_id']; 
	foreach ($gpu_model as $key=>$x)
	{ $gpu_model[$key]=preg_replace("/[ ]\([0-9\.]+\/10\)/", "", $x); }
}

if (isset($_GET['GPU_arch_id']))
{  array_walk($_GET['GPU_arch_id'],'clean_string'); $gpu_arch = $_GET['GPU_arch_id']; }

if (isset($_GET['GPU_msc_id']))
{ 	array_walk($_GET['GPU_msc_id'],'clean_string'); $gpu_misc = $_GET['GPU_msc_id'];
	foreach($gpu_misc as $key=>$el){ if(stripos($el,"mxm")!==FALSE){ $mdb_interface[]="group"; $mdb_interface[]='1 X MXM 3.0'; $mdb_interface[]='2 X MXM 3.0'; $mdb_interface[]='1 X DGFF'; $mdb_interface[]="ungroup"; unset($gpu_misc[$key]);} }
}
 
// GPU Maxmem
if(isset($_GET['gpumemmin']))
{ $gpu_maxmemmin = intval($_GET['gpumemmin']); }

if(isset($_GET['gpumemmax']))
{ $gpu_maxmemmax = intval($_GET['gpumemmax']); }
			
//  GPU Memory band
if(isset($_GET['gpubusmin']))
{ $gpu_mbwmin = intval($_GET['gpubusmin']); }

if(isset($_GET['gpubusmax']))
{ $gpu_mbwmax = intval($_GET['gpubusmax']); }

// GPU Launch date
if(isset($_GET['gpulaunchdatemin']))
{ $gpu_ldmin =intval($_GET['gpulaunchdatemin']); }
$gpu_ldmin=$gpu_ldmin."-01-01";

if(isset($_GET['gpulaunchdatemax']))
{ $gpu_ldmax = intval($_GET['gpulaunchdatemax']); }
$gpu_ldmax=$gpu_ldmax."-12-31";


/* *** DISPLAY *** */
if(isset($_GET['displaymin']))
{ $display_sizemin = floatval($_GET['displaymin']); }
if(isset($_GET['displaymax']))
{ $display_sizemax = floatval($_GET['displaymax']); }

if(isset($_GET['DISPLAY_resol_id']))
{
	array_walk($_GET['DISPLAY_resol_id'],'clean_string'); $display_resolutions = $_GET['DISPLAY_resol_id']; 
	$result_explode = explode('x', $display_resolutions[0]);
	$display_hresmax = $result_explode[0];
	$display_vresmax = $result_explode[1];
}

if(isset($_GET['DISPLAY_msc_id']))
{
	array_walk($_GET['DISPLAY_msc_id'],'clean_string'); $display_backt = $_GET['DISPLAY_msc_id'];
	foreach($display_backt as $key=>$el)
	{
		switch($el)
		{
			case (stripos($el,"G-sync")!==FALSE):
			{
				$mdb_misc[]=$display_backt[$key];
				unset($display_backt[$key]);
				break;
			}
			case (strpos($el,"Hz")!==FALSE):
			{
				$new_display_hz=intval(str_ireplace("Hz","",$el));
				if($display_hz==30){$display_hz=$new_display_hz;}
				elseif($display_hz>$new_display_hz){$display_hz=$new_display_hz;}
				
				unset($display_backt[$key]);
				break;
			}
			case ((stripos($el,"edgeless"))!==FALSE):
			{ $chassis_stuff[]="Edgeless display"; unset($display_backt[$key]); break;}
			
			case ((stripos($el,"stylus"))!==FALSE):
			{ $chassis_stuff[]="Stylus"; unset($display_backt[$key]); break;}
			
			case $el=='80% sRGB or better':
			{
				$display_srgb=80; unset($display_backt[$key]); break;
			}	
			case $el=='HDR':
			{
				$display_hdr=1; unset($display_backt[$key]); break;
			}
			
			case $el=='60% DCI-P3 or better':
			{
				$display_dcip=60; unset($display_backt[$key]); break;
			}
		}
	}
	$display_misc=array_unique($display_misc);
}

// DISPLAY touchscreen
if (isset($_GET['touchscreen']) && $_GET['touchscreen'] == TRUE) 
{ $display_touch[] = "1"; } //with touch

if (isset($_GET['nontouchscreen']) && $_GET['nontouchscreen'] == TRUE) 
{ $display_touch[] = "2"; } //without touch

if(!isset($display_touch))
{ $display_touch[] = "1"; $display_touch[] ="2"; } // 1 with touch; 2 without touchscreen

//DISPLAY ratio
if(isset($_GET['DISPLAY_ratio']))
{ array_walk($_GET['DISPLAY_ratio'],'clean_string'); $display_format=$_GET['DISPLAY_ratio']; }

//DISPLAY surface type
if(isset($_GET['surface']))
{ array_walk($_GET['surface'],'clean_string'); $display_surft=$_GET['surface']; }

if(isset($_GET['verresmin']))
{ $display_vresmin = intval($_GET['verresmin']); }
if(isset($_GET['verresmax']))
{ $display_vresmax = intval($_GET['verresmax']); }

/* *** STORAGE *** */
// STOR capacity
if(isset($_GET['capacitymin']))
{ $hdd_capmin = intval($_GET['capacitymin']); }
if(isset($_GET['capacitymax']))
{ $hdd_capmax = intval($_GET['capacitymax']); }

//STOR type 
if(isset($_GET['typehdd']))
{ array_walk($_GET['typehdd'],'clean_string'); $hdd_type = $_GET['typehdd']; }

// STOR rpm
if(isset($_GET['rpm']))
{ $hdd_rpmmin = intval($_GET['rpm']); }

//STOR nr of hdd		
if(isset($_GET['nrhdd']))
{ $nr_hdd = intval($_GET['nrhdd']);	}

/* *** Motherboard *** */
/*
if (isset($_GET['GPU_msc_id']))
{ if  ($_GET['GPU_msc_id']== "G-Sync/FreeSync") {$addmsc[]="G-Sync/FreeSync";}
else 
}
} */

if (isset($_GET['mdbslots']))
{ $mdb_ramcap = intval($_GET['mdbslots']); }
	
if(isset($_GET['MDB_port_id']))
{ array_walk($_GET['MDB_port_id'],'clean_string'); $chassis_ports = $_GET['MDB_port_id']; } //var_dump($chassis_ports);

$usb2_set=999; 	for($usbv=0;$usbv<3;$usbv++){ ${'usb3'.$usbv.'_set'}=999; ${'usb3c'.$usbv.'_set'}=999; }
foreach($chassis_ports as $key => $x)
{
	if((stripos($x,"RS-232"))!==FALSE)
	{ $addmsc["RS-232"][]="RS-232"; }
	
	if((stripos($x,"ExpressCard"))!==FALSE)
	{ $addmsc["ExpressCard"][]="ExpressCard"; }
	
	if((stripos($x,"SIM card"))!==FALSE)
	{ $addmsc["SIM card"][]="SIM card"; }
	
	if((stripos($x,"SmartCard"))!==FALSE)
	{ $addmsc["SmartCard"][]="SmartCard"; }
	
	if((stripos($x,"MicroSD card reader"))!==FALSE)
	{ 
		$remove_sd=1;
		if($remove_msd){ unset($chassis_ports[$key]); $chassis_addpi["SD card reader"][]="MicroSD card reader"; }
		else
		{
			$chassis_addpi["MicroSD card reader"][]="SD card reader";
		}
	}

	if((strcasecmp($x,"SD card reader"))==0)
	{
		$remove_msd=1;
		if($remove_sd){ unset($chassis_ports[$key]); $chassis_addpi["MicroSD card reader"][]="SD card reader"; }
	}
	
	if(stripos($x,"USB")!==FALSE)
	{
		$piparts=explode(" X ",$x);
		if(stripos($piparts[1],"USB 2")!==FALSE)
		{ 
			if($usb2_set>intval($piparts[0]))
			{ $chassis_ports[$key]=$piparts[0]." X "."USB"; $usb2_set=intval($piparts[0]);  }
			else
			{ unset($chassis_ports[$key]); }
		}
		else
		{
			for($usbv=0;$usbv<3;$usbv++)
			{
				if(stripos($piparts[1],"USB 3.".$usbv)!==FALSE||stripos($piparts[1],"USB-C 3.".$usbv)!==FALSE)
				{
					if(stripos($piparts[1],"USB-C")===FALSE)
					{
						if(${'usb3'.$usbv.'_set'}>intval($piparts[0]))
						{ $chassis_ports[$key]=$piparts[0]." X "."USB 3.".$usbv; ${'usb3'.$usbv.'_set'}=intval($piparts[0]); for($usbv2=$usbv+1;$usbv2<3;$usbv2++){ for ($nrpi=intval($piparts[0]);$nrpi<7;$nrpi++){ $chassis_addpi[$piparts[0]." X "."USB 3.".$usbv][]=$nrpi." X "."USB 3.".$usbv2; } } }
						else
						{ unset($chassis_ports[$key]); }
					}
					else
					{
						if(${'usb3c'.$usbv.'_set'}>intval($piparts[0]))
						{ $chassis_ports[$key]=$piparts[0]." X "."USB-C 3.".$usbv.""; ${'usb3c'.$usbv.'_set'}=intval($piparts[0]); for($usbv2=$usbv+1;$usbv2<3;$usbv2++){ for ($nrpi=intval($piparts[0]);$nrpi<7;$nrpi++){ $chassis_addpi[$piparts[0]." X "."USB-C 3.".$usbv.""][]=$nrpi." X "."USB-C 3.".$usbv2.""; } } }
						else
						{ unset($chassis_ports[$key]); }
					}
				}
			}
		}
	}
	//preg_replace("/([0-9] X )USB 2.[0-9a-z]/","$1 USB", "2 X USB 2.x"))
}

if(isset($_GET['MDB_vport_id']))
{ array_walk($_GET['MDB_vport_id'],'clean_string'); $chassis_vports = $_GET['MDB_vport_id']; }

$hdmi_set=0; $dp_set=0;

$org_chassis_vports=$chassis_vports;
$chassis_vports=array(); $c_key=0;
$chassis_e_ports=array();
foreach($org_chassis_vports as $key => $x)
{
	if(stripos($x,"DP")!==FALSE)
	{ if(!isset($chassis_e_ports["mDP"])){ $chassis_e_ports["DP"]=["mDP","Thunderbolt"]; } }
	if(stripos($x,"HDMI")!==FALSE)
	{ $chassis_e_ports["HDMI"]=["mini HDMI","micro HDMI"]; }
	if(stripos($x,"mini HDMI")!==FALSE)
	{ $chassis_e_ports["mini HDMI"]=["micro HDMI"]; }
	if(stripos($x,"mDP")!==FALSE)
	{ $chassis_e_ports["mDP"]=["Thunderbolt"]; $chassis_e_ports["DP"]=array(); }
}

foreach($org_chassis_vports as $key => $x)
{
	if((stripos($x,"any"))!==FALSE)
	{
		$chassis_vports[$c_key]="group"; $c_key++;
		foreach(["HDMI","DP","VGA"] as $val)
		{	
			$chassis_vports[$c_key]["value"]=$val;
			$chassis_vports[$c_key]["prop"]="diffvisearch";
			$chassis_vports[$c_key]["or"]=true;
			$c_key++;
			if($val=="DP"){ $chassis_vports[$c_key]["value"]="Thunderbolt"; $chassis_vports[$c_key]["alt"]="`CHASSIS`.`pi`"; $c_key++;}
		}
		$chassis_vports[$c_key]="ungroup"; $c_key++;
	}
	elseif(stripos($x," x ")!==FALSE)
	{ 
		$viparts=explode(" X ",$x); $start_count=intval($viparts[0]); $port=$viparts[1];
		
		if($start_count>1||(isset($chassis_e_ports["mDP"])&&isset($chassis_e_ports["DP"])))
		{
			$chassis_vports[$c_key]="group"; $c_key++;
			for($i=$start_count;$i<=6;$i++)
			{
				$chassis_vports[$c_key]["value"]=$i." X ".$port;
				$chassis_vports[$c_key]["or"]=true;
				$c_key++;
			}
			foreach($chassis_e_ports[$port] as $val)
			{
				if(!isset($chassis_e_ports[$val]))
				{
					for($i=$start_count;$i<=6;$i++)
					{
						if(($val=="Thunderbolt")&&($start_count<2)){ $chassis_vports[$c_key]["value"]=$val; $chassis_vports[$c_key]["prop"]="diffvisearch"; $chassis_vports[$c_key]["alt"]="`CHASSIS`.`pi`"; $i=10; }
						else
						{ $chassis_vports[$c_key]["value"]=$i." X ".$val; }
						$chassis_vports[$c_key]["or"]=true;
						$c_key++;
					}
				}
			}
			$chassis_vports[$c_key]="ungroup"; $c_key++;
		}
		else
		{
			$chassis_vports[$c_key]="group"; $c_key++;
			$chassis_vports[$c_key]["value"]=$port;
			$chassis_vports[$c_key]["prop"]="diffvisearch";
			$chassis_vports[$c_key]["or"]=true;
			$c_key++;
			foreach($chassis_e_ports[$port] as $val)
			{
				if(!isset($chassis_e_ports[$val]))
				{
					$chassis_vports[$c_key]["value"]=$val;
					$chassis_vports[$c_key]["prop"]="diffvisearch";
					$chassis_vports[$c_key]["or"]=true;
					if($val=="Thunderbolt"){ $chassis_vports[$c_key]["alt"]="`CHASSIS`.`pi`"; }
					$c_key++;
				}
			}
			$chassis_vports[$c_key]="ungroup"; $c_key++;
		}
	}
}

/* *** WWAN *** */
if (isset($_GET['mdbwwan']))
{ $mdb_wwan = intval($_GET['mdbwwan']); }

/* *** RAM *** */
// RAM capacity
if(isset($_GET['rammin']))
{ $mem_capmin = intval($_GET['rammin']); }
if(isset($_GET['rammax']))
{ $mem_capmax = intval($_GET['rammax']); }
		
// RAM speed
if(isset($_GET['freqmin']))
{ $mem_freqmin = intval($_GET['freqmin']); }
if(isset($_GET['freqmax']))
{ $mem_freqmax = intval($_GET['freqmax']); }

// RAM type
if(isset($_GET['memtype']))
{ array_walk($_GET['memtype'],'clean_string'); $mem_type = $_GET['memtype']; }

/* *** Optical Drive *** */
if(isset($_GET['oddtype'])&&$_GET['oddtype']!="Any/None" && !(stripos($_GET['oddtype'],"Any")!==FALSE&&$_GET['oddtype']!="Any optical drive"))
{ $odd_type = clean_string($_GET['oddtype']); }

/* *** ACUM *** */
if(isset($_GET['acumcapmin']))
{ $acum_capmin = floatval($_GET['acumcapmin']); }
if(isset($_GET['acumcapmax']))
{ $acum_capmax = floatval($_GET['acumcapmax']); }

// Battery life
if(isset($_GET['batlifemin']))
{ $batlife_min = floatval($_GET['batlifemin']); }
if(isset($_GET['batlifemax']))
{ $batlife_max = floatval($_GET['batlifemax']); }

/* *** CHASSIS *** */
// made of
if(isset($_GET['material']))
{ array_walk($_GET['material'],'clean_string'); $chassis_made = $_GET['material']; }

//weight
if(isset($_GET['weightmin']))
{ $chassis_weightmin = floatval($_GET['weightmin']); }
if(isset($_GET['weightmax']))
{ $chassis_weightmax = floatval($_GET['weightmax']); }

//thickness
if(isset($_GET['thicmin']))
{ $chassis_thicmin = floatval($_GET['thicmin']); }
if(isset($_GET['thicmax']))
{ $chassis_thicmax = floatval($_GET['thicmax']); }		

//depth
if(isset($_GET['depthmin']))
{ $chassis_depthmin = floatval($_GET['depthmin']); }
if(isset($_GET['depthmax']))
{ $chassis_depthmax = floatval($_GET['depthmax']); }		
		
//width
if(isset($_GET['widthmin']))
{ $chassis_widthmin = floatval($_GET['widthmin']); }
if(isset($_GET['widthmax']))
{ $chassis_widthmax = floatval($_GET['widthmax']); }

//webcam
if(isset($_GET['webmin']))
{ $chassis_webmin = floatval($_GET['webmin']); }
if(isset($_GET['webmax']))
{ $chassis_webmax = floatval($_GET['webmax']); }
//****************************************************************************************************************************
//normal/2 in 1

if (isset($_GET['twoinone-no']) && $_GET['twoinone-no'] == TRUE) 
{ $chassis_twoinone[] = "0"; } //classic laptop
if (isset($_GET['twoinone-yes']) && $_GET['twoinone-yes'] == TRUE) 
{ $chassis_twoinone[] = "1"; } //convertible

//if(!isset($chassis_twoinone))
if (!isset($_GET['twoinone-no']) && !isset($_GET['twoinone-yes'])) 
{ $chassis_twoinone[] = "0"; $chassis_twoinone[] ="1"; } // 0 classic; 1 convertible

//All sort of extra Chassis stuff
if(isset($_GET['CHASSIS_stuff_id']))
{ array_walk($_GET['CHASSIS_stuff_id'],'clean_string'); $chassis_stuff = $_GET['CHASSIS_stuff_id']; }
$chassis_speakers=array(); $chassis_subwoofer=array();
foreach($chassis_stuff as $key => $x)
{
	if(((stripos($x,"speakers"))!==FALSE)&&!((stripos($x,"premium"))!==FALSE))
	{ unset($chassis_stuff[$key]); $chassis_speakers[]=$x; }
	
	if((stripos($x,"subwoofer"))!==FALSE)
	{ unset($chassis_stuff[$key]); $chassis_subwoofer[]=$x; }
	
	if((stripos($x,"keyboard"))!==FALSE)
	{ $chassis_stuff[$key]=str_ireplace(" keyboard","",$x); }

	if((stripos($x,"spill resistant"))!==FALSE)
	{
		unset($chassis_stuff[$key]);
		$chassis_stuff[]="group";
		$chassis_stuff[]="spill resistant";
		$chassis_stuff[]="sealed";
		$chassis_stuff[]="ungroup";
	}

	if((stripos($x,"legacy ports"))!==FALSE)
	{ $chassis_stuff[$key]=str_ireplace(" ports","",$x); }
	
	if((stripos($x,"premium speakers"))!==FALSE)
	{
		unset($chassis_stuff[$key]);
		$chassis_stuff[]="group";
		$chassis_stuff[]="olufsen";
		$chassis_stuff[]="altec";
		$chassis_stuff[]="harman";
		$chassis_stuff[]="jbl";
		$chassis_stuff[]="klipsch";
		$chassis_stuff[]="sonicmaster";
		$chassis_stuff[]="dynaudio";
		$chassis_stuff[]="akg";
		$chassis_stuff[]="onkyo";
		$chassis_stuff[]="omnisonic";
		$chassis_stuff[]="ungroup";
	}
	
	if(((stripos($x,"USB-C"))!==FALSE)&&((stripos($x,"charger"))!==FALSE))
	{ unset($chassis_stuff[$key]); $chassis_charger="USB-C"; }
}

$addgroup=1;
foreach($chassis_speakers as $x)
{
	if($addgroup==1){ $chassis_stuff[]="group"; $addgroup=2; }
	if((stripos($x,"2 x speakers"))!==FALSE)
	{ $chassis_stuff[]=$x; $chassis_stuff[]="2x__W speaker"; $chassis_stuff[]="2x___W speaker"; $x="2x_W speaker"; }
		
	if((stripos($x,"4 x speakers"))!==FALSE)
	{ $chassis_stuff[]=$x; $chassis_stuff[]="4x__W speaker"; $chassis_stuff[]="4x___W speaker"; $x="4x_W speaker"; }
	
	if((stripos($x,"1 x speaker"))!==FALSE)
	{ $chassis_stuff[]=$x; $chassis_stuff[]="1x__W speaker"; $chassis_stuff[]="1x___W speaker"; $x="1x_W speaker"; }
	$chassis_stuff[]=$x;
}
if($addgroup==2) { $chassis_stuff[]="ungroup"; $addgroup=1; }

$addgroup=1;
foreach($chassis_subwoofer as $x)
{	
	if($addgroup==1){ $chassis_stuff[]="group"; $addgroup=2; }
	if((stripos($x,"1 x subwoofer"))!==FALSE)
	{ $chassis_stuff[]=$x; $chassis_stuff[]="1x__W subwoofer"; $chassis_stuff[]="1x___W subwoofer"; $x="1x_W subwoofer"; }
	
	if((stripos($x,"2 x subwoofer"))!==FALSE)
	{ $chassis_stuff[]=$x; $chassis_stuff[]="2x__W subwoofer"; $chassis_stuff[]="2x___W subwoofer"; $x="2x_W subwoofer"; }

	$chassis_stuff[]=$x;
}
if($addgroup==2) { $chassis_stuff[]="ungroup"; $addgroup=1; }

$addmsc=array_unique($addmsc);
foreach($addmsc as $key=>$addtomsc)
{ $chassis_extra_stuff[$key]=$addtomsc; }

/* *** WNET *** */
//speed
if(isset($_GET['wnetspeed']))
{ $wnet_speedmin = intval($_GET['wnetspeed']); }
$wnet_speedmax = 9999999;

//bluetooth
if (isset($_GET['bluetooth']) && $_GET['bluetooth'] == TRUE)
{$wnet_bluetooth = "1"; /*$msc_model="bluetooth";*/ } else {$wnet_bluetooth = "2";}

//Operating System
if(isset($_GET['opsist']))
{
	array_walk($_GET['opsist'],'clean_string'); $sist_list=$_GET['opsist']; 
	foreach($sist_list as $key => $x)
	{
		if((stristr($x,"No OS")!=FALSE))
		{ $sist_sist[]=$x; }
		else
		{
			$sist_parts=explode(" ",$x);
			if(is_numeric(end($sist_parts)))
			{
				$sist_vers[]=end($sist_parts);
				array_pop($sist_parts);
				$sist_sist[]=implode(" ",$sist_parts);
			}
			else
			{
				if(is_numeric(prev($sist_parts)))
				{
					$sist_type=end($sist_parts);
					$sist_vers[]=prev($sist_parts);
					array_splice($sist_parts,-2,2);
					$sist_sist[]=implode(" ",$sist_parts)."+".$sist_type;
				}
				else
				{
					$sist_sist[]=$x;
				}
			}
		}
	}
}
/* *** REGIONS *** */

if(isset($_GET['Regions']) && $_GET['Regions']) { array_walk($_GET['Regions'],'clean_string'); $regions_name = $_GET['Regions']; foreach($regions_name as $region){if(strcmp("All",$region)==0){$to_search["regions"]=0;}}} else {$to_search["regions"]=0;} 

/** OVERRIDE BUY BUTTON REGIONS FROM THE EXCHANGE RATE WITH THOSE OF THE REGION **/
if($to_search["regions"])
{ 
	$regional_search_regions_array=array();
	$regional_exch_ids=array();
	$default_value=null;
	foreach($regions_name as $el)
	{
		foreach ($exchange_list->{"code"} as $ex_key => $ex_el)
		{
			if(in_array($el,explode(",",$ex_el["dregion"])))
			{ 
				if(!isset($default_value)||$default_value==null)
				{ $default_value=$ex_el; $default_value["code"]=$ex_key; }
				
				foreach(explode(",",$ex_el["region"]) as $f_el)
				{
					array_push($regional_search_regions_array,$f_el);
				}
			}
		}
	}
	if(isset($regional_search_regions_array[0]))
	{ $regional_search_regions_array=array_unique($regional_search_regions_array); $search_regions_results=implode(",",$regional_search_regions_array); }
	
	
	$value=$exchange_list->{"code"}->{$exchcode};
	$el_regions=explode(",",$value["region"]);
	foreach($regional_search_regions_array as $el2)
	{
		if($el2!=0&&$el2!=1)
		{
			if(in_array($el2,$el_regions))
			{ array_push($regional_exch_ids,$value["id"]); }
		}
	}
	
	if(!in_array($exch_id,$regional_exch_ids)&&$default_value!=null)
	{
		$_SESSION['regional_type']="region";
		$_SESSION['exchcode']=$default_value["code"];
		$_SESSION['exch']=$default_value["convr"];
		$_SESSION['exchsign']=$default_value["sign"];
		$_SESSION['lang']=$default_value["id"];
	}
}


/* *** WARRANTY *** */
if(isset($_GET['yearsmin']) && ($_GET['yearsmin'])!="" && ($_GET['yearsmin'])!=NULL) 
{ $war_yearsmin = intval($_GET['yearsmin']); }
if(isset($_GET['yearsmax']) && ($_GET['yearsmax'])) 
{ $war_yearsmax = intval($_GET['yearsmax']); }
$war_typewar=[1=>"1",2=>"2",3=>"3",4=>"4"];

if(isset($regions_name[0])&&stripos($regions_name[0],"Euro")!==FALSE&&!isset($regions_name[1]))
{$war_yearsmin=2;}

if (isset($_GET['premiumadv']))
{ $war_typewar=[2=>"2",4=>"4"];}

if($hdd_capmin)
{
	$totalcapmin=$hdd_capmin;
	if($nr_hdd<3)
	{ $hdd_capmin=0; }
	else
	{ $nr_hdd=1; }
}
else
{ $totalcapmin=0; }
?>