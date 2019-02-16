<?php
function get_best_low($cons,$current_ex_region,$model_id)
{
	$best_low=array(); $model_search=false;
	if(isset($current_ex_region)){$cur_p_region=array_diff($current_ex_region,["0","1"]); $cur_p_region=reset($cur_p_region); if(!(isset($cur_p_region)&&$cur_p_region!=""&&$cur_p_region!=NULL&&$cur_p_region!="0")){$cur_p_region="2";} }else{$cur_p_region="2";}
	
	$sql="SELECT * FROM `notebro_temp`.`best_low_opt` WHERE id_model=CONCAT('p_',(SELECT `pmodel` FROM `notebro_temp`.`m_map_table` WHERE `model_id`=".$model_id." LIMIT 1),'_".$cur_p_region."') LIMIT 1";
	$best_low=mysqli_fetch_assoc(mysqli_query($cons,$sql));
	if(!(isset($best_low["best_value"])&&$best_low["best_value"]!=""&&$best_low["best_value"]!=NULL))
	{
		 $model_search=true;
		$sql="SELECT * FROM `notebro_temp`.`best_low_opt` WHERE id_model='".$model_id."'";
		$best_low=mysqli_fetch_assoc(mysqli_query($cons,$sql));
	}
	if($model_search){ $best_low["lowest_price"].="_".$model_id; $best_low["best_performance"].="_".$model_id; $best_low["best_value"].="_".$model_id; }
	if($best_low["lowest_price"]==$best_low["best_value"]) { $best_low["lowest_price"]=""; }
	if($best_low["lowest_price"]==$best_low["best_performance"]) { $best_low["lowest_price"]="";}
	if($best_low["best_value"]==$best_low["best_performance"]) { $best_low["best_performance"]="";}
	return $best_low;
}
?>