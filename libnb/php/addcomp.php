<?php
require_once("../../etc/session.php"); 
require_once("../../etc/con_db.php");
require_once("../../etc/con_sdb.php");
require_once("../../etc/conf.php");
?>

<?php
if(isset($_POST['sendid'])){ $config_id = $_POST['sendid']; }
else
{
	$conf_model = $_POST['sendmid']; $conf_cpu=$_POST['sendcpu']; $conf_gpu=$_POST['sendgpu']; $conf_disp=$_POST['senddisp']; $conf_hdd=$_POST['sendhdd']; $conf_shdd=$_POST['sendshdd'];
	$conf_mem=$_POST['sendmem']; $conf_chassis=$_POST['sendchassis']; $conf_odd=$_POST['sendodd']; $conf_wnet=$_POST['sendwnet']; $conf_war=$_POST['sendwar']; $conf_sist=$_POST['sendsis'];
	$conf_acum=$_POST['sendacum'];  $conf_mdb=$_POST['sendmdb'];
	$config_id=0;
	$conf_cpu_name=$_POST['sendcpuname']; $conf_gpu_name=$_POST['sendgpuname'];	$conf_display_size=$_POST['senddissize'];
	$conf_display_res=$_POST['senddisres']; 	$conf_mem_info=$_POST['sendmeminfo']; 	$conf_hdd_info=$_POST['sendhddinfo'];
}

if($config_id)
{
	$sql="SELECT id,cpu,gpu,display,mem,hdd,model FROM notebro_temp.all_conf_".table($config_id)." WHERE id=$config_id LIMIT 1";;
}
else
{
	$sql="SELECT id FROM notebro_temp.all_conf_".$conf_model." WHERE cpu=".$conf_cpu." AND gpu=".$conf_gpu." AND display=".$conf_disp." AND hdd=".$conf_hdd." AND shdd=".$conf_shdd." AND acum=".$conf_acum." AND mdb=".$conf_mdb." AND mem=".$conf_mem." AND odd=".$conf_odd." AND chassis=".$conf_chassis." AND wnet=".$conf_wnet." AND war=".$conf_war." AND sist=".$conf_sist." LIMIT 1";
	//error_log($sql);
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
	
	$sql2='SELECT prod,model FROM GPU WHERE id='.$row["gpu"];
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

//introdus shdd in cod
$currentconf=array("checked" =>0, "id" => $row["id"] ,"name" => $conf_model, "model"=> $conf_model , "cpu_info" => $conf_cpu_name, "gpu_info" => $conf_gpu_name, "disp_size" => $conf_display_size, "disp_res" => $conf_display_res, "mem_info" => $conf_mem_info, "hdd_info" => $conf_hdd_info );

$i=0; $k=0; $nrcheck=-1; $already=1;
while(isset($_SESSION['conf'.$i]) && $_SESSION['conf'.$i] && $i<=9)
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
	$i++;
}

if($already)
{
	if($i>9)
	{ echo "Maximum number of compare configurations reached!"; }
	else
	{
		mysqli_select_db($con,"notebro_db");
		$sql="SELECT fam, model FROM MODEL WHERE id=".$conf_model;
		$result = mysqli_query($con,$sql);
		
		while ($row = mysqli_fetch_assoc($result)) { $name=$row["fam"]." ".$row["model"]; }
		
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
			echo $name." (".$k.")++".$checked."++".$nrcheck."++".$currentconf["id"]."++".$currentconf['cpu_info']."++".$currentconf['gpu_info']."++".$currentconf['disp_size']."++".$currentconf['disp_res']."++".$currentconf['mem_info']."++".$currentconf['hdd_info']."++".$i;
		}
		else
		{
			$_SESSION['conf'.$i]["name"]=$name;	
			echo $name."++".$checked."++".$nrcheck."++".$currentconf["id"]."++".$currentconf['cpu_info']."++".$currentconf['gpu_info']."++".$currentconf['disp_size']."++".$currentconf['disp_res']."++".$currentconf['mem_info']."++".$currentconf['hdd_info']."++".$i;
		}
	}
}
else
{
	echo "Configuration already added!"."++0++0++0";
}
?>