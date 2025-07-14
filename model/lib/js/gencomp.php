<?php
/* HERE WE GENERATE THE ACTUAL COMPARE INFORMATION USING JAVASCRIPT */
header('Content-Type: application/javascript');

require_once("../../../etc/session.php");
require_once("../../../etc/conf.php");
require_once("../../../etc/con_db.php");
require_once("../../../etc/con_sdb.php");
require_once("../php/gencompfunc.php");
$buy_regions = array();
if (isset($_SESSION['excomp']))
{
	$exchcode = $_SESSION['excomp'];
	$_SESSION['exchcode'] = $exchcode;
	$query = mysqli_query($con, "SELECT * FROM `".$GLOBALS['global_notebro_site']."`.exchrate");

	while ($row = mysqli_fetch_assoc($query))
	{
		$buy_regions = array_merge($buy_regions, explode(",", $row["regions"]));
		if ($row["code"] == $exchcode)
		{
			$buy_regions = $row["regions"];
			$lang = $row["id"];
			$_SESSION['lang'] = $lang;
			$exch = floatval($row["convr"]);
			$_SESSION['exch'] = $exch;
			$exchsign = $row["sign"];
			$_SESSION['exchsign'] = $exchsign;
			break;
		}
	}

	if (!isset($exch))
	{
		$lang = 0;
		$exchcode = "USD";
		$exchsign = "$";
		$exch = 1;
		$buy_regions = implode(",", array_unique($buy_regions));
		$_SESSION['lang'] = $lang;
		$_SESSION['exch'] = $exch;
		$_SESSION['exchsign'] = $exchsign;
		$_SESSION['exchcode'] = $exchcode;
	}
} 
else
{
	$query = mysqli_query($con, "SELECT GROUP_CONCAT(regions) as regions FROM `"$GLOBALS['global_notebro_site']."`.exchrate LIMIT 1");
	$row = mysqli_fetch_assoc($query);
	$buy_regions = implode(",", array_unique(explode($row["regions"])));
	if (isset($_SESSION['lang'])){ $lang = $_SESSION['lang']; } else { $lang = 0; }
	if (isset($_SESSION['exchcode'])) { $exchcode = $_SESSION['exchcode']; } else { $exchcode = "USD"; }
	if (isset($_SESSION['exchsign'])) {	$exchsign = $_SESSION['exchsign']; } else { $exchsign = "$"; }
	if (isset($_SESSION['exch'])) {	$exch = $_SESSION['exch']; } else { $exch = 1; }
}

$delshdd = 1;
$delodd = 1;
$delmsc = 1;
$nrconf = $_SESSION['java_nrconf'];
$nrgetconfs = $_SESSION['java_nrgetconfs'];
$getconfs = $_SESSION['java_getconfs'];
$session_idconf = $_SESSION['java_session_idconf'];
if ($nrgetconfs > 0) {$nrconf = $nrgetconfs - 1; }

