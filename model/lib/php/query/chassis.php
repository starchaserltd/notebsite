<?php
if(isset($_GET['q'])){ 
    $q = filter_var($_GET['q'], FILTER_VALIDATE_INT); 
    if($q === FALSE){ 
        $q = -1; 
    } 
} else { 
    $q = -1;
}

if($q >= 0)
{
    require("../../../../etc/con_db.php");
    require("../../../../etc/rates_conf.php");
    mysqli_select_db($con, $global_notebro_db);

    $sql    = "SELECT * FROM CHASSIS WHERE id = '".$q."'";
    $result = mysqli_query($con,$sql);
    
    $rows = array();
    while($r = mysqli_fetch_assoc($result)) 
    {
        foreach ($r as $key => $value) {
            if (is_numeric($value)) {
                $r[$key] += 0;          // cast numeric strings to numbers
            }
        }
    
        $rows[] = $r;

        $rows[0]['made'] = explode(",", $rows[0]['made'] ?? '');
        if (!empty($rows[0]['s_made'])) {
            $rows[0]['made'] = array_unique(
                array_merge($rows[0]['made'], explode(",", $rows[0]['s_made']))
            );
        }
        $rows[0]['made'] = implode(", ", $rows[0]['made']);

        // Prevent PHP 8.1+ deprecation notices (null → empty string)
        $rows[0]['msc']      = str_replace(',', ', ', $rows[0]['msc']      ?? '');
        $rows[0]['pi']       = str_replace(',', ', ', $rows[0]['pi']       ?? '');
        $rows[0]['keyboard'] = str_replace(',', ', ', $rows[0]['keyboard'] ?? '');
        $rows[0]['vi']       = str_replace(',', ', ', $rows[0]['vi']       ?? '');
        $rows[0]['color']    = str_replace(',', ', ', $rows[0]['color']    ?? '');

        if(!$rows[0]['msc']) { $rows[0]['msc']="-"; }
        if(!$rows[0]['pi'])  { $rows[0]['pi']="-"; }
        if(!$rows[0]['vi']) { 
            if(stripos($rows[0]['pi'],"thunderbolt")!==FALSE) { 
                $rows[0]['vi']="1 X mDP (Thunderbolt)"; 
            } else { 
                $rows[0]['vi']="-"; 
            } 
        } else { 
            if(stripos($rows[0]['pi'],"thunderbolt")!==FALSE && stripos($rows[0]['vi'],"DP")===FALSE) { 
                $rows[0]['vi'].=", 1 X mDP (Thunderbolt)"; 
            } 
        }
        if(!$rows[0]['color']) { $rows[0]['color']="-"; }
        if(!$rows[0]['web'])   { $rows[0]['web']="None"; }
        if(!$rows[0]['touch']) { $rows[0]['touch']="Standard"; }

        if(!$rows[0]['charger']) { 
            $rows[0]['charger']="-"; 
        } else { 
            $rows[0]['charger']=str_replace(",", ",<br>",$rows[0]['charger']); 
        }
        //$rows[0]['price']=round($rows[0]['price'],2);
        $rows[0]['price']=0;
        $rows[0]['confrate'] = round($rows[0]['rating'],3)*$chassis_i/100;  
    }

    $rows[0]['rating']=0;
    print json_encode($rows[0]);
    mysqli_close($con);
}
else
{
    header('X-PHP-Response-Code: 204', true, 204);
}
?>
