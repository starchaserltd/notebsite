<?php
require_once("../etc/con_sdb.php");

/* ------------------------------------------------------------------
 * Default limits – use sensible max/min when the variable is missing
 * ------------------------------------------------------------------ */
if (!(isset($budgetmax) && $budgetmax > 0)) { $budgetmax = 2147483647; }
if (!isset($budgetmin)) { $budgetmin = 0; }
if (!(isset($batlife_max) && $batlife_max > 0)) { $batlife_max = 2147483647; }
if (!isset($batlife_min)) { $batlife_min = 0; }
if (!(isset($hdd_capmax) && $hdd_capmax > 0)) { $hdd_capmax = 2147483647; }
if (!isset($totalcapmin)) { $totalcapmin = 0; }

$ignored_comp   = array();
$no_comp_search = array();

/* ------------------------------------------------------------------
 * How many rows each component table holds – used to decide whether a
 * component should be ignored (too many possibilities → big query).
 * ------------------------------------------------------------------ */
$sql_presearch_cnt = "(SELECT COUNT(id) FROM CHASSIS WHERE valid=1) UNION (SELECT COUNT(id) FROM MDB WHERE valid=1) UNION (SELECT COUNT(id) FROM DISPLAY WHERE valid=1) UNION (SELECT COUNT(id) FROM ACUM WHERE valid=1) UNION (SELECT COUNT(id) FROM CPU WHERE valid=1) UNION (SELECT COUNT(id) FROM GPU WHERE valid=1) UNION (SELECT COUNT(id) FROM MEM WHERE valid=1) UNION (SELECT COUNT(id) FROM WNET WHERE valid=1)";
$result = mysqli_query($con, $sql_presearch_cnt);
$row    = mysqli_fetch_all($result);

$list_comps_to_ignore = [
    "chassis", "mdb", "display", "acum",
    "cpu", "gpu", "mem", "wnet"
];
$comp_pre_list = [
    "cpu", "display", "mem", "hdd", "shdd", "gpu", "wnet",
    "odd", "mdb", "chassis", "acum", "war", "sist"
];

/* ------------------------------------------------------------------
 * Mark components to ignore if the user-selected list is huge compared
 * with what actually exists in the table.
 * ------------------------------------------------------------------ */
foreach ($list_comps_to_ignore as $i => $val) {
    if (isset($comp_lists[$val]) && is_array($comp_lists[$val])) {
        $count = count($comp_lists[$val]);
        if (($count > $presearch_comp_limit) &&
            ($count > intval(0.75 * intval($row[$i][0])))) {
            $ignored_comp[] = $val;
        }
    }
}

/* ------------------------------------------------------------------
 * Build a safe WHERE clause.
 *   1. Collect individual AND‑joined conditions into $where_parts.
 *   2. Append OR‑joined component conditions only when they are present
 *      so we never emit an empty pair of parentheses.
 * ------------------------------------------------------------------ */
$select_cols = "`model_id`,`p_model`,`min_batlife`,`" . implode("`,`", $comp_pre_list) . "`";
$sql_presearch = "SELECT $select_cols FROM `" . $GLOBALS['global_notebro_sdb'] . "`.`presearch_tbl` WHERE ";
$where_parts   = [];
$model_id_new  = [];

foreach ($comp_lists as $key => $val) {

    /* --------------------------------------------------------------
     * Skip undefined / empty component filters *early*.
     * -------------------------------------------------------------- */
    if (empty($val) || !is_array($val) || reset($val) === NULL) {
        if (is_array($val) && reset($val) === NULL) {
            /* Explicitly asked for this component but with no ids →
             * force an empty result set.
             */
            $no_comp_search[] = $key;
            $where_parts      = ["1=0"];
            break;
        }
        continue;
    }

    /* --------------------------------------------------------------
     * Build OR‑joined pieces for this component.
     * -------------------------------------------------------------- */
    $or_parts = [];
    foreach ($val as $id => $dummy) {
        $id = intval($id);
        if ($key === "model") {
            $model_id_new[] = $id; /* handled later */
        } else {
            if (!in_array($key, $ignored_comp, true)) {
                $or_parts[] = "FIND_IN_SET($id,`$key`) > 0";
            }
            /* ignored components are dealt with in the secondary query
             * if the main query yields no results (legacy behaviour).
             */
        }
    }

    if ($or_parts) {
        $where_parts[] = '(' . implode(' OR ', $or_parts) . ')';
    }
}

/* explicit model id filter (added last) --------------------------- */
if ($model_id_new) {
    $where_parts[] = "`model_id` IN (" . implode(',', $model_id_new) . ")";
}

/* static range filters ------------------------------------------- */
$where_parts[] = "((`min_price` <= $budgetmax AND `max_price` >= $budgetmin) OR `min_price` = 0)";
$where_parts[] = "((`min_batlife` <= $batlife_max AND `max_batlife` >= $batlife_min) OR `min_batlife` = 0)";
$where_parts[] = "((`min_cap` <= $hdd_capmax AND `max_cap` >= $totalcapmin) OR `min_cap` = 0)";
$where_parts[] = "((`max_price` - `min_price`) != 999999)";

/* shdd filter (if supplied) -------------------------------------- */
if (!empty($shdd_search_cond)) {
    $where_parts[] = $shdd_search_cond;
}

/* assemble final query ------------------------------------------- */
$sql_presearch .= implode(" AND\n ", $where_parts);

/* -------------------------------------------------------------- */
$result = mysqli_query($cons, $sql_presearch);
$valid_ids       = [];
$count_p_models  = [];
$pre_min_bat_life = 9999999;

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        if (isset($row["model_id"]) && $row["model_id"]) {
            $valid_ids[$row["model_id"]] = $row["p_model"];
            foreach ($comp_pre_list as $el) {
                $valid_comps[$row["model_id"]][$el]        = explode(",", $row[$el]);
                $valid_comps["count"][$row["model_id"]][$el] = count($valid_comps[$row["model_id"]][$el]);
            }
            $row["min_batlife"] = floatval($row["min_batlife"]);
            if ($pre_min_bat_life > $row["min_batlife"]) {
                $pre_min_bat_life = $row["min_batlife"];
            }
        }
    }
    $row["min_batlife"] = $pre_min_bat_life;
} else {
    $comp_lists["model"] = array();
}

foreach ($comp_lists["model"] as $key => $val) {
    if (!isset($valid_ids[$key])) {
        unset($comp_lists["model"][$key]);
    } else {
        $count_p_models[] = $valid_ids[$key];
    }
}
?>
