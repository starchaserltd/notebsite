<?php
/* SIMPLE SEARCH */
//Initialising some generic values
$cpu_tdpmin=0.01; $gpu_powermin=0.00; $display_hresmin=0.01; $hdd_capmin=0.01; $war_yearsmin=0.01; $acum_capmin=0.01; $wnet_ratemin=0.00; $sist_pricemax=1; $odd_speedmin=0.01; $hdd_capmin = 1; $hdd_capmax = 1900; $mem_capmin=0.01; $mdb_ratemin=0.01; $chassis_weightmin=0.01; $wnet_speedmin=150;
$diffsearch=0;
$batlife_min=0;
$batlife_max=1000;
$mdb_wwan = 0;

// BUDGET val min and max
if(isset($_GET['bdgmin'])) { $budgetmin = (floatval($_GET['bdgmin'])/$exch)-1; }
if(isset($_GET['bdgmax'])) { $budgetmax = (floatval($_GET['bdgmax'])/$exch)+1; }

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
	"regions" => 0
);

if(isset($_GET['s_prod'])) {  array_walk($_GET['s_prod'],'clean_string'); $prod_model = $_GET['s_prod']; }
$hdd_type = array();

switch ($_GET['type']) 
{	
	case "1": //mainstream
		$model_minclass=0; $model_maxclass=1;
		$cpu_tdpmin = 7;
		$cpu_tdpmax = 45;
		$mdb_wwan = 1;
		$chassis_weightmin= 1.90;
		$chassis_weightmax=3;
		$chassis_thicmin=18;
		$chassis_thicmax=40;
		$gpu_typelist=[0,1];
		$hdd_type = ["HDD","SSD","SSHD"];
		$sist_sist=["Windows+Home","Windows+Pro","Windows+S","Chrome OS","macOS","Linux Ubuntu"]; 
		$to_search["chassis"]=1; $to_search["mdb"]=1; $to_search["cpu"]=1; $to_search["gpu"]=1;
		$to_search["hdd"]=1; $to_search["mem"]=1; $to_search["display"]=1; $to_search["sist"]=1;
		$filtercomp = array("cpu","chassis", "gpu", "mdb", "display","hdd","sist");
		break;
		
	case "2"://ultraportable
		$model_minclass=0; $model_maxclass=1;
		$cpu_tdpmin = 0;
		$cpu_tdpmax = 25; 
		$hdd_type = ["EMMC","SSD"];
		$chassis_weightmax=2.1;
		$chassis_thicmax = 23;
		$gpu_typelist=[0,1,2];
		$mdb_wwan = 0;
		$sist_sist=["Windows+Home","Windows+Pro","Windows+S","Chrome OS","macOS","Linux Ubuntu"]; 
		$to_search["chassis"]=1; $to_search["cpu"]=1; $to_search["gpu"]=1;
		$to_search["hdd"]=1; $to_search["mem"]=1; $to_search["display"]=1; $to_search["sist"]=1;
		$filtercomp = array("cpu","chassis", "gpu", "display","hdd","sist");
		break;
		
	case "3"://business
		$model_minclass=1; $model_maxclass=4;
		$cpu_tdpmin = 4;
		$cpu_tdpmax = 45;
		$chassis_weightmax=3;
		$mdb_wwan = 0;
		$chassis_thicmax=40;
		$gpu_powermax=30;
		$gpu_typelist=[0,1,3];
		$hdd_type = ["HDD","SSD","SSHD"];
		$sist_sist=["Windows+Home","Windows+Pro","Windows+S","macOS","Linux Ubuntu"]; 
		$to_search["chassis"]=1; $to_search["mdb"]=1; $to_search["cpu"]=1; $to_search["gpu"]=1;
		$to_search["hdd"]=1; $to_search["mem"]=1; $to_search["display"]=1; $to_search["sist"]=1;
		$filtercomp = array("cpu","chassis", "gpu", "mdb", "display","hdd","sist","mem");
		break;
    	
	case "4":// gaming
		$model_minclass=0; $model_maxclass=1;
		$cpu_tdpmin = 15;
		$cpu_tdpmax = 300;
		$mdb_wwan = 1;
		$hdd_type = ["HDD","SSD","SSHD"];
		$chassis_thicmin = 10;
		$sist_sist=["Windows+Home","Windows+Pro","Windows+S"]; 
		$to_search["chassis"]=1; $to_search["cpu"]=1; $to_search["gpu"]=1; $to_search["mdb"]=1;
		$to_search["hdd"]=1; $to_search["mem"]=1; $to_search["display"]=1; $to_search["sist"]=1;
		$filtercomp = array("cpu","chassis", "gpu","mdb", "display","hdd","sist");
		break;
		
	case "5":// cad/3d design
		$model_minclass=1; $model_maxclass=4;
		$cpu_tdpmin = 15;
		$cpu_tdpmax = 300;
		$gpu_powermin=30;
		$gpu_typelist=[3];
		$mdb_wwan = 0;
		$hdd_type = ["SSD","SSHD"];
		$chassis_thicmin = 10;
		$sist_sist=["Windows+Home","Windows+Pro"]; 
		$to_search["chassis"]=1; $to_search["cpu"]=1; $to_search["gpu"]=1; $to_search["mdb"]=1;
		$to_search["hdd"]=1; $to_search["mem"]=1; $to_search["display"]=1; $to_search["sist"]=1;
		$filtercomp = array("cpu","chassis", "gpu","mdb", "display","hdd","sist");	
		break;
	
	case "99":// All
		$sist_sist=["Windows+Home","Windows+Pro","Windows+S","Chrome OS","macOS","Linux Ubuntu","Android"];
		$mdb_wwan = 0;
		$filtercomp = array("sist");
		break;
}

