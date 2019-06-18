
<?php
require_once("../etc/con_rdb.php");
require_once("../etc/con_db.php");
require_once("../etc/conf.php");

if ($table == 'REVIEWS')
{   
	$sql="SELECT `model`.`id`,`idfam`,`prod`,`model`,`fam`.`fam`,`fam`.`subfam`,`fam`.`showsubfam`,`model`.`p_model` FROM MODEL model JOIN ( SELECT id,fam,subfam,showsubfam FROM notebro_db.FAMILIES ) fam ON fam.id=model.idfam WHERE model.id IN (".implode(",",$model_id).") LIMIT ".count($model_id);
	$query=mysqli_query($con,$sql);
	$fatal_error=1;	$i=0;
	while($row=mysqli_fetch_assoc($query))
	{
		if(intval($row['showsubfam'])==1){ $subfam=" ".$row['subfam']." "; } else { $subfam=" "; }
		$model_name[$i] = $row['prod']." ".$row['fam'].$subfam.$row['model'];
		//verify and take last id for reviews
		$link = preg_replace('!<a href="([^\"]+)" target="_blank">[^<]+</a>!', '<a href="$1" target="_blank">$1</a>', $link); 
		$idireviews = mysqli_fetch_row(mysqli_query($rcon,"SELECT lastid FROM notebro_db.last_key WHERE info = 'lastid_ireviews'"));
		$idlastireviews = mysqli_fetch_row(mysqli_query($rcon,"SELECT id FROM notebro_db.REVIEWS ORDER BY id DESC LIMIT 1"));
		if(isset($idireviews[0])) { if ($idireviews[0] <= $idlastireviews[0]) {$idireviews[0] = $idlastireviews[0]+1;} } 

		if(!empty($model_name[$i])&&!empty($link)&&!empty($site)) /// validarea campurilor obligatorii
		{
			$scor[$i]=0;

			if (!preg_match("/^[ a-z A-Z 0-9 _\-\,\.\"\(\)\/\ ]*$/",$model_name[$i])) 
			{ 
				echo "<script type='text/javascript'>alert('Model_name')</script>";
				echo "<meta http-equiv=\"refresh\" content=\"0;URL=ireviews.php\">";
			}
			else { $scor[$i] ++; }

			if (!preg_match("/^[ a-z A-Z 0-9 _\-\,\.\'\ ]*$/",$site)) 
			{ 
				echo "<script type='text/javascript'>alert('Site')</script>";
				echo "<meta http-equiv=\"refresh\" content=\"0;URL=ireviews.php\">";
			}
			else { $scor[$i]++; }

			if ($link)
			{
				$url = filter_var($link, FILTER_SANITIZE_URL);
				if (!filter_var($url, FILTER_VALIDATE_URL) === false) { $scor[$i]++; }
			}			
			else
			{
				echo "<script type='text/javascript'>alert('URL problem')</script>";
				echo "<meta http-equiv=\"refresh\" content=\"0;URL=ireviews.php\">";
			}
		}
		else { $scor[$i]=0; }
	
		if(!isset($idireviews[0])) { $scor[$i]=0; }
	
		if ($scor[$i] == 3) 
		{
			$query1 = "SELECT model_id,link from REVIEWS WHERE (model_id=".$row["p_model"]." OR model_id IN (SELECT `id` FROM `notebro_db`.`MODEL` WHERE `notebro_db`.`MODEL`.`p_model`=".$row["p_model"].")) AND link like '%".$link."%'"; //echo $query1;
			$result = mysqli_query($rcon,$query1);
			if($result && !(mysqli_num_rows($result)>0))
			{
				$noteb_review=0; if(stripos($link,"noteb.com")!==FALSE){$noteb_review=1;}
				$sql = "INSERT INTO `notebro_db`.`REVIEWS` (id, model, model_id, site, title, link, notebreview, site_source) VALUES ('".$idireviews[0]."','".$model_name[$i]."','".$row["p_model"]."','".$site."','','".$link."','".$noteb_review."', '".$site_name."')";
				if(mysqli_query($rcon, $sql))
				{
					echo "<meta http-equiv=\"refresh\" content=\"0;URL=?public/ireviews.php\">";
					$sql = "UPDATE notebro_db.last_key SET lastid = '".($idireviews[0]+1)."' WHERE info = 'lastid_ireviews'" ;
					if(mysqli_query($rcon, $sql))
					{echo "<script type='text/javascript'>alert('$site review on $model_name[$i] submitted successfully. Thank you!')</script>"; $error=0;}
				}
				else
				{ echo "<script type='text/javascript'>alert('Were are sorry, but there was unknown error. Please contact the site administrator.')</script>"; }
			}
			else {echo "<script type='text/javascript'>alert('We are sorry, but the $site review for $model_name[$i] has already been submitted.')</script>";}
		}
		else
		{ if($fatal_error){ echo "<script type='text/javascript'>alert('Please insert mandatory fields or link is invalid')</script>"; } $fatal_error=0; }
		$i++;
	}
		mysqli_close($rcon); mysqli_close($con);
}
else
{ echo "Something went terribly wrong" . mysqli_error($rcon); }

?>