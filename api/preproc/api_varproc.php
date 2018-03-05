<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
echo getcwd() . "\n";

*/
// code when we have model id
require_once("../search/proc/init.php");
$totalcapmin=0; $totalcapmax=999999999; $nr_hdd=0;
/*
$param['display_type'] = "TN";
$param['cpu_name']= "Intel i7-5750"; 
$param['gpu_name']= "NVIDIA GeForce GTX 1070"; 
$param['display_srgb'] = "80%";
$param['firsthddcap'] = "2048"; 
$param['mdb_gsync'] = "0";
$param['mdb_optimus'] = "0";
$param['wireless_name'] = "Intel Wireless-AC 9260";
$param['opsist'] = "Windows 10.00";
$param['display_res'] = "1920x1080";
$param['warranty_type'] = "Premium";
$param['warranty_years'] = "2";
$param['battery_size'] = "60 Whr";
$param['odd_type'] = "NONE";
*/

//LIST OF COMPONENTS WE WILL FILTER
$to_search = array(
	"model"   => 0,
    "acum"    => 0,  
    "chassis" => 0,
    "cpu"     => 0,
    "display" => 0,
    "gpu"     => 0, 
    "hdd"     => 0,
    "mdb"     => 0,
    "mem"     => 0,
    "odd"     => 0,
    "shdd"    => 0,
    "sist"    => 0,
    "war"     => 0,
    "regions" => 0,
	"wnet"    => 0
	
);

//************WNET****************

