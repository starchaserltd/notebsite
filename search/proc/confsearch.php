<?php
require_once("confsearchfunc.php");
require_once("../etc/con_sdb.php");

$cons=dbs_connect();

if($browse_by)
{
	//IF BROWSING WE HAVE A SIMPLER QUERY	
	$conds = array();

	foreach ($filtercomp as $v)
	{
		if (!$to_search[$v]) { continue; }
		$conds[$v] = $v . " IN (" . implode(",", array_keys($comp_lists[$v])) . ")";
	} 
	if ($nr_hdd == 2) { $conds["shdd"] = "shdd > 0"; }
	$conds["capacity"] = "(capacity > " . $totalcapmin . " )";
}
elseif ($issimple || $isadvanced || $isquiz)
{
	//IF WE ARE SEARCHING, THINGS GET A TAD MORE COMPLICATED
	$conds = array();
	
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
		$query_search = "SELECT * FROM notebro_temp.all_conf_".$model." WHERE " . implode(" AND ", $conds_model) . " " . $orderby . " LIMIT 1"; 
	}
    else
	{ 
		$query_search = "SELECT * FROM notebro_temp.all_conf_".$model." " . $orderby . " LIMIT 1";
	}
	/* DEBUGGING CODE */
	# echo "<pre>" . var_dump($query_search) . "</pre>";
	# $time_start_query = microtime(true);
	# echo "<pre>"; var_dump($query_search); echo "<br>"; echo "</pre>";
	$result=mysqli_query($cons, $query_search);
	
	if($result)
	{ 
		$result = mysqli_fetch_assoc($result); 

	# $time_end_query = microtime(true);
	# array_push($queries, array(
	#	"query" => $query_search,
	#	"time" => $time_end_query - $time_start_query));
		if (!is_null($result)) { $results[] = $result; }
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

     $time_end = microtime(true);
     $execution_time = ($time_end - $time_start);

	 echo "<hr>";
     echo "Total time elapsed: " . $execution_time . " s";
     echo "<br>";
*/
	mysqli_close($cons);
    $sort_func($results);
    $count = count($results);
?>