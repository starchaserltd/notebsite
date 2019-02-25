<?php
//some variable initialisation
$cpu_tdpmin = 0.01; $gpu_powermin = 0; $gpu_maxmemmin = 1; //$hdd_capmin = $totalcapmin;
$war_yearsmin = 0.01; $acum_capmin = 0.01; $sist_pricemax = 1; $remove_sd=0; $remove_msd=0;
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

// CPU Launch date
if($_GET['launchdatemin'])
{ $cpu_ldmin = $_GET['launchdatemin']; }
$cpu_ldmin=$cpu_ldmin."-01-01";

if($_GET['launchdatemax'])
{ $cpu_ldmax = $_GET['launchdatemax']; }
$cpu_ldmax=$cpu_ldmax."-12-31";

// CPU nr cores
if($_GET['nrcoresmin'])
{ $cpu_coremin = intval($_GET['nrcoresmin']); }
if($_GET['nrcoresmax'])
{ $cpu_coremax = intval($_GET['nrcoresmax']); }

// CPU TDP
if($_GET['cputdpmin'])
{ $cpu_tdpmin = floatval($_GET['cputdpmin']); }
if($_GET['cputdpmax'])
{ $cpu_tdpmax = floatval($_GET['cputdpmax']);	}		

// CPU Frequency
if($_GET['cpufreqmin'])
{ $cpu_turbomin = floatval($_GET['cpufreqmin']); }
if($_GET['cpufreqmax'])
{ $cpu_turbomax = floatval($_GET['cpufreqmax']); }

// CPU Lithography
if($_GET['cputechmin'])
{ $cpu_techmin = floatval($_GET['cputechmax']); }
if($_GET['cputechmax'])
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
	$gpu_typelist[]=0;
}