for ($x = 0; $x <= $nrconf; $x++)
{
	if ($nrgetconfs > 0) { $confid = $getconfs[$x]; } else { $confid = $_SESSION['conf'.$session_idconf[$x]]['id']; }

	$row = $_SESSION['compare_list'][$confid];
	$conf_model = trim($row['model']);
	$cpu_conf_cpu = trim($row['cpu']);
	$display_conf_display = trim($row['display']);
	$gpu_conf_gpu = trim($row['gpu']);
	$hdd_conf_hdd = trim($row['hdd']);
	$shdd_conf_shdd = trim($row['shdd']);
	$acum_conf_acum = trim($row['acum']);
	$mdb_conf_mdb = trim($row['mdb']);
	$mem_conf_mem = trim($row['mem']);
	$odd_conf_odd = trim($row['odd']);
	$chassis_conf_chassis = trim($row['chassis']);
	$wnet_conf_wnet = trim($row['wnet']);
	$war_conf_war = trim($row['war']);
	$sist_conf_sist = trim($row['sist']);
	$rate_conf_rate = normal_rating(floatval($row['rating']));
	$price_conf_price = floatval($row['price']);
	$err_conf_err = $row['err'];
	$batlife_conf_batlife = floatval($row['batlife']);
?>
	<!-- HEADER CSS -->
	var comp_conf_to_gen=<?php echo $x ?>;
	if(array_var_new==null || comp_conf_to_gen==0){ var array_var_new={}; }
	array_var_new[comp_conf_to_gen]={};
	array_var_new[comp_conf_to_gen]["INFO"]={};
	array_var_new[comp_conf_to_gen]["MODEL"]={};
	<?php
	show('`'.$GLOBALS['global_notebro_db'].'`.MODEL model JOIN `'.$GLOBALS['global_notebro_db'].'`.FAMILIES families on model.idfam=families.id', $conf_model);
	preg_match('/(.*)\.(jpg|png)/', $resu["img_1"], $img);
	$img = $img[1];
	$resu['mdbname'] = "";
	?>
	array_var_new[comp_conf_to_gen]["INFO"]["CONF_ID"]='<?php echo $confid ?>';
	<?php
	$model_comp_name = $resu['prod'] . " " . $resu['fam'] . " " . $resu['model'] . "" . $resu['submodel'] . $resu['mdbname'] . " " . $resu['region'];
	$model_msc = $resu['msc'];
	$ref_tag = "";
	$conf_data="";
	$conf_data='data-idmodel="'.$conf_model.'"';
	foreach ($laptop_comp_list as $comp) { $conf_data=$conf_data.' data-id'.$comp.'="'.${$comp."_conf_".$comp}.'"'; }
	?>
	array_var_new[comp_conf_to_gen]["MODEL"]["COMP_NAME"]='<?php echo $model_comp_name; ?>';
	array_var_new[comp_conf_to_gen]["MODEL"]["SIMPLE_NAME"]='<?php echo $resu['prod'] . " " . $resu['fam'] . " " . $resu['model']; ?>';
	array_var_new[comp_conf_to_gen]["MODEL"]["MSC_INFO"]='<?php echo $model_msc; ?>';
	array_var_new[comp_conf_to_gen]["MODEL"]["IMG"]='<?php echo $img; ?>';
	array_var_new[comp_conf_to_gen]["MODEL"]["ID"]='<?php echo $conf_model; ?>';
	array_var_new[comp_conf_to_gen]["MODEL"]["BUY"]={};
	array_var_new[comp_conf_to_gen]["MODEL"]["BUY"]["buyregions"]='<?php echo $buy_regions; ?>';
	array_var_new[comp_conf_to_gen]["MODEL"]["BUY"]["lang"]='<?php echo $lang; ?>';
	array_var_new[comp_conf_to_gen]["MODEL"]["BUY"]["conf_data"]='<?php echo $conf_data; ?>';
	array_var_new[comp_conf_to_gen]["MODEL"]["BUY"]["mprod"]='<?php echo $resu['prod']; ?>';
	array_var_new[comp_conf_to_gen]["MODEL"]["BUY"]["pmodel"]='<?php echo $resu["p_model"]; ?>';
	array_var_new[comp_conf_to_gen]["MODEL"]["BUY"]["ref"]='<?php echo $ref_tag; ?>';
	array_var_new[comp_conf_to_gen]["MODEL"]["PRICE"]='<?php echo round(($price_conf_price) * $exch, 0); ?>';
	//array_var_new[comp_conf_to_gen]["MODEL"]["PRICE_MIN"]='<?php echo round(($price_conf_price - $err_conf_err / 2) * $exch, 0); ?>';
	//array_var_new[comp_conf_to_gen]["MODEL"]["PRICE_MAX"]='<?php echo round(($price_conf_price + $err_conf_err / 2) * $exch, 0); ?>';
	array_var_new[comp_conf_to_gen]["MODEL"]["BATLIFE"]='<?php echo $batlife_conf_batlife; ?>';
	array_var_new[comp_conf_to_gen]["MODEL"]["RATING"]='<?php echo round($rate_conf_rate / 100, 1); ?>';
	array_var_new[comp_conf_to_gen]["MODEL"]["EXCH_SIGN"]='<?php echo $exchsign; ?>';

	<?php
	
	if (!function_exists("gen_js_object"))
	{

		function gen_js_object($array)
		{
			$object = "{";
			$object_parts = array();
			foreach ($array as $key => $val) {
				$val = str_replace('"', '\"', $val);
				$object_parts[] = $key . ':' . '"' . $val . '"';
			}
			$object_parts[] = "tags" . ':' . '[]';
			$object .= implode(",", $object_parts);
			$object .= "}";
			return $object;
		}
	}
	
	if ($x == 0) {
		echo 'document.title="Noteb - ";';
	}
	?>
	document.title = document.title +
	<?php
	
	if ($x > 0) {
		echo "' vs '";
	} else {
		echo "' '";
	} ?> + '<?php echo $resu['prod'] . " " . $resu['fam'] . " " . $resu['model']; ?> '; excode='<?php echo  $exchcode ?>';
	

	<!-- CPU -->
	<?php
	$new_to_add = NULL;
	show('CPU', $cpu_conf_cpu);

	$resu['model'] = $resu['prod'] . " " . $resu['model'];
	$resu['clocks'] = number_format(round($resu['clocks'], 2), 2) . " GHz";
	$resu['maxtf'] = number_format(round($resu['maxtf'], 2), 2) . " GHz";
	$resu['tech'] = $resu['tech'] . " nm";
	$resu['cache'] = $resu['cache'] . " MB";
	$resu['tdp'] = $resu['tdp'] . " W";

	$new_to_add = gen_js_object($resu);

	?>
	array_var_new[comp_conf_to_gen]["CPU"]=<?php echo $new_to_add ?>;
	//proc_min_max_val("CPU","rating",array_var_new[comp_conf_to_gen]["CPU"]["rating"],0);
	<!-- addcolumn(array_var,"CPU_table",""); -->
	<!-- GPU -->
	<?php
	$new_to_add = NULL;
	show('GPU', $gpu_conf_gpu);
	
	if(intval($resu['power'])!=0) { $resu['power'].=" W"; }

	$resu['model'] = $resu['prod']." ".$resu['name'];
	$resu['tech'] = $resu['tech']." nm";
	$resu['cspeed'] = $resu['cspeed']." MHz";
	$resu['mspeed'] = $resu['mspeed']." MHz";
	$resu['mbw'] = $resu['mbw']." bit";
	$resu['vmem'] = $resu['maxmem']." MB ".$resu["mtype"];

	$new_to_add = gen_js_object($resu);
	?>
	array_var_new[comp_conf_to_gen]["GPU"]=<?php echo $new_to_add ?>;
	//proc_min_max_val("GPU","rating",array_var_new[comp_conf_to_gen]["GPU"]["rating"],0);
	<!-- addcolumn(array_var,"GPU_table",""); -->
	<!-- Display -->
	<?php
	$new_to_add = NULL;
	show('DISPLAY', $display_conf_display);
	$addblue = ""; if ($resu['touch'] == "YES") { $addblue = 'class="labelblue-s"'; }

	$resu['dcip3'] = $resu['dci-p3'];
	unset($resu['dci-p3']);
	$resu['size'] = $resu['size'] . ' "';
	$resu['resolution'] = $resu['hres'] . "x" . $resu['vres'];
	$resu["touch_addblue"] = $addblue;

	$new_to_add = gen_js_object($resu);
	?>
	array_var_new[comp_conf_to_gen]["DISPLAY"]=<?php echo $new_to_add ?>;
	<!-- addcolumn(array_var,"DISPLAY_table",""); -->
	<!-- Storage -->
	<?php
	$new_to_add = NULL;
	show('HDD', $hdd_conf_hdd);
	if (!$resu['msc']) { $resu['msc'] = "-"; }

	$resu['cap'] = $resu['cap']." GB";
	$resu['readspeed'] = $resu['readspeed']." MB/s";
	$resu['writes'] = $resu['writes']." MB/s";

	$new_to_add = gen_js_object($resu);
	?>
	array_var_new[comp_conf_to_gen]["STORAGE"]=<?php echo $new_to_add ?>;
	<!-- addcolumn(array_var,"STORAGE_table",""); -->
	<!-- Secondary Storage -->
	<?php
	$new_to_add = NULL;
	show('HDD', $shdd_conf_shdd);
	$resu['cap'] = "-";
	$resu['rpm'] = "-";
	$resu['type'] = "-";
	$resu['readspeed'] = "-";
	$resu['writes'] = "-";

	if (!($shdd_conf_shdd == "0" || $shdd_conf_shdd == ""))
	{
		$delshdd = 0;

		$resu['cap'] = $resu['cap']." GB";
		$resu['readspeed'] = $resu['readspeed']." MB/s";
		$resu['writes'] = $resu['writes']." MB/s";
	}
	else
	{	}
	$new_to_add = gen_js_object($resu);
	?>
	array_var_new[comp_conf_to_gen]["SSTORAGE"]=<?php echo $new_to_add ?>;
	<!-- addcolumn(array_var,"SSTORAGE_table",""); -->
	<!-- Motherboard -->
	<?php
	$new_to_add = NULL;
	show('MDB', $mdb_conf_mdb);

	$new_to_add = gen_js_object($resu);
	?>
	array_var_new[comp_conf_to_gen]["MDB"]=<?php echo $new_to_add ?>;
	<!-- addcolumn(array_var,"MDB_table",""); -->

	<!-- Memory -->
	<?php
	$new_to_add = NULL;
	show('MEM', $mem_conf_mem);

	$resu['cap'] = $resu['cap'] . " GB";
	$resu['type'] = $resu['type'] . " MHz";

	$new_to_add = gen_js_object($resu);
	?>
	array_var_new[comp_conf_to_gen]["MEM"]=<?php echo $new_to_add ?>;
	<!-- addcolumn(array_var,"MEM_table",""); -->
	<!--ODD-->
	<?php
	$new_to_add = NULL;
	show('ODD', $odd_conf_odd);
	if ($resu['type'] != "-") {	$delodd = 0; }

	$new_to_add = gen_js_object($resu);
	?>
	array_var_new[comp_conf_to_gen]["ODD"]=<?php echo $new_to_add ?>;
	<!-- addcolumn(array_var,"ODD_table",""); -->
	<!--Acumulator-->
	<?php
	$new_to_add = NULL;
	show('ACUM', $acum_conf_acum);

	$resu['cap'] = $resu['cap'] . " Whr";

	$new_to_add = gen_js_object($resu);
	?>
	array_var_new[comp_conf_to_gen]["ACUM"]=<?php echo $new_to_add ?>;
	<!-- addcolumn(array_var,"ACUM_table",""); -->
	<!--Chassis-->
	<?php
	$new_to_add = NULL;
	show('CHASSIS', $chassis_conf_chassis);
	if (floatval($resu['web']) > 0.05) { $resu['web'] .= " MP"; }

	$new_to_add = gen_js_object($resu);
	?>
	array_var_new[comp_conf_to_gen]["CHASSIS"]=<?php echo $new_to_add ?>;
	proc_min_max_val("CHASSIS","weight",array_var_new[comp_conf_to_gen]["CHASSIS"]["weight"],1);
	<!-- addcolumn(array_var,"CHASSIS_table",""); -->
	<!--Wnet-->
	<?php
	$new_to_add = NULL;
	show('WNET', $wnet_conf_wnet);
	if (intval($resu['speed']) > 0) { $resu['speed'] .= " Mbps"; }
	else { $resu['speed'] = "-"; }

	$new_to_add = gen_js_object($resu);
	?>
	array_var_new[comp_conf_to_gen]["WNET"]=<?php echo $new_to_add ?>;
	<!-- addcolumn(array_var,"WNET_table",""); -->
	<!--Warranty-->
	<?php
	$new_to_add = NULL;
	show('WAR', $war_conf_war);

	$new_to_add = gen_js_object($resu);
	?>
	array_var_new[comp_conf_to_gen]["WAR"]=<?php echo $new_to_add ?>;
	<!-- addcolumn(array_var,"WARA_table",""); -->
	<!--Operating System-->
	<?php
	$new_to_add = NULL;
	show('SIST', $sist_conf_sist);

	$new_to_add = gen_js_object($resu);
	?>
	array_var_new[comp_conf_to_gen]["OS"]=<?php echo $new_to_add ?>;
	<!-- addcolumn(array_var,"OS_table",""); -->
	<!-- Model Miscellaneous -->
	<?php
	$new_to_add = NULL;
	if ($model_msc != "") { $delmsc = 0; }

	$new_to_add = $model_msc;
	?>
	array_var_new[comp_conf_to_gen]["MSC"]="<b><?php echo trim($new_to_add); ?></b>";
	<!-- addcolumn(array_var,"MSC_table",""); -->
<?php
}