if(isset($_GET['cpu_type']))
{
	foreach($_GET['cpu_type'] as $el)
	{
		switch($el)
		{
			case "1":
			{
				$cpu_prod[]="Intel";
				break;
			}
			case "2":
			{
				$cpu_prod[]="Intel";
				$cpu_misc[]="Intel Core i3";
				break;
			}
			case "3":
			{
				$cpu_prod[]="Intel";
				$cpu_misc[]="Intel Core i5";
				break;
			}
			case "4":
			{
				$cpu_prod[]="Intel";
				$cpu_misc[]="Intel Core i7";
				$cpu_misc[]="Intel Core i9";
				$cpu_misc[]="Intel Xeon";
				break;
			}
			case "5":
			{
				$cpu_prod[]="AMD";
				break;
			}
			case "6":
			{
				$cpu_prod[]="AMD";
				$cpu_misc[]="Ryzen";
				break;
			}
			case "7":
			{
				$cpu_misc[]="HT";
				break;
			}
			case "8":
			{
				$cpu_coremin=4;
				break;
			}
			case "9":
			{
				if($cpu_coremin<4){$cpu_coremin=6;}
				break;
			}
		}
	}
	$cpu_prod=array_unique($cpu_prod);
	$filtercomp[] = "cpu";
}

if(isset($_GET['s_memmin'])) { $mem_capmin=intval($_GET['s_memmin']); }
if(isset($_GET['s_memmax'])) { $mem_capmax=intval($_GET['s_memmax']); }
$filtercomp[] = "mem";

if(isset($_GET['ssd'])) { $hdd_type = ["SSD"]; }
if(isset($_GET['s_hddmin'])) { $totalcapmin=intval($_GET['s_hddmin']); }
if(isset($_GET['s_hddmax'])) { $hdd_capmax=intval($_GET['s_hddmax']); }
$filtercomp[] = "hdd";

