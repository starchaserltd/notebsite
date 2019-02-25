<?php
if(!isset($any_conf_search)){$any_conf_search=false;} if(!isset($change_model_region)){$change_model_region=false;} if(!isset($try_for_exact_model)){$try_for_exact_model=false;}
if(isset($include_getconf)){$include_getconf=true; $getall=true; $c=true; if(!isset($conf_only_search)){$conf_only_search=false;} }
else
{
	$include_getconf=false; $conf_only_search=false; $warnotin=""; $getall=false;
	if(isset($_GET['c'])){ $c=preg_replace('~[\x00\x0A\x0D\x1A\x22\x27\x5C]~u', '\\\$0', filter_var($_GET['c'],FILTER_SANITIZE_STRING)); if(stripos($c,"undefined")===FALSE){ $conf=explode("-",$c);} else {$c=0;} } else {$conf=array(); $c=0;}
	if(isset($_GET['comp'])){ $comp=preg_replace('~[\x00\x0A\x0D\x1A\x22\x27\x5C]~u', '\\\$0', filter_var($_GET['comp'],FILTER_SANITIZE_STRING)); if(stripos($comp,"undefined")!==FALSE){ $comp=NULL; } }
	if(isset($_GET['cf'])&&($_GET['cf']!="undefined")){ $cf=floatval($_GET['cf']); } else {$cf=0;} /* config rating */
	if(isset($_GET['ex'])){ $excode=preg_replace('~[\x00\x0A\x0D\x1A\x22\x27\x5C]~u', '\\\$0', filter_var($_GET['ex'],FILTER_SANITIZE_STRING)); if(stripos($excode,"undefined")!==FALSE){ $excode="USD"; } }
}
$get_best_low_func=false;
if($c)
{
	$rows=array(); $rows["cmodel"]=$conf[0]; $rows["newregion"]=false; if(!$include_getconf){ require("../../../../etc/con_sdb.php"); require("../../../../etc/session.php"); } $result=FALSE; $rows["cid"]=0;
	require_once("get_best_low.php");
	if(!$change_model_region){ $change_model_region=!model_in_region($cons,$conf[0],$excode); }
	if($getall){$all="*,";}else{$all="";} if(!isset($conf[1])){for($i=1;$i<14;$i++){if(!isset($conf[$i])){$conf[$i]="";}}}
	$sql="SELECT ".$all."id,price,model,err FROM notebro_temp.all_conf_".$conf[0]." WHERE model=".$conf[0]." AND cpu=".$conf[1]." AND display=".$conf[2]." AND mem=".$conf[3]." AND hdd=".$conf[4]." AND shdd=".$conf[5]." AND gpu=".$conf[6]." AND wnet=".$conf[7]." AND odd=".$conf[8]." AND mdb=".$conf[9]." AND chassis=".$conf[10]." AND acum=".$conf[11]." AND war".$warnotin." IN (".$conf[12].") AND sist=".$conf[13]." LIMIT 1";

	//Don't do the primary search when we need to change the region or exchange rate
	if(!$change_model_region&&$comp!="EXCH"){$result=mysqli_query($cons,$sql);}
	$retry=0; $exclude_war=array(); $current_region=[0]; $rows["exch"]=$excode; if(!isset($cf)){$cf=-1;} $region=[-1]; $no_avb_search=true; $only_exch_regions=false; $confdata=array();

	if($result!==FALSE)
	{
		$confdata = mysqli_fetch_array($result);
		if(intval($confdata["price"])>0)
		{
			$rows["cid"]=$confdata["id"];
			$rows["cprice"]=$confdata["price"];
			$rows["cerr"]=$confdata["err"];
			if($getall){$rows["all"]=$confdata;}
		}
		else { $retry=1; }
	}
	else { $retry=1; }

	if($retry)
	{
		$filter="";
		if($cf!==-1)
		{
			switch($comp)
			{
				case "CPU":	{ $filter="cpu=".$conf[1]; break; }
				case "DISPLAY": { $filter="display=".$conf[2]; break; }
				case "MEM": { $filter="mem=".$conf[3]; $no_avb_search=false; break; }
				case "HDD":	{ $filter="hdd=".$conf[4]; $no_avb_search=false; break; }
				case "SHDD": { $filter="shdd=".$conf[5]; $no_avb_search=false; break; }
				case "GPU":	{ $filter="gpu=".$conf[6]; break; } 
				case "WNET": { $filter="wnet=".$conf[7]; $no_avb_search=false; break; } 
				case "ODD":	{ $filter="odd=".$conf[8]; $no_avb_search=false; break; } 
				case "MDB":	{ $filter="mdb=".$conf[9]; break; } 
				case "CHASSIS": { $filter="chassis=".$conf[10]; break; } 
				case "ACUM": { $filter="acum=".$conf[11]; $no_avb_search=false; break; } 
				case "WAR":	{ $filter="war=".$conf[12]; $no_avb_search=false; break; }  
				case "SIST": { $filter="sist=".$conf[13]; $no_avb_search=false; break; }
				case "EXCH": { $filter="1=1"; $change_model_region=true; $only_exch_regions=true; break; }
				default: { $filter="1=1"; break; }
			}
		}
		
		/*GET regions of interest and warranty limitations based exchange rate.*/
		$found_excode=false; $ex_regions_gc=array();
		$ex_result=mysqli_query($cons,"SELECT ex,regions,ex_war FROM `notebro_temp`.`ex_map_table`"); 
		if($ex_result)
		{
			while($row=mysqli_fetch_row($ex_result))
			{
				$ex_regions_gc[$row[0]]=explode(",",$row[1]);
				if($excode==$row[0])
				{
					$found_excode=true;
					if(isset($row[1])&&$row[1]!=NULL&&$row[1]!="")
					{ $region=$ex_regions_gc[$row[0]]; }
					else
					{ $region=[-1]; }
					$current_ex_region=$region;
					if(isset($row[2])&&$row[2]!=NULL&&$row[2]!="")
					{ $exclude_war=explode(",",$row[2]); }
					else
					{ $exclude_war=array(); }
				}
			}
			mysqli_free_result($ex_result);
		}
		if(!$found_excode){ $region=[-1];  $exclude_war=array();}
			
		/*Do a search only for models in the current currency region.*/
		if(!$any_conf_search&&!$change_model_region)
		{ $rows=search_valid_config(array($conf[0]),$conf[1],$conf[2],$conf[3],$conf[4],$conf[5],$conf[6],$conf[7],$conf[8],$conf[9],$conf[10],$conf[11],$conf[12],$conf[13],$filter,$cf,$current_region,$exclude_war); }
		if($rows["cid"]==0 && !$conf_only_search)
		{
			$result=mysqli_query($cons,"SELECT * FROM `notebro_temp`.`m_map_table` WHERE `model_id`=".$conf[0]." LIMIT 1");
			if($result!==FALSE&&mysqli_num_rows($result)>0)
			{
				$m_map=mysqli_fetch_assoc($result);
				foreach($m_map as $key=>$el)
				{
					if(($only_exch_regions&&!(in_array($key,$current_ex_region)))&&(strval($key)!="0"))
					{ unset($m_map[$key]);}
					elseif((!$no_avb_search)&&(strval($key)=="0")){ unset($m_map[$key]);}
					elseif((isset($el)&&($el!=NULL)&&($el!="")&&strval($key)!="model_id"&&strval($key)!="show_smodel"))
					{
						 $m_map[$key]=explode(",",$el);
						 if(!$any_conf_search&&!$change_model_region)
						 {
							//DELETE model that was searched by default, does not apply when doing search by model id or when there is a regional change
							foreach($m_map[$key] as $key2=>$el2)
							{ if($el2==$conf[0]){$current_region=[$key]; if(!$only_exch_regions){unset($m_map[$key][$key2]);} } }
						 }
					}
					else
					{ unset($m_map[$key]); }
				}

				$models_in_region=array();
				foreach($region as $el)
				{
					if(isset($m_map[$el]))
					{ $models_in_region=array_merge($models_in_region,$m_map[$el]); unset($m_map[$el]); }
				}
				if(count($models_in_region)>0)
				{
					if(!$any_conf_search)
					{ $rows=search_valid_config($models_in_region,$conf[1],$conf[2],$conf[3],$conf[4],$conf[5],$conf[6],$conf[7],$conf[8],$conf[9],$conf[10],$conf[11],$conf[12],$conf[13],$filter,$cf,$region,$exclude_war);}
					else /* First search in the model selected, then in all models in the region*/
					{ if($try_for_exact_model){ $rows=search_any_config(array($conf[0]),$exclude_war); } if($rows["cid"]==0){ $rows=search_any_config($models_in_region,$exclude_war); } }
					/*If warranty limitations prevented finding a valid configuration, try to search again without the warranty limitations.*/
					if($rows["cid"]==0&&$rows["invalid_ex_war"]){if(!$any_conf_search){$rows=search_valid_config($models_in_region,$conf[1],$conf[2],$conf[3],$conf[4],$conf[5],$conf[6],$conf[7],$conf[8],$conf[9],$conf[10],$conf[11],$conf[12],$conf[13],$filter,$cf,$region,array());}else{$rows=search_any_config($models_in_region,array());}}
				}

				if($rows["cid"]==0)
				{
					$exclude_war=array(); $region=array(); $models_in_region=array();
					foreach($m_map as $key=>$el)
					{
						$models_in_region=array_merge($models_in_region,$m_map[$key]); array_push($region,$key);
						unset($m_map[$key]);
					}
					
					if(count($models_in_region)>0)
					{
						/*If so far we haven not found anything, we try another search for whatever models and regions are left*/
						if(!$any_conf_search)
						{$rows=search_valid_config($models_in_region,$conf[1],$conf[2],$conf[3],$conf[4],$conf[5],$conf[6],$conf[7],$conf[8],$conf[9],$conf[10],$conf[11],$conf[12],$conf[13],$filter,$cf,$region,$exclude_war); }
						else
						{$rows=search_any_config($models_in_region,$exclude_war);}
					}
					mysqli_free_result($result);
				}
			}
		}
	}

	/* If a new model was selected, we need the new model data */
	if($conf[0]!=$rows["cmodel"])
	{	
		if(!$include_getconf){ require_once("../../../../etc/con_db.php"); $extra_model_sql=""; }else{$extra_model_sql="`model`.`prod`, `families`.`fam`, `families`.`subfam`, `families`.`showsubfam`, `model`.`model`,`model`.`submodel`,`model`.`keywords`,";}
		$result_model=mysqli_query($con,"SELECT ".$extra_model_sql."`model`.`regions`,`model`.`p_model` FROM `notebro_db`.`MODEL` model JOIN `notebro_db`.`FAMILIES` families ON `model`.`idfam`=`families`.`id` WHERE `model`.`id`=".$rows["cmodel"]." LIMIT 1");
		if($result_model&&mysqli_num_rows($result_model)>0)
		{
			$model_data=mysqli_fetch_array($result_model); $_SESSION['model']=$rows["cmodel"];
			if($include_getconf)
			{
				$rows["mprod"]=$model_data["prod"]; if(isset($model_data["subfam"])&&$model_data["showsubfam"]!=0){ $model_data["subfam"]=" ".$model_data["subfam"]; } else { $model_data["subfam"]=""; } $rows["mfam"]=$model_data["fam"].$model_data["subfam"]; $rows["mmodel"]=$model_data["model"]; $rows["msubmodel"]=$model_data["submodel"];
			}
			$rows["mregion_id"]=explode(",",$model_data['regions']); 
			if(array_search("1",$rows["mregion_id"])===FALSE){ foreach($ex_regions_gc as $key=>$el){ foreach($rows["mregion_id"] as $el2){ if(in_array($el2,$el)){if(in_array($el2,$current_ex_region)){$rows["exch"]=$excode;}else{$rows["exch"]=$key;} break 2;}}} if($include_getconf){ $resu=mysqli_fetch_array(mysqli_query($con,"SELECT `disp` FROM `notebro_db`.`REGIONS` WHERE `id`=".$rows["mregion_id"][0]." LIMIT 1")); $rows["mregion"]=$resu["disp"];} $rows["buy_regions"]=$model_data['regions']; } else { $rows["exch"]="USD"; $rows["mregion"]=""; $rows["buy_regions"]=0; }
			mysqli_free_result($result_model);
			$get_best_low_func=true;
		}
		else
		{ $rows["cmodel"]=$GLOBALS["conf"][0]; $rows["submodel"]=null; }
	}
	else
	{ if($change_model_region||$comp=="EXCH"){$get_best_low_func=true;} }

	/* Here we get the best configurations from the temporary database */
	if($get_best_low_func&&isset($rows["cmodel"])&&$rows["cmodel"]!=null&&$rows["cmodel"]!=0&&isset($current_ex_region))
	{ $rows["best_low"]=get_best_low($cons,$current_ex_region,$rows["cmodel"]); }
	
	if(!$include_getconf){ mysqli_close($cons); }
	if($only_exch_regions){$rows["exch"]=$excode; $_SESSION['exchcode']=$rows["exch"]; $_SESSION['exchcode_change']=true;}
	if(!$include_getconf){ print json_encode($rows);}
}
else
{ if(!$include_getconf){header('X-PHP-Response-Code: 204', true, 204);} }

