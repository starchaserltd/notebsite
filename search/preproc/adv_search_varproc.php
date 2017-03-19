<?php
//some variable initialisation
$cpu_tdpmin = 0.01; $gpu_powermin = 0; $gpu_maxmemmin = 1; $display_hresmin = 0.01; //$hdd_capmin = $totalcapmin;
$war_yearsmin = 0.01; $acum_capmin = 0.01; $wnet_ratemin = 0.01; $sist_pricemax = 1;
$odd_speedmin = 0; $mem_capmin = 1; $mdb_ratemin = 0; $chassis_weightmin = 0.01; $addmsc=array();
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
    "shdd"    => 0, 
    "sist"    => 1,
    "war"     => 1,
    "wnet"    => 1,
);

// BUDGET min si max
if($_GET['bdgminadv'])
$budgetmin = floatval($_GET['bdgminadv'])/$exch;
if($_GET['bdgmaxadv'])
$budgetmax = floatval($_GET['bdgmaxadv'])/$exch;

if(isset($_GET['Producer_prod']))
{ $prod_model = $_GET['Producer_prod']; }

if(isset($_GET['Family_fam']))
{ $fam_model = $_GET['Family_fam']; }


/* *** CPU *** */
if(isset($_GET['CPU_prod_id']))
{ $cpu_prod = $_GET['CPU_prod_id']; }

