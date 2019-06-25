<?php
require_once("../etc/con_rdb.php");
require_once("../etc/con_db.php");

if ($table == 'COMMENTS')
{   
	$sql="SELECT `model`.`id`,`idfam`,`prod`,`model`,`fam`.`fam`,`fam`.`subfam`,`fam`.`showsubfam`,`model`.`p_model` FROM MODEL model JOIN ( SELECT id,fam,subfam,showsubfam FROM notebro_db.FAMILIES ) fam ON fam.id=model.idfam WHERE model.id IN (".implode(",",$model_id).") LIMIT ".count($model_id);
	$query=mysqli_query($con,$sql);
	$fatal_error=1;	$i=0; $source_com_parts_final=array();  $insert_com=false; $insert_source=false;
	
	if($query&&mysqli_num_rows($query)>0)
	{
		while($row=mysqli_fetch_assoc($query))
		{
			if(intval($row['showsubfam'])==1){ $subfam=" ".$row['subfam']." "; } else { $subfam=" "; }
			$model_name[$i] = $row['prod']." ".$row['fam'].$subfam.$row['model'];
			//verify and take last id for reviews

			if(!empty($model_name[$i])&&!empty($info_com)) /// validarea campurilor obligatorii
			{
				$scor[$i]=0;

				if (!preg_match("/^[ a-z A-Z 0-9 _\-\,\.\"\(\)\/\ ]*$/",$model_name[$i])) 
				{ 
					echo "<script>alert('Model_name')</script>";
					if($form_redirect){echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$form_redirect."\">"; }
				}
				else { $scor[$i]++; }

				if (!preg_match("/^[ a-z A-Z 0-9 _\-\,\.\"\(\)\/\:\%\+\@\ ]*$/",$info_com)) 
				{ 
					echo "<script'>alert('Comment')</script>";
					if($form_redirect){echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$form_redirect."\">"; }
				}
				else { $scor[$i]++; $insert_com=true; }
				
				if ($source_com)
				{
					$source_com_parts=array(); $source_com_parts=explode(" ",$source_com); $source_com_parts2=array(); 
					foreach($source_com_parts as $val){foreach(explode(",",$val) as $val){$source_com_parts2[]=$val;} }
					foreach($source_com_parts2 as $val){ $url = filter_var($val, FILTER_SANITIZE_URL); if(!filter_var($url, FILTER_VALIDATE_URL)===false){ $source_com_parts_final[]=$url;}}
					if(isset($source_com_parts_final[0])){ $scor[$i]++;  $insert_source=true; }
				}
			}
			else { $scor[$i]=0; }
		
			if ($scor[$i]>1) 
			{
				if($insert_com){insert_function($con,$rcon,$info_com,"com",$row["p_model"],$model_name[$i],$form_redirect);}
				if($insert_source){ insert_function($con,$rcon,implode(" ",$source_com_parts_final),"src",$row["p_model"],$model_name[$i],$form_redirect);}
			}
			else
			{ if($fatal_error){ echo "<script>alert('Please insert mandatory fields or link is invalid')</script>"; } $fatal_error=0; }
			$i++;
			mysqli_close($rcon); mysqli_close($con);
		}
	}
	else
	{ echo "<script>alert('Invalid model ID!')</script>"; }
}
else
{ echo "Something went terribly wrong" . mysqli_error($rcon); }

function insert_function($con,$rcon,$value,$field,$model_id,$model_name,$form_redirect)
{
	global $alerted;
	$query1 = "SELECT `model` FROM `notebro_db`.`COMMENTS` WHERE (model=".$model_id." OR model IN (SELECT `id` FROM `notebro_db`.`MODEL` WHERE `notebro_db`.`MODEL`.`p_model`=".$model_id.")) AND type='".$field."'"; //echo $query1;
	$result = mysqli_query($rcon,$query1);
	if($result && !(mysqli_num_rows($result)>0))
	{
		$sql = "INSERT INTO `notebro_db`.`COMMENTS` (`model`, `type`, `comment`,`valid`,`update`) VALUES ('".$model_id."','".$field."','".$value."',0,0)";
		if(mysqli_query($rcon, $sql))
		{
			if(!$alerted){ echo "<script>alert('Comment on $model_name submitted successfully. Thank you!')</script>"; $error=0; $alerted=true;}
			if($form_redirect){echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$form_redirect."\">"; }
		}
		else
		{ echo "<script>alert('Were are sorry, but there was unknown error. Please contact the site administrator.')</script>"; }
	}
	else
	{
		$query1 = "SELECT COUNT(`model`) as `count` FROM `notebro_db`.`COMMENTS` WHERE (model=".$model_id." OR model IN (SELECT `id` FROM `notebro_db`.`MODEL` WHERE `notebro_db`.`MODEL`.`p_model`=".$model_id.")) AND `type`='".$field."' AND `update`>0"; //echo $query1;
		$result = mysqli_query($rcon,$query1);
		$update_count=0;
		if($result && mysqli_num_rows($result)>0)
		{ $update_count=intval(mysqli_fetch_assoc($result)['count']); }
		
		$sql="INSERT INTO `notebro_db`.`COMMENTS` (`model`, `type`, `comment`,`valid`,`update`) VALUES ('".$model_id."','".$field."','".$value."',0,".($update_count+1).")";
		if(mysqli_query($rcon, $sql))
		{
			if(!$alerted){ echo "<script>alert('Update comment on $model_name submitted successfully. Thank you!')</script>"; $error=0; $alerted=true;}
			if($form_redirect){echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$form_redirect."\">"; }
		}
		else
		{ echo "<script>alert('Were are sorry, but there was unknown error. Please contact the site administrator.')</script>"; }
	}
}

if($form_redirect){echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$form_redirect."\">"; }
?>