/* DELETING FIELDS WITHOUT DATA */
echo "\r\n";

if ($delshdd){ echo '(function() { Object.keys(array_var_new).forEach(function(key) { delete window.array_var_new[key]["SSTORAGE"] }) })();'; }
if ($delodd){ echo '(function() { Object.keys(array_var_new).forEach(function(key) { delete window.array_var_new[key]["ODD"] }) })();'; }
if ($delmsc){ echo '(function() { Object.keys(array_var_new).forEach(function(key) { delete window.array_var_new[key]["MSC"] }) })();'; }

?>
function proc_min_max_val(component, field, new_val, rev)
{
	new_val = parseFloat(new_val);
	var local_min_value = new_val;
	var local_max_value = new_val;

	var comp_css_max = "labelblue-s";
	var comp_css_min = "labelred-s";

	for (var key in array_var_new)
	{
		if (array_var_new[key][component] != null)
		{
			if (array_var_new[key][component].tags == null)
			{
				array_var_new[key][component].tags = {};
			}
			if (array_var_new[key][component].tags[field] == null)
			{
				array_var_new[key][component].tags[field] = [comp_css_min, comp_css_max];
			}

			if (array_var_new[key][component].tags[field].indexOf(comp_css_min) > -1)
			{
				if (((local_min_value < parseFloat(array_var_new[key][component][field])) && (!rev)) || ((local_min_value> parseFloat(array_var_new[key][component][field])) && (rev)))
				{
					array_var_new[key][component].tags[field].splice(array_var_new[key][component].tags[field].indexOf(comp_css_min), 1);
				}
				else
				{ local_min_value = parseFloat(array_var_new[key][component][field]); }
			}

			if (array_var_new[key][component].tags[field].indexOf(comp_css_max) > -1)
			{
				if (((local_max_value > parseFloat(array_var_new[key][component][field])) && (!rev)) || ((parseFloat(array_var_new[key][component][field] > local_max_value )) && (rev)))
				{ array_var_new[key][component].tags[field].splice(array_var_new[key][component].tags[field].indexOf(comp_css_max), 1); } else { local_max_value=parseFloat(array_var_new[key][component][field]); }
			}
		}
	}
}
	
