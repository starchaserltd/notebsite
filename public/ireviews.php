<?php
require_once("../etc/conf.php");
if(!empty($_POST['captcha_code']))
{
	//get captcha code from session
	$captchaCode = $_SESSION['captchaCode'];
	//get captcha code from input field
	$enteredcaptchaCode = $_POST['captcha_code'];
	//verify the captcha code
	if($enteredcaptchaCode === $captchaCode)
	{ require_once("lib/php/updatefinal.php"); }
	else
	{ $errMsg = 'Captcha code not matched, please try again.'; }
}
else { $errMsg = 'Please enter the captcha code:'; }
?>


<form id="ireviews_form" action="javascript:void(0);" method="post">
<div style="min-height:650px">
	<div class="title"><p><b>Add an external review to Noteb database</b></p></div>
	
	<div class="col-md-12 col-lg-12 irevtop">
		<div class="Irevm col-md-1">Model :</div>
		<div class="col-md-6" id="modelfind">			
			<select class="modelsearch Irevmod" id="model_id" name ="model_id" data-placeholder="Search a laptop model" data-initvalue="search for a model"></select>			
		</div>
	</div>
	
	<div class="col-md-12 col-lg-12 irevtop">
		<div class="Irevm col-md-1">Site :</div>
		<div class="col-md-6" id="modelfind">
		<select class="predbvalues Irevmod" name="site" data-placeholder="Ex. Tom's Hardware, Notebookcheck" data-initvalue="Type website name" data-url="public/lib/php/queries.php" data-type="review_websites"></select>
		<!-- <div class="col-md-6"><textarea class="input" style="margin:0" name="site" autocomplete="off" spellcheck="false" name="site" placeholder="Ex. Tom's Hardware, Notebookcheck" value=""></textarea></div> -->
		</div>
	</div>

	<div class="col-md-12 col-lg-12 irevtop">
		<div class="Irevm col-md-1">Link :</div>
		<div class="col-md-6"><textarea class="Irevmod input" style="margin:0" name="link" autocomplete="off" spellcheck="false" name="link" placeholder="Ex. http://www.tomshardware.com/reviews/dell-inspiron-15-7000-gaming-laptop,4944.html" value=""></textarea></div>
	</div>
	<input type="hidden" name="intr" value="1">
	<input type="hidden" name="table" value="REVIEWS">

<?php if(!empty($errMsg)) echo '<div class="col-md-12 col-md-offset-3 Irevm"><p style="color:#EA4335">'.$errMsg.'</p></div>';?>
<?php if(!empty($succMsg)) echo '<p style="color:#34A853;">'.$succMsg.'</p>';?>
<div class="col-md-6 col-md-offset-3">	<img src="<?php echo $web_address;?>public/lib/php/captcha.php" id="capImage"/></br><p style="font-size:10px">Can't read the image? click here to<a style="margin-left:2px;text-decoration:none" href="javascript:void(0);" onclick="javascript:$('#capImage').attr('src','<?php echo $web_address;?>public/lib/php/captcha.php?'+new Date().getTime());">refresh</a></p>Enter the code: <input name="captcha_code" type="text" value=""></div>
	<input class="btn blue bsub" type="submit" value="Submit" id="ireviews_form_btn" name="submit" style="position: absolute; left:290px; top:450px; width: 150px;color:white;" >
</div>
	</form>
<link rel="stylesheet" href="public/lib/css/ireviews.css" type="text/css" />
<script>$.getScript("public/lib/js/ireviews.js");</script>