function search_valid_config($models,$cpu,$display,$mem,$hdd,$shdd,$gpu,$wnet,$odd,$mdb,$chassis,$acum,$war,$sist,$filter,$cf,$s_regions,$exclude_war)
{
	$run=7; $war_to_exclude=false; if(count($exclude_war)>0){ $run++; $war_to_exclude=true; $exclude_war="AND war NOT IN (".implode(",",$exclude_war).")";}else{ $exclude_war=""; } 
	$filter_complete=" AND (1=1 AND cpu=".$cpu." AND display=".$display." AND hdd=".$hdd." AND mem=".$mem." AND gpu=".$gpu." AND sist=".$sist.") ".$exclude_war; $fcount=0;
	$filter_complete=str_replace(" AND ".$filter,"",$filter_complete,$fcount); if($fcount){$run--;} $cons=$GLOBALS['cons']; $confdata=null; $rows["invalid_ex_war"]=false; $osrun=2;
	
	while($run>0)
	{
		$sql="";
		foreach($models as $key=>$model)
		{ $sql.="(SELECT * FROM `notebro_temp`.`all_conf_".$model."` WHERE model=".$model." AND ".$filter.$filter_complete." AND price>0 AND value>=".$cf." ORDER BY value asc LIMIT 1) UNION (SELECT * FROM notebro_temp.all_conf_".$model." WHERE model=".$model." AND ".$filter.$filter_complete." AND price>0 AND value<".$cf." ORDER BY VALUE desc LIMIT 1) UNION "; }
		$sql=substr($sql, 0, -6); $sql.="ORDER BY abs(value - ".$cf.") LIMIT 1";
		$result = mysqli_query($cons,$sql);
		
		if($result!==FALSE&&mysqli_num_rows($result)>0)
		{
			$confdata=mysqli_fetch_assoc($result);
			$rows["cid"]=$confdata["id"]; $rows["cprice"]=$confdata["price"]; $rows["cerr"]=$confdata["err"]; $rows["cmodel"]=$confdata["model"]; $a=array();
			if(intval($cpu)!=intval($confdata["cpu"])){ $a[]="processor"; $rows["changes"]["CPU"]=intval($confdata["cpu"]); } if(intval($display)!=intval($confdata["display"])){ $a[]="display"; $rows["changes"]["DISPLAY"]=intval($confdata["display"]); } if(intval($mem)!=intval($confdata["mem"])){ $a[]="memory"; $rows["changes"]["MEM"]=intval($confdata["mem"]); } if(intval($hdd)!=intval($confdata["hdd"])){ $a[]="hard drive"; $rows["changes"]["HDD"]=intval($confdata["hdd"]); }
			if(intval($shdd)!=intval($confdata["shdd"])){ $a[]="secondary hard drive"; $rows["changes"]["SHDD"]=intval($confdata["shdd"]); } if(intval($gpu)!=intval($confdata["gpu"])){ $a[]="video card"; $rows["changes"]["GPU"]=intval($confdata["gpu"]); } if(intval($wnet)!=intval($confdata["wnet"])){ $a[]="wireless"; $rows["changes"]["WNET"]=intval($confdata["wnet"]); } if(intval($odd)!=intval($confdata["odd"])){ $a[]="optical drive"; $rows["changes"]["ODD"]=intval($confdata["odd"]); }
			if(intval($mdb)!=intval($confdata["mdb"])){ $a[]="motherboard"; $rows["changes"]["MDB"]=intval($confdata["mdb"]); } if(intval($chassis)!=intval($confdata["chassis"])){ $a[]="chassis"; $rows["changes"]["CHASSIS"]=intval($confdata["chassis"]); } if(intval($acum)!=intval($confdata["acum"])){ $a[]="battery"; $rows["changes"]["ACUM"]=intval($confdata["acum"]); } if(intval($war)!=intval($confdata["war"])){ $a[]="warranty"; $rows["changes"]["WAR"]=intval($confdata["war"]); } if(intval($sist)!=intval($confdata["sist"])){ $a[]="operating system"; $rows["changes"]["SIST"]=intval($confdata["sist"]); }
			if(count(array_diff($GLOBALS['current_region'],$s_regions))>0){ $rows["newregion"]=true;  if(count(array_diff($GLOBALS['current_ex_region'],$s_regions))>0){ $a["region"]="region";}} if($war_to_exclude&&$exclude_war==""){$rows["invalid_ex_war"]=true;}
			if(count($a)>0){ $rows["changes"]["txt"]=preg_replace('/(,(?!.*,))/', ' and',implode(", ",$a));}
			if($GLOBALS['getall']){$rows["all"]=$confdata;}
			$run=-1;
		}
		else
		{
			$fc=0;
			$filter_complete=str_replace(" AND hdd=".$hdd,"",$filter_complete,$fc); 
			if($fc<1)
			{
				$filter_complete=str_replace(" AND mem=".$mem,"",$filter_complete,$fc);
				if($fc<1)
				{	
					if($osrun>1)
					{
						if(intval($sist)!=999)
						{ $filter_complete=str_replace(" AND sist=".$sist," AND sist!=999",$filter_complete,$fc);}
						else
						{ $filter_complete=str_replace(" AND sist=".$sist,"",$filter_complete,$fc);}
						$osrun=1;
					}
					if($fc<1)
					{			
						$filter_complete=str_replace(" AND display=".$display,"",$filter_complete,$fc); 
						if($fc<1)
						{
							$filter_complete=str_replace(" AND gpu=".$gpu,"",$filter_complete,$fc);
							if($fc<1)
							{
								$filter_complete=str_replace(" AND cpu=".$cpu,"",$filter_complete,$fc);
								if($fc<1)
								{
									if($osrun>0){ $filter_complete=" ".$exclude_war; $run=2; $osrun=0; }
									if($war_to_exclude){$exclude_war="";}
								}
							}
						}
					}
				}
			}
		}
		$run--;
	}
	if(!$confdata){ $rows["cmodel"]=$GLOBALS["conf"][0]; $rows["cid"]=0; $rows["cprice"]=0; $rows["cerr"]=0; }
	return $rows;
}

