
<?php
require_once("../etc/con_rdb.php");
require_once("../etc/con_db.php");
$table = $_POST['table'];

if ($table == 'REVIEWS'){   
 // sanitise links before insert
	if(isset($_POST['model_id'])){ $model_id = $_POST['model_id']; }
	if(isset($_POST['site'])) { $site = $_POST['site']; }
	if(isset($_POST['link'])) { $link = $_POST['link']; }
	
	$sql="SELECT idfam,prod,model,fam.fam,fam.subfam,fam.showsubfam FROM MODEL model JOIN ( SELECT id,fam,subfam,showsubfam FROM notebro_db.FAMILIES ) fam ON fam.id=model.idfam WHERE model.id=$model_id LIMIT 1";
	$query=mysqli_query($con,$sql);
	$row=mysqli_fetch_assoc($query);
	if(intval($row['showsubfam'])==1){ $subfam=" ".$row['subfam']." "; } else { $subfam=" "; }
	$model_name = $row['prod']." ".$row['fam'].$subfam.$row['model'];

	//verify and take last id for reviews
	$link = preg_replace('!<a href="([^\"]+)" target="_blank">[^<]+</a>!', '<a href="$1" target="_blank">$1</a>', $link); 
	$idireviews = mysqli_fetch_row(mysqli_query($con,"SELECT lastid FROM notebro_db.last_key WHERE info = 'lastid_ireviews'"));
	$idlastireviews = mysqli_fetch_row(mysqli_query($con,"SELECT id FROM notebro_db.REVIEWS ORDER BY id DESC LIMIT 1"));
	if ($idireviews[0] <= $idlastireviews[0]) {$idireviews[0] = $idlastireviews[0]+1;}

	if(!empty($model_name)&&!empty($link)&&!empty($site)) /// validarea campurilor obligatorii
	{
		$scor=0;

		if (!preg_match("/^[ a-z A-Z 0-9 _\-\,\.\"\(\)\/\ ]*$/",$model_name)) 
		{ 
			echo "<script type='text/javascript'>alert('Model_name')</script>";
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=ireviews.php\">";
		}
		else { $scor ++; }

		if (!preg_match("/^[ a-z A-Z 0-9 _\-\,\.\'\ ]*$/",$site)) 
		{ 
			echo "<script type='text/javascript'>alert('Site')</script>";
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=ireviews.php\">";
		}
		else { $scor ++; }

		if ($link)
		{
			$url = filter_var($link, FILTER_SANITIZE_URL);
			if (!filter_var($url, FILTER_VALIDATE_URL) === false) { $scor ++; }
		}			
		else
		{
			echo "<script type='text/javascript'>alert('URL problem')</script>";
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=ireviews.php\">";
		}
	}
	else { $scor=0; }

	if ($scor == 3) 
	{
		$sql = "insert into REVIEWS (id, model, model_id, site, title, link, notebreview) values ('".$idireviews[0]."','".$model_name."','".$model_id."','".$site."','','".$link."','0')";
		if(mysqli_query($rcon, $sql))
		{
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=?public/ireviews.php\">";
			$sql = "UPDATE notebro_db.last_key SET lastid = '".($idireviews[0]+1)."' WHERE info = 'lastid_ireviews'" ;
			if(mysqli_query($rcon, $sql))
			{ /*echo "Succesfully submitted $site review on $model_name. Thank you!. <br><br>";*/	echo "<script type='text/javascript'>alert('$site review on $model_name submitted successfully. Thank you!')</script>";		}
		}
	}
	else
	{ echo "<script type='text/javascript'>alert('Please insert mandatory fields or link is invalid')</script>"; }
	mysqli_close($rcon); mysqli_close($con);
}
else
{ echo "Something went terribly wrong" . mysqli_error($con); }

?>