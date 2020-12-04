<?php
require_once("../etc/conf.php");
require_once("../etc/session.php");

if(isset($_GET['model_id'])) { $ex_model_id = intval($_GET['model_id']); }else{$ex_model_id=0;}
if(isset($_POST['table'])) { $table = clean_string($_POST['table']); }
if(isset($_POST['model_id_ireviews'])){ $model_id=array(); foreach($_POST['model_id_ireviews'] as $key=>$el) { $model_id[intval($key)]=intval($el); } }
if(isset($_POST['site'])) { $site = clean_string($_POST['site']); }
if(isset($_POST['link'])) { $link = clean_string(filter_var($_POST['link'], FILTER_VALIDATE_URL)); }

$error=1;
if(!empty($_POST['captcha_code']))
{
	//get captcha code from session
	$captchaCode = $_SESSION['captchaCode'];
	//get captcha code from input field
	$enteredcaptchaCode = clean_string($_POST['captcha_code']);
	//verify the captcha code
	if($enteredcaptchaCode === $captchaCode)
	{ require_once("lib/php/updatereviews.php"); }
	else
	{ $errMsg = 'Captcha code not matched, please try again.'; echo "<script type='text/javascript'>alert('Wrong captcha code. Please try again.')</script>"; }
}
else { $errMsg = 'Please enter the captcha code:'; }

if($ex_model_id&&!isset($_POST['model_name_ireviews']))
{
	require_once("../etc/con_db.php");
	$sql="SELECT `model`.`id`,`idfam`,`prod`,`model`,`fam`.`fam`,`fam`.`subfam`,`fam`.`showsubfam`,`model`.`p_model` FROM `MODEL` AS `model` JOIN ( SELECT `id`,`fam`,`subfam`,`showsubfam` FROM `notebro_db`.`FAMILIES` ) AS `fam` ON `fam`.`id`=`model`.`idfam` WHERE `model`.`p_model`=".$ex_model_id." LIMIT 1";
	$query=mysqli_query($con,$sql);
	if(have_results($query))
	{
		$ex_row=mysqli_fetch_assoc($query);
		if(intval($ex_row['showsubfam'])==1){ $subfam=" ".$ex_row['subfam']." "; } else { $subfam=" "; }
		$_POST['model_name_ireviews']=$ex_row['prod']." ".$ex_row['fam'].$subfam.$ex_row['model'];
		$model_id[0]=$ex_model_id;
	}
}
?>
<form id="ireviews_form" action="javascript:void(0);" method="post">
<div style="min-height:650px">
	<div class="title"><p><b>Add an external review to Noteb database</b></p></div>
	
	<div class="row irevtop">
		<div class="Irevm col-md-1">Model :</div>
		<div class="col-md-6" id="modelfind">			
			<select class="modelsearch Irevmod" id="model_id_ireviews" name ="model_id_ireviews[]" data-placeholder="Search a laptop model" data-initvalue="search for a model"></select>			
		</div>
	</div>
	
	<div class="row irevtop">
		<div class="Irevm col-md-1">Site :</div>
		<div class="col-md-6" id="modelfind">
		<select class="predbvalues Irevmod" id="site" name="site" data-placeholder="Ex. Tom's Hardware, Notebookcheck" data-initvalue="Type website name" data-url="public/lib/php/queries.php" data-type="review_websites"></select>
		</div>
	</div>

	<div class="row irevtop">
		<div class="Irevm col-md-1">Link :</div>
		<div class="col-md-6"><textarea class="Irevmod input" style="margin-left:15px;" name="link" autocomplete="off" spellcheck="false" id="link" placeholder="Ex. http://www.tomshardware.com/reviews/dell-inspiron-15-7000-gaming-laptop,4944.html" value=""></textarea></div>
	</div>
	<input type="hidden" name="intr" value="1">
	<input type="hidden" name="table" value="REVIEWS">
	<input type="hidden" name="model_name_ireviews" id="model_name_ireviews" value="">

<?php if(!empty($errMsg)) echo '<div  class="col-md-11 offset-md-1 Irevm"><p style="color:#EA4335">'.$errMsg.'</p></div>';?>
<?php if(!empty($succMsg)) echo '<p style="color:#34A853;">'.$succMsg.'</p>';?>
<div class="col-md-6 offset-md-1">	<img src="<?php echo $web_address;?>public/lib/php/captcha.php?<?php echo mt_rand(); ?>" id="capImage"/></br><p style="font-size:10px">Can't read the image? click here to<a style="margin-left:2px;text-decoration:none" href="javascript:void(0);" onclick="javascript:$('#capImage').attr('src','<?php echo $web_address;?>public/lib/php/captcha.php?'+new Date().getTime());">refresh</a></p>Enter the code: <input name="captcha_code" type="text" value=""></div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align: center;"><input class="btn blue bsub" type="submit" value="Submit" id="ireviews_form_btn" name="submit" style="display:inline-block;width: 150px;color:white;" >
</div>
	</form>
<link rel="stylesheet" href="public/lib/css/ireviews.css" type="text/css" />
<script>$.getScript("public/lib/js/ireviews.js");
actbtn("USER");
setTimeout(function (){
<?php
if($error)
{
	if(isset($_POST['model_name_ireviews'])&&isset($model_id)) { $model_names=explode(",",str_replace('"','',clean_string($_POST['model_name_ireviews']))); foreach($model_names as $key=>$el){ echo "$('#model_id_ireviews').append('<option selected=".'"'."selected".'"'." value=".'"'.intval($model_id[$key]).'"'.">".$model_names[$key]."</option>');";  } }
	if(isset($site)) { echo "$('#site').html('<option selected=".'"'."selected".'"'.">".$site."<option>');"; }
	if(isset($link)) { echo "$('#link').html('".$link."');"; }
}
?>
}, 200);
</script>
<?php include_once("../etc/scripts_pages.php"); ?>