foreach (array("model","cpu", "display", "gpu", "acum", "war", "hdd", "shdd", "wnet", "sist", "odd", "mem", "mdb", "chassis") as $v) 
{
	switch($v)
	{
		case 'model' :
		{		
			if((isset($param['model_id'])&&!empty($param['model_id']))||(isset($param['model_name'])&&!empty($param['model_name'])))
			{				
				$id_set=NULL;
				if (isset($param['model_id'])&&!empty($param['model_id'])) 
				{ $id_set=$param['model_id']; }

				if(!$id_set){ $_POST["keys"]=$param['model_name']; } else { $_POST["keys"]=""; }
				$relativepath="../";      $close_con=0;      $m_search_included=1;
				require_once('../search/lib/func/m_search.php');
				foreach($m_search_included as $el){ $comp_lists_api["model"][]["id"]=$el["id"]; }
			}
			break;
		}
		
		case 'cpu':
		{
			if (isset($param['cpu_name']) && !empty($param['cpu_name']))
			{
				$param['cpu_name'] = strtoupper($param['cpu_name']);
				$result = mysqli_query($GLOBALS['con'], "SELECT name FROM notebro_site.nomen WHERE type = 11 ORDER BY type ASC");
				while( $row=mysqli_fetch_array($result)){ $cpu_prod[]=$row[0]; } 
				foreach($cpu_prod as $el){ $param['cpu_name'] = trim(str_replace($el,"",$param['cpu_name'])," "); }	
				$cpu_name = mysqli_fetch_row(mysqli_query($GLOBALS['con'],"SELECT model FROM notebro_db.CPU where model like '%".$param['cpu_name']."%' limit 1"));
				$cpu_model = $cpu_name[0];
				$to_search['cpu'] = 1;
			}
			break;
		}
		
		case 'display' :
		{
			if (isset($param['display_res'])&& !empty($param['display_res']))
			{	
				$display_res = $param['display_res'];
				$result_explode = explode('x', $display_res);
				$display_hresmax = intval(trim($result_explode[0]," "));
				$display_vresmax = intval(trim($result_explode[1]," "));
				$to_search['display'] = 1;
			}
			if (isset($param['display_type'])&& !empty($param['display_type'])) 
			{
				$result = mysqli_query($GLOBALS['con'], "SELECT DISTINCT backt FROM notebro_db.DISPLAY WHERE backt like '%".$param['display_type']."%'");
				while( $row=mysqli_fetch_array($result)){$display_type[] = $row[0]; }
				$to_search['display'] = 1; 
			}
			if (isset($param['display_srgb'])&& !empty($param['display_srgb'])) 
			{
				$display_srgb = intval(trim($param['display_srgb'],"\x25"));
				$to_search['display'] = 1;	
			} 
			break;
		}
		
		case 'mem' :
		{   
			if (isset($param['maxmem'])&& !empty($param['maxmem']))
			{
				$mem_capmax = intval(preg_replace("/[^0-9]+/", "",$param['maxmem']));
				$to_search['mem']=1;
			}				
			break;
		}
		
		case 'hdd' :
		{
			if (isset($param['firsthddcap'])&& !empty($param['firsthddcap']))
			{
				$hdd_capmin =intval(preg_replace("/[^0-9]+/", "",$param['firsthddcap']));
				$to_search['hdd'] = 1;
			}
			break;	
		}	
		
		case 'shdd' :
		{   
			if (isset($param['secondhddcap'])&& !empty($param['secondhddcap']))
			{
				$nr_hdd=2;
				$to_search['shdd'] = 1;
			}
			break;	
		}
	
		case 'gpu' :
		{
			if (isset($param['gpu_name'])&& !empty($param['gpu_name']))
			{
				$result = mysqli_query($GLOBALS['con'], "SELECT name FROM notebro_site.nomen WHERE type = 12 ORDER BY type ASC");
				while( $row=mysqli_fetch_array($result)){$gpu_prod[] = $row[0]; }
				foreach($gpu_prod as $el) {	$param['gpu_name'] = trim(str_replace($el,"",$param['gpu_name'])," "); }	
				$sql = "SELECT model FROM notebro_db.GPU where model like '%".$param['gpu_name']."%' ";
				if (stripos($param['gpu_name'],"SLI")!==FALSE) { $sql.=' AND model LIKE "%SLI%" ORDER BY rating DESC limit 1'; }
				else { $sql.=' AND model NOT LIKE "%SLI%" ORDER BY rating DESC LIMIT 1'; } 
				$gpu_name = mysqli_fetch_row(mysqli_query($GLOBALS['con'],$sql));	
				$gpu_model = $gpu_name[0];
				$to_search['gpu'] = 1;
			}
			break;
		}
		
		case 'wnet' :
		{  
			if (isset($param['wireless_name'])&& !empty($param['wireless_type']))
			{
				$result = mysqli_query($GLOBALS['con'], "SELECT DISTINCT prod FROM notebro_db.WNET WHERE 1=1");
				while($row=mysqli_fetch_array($result)){$wnet_prod[] = $row[0]; }
				foreach( $wnet_prod as $el){ $param['wireless_name'] = trim(str_replace($el,"",$param['wireless_name'])," "); }
				$wireless_type = $param['wireless_name'];
				$to_search['wnet'] = 1;
			}
			break;	
		}
		
		case 'odd' :
		{
			if (isset($param['odd_type'])&& !empty($param['odd_type']))
			{
				$odd_type = strtoupper($param['odd_type']);
				$to_search['odd'] = 1; 
			}
            break;
		}
		
		case 'mdb' :
		{	
			if (isset($param['mdb_wan'])&& !empty($param['mdb_wan']))
			{
				switch($param['mdb_wan'])
				{
					case "yes":
					{ $mdb_wwan=2; $to_search['mdb']=1; break; }
					case "no":
					{ $mdb_wwan=1; $to_search['mdb']=1; break; }
					default:
					{ $mdb_wwan=0;  break; }
				}
			}
			if (isset($param['mdb_gsync'])&& !empty($param['mdb_gsync'])) 
			{
				switch($param['mdb_gsync'])
				{	
					case "yes":
					{ $mdb_misc[]="G-Sync/FreeSync"; $to_search['mdb']=1; break; }
					default:
					{ break; }
				}
			}

			if (isset($param['mdb_optimus'])&& !empty($param['mdb_optimus']))
			{
				switch($param['mdb_optimus'])
				{	
					case "yes":
					{ $mdb_misc[]="Optimus/Enduro"; $to_search['mdb']=1; break; }
					default:
					{ break; }
				}
			}
		}			
		case 'chassis' :
		{
			break;	
		}
		
		case 'acum' :
		{
			if (isset($param['battery_size'])&& !empty($param['battery_size']))
			{
				$acum_capmin = floatval(preg_replace("/[^0-9]+/", "",$param['battery_size']));
				$to_search['acum'] = 1;
			}
			break;
		}
	
		case 'war' :
		{   
			if (isset($param['warranty_years'])&& !empty($param['warranty_years']))
			{
				$war_yearsmin=$param['warranty_years'];
				$to_search["war"] = 1;
			}
			if (isset($param['warranty_type'])&& !empty($param['warranty_type']))
			{
				if ($param['warranty_type'] = "Premium") {$war_typewar =array(2,3,4); }
				else if ($param['warranty_type'] = "Standard") {$war_typewar = array(1); }
				$to_search["war"] = 1; 
			}
			break;	
		}
		
		case 'sist' :
		{
			if (isset($param['opsist'])&& !empty($param['opsist']))
			{
				$opsist	= $param['opsist'];
				$sist_parts=explode(" ",$opsist);
				
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
				$to_search["sist"] = 1;
			}	
			break ;	
		}	
	}
}
?>