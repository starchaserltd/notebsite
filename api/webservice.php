<?php 
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
$method =""; $api_key =""; $param =""; $response=new stdClass(); $response->code=999; $response->message="Unknown error."; $response->result=new stdClass(); $response->daily_hits_left=null; $single_result=0;

if(isset($_POST['method'])) { $method=$_POST['method']; } 
if(isset($_POST['apikey'])) { $api_key = $_POST['apikey']; }
if(isset($_POST['param'])) { $param = $_POST['param']; }
if($api_key!==""&&$api_key!==NULL)
{
	require_once("../etc/con_db.php");
	$api_key=mysqli_real_escape_string($con,$api_key);
	$result = mysqli_query($con,"SELECT daily_hits FROM notebro_site.api_keys WHERE api_key = '".$api_key."'");
	if($result&&mysqli_num_rows($result)>0)
	{
		$hits_left=mysqli_fetch_row($result)[0];
		if(intval($hits_left)>0)
		{
			$sql = 'UPDATE `notebro_site`.`api_keys` SET `notebro_site`.`api_keys`.`daily_hits` = `notebro_site`.`api_keys`.`daily_hits`-1 WHERE `notebro_site`.`api_keys`.`api_key` = "'.$api_key.'"';  mysqli_query($con, $sql);
			if($method!==NULL && $method!=="")
			{
				switch($method)
				{
					case "get_model_info":
					{
						$response->code=26; $response->message="Valid method.";$response->daily_hits_left=$hits_left;
						$single_result=1; $search_array=array("model","cpu", "display", "gpu", "acum", "war", "hdd", "shdd", "wnet", "sist", "odd", "mem", "mdb", "chassis"); $nr_max_models=7;
						require_once("preproc/api_varproc.php");
						require_once("lib/api_search.php");
						if(isset($idmodel[0]))
						{
							require_once("lib/model_param.php");
							$resulti = mysqli_query($GLOBALS['cons'], "SELECT * FROM notebro_temp.all_conf_".$idmodel[0]." WHERE id = ".$result['id']." LIMIT 1");
							$i=0;
							while( $row=mysqli_fetch_assoc($resulti))
							{
								$response->result->{$i}=new stdClass(); $object_addr=$response->result->{$i};
								// Model info
								$object_addr->model_info=comp_details("model_name_msearch",$row["model"]);
								$object_addr->config_id=$row["id"];
								$object_addr->model_resources=comp_details("model_res",$idmodel[0]);
								unset($object_addr->model_resources["cpu"]); unset($object_addr->model_resources["display"]); unset($object_addr->model_resources["mem"]); unset($object_addr->model_resources["hdd"]); unset($object_addr->model_resources["shdd"]);
								unset($object_addr->model_resources["gpu"]); unset($object_addr->model_resources["wnet"]); unset($object_addr->model_resources["odd"]); unset($object_addr->model_resources["mdb"]); unset($object_addr->model_resources["chassis"]);
								unset($object_addr->model_resources["acum"]); unset($object_addr->model_resources["warranty"]); unset($object_addr->model_resources["sist"]); unset($object_addr->model_resources["id"]);
								//Components
								$object_addr->cpu=comp_details("cpu",$row['cpu']); unset($object_addr->cpu["id"]); $object_addr->cpu["integrated_video_id"]==NULL;
								$object_addr->display=comp_details("display",$row['display']); unset($object_addr->display["id"]);
								$object_addr->memory=comp_details("mem",$row['mem']); unset($object_addr->memory["id"]);
								$object_addr->primary_storage=comp_details("hdd",$row['hdd']); unset($object_addr->primary_storage["id"]);
								$object_addr->secondary_storage=comp_details("hdd",$row['shdd']); unset($object_addr->secondary_storage["id"]);
								$object_addr->gpu=comp_details("gpu",$row['gpu']); unset($object_addr->gpu["id"]); unset($object_addr->gpu["typegpu"]);
								$object_addr->wireless_card=comp_details("wnet",$row['wnet']); unset($object_addr->wireless_card["id"]);
								$object_addr->optical_drive=comp_details("odd",$row['odd']); unset($object_addr->optical_drive["id"]);
								$object_addr->motherboard=comp_details("mdb",$row['mdb']); unset($object_addr->motherboard["id"]);
								$object_addr->chassis=comp_details("chassis",$row['chassis']); unset($object_addr->chassis["id"]);
								$object_addr->battery=comp_details("acum",$row['acum']); unset($object_addr->battery["id"]);
								$object_addr->warranty=comp_details("war",$row['war']); unset($object_addr->warranty["id"]);
								$object_addr->operating_system=comp_details("sist",$row['sist'])["name"];
								//OTHER CONFIG INFO
								$object_addr->config_score=strval(floatval($row["rating"])/100);
								$object_addr->config_price=strval(intval($row["price"]));
								$object_addr->config_price_min=strval(round((floatval($row["price"])-(floatval($row["err"])/2)),0));
								$object_addr->config_price_max=strval(round((floatval($row["price"])+(floatval($row["err"])/2)),0));
								$object_addr->battery_life_raw=strval(round(floatval($row["batlife"]),1));
								$hours=intval($row["batlife"]); $minutes=floatval($row["batlife"]); $minutes=intval(($minutes-floor($minutes))*60);
								$object_addr->battery_life_hours=$hours.":".sprintf("%02d", $minutes);
								$object_addr->total_storage_capacity=$row["capacity"];
								$i++;
							}
						}
						break;
					}
					case "get_model_info_all":
					{
						$response->code=26; $response->message="Valid method.";$response->daily_hits_left=$hits_left;
						$single_result=1;  $search_array=array("model","cpu", "display", "gpu", "acum", "war", "hdd", "shdd", "wnet", "sist", "odd", "mem", "mdb", "chassis"); $nr_max_models=7;
						require_once("preproc/api_varproc.php");
						require_once("lib/api_search.php");
						require_once("lib/model_param.php");
						if(isset($idmodel[0]))
						{
							$resulti = mysqli_query($GLOBALS['cons'], "SELECT * FROM notebro_temp.all_conf_".$idmodel[0]." WHERE id = ".$result['id']." LIMIT 1");
							$i=0;
							while( $row=mysqli_fetch_assoc($resulti))
							{
								$response->result->{$i}=new stdClass(); $object_addr=$response->result->{$i};
								// Model info
								$object_addr->model_info=comp_details("model_name_msearch",$row["model"]);
								$object_addr->config_id=$row["id"];
								$object_addr->model_resources=comp_details("model_res",$idmodel[0]);
								//Components
								$selected=NULL; foreach(explode(",",$object_addr->model_resources["cpu"]) as $el) { $data=comp_details("cpu",$el); $j=intval($data["id"]); unset($data["id"]); $object_addr->cpu->{$j}=$data; if(intval($row["cpu"])==$j){ $selected=$j; } }$object_addr->cpu->selected=$selected;
								$selected=NULL; $j=0; foreach(explode(",",$object_addr->model_resources["display"]) as $el) { $data=comp_details("display",$el); $j=intval($data["id"]); unset($data["id"]); $object_addr->display->{$j}=$data; if(intval($row["display"])==$j){ $selected=$j; } } $object_addr->display->selected=$selected;
								$selected=NULL; foreach(explode(",",$object_addr->model_resources["mem"]) as $el) { $data=comp_details("mem",$el); $j=intval($data["id"]); unset($data["id"]); $object_addr->memory->{$j}=$data; if(intval($row["mem"])==$j){ $selected=$j; } } $object_addr->memory->selected=$selected;
								$selected=NULL; foreach(explode(",",$object_addr->model_resources["hdd"]) as $el) { $data=comp_details("hdd",$el); $j=intval($data["id"]); unset($data["id"]); $object_addr->primary_storage->{$j}=$data; if(intval($row["hdd"])==$j){ $selected=$j; } } $object_addr->primary_storage->selected=$selected;
								$selected=NULL; foreach(explode(",",$object_addr->model_resources["shdd"]) as $el) { $data=comp_details("hdd",$el); $j=intval($data["id"]); unset($data["id"]); $object_addr->secondary_storage->{$j}=$data; if(intval($row["shdd"])==$j){ $selected=$j; } } $object_addr->secondary_storage->selected=$selected;					
								$integrated=0; $selected=NULL; foreach(explode(",",$object_addr->model_resources["gpu"]) as $el) { $data=comp_details("gpu",$el); $j=intval($data["id"]); unset($data["id"]); $object_addr->gpu->{$j}=$data; if(intval($row["gpu"])==$j){ $selected=$j; } } if(intval($object_addr->gpu->{$j}["typegpu"])==0) { $integrated=1; unset($object_addr->gpu->{$j}["typegpu"]); } $object_addr->gpu->selected=$selected; if(!$integrated){ foreach($object_addr->cpu as $key=>$el){ $object_addr->cpu->$key["integrated_video_id"]=NULL; } }
								$selected=NULL; foreach(explode(",",$object_addr->model_resources["wnet"]) as $el) { $data=comp_details("wnet",$el); $j=intval($data["id"]); unset($data["id"]); $object_addr->wireless->{$j}=$data; if(intval($row["wnet"])==$j){ $selected=$j; } } $object_addr->wireless->selected=$selected;
								$selected=NULL; foreach(explode(",",$object_addr->model_resources["odd"]) as $el) { $data=comp_details("odd",$el); $j=intval($data["id"]); unset($data["id"]); $object_addr->optical_drive->{$j}=$data; if(intval($row["odd"])==$j){ $selected=$j; } } $object_addr->optical_drive->selected=$selected;
								$selected=NULL; foreach(explode(",",$object_addr->model_resources["mdb"]) as $el) { $data=comp_details("mdb",$el); $j=intval($data["id"]); unset($data["id"]); $object_addr->motherboard->{$j}=$data; if(intval($row["mdb"])==$j){ $selected=$j; } } $object_addr->motherboard->selected=$selected;
								$selected=NULL; foreach(explode(",",$object_addr->model_resources["chassis"]) as $el) { $data=comp_details("chassis",$el); $j=intval($data["id"]); unset($data["id"]); $object_addr->chassis->{$j}=$data; if(intval($row["chassis"])==$j){ $selected=$j; } } $object_addr->chassis->selected=$selected;
								$selected=NULL; foreach(explode(",",$object_addr->model_resources["acum"]) as $el) { $data=comp_details("acum",$el); $j=intval($data["id"]); unset($data["id"]); $object_addr->battery->{$j}=$data; if(intval($row["acum"])==$j){ $selected=$j; } } $object_addr->battery->selected=$selected;
								$selected=NULL; foreach(explode(",",$object_addr->model_resources["warranty"]) as $el) { $data=comp_details("war",$el); $j=intval($data["id"]); unset($data["id"]); $object_addr->warranty->{$j}=$data; if(intval($row["war"])==$j){ $selected=$j; } } $object_addr->warranty->selected=$selected;
								$selected=NULL; foreach(explode(",",$object_addr->model_resources["sist"]) as $el) { $data=comp_details("sist",$el); $j=intval($data["id"]); unset($data["id"]); $object_addr->operating_system->{$j}=$data; if(intval($row["sist"])==$j){ $selected=$j; } } $object_addr->operating_system->selected=$selected;
								
								unset($object_addr->model_resources["cpu"]); unset($object_addr->model_resources["display"]); unset($object_addr->model_resources["mem"]); unset($object_addr->model_resources["hdd"]); unset($object_addr->model_resources["shdd"]);
								unset($object_addr->model_resources["gpu"]); unset($object_addr->model_resources["wnet"]); unset($object_addr->model_resources["odd"]); unset($object_addr->model_resources["mdb"]); unset($object_addr->model_resources["chassis"]);
								unset($object_addr->model_resources["acum"]); unset($object_addr->model_resources["warranty"]); unset($object_addr->model_resources["sist"]); unset($object_addr->model_resources["id"]);
								//OTHER CONFIG INFO
								$object_addr->config_score=strval(floatval($row["rating"])/100);
								$object_addr->config_price=strval(intval($row["price"]));
								$object_addr->config_price_min=strval(round((floatval($row["price"])-(floatval($row["err"])/2)),0));
								$object_addr->config_price_max=strval(round((floatval($row["price"])+(floatval($row["err"])/2)),0));
								$object_addr->battery_life_raw=strval(round(floatval($row["batlife"]),1));
								$hours=intval($row["batlife"]); $minutes=floatval($row["batlife"]); $minutes=intval(($minutes-floor($minutes))*60);
								$object_addr->battery_life_hours=$hours.":".sprintf("%02d", $minutes);
								$object_addr->total_storage_capacity=$row["capacity"];
								$i++;
							}
						}
						break;
					}
					case "list_models":
					{
						$response->code=26; $response->message="Valid method.";$response->daily_hits_left=$hits_left;
						$i=0; $single_result=1; $search_array=array("model"); $nr_max_models=100000; if(!isset($param['model_name'])||(isset($param['model_name'])&&$param['model_name']==NULL)){ $param['model_name']="%"; }
						require_once("preproc/api_varproc.php");
						require_once("lib/model_param.php");
						$m_search_ids_list=""; foreach($m_search_included as $el){ $m_search_ids_list.=$el["id"].","; } $m_search_ids_list=rtrim($m_search_ids_list,",");
						$list_all_model_res=comp_details("model_res",$m_search_ids_list);
						foreach($list_all_model_res as $el)
						{
							$response->result->{$i}=new stdClass(); $object_addr=$response->result->{$i};
							// Model info
							$object_addr->model_info=comp_details("model_name_msearch",$el["id"]);
							$object_addr->model_resources=$el;
							unset($object_addr->model_resources["cpu"]); unset($object_addr->model_resources["display"]); unset($object_addr->model_resources["mem"]); unset($object_addr->model_resources["hdd"]); unset($object_addr->model_resources["shdd"]);
							unset($object_addr->model_resources["gpu"]); unset($object_addr->model_resources["wnet"]); unset($object_addr->model_resources["odd"]); unset($object_addr->model_resources["mdb"]); unset($object_addr->model_resources["chassis"]);
							unset($object_addr->model_resources["acum"]); unset($object_addr->model_resources["warranty"]); unset($object_addr->model_resources["sist"]); unset($object_addr->model_resources["id"]);
							$i++;
						}
						break;
					}
					default:
					{
						$response->code=12; $response->message="Unknown method provided."; $response->daily_hits_left=$hits_left;
						break;
					}
				}
			}
			else
			{ $response->code=11; $response->message="No method provided, nothing to do."; $response->daily_hits_left=$hits_left; }
		}
		else
		{ $response->code=10; $response->message="Maximum daily queries has been exceeded. Contact site admin."; $response->daily_hits_left=$hits_left; }
	}
	else
	{ $response->code=0; $response->message="Unknown API key."; }
}
else
{ $response->code=0; $response->message="No valid API key provided."; }

echo json_encode($response);		
?>
