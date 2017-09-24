<?php
require_once("../etc/conf.php");
if (!isset($_SERVER['HTTP_REFERER']) || stripos($_SERVER['HTTP_REFERER'],$site_name) ==FALSE) 
{	$actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	header("Location: ".$port_type."://".str_replace($site_name."/",$site_name."/?",$actual_link)."");
	die();
}
?>
	<div style="margin-top:75px; margin-left:50px;">
	 <p><b>This website (noteb.com) and all its subdomains are fully owned by <a href="http://www.starchaser.ro">Starchaser S.R.L.</a></b></p>
	 <p><b>Headquarters: </b><br>
	 Regina Maria nr. 7<br>
	 Ramnicu Valcea, Valcea<br>
	 240151<br>
	 Romania<br>
	 </p>
	<p>For any inquires, complaints or suggestions please contact us via email at: <img src="res/img/starofficeemail.png" width="149" height="20"></p>
	</div>
	<script type="text/javascript">
	 $(document).ready(function(){
	  actbtn("HOME");
	 });
	 </script>