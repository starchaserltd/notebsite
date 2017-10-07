<?php
//some variable initialisation
$cpu_tdpmin = 0.01; $gpu_powermin = 0; $gpu_maxmemmin = 1; //$hdd_capmin = $totalcapmin;
$war_yearsmin = 0.01; $acum_capmin = 0.01; $wnet_ratemin = 0.01; $sist_pricemax = 1;
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
if(isset($_GET['Producer_prod'])) { $prod_model = $_GET['Producer_prod']; }
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
if(isset($_GET['CPU_prod_id'])) { $cpu_prod = $_GET['CPU_prod_id']; }

//THE CPU MODEL IS SPECIAL SO IT NEEDS SOME TRIMMING AND REBUILDING	
if(isset($_GET['CPU_model_id']))
{	
	$cpu_model = $_GET['CPU_model_id']; 
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
{ $cpu_turbomin = $_GET['cpufreqmin']; }
if($_GET['cpufreqmax'])
{ $cpu_turbomax = $_GET['cpufreqmax']; }

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
{ $gpu_model = $_GET['GPU_model_id']; 
	foreach ($gpu_model as $key=>$x)
	{
		$gpu_model[$key]=preg_replace("/[ ]\([0-9\.]+\/10\)/", "", $x);
	}
}

if (isset($_GET['GPU_arch_id']))
{ $gpu_arch = $_GET['GPU_arch_id']; }

if (isset($_GET['GPU_msc_id']))
{ $gpu_misc = $_GET['GPU_msc_id']; }
/*$gpu_misc = array_flip($gpu_misc);
if (isset($gpu_misc['G-Sync/FreeSync'])) {$mdb_misc[]="G-Sync";$mdb_misc[] = "FreeSync";}
unset($gpu_misc['G-Sync/FreeSync']);
$gpu_misc = array_flip($gpu_misc); 
 */

// var_dump($gpu_misc);
 
 
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

// DISPLAY MSC
$rows = array(); $result=mysqli_query($con,"SELECT name FROM notebro_site.nomen WHERE prop='backt'");
while($row = mysqli_fetch_array($result))
{  array_push($rows, $row[0]); }

if(isset($_GET['DISPLAY_msc_id']))
{
$display_backt = $_GET['DISPLAY_msc_id'];
$display_misc= array_diff($display_backt,$rows); //var_dump($display_misc);
$display_backt = array_diff($display_backt,$display_misc); 

$display_misc = array_flip($display_misc);
if (isset($display_misc['G-Sync/FreeSync'])) {$mdb_misc[]="G-Sync/FreeSync"; }
unset($display_misc['G-Sync/FreeSync']);
//$display_misc = array_flip($display_misc); 
if (isset($display_misc['80% sRGB or better'])) {$display_srgb= 80;}//new
unset($display_misc['80% sRGB or better']);//new
$display_misc = array_flip($display_misc);//new

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
{ $nr_hdd = intval($_GET['nrhdd']);	}

/* *** Motherboard *** */
/*
if (isset($_GET['GPU_msc_id']))
{ if  ($_GET['GPU_msc_id']== "G-Sync/FreeSync") {$addmsc[]="G-Sync/FreeSync";}
else 
}
} */

if ($_GET['mdbslots'])
{ $mdb_ramcap = $_GET['mdbslots']; }
	
if(isset($_GET['MDB_port_id']))
{ $chassis_ports = $_GET['MDB_port_id']; } //var_dump($chassis_ports);

foreach($chassis_ports as $key => $x)
{
	if((stripos($x,"RS-232"))!==FALSE)
	{
		$addmsc["RS-232"][]="RS-232";
	}
	
	if((stripos($x,"ExpressCard"))!==FALSE)
	{
		$addmsc["ExpressCard"][]="ExpressCard";
	}
	
	if((stripos($x,"SIM card"))!==FALSE)
	{
		$addmsc["SIM card"][]="SIM card";
	}
	
	if((stripos($x,"SmartCard"))!==FALSE)
	{
		$addmsc["SmartCard"][]="SmartCard";
	}
	if((stripos($x,"SD card reader"))!==FALSE)
	{
		
		//$addpi[] = ["4in1","6in1","3in1"];
		//$addpi[]="SD card reader";
		$chassis_addpi["SD card reader"][]="2-in-1 card reader";
		$chassis_addpi["SD card reader"][]="3-in-1 card reader";
		$chassis_addpi["SD card reader"][]="4-in-1 card reader";
		$chassis_addpi["SD card reader"][]="5-in-1 card reader";
		$chassis_addpi["SD card reader"][]="6-in-1 card reader";
		$chassis_addpi["SD card reader"][]="MicroSD card reader";
	}
	
	if(stripos($x,"USB 3.0")!==FALSE)
	{
		$y=str_ireplace("3.0","3.1",$x);
		$y2=explode(" X ",$y);
		$y2i=intval($y2[0]);
		if($y2i>0 && $y2i<6)
		{
			for($i=$y2i;$i<=6;$i++)
			{ $chassis_addpi[$x][]=$i." X ".$y2[1]; }
		}
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
if($_GET['oddtype']!="Any/None" && $_GET['oddtype']!="Any")
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
$chassis_speakers=array(); $chassis_subwoofer=array();
foreach($chassis_stuff as $key => $x)
{
	
	if(((stripos($x,"speakers"))!==FALSE)&&!((stripos($x,"premium"))!==FALSE))
	{
		unset($chassis_stuff[$key]); $chassis_speakers[]=$x;
	}
	
	if((stripos($x,"subwoofer"))!==FALSE)
	{
		unset($chassis_stuff[$key]); $chassis_subwoofer[]=$x;
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
		unset($chassis_stuff[$key]);
		$chassis_stuff[]="group";
		$chassis_stuff[]="olufsen";
		$chassis_stuff[]="altec";
		$chassis_stuff[]="harman";
		$chassis_stuff[]="jbl";
		$chassis_stuff[]="klipsch";
		$chassis_stuff[]="sonicmaster";
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
{
	$chassis_extra_stuff[$key]=$addtomsc;
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
/* *** REGIONS *** */

if(isset($_GET['Regions']) && $_GET['Regions']) { $regions_name =$_GET['Regions']; } else {$to_search["regions"]=0;} 

/* *** WARRANTY *** */
if(isset($_GET['yearsmin']) && ($_GET['yearsmin'])) 
{ $war_yearsmin = $_GET['yearsmin']; }
if(isset($_GET['yearsmax']) && ($_GET['yearsmax'])) 
{ $war_yearsmax = $_GET['yearsmax']; }

$war_typewar[1] = "1"; $war_typewar[2] = "2";

if (isset($_GET['premiumadv']))
{ $war_typewar[2] = "2"; $war_typewar[1]=-1; }
if (isset($_GET['premiumadvadp']))
{ 
	if($war_typewar[2]=="2"){ $war_typewar[4] = "4"; $war_typewar[1]=-1; $war_typewar[2]=-1; } 
	else { $war_typewar[3]="3"; $war_typewar[4] = "4"; $war_typewar[1]=-1; $war_typewar[2]=-1;  }
}

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
