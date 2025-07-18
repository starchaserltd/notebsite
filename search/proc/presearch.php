<?php
require_once("../etc/con_sdb.php");

if(!(isset($budgetmax)&&$budgetmax>0)){$budgetmax=2147483647;} if(!(isset($budgetmin))){$budgetmin=0;}
if(!(isset($batlife_max)&&$batlife_max>0)){$batlife_max=2147483647;} if(!(isset($batlife_min))){$batlife_min=0;}
if(!(isset($hdd_capmax)&&$hdd_capmax>0)){$hdd_capmax=2147483647;} if(!(isset($totalcapmin))){$totalcapmin=0;}

$ignored_comp=array(); $no_comp_search=array();
$sql_presearch="(SELECT COUNT(id) FROM CHASSIS WHERE valid=1) UNION (SELECT COUNT(id) FROM MDB WHERE valid=1) UNION (SELECT COUNT(id) FROM DISPLAY WHERE valid=1) UNION (SELECT COUNT(id) FROM ACUM WHERE valid=1) UNION (SELECT COUNT(id) FROM CPU WHERE valid=1) UNION (SELECT COUNT(id) FROM GPU WHERE valid=1) UNION (SELECT COUNT(id) FROM MEM WHERE valid=1) UNION (SELECT COUNT(id) FROM WNET WHERE valid=1)";
$result=mysqli_query($con,$sql_presearch); $row=mysqli_fetch_all($result);
$list_comps_to_ignore=["chassis","mdb","display","acum","cpu","gpu","mem","wnet"]; $i=0;
$comp_pre_list=array("cpu","display","mem","hdd","shdd","gpu","wnet","odd","mdb","chassis","acum","war","sist");

foreach($list_comps_to_ignore as $val)
{
	if(isset($comp_lists[$val])&&is_array($comp_lists[$val])){ $count=count($comp_lists[$val]); if(($count>$presearch_comp_limit)&&($count>intval(0.75*intval($row[$i][0])))){$ignored_comp[]=$val;}}
	$i++;
}

$pre_sql_presearch="SELECT `model_id`,`p_model`,`min_batlife`,`".implode("`,`",$comp_pre_list)."` FROM `".$GLOBALS['global_notebro_sdb']."`.`presearch_tbl` WHERE "; $model_id_new=array(); $start_id_model=0; $has_or=0;
$sql_presearch=$pre_sql_presearch;
$sql_presearch_add_no_results=""; $no_results_has_or=0;

foreach($comp_lists as $key=>$val)
{
	$sql_presearch_add_no_results.="("; $sql_presearch.="("; $empty_cond=0;
	if(isset($val)&&$val!=NULL)
	{
		if(is_array($val)&&reset($val)!==NULL)
		{
			foreach($val as $key2=>$val2)
			{
				if($key=="model")
				{
					$start_id_model=1;
					$model_id_new[]=$key2;
				}
				else
				{ 	
					$start_id_model=0;
					if(!in_array($key,$ignored_comp))
					{
						$sql_presearch.=" FIND_IN_SET(".$key2.",`".$key."`)>0 OR"; $has_or=1;
					}
					else
					{ 
						$empty_cond=1;
						$sql_presearch_add_no_results.=" FIND_IN_SET(".$key2.",`".$key."`)>0 OR"; $no_results_has_or=1;
					}
				}
			}
		}
		else
		{ $empty_cond=1; }
	}
	else
	{
		if(is_array($val)&&reset($val)==NULL){$no_comp_search[]=$key; $sql_presearch="SELECT `model_id`,`p_model`,`min_batlife`,`".implode("`,`",$comp_pre_list)."` FROM `".$GLOBALS['global_notebro_sdb']."`.`presearch_tbl` WHERE 1=0 "; }
	}

	if($empty_cond)
	{
		$sql_presearch.="1=1";
		if($no_results_has_or)
		{
			$sql_presearch_add_no_results=substr($sql_presearch_add_no_results, 0, -3); $no_results_has_or=0;
			if($start_id_model){ $sql_presearch_add_no_results.=" `model_id` IN (".implode(",",$model_id_new).")";}
			$sql_presearch_add_no_results.=") AND ";
		}
		else
		{ $sql_presearch_add_no_results=substr($sql_presearch_add_no_results, 0, -1); }
	}
	else
	{ $sql_presearch_add_no_results=substr($sql_presearch_add_no_results, 0, -1); }
	
	if($has_or){$sql_presearch=substr($sql_presearch, 0, -3); $has_or=0;}
	if($start_id_model){ $sql_presearch.=" `model_id` IN (".implode(",",$model_id_new).")";}
	$sql_presearch.=") AND ";
}

$sql_presearch.=$shdd_search_cond."((`min_price`<=".$budgetmax." AND `max_price`>=".$budgetmin.") OR `min_price`=0) AND ((`min_batlife`<=".$batlife_max." AND `max_batlife`>=".$batlife_min.") OR `min_batlife`=0) AND ((`min_cap`<=".$hdd_capmax." AND `max_cap`>=".$totalcapmin.") OR `min_cap`=0)";
$sql_presearch=str_replace("AND () "," ",$sql_presearch);
$sql_presearch=$sql_presearch." AND ((`max_price`-`min_price`)!=999999)";

$result=mysqli_query($cons,$sql_presearch); $valid_ids=array(); $count_p_models=array(); $pre_min_bat_life=9999999;
if($result&&mysqli_num_rows($result)>0)
{ 
	while($row=mysqli_fetch_assoc($result))
	{
		if(isset($row["model_id"])&&$row["model_id"]){ $valid_ids[$row["model_id"]]=$row["p_model"]; foreach($comp_pre_list as $el){ $valid_comps[$row["model_id"]][$el]=explode(",",$row[$el]); $valid_comps["count"][$row["model_id"]][$el]=count($valid_comps[$row["model_id"]][$el]);} $row["min_batlife"]=floatval($row["min_batlife"]); if($pre_min_bat_life>$row["min_batlife"]){$pre_min_bat_life=$row["min_batlife"];} }
	}
	$row["min_batlife"]=$pre_min_bat_life;
}
else
{ $comp_lists["model"]=array(); }
foreach($comp_lists["model"] as $key=>$val)
{ if(!isset($valid_ids[$key])){unset($comp_lists["model"][$key]);}else{$count_p_models[]=$valid_ids[$key];} }
?>