<?php
include("../../etc/conf.php");
if (!isset($_SERVER['HTTP_REFERER']) || stripos($_SERVER['HTTP_REFERER'],$site_name) ==FALSE) 
{	$actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	header("Location: http://noteb.com/?content/home.php");
	die();
}
?>
<div style="border-style:dashed; border-width:medium; border-color:#b5b8bd; height:210px; width:100%;">
<img class="img-responsive" src="search/quiz/res/img/working.jpg" style="vertical-align: middle;height:200px;">
</div>