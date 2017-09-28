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
	{
		require_once("lib/php/updatefinal.php"); }
	else
	{ $errMsg = 'Captcha code not matched, please try again.'; }
}
else { $errMsg = 'Please enter the captcha code.'; }
?>


<form id="ireviews_form" action="javascript:void(0);" method="post">
	<div class="title"><p><b>ADD A REVIEW TO NOTEB DATABASE</b></p></div>
	<div class="col-md-12 col-lg-12" style="margin-bottom:10px;">
		<div class="col-md-1" style="padding:0px">Model :</div>
		<div class="col-md-6">
			<div class="continut1" style="position:relative;height:auto;"> 
				<select class="modelsearch js-example-responsive" id="model_id" name ="model_id" data-placeholder="Search a laptop model" data-initvalue="search for a model"  style="width: 150%; margin:5px 0px 10px 0px;"></select>
			</div>
		</div>
	</div>
	
	<div class="col-md-12" style="margin-bottom:10px;">
		<div class="col-md-1" style="padding:0px">Site</div>
		<div class="col-md-6">
		<select class="predbvalues" name="site" data-placeholder="Ex. Tom's Hardware, Notebookcheck" data-initvalue="Type website name" data-url="public/lib/php/queries.php" data-type="review_websites" style="width: 50%; margin:5px 0px 10px 0px;"></select>
		<!-- <div class="col-md-6"><textarea class="input" style="margin:0" name="site" autocomplete="off" spellcheck="false" name="site" placeholder="Ex. Tom's Hardware, Notebookcheck" value=""></textarea></div> -->
		</div>
	</div>

	<div class="col-md-12" style="margin-bottom:10px;">
		<div class="col-md-1" style="padding:0px">Link</div>
		<div class="col-md-6"><textarea class="input" style="margin:0" name="link" autocomplete="off" spellcheck="false" name="link" placeholder="Ex. http://www.tomshardware.com/reviews/dell-inspiron-15-7000-gaming-laptop,4944.html" value=""></textarea></div>
	</div>
	<input type="hidden" name="intr" value="1">
	<input type="hidden" name="table" value="REVIEWS">

<?php if(!empty($errMsg)) echo '<p style="color:#EA4335;">'.$errMsg.'</p>';?>
<?php if(!empty($succMsg)) echo '<p style="color:#34A853;">'.$succMsg.'</p>';?>
	<img src="<?php echo $web_address;?>public/lib/php/captcha.php" id="capImage"/>Can't read the image? click here to <a href="javascript:void(0);" onclick="javascript:$('#capImage').attr('src','<?php echo $web_address;?>public/lib/php/captcha.php?'+new Date().getTime());">refresh</a>.<br><br>Enter the code: <input name="captcha_code" type="text" value="">
	<input type="submit" value="Submit" id="ireviews_form_btn" name="submit" style="position: absolute; left:290px; top:450px; width: 150px;" >
</form>
<link rel="stylesheet" href="public/lib/css/ireviews.css" type="text/css" />
<script>$.getScript("public/lib/js/ireviews.js");</script>
<script type="text/javascript">
$(document).ready(function()
	{ actbtn("USER"); 
});
</script>

