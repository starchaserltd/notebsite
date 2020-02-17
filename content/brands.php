<?php
require_once("../etc/conf.php");
if (!isset($_SERVER['HTTP_REFERER']) || stripos($_SERVER['HTTP_REFERER'],$site_name) ==FALSE) 
{	$actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	header("Location: ".$port_type."://".str_replace($site_name."/",$site_name."/?",$actual_link)."");
	die();
}
require_once("../etc/con_db.php");

$sel = "SELECT * FROM `notebro_site`.`brands` WHERE `inactive`!=1 ORDER BY ord ASC"; 
$results = mysqli_query($con, $sel); 
?>
<div class="row">
<?php
while($row = mysqli_fetch_array($results))
{
	echo '<div class="col-4 col-md-3 col-sm-6 col-xs-6 col-lg-3 allBrands"><a style="cursor:pointer" onmousedown="OpenPage('."'".'search/search.php?prod='.$row["brand"].'&browse_by=prod'."'".',event)">
	<div style="margin-right:5px; margin-bottom: 5px; padding:5px; font-size:15px; text-align:center; max-width:120px;">
	<div class="brands" ><img class="img-responsive" style= "display:block;max-width:100%;height:auto;width:100%; vertical-align: middle;" src="res/'.$row["pic"].'" alt="Brand Logo"></div><div  style="color:#000; font-weight:600; text-align:center;">'.$row["brand"].'</div>
	</div></a></div>';
}
?>
</div>
<script type="text/javascript">
$(document).ready(function(){
	actbtn("SEARCH");
	document.title="Noteb - Browser laptop brands";
});
</script>
<?php include_once("../etc/scripts_pages.php"); ?>
