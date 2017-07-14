<?php
/* SIMPLE SEARCH */
//Initialising some generic values
$cpu_tdpmin=0.01; $gpu_powermin=0.00; $display_hresmin=0.01; $hdd_capmin=0.01; $war_yearsmin=0.01; $acum_capmin=0.01; $wnet_ratemin=0.00; $sist_pricemax=1; $odd_speedmin=0.01; $hdd_capmin = 1; $hdd_capmax = 3024; $mem_capmin=0.01; $mdb_ratemin=0.01; $chassis_weightmin=0.01; 
$diffsearch=0;
$batlife_min=0;
$batlife_max=1000;
$mdb_wwan = 1;

// BUDGET val min and max
if(isset($_GET['bdgmin'])) { $budgetmin = (floatval($_GET['bdgmin'])/$exch)-1; }
if(isset($_GET['bdgmax'])) { $budgetmax = (floatval($_GET['bdgmax'])/$exch)+1; }

$result = mysqli_query($GLOBALS['con'], "SELECT * FROM notebro_site.nomen WHERE type=15 OR type=16 OR type=21 OR type=31 OR type=34 OR type=35 OR type=63 OR type=66 OR type=68 OR type=81 ORDER BY type ASC"); 

while( $row=mysqli_fetch_array($result))
{
	$nomenvalues[]=$row; 
}

//LIST OF COMPONENTS WE WILL FILTER
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
    "odd"     => 0,
    "prod"    => 0,
    "shdd"    => 0,
    "sist"    => 1,
    "war"     => 1,
    "wnet"    => 1,
);

$hdd_type = array();

switch ($_GET['type']) 
{	
	case "1": //normal
		$cpu_tdpmin = 5; //echo $cpu_tdpmin;
		$cpu_tdpmax = 45; //echo $cpu_tdpmax;
		$display_sizemin = 14;
		$display_sizemax = 17.5;
		$mem_capmin = 4;
		$mem_capmax = 8;
		$batlife_min = 3;
		$batlife_max = 8;
		$chassis_weightmin= 1.80;
		$chassis_weightmax=3;
		$wnet_speedmin = 430;	
		break;
		
	case "2"://ultraportable
		$cpu_tdpmin = 1;
		$cpu_tdpmax = 25;
		$display_sizemax = 16;
		$mem_capmin = 4;
		$mem_capmax = 8;
		$batlife_min = 5;
		$chassis_weightmax=1.80; 
		
		$wnet_speedmin = 850;
		$chassis_thicmax = 19;
		$hdd_type[] = "SSD";
		$mdb_wwan = 0;
		break;
		
	case "3"://business
		$cpu_tdpmin = 10;
		$cpu_tdpmax = 45;
		$display_sizemin = 14;
		$display_sizemax = 17.3;
		$display_surft = "matte";  
		$mem_capmin = 4;
		$mem_capmax = 16;
		$batlife_min = 5;
		$chassis_weightmin=1.5;
		$chassis_thicmin = 17;
		$wnet_speedmin = 850;
		$war_typewar = array(2,3,4); 
		//$budgetmin = 400;
		$hdd_capmin = 100;
		$chassis_ports=array();
		$chassis_vports=array();
		$chassis_ports[]="1 X LAN";
		$chassis_vports[]="HDMI";
		$diffvisearch=1;
		$diffpisearch=1;
		$chassis_webmin=0.9;
		$hdd_type[]="SSD";
		$mdb_wwan = 0;
		$sist_sist[]="Windows+Pro"; $sist_sist[]="macOS";
		break;
    	
	case "4":// gaming
		$cpu_tdpmin = 15; 
		$display_sizemin = 13;
		$mem_capmin = 8;
		$chassis_thicmin = 20;
		//$budgetmin = 400;
		$hdd_capmin = 200;
		$wnet_speedmin = 867;
		$display_hresmin = 1600; 
		$display_vresmin = 900;   
		$hdd_type[] = "SSD";
		$gpu_ldmin = (intval(substr($nomenvalues[9][2],0,4))-1)."-01-01";
		break;
		
	case "5":// cad/3d design
		$cpu_clockmin = 0.45*$nomenvalues[1][2];
		$cpu_tdpmin = 14;
		$cpu_tdpmax = 55;
		$display_sizemin = 15;
		$mem_capmin = 8;
		$display_hresmin = 1920;
		$display_vresmin = 1080;
		$hdd_capmin = 200;  
		$mdb_wwan = 0;		
		break;
}

