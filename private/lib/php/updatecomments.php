<?php
require_once("../etc/con_rdb.php");
require_once("../etc/con_db.php");

if ($table == 'COMMENTS')
{   
	$sql="SELECT `model`.`id`,`idfam`,`prod`,`model`,`fam`.`fam`,`fam`.`subfam`,`fam`.`showsubfam`,`model`.`p_model` FROM MODEL model JOIN ( SELECT id,fam,subfam,showsubfam FROM notebro_db.FAMILIES ) fam ON fam.id=model.idfam WHERE model.id IN (".implode(",",$model_id).") LIMIT ".count($model_id);
	$query=mysqli_query($con,$sql);
	$fatal_error=1;	$i=0;

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
				echo "<script type='text/javascript'>alert('Model_name')</script>";
				//echo "<meta http-equiv=\"refresh\" content=\"0;URL=cominfo.php\">";
			}
			else { $scor[$i]++; }

			if (!preg_match("/^[ a-z A-Z 0-9 _\-\,\.\"\(\)\/\:\%\+\ ]*$/",$info_com)) 
			{ 
				echo "<script type='text/javascript'>alert('Comment')</script>";
				//echo "<meta http-equiv=\"refresh\" content=\"0;URL=cominfo.php\">";
			}
			else { $scor[$i]++; }
		}
		else { $scor[$i]=0; }
	
		if ($scor[$i]==2) 
		{
			$query1 = "SELECT `model` FROM `notebro_db`.`COMMENTS` WHERE (model=".$row["p_model"]." OR model IN (SELECT `id` FROM `notebro_db`.`MODEL` WHERE `notebro_db`.`MODEL`.`p_model`=".$row["p_model"].")) AND type='com'"; //echo $query1;
			$result = mysqli_query($rcon,$query1);
			if($result && !(mysqli_num_rows($result)>0))
			{
				$sql = "INSERT INTO `notebro_db`.`COMMENTS` (`model`, `type`, `comment`,`valid`,`update`) VALUES ('".$row["p_model"]."','com','".$info_com."',0,0)";
				var_dump($sql);
				if(mysqli_query($rcon, $sql))
				{
					//echo "<meta http-equiv=\"refresh\" content=\"0;URL=?public/cominfo.php\">";
					echo "<script type='text/javascript'>alert('Comment on $model_name[$i] submitted successfully. Thank you!')</script>"; $error=0;
				}
				else
				{ echo "<script type='text/javascript'>alert('Were are sorry, but there was unknown error. Please contact the site administrator.')</script>"; }
			}
			else
			{
				$query1 = "SELECT COUNT(`model`) as `count` FROM `notebro_db`.`COMMENTS` WHERE (model=".$row["p_model"]." OR model IN (SELECT `id` FROM `notebro_db`.`MODEL` WHERE `notebro_db`.`MODEL`.`p_model`=".$row["p_model"].")) AND `type`='com' AND `update`>0"; //echo $query1;
				$result = mysqli_query($rcon,$query1);
				$update_count=0;
				if($result && mysqli_num_rows($result)>0)
				{ $update_count=intval(mysqli_fetch_assoc($result)['count']); }
				
				$sql="INSERT INTO `notebro_db`.`COMMENTS` (`model`, `type`, `comment`,`valid`,`update`) VALUES ('".$row["p_model"]."','com','".$info_com."',0,".($update_count+1).")";
				if(mysqli_query($rcon, $sql))
				{
					//echo "<meta http-equiv=\"refresh\" content=\"0;URL=?public/cominfo.php\">";
					echo "<script type='text/javascript'>alert('Update comment on $model_name[$i] submitted successfully. Thank you!')</script>"; $error=0;
				}
				else
				{ echo "<script type='text/javascript'>alert('Were are sorry, but there was unknown error. Please contact the site administrator.')</script>"; }
			}
		}
		else
		{ if($fatal_error){ echo "<script type='text/javascript'>alert('Please insert mandatory fields or link is invalid')</script>"; } $fatal_error=0; }
		$i++;
		mysqli_close($rcon); mysqli_close($con);
	}
}
else
{ echo "Something went terribly wrong" . mysqli_error($rcon); }

?>