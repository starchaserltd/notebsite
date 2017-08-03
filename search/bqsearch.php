<?php
require_once("../etc/conf.php");
require_once("../etc/session.php");
require_once("../search/proc/init.php");

//THIS is a security key to prevent unauthorised access of code, basically we allow this script to work only when it has been accessed by another php page 
if(strcmp("kMuGLmlIzCWmkNbtksAh",$_SESSION['auth'])==0)
{
	//$_SESSION['auth']=0;
	$budgetmax=0;
	$budgetmin=9999999999;
	require_once("../etc/con_db.php");
	require_once("../etc/con_sdb.php");
	

			$orderby = "ORDER BY price ASC";
			$orderby_index = "USE INDEX FOR ORDER BY (price)";
			$price_button = " active";
			$sort_func = "sort_func_by_price";
	
	


		include ("preproc/q_search_varproc.php");
	
	ob_start();
	require("proc/search_filters.php");
	ob_get_clean();
	
	$conds = array();
	foreach (array("cpu", "display", "gpu", "acum", "war", "hdd", "wnet", "sist", "odd", "mem", "mdb", "chassis") as $v) 
	{
		if (!$to_search[$v]) { continue; }
		$conds[$v] = $v . " IN (" . implode(",", array_keys($comp_lists[$v])) . ")";
	}


	if ($nr_hdd > 1) { $conds["shdd"]="shdd > 0"; }

	$conds["capacity"] = "(capacity BETWEEN " . $totalcapmin . " AND " . $hdd_capmax . " )";

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
		$query_search = "SELECT MAX(batlife) AS maxbatlife, MIN(batlife) AS minbatlife FROM notebro_temp.all_conf_".$model." WHERE " . implode(" AND ", $conds_model) . " AND (batlife < ".$batlifemin ." OR batlife > ". $batlifemax .")" . " LIMIT 1"; 
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

		if (!is_null($result)) { if(($result["minbatlife"]!=NULL) && ($batlifemin>$result["minbatlife"])){$batlifemin=$result["minbatlife"];} if($batlifemax<$result["maxbatlife"]){$batlifemax=$result["maxbatlife"];} }
	}
}
	
$result=array("batlifemin"=>$batlifemin,"batlifemax"=>$batlifemax);
echo json_encode($result);
	
	exit();
}
else
{
	echo "Heh! What are you trying to do?";
}
?>