switch ($issimple)
{											 
    case "1"://balanced features(preselectat)
        break;
    
	case "2": //battery focus
		if (($_GET['type'])==1)
			{
				$display_sizemin = 13;
				$batlife_min = 4;
				$cpu_tdpmax = 40;
			}
		else if (($_GET['type'])==2)
			{
				$batlife_min = 6;
				$cpu_tdpmax = 22;
				$display_sizemin = 11;
			}
		else if (($_GET['type'])==3)
			{
				$display_sizemin = 11;
				$batlife_min = 7;
				$cpu_tdpmax = 40;
			}
		else if (($_GET['type'])==4)
			{
				$batlife_min = 4;
				$cpu_tdpmax = 45;
			}
		else if (($_GET['type'])==5)
			{
				$display_sizemin = 13;
				$batlife_min = 4.5;
				$cpu_tdpmax = 40 ;
			}	
        break;
		
   case "3": //high performance
		$mem_capmin = 8;
		$mem_capmax = 32;
		if (($_GET['type'])==1) //normal
			{
				$cpu_clockmin = 0.55*$nomenvalues[1][2];
				$cpu_tdpmin = 15;
			}
		else if (($_GET['type'])==2) //ultraportable
			{
				$cpu_clockmin = 0.50*$nomenvalues[1][2];
				$cpu_tdpmin = 15;
				$cpu_tdpmax = 45;
				$chassis_weightmax= 1.9;
				$chassis_thicmax = 19;
				
			}
		else if (($_GET['type'])==3) //business
			{
				$cpu_clockmin = 0.55*$nomenvalues[1][2];
				$cpu_tdpmin = 15;
			}
		else if (($_GET['type'])==4) //gaming
			{
				$cpu_clockmin = 0.50*$nomenvalues[1][2];
				$cpu_tdpmin = 45;
			}
		else if (($_GET['type'])==5) //cad
			{
				$cpu_clockmin = 0.55*$nomenvalues[1][2];
				$cpu_tdpmin = 40;
				$cpu_tdpmax = 150;
			}
		break;
    
}

switch ($_GET['graphics']) 
{  			
    case "1": //minimal
		$wnet_speedmin=433;
        $gpu_typelist[] = 0; $gpu_typelist[] = 1;
		if (($_GET['type'])==4) //GAMING
		{
			$gpu_powermin = 15;
			$gpu_powermax = 40;
			$gpu_maxmemmax = 4096;
			unset($gpu_typelist);
			$gpu_typelist[] = 1;
			$gpu_typelist[] = 2;
		}
		else if (($_GET['type'])==5) //PROFESIONAL
		{
			$gpu_powermin = 20;
			$gpu_powermax = 40;
			unset($gpu_typelist);
			$gpu_typelist[] = 3;
		}
		break;
    
	case "2"://casual gaming
		if (($_GET['type'])==1) // NORMAL
		{
			$gpu_typelist[] = 1;
			$gpu_typelist[] = 2;
			$gpu_powermin = 30;
			$gpu_powermax = 50;
			$gpu_maxmemmax = 4096;
		}
		else if (($_GET['type'])==2) // ULTRAPOR
		{
			if($issimple=="2")
			{ $batlife_min = 4; }
			else
			{ $batlife_min = 3; }
			$gpu_typelist[] = 1;
			$gpu_typelist[] = 2;
			$gpu_powermin = 20;
			$gpu_powermax = 50;
			$gpu_maxmemmax = 4096;
			$chassis_weightmax= 2.0;
			$chassis_thicmax = 20;
		}
		else if (($_GET['type'])==3) //BUSINESS
		{
			$gpu_typelist[] = 1;
			$gpu_typelist[] = 2;
			$gpu_typelist[] = 3;
			$gpu_powermin = 25;
			$gpu_powermax = 50;
			$gpu_maxmemmax = 4096;
		}
		else if (($_GET['type'])==4) //GAMING
		{
			$gpu_typelist[] = 1;
			$gpu_typelist[] = 2;
			$gpu_powermin = 35;
			$gpu_powermax = 75;
			$gpu_maxmemmax = 4096;
		}
		else if (($_GET['type'])==5) //PROFESIONAL
		{
			$gpu_typelist[] = 3;
			$gpu_powermin = 35;
			$gpu_powermax = 75;
		}
		break;

	case "3": //high performance
		$gpu_typelist[] = 1; $gpu_typelist[] = 2;
		if (($_GET['type'])==5) //PROFESIONAL
		{ unset($gpu_typelist); $gpu_typelist[] = 3; }
		else if (($_GET['type'])==2) // ULTRAPOR
		{ 	$chassis_weightmax= 2.0;
			$chassis_thicmax = 20;
			if($issimple=="2")
			{ $batlife_min = 4; }
			else
			{ $batlife_min = 3; }
		}
		else if (($_GET['type'])==3) //BUSINESS
		{ 
			$gpu_typelist[] = 3;
		}
		else if (($_GET['type'])==4) //GAMING
		{ 
			unset($gpu_typelist); $gpu_typelist[] = 2; $gpu_typelist[] = 4;
		}
		else
		{
			$gpu_typelist[] = 4; 
		}
		$gpu_powermin = 50;
		$gpu_mbwmin = 128;
		$gpu_maxmemmin = 2048;
		break;
}
$gpu_typelist=array_unique($gpu_typelist);


