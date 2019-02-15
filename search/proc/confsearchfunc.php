<?php
function sort_func_by_rating(&$results) {
    usort($results, function ($row1, $row2) {
        return (floatval($row1["rating"]) > floatval($row2["rating"])) ? -1 : 1;
    });
}

function sort_func_by_value(&$results) {
    usort($results, function ($row1, $row2) {
        return (floatval($row1["value"]) > floatval($row2["value"])) ? -1 : 1;
    });
}

function sort_func_by_price(&$results) {
    usort($results, function ($row1, $row2) {
        return (floatval($row1["price"]) < floatval($row2["price"])) ? -1 : 1;
    });
}

function del_duplicate_pmodel(&$results)
{
	$compare_array=array(); $i=0;
	foreach($results as $key=>$val)
	{
		if(isset($compare_array[$val["pmodel"]]))
		{
			if(!$val["show_smodel"])
			{
				if($compare_array[$val["pmodel"]]==-1)
				{ unset($results[$key]); }
				else
				{ unset($results[$compare_array[$val["pmodel"]]]); $compare_array[$val["pmodel"]]=-1; }
			}
		}
		else
		{ if($val["mi_region"]==7){ $compare_array[$val["pmodel"]]=$key; } else { $compare_array[$val["pmodel"]]=-1; } }
	}
	$results=array_values($results);
}
function id (&$results) { return; }
?>