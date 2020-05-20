<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
function var_error_log($object=null){ob_start(); var_dump($object); $contents=ob_get_contents(); ob_end_clean(); error_log($contents);}
error_reporting(E_ALL);
echo getcwd() . "\n";
?>