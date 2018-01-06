<?php
require_once("../etc/conf.php");
require_once("../etc/session.php");
require_once("../search/proc/init.php");

//THIS is a security key to prevent unauthorised access of code, basically we allow this script to work only when it has been accessed by another php page 
if(strcmp("kMuGLmlIzCWmkNbtksAh",$_SESSION['auth'])==0)
{
	//$_SESSION['auth']=0;
	$presearch_budgetmax=0; $presearch_budgetmin=9999999999;
	$presearch_batlifemax=0; $presearch_batlifemin=9999999999; $query_search="";

	$orderby = "ORDER BY price ASC";
	$orderby_index = "USE INDEX FOR ORDER BY (price)";
	$price_button = " active";
	$sort_func = "sort_func_by_price";
	
	require_once("../etc/con_db.php");
	require_once("../etc/con_sdb.php");
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

	if($qsearchtype=="p")
	{
		$conds["batlife_min"] = "batlife >= ".$batlife_min; 
		$conds["batlife_max"] = "batlife <= ".$batlife_max; 
	}
	
	if ($nr_hdd > 1) { $conds["shdd"]="shdd > 0"; }

	$conds["capacity"] = "(capacity BETWEEN " . $totalcapmin . " AND " . $totalcapmax . " )";

	$results = array(); $queries = array();

	/* DEBUGGING CODE */
	# $time_start = microtime(true);
	# echo "<pre>" . var_dump($comp_lists) . "</pre>";

	foreach($comp_lists["model"] as $m)
	{
		$model = $m["id"];
		$conds_model = $conds;
		
		if($conds_model)
		{ 
			if($qsearchtype=="p")
			{ $query_search = "SELECT MAX(price) AS maxprice, MIN(price) AS minprice FROM notebro_temp.all_conf_".$model." WHERE " . implode(" AND ", $conds_model) . " AND (price < ".$presearch_budgetmin ." OR price > ". $presearch_budgetmax .")" . " LIMIT 1"; }
			
			if($qsearchtype=="b")
			{ $query_search = "SELECT MAX(batlife) AS maxbatlife, MIN(batlife) AS minbatlife FROM notebro_temp.all_conf_".$model." WHERE " . implode(" AND ", $conds_model) . " LIMIT 1"; }
		}

		/* DEBUGGING CODE */
		# echo "<pre>" . var_dump($query_search) . "</pre>";
		# $time_start_query = microtime(true);
		# echo "<pre>"; var_dump($query_search); var_dump( $presearch_batlifemin); echo "<br>"; echo "</pre>";
		$result=mysqli_query($cons, $query_search);
		#echo $query_search; echo "<br>";
		if($result)
		{ 
			$result = mysqli_fetch_assoc($result); 

			# $time_end_query = microtime(true);
			# array_push($queries, array(
			#	"query" => $query_search,
			#	"time" => $time_end_query - $time_start_query));
			if($qsearchtype=="p")
			{ if (!is_null($result)) { if(($result["minprice"]!=NULL) && ($presearch_budgetmin>$result["minprice"])){$presearch_budgetmin=$result["minprice"];} if($presearch_budgetmax<$result["maxprice"]){$presearch_budgetmax=$result["maxprice"];} } }
			
			if($qsearchtype=="b")
			{ if (!is_null($result)) { if(($result["minbatlife"]!=NULL) && ($presearch_batlifemin>$result["minbatlife"])){$presearch_batlifemin=$result["minbatlife"];} if($presearch_batlifemax<$result["maxbatlife"]){$presearch_batlifemax=$result["maxbatlife"];} } }
		}
	}
	if($qsearchtype=="p") { $result=array("budgetmin"=>$presearch_budgetmin,"budgetmax"=>$presearch_budgetmax); }
	if($qsearchtype=="b") { $result=array("batlifemin"=>$presearch_batlifemin,"batlifemax"=>$presearch_batlifemax); }
	echo json_encode($result);
	
	exit();
}
else { echo "Heh! What are you trying to do?"; }
?>