if(isset($_GET['s_dispsizemin'])) { $display_sizemin=floatval($_GET['s_dispsizemin']); }
if(isset($_GET['s_dispsizemax'])) { $display_sizemax=floatval($_GET['s_dispsizemax']); }
if(isset($_GET['display_type']))
{
	$display_backt=array(); $display_misc=array(); $display_touch=array();
	foreach($_GET['display_type'] as $el)
	{
		switch($el)
		{
			case "1":
			{
				array_push($display_backt,"LED IPS","OLED","LED IPS PenTile");
				break;
			}
			case "2":
			{
				array_push($display_backt,"LED TN WVA");
				$display_hz=120;
				break;
			}
			case "3":
			{
				$display_vresmin=1080;
				break;
			}
			case "4":
			{
				if($display_vresmin!=1080) { $display_vresmin=1280; }
				break;
			}
			case "5":
			{
				if($display_vresmin!=1080 && $display_vresmin!=1280 ) { $display_vresmin=1920; }
				break;
			}
			case "6":
			{
				$display_srgb=80;
				break;
			}
			case "7":
			{
				$display_touch[]=2;
				$chassis_twoinone=[0,1];
				break;
			}
			case "8":
			{
				$display_touch[]=1;
				$chassis_twoinone=[0,1];
				break;
			}
			case "9":
			{
				$chassis_twoinone=[0,1];
				$chassis_stuff[]="Stylus";
				break;
			}
		}
	}
}
$filtercomp[] = "display";

if(isset($_GET['graphics']))
{
	foreach($_GET['graphics'] as $el)
	{
		switch ($el) 
		{  			
			case "1": //basic
			{
				if ($_GET['type']=="4") //GAMING
				{
					$gpu_maxmemmin = 1024;
					$gpu_powermin = 20;
					$gpu_typelist = [1];
				}
				elseif (($_GET['type'])=="5") //PROFESIONAL
				{
					$gpu_maxmemmin = 1024;
					$gpu_powermin = 25;
					$gpu_ratemin = 0;
					$gpu_ratemax = 30;
					$gpu_typelist = [3];
				}
				else//ALL
				{
					$gpu_powermax = 50;
					$gpu_typelist = [0,1,3];
				}
				break;
			}
			
			case "2": //average
			{
				if ($_GET['type']=="4") //GAMING
				{
					$gpu_maxmemmin = 2048;
					$gpu_typelist = [2];
				}
				elseif (($_GET['type'])=="5") //PROFESIONAL
				{
					$gpu_maxmemmin = 2048;
					$gpu_ratemin = 25;
					$gpu_ratemax = 50;
					$gpu_typelist = [3];
				}
				else//ALL
				{
					$gpu_powermin = 55;
					$gpu_powermax = 80;
					$gpu_typelist = [2,3];
				}
				break;
			}

			case "3": //high-end
			{
				if ($_GET['type']=="4") //GAMING
				{
					$gpu_typelist = [4];
				}
				elseif (($_GET['type'])=="5") //PROFESIONAL
				{
					$gpu_maxmemmin = 2048;
					$gpu_ratemin = 50;
					$gpu_typelist = [3];
				}
				else//ALL
				{
					$gpu_powermin = 70;
					$gpu_typelist = [4,3];
				}
				break;
			}
		}
	}
}

//regional search
if(isset($_GET['region_type']))
{
	foreach($_GET['region_type'] as $el)
	{
		if($el==1){ $regions_name[]="United States"; $war_yearsmin=1; }
		elseif ($el==2){ $regions_name[]="Europe"; $war_yearsmin=2; }
	}
	$filtercomp[] = "regions";
	
	$regional_search_regions_array=array();
	
	foreach($regions_name as $el)
	{
		foreach ($exchange_list->{"code"} as $ex_key => $ex_el)
		{
			if(in_array($el,explode(",",$ex_el["dregion"])))
			{ 
				foreach(explode(",",$ex_el["region"]) as $f_el)
				{ array_push($regional_search_regions_array,$f_el); }
			}
		}
	}
	if(isset($regional_search_regions_array[0]))
	{ $regional_search_regions_array=array_unique($regional_search_regions_array); $search_regions_results=implode(",",$regional_search_regions_array); }
}

$filtercomp=array_unique($filtercomp);
foreach($filtercomp as $el) { $to_search[$el]=1; }

?>