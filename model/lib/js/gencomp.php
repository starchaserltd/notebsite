<?php
/* HERE WE GENERATE THE ACTUAL COMPARE INFORMATION USING JAVASCRIPT */
header('Content-Type: application/javascript');

require_once("../../../etc/session.php"); 
require_once("../../../etc/conf.php");
require_once("../../../etc/con_db.php");
require_once("../../../etc/con_sdb.php");
require_once("../php/gencompfunc.php");

if(isset($_SESSION['exchcode'])){ $exchcode=$_SESSION['exchcode']; } else {$exchcode="USD";} 
if(isset($_SESSION['exchsign'])){ $exchsign=$_SESSION['exchsign']; } else {$exchsign="$";} 
if(isset($_SESSION['exch'])){ $exch=$_SESSION['exch']; } else { $exch=1; }
$delshdd=1; $delodd=1;

$nrconf= $_SESSION['java_nrconf']; $nrgetconfs=$_SESSION['java_nrgetconfs']; $getconfs=$_SESSION['java_getconfs']; $idconf=$_SESSION['java_idconf'];
if($nrgetconfs>0) { $nrconf=$nrgetconfs-1; }
$maxminvalues=(object) [];
for($x = 0; $x <= $nrconf; $x++) 
{
	if($nrgetconfs>0) { $confid=$getconfs[$x]; }
	else { $confid = $_SESSION['conf'.$idconf[$x]]['id']; }
	$cons=dbs_connect();
	$sql="SELECT * FROM notebro_temp.all_conf_".table($confid)." WHERE id = $confid";
	$result = mysqli_query($cons,$sql);
	$row = mysqli_fetch_assoc($result);
	mysqli_close($cons);
	$conf_model = $row['model'];
	$cpu_conf_cpu= $row['cpu'];
	$disp_conf_display = $row['display'];
	$gpu_conf_gpu = $row['gpu'];
	$hdd_conf_hdd = $row['hdd'];
	$shdd_conf_shdd = $row['shdd'];
	$acum_conf_acum = $row['acum'];
	$mdb_conf_mdb = $row['mdb'];
	$mem_conf_mem = $row['mem'];
	$odd_conf_odd = $row['odd'];
	$chassis_conf_chassis = $row['chassis'];
	$wnet_conf_wnet = $row['wnet'];
	$war_conf_war = $row['war'];
	$sist_conf_sist = $row['sist'];
	$rate_conf_rate = $row['rating'];
	$price_conf_price = $row['price'];
	$err_conf_err = $row['err'];
	$batlife_conf_batlife = $row['batlife'];
?>
	<!-- HEADER CSS -->
<?php 
	show('MODEL',$conf_model ); 
	if(isset($getconfs[$x])){ $cfg_id=$getconfs[$x];  } else { $cfg_id=$_SESSION['conf'.$idconf[$x]]["id"]; }

	preg_match('/(.*)\.(jpg|png)/', $resu["img_1"],$img);
	$img=$img[1];
	$maxminvalues=bluered(floatval($rate_conf_rate),$maxminvalues,$x,"rating",0);
	$maxminvalues=bluered(floatval($price_conf_price),$maxminvalues,$x,"price",1);
	$maxminvalues=bluered(floatval($batlife_conf_batlife),$maxminvalues,$x,"batlife",0);
	$model_title='<a href="?model/model.php'."?conf=".$confid.'"><span class="tbltitle">'.$resu['prod']." ".$resu['fam']." ".$resu['model'].$resu['mdbname']." ".$resu['submodel'].'</span></a>';
	$vars=array(
		'<a style="align-items:center; margin:0 auto" href="?model/model.php'."?conf=".$confid.'">'.'<img src="res/img/models/thumb/t_'.$img.'.jpg" class="img-responsive comparejpg" alt="Image for '.$resu['model'].'"></a>',
		$model_title,
		'<span class="col-sm-12 col-md-12 col-xs-12 col-lg-12 nopding"><span style="color:black; font-weight:bold;">Rating: </span><br class="brk"><span id="rating'.$x.'">'.round($rate_conf_rate/100,1)." / 100</span></span>",
		'<span class="col-sm-12 col-md-12 col-xs-12 col-lg-12 nopding" style="color:black;"><span style="color:black; font-weight:bold;">Price: </span><br class="brk"><span id="price'.$x.'">'.$exchsign." ".round(($price_conf_price-$err_conf_err/2)*$exch,0)." - ".round(($price_conf_price+$err_conf_err/2)*$exch,0)."</span></span>",
		'<span class="col-sm-12 col-md-12 col-xs-12 col-lg-12 nopding" style="color:black;"><span style="color:black; font-weight:bold;">Battery:  </span><br class="brk"><span id="batlife'.$x.'">'.round(($batlife_conf_batlife*0.95),1)." - ".round(($batlife_conf_batlife*1.02),1)." h</span></span>",
		'<a style="color:black;"><span class="col-xs-8 col-md-6 col-sm-6 col-md-offset-3  col-sm-offset-3 col-xs-offset-2 addtocpmp" onclick="removecomp('."-+-".$cfg_id."-+-".',1)">Remove</span></a>'
	);

	$danvar=implode("','",$vars);
	$danvar="'".$danvar."'";
?>
	var array_var=[<?php echo $danvar; ?>];
	addcolumn(array_var,"HEADER_table",""); 
	<!-- CPU -->
<?php 
	show('CPU',$cpu_conf_cpu);
	$maxminvalues=bluered(floatval($resu['rating']),$maxminvalues,$x,"cpurating",0);
	$vars=array(
		$resu['prod']." ".$resu['model'],
		$resu['ldate'],
		$resu['socket'],
		$resu['tech']." nm",
		$resu['cache']." MB",
		number_format(round($resu['clocks'],2),2)." GHz",
		number_format(round($resu['maxtf'],2),2)." GHz",
		$resu['cores'],
		$resu['tdp']." W",
		$resu['msc'],
		$resu['class'],
		'<span id="cpurating'.$x.'">'.$resu['rating'].'</span>',
	);
		 
	$danvar=implode("','",$vars);
	$danvar="'".$danvar."'";
?>
	var array_var=[<?php echo $danvar; ?>];
	addcolumn(array_var,"CPU_table",""); 
	<!-- GPU -->
<?php
	show('GPU',$gpu_conf_gpu);
	$maxminvalues=bluered(floatval($resu['rating']),$maxminvalues,$x,"gpurating",0);
	if(intval($resu['power'])!=0){$resu['power'].=" W";}
	$vars=array(
		$resu['prod']." ".$resu['model'],
		$resu['arch'],
		$resu['tech']." nm",
		$resu['pipe'],
		$resu['cspeed']." MHz",
		$resu['shader'],
		$resu['mspeed']." MHz",
		$resu['mbw']." bit",
		$resu['maxmem']." MB ".$resu["mtype"],
		$resu['sharem'],
		$resu['power'],
		$resu['msc'],
		$resu['gpuclass'],
		'<span id="gpurating'.$x.'">'.$resu['rating'].'</span>',
	);
		 
	$danvar=implode("','",$vars);
	$danvar="'".$danvar."'";
?>
	var array_var=[<?php echo $danvar; ?>];
	addcolumn(array_var,"GPU_table",""); 
	<!-- Display -->
<?php
	show('DISPLAY',$disp_conf_display);
	$maxminvalues=bluered(floatval($resu['hres'])*floatval($resu['vres']),$maxminvalues,$x,"resol",0);
	$addblue=""; if($resu['touch']=="YES") { $addblue='class="labelblue-s"'; }
	$vars=array(
		// $resu['model'],
		$resu['size'].' "',
		$resu['format'],
		'<span id="resol'.$x.'">'.$resu['hres']."x".$resu['vres'].'</span>',
		$resu['surft'],
		$resu['backt'],
		'<span id="touch'.$x.'" '.$addblue.' >'.$resu['touch'].'</span>',
		$resu['msc'],
		// $resu['rating'],
	);
	
	$danvar=implode("','",$vars);
	$danvar="'".$danvar."'";
?>
	var array_var=[<?php echo $danvar; ?>];
	addcolumn(array_var,"DISPLAY_table",""); 
	<!-- Storage -->
<?php 
	show('HDD',$hdd_conf_hdd);
	$maxminvalues=bluered(floatval($resu['rating']),$maxminvalues,$x,"storcap",0);
//	$maxminvalues=bluered(floatval($resu['readspeed']),$maxminvalues,$x,"storspeed",0);
	if(!$resu['msc']){$resu['msc']="-";}
	$vars=array(
		// $resu['model'],
		'<span id="storcap'.$x.'">'.$resu['cap']." GB".'</span>',
		$resu['rpm'],
		$resu['type'],
		'<span id="storspeed'.$x.'">'.$resu['readspeed']." MB/s".'</span>',
		$resu['writes']." MB/s",
		$resu['msc'],
	);
		 
	$danvar=implode("','",$vars);
	$danvar="'".$danvar."'";
?>
	addcolumn(<?php echo "['".$model_title."']"; ?>,"title_STORAGE",'style="border-top: 0px;"'); 
	var array_var=[<?php echo $danvar; ?>];
	addcolumn(array_var,"STORAGE_table",""); 
	<!-- Secondary Storage -->
<?php
	show('HDD',$shdd_conf_shdd);
	if (!($shdd_conf_shdd == "0" || $shdd_conf_shdd ==""))
	{
		$maxminvalues=bluered(floatval($resu['cap']),$maxminvalues,$x,"storcap2",0);
		$delshdd=0;
		$vars=array(
			'<span id="storcap2'.$x.'">'.$resu['cap']." GB".'</span>',
			$resu['rpm'],
			$resu['type'],
			$resu['readspeed']." MB/s",
			$resu['writes']." MB/s",
		);
	}
	else
	{
		$vars=array(
			"-",
			"-",
			"-",
			"-",
			"-",
		);
	}
	$danvar=implode("','",$vars);
	$danvar="'".$danvar."'";
?>
	var array_var=[<?php echo $danvar; ?>];
	addcolumn(array_var,"SSTORAGE_table",""); 
	<!-- Motherboard -->	
<?php
	show('MDB',$mdb_conf_mdb);
	$vars=array(
		//	$resu['model'],
		$resu['ram'],
		$resu['chipset'],
		$resu['interface'],
		$resu['netw'],
		$resu['hdd'],
		$resu['msc'],
	);
		 
	$danvar=implode("','",$vars);
	$danvar="'".$danvar."'";
?>
	var array_var=[<?php echo $danvar; ?>];
	addcolumn(array_var,"MDB_table",""); 
	<!-- Memory -->
<?php
	show('MEM',$mem_conf_mem);
	$maxminvalues=bluered(floatval($resu['cap']),$maxminvalues,$x,"memcap",0);
	$vars=array(
		'<span id="memcap'.$x.'">'.$resu['cap']." GB".'</span>',
		$resu['stan'],
		$resu['type']." MHz",
		$resu['lat'],
		$resu['msc'],
	);
		 
	$danvar=implode("','",$vars);
	$danvar="'".$danvar."'";
?>
	var array_var=[<?php echo $danvar; ?>];
	addcolumn(array_var,"MEM_table",""); 
	<!--ODD-->
<?php
	show('ODD',$odd_conf_odd);
	if($resu['type']!="-") { $delodd=0;}
	$vars=array(
		$resu['type'],
		$resu['speed'],
		$resu['msc'],
	);
		 
	$danvar=implode("','",$vars);
	$danvar="'".$danvar."'";
?>
	addcolumn(<?php echo "['".$model_title."']"; ?>,"title_ODD",'style="border-top: 0px;"'); 
	var array_var=[<?php echo $danvar; ?>];
	addcolumn(array_var,"ODD_table",""); 
	<!--Acumulator-->
<?php
	show('ACUM',$acum_conf_acum);
	$vars=array(
		$resu['cap']." Whr",
		$resu['tipc'],
		$resu['weight'],
		$resu['msc'],
	);
		 
	$danvar=implode("','",$vars);
	$danvar="'".$danvar."'";
?>
	var array_var=[<?php echo $danvar; ?>];
	addcolumn(array_var,"ACUM_table",""); 
	<!--Chassis-->
<?php
	show('CHASSIS',$chassis_conf_chassis);
	$maxminvalues=bluered(floatval($resu['weight']),$maxminvalues,$x,"weight",1);
	if(intval($resu['web'])!=0){$resu['web'].=" MP";}
	$vars=array(
		$resu['pi'],
		$resu['vi'],
		$resu['web'],
		$resu['touch'],
		$resu['keyboard'],
		$resu['charger'],
		'<span id="weight'.$x.'">'.$resu['weight'].'</span>',
		$resu['thic'],
		$resu['depth'],
		$resu['width'],
		$resu['color'],
		$resu['made'],
		$resu['msc'],
	);
		 
	$danvar=implode("','",$vars);
	$danvar="'".$danvar."'";
?>
	var array_var=[<?php echo $danvar; ?>];
	addcolumn(array_var,"CHASSIS_table",""); 
	<!--Wnet-->		
<?php
	show('WNET',$wnet_conf_wnet);
	if(intval($resu['speed'])>0){$resu['speed'].=" Mbps";} else { $resu['speed']="-";}
	$vars=array(
		$resu['model'],
		$resu['slot'],
		$resu['speed'],
		$resu['stand'],
		$resu['msc'],
	);
	 
	$danvar=implode("','",$vars);
	$danvar="'".$danvar."'";
?>
	addcolumn(<?php echo "['".$model_title."']"; ?>,"title_WNET",'style="border-top: 0px;"'); 
	var array_var=[<?php echo $danvar; ?>];
	addcolumn(array_var,"WNET_table",""); 
	<!--Warranty-->
<?php
	show('WAR',$war_conf_war);
	$maxminvalues=bluered(floatval($resu['years']),$maxminvalues,$x,"war",0);
	$vars=array(
		'<span id="war'.$x.'">'.$resu['years'].'</span>',
		$resu['msc'],
	);
		 
	$danvar=implode("','",$vars);
	$danvar="'".$danvar."'";
?>
	var array_var=[<?php echo $danvar; ?>];
	addcolumn(array_var,"WARA_table",""); 
	<!--Operating System-->
<?php
	show('SIST',$sist_conf_sist);
	$vars=array(
		$resu['sist']." ".$resu['vers']." ".$resu['type']
	);
		 
	$danvar=implode("','",$vars);
	$danvar="'".$danvar."'";
?>
	var array_var=[<?php echo $danvar; ?>];
	addcolumn(array_var,"OS_table",""); 
<?php
}