switch ($_GET['display']) 
{
    case "1": //budget
		if (!(($_GET['type'] == 4) OR ($_GET['type'] == 5)))
		{
			$display_hresmin = "1";
			$display_hresmax = "2000";
			$display_vresmin = "1";
			$display_vresmax = "1300";
		}
		else
		{
			$display_hresmax = "2000";
			$display_vresmax = "1300";
		}
		break;
    case "2": //high resolution
        $display_hresmin= "1919";
		$display_hresmax = $nomenvalues[7][2];
		$display_vresmin = "1079";
		$display_vresmax = $nomenvalues[8][2];
		break;
}

//touchscreen checkbox
if (isset($_GET['touchscreen_s']) && $_GET['touchscreen_s'] == true)
{ $display_touch[] = "1";} //with touch
else
{ $display_touch[] = "1"; $display_touch[] ="2"; }// no touch


foreach($_GET['storage'] as $x) 
{
    switch($x)
	{
		case "1":  //normal
			$hdd_type[] = "HDD"; $hdd_type[] = "EMMC"; $hdd_type[] = "SSHD";
			$hdd_capmin = 100;
			$hdd_capmax = 1000;
			break;
		
		case "2":  //high storage
			$hdd_capmin = 500;
			$hdd_capmax = $nomenvalues[4][2]*2;
			break;
		
		case "3":  //high speed
			$hdd_type[] = "SSD" ;
			break;
	}
}

//years for warranty and premium checkbox
if($_GET['warmin']) { $war_yearsmin = $_GET['warmin']; }
if($_GET['warmax']) { $war_yearsmax = $_GET['warmax']; }
if (isset($_GET['premium']) && $_GET['premium'] == TRUE) {$war_typewar = "2";} else {$war_typewar = "1";}

if($budgetmax<550)
{
	$hdd_capmin = 32;
	// We are on a budget eh? OK, let's make things less strict.
	switch ($_GET['type'])
	{
		case "1": //normal
			$cpu_tdpmin = $nomenvalues[2][2];
			$cpu_tdpmax = 30;
			$display_sizemin = $nomenvalues[3][2]; 
			$mem_capmin = $nomenvalues[5][2];
			$mem_capmax = 4;
			$chassis_weightmin= 1.1;	
			break;
		
		case "2": //ultraportable
			$display_sizemax = 16;
			$mem_capmin = $nomenvalues[5][2];
			$mem_capmax = 4;
			$batlife_min = 4; 
			$chassis_weightmax=2; ;
			$wnet_speedmin = 300;
			$chassis_thicmax = 24;
			break;
   
		case "3": //business
			$cpu_tdpmin = 4;
			$cpu_tdpmax = 35;
			$display_sizemin = $nomenvalues[3][2];
			$display_sizemax = 16;
			$mem_capmin = 4;
			$chassis_weightmin=1.8;
			$wnet_speedmin = 430;
			$war_typewar = "1";
			//$budgetmin = 400;
			break;

		case "4": // gaming
			$display_sizemin = 11;
			$hdd_capmin = 200;
			$mem_capmin = 4;
			$wnet_speedmin = 430;
			$display_hresmin = 1366; 
			$display_vresmin = 768;  
			break;
		
		case "5": // cad/3d design
			$cpu_tdpmin = 11;
			$cpu_tdpmax = 45;
			$cpu_clockmin=$cpu_clockmin*0.75;
			$display_sizemin = 11;
			$mem_capmin = 4;
			$display_hresmin = 1366;
			$display_vresmin = 768;
			$hdd_capmin = 100;  
			break;
	}
}

if($hdd_capmin)
{	
	$totalcapmin=$hdd_capmin;
	$hdd_capmin=0;
}
else
{ $totalcapmin=0; }


?>