//THE CPU MODEL IS SPECIAL SO IT NEEDS SOME TRIMMING AND REBUILDING	
if(isset($_GET['CPU_model_id']))
{	
	$cpu_model = $_GET['CPU_model_id']; 
	$i=0;
	
	foreach ($cpu_model as $x)
	{
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
{ $cpu_socket = $_GET['CPU_socket_id']; }

// CPU miscellaneous
if(isset($_GET['CPU_msc_id']))
{ $cpu_misc = $_GET['CPU_msc_id']; }

// CPU Launch date
if($_GET['launchdatemin'])
{ $cpu_ldmin = $_GET['launchdatemin']; }
$cpu_ldmin=$cpu_ldmin."-01-01";

if($_GET['launchdatemax'])
{ $cpu_ldmax = $_GET['launchdatemax']; }
$cpu_ldmax=$cpu_ldmax."-12-31";

// CPU nr cores
if($_GET['nrcoresmin'])
{ $cpu_coremin = $_GET['nrcoresmin']; }
if($_GET['nrcoresmax'])
{ $cpu_coremax = $_GET['nrcoresmax']; }

// CPU TDP
if($_GET['cputdpmin'])
{ $cpu_tdpmin = $_GET['cputdpmin']; }
if($_GET['cputdpmax'])
{ $cpu_tdpmax = $_GET['cputdpmax'];	}		

// CPU Frequency
if($_GET['cpufreqmin'])
{ $cpu_clockmin = $_GET['cpufreqmin']; }
if($_GET['cpufreqmax'])
{ $cpu_clockmax = $_GET['cpufreqmax']; }

// CPU Lithography
if($_GET['cputechmin'])
{ $cpu_techmin = $_GET['cputechmax']; }
if($_GET['cputechmax'])
{ $cpu_techmax = $_GET['cputechmin']; }
			

/* *** GPU *** */
 $gpu_typelist=array();
if(isset($_GET['gputype']))
{
	$typegpu=$_GET['gputype'];
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
{ $gpu_prod = $_GET['GPU_prod_id']; }

if ($_GET['gpupowermin'])
{ $gpu_powermin = $_GET['gpupowermin']; }
if ($_GET['gpupowermax'])
{ $gpu_powermax = $_GET['gpupowermax']; }

if (isset($_GET['GPU_model_id']))
{ $gpu_model = $_GET['GPU_model_id']; }

if (isset($_GET['GPU_arch_id']))
{ $gpu_arch = $_GET['GPU_arch_id']; }

if (isset($_GET['GPU_msc_id']))
{ $gpu_misc = $_GET['GPU_msc_id']; }

// GPU Maxmem
if($_GET['gpumemmin'])
{ $gpu_maxmemmin = $_GET['gpumemmin']; }

if($_GET['gpumemmax'])
{ $gpu_maxmemmax = $_GET['gpumemmax']; }
			
//  GPU Memory band
if($_GET['gpubusmin'])
{ $gpu_mbwmin = $_GET['gpubusmin']; }

if($_GET['gpubusmax'])
{ $gpu_mbwmax = $_GET['gpubusmax']; }

// GPU Launch date
if($_GET['gpulaunchdatemin'])
{ $gpu_ldmin = $_GET['gpulaunchdatemin']; }
$gpu_ldmin=$gpu_ldmin."-01-01";

if($_GET['gpulaunchdatemax'])
{ $gpu_ldmax = $_GET['gpulaunchdatemax']; }
$gpu_ldmax=$gpu_ldmax."-12-31";


/* *** DISPLAY *** */
if($_GET['displaymin'])
{ $display_sizemin = $_GET['displaymin']; }
if($_GET['displaymax'])
{ $display_sizemax = $_GET['displaymax']; }

if(isset($_GET['DISPLAY_resol_id']))
{
$display_resolutions = $_GET['DISPLAY_resol_id']; 
$result_explode = explode('x', $display_resolutions[0]);
$display_hresmax = $result_explode[0];
$display_vresmax = $result_explode[1];
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
{ $display_format = $_GET['DISPLAY_ratio']; }

//DISPLAY surface type
if(isset($_GET['surface']))
{ $display_surft = $_GET['surface']; }

if($_GET['verresmin'])
{ $display_vresmin = $_GET['verresmin']; }
if($_GET['verresmax'])
{ $display_vresmax = $_GET['verresmax']; }


/* *** STORAGE *** */
// STOR capacity
if($_GET['capacitymin'])
{ $hdd_capmin = $_GET['capacitymin']; }
if($_GET['capacitymax'])
{ $hdd_capmax = $_GET['capacitymax']; }

//STOR type 
if(isset($_GET['typehdd']))
{ $hdd_type = $_GET['typehdd']; }

// STOR rpm
if(isset($_GET['rpm']))
{ $hdd_rpmmax = $_GET['rpm']; }

//STOR nr of hdd		
if($_GET['nrhdd'])
{ $nr_hdd = $_GET['nrhdd'];	}


/* *** Motherboard *** */
if ($_GET['mdbslots'])
{ $mdb_ramcap = $_GET['mdbslots']; }
	
if(isset($_GET['MDB_port_id']))
{ $chassis_ports = $_GET['MDB_port_id']; }

foreach($chassis_ports as $key => $x)
{
	if((stripos($x,"RS-232"))!==FALSE)
	{
		$addmsc[]="RS-232";
	}
	
	if((stripos($x,"ExpressCard"))!==FALSE)
	{
		$addmsc[]="ExpressCard";
	}
	
	if((stripos($x,"SIM card"))!==FALSE)
	{
		$addmsc[]="SIM card";
	}
	
	if((stripos($x,"SmartCard"))!==FALSE)
	{
		$addmsc[]="SmartCard";
	}
}

if(isset($_GET['MDB_vport_id']))
{ $chassis_vports = $_GET['MDB_vport_id']; }

foreach($chassis_vports as $key => $x)
{
	if((stripos($x,"1 X mDP"))!==FALSE)
	{
		$chassis_vports[$key]="mDP";
		$diffvisearch=1;
	}
	
	if((stripos($x,"1 X DP"))!==FALSE)
	{
		$chassis_vports[$key]="DP";
		$diffvisearch=1;
	}

	if((stripos($x,"1 X HDMI"))!==FALSE)
	{
		$chassis_vports[$key]="HDMI";
		$diffvisearch=1;
	}
	
	if((stripos($x,"1 X VGA"))!==FALSE)
	{
		$chassis_vports[$key]="VGA";
		$diffvisearch=1;
	}
}

//DO %var% type of SQL search

/* *** WWAN *** */
if ($_GET['mdbwwan'])
{ $mdb_wwan = $_GET['mdbwwan']; }

		
/* *** RAM *** */
// RAM capacity
if($_GET['rammin'])
{ $mem_capmin = $_GET['rammin']; }
if($_GET['rammax'])
{ $mem_capmax = $_GET['rammax']; }
		
// RAM speed
if($_GET['freqmin'])
{ $mem_freqmin = $_GET['freqmin']; }
if($_GET['freqmax'])
{ $mem_freqmax = $_GET['freqmax']; }

// RAM type
if(isset($_GET['memtype']))
{ $mem_type = $_GET['memtype']; }


/* *** Optical Drive *** */
if($_GET['oddtype']!="Any")
{ $odd_type = $_GET['oddtype']; }


/* *** ACUM *** */
if($_GET['acumcapmin'])
{ $acum_capmin = $_GET['acumcapmin']; }
if($_GET['acumcapmax'])
{ $acum_capmax = $_GET['acumcapmax']; }

// Battery life
if($_GET['batlifemin'])
{ $batlife_min = $_GET['batlifemin']; }
if($_GET['batlifemax'])
{ $batlife_max = $_GET['batlifemax']; }

/* *** CHASSIS *** */
// made of
if(isset($_GET['material']))
{ $chassis_made = $_GET['material']; }

//weight
if($_GET['weightmin'])
{ $chassis_weightmin = $_GET['weightmin']; }
if($_GET['weightmax'])
{ $chassis_weightmax = $_GET['weightmax']; }

//thickness
if($_GET['thicmin'])
{ $chassis_thicmin = $_GET['thicmin']; }
if($_GET['thicmax'])
{ $chassis_thicmax = $_GET['thicmax']; }		

//depth
if($_GET['depthmin'])
{ $chassis_depthmin = $_GET['depthmin']; }
if($_GET['depthmax'])
{ $chassis_depthmax = $_GET['depthmax']; }		
		
//width
if($_GET['widthmin'])
{ $chassis_widthmin = $_GET['widthmin']; }
if($_GET['widthmax'])
{ $chassis_widthmax = $_GET['widthmax']; }

//webcam
if($_GET['webmin'])
{ $chassis_webmin = $_GET['webmin']; }
if($_GET['webmax'])
{ $chassis_webmax = $_GET['webmax']; }
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
{ $chassis_stuff = $_GET['CHASSIS_stuff_id']; }

foreach($chassis_stuff as $key => $x)
{
	if((stripos($x,"2 x speakers"))!==FALSE)
	{
		$chassis_stuff[$key]="2x%speakers";
	}
	
	if((stripos($x,"keyboard"))!==FALSE)
	{
		$chassis_stuff[$key]=str_ireplace(" keyboard","",$x);
	}
	
	if((stripos($x,"legacy ports"))!==FALSE)
	{
		$chassis_stuff[$key]=str_ireplace(" ports","",$x);
	}
	
	if((stripos($x,"premium speakers"))!==FALSE)
	{
		$chassis_stuff[$key]="olufsen";
		$chassis_stuff[]="jbl";
		$chassis_stuff[]="klipsch";
		$chassis_stuff[]="sonicmaster";
	}
}

$addmsc=array_unique($addmsc);
foreach($addmsc as $addtomsc)
{
	$chassis_extra_stuff[]=$addtomsc;
}


/* *** WNET *** */
//speed
if($_GET['wnetspeed'])
{ $wnet_speedmin = $_GET['wnetspeed']; }
$wnet_speedmax = 9999999;

//bluetooth
if (isset($_GET['bluetooth']) && $_GET['bluetooth'] == TRUE)
{$wnet_bluetooth = "1"; /*$msc_model="bluetooth";*/ } else {$wnet_bluetooth = "2";}

//Operating System
if(isset($_GET['opsist']))
{
	$sist_list = $_GET['opsist']; 
	foreach($sist_list as $key => $x)
	{
		if((stristr($x,"No OS")!=FALSE))
		{
		 $sist_sist[]=$x;
		}
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

/* *** WARRANTY *** */
if($_GET['yearsmin'])
{ $war_yearsmin = $_GET['yearsmin']; }
if($_GET['yearsmax'])
{ $war_yearsmax = $_GET['yearsmax']; }

$war_typewar = "1";

if (isset($_GET['premiumadv']))
{$war_typewar = "2";}
if (isset($_GET['premiumadvadp']))
{ 
	if($war_typewar=="2"){ $war_typewar = "4"; } 
	else { $war_typewar="3";}
}

if($hdd_capmin)
{
	$totalcapmin=$hdd_capmin;
	$hdd_capmin=0;
}
else
{ $totalcapmin=0; }