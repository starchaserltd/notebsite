<?php
if(isset($_GET['sort_by'])) { $sort_by = $_GET['sort_by']; }
if(isset($_GET['browse_by'])) { $browse_by = $_GET['browse_by']; }
$to_search["model"]=1;
//LIST OF COMPONENTS WE WILL FILTER
$to_search = array(
	"model"   => 1,
    "acum"    => 0,
    "chassis" => 0,
    "cpu"     => 0,
    "display" => 0,
    "gpu"     => 0,
    "hdd"     => 0,
    "mdb"     => 0,
    "mem"     => 0,
    "odd"     => 0,
    "prod"    => 0,
    "shdd"    => 0,
    "sist"    => 0,
    "war"     => 0,
    "wnet"    => 0,
);
switch($browse_by)
{
	case "prod":
	{	
		if($_GET['prod'])
		{
			$prod_model = $_GET['prod'];
			$filtercomp = array();
		}
		break;
	}	
	
	case "mainstream":
	{	$cpu_tdpmin = 4;
		$display_sizemin=14;
		$display_sizemax=17.3;
		$display_touch[] = "1"; $display_touch[] ="2"; 
		$cpu_tdpmax = 35;
		$mdb_wwan = 1;
		$chassis_weightmin= 1.80;
		$chassis_weightmax=3;
		$chassis_thicmin=10;
		$chassis_thicmax=30;
		$gpu_typelist[]=0;
		$gpu_typelist[]=1;
		$to_search["chassis"]=1;
		$to_search["mdb"]=1;
		$to_search["cpu"]=1;
		$to_search["gpu"]=1;
		$to_search["display"]=1;
		$filtercomp = array("cpu","chassis", "gpu", "mdb", "display");
		break;
	}
	case "ultraportable":
	{
		$cpu_tdpmin = 0;
		$cpu_tdpmax = 25; 
		$chassis_weightmax=2;
		$chassis_thicmax = 19;
		$gpu_typelist[]=0;
		$gpu_typelist[]=1;
		$gpu_typelist[]=2;
		$to_search["chassis"]=1;
		$to_search["cpu"]=1;
		$to_search["gpu"]=1;
		$filtercomp = array("cpu","gpu", "chassis");
		break;
	}
	case "gaming":
	{
		$cpu_tdpmin = 30;
		$cpu_tdpmax = 300;
		$gpu_powermin=30;
		$type_gpu = 1;
		$gpu_typelist[]=1;
		$gpu_typelist[]=2;
		$gpu_typelist[]=4;
		$display_touch[] = "1"; $display_touch[] ="2";
		$mdb_wwan = 1;
		$chassis_thicmin = 10;
		$to_search["chassis"]=1;
		$to_search["cpu"]=1;
		$to_search["gpu"]=1;
		$to_search["mdb"]=1;
		$filtercomp = array("cpu", "mdb" , "chassis" ,"gpu");
		break;
	}
	case "professional":
	{
		$cpu_tdpmin = 15;
		$cpu_tdpmax = 300;
		$gpu_powermin=20;
		$gpu_typelist[]=0;
		$gpu_typelist[]=1;
		$gpu_typelist[]=3;
		$mdb_wwan = 0;
		$to_search["mdb"]=1;
		$to_search["cpu"]=1;
		$to_search["gpu"]=1;
		$to_search["display"]=1;
		$filtercomp = array("cpu", "mdb","gpu","display");
		break;
	}
	case "smalldisplay":
	{
		$display_sizemin=10;
		$display_sizemax=13.95;
		$display_touch[] = "1"; $display_touch[] ="2"; 
		$to_search["display"]=1;
		$filtercomp = array("display");
		break;
	}
	case "mediumdisplay":
	{
		$display_sizemin=14;
		$display_sizemax=16.95;
		$display_touch[] = "1"; $display_touch[] ="2"; 
		$to_search["display"]=1;
		$filtercomp = array("display");
		break;
	}
	case "largedisplay":
	{
		$display_sizemin=17;
		$display_sizemax=18.7;
		$display_touch[] = "1"; $display_touch[] ="2"; 
		$to_search["display"]=1;
		$filtercomp = array("display");
		break;
	}	
}

?>
