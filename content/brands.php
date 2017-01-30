<?php
require_once("../etc/session.php");
require_once("../etc/con_db.php");

$sel = "SELECT * FROM notebro_site.brands ORDER BY ord ASC"; 
$results = mysqli_query($con, $sel); 
while($row = mysqli_fetch_array($results))
{
	echo '<a style="cursor:pointer" onmousedown="OpenPage('."'".'search/search.php?prod='.$row["brand"].'&browse_by=prod'."'".',event)"><div class="col-md-2 col-sm-2 col-xs-6 col-lg-2">
	<div style="margin-right:5px; margin-bottom: 5px; padding:5px; font-size:15px; text-align:center; max-width:120px;">
	<div class="brands" ><img class="img-responsive" style= "display:block;max-width:100%;height:auto;width:100%; vertical-align: middle;" src="res/'.$row["pic"].'"></div><div  style="color:#000; font-weight:600; text-align:center;">'.$row["brand"].'</div>
	</div></div></a>';
}
?>