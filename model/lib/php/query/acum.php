<?php
if (isset($_GET['q'])) {
    $q = filter_var($_GET['q'], FILTER_VALIDATE_INT);
    if ($q === FALSE) { $q = -1; }
} else { $q = -1; }

if ($q >= 0)
{
    header('Content-Type: application/json; charset=UTF-8'); 

    require("../../../../etc/con_db.php");
    require("../../../../etc/rates_conf.php");
    mysqli_select_db($con,$global_notebro_db);

    /* prepared statement instead of string-concat */
    $stmt = mysqli_prepare($con, "SELECT * FROM ACUM WHERE id = ? LIMIT 1"); // 
    mysqli_stmt_bind_param($stmt, "i", $q);                                  
    mysqli_stmt_execute($stmt);                                             
    $result = mysqli_stmt_get_result($stmt);                          

    if (mysqli_num_rows($result) == 0) {  
        http_response_code(404);  
        exit;                 
    }

    $rows = array();
    if ($r = mysqli_fetch_assoc($result))      
    {
        foreach ($r as $key => $value) {
            if (is_numeric($value)) {
                $r[$key] += 0;  
            }
        }

        $rows[] = $r;
        $rows[0]['msc'] = str_replace(",", ", ", (string) $rows[0]['msc']);
        if(!$rows[0]['msc']) { $rows[0]['msc']="-"; }
        if(!$rows[0]['tipc']) { $rows[0]['tipc']="-"; }
        if(!$rows[0]['nrc'])  { $rows[0]['nrc']="-"; }
        if(!$rows[0]['cap'])  { $rows[0]['cap']="-"; }

        $rows[0]['price'] = 0;
        $rows[0]['confrate'] = round($rows[0]['rating'],3)*$acum_i/100;
    }

    $rows[0]['rating'] = 0;
    print json_encode($rows[0], JSON_NUMERIC_CHECK); 
    mysqli_stmt_close($stmt); 
    mysqli_close($con);
}
else
{ header('X-PHP-Response-Code: 204', true, 204); }
?>
