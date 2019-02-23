<?php
require_once("confsearchfunc.php");
require_once("../etc/con_sdb.php");

$cons=dbs_connect(); $conds = array(); $conds["price"]="(price > 0)";
if($browse_by)
{
	//IF BROWSING WE HAVE A SIMPLER QUERY	
	foreach ($filtercomp as $v)
	{
		if (!$to_search[$v]) { continue; }
		$conds[$v] = $v . " IN (" . implode(",", array_keys($comp_lists[$v])) . ")";
	} 
	if ($nr_hdd == 2) { $conds["shdd"] = "shdd > 0"; }
	$conds["capacity"] = "(capacity BETWEEN " . $totalcapmin . " AND 2048 )";
}
elseif ($issimple || $isadvanced || $isquiz)
{
	//IF WE ARE SEARCHING, THINGS GET A TAD MORE COMPLICATED
	foreach (array("cpu", "display", "gpu", "acum", "war", "hdd", "wnet", "sist", "odd", "mem", "mdb", "chassis") as $v) 
	{
		if (!$to_search[$v]) { continue; }
		$conds[$v] = $v . " IN (" . implode(",", array_keys($comp_lists[$v])) . ")";
	}

	$conds["batlife_min"] = "batlife >= ".$batlife_min; 
	$conds["batlife_max"] = "batlife <= ".$batlife_max; 

	if ($nr_hdd ==2) { $conds["shdd"]="shdd > 0"; }

	$conds["price"] = "(price BETWEEN " . $budgetmin . " AND " . $budgetmax . ")";
	$conds["capacity"] = "(capacity BETWEEN " . $totalcapmin . " AND " . $hdd_capmax . " )";
}

$results = array();
$queries = array();

/* DEBUGGING CODE */
# $time_start = microtime(true);
# echo "<pre>" . var_dump($comp_lists) . "</pre>";

foreach($comp_lists["model"] as $m)
{
	$model = $m["id"];
	$conds_model = $conds;
	
	if($conds_model)
    { 
		$query_search = "SELECT * FROM `notebro_temp`.`all_conf_".$model."` WHERE " . implode(" AND ", $conds_model) . " " . $orderby . " LIMIT 1"; 
	}
    else
	{ 
		$query_search = "SELECT * FROM `notebro_temp`.`all_conf_".$model."` " . $orderby . " LIMIT 1";
	}
	/* DEBUGGING CODE */
	# echo "<pre>" . var_dump($query_search) . "</pre>";
	# $time_start_query = microtime(true);
	# echo "<pre>"; var_dump($query_search); echo "<br>"; echo "</pre>";
	$result=mysqli_query($cons, $query_search);
	
	if($result&&mysqli_num_rows($result)>0)
	{ 
		$result = mysqli_fetch_assoc($result); 

	# $time_end_query = microtime(true);
	# array_push($queries, array(
	#	"query" => $query_search,
	#	"time" => $time_end_query - $time_start_query));
		$query_search_pmodel="SELECT * FROM `notebro_temp`.`m_map_table` WHERE `notebro_temp`.`m_map_table`.`model_id`=".$model." LIMIT 1";
		$result_pmodel_r=mysqli_query($cons,$query_search_pmodel);
		if($result_pmodel_r&&mysqli_num_rows($result_pmodel_r)>0)
		{ $result_pmodel=mysqli_fetch_assoc($result_pmodel_r);}
		else
		{ $result_pmodel["pmodel"]=$model; $result_pmodel["show_smodel"]=0; }
		$result["pmodel"]=$result_pmodel["pmodel"]; $result["show_smodel"]=intval($result_pmodel["show_smodel"]); $result_pmodel["mi_region"]=0; foreach($search_regions_array as $val){if(isset($result_pmodel[$val])&&$result_pmodel[$val]!=null){ if(in_array($result["model"],explode(",",$result_pmodel[$val]))){ $result_pmodel["mi_region"]=1; } } } $result["mi_region"]=$result_pmodel["mi_region"];
		
		if (!is_null($result)) { $results[]=$result; }
	}
}
	
/* DEBUGGING CODE */
/*
//HERE WE CALCULATE EXECUTION TIMES
usort($queries, function ($p, $q) {
	return ($p["time"] > $q["time"]) ? -1 : 1;
	});

	echo "Showing top 3 slowest queries:";
	foreach($queries as $i => $q)
	{
		if ($i == 3)
		{ break; }
		echo "<pre>" . $q["query"] . "</pre>";
		echo "Time elapsed: " . sprintf("%.4f", $q["time"]) . " s<br>";
     }
*/
    /* $time_end = microtime(true);
     $execution_time = ($time_end - $time_start);

	 echo "<hr>";
     echo "Total time elapsed: " . $execution_time . " s";
     echo "<br>";
*/
    $count=count($results); 
	if($count<1)
	{
		//SEARCHING FOR LAPTOPS THAT MATCH EVERYTHING EXCEPT THE BUDGET
		$sql_presearch=str_ireplace("((`min_price`<".$budgetmax." AND `max_price`>".$budgetmin.") OR `min_price`=0) AND","",str_ireplace("GROUP_CONCAT(CONCAT(`model_id`,'+',`p_model`))","COUNT(DISTINCT `p_model`)",$sql_presearch));
		$result_noresult=mysqli_query($cons,$sql_presearch); $presearch_models_nr=0;
		if($result_noresult&&mysqli_num_rows($result_noresult)>0)
		{ if($row=mysqli_fetch_assoc($result_noresult)){ if(isset($row["ids"])&&$row["ids"]){ $presearch_models_nr=intval($row["ids"]); } } }
	}
	else
	{ $sort_func($results); del_duplicate_pmodel($results); $count=count($results); }
	mysqli_close($cons);
?>