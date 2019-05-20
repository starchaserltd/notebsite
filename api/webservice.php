<?php 
$method =""; $api_key =""; $param =""; $response=new stdClass(); $response->code=999; $response->message="Unknown error."; $response->result=new stdClass(); $response->daily_hits_left=null; $single_result=0;

$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
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
								$hours=intval($row["batlife"]); $minutes=floatval($row["batlife"]); $minutes=intval(intval(($minutes-floor($minutes))*60)/5)*5;
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
								$hours=intval($row["batlife"]); $minutes=floatval($row["batlife"]); $minutes=intval(intval(($minutes-floor($minutes))*60)/5)*5;
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
					case "get_conf_info":
					{
						$response->code=26; $response->message="Valid method.";$response->daily_hits_left=$hits_left;
						require_once("../etc/con_sdb.php"); $abort=0; $object_addr=$response->result;
						if(isset($param['conf_id'])&&$param['conf_id']!=NULL)
						{
							$param['conf_id']=mysqli_real_escape_string($con,$param['conf_id']);
							$result=mysqli_query($cons,"SELECT model FROM `notebro_temp`.`all_conf` WHERE id=".$param['conf_id']." LIMIT 1");
							if($result && mysqli_num_rows($result)>0)
							{
								$model_id=mysqli_fetch_assoc($result)["model"];
								$result=mysqli_query($cons,"SELECT model,rating,price,err,batlife,capacity FROM notebro_temp.all_conf_".$model_id." WHERE id=".$param['conf_id']." LIMIT 1");
								$row=mysqli_fetch_assoc($result);
							}
							else
							{ $response->code=29; $response->message.=" Unable to retrieve data by configuration id, falling back to component search."; }
						}
						else
						{
							$response->code=29; $response->message.=" No valid configuration id provided, falling back to component search."; $abort=0;
							if(!$abort){ if(isset($param['model_id']) && $param['model_id']!=NULL && $param['model_id']!=""){ $model_id=intval($param['model_id']); } else { $response->code=28; $response->message.=" Fatal error: No model id provided."; $abort=1; } }
							if(!$abort){ if(isset($param['cpu_id']) && $param['cpu_id']!=NULL && $param['cpu_id']!=""){ $cpu_id=intval($param['cpu_id']); } else { $response->code=28; $response->message.=" Fatal error: No processor id provided."; $abort=1; } }
							if(!$abort){ if(isset($param['display_id']) && $param['display_id']!=NULL && $param['display_id']!=""){ $display_id=intval($param['display_id']); } else { $response->code=28; $response->message.=" Fatal error: No display id provided."; $abort=1; } }
							if(!$abort){ if(isset($param['memory_id']) && $param['memory_id']!=NULL && $param['memory_id']!=""){ $mem_id=intval($param['memory_id']); } else { $response->code=28; $response->message.=" Fatal error: No memory id provided."; $abort=1; } }
							if(!$abort){ if(isset($param['primary_storage_id']) && $param['primary_storage_id']!=NULL && $param['primary_storage_id']!=""){ $hdd_id=intval($param['primary_storage_id']); } else { $response->code=28; $response->message.=" Fatal error: No primary storage id provided."; $abort=1; } }
							if(!$abort){ if(isset($param['secondary_storage_id']) && $param['secondary_storage_id']!=NULL && $param['secondary_storage_id']!=""){ $shdd_id=intval($param['secondary_storage_id']); } else { $response->code=28; $response->message.=" Fatal error: No secondary storage id provided."; $abort=1; } }
							if(!$abort){ if(isset($param['gpu_id']) && $param['gpu_id']!=NULL && $param['gpu_id']!=""){ $gpu_id=intval($param['gpu_id']); } else { $response->code=28; $response->message.=" Fatal error: No graphics id provided."; $abort=1; } }
							if(!$abort){ if(isset($param['wireless_id']) && $param['wireless_id']!=NULL && $param['wireless_id']!=""){ $wnet_id=intval($param['wireless_id']); } else { $response->code=28; $response->message.=" Fatal error: No wireless id provided."; $abort=1; } }
							if(!$abort){ if(isset($param['optical_drive_id']) && $param['optical_drive_id']!=NULL && $param['optical_drive_id']!=""){ $odd_id=intval($param['optical_drive_id']); } else { $response->code=28; $response->message.=" Fatal error: No optical drive id provided."; $abort=1; } }
							if(!$abort){ if(isset($param['motherboard_id']) && $param['motherboard_id']!=NULL && $param['motherboard_id']!=""){ $mdb_id=intval($param['motherboard_id']); } else { $response->code=28; $response->message.=" Fatal error: No motherboard id provided."; $abort=1; } }
							if(!$abort){ if(isset($param['chassis_id']) && $param['chassis_id']!=NULL && $param['chassis_id']!=""){ $chassis_id=intval($param['chassis_id']); } else { $response->code=28; $response->message.=" Fatal error: No chassis id provided."; $abort=1; } }
							if(!$abort){ if(isset($param['battery_id']) && $param['battery_id']!=NULL && $param['battery_id']!=""){ $acum_id=intval($param['battery_id']); } else { $response->code=28; $response->message.=" Fatal error: No battery id provided."; $abort=1; } }
							if(!$abort){ if(isset($param['warranty_id']) && $param['warranty_id']!=NULL && $param['warranty_id']!=""){ $war_id=intval($param['warranty_id']); } else { $response->code=28; $response->message.=" Fatal error: No warranty id provided."; $abort=1; } }
							if(!$abort){ if(isset($param['operating_system_id']) && $param['operating_system_id']!=NULL && $param['operating_system_id']!=""){ $sist_id=intval($param['operating_system_id']); } else { $response->code=28; $response->message.=" Fatal error: No operating system id provided."; $abort=1; } }
							if(!$abort)
							{
								$result=mysqli_query($cons,"SELECT model,rating,price,err,batlife,capacity FROM notebro_temp.all_conf_".$model_id." WHERE model=".$model_id." AND cpu=".$cpu_id." AND display=".$display_id." AND mem=".$mem_id." AND hdd=".$hdd_id." AND shdd=".$shdd_id." AND gpu=".$gpu_id." AND wnet=".$wnet_id." AND odd=".$odd_id." AND mdb=".$mdb_id." AND chassis=".$chassis_id." AND acum=".$acum_id." AND war=".$war_id." AND sist=".$sist_id." LIMIT 1");
								if(!($result && mysqli_num_rows($result)>0))
								{
									$result=mysqli_query($con,"SELECT typegpu FROM `notebro_db`.`GPU` WHERE id=".$gpu_id." LIMIT 1");
									if($result && mysqli_num_rows($result)>0)
									{
										if(intval(mysqli_fetch_assoc($result)["typegpu"])===0)
										{
											$result=mysqli_query($con, "SELECT gpu FROM `notebro_db`.`CPU` WHERE id=".$cpu_id." LIMIT 1");
											$cpugpu=intval(mysqli_fetch_assoc($result)["gpu"]);
											if($cpugpu!==$gpu_id)
											{	
												$gpu_id=$cpugpu; $response->code=29; $response->message.=" Wrong GPU id provided, attempting to correct.";
												$result=mysqli_query($cons,"SELECT model,rating,price,err,batlife,capacity FROM notebro_temp.all_conf_".$model_id." WHERE model=".$model_id." AND cpu=".$cpu_id." AND display=".$display_id." AND mem=".$mem_id." AND hdd=".$hdd_id." AND shdd=".$shdd_id." AND gpu=".$gpu_id." AND wnet=".$wnet_id." AND odd=".$odd_id." AND mdb=".$mdb_id." AND chassis=".$chassis_id." AND acum=".$acum_id." AND war=".$war_id." AND sist=".$sist_id." LIMIT 1");
												if($result && mysqli_num_rows($result)>0)
												{
													$response->message.=" GPU correction successful.";
													$row=mysqli_fetch_assoc($result);	
												}
												else { $response->code=28; $response->message.=" Error: No configuration available with specified component ids."; $abort=1; }		
											}
											else { $response->code=28; $response->message.=" Error: No configuration available with specified component ids."; $abort=1; }		
										}
										else { $response->code=28; $response->message.=" Error: No configuration available with specified component ids."; $abort=1; }
									}
									else { $response->code=28; $response->message.=" Fata error: No video card found with provided gpu id"; $abort=1; }
								}
								else { $row=mysqli_fetch_assoc($result); }	
							}
						}
						if(!(isset($row)&&isset($row["price"]))) { $response->code=29; $response->message.=" Unable to retrive data"; $abort=1; }
						if(!$abort)
						{
							$object_addr->model_id=strval($row["model"]);
							$object_addr->config_score=strval(floatval($row["rating"])/100);
							$object_addr->config_price=strval(intval($row["price"]));
							$object_addr->config_price_min=strval(round((floatval($row["price"])-(floatval($row["err"])/2)),0));
							$object_addr->config_price_max=strval(round((floatval($row["price"])+(floatval($row["err"])/2)),0));
							$object_addr->battery_life_raw=strval(round(floatval($row["batlife"]),1));
							$hours=intval($row["batlife"]); $minutes=floatval($row["batlife"]); $minutes=intval(intval(($minutes-floor($minutes))*60)/5)*5;
							$object_addr->battery_life_hours=$hours.":".sprintf("%02d", $minutes);
							$object_addr->total_storage_capacity=$row["capacity"];
						}
						break;
					}
					case "get_exact_conf_info":
					{
						$response->code=26; $response->message="Valid method.";$response->daily_hits_left=$hits_left;
						require_once("../etc/con_sdb.php"); $abort=0; $object_addr=$response->result;
						$single_result=1; $search_array=array("model","cpu", "display", "gpu", "acum", "war", "hdd", "shdd", "wnet", "sist", "odd", "mem", "mdb", "chassis"); $nr_max_models=7;
						if(isset($param['conf_id'])&&$param['conf_id']!=NULL)
						{
							$param['conf_id']=mysqli_real_escape_string($cons,$param['conf_id']);
							$result=mysqli_query($cons,"SELECT model FROM `notebro_temp`.`all_conf` WHERE id=".$param['conf_id']." LIMIT 1");
							if($result && mysqli_num_rows($result)>0)
							{
								$model_id=mysqli_fetch_assoc($result)["model"];
								$result=mysqli_query($cons,"SELECT * FROM notebro_temp.all_conf_".$model_id." WHERE id=".$param['conf_id']." LIMIT 1");
								$row=mysqli_fetch_assoc($result);
								$search_array=array("model"); $param['model_id']=$model_id; $nr_models=1;
								require_once("preproc/api_varproc.php");
								require_once("lib/model_param.php");
								// Model info
								$object_addr->model_info=comp_details("model_name_msearch",$row["model"]);
								$object_addr->config_id=$row["id"];
								$object_addr->model_resources=comp_details("model_res",$row["model"]);
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
								$hours=intval($row["batlife"]); $minutes=floatval($row["batlife"]); $minutes=intval(intval(($minutes-floor($minutes))*60)/5)*5;
								$object_addr->battery_life_hours=$hours.":".sprintf("%02d", $minutes);
								$object_addr->total_storage_capacity=$row["capacity"];
							}
							else
							{ $response->code=29; $response->message.=" Unable to retrieve data by configuration id"; }
						}
						else
						{ $response->code=28; $response->message.=" No valid configuration id provided."; }
						break;
					}
					case "get_exchange_rates":
					{
						$response->code=26; $response->message="Valid method.";$response->daily_hits_left=$hits_left;
						$abort=0; $object_addr=$response->result;
						if(isset($param['exchange_code'])&&$param['exchange_code']!==NULL&&$param['exchange_code']!=="")
						{
							$param['exchange_code']=mysqli_real_escape_string($con,$param['exchange_code']);
							$get_code=" WHERE code='".$param['exchange_code']."'";
							$result=mysqli_query($con,"SELECT code FROM `notebro_site`.`exchrate`".$get_code." LIMIT 1");
							if(!($result && mysqli_num_rows($result)>0)){ $get_code="";  $response->message.=" Invalid exchange_code, retrieving full list."; }
						}
						else { $get_code=""; }

						$result=mysqli_query($con,"SELECT code,convr,sign FROM `notebro_site`.`exchrate`".$get_code);
						if($result && mysqli_num_rows($result)>0)
						{
							$i=0;
							while($row=mysqli_fetch_assoc($result))
							{
								$response->result->{$i}=new stdClass(); $object_addr=$response->result->{$i};
								$object_addr->exchange_code=$row["code"];
								$object_addr->exchange_rate=$row["convr"];
								$object_addr->exchange_sign=$row["sign"];
								$i++;
							}
						}
						else
						{ $response->code=29; $response->message.=" Database is inaccessible."; }
						break;
					}
					case "get_optimal_configs":
					{
						require_once("../libnb/php/api_access.php");
						
						$response->code=26; $response->message="Valid method.";$response->daily_hits_left=$hits_left;
						$abort=0; $object_addr=$response->result;
						if(isset($param['model_id'])&&$param['model_id']!==NULL&&$param['model_id']!=="")
						{
							$model_id=intval($param['model_id']); $org_model_id=$model_id;
							if(isset($param['region'])){ $region_id=strval(intval($param['region'])); }else{ $region_id=""; }
							if(isset($param['pmodel'])){ $for_pmodel=intval($param['pmodel']); }else{ $for_pmodel=0; }							
							
							require_once("../etc/con_sdb.php");
							
							$no_p_model=False;
							if($for_pmodel)
							{
								$get_pmodel=mysqli_query($cons,'SELECT `m_map_table`.`pmodel` FROM `notebro_temp`.`m_map_table` WHERE `m_map_table`.`model_id`="'.$model_id.'" LIMIT 1');
								if($get_pmodel && mysqli_num_rows($get_pmodel)>0)
								{
									$pmodel=mysqli_fetch_assoc($get_pmodel)["pmodel"];
									$result=mysqli_query($cons,'SELECT * FROM `notebro_temp`.`best_low_opt` WHERE `best_low_opt`.`id_model` LIKE "%p_'.$pmodel.'_'.$region_id.'" LIMIT 1');
									if(!($result && mysqli_num_rows($result)>0))
									{ $no_p_model=True; }
									else
									{ $model_id='%p_'.$pmodel.'_'.$region_id;}
									mysqli_free_result($get_pmodel);
								}
								else
								{ $no_p_model=True;}
							
								if($no_p_model)
								{ $result=mysqli_query($cons,'SELECT * FROM `notebro_temp`.`best_low_opt` WHERE `best_low_opt`.`id_model`="'.$model_id.'_'.$region_id.'" LIMIT 1'); }
							}
							else
							{ $no_p_model=True; $result=mysqli_query($cons,"SELECT * FROM `notebro_temp`.`best_low_opt` WHERE `id_model`='".$model_id."_".$region_id."' LIMIT 1"); }
						
							if(!($result && mysqli_num_rows($result)>0))
							{ $model_id=$org_model_id; $result=mysqli_query($cons,"SELECT * FROM `notebro_temp`.`best_low_opt` WHERE `id_model` LIKE '%".$model_id."%' LIMIT 1"); }

							if(!($result && mysqli_num_rows($result)>0)){$response->code=29; $response->message.=" Invalid model id or database is inaccesible, aborting."; }
							else
							{
								while($row=mysqli_fetch_assoc($result))
								{
									$response->result->{$org_model_id}=new stdClass(); $object_addr=$response->result->{$org_model_id};
									if(!$no_p_model){ $explode_result=explode("_",$row['lowest_price']); $row['lowest_price']=$explode_result[0]; $model_id=$explode_result[1];}
									$query="SELECT price FROM notebro_temp.all_conf_".$model_id." WHERE id=".$row['lowest_price'];
									$result_sdb=mysqli_query($cons,$query);
									if($result_sdb && mysqli_num_rows($result_sdb)>0){ $row_sdb=mysqli_fetch_assoc($result_sdb); $object_addr->lowest_price_id=$row['lowest_price']; $object_addr->lowest_price=$row_sdb['price'];}
									else
									{ $response->code=30; $response->message.=" Unable to retrieve data for ".'lowest price id'; }
									if(!$no_p_model){ $explode_result=explode("_",$row['best_performance']); $row['best_performance']=$explode_result[0]; $model_id=$explode_result[1];}
									$query="SELECT price FROM notebro_temp.all_conf_".$model_id." WHERE id=".$row['best_performance'];
									$result_sdb=mysqli_query($cons,$query);
									if($result_sdb && mysqli_num_rows($result_sdb)>0){ $row_sdb=mysqli_fetch_assoc($result_sdb); $object_addr->best_performance_id=$row['best_performance']; $object_addr->best_performance=$row_sdb['price'];}
									else
									{ $response->code=30; $response->message.=" Unable to retrieve data for ".'best performance id'; }
									if(!$no_p_model){ $explode_result=explode("_",$row['best_value']); $row['best_value']=$explode_result[0]; $model_id=$explode_result[1];}
									$query="SELECT price FROM notebro_temp.all_conf_".$model_id." WHERE id=".$row['best_value'];
									$result_sdb=mysqli_query($cons,$query);
									if($result_sdb && mysqli_num_rows($result_sdb)>0){ $row_sdb=mysqli_fetch_assoc($result_sdb); $object_addr->best_value_id=$row['best_value']; $object_addr->best_value=$row_sdb['price'];}
									else
									{ $response->code=30; $response->message.=" Unable to retrieve data for ".'best value id'; }
								}
							}
						}
						else
						{ $response->code=28; $response->message.=" No valid configuration id provided."; }
						break;
					}
					default:
					{
						$response->code=12; $response->message="Unknown method provided."; $response->daily_hits_left=$hits_left;
						break;
					}
				}
			}
			else { $response->code=11; $response->message="No method provided, nothing to do."; $response->daily_hits_left=$hits_left; }
		}
		else { $response->code=10; $response->message="Maximum daily queries has been exceeded. Contact site admin."; $response->daily_hits_left=$hits_left; }
	}
	else { $response->code=0; $response->message="Unknown API key."; }
}
else { $response->code=0; $response->message="No valid API key provided."; }
echo json_encode($response);		
?>