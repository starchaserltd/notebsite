<?php
$site_name="YOUR_HOST";
$admin_address="/../admin"; 					/* ADMIN FOLDER */

$wp_rmimg="";									/* REWRITE WP IMG ADDRESS */
$wp_address="https://yourdomain.com"; /* WORDPRESS INSTALATION ADDRESS */
$new_wp_address="https://yourdomain.com";

$web_address="http://".$site_name."/";
$root_mod="/../notebro/noteb";
$port_type="http";
$underwork=0;
$laptop_comp_list=["cpu","display","mem","hdd","shdd","gpu","mdb","wnet","odd","sist","chassis","acum","war"];
function clean_string($string){ return preg_replace('~[\x00\x0A\x0D\x1A\x22\x27\x5C]~u', '\\\$0', filter_var($string,FILTER_SANITIZE_STRING)); }
function table($id) { $t=explode("_",$id); $id=$t[0]; if(isset($t[1])){ $model=$t[1]; } $result=mysqli_query($GLOBALS["cons"],"SELECT model FROM ".$GLOBALS['global_notebro_sdb'].".all_conf WHERE id=$id LIMIT 1"); if($result && mysqli_num_rows($result)>0) {  $model=mysqli_fetch_row($result); mysqli_free_result($result); $t[1]=$model[0]; } else { if(isset($model)) { $result=mysqli_query($GLOBALS["con"],"SELECT best_value FROM ".$GLOBALS['global_notebro_sdb'].".best_low_opt WHERE id_model=$model LIMIT 1"); if($result && mysqli_num_rows($result)>0) { $id=mysqli_fetch_row($result); mysqli_free_result($result);  $t[0]=$id[0]; }else { $t=NULL; } } else { $t=NULL; } }  return $t; }
if (session_status() == PHP_SESSION_NONE) { ini_set('session.cookie_samesite', "Lax");	ini_set('session.name', "NOTEBSESSID"); session_start(); }
?>
