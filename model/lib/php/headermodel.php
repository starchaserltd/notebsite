<?php
$idmodel=''; $conf=''; $nonexistent=1;
if(isset($_SESSION['lang'])) { $lang=$_SESSION['lang']; } else { $lang=0; }
$country=mysqli_fetch_array(mysqli_query($con,"SELECT buy FROM notebro_site.exchrate WHERE id=$lang"));
if(isset($_SESSION['exchcode'])){ $exchcode=$_SESSION['exchcode']; }
if(isset($_SESSION['exch'])){ $exch=$_SESSION['exch']; } else { $exch=1; }
if(isset($_SESSION['exchsign'])){ $exchsign=$_SESSION['exchsign']; } else { $exchsign="$"; }
//CODE FOR THE MODEL SEARCH
if(isset($_GET['model_id']) && $_GET['model_id']!="NaN")
{
	require_once("../etc/con_sdb.php");
	$cons=dbs_connect();
	$idmodel=$_GET['model_id'];
	$sql="SELECT id FROM notebro_temp.all_conf_".$idmodel." ORDER BY VALUE DESC LIMIT 1";
	$result=mysqli_query($cons,$sql);
	$id=mysqli_fetch_row($result);
	mysqli_close($cons);
}
if(isset($_GET['conf']) && $_GET['conf']!="NaN") { $conf = (string)($_GET['conf']); }
if(isset($idmodel) && $idmodel){  $conf=$id[0]; } // for a model
?>
<script>
var istime=0; var exch = <?php echo $exch; ?>; var lang = <?php echo $lang; ?>; var countrybuy="<?php echo $country["buy"]; ?>"; var config_rate=0;
var config_price=0; var config_price1=0; var config_price2=0; var config_err=0; var config_batlife=1;</script>