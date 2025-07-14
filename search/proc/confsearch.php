<?php
require_once("confsearchfunc.php");
require_once("../etc/con_sdb.php");

$cons=dbs_connect(); $conds = array();
$results = array(); $queries = array(); $final_comp_list=array();
function sdb_query($cons,$query_search)
{
    $result=NULL;
    if(mysqli_multi_query($cons,implode("; ",$query_search)))
    {
        do
        {
            if($result=mysqli_store_result($cons))
            {
                if(mysqli_num_rows($result)>0)
                { $row=mysqli_fetch_assoc($result); $GLOBALS["results"][$row["model"]]=$row; }
            }
            mysqli_free_result($result);
        }while (mysqli_next_result($cons));
    }
    else
    {
        foreach($query_search as $query)
        {
            if($result=mysqli_query($cons,$query))
            {
                if(mysqli_num_rows($result)>0)
                { $row=mysqli_fetch_assoc($result); $GLOBALS["results"][$row["model"]]=$row; }
                mysqli_free_result($result);
            }
        }
    }
    return array();
}

$conds["price"]="(price > 0)";
if($browse_by)
{
    $conds["capacity"] = "(capacity BETWEEN " . $totalcapmin . " AND 2048 )";
}
elseif ($issimple || $isadvanced || $isquiz)
{
    // IF WE ARE SEARCHING, THINGS GET A TAD MORE COMPLICATED
    $conds["batlife_min"] = "batlife >= ".$batlife_min;
    $conds["batlife_max"] = "batlife <= ".$batlife_max;
    $conds["price"] = "(price BETWEEN " . $budgetmin . " AND " . $budgetmax . ")";
    $conds["capacity"] = "(capacity BETWEEN " . $totalcapmin . " AND " . $hdd_capmax . " )";
}

/* DEBUGGING CODE */
# $time_start = microtime(true);
# echo "<pre>" . var_dump($comp_lists) . "</pre>";

$search_batch_size=100; $i=0;
$query_search=array(); $results=array(); $results_pmode=array();
$count_comp_list=0; $count_comp_list=count($comp_lists["model"]);

foreach($comp_lists["model"] as $mkey=>$m)
{
    $model=$m["id"]; $do_query=true;
    // CLEANING THE LIST OF COMPONENTS
    foreach($comp_pre_list as $comp)
    {
        $final_comp_list[$comp]=array(); if(isset($conds[$comp])){unset($conds[$comp]);} $f_count=0;
        if ($nr_hdd == 2) { $conds["shdd"] = "shdd > 0"; }

        if(isset($comp_lists[$comp])&&is_array($comp_lists[$comp]))
        { $final_comp_list[$comp]=array_intersect($valid_comps[$model][$comp],array_keys($comp_lists[$comp])); }
        else
        { $final_comp_list[$comp]=$valid_comps[$model][$comp]; }

        $f_count=count($final_comp_list[$comp]);

        if($f_count<1)
        { $do_query=false; continue; }
        elseif(($f_count!=$valid_comps["count"][$model][$comp])&&$to_search[$comp])
        { $conds[$comp] = $comp." IN (".implode(",",$final_comp_list[$comp]).")";}
        else
        { continue; }
    }

    if($do_query)
    {
        $conds_model = $conds;

        if($conds_model)
        {
            $query_search[$i] = "SELECT * FROM `".$GLOBALS['global_notebro_sdb']."`.`all_conf_".$model."` WHERE " . implode(" AND ", $conds_model) . " " . $orderby . " LIMIT 1";
        }
        else
        {
            $query_search[$i] = "SELECT * FROM `".$GLOBALS['global_notebro_sdb']."`.`all_conf_".$model."` " . $orderby . " LIMIT 1";
        }
    }
    /* DEBUGGING CODE */
    #echo "<pre>" . var_dump($i) ." : ". var_dump($query_search[$i]) . "</pre>"; echo "<br>";
    #$time_start_query = microtime(true);
    #echo "<pre>"; var_dump($query_search[$i]); echo "</pre>"; echo "<br><br>";

    $i++;
    if($i%$search_batch_size==0||$count_comp_list<=$i)
    {
        $query_search=sdb_query($cons,$query_search);
        // SDB_QUERY RESETS query_search AND PUTS DATA IN $GLOBALS["results"]
    }
}

