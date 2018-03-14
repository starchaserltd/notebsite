<?php
$idmodel=''; $conf=''; $nonexistent=1;
if(isset($_GET['ex']))
{
	$exchcode=strtoupper($_GET['ex']); $_SESSION['exchcode']=$exchcode;
	$query=mysqli_query($con,"SELECT * FROM notebro_site.exchrate");
	while( $row=mysqli_fetch_assoc($query))
	{
		if($row["code"]==$exchcode)
		{
			$country=$row["buy"];
			$lang=$row["id"]; $_SESSION['lang']=$lang;
			$exch=floatval($row["convr"]); $_SESSION['exch']=$exch;
			$exchsign=$row["sign"]; $_SESSION['exchsign']=$exchsign;
			break;
		}
	}
}
else 
{ 
	if(isset($_SESSION['lang'])) { $lang=$_SESSION['lang']; } else { $lang=0; }
	$country=mysqli_fetch_array(mysqli_query($con,"SELECT buy FROM notebro_site.exchrate WHERE id=$lang")); $country=$country["buy"];
	if(isset($_SESSION['exchcode'])){ $exchcode=$_SESSION['exchcode']; } else { $exchcode="USD"; }
	if(isset($_SESSION['exch'])){ $exch=$_SESSION['exch']; } else { $exch=1; }
	if(isset($_SESSION['exchsign'])){ $exchsign=$_SESSION['exchsign']; } else { $exchsign="$"; }
} 
//CODE FOR THE MODEL SEARCH
if(isset($_GET['conf']) && $_GET['conf']!="NaN") { $conf = $_GET['conf']; }
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
if(isset($idmodel) && $idmodel){  $conf=$id[0]."_".$idmodel; } // for a model
?>
<script>
var istime=0; var exch = <?php echo $exch; ?>; var lang = <?php echo $lang; ?>; var countrybuy="<?php echo $country; ?>"; var excode="<?php echo $exchcode; ?>";  var config_rate=0;
var config_price=0; var config_price1=0; var config_price2=0; var config_err=0; var config_batlife=1;</script>