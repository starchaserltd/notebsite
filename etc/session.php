<?php 
	
 if(session_id() == '')
 {
      session_start();
 }
 
//THIS is a security key to prevent unauthorised access of code
$_SESSION['auth']="kMuGLmlIzCWmkNbtksAh";
if(!isset($_SESSION['model'])) {$_SESSION['model']=0;} if(!isset($_SESSION['conf_cpu'])) {$_SESSION['conf_cpu']=0;} if(!isset($_SESSION['conf_gpu'])) {$_SESSION['conf_gpu']=0;} if(!isset($_SESSION['conf_display'])) {$_SESSION['conf_display']=0;}
if(!isset($_SESSION['curentconf_hdd'])) {$_SESSION['curentconf_hdd']=0;} if(!isset($_SESSION['conf_shdd'])) {$_SESSION['conf_shdd']=0;} if(!isset($_SESSION['conf_acum'])) {$_SESSION['conf_acum']=0;} if(!isset($_SESSION['conf_mdb'])) {$_SESSION['conf_mdb']=0;}
if(!isset($_SESSION['conf_mem'])) {$_SESSION['conf_mem']=0;} if(!isset($_SESSION['conf_odd'])) {$_SESSION['conf_odd']=0;} if(!isset($_SESSION['conf_chassis'])) {$_SESSION['conf_chassis']=0;} if(!isset($_SESSION['conf_wnet'])) {$_SESSION['conf_wnet']=0;} 
if(!isset($_SESSION['conf_war'])) {$_SESSION['conf_war']=0;} if(!isset($_SESSION['conf_sist'])) {$_SESSION['conf_sist']=0;} if(!isset($_SESSION['conf_gpu_model'])) {$_SESSION['conf_gpu_model']=0;} if(!isset($_SESSION['curentconf_shdd'])) {$_SESSION['curentconf_shdd']=0;}
//session_destroy();
 ?>