if(count($query_search)>0){ $query_search=sdb_query($cons,$query_search); }

// ------------------------------------------------------------------
// FIX: Guard against empty IN () clause to avoid SQL syntax error
// ------------------------------------------------------------------
$modelIds = array_keys($results);          // collect IDs returned so far
if(!empty($modelIds))                      // only run the query if we have any
{
    $query_search_pmodel="SELECT * FROM `".$GLOBALS['global_notebro_sdb']."`.`m_map_table` WHERE `".$GLOBALS['global_notebro_sdb']."`.`m_map_table`.`model_id` IN (".implode(",",$modelIds).")";
    $result_pmodel_r=mysqli_query($cons,$query_search_pmodel);

    if($result_pmodel_r&&mysqli_num_rows($result_pmodel_r)>0)
    {
        while($row=mysqli_fetch_assoc($result_pmodel_r))
        { $results_pmodel[$row["model_id"]]=$row; }
        mysqli_free_result($result_pmodel_r);
    }
}
// ------------------------------------------------------------------
// END FIX
// ------------------------------------------------------------------

foreach(array_keys($results) as $el)
{
    if(!isset($results_pmodel[$el]))
    { $results_pmodel[$el]["pmodel"]=$el; $results_pmodel[$el]["show_smodel"]=0; }

    $results[$el]["pmodel"]=$results_pmodel[$el]["pmodel"]; $results[$el]["show_smodel"]=intval($results_pmodel[$el]["show_smodel"]); $results_pmodel[$el]["mi_region"]=0; foreach($search_regions_array as $val){if(isset($results_pmodel[$el][$val])&&$results_pmodel[$el][$val]!=null){ if(in_array($results[$el]["model"],explode(",",$results_pmodel[$el][$val]))){ $results_pmodel[$el]["mi_region"]=1; } } } $results[$el]["mi_region"]=$results_pmodel[$el]["mi_region"];
}



    # $time_end_query = microtime(true);
    # array_push($queries, array(
    #   "query" => $query_search,
    #   "time" => $time_end_query - $time_start_query));
    

/* DEBUGGING CODE */
/*
// HERE WE CALCULATE EXECUTION TIMES
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
/*
    $time_end = microtime(true);
    $execution_time = ($time_end - $time_start);

    echo "<hr>";
    echo "Total time elapsed: " . $execution_time . " s";
    echo "<br>";
*/
$count=count($results);
if($count<1)
{
    // SEARCHING FOR LAPTOPS THAT MATCH EVERYTHING EXCEPT THE BUDGET
    $sql_presearch=str_ireplace("((`min_price`<=".$budgetmax." AND `max_price`>=".$budgetmin.") OR `min_price`=0) AND","",str_ireplace($pre_sql_presearch,"SELECT COUNT(DISTINCT `p_model`) as `ids`,MIN(`min_batlife`) as `min_batlife` FROM `".$GLOBALS['global_notebro_sdb']."`.`presearch_tbl` WHERE ",$sql_presearch));
    $sql_presearch.=" AND ".$sql_presearch_add_no_results."1=1";
    $result_noresult=mysqli_query($cons,$sql_presearch); $presearch_models_nr=0; $presearch_min_batlife=0.0;
    if($result_noresult&&mysqli_num_rows($result_noresult)>0)
    { if($row=mysqli_fetch_assoc($result_noresult)){ if(isset($row["ids"])&&$row["ids"]){ $presearch_models_nr=intval($row["ids"); $presearch_min_batlife=round(floatval($row["min_batlife"]),1,PHP_ROUND_HALF_DOWN); if($batlife_min<$presearch_min_batlife){$presearch_min_batlife=$batlife_min;} } } }
}
else
{ $sort_func($results); del_duplicate_pmodel($results); $count=count($results); }
mysqli_close($cons);
?>