if($typegpu==1)
{
	if(isset($_GET['gputype2']))
	{
		foreach($_GET['gputype2'] as $x)
		{
			$x=intval($x);
			if($x==0) { $gpu_typelist[]=0; $gpu_typelist[]=1; }
			if($x==1) { $gpu_typelist[]=1; }
			if($x==2) { $gpu_typelist[]=2; }
			if($x==3) { $gpu_typelist[]=3; }
			if($x==4) { $gpu_typelist[]=4; }
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

if ($_GET['gpupowermin'])
{ $gpu_powermin = floatval($_GET['gpupowermin']); }
if ($_GET['gpupowermax'])
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
if($_GET['gpumemmin'])
{ $gpu_maxmemmin = intval($_GET['gpumemmin']); }

if($_GET['gpumemmax'])
{ $gpu_maxmemmax = intval($_GET['gpumemmax']); }
			
//  GPU Memory band
if($_GET['gpubusmin'])
{ $gpu_mbwmin = intval($_GET['gpubusmin']); }

if($_GET['gpubusmax'])
{ $gpu_mbwmax = intval($_GET['gpubusmax']); }

// GPU Launch date
if($_GET['gpulaunchdatemin'])
{ $gpu_ldmin =intval($_GET['gpulaunchdatemin']); }
$gpu_ldmin=$gpu_ldmin."-01-01";

if($_GET['gpulaunchdatemax'])
{ $gpu_ldmax = intval($_GET['gpulaunchdatemax']); }
$gpu_ldmax=$gpu_ldmax."-12-31";


/* *** DISPLAY *** */
if($_GET['displaymin'])
{ $display_sizemin = floatval($_GET['displaymin']); }
if($_GET['displaymax'])
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
			case (stripos($el,"144Hz")!==FALSE):
			{
				if(!isset($display_misc["Hz"])){ $display_misc["Hz"]=array(); }
				$display_misc["Hz"][]="144Hz";
				unset($display_backt[$key]);
				break;
			}
			case (stripos($el,"120Hz")!==FALSE):
			{
				if(!isset($display_misc["Hz"])){ $display_misc["Hz"]=array(); }
				$display_misc["Hz"][]="144Hz";
				$display_misc["Hz"][]="120Hz";
				unset($display_backt[$key]);
				break;
			}
			case (stripos($el,"75Hz")!==FALSE):
			{
				if(!isset($display_misc["Hz"])){ $display_misc["Hz"]=array(); }
				$display_misc["Hz"][]="144Hz";
				$display_misc["Hz"][]="120Hz";
				$display_misc["Hz"][]="75Hz";
				unset($display_backt[$key]);
				break;
			}
			case $el=='80% sRGB or better' :
			{
				$display_srgb=80; unset($display_backt[$key]); break;
			}
		}
	}
	if(isset($display_misc["Hz"])) { $display_misc["Hz"]=array_unique($display_misc["Hz"]); }
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

if($_GET['verresmin'])
{ $display_vresmin = intval($_GET['verresmin']); }
if($_GET['verresmax'])
{ $display_vresmax = intval($_GET['verresmax']); }

/* *** STORAGE *** */
// STOR capacity
if($_GET['capacitymin'])
{ $hdd_capmin = intval($_GET['capacitymin']); }
if($_GET['capacitymax'])
{ $hdd_capmax = intval($_GET['capacitymax']); }

//STOR type 
if(isset($_GET['typehdd']))
{ array_walk($_GET['typehdd'],'clean_string'); $hdd_type = $_GET['typehdd']; }

// STOR rpm
if(isset($_GET['rpm']))
{ $hdd_rpmmin = intval($_GET['rpm']); }

//STOR nr of hdd		
if($_GET['nrhdd'])
{ $nr_hdd = intval($_GET['nrhdd']);	}

/* *** Motherboard *** */
/*
if (isset($_GET['GPU_msc_id']))
{ if  ($_GET['GPU_msc_id']== "G-Sync/FreeSync") {$addmsc[]="G-Sync/FreeSync";}
else 
}
} */

if ($_GET['mdbslots'])
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
	}

	if((strcasecmp($x,"SD card reader"))==0)
	{
		$remove_msd=1;
		if($remove_sd){ unset($chassis_ports[$key]); $chassis_addpi["MicroSD card reader"][]="SD card reader"; }
		else
		{
			$chassis_addpi["SD card reader"][]="2-in-1 card reader";
			$chassis_addpi["SD card reader"][]="3-in-1 card reader";
			$chassis_addpi["SD card reader"][]="4-in-1 card reader";
			$chassis_addpi["SD card reader"][]="5-in-1 card reader";
			$chassis_addpi["SD card reader"][]="6-in-1 card reader";
		}
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
				if(stripos($piparts[1],"USB 3.".$usbv)!==FALSE)
				{
					if(stripos($piparts[1],"Type")===FALSE)
					{
						if(${'usb3'.$usbv.'_set'}>intval($piparts[0]))
						{ $chassis_ports[$key]=$piparts[0]." X "."USB 3.".$usbv; ${'usb3'.$usbv.'_set'}=intval($piparts[0]); for($usbv2=$usbv+1;$usbv2<3;$usbv2++){$chassis_addpi[$piparts[0]." X "."USB 3.".$usbv][]=$piparts[0]." X "."USB 3.".$usbv2; } }
						else
						{ unset($chassis_ports[$key]); }
					}
					else
					{
						if(${'usb3c'.$usbv.'_set'}>intval($piparts[0]))
						{ $chassis_ports[$key]=$piparts[0]." X "."USB 3.".$usbv." (Type-C)"; ${'usb3c'.$usbv.'_set'}=intval($piparts[0]); for($usbv2=$usbv+1;$usbv2<3;$usbv2++){$chassis_addpi[$piparts[0]." X "."USB 3.".$usbv." (Type-C)"][]=$piparts[0]." X "."USB 3.".$usbv2." (Type-C)"; } }
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

foreach($chassis_vports as $key => $x)
{
	if((stripos($x,"any"))!==FALSE)
	{
		$chassis_vports[$key]="HDMI";
		$diffvisearch=2;
	}
	
	if((stripos($x,"mDP"))!==FALSE && $dp_set)
	{
		unset($chassis_vports[$key]);
	}
	
	if((stripos($x,"1 X mDP"))!==FALSE)
	{
		$chassis_vports[$key]="mDP";
		$diffvisearch=1;
	}
	
	if((stripos($x,"X DP"))!==FALSE)
	{ $dp_set=1; }
	
	if((stripos($x,"1 X DP"))!==FALSE)
	{
		$chassis_vports[$key]="DP";
		$diffvisearch=1;
	}

	if((stripos($x,"X HDMI"))!==FALSE)
	{ $hdmi_set=1; }
	
	if((stripos($x,"1 X HDMI"))!==FALSE)
	{
		$chassis_vports[$key]="HDMI";
		$diffvisearch=1;
	}
	
	if((stripos($x,"Micro HDMI"))!==FALSE && $hdmi_set)
	{
		unset($chassis_vports[$key]);
	}
	
	if((stripos($x,"1 X VGA"))!==FALSE)
	{
		$chassis_vports[$key]="VGA";
		$diffvisearch=1;
	}
}

/* *** WWAN *** */
if ($_GET['mdbwwan'])
{ $mdb_wwan = intval($_GET['mdbwwan']); }

/* *** RAM *** */
// RAM capacity
if($_GET['rammin'])
{ $mem_capmin = intval($_GET['rammin']); }
if($_GET['rammax'])
{ $mem_capmax = intval($_GET['rammax']); }
		
// RAM speed
if($_GET['freqmin'])
{ $mem_freqmin = intval($_GET['freqmin']); }
if($_GET['freqmax'])
{ $mem_freqmax = intval($_GET['freqmax']); }

// RAM type
if(isset($_GET['memtype']))
{ array_walk($_GET['memtype'],'clean_string'); $mem_type = $_GET['memtype']; }

/* *** Optical Drive *** */
if(isset($_GET['oddtype'])&&$_GET['oddtype']!="Any/None" && !(stripos($_GET['oddtype'],"Any")!==FALSE&&$_GET['oddtype']!="Any optical drive"))
{ array_walk($_GET['oddtype'],'clean_string'); $odd_type = $_GET['oddtype']; }

/* *** ACUM *** */
if($_GET['acumcapmin'])
{ $acum_capmin = floatval($_GET['acumcapmin']); }
if($_GET['acumcapmax'])
{ $acum_capmax = floatval($_GET['acumcapmax']); }

// Battery life
if($_GET['batlifemin'])
{ $batlife_min = floatval($_GET['batlifemin']); }
if($_GET['batlifemax'])
{ $batlife_max = floatval($_GET['batlifemax']); }

/* *** CHASSIS *** */
// made of
if(isset($_GET['material']))
{ array_walk($_GET['material'],'clean_string'); $chassis_made = $_GET['material']; }

//weight
if($_GET['weightmin'])
{ $chassis_weightmin = floatval($_GET['weightmin']); }
if($_GET['weightmax'])
{ $chassis_weightmax = floatval($_GET['weightmax']); }

//thickness
if($_GET['thicmin'])
{ $chassis_thicmin = floatval($_GET['thicmin']); }
if($_GET['thicmax'])
{ $chassis_thicmax = floatval($_GET['thicmax']); }		

//depth
if($_GET['depthmin'])
{ $chassis_depthmin = floatval($_GET['depthmin']); }
if($_GET['depthmax'])
{ $chassis_depthmax = floatval($_GET['depthmax']); }		
		
//width
if($_GET['widthmin'])
{ $chassis_widthmin = floatval($_GET['widthmin']); }
if($_GET['widthmax'])
{ $chassis_widthmax = floatval($_GET['widthmax']); }

//webcam
if($_GET['webmin'])
{ $chassis_webmin = floatval($_GET['webmin']); }
if($_GET['webmax'])
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
		$chassis_stuff[]="ungroup";
	}
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
if($_GET['wnetspeed'])
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
				$sist_type=end($sist_parts);
				$sist_vers[]=prev($sist_parts);
				array_splice($sist_parts,-2,2);
				$sist_sist[]=implode(" ",$sist_parts)."+".$sist_type;
			}
		}
	}
}
/* *** REGIONS *** */

if(isset($_GET['Regions']) && $_GET['Regions']) { array_walk($_GET['Regions'],'clean_string'); $regions_name = $_GET['Regions']; } else {$to_search["regions"]=0;} 

/* *** WARRANTY *** */
if(isset($_GET['yearsmin']) && ($_GET['yearsmin'])) 
{ $war_yearsmin = intval($_GET['yearsmin']); }
if(isset($_GET['yearsmax']) && ($_GET['yearsmax'])) 
{ $war_yearsmax = intval($_GET['yearsmax']); }
$war_typewar=[1=>"1",2=>"2",3=>"3",4=>"4"];

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