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

function id (&$results) {
    return;
}
?>