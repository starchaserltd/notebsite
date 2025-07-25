<?php
$query_search="";
$orderby = "ORDER BY rating ASC";
$orderby_index = "USE INDEX FOR ORDER BY (rating)";
$sort_func = "sort_func_by_rating";
$relativepath="";

if(!$abort)
{
	require_once("../etc/con_sdb.php");
	ob_start();
	require("../search/proc/search_filters.php");
	ob_get_clean();

	$conds = array();
	foreach (array("cpu", "display", "gpu", "acum", "war", "hdd", "wnet", "sist", "odd", "mem", "mdb", "chassis") as $v) 
	{
		if (!$to_search[$v]) { continue; }
		$conds[$v] = $v . " IN (" . implode(",", array_keys($comp_lists[$v])) . ")";
	}

	if ($nr_hdd > 1) { $conds["shdd"]="shdd > 0"; }
	$conds["capacity"] = "(capacity BETWEEN " . $totalcapmin . " AND " . $totalcapmax . " )";
	$results = array(); $queries = array(); $idmodel=array();

	if(!isset($comp_lists["model"])&&isset($comp_lists_api["model"])){ $comp_lists["model"]=$comp_lists_api["model"]; }
	if(isset($comp_lists["model"]))
	{
		foreach($comp_lists["model"] as $m)
		{
			$model = $m["id"];
			$conds_model = $conds;
			
			if($conds_model)
			{ $query_search = "SELECT id,model FROM `".$GLOBALS['global_notebro_sdb']."`.all_conf_".$model." WHERE " . implode(" AND ", $conds_model) . " AND price>0 ORDER BY value DESC LIMIT 1"; }

			/* DEBUGGING CODE */
			$results=mysqli_query($cons, $query_search);
			if($results)
			{ 
				$result = mysqli_fetch_assoc($results); 
				if ((!is_null($result)) && ($result["id"]!=NULL))
				{ 
					$idmodel[] = $result["model"];
					if($single_result){	break; }
				}
			}
		}
	}
}
?>