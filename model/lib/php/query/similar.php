<?php

if(isset($_GET['q'])){ $q=filter_var($_GET['q'], FILTER_VALIDATE_INT); if($q===FALSE){ $q=-1; } } else { $q=-1;}
if($q>=0)
{
	require("../../../../etc/con_db.php");
	require("../../../../etc/conf.php");
	
	if(isset($_GET['cpu_min_rating'])) { $cpu_min_rating=floatval($_GET['cpu_min_rating']); }else{$q=-1;}
	if(isset($_GET['cpu_max_rating'])) { $cpu_max_rating=floatval($_GET['cpu_max_rating']); }else{$q=-1;}
	if(isset($_GET['cpu_min_tdp'])) { $cpu_min_tdp=floatval($_GET['cpu_min_tdp']); }else{$q=-1;}
	if(isset($_GET['cpu_max_tdp'])) { $cpu_max_tdp=floatval($_GET['cpu_max_tdp']); }else{$q=-1;}
	
	if(isset($_GET['gpu_min_rating'])) { $gpu_min_rating=floatval($_GET['gpu_min_rating']); }else{$q=-1;}
	if(isset($_GET['gpu_max_rating'])) { $gpu_max_rating=floatval($_GET['gpu_max_rating']); }else{$q=-1;}
	if(isset($_GET['gpu_rating'])) { $gpu_rating=floatval($_GET['gpu_rating']); }else{$q=-1;}
	if(isset($_GET['gpu_type'])) { $gpu_type=floatval($_GET['gpu_type']); }else{$q=-1;}
	
	if(isset($_GET['get_os_list'])) { $get_os=floatval($_GET['get_os_list']); }else{$q=-1;}
	if(isset($_GET['m_family'])) { $model_id=clean_string($_GET['m_family']); }else{$q=-1;}
	
	$response=array();
	
	if($q>=0)
	{
		mysqli_select_db($con,"notebro_db");
		$sql="SELECT CONCAT(`prod`,' ',`model`) as `cpu_model` FROM `notebro_db`.`CPU` WHERE `valid`=1 AND `rating`>='".$cpu_min_rating."' AND `rating`<='".$cpu_max_rating."' AND `tdp`>='".$cpu_min_tdp."' AND `tdp`<='".$cpu_max_tdp."'";
		$result=mysqli_query($con,$sql);
		$response["cpu"]=array();
		if($result&&mysqli_num_rows($result)>0)
		{ $response["cpu"]=mysqli_fetch_all($result,MYSQLI_ASSOC); mysqli_free_result($result); }
		
		$skip_sql=0;
		$type_gpu_sql="1=1"; $response["gputype2"]=[0,1,2,3,4]; $response["gputype"]=[2];
		if($gpu_type==0&&$gpu_rating<6){$skip_sql=1; $response["gputype"]=[0]; $response["gputype2"]=array();}
		elseif($gpu_type==0&&$gpu_rating>=6){ $skip_sql=1; $response["gputype2"]=[10]; $response["gputype"]=[1];}
		elseif($gpu_type==3){$type_gpu_sql="`typegpu`='3'"; $response["gputype2"]=[3]; $response["gputype"]=[1];}
		else{$type_gpu_sql="`typegpu`>'0'"; $response["gputype2"]=[1,2,3,4]; $response["gputype"]=[1];}
		
		if(!$skip_sql)
		{
			$sql="SELECT `model` as `gpu_model` FROM `notebro_db`.`GPU` WHERE `valid`=1 AND `rating`>='".$gpu_min_rating."' AND `rating`<='".$gpu_max_rating."' AND ".$type_gpu_sql."";
			$result=mysqli_query($con,$sql);
			$response["gpu"]=array();
			if($result&&mysqli_num_rows($result)>0)
			{ $response["gpu"]=mysqli_fetch_all($result,MYSQLI_ASSOC); mysqli_free_result($result);}
		}
		
		$skip_sql=0;
		if($get_os)
		{
			$sql="SELECT DISTINCT `sist` as `os_model` FROM `notebro_db`.`SIST` WHERE `valid`=1 AND `id`!=999"."";
			$result=mysqli_query($con,$sql);
			$response["os"]=array();
			if($result&&mysqli_num_rows($result)>0)
			{ $response["os"]=mysqli_fetch_all($result,MYSQLI_ASSOC); mysqli_free_result($result);}
		}
		
		$sql="SELECT `FAMILIES`.`business` FROM `FAMILIES` WHERE `FAMILIES`.`id`=(SELECT `MODEL`.`idfam` FROM `MODEL` WHERE `MODEL`.`id`=".$model_id." LIMIT 1) LIMIT 1";
		$result=mysqli_query($con,$sql);
		$response["family_type"]=array();
		if($result&&mysqli_num_rows($result)>0)
		{ 
			$value=mysqli_fetch_assoc($result);
			$value=intval($value["business"]);
			switch($value)
			{
				case (0): { $response["family_type"]=null; break;}
				case (1): { $response["family_type"]=null; break;}
				case (2): { $response["family_type"]="All business families"; break;}
				case (3): { $response["family_type"]="All business families"; break;}
				default : { $response["family_type"]=null; break;}
			}
			mysqli_free_result($result);
		}
	}
	mysqli_close($con);
	print json_encode($response);
}
else
{ header('X-PHP-Response-Code: 204', true, 204); }
?>