/* APPLYING BLUE/RED LABELS */
echo "\r\n";

foreach ($maxminvalues as $key => $value)
{
	if($value[0]!=$value[1])
	{
		foreach($value[0] as $val){ echo 'document.getElementById("'.$key.$val.'").className = "labelblue-s"; '; }
		foreach($value[1] as $val){ echo 'document.getElementById("'.$key.$val.'").className = "labelred-s"; '; }
	}
}

if($delshdd)
{
	echo 'mytbl = document.getElementById("SSTORAGE_table");
	mytbl.parentNode.removeChild(mytbl);
	mytbl = document.getElementById("title_SS");
	mytbl.parentNode.removeChild(mytbl);
	mytbl = document.getElementById("toggle_SS");
	mytbl.parentNode.removeChild(mytbl); ';
}

if($delodd)
{
	echo 'mytbl = document.getElementById("ODD_table");
	mytbl.parentNode.removeChild(mytbl);
	mytbl = document.getElementById("title_BAT");
	mytbl.parentNode.removeChild(mytbl);
	mytbl = document.getElementById("toggle_ODD");
	mytbl.parentNode.removeChild(mytbl);
	mytbl = document.getElementById("title_ODAC");
	mytbl.innerHTML = "Battery"; ';
}

//var_dump($maxminvalues);
?>
var nrrcomp=document.getElementsByClassName("addtocpmp").length;
for(var i = 0; i < nrrcomp; i++)
{
value=document.getElementsByClassName("addtocpmp")[i].getAttribute('onclick').replace(/\-\+\-/g,"'"); 
document.getElementsByClassName("addtocpmp")[i].setAttribute('onclick',value);
}

//STRIPE THE TABLES
stripeme("CPU_table");
stripeme("GPU_table");
stripeme("DISPLAY_table");
stripeme("STORAGE_table");
stripeme("SSTORAGE_table");
stripeme("MDB_table");
stripeme("MEM_table");
stripeme("ODD_table");
stripeme("ACUM_table");
stripeme("CHASSIS_table");
stripeme("WNET_table");
stripeme("WARA_table");
stripeme("OS_table");