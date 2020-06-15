<?php
require_once("../../etc/session.php");
require_once("../../etc/con_db.php");
require_once("../../etc/con_sdb.php");
require_once("../../etc/conf.php");
?>
<?php
if(isset($_POST['sendid'])){ $config_id = mysqli_real_escape_string($con,filter_var($_POST['sendid'], FILTER_SANITIZE_STRING)); }
else
{
	$conf_model = intval($_POST['sendmid']); $conf_cpu=intval($_POST['sendcpu']); $conf_gpu=intval($_POST['sendgpu']); $conf_disp=intval($_POST['senddisp']); $conf_hdd=intval($_POST['sendhdd']); $conf_shdd=intval($_POST['sendshdd']);
	$conf_mem=intval($_POST['sendmem']); $conf_chassis=intval($_POST['sendchassis']); $conf_odd=intval($_POST['sendodd']); $conf_wnet=intval($_POST['sendwnet']); $conf_war=intval($_POST['sendwar']); $conf_sist=intval($_POST['sendsis']);
	$conf_acum=intval($_POST['sendacum']);  $conf_mdb=intval($_POST['sendmdb']);
	$config_id=0;
	$conf_cpu_name= mysqli_real_escape_string($con,filter_var($_POST['sendcpuname'], FILTER_SANITIZE_STRING)); $conf_gpu_name= mysqli_real_escape_string($con,filter_var($_POST['sendgpuname'], FILTER_SANITIZE_STRING)); $conf_display_size= mysqli_real_escape_string($con,filter_var($_POST['senddissize'], FILTER_SANITIZE_STRING));
	$conf_display_res=mysqli_real_escape_string($con,filter_var($_POST['senddisres'], FILTER_SANITIZE_STRING));	$conf_mem_info=mysqli_real_escape_string($con,filter_var($_POST['sendmeminfo'], FILTER_SANITIZE_STRING)); $conf_hdd_info=mysqli_real_escape_string($con,filter_var($_POST['sendhddinfo'], FILTER_SANITIZE_STRING));
}

if($config_id)
{
	$t=table($config_id); $config_id=$t[0];
	$sql="SELECT id,cpu,gpu,display,mem,hdd,model FROM notebro_temp.all_conf_".$t[1]." WHERE id=$config_id LIMIT 1";;
}
else
{
	$sql="SELECT id FROM notebro_temp.all_conf_".$conf_model." WHERE cpu=".$conf_cpu." AND gpu=".$conf_gpu." AND display=".$conf_disp." AND hdd=".$conf_hdd." AND shdd=".$conf_shdd." AND acum=".$conf_acum." AND mdb=".$conf_mdb." AND mem=".$conf_mem." AND odd=".$conf_odd." AND chassis=".$conf_chassis." AND wnet=".$conf_wnet." AND war=".$conf_war." AND sist=".$conf_sist." LIMIT 1";
}
$cons=dbs_connect();
$result = mysqli_query($cons,$sql);
$row = mysqli_fetch_array($result);
mysqli_close($cons);

if($config_id)
{
	$conf_model=$row["model"];

	$sql2='SELECT model FROM CPU WHERE id='.$row["cpu"];
	$result2 = mysqli_query($con,$sql2);
	$r = mysqli_fetch_assoc($result2); 
	$conf_cpu_name=$r["model"];

	$sql2='SELECT prod,name FROM GPU WHERE id='.$row["gpu"];
	$result2 = mysqli_query($con,$sql2);
	$r = mysqli_fetch_assoc($result2); 
	$conf_gpu_name=$r["prod"]." ".$r["model"];

	$sql2='SELECT size,hres,vres FROM DISPLAY WHERE id='.$row["display"];
	$result2 = mysqli_query($con,$sql2);
	$r = mysqli_fetch_assoc($result2); 
	$conf_display_size=$r['size'];
	$conf_display_res=$r['hres']."x".$r['vres'];

	$sql2='SELECT cap,type FROM MEM WHERE id='.$row["mem"];
	$result2 = mysqli_query($con,$sql2);
	$r = mysqli_fetch_assoc($result2); 
	$conf_mem_info=$r['cap']."GB ".$r['type'];

	$sql2='SELECT cap,type FROM HDD WHERE id='.$row["hdd"];
	$result2 = mysqli_query($con,$sql2);
	$r = mysqli_fetch_assoc($result2); 
	$conf_hdd_info=$r['cap']."GB ".$r['type'];
}

$currentconf=array("checked" =>0, "id" => $row["id"]."_".$conf_model ,"name" => $conf_model, "model"=> $conf_model , "cpu_info" => $conf_cpu_name, "gpu_info" => $conf_gpu_name, "disp_size" => $conf_display_size, "disp_res" => $conf_display_res, "mem_info" => $conf_mem_info, "hdd_info" => $conf_hdd_info );

$ij=0; $k=0; $nrcheck=-1; $already=1;
for($i=0;$i<=9;$i++)
{
	if(isset($_SESSION['conf'.$i]) && $_SESSION['conf'.$i])
	{ 	
		if($_SESSION['conf'.$i]["checked"])
		{ $nrcheck++; }
		
		if($_SESSION['conf'.$i]["model"]==$currentconf["model"])
		{ 
			if($_SESSION['conf'.$i]["id"]!=$currentconf["id"]) 
			{ $k++; } 
			else
			{ $already=0; }
		}
	$ij++;
	}
}
$i=$ij;
if($already)
{
	if($i>9)
	{ echo "Maximum number of compare configurations reached!++0++0++0++max"; }
	else
	{
		mysqli_select_db($con,"notebro_db");
		$sql="SELECT families.fam, model.model, model.submodel, img_1 FROM notebro_db.MODEL model JOIN notebro_db.FAMILIES families on model.idfam=families.id WHERE model.id=".$conf_model;
		$result = mysqli_query($con,$sql);
		$currentconf["img"]="missing";
		while ($row = mysqli_fetch_assoc($result)) { if(strlen($row["submodel"])>21 && !preg_match("/\(.*\)/",$row["submodel"])){ $row["submodel"]=substr($row["submodel"],0,20)."."; } $name=$row["fam"]." ".$row["model"]."".$row["submodel"]; $currentconf["img"]=$row["img_1"]; } 
		mysqli_free_result($result);
		$_SESSION['conf'.$i]=$currentconf;
		$nrcheck++;
		
		if($nrcheck<4)
		{ $_SESSION['conf'.$i]["checked"]=1; $checked="checked='checked'"; }
		else
		{ $_SESSION['conf'.$i]["checked"]=0; $checked=""; $nrcheck=4;}
		if($k)
		{
			$_SESSION['conf'.$i]["name"]=$name." (".$k.")";
			echo $name." (".$k.")++".$checked."++".$nrcheck."++".$currentconf["id"]."++".$currentconf['cpu_info']."++".$currentconf['gpu_info']."++".$currentconf['disp_size']."++".$currentconf['disp_res']."++".$currentconf['mem_info']."++".$currentconf['hdd_info']."++".$currentconf["img"]."++".$i;
		}
		else
		{
			$_SESSION['conf'.$i]["name"]=$name;	
			echo $name."++".$checked."++".$nrcheck."++".$currentconf["id"]."++".$currentconf['cpu_info']."++".$currentconf['gpu_info']."++".$currentconf['disp_size']."++".$currentconf['disp_res']."++".$currentconf['mem_info']."++".$currentconf['hdd_info']."++".$currentconf["img"]."++".$i;
		}
	}
}
else
{
	echo "Configuration already added!"."++0++0++0";
}
?>