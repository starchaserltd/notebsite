<?php
if(isset($_GET['sort_by'])) { $sort_by = clean_string($_GET['sort_by']); }
if(isset($_GET['browse_by'])) { $browse_by = clean_string($_GET['browse_by']); }
$to_search["model"]=1; $totalcapmin=0; $set_j_ssearch="";  $mem_capmax=32; $war_yearsmin=0;
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
    "mem"     => 1,
    "odd"     => 0,
    "prod"    => 0,
    "shdd"    => 0,
    "sist"    => 0,
    "war"     => 0,
    "wnet"    => 0,
	"regions" => 0
);
switch($browse_by)
{
	case "prod":
	{	
		if(isset($_GET['prod']) && $_GET['prod'])
		{
			$prod_model=clean_string($_GET['prod']); $set_j_ssearch="$('#s_prod_id').val(null).trigger('change'); document.getElementById('s_dispsize').noUiSlider.reset(); $('#s_prod_id').append('<option selected=".'"'."selected".'"'.'>'.$prod_model."</option>'); $('#type').multiselect('select', ['99']); $('#type').multiselect('refresh');";
			$sist_sist=["Windows+Home","Windows+Pro","Windows+S","Chrome OS","macOS","Linux","Android"]; 
			$to_search["sist"]=1; $filtercomp = array("sist");
		}
		break;
	}	
	
	case "mainstream":
	{	
		$model_minclass=0; $model_maxclass=1;
		$cpu_tdpmin = 7;
		$cpu_tdpmax = 45;
		$display_sizemin=14;
		$display_sizemax=17.3;
		$display_vresmin=1080;
		$chassis_twoinone=0;
		$mdb_wwan = 1;
		$chassis_weightmin= 1.90;
		$chassis_weightmax=3;
		$chassis_thicmin=18;
		$chassis_thicmax=40;
		$mem_capmin=8;
		$gpu_typelist=[0,1];
		$hdd_type = ["HDD","SSD","SSHD"];
		$totalcapmin = 120; 
		$sist_sist=["Windows+Home","Windows+Pro","Windows+S","Chrome OS","macOS","Linux"]; 
		$to_search["chassis"]=1; $to_search["mdb"]=1; $to_search["cpu"]=1; $to_search["gpu"]=1;
		$to_search["hdd"]=1; $to_search["mem"]=1; $to_search["display"]=1; $to_search["sist"]=1;
		$filtercomp = array("cpu","chassis", "gpu", "mdb", "display","hdd","sist","mem");
		$set_j_ssearch="$('#s_prod_id').empty().select2(); $('#type').multiselect('select', ['1']); document.getElementById('s_dispsize').noUiSlider.reset(); $('#type').multiselect('refresh');";
		break;
	}
	case "ultraportable":
	{
		$model_minclass=0; $model_maxclass=1;
		$cpu_tdpmin = 0;
		$cpu_tdpmax = 25; 
		$mem_capmin=8;
		$gpu_typelist=[0,1];
		$display_vresmin=1080;
		$hdd_type = ["EMMC","SSD"];
		$totalcapmin = 120;
		$chassis_weightmax=2.1;
		$chassis_thicmax = 23;
		$gpu_typelist=[0,1,2];
		$sist_sist=["Windows+Home","Windows+Pro","Windows+S","Chrome OS","macOS","Linux"]; 
		$to_search["chassis"]=1; $to_search["cpu"]=1; $to_search["gpu"]=1;
		$to_search["hdd"]=1; $to_search["mem"]=1; $to_search["display"]=1; $to_search["sist"]=1;
		$filtercomp = array("cpu","chassis", "gpu", "display","hdd","sist","mem");
		$set_j_ssearch="$('#s_prod_id').empty().select2(); $('#type').multiselect('select', ['2']); document.getElementById('s_dispsize').noUiSlider.reset(); $('#type').multiselect('refresh');";
		break;
	}
	case "budget":
	{
		$model_minclass=0; $model_maxclass=1;
		$cpu_tdpmin = 0;
		$cpu_tdpmax = 15; 
		$chassis_weightmax=2.8;
		$chassis_thicmin = 16;
		$cpu_turbomax = 3.0;
		$mem_capmax=8;
		$display_vresmax=1080;
		$gpu_typelist=[0,1];
		$mdb_wwan = 1;
		$totalcapmin = 0;
		$sist_sist=["Windows+Home","Android","Windows+S","Chrome OS","No OS","Linux"]; 
		$to_search["chassis"]=1; $to_search["cpu"]=1; $to_search["gpu"]=1; $to_search["mdb"]=1;
		$to_search["mem"]=1; $to_search["display"]=1; $to_search["sist"]=1;
		$filtercomp = array("cpu","chassis", "gpu","mdb", "display","sist","mem");
		$set_j_ssearch="$('#s_prod_id').empty().select2(); $('#type').multiselect('select', ['99']); document.getElementById('s_dispsize').noUiSlider.reset(); $('#type').multiselect('refresh');";
		break;
	}
	case "business":
	{
		$model_minclass=1; $model_maxclass=4;
		$cpu_tdpmin = 4;
		$cpu_tdpmax = 45;
		$display_sizemin=13;
		$display_sizemax=17.3;
		$display_vresmin=1080;
		$chassis_weightmax=3;
		$chassis_thicmax=40;
		$gpu_powermax=30;
		$mem_capmin=8;
		$mdb_wwan = 0;
		$gpu_typelist=[0,1,3];
		$hdd_type = ["HDD","SSD","SSHD"];
		$totalcapmin = 120;
		$sist_sist=["Windows+Home","Windows+Pro","Windows+S","macOS","Linux"]; 
		$to_search["chassis"]=1; $to_search["mdb"]=1; $to_search["cpu"]=1; $to_search["gpu"]=1;
		$to_search["hdd"]=1; $to_search["mem"]=1; $to_search["display"]=1; $to_search["sist"]=1;
		$filtercomp = array("cpu","chassis", "gpu", "mdb", "display","hdd","sist","mem");
		$set_j_ssearch="$('#s_prod_id').empty().select2(); $('#type').multiselect('select', ['3']); document.getElementById('s_dispsize').noUiSlider.reset(); $('#type').multiselect('refresh');";
		break;
	}
	case "gaming":
	{
		$model_minclass=0; $model_maxclass=1;
		$cpu_tdpmin = 15;
		$cpu_tdpmax = 300;
		$display_sizemin=13;
		$display_sizemax=17.3;
		$display_vresmin=1080;
		$mem_capmin=8;
		$gpu_powermin=59;
		$gpu_typelist=[2,4];
		$mdb_wwan = 1;
		$hdd_type = ["HDD","SSD","SSHD"];
		$totalcapmin = 250;
		$chassis_thicmin = 10;
		$sist_sist=["Windows+Home","Windows+Pro","Windows+S"]; 
		$to_search["chassis"]=1; $to_search["cpu"]=1; $to_search["gpu"]=1; $to_search["mdb"]=1;
		$to_search["hdd"]=1; $to_search["mem"]=1; $to_search["display"]=1; $to_search["sist"]=1;
		$filtercomp = array("cpu","chassis", "gpu","mdb", "display","hdd","sist","mem");
		$set_j_ssearch="$('#s_prod_id').empty().select2(); $('#type').multiselect('select', ['4']); document.getElementById('s_dispsize').noUiSlider.reset(); $('#type').multiselect('refresh');";
		break;
	}
	case "professional":
	{
		$model_minclass=1; $model_maxclass=4;
		$cpu_tdpmin = 15;
		$cpu_tdpmax = 300;
		$display_sizemin=13;
		$display_sizemax=17.3;
		$display_vresmin=1080;
		$mem_capmin=8;
		$gpu_powermin=30;
		$gpu_typelist=[3];
		$mdb_wwan = 0;
		$hdd_type = ["SSD","SSHD"];
		$totalcapmin = 250;
		$chassis_thicmin = 10;
		$sist_sist=["Windows+Home","Windows+Pro"]; 
		$to_search["chassis"]=1; $to_search["cpu"]=1; $to_search["gpu"]=1; $to_search["mdb"]=1;
		$to_search["hdd"]=1; $to_search["mem"]=1; $to_search["display"]=1; $to_search["sist"]=1;
		$filtercomp = array("cpu","chassis", "gpu","mdb", "display","hdd","sist","mem");
		$set_j_ssearch="$('#s_prod_id').empty().select2(); $('#type').multiselect('select', ['5']); document.getElementById('s_dispsize').noUiSlider.reset(); $('#type').multiselect('refresh');";
		break;
	}
	case "smalldisplay":
	{
		$display_sizemin=10;
		$display_sizemax=13.9;
		$display_touch[] = "1"; $display_touch[] ="2"; 
		$to_search["display"]=1;  $to_search["sist"]=1;
		$filtercomp = array("display","sist");
		$sist_sist=["Windows+Home","Windows+Pro","Windows+S","Chrome OS","macOS","Linux","Android"];
		$set_j_ssearch="$('#s_prod_id').empty().select2(); $('#type').multiselect('select', ['99']); $('#type').multiselect('refresh'); document.getElementById('s_dispsize').noUiSlider.set([10,13.9]);";
		break;
	}
	case "mediumdisplay":
	{
		$display_sizemin=14;
		$display_sizemax=16.4;
		$display_touch[] = "1"; $display_touch[] ="2"; 
		$to_search["display"]=1; $to_search["sist"]=1;
		$filtercomp = array("display","sist");
		$sist_sist=["Windows+Home","Windows+Pro","Windows+S","Chrome OS","macOS","Linux","Android"];
		$set_j_ssearch="$('#s_prod_id').empty().select2(); $('#type').multiselect('select', ['99']); $('#type').multiselect('refresh'); document.getElementById('s_dispsize').noUiSlider.set([14,16.4]);";
		break;
	}
	case "largedisplay":
	{
		$display_sizemin=17;
		$display_sizemax=21;
		$display_touch[] = "1"; $display_touch[] ="2"; 
		$to_search["display"]=1; $to_search["sist"]=1;
		$filtercomp = array("display","sist");
		$sist_sist=["Windows+Home","Windows+Pro","Windows+S","Chrome OS","macOS","Linux","Android"];
		$set_j_ssearch="$('#s_prod_id').empty().select2(); $('#type').multiselect('select', ['99']); $('#type').multiselect('refresh'); document.getElementById('s_dispsize').noUiSlider.set([17,21]);";
		break;
	}
	case "model_name":
	{
		$mem_capmax=0;
		if(isset($_GET['keywords']) && $_GET['keywords'])
		{
			$model_name=clean_string($_GET['keywords']); $set_j_ssearch="document.getElementById('s_dispsize').noUiSlider.reset(); $('#s_prod_id').empty().select2(); $('#type').multiselect('select', ['99']); $('#type').multiselect('refresh');";
			$sist_sist=["Windows+Home","Windows+Pro","Windows+S","Chrome OS","macOS","Linux","Android"]; 
			$to_search["sist"]=1;	$filtercomp = array("sist");
			$_POST["keys"]=$model_name;
			$m_search_included=true; $relativepath="../"; $close_con=0; require_once("lib/func/m_search.php");
			foreach($m_search_included as $val){ $search_ids_model[]=intval($val["id"]); }
		}
		break;
	}
}

?>