$(document).ready(function()
{
	var nrrcomp=document.getElementsByClassName("addtocpmp").length;
	for (var i=0; i < nrrcomp; i++) { value=document.getElementsByClassName("addtocpmp")[i].getAttribute('onclick').replace(/\-\+\-/g, "'" ); document.getElementsByClassName("addtocpmp")[i].setAttribute('onclick', value); }
	var confstoremove=["<?php echo implode('","', $_SESSION['toalert']); ?>"];
	if (confstoremove[0] !=="" )
	{
		for (var key in confstoremove)
		{
			var notreplaced=1; if (notreplaced) { currentPage=currentPage.replace(new RegExp("&conf[\\d+]=" + confstoremove[key], 'i'), function replacing() { notreplaced = 0; return ""; }) }
			if (notreplaced)
			{ currentPage = currentPage.replace(new RegExp(" conf[\\d+]=" + confstoremove[key] + " &", 'i' ), function replacing() { notreplaced=0; return "" ; }) }
				
			if (notreplaced) { currentPage=currentPage.replace(new RegExp("conf[\\d+]=" + confstoremove[key], 'i'), function replacing() { notreplaced = 0; return ""; }) }
		}

		var stateObj = { no: " empty" }; setTimeout(function() { gocomp=1; }, 10);
		history.replaceState(stateObj, document.title, currentPage);
	}
});

var lang=<?php echo $lang; ?>;