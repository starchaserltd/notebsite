<?php
require_once("../search/proc/init.php");
$totalcapmin=0; $totalcapmax=999999999; $nr_hdd=0;

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

$abort=0;
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
				{ 
					$result = mysqli_query($GLOBALS['con'], "SELECT id FROM `notebro_db`.`MODEL` WHERE id=".$param['model_id']." LIMIT 1");
					if($result && mysqli_num_rows($result)>0)
					{ $id_set=$param['model_id']; }
					else
					{ $response->message.=" Unable to identify model by ID, falling back to name search."; }
				}

				if(!$id_set){ $_POST["keys"]=$param['model_name']; } else { $_POST["keys"]=""; }
				$relativepath="../";      $close_con=0;      $m_search_included=1;
				require_once('../search/lib/func/m_search.php'); $nr_models=0;
				foreach($m_search_included as $el){ $comp_lists_api["model"][]["id"]=$el["id"]; $nr_models++; }
				if($nr_models>7) { $response->code=30; $response->message.=" Too many models selected, please be more specific."; $abort=1; }
				elseif($nr_models<1) { $response->code=30; $response->message.="Fatal error: Unable to identify the model by name.";  $abort=1; }
				
			}
			break;
		}
		
		case 'cpu':
		{
			if (isset($param['cpu_name']) && !empty($param['cpu_name']) && !$abort)
			{
				$param['cpu_name'] = strtoupper($param['cpu_name']);
				$result = mysqli_query($GLOBALS['con'], "SELECT name FROM notebro_site.nomen WHERE type = 11 ORDER BY type ASC");
				while( $row=mysqli_fetch_array($result)){ $cpu_prod[]=$row[0]; } 
				foreach($cpu_prod as $el){ $param['cpu_name'] = trim(str_replace($el,"",$param['cpu_name'])," "); } $cpu_prod=array();
				if($cpu_name = mysqli_fetch_row(mysqli_query($GLOBALS['con'],"SELECT model FROM notebro_db.CPU where model like '%".$param['cpu_name']."%' limit 1")))
				{ $cpu_model = $cpu_name[0]; $to_search['cpu'] = 1; }
				else
				{ $response->code=31; $response->message.=" Unable to identify the CPU by name."; }
			}
			break;
		}
		
		case 'display' :
		{
			if (isset($param['display_res'])&& !empty($param['display_res']) && !$abort)
			{	
				$display_res = $param['display_res'];
				$result_explode = explode('x', $display_res);
				$display_hresmin = intval(trim($result_explode[0]," "));
				$display_vresmin = intval(trim($result_explode[1]," "));
				if($display_hresmin>0 && $display_hresmin<50000 && $display_vresmin>0 && $display_vresmin<50000)
				{ $to_search['display'] = 1; }
				else
				{ unset($display_hresmin); unset($display_vresmin); $response->code=31; $response->message.=" Display resolution out of range.";}
			}
			if (isset($param['display_type'])&& !empty($param['display_type']) && !$abort)
			{
				$result = mysqli_query($GLOBALS['con'], "SELECT name FROM `notebro_site`.`nomen` WHERE name LIKE '%".$param['display_type']."%' AND type=10");
				if($result && mysqli_num_rows($result)>0)
				{
					while( $row=mysqli_fetch_array($result)){$display_backt[] = $row[0];}
					$to_search['display'] = 1;
				}
				else
				{ $response->code=31; $response->message.=" Unable to identify Display type.";}
			}
			if (isset($param['display_srgb'])&& !empty($param['display_srgb']) && !$abort)
			{
				$display_srgb = intval(trim($param['display_srgb'],"\x25"));
				if($display_srgb>0 && $display_srgb<100)
				{ $to_search['display'] = 1; }
				else
				{ $display_srgb=0; $response->code=31; $response->message.=" sRGB value is out of range."; }
			}
			if (isset($param['display_size_min'])&& !empty($param['display_size_min']) && !$abort)
			{
				$val=floatval($param['display_size_min']);
				if($val>0 && $val<30)
				{ $display_sizemin=$val; $to_search['display'] = 1; }
				else
				{ $response->code=31; $response->message.=" Display minimum size value is out of range."; }
			} 
			if (isset($param['display_size_max'])&& !empty($param['display_size_max']) && !$abort)
			{
				$val=floatval($param['display_size_max']);
				if($val>0 && $val<30)
				{ $display_sizemax=$val; $to_search['display'] = 1; }
				else
				{ $response->code=31; $response->message.=" Display maximum size value is out of range."; }
			} 
			break;
		}
		
		case 'mem' :
		{   
			if (isset($param['maxmem'])&& !empty($param['maxmem']) && !$abort)
			{
				$mem_capmin = intval(preg_replace("/[^0-9]+/", "",$param['maxmem']));
				if($mem_capmin>0 && $mem_capmin<1000)
				{ $to_search['mem']=1; }
				else
				{ $response->code=31; $response->message.=" Memory capacity out of range."; }
					
			}				
			break;
		}
		
		case 'hdd' :
		{
			if (isset($param['storagecap'])&& !empty($param['storagecap']) && !$abort)
			{
				$totalcapmin =intval(preg_replace("/[^0-9]+/", "",$param['storagecap']));
				if($totalcapmin>0 && $totalcapmin<100000)
				{ $to_search['hdd'] = 1; }
				else
				{ unset($totalcapmin); $response->code=31; $response->message.=" HardDrive capacity out of range."; }
			}
			if (isset($param['firsthddtype'])&& !empty($param['firsthddtype']) && !$abort)
			{
				$result = mysqli_query($GLOBALS['con'], "SELECT name FROM `notebro_site`.`nomen` WHERE type=54");
				while( $row=mysqli_fetch_array($result)){$hdd_types[] = $row[0];}
				if(in_array($param['firsthddtype'],$hdd_types))
				{ $to_search['hdd'] = 1; }
				else
				{ unset($hdd_types); $response->code=31; $response->message.=" HardDrive type unidentified."; }
			}
			break;	
		}	
		
		case 'shdd' :
		{   
			if (isset($param['secondhdd'])&& !empty($param['secondhdd']) && !$abort)
			{
				$nr_hdd=2;
				$to_search['shdd'] = 1;
			}
			break;	
		}
	
		case 'gpu' :
		{
			if (isset($param['gpu_name'])&& !empty($param['gpu_name']) && !$abort)
			{
				$result = mysqli_query($GLOBALS['con'], "SELECT name FROM notebro_site.nomen WHERE type = 12 ORDER BY type ASC");
				while( $row=mysqli_fetch_array($result)){$gpu_prod[] = $row[0]; }
				foreach($gpu_prod as $el) {	$param['gpu_name'] = trim(str_replace($el,"",$param['gpu_name'])," "); } $gpu_prod=array();
				$sql = "SELECT model FROM notebro_db.GPU where model like '%".$param['gpu_name']."%' ";
				if (stripos($param['gpu_name'],"SLI")!==FALSE) { $sql.=' AND model LIKE "%SLI%" ORDER BY rating DESC limit 1'; }
				else { $sql.=' AND model NOT LIKE "%SLI%" ORDER BY rating DESC LIMIT 1'; } 
				$gpu_name = mysqli_fetch_row(mysqli_query($GLOBALS['con'],$sql));
				if($gpu_name && count($gpu_name)>0) 
				{ $gpu_model = $gpu_name[0]; $to_search['gpu'] = 1; }
				else
				{ $response->code=31; $response->message.=" Unable to identify GPU name."; }
			}
			break;
		}
		
		case 'wnet' :
		{
			if (isset($param['wireless_name'])&& !empty($param['wireless_name']) && !$abort)
			{
				$result = mysqli_query($GLOBALS['con'], "SELECT DISTINCT prod FROM notebro_db.WNET WHERE 1=1");
				while($row=mysqli_fetch_array($result)){$wnet_prod[] = $row[0]; }
				foreach( $wnet_prod as $el){ $param['wireless_name'] = trim(str_replace($el,"",$param['wireless_name'])," "); } unset($wnet_prod);
				$wnet_model = $param['wireless_name'];
				$to_search['wnet'] = 1;
			}
			break;	
		}
		
		case 'odd' :
		{
			if (isset($param['odd_type'])&& !empty($param['odd_type']) && !$abort)
			{
				$param['odd_type']=strtoupper(str_replace(" ","%",$param['odd_type']));
				$result = mysqli_query($GLOBALS['con'], "SELECT name FROM `notebro_site`.`nomen` WHERE name LIKE '%".$param['odd_type']."%' AND type=52");
				if($result && mysqli_num_rows($result)>0)
				{
					while( $row=mysqli_fetch_array($result)){$odd_type[] = $row[0];}
					$to_search['odd'] = 1;
				}
				else { $response->code=31; $response->message.=" Unknown optical drive."; }
			}
            break;
		}
		
		case 'mdb' :
		{	
			if (isset($param['mdb_wan'])&& !empty($param['mdb_wan']) && !$abort)
			{
				switch(strtolower($param['mdb_wan']))
				{
					case "yes":
					{ $mdb_wwan=2; $to_search['mdb']=1; break; }
					case "no":
					{ $mdb_wwan=1; $to_search['mdb']=1; break; }
					default:
					{ $mdb_wwan=0;  break; }
				}
			}
			if (isset($param['mdb_gsync'])&& !empty($param['mdb_gsync']) && !$abort)
			{
				switch(strtolower($param['mdb_gsync']))
				{	
					case "yes":
					{ $mdb_misc[]="G-Sync/FreeSync"; $to_search['mdb']=1; break; }
					default:
					{ break; }
				}
			}

			if (isset($param['mdb_optimus'])&& !empty($param['mdb_optimus']) && !$abort)
			{
				switch(strtolower($param['mdb_optimus']))
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
			if (isset($param['battery_size'])&& !empty($param['battery_size'])  && !$abort)
			{
				$acum_capmin = floatval(preg_replace("/[^0-9]+/", "",$param['battery_size']));
				if($acum_capmin>0 && $acum_capmin<1000)
				{ $to_search['acum'] = 1; }
				else
				{ unset($acum_capmin); $response->code=31; $response->message.=" Battery capacity out of range."; }	
			}
			break;
		}
	
		case 'war' :
		{   
			if (isset($param['warranty_years'])&& !empty($param['warranty_years']) && !$abort)
			{
				$war_yearsmin=intval($param['warranty_years']);
				if($war_yearsmin>0 && $war_yearsmin<10)
				{ 	$to_search["war"] = 1; }
				else
				{ unset($war_yearsmin); $response->code=31; $response->message.=" Number of warranty years is out of range."; }	
			}
			if (isset($param['warranty_type'])&& !empty($param['warranty_type']))
			{
				if (strcasecmp($param['warranty_type'],"premium")===0) {$war_typewar =array(2,3,4); $to_search["war"] = 1; }
				elseif (strcasecmp($param['warranty_type'],"standard")===0) {$war_typewar = array(1); $to_search["war"] = 1;  }
				else { $response->code=31; $response->message.=" Unknown warranty type, can only be Standard or Premium."; }
			}
			break;	
		}
		
		case 'sist' :
		{
			if (isset($param['opsist'])&& !empty($param['opsist']) && !$abort)
			{
				$param['opsist']=str_replace(" ","%",$param['opsist']);
				$result = mysqli_query($GLOBALS['con'], "SELECT name FROM `notebro_site`.`nomen` WHERE name LIKE '%".$param['opsist']."%' AND type=25 LIMIT 1");
				if($result && mysqli_num_rows($result)>0)
				{
					while( $row=mysqli_fetch_array($result)){$opsist[] = $row[0];}
					$to_search['sist'] = 1;
				}
				else { $response->code=31; $response->message.=" Unknown operating system."; }
				

				if(isset($opsist[0]))
				{
					foreach($opsist as $opsist)
					{
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
					}
				}
			}	
			break ;	
		}	
	}
}
?>