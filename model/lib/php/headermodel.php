<?php
$idmodel=''; $conf=''; $nonexistent=1; $lang=-1; $components_found=false; $pos_ex_change=false;

$sel2="SELECT id,convr,code,sign,regions,ex_war FROM notebro_site.exchrate";
$result=mysqli_query($con,$sel2); $exchange_list=new stdClass(); $region_ex=array();
while($row=mysqli_fetch_assoc($result))
{
	$exchange_list->{$row["code"]}=array("id"=>$row["id"],"convr"=>floatval($row["convr"]),"sign"=>$row["sign"],"regions"=>explode(",",$row["regions"]),"ex_war"=>$row["ex_war"]);
	foreach($exchange_list->{$row["code"]}["regions"] as $el){ $el=intval($el); $region_ex[$el][]=$row["code"];}
}
mysqli_free_result($result);

if(isset($_GET['ex']))
{
	$get_ex=strtoupper(clean_string($_GET["ex"]));
	if((!isset($_SESSION['exchcode']))||(isset($_SESSION['exchcode_change'])&&$_SESSION['exchcode_change'])){ $exchcode=$get_ex; $_SESSION['exchcode']=$exchcode; $_SESSION['exchcode_change']=false;}else{$exchcode=$_SESSION['exchcode'];}
}
else
{ if(isset($_SESSION['exchcode'])){ $exchcode=$_SESSION['exchcode']; } else { $exchcode="USD"; } }

$row=$exchange_list->{$exchcode};
$ex_regions=$row["regions"];
$country=implode(",",$ex_regions);
$lang=intval($row["id"]); $_SESSION['lang']=$lang;
$exch=floatval($row["convr"]); $_SESSION['exch']=$exch;
$exchsign=$row["sign"]; $_SESSION['exchsign']=$exchsign;
if($row["ex_war"]&&$row["ex_war"]!=""&&$row["ex_war"]!=NULL){$ex_war=explode(",",$row["ex_war"]);}else{$ex_war=[-1];} $_SESSION['ex_war']=$ex_war;

//CODE FOR THE MODEL SEARCH
if(isset($_GET['conf']) && $_GET['conf']!="NaN") { $conf = clean_string($_GET['conf']); }
if(isset($_GET['model_id']) && $_GET['model_id']!="NaN")
{
	require_once("../etc/con_sdb.php"); $id=array(); $id[0]=0;
	$cons=dbs_connect();
	$idmodel=clean_string($_GET['model_id']);
	if(stripos($idmodel,"_np")!==FALSE){$idmodel=explode("_",$idmodel)[0]; $try_for_exact_model=true;}else{$try_for_exact_model=false;}

	$conf=array(); $conf[0]=$idmodel; if(count($ex_war)>0){$conf[12]=implode(",",$ex_war);}else{$conf[12]="-1";} $warnotin=" NOT";
	$include_getconf=true; $conf_only_search=false; $excode=$exchcode; $comp="1=1"; $any_conf_search=true;
	require_once("lib/php/query/getconf.php");
	if($rows["cid"]!=0)
	{
		$idmodel=$rows["cmodel"];
		$id[0]=$rows["cid"]; $idcpu=$rows["all"]["cpu"]; $iddisplay=$rows["all"]["display"]; $idmem=$rows["all"]["mem"]; $idhdd=$rows["all"]["hdd"]; $idshdd=$rows["all"]["shdd"]; $idgpu=$rows["all"]["gpu"];
		$idwnet=$rows["all"]["wnet"]; $idodd=$rows["all"]["odd"]; $idmdb=$rows["all"]["mdb"]; $idchassis=$rows["all"]["chassis"]; $idacum=$rows["all"]["acum"]; $idwar=$rows["all"]["war"]; $idsist=$rows["all"]["sist"];
		$idmodel=$rows["cmodel"]; $components_found=true;
	}
	else
	{ $sql="SELECT id FROM `notebro_temp`.`all_conf_".$idmodel."` ORDER BY VALUE DESC LIMIT 1"; $result=mysqli_query($cons,$sql); if($result){ $id=mysqli_fetch_row($result); } }
	mysqli_close($cons);
}

if(isset($idmodel) && $idmodel){  $conf=$id[0]."_".$idmodel; } // for a model
$usertag=""; if($conf){ if(isset($_GET["ref"])&&$_GET["ref"]!=""){ $usertag=mysqli_real_escape_string($con,filter_var($_GET["ref"], FILTER_SANITIZE_STRING)); } }
?>
<script>
var istime=0; var show_comp_message=0; var lang = <?php echo $lang; ?>; var countrybuy="<?php echo $country; ?>"; var excode="<?php echo $exchcode; ?>";  var config_rate=0;
var config_price=0; var config_price1=0; var config_price2=0; var config_err=0; var config_batlife=1; </script>