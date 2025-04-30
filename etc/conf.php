<?php
$site_name="noteb.com";
$admin_address="/../vault"; 				/* ADMIN FOLDER */
$wp_rmimg="wp/wp-content/"; 								/* REWRITE WP IMG ADDRESS */
$wp_address="http://34.194.182.255/vault/"; /* WORDPRESS INSTALATION ADDRESS */
$wp_new_address="https://noteb.com/";
$port_type="https";
$root_mod="";
$underwork=0;

$web_address="https://".$site_name."/";
$laptop_comp_list=["cpu","display","mem","hdd","shdd","gpu","mdb","wnet","odd","sist","chassis","acum","war"];
function clean_string($string){ return preg_replace('~[\x00\x0A\x0D\x1A\x22\x27\x5C]~u', '\\\$0', filter_var($string,FILTER_SANITIZE_STRING)); }
function table($id) { $cons=dbs_connect();  $t=explode("_",$id); $id=$t[0]; if(isset($t[1])){ $model=$t[1]; } $result=mysqli_query($cons,"SELECT model FROM notebro_temp.all_conf WHERE id=$id LIMIT 1"); if($result && mysqli_num_rows($result)>0) {  $model=mysqli_fetch_row($result); mysqli_free_result($result); $t[1]=$model[0]; } else { if(isset($model)) { $result=mysqli_query($cons,"SELECT best_value FROM notebro_temp.best_low_opt WHERE id_model=$model LIMIT 1"); if($result && mysqli_num_rows($result)>0) { $id=mysqli_fetch_row($result); mysqli_free_result($result);  $t[0]=$id[0];} else { $t=NULL; } } else { $t=NULL; } }  mysqli_close($cons); return $t; }
if (session_status() == PHP_SESSION_NONE) { ini_set('session.cookie_samesite', "Lax");	ini_set('session.name', "NOTEBSESSID"); session_start(); }
?>