function search_any_config($models,$exclude_war)
{
	$run=1; $war_to_exclude=false; if(count($exclude_war)>0){ $run++; $war_to_exclude=true; $exclude_war="AND war NOT IN (".implode(",",$exclude_war).")";}else{ $exclude_war=""; } 
	$cons=$GLOBALS['cons']; $confdata=null; $rows["invalid_ex_war"]=false; $osrun=2; $filter_complete=" AND sist!=999 ".$exclude_war;
	while($run>0)
	{
		$sql="";
		foreach($models as $key=>$model)
		{ $sql.="(SELECT * FROM `notebro_temp`.`all_conf_".$model."` WHERE model=".$model." ".$filter_complete." AND price>0 ORDER BY value desc LIMIT 1) UNION "; }
		$sql=substr($sql, 0, -6); $sql.="ORDER BY abs(value),id LIMIT 1";

		$result = mysqli_query($cons,$sql);
		if($result!==FALSE&&mysqli_num_rows($result)>0)
		{
			$confdata=mysqli_fetch_assoc($result);
			$rows["cid"]=$confdata["id"]; $rows["cprice"]=$confdata["price"]; $rows["cerr"]=$confdata["err"]; $rows["cmodel"]=$confdata["model"];
			if($GLOBALS['getall']){$rows["all"]=$confdata;}
			$run=-1;
		}
		else
		{
			if($osrun>1)
			{ $filter_complete=" ".$exclude_war; $run=2; $osrun=1;}
			else
			{ if($osrun>0){ $filter_complete=""; $run=2; $osrun=0; } }
		}
		$run--;
	}
	if(!$confdata){ $rows["cid"]=0; $rows["cmodel"]=$GLOBALS["conf"][0]; $rows["cprice"]=0; $rows["cerr"]=0; }
	return $rows;
}
?>