<!DOCTYPE html>
<?php if(!isset($interface_method)){$interface_method=$_POST;} if(!isset($root_path)){$root_path="";} if(!isset($root_path_2)){$root_path_2="";} if(!isset($root_path_3)){$root_path_3="";} if(!isset($form_redirect)){$form_redirect="";} ?>
<head>
	<title>Noteb model comments</title>
	<script src="<?php echo $root_path_2; ?>../lib/js/jquery.min.js"></script> 
	<script src="<?php echo $root_path_2; ?>../lib/js/bootstrap.min.js"></script>
	<script src="<?php echo $root_path_2; ?>../lib/js/select2.min.js"></script>	
</head>
<body style="background-color:#6BCAE2" >
<?php require_once($root_path_2."../etc/conf.php"); ?>
<script><?php echo 'var siteroot = "'.$web_address.'";'; ?></script>
<?php 
if(isset($_POST['table'])) { $table = clean_string($_POST['table']); }
if(isset($interface_method['model_ids'])){ $model_id=array(); foreach($interface_method['model_ids'] as $key=>$el) { $model_id[intval($key)]=intval($el); } }
if(isset($_POST['info_com'])) { $info_com = clean_string(filter_var($_POST['info_com'],FILTER_SANITIZE_STRING)); }
if(isset($_POST['com_redirect'])) { $form_redirect = clean_string(filter_var($_POST['com_redirect'],FILTER_SANITIZE_STRING)); }
if(isset($_POST['source_com'])) { $source_com = clean_string(filter_var($_POST['source_com'],FILTER_SANITIZE_STRING)); }

if(!$form_redirect||$form_redirect==""){$form_redirect=NULL;}
if(!isset($error)){ $error=1; }

if(isset($table))
{ require_once($root_path_3."lib/php/updatecomments.php"); ?><script>setTimeout(function(){ complete_text_info("<?php echo $model_id[0]; ?>");}, 500);</script><?php }
?>
<div id="result"></div>
<form id="com_info_form" action="<?php echo $root_path_3; ?>cominfo.php" method="post">
<div style="min-height:400px">
	<div class="title"><p><b>Add specific information to a laptop</b></p></div>
	
	<div class="row irevtop">
		<div class="col-md-1">Model :</div>
		<div class="col-md-6" id="modelfind">			
			<select style="width:500px;" class="modelsearch" id="model_ids" name ="model_ids[]" data-placeholder="Search a laptop model" data-initvalue="search for a model"></select>			
		</div>
	</div>
	<br>
	<div class="row irevtop">
		<div class="Irevm col-md-1"><b>Info :</b></div>
		<div class="col-md-6"><textarea class="input" style="margin:0; width:500px;" autocomplete="off" spellcheck="false" id="info_com" name="info_com" placeholder="Ex: Processor throttling under prologued heavy usage."></textarea></div>
	</div>
	<br><br>
	<div class="row irevtop">
		<div class="Irevm col-md-1">Source Info :</div>
		<div class="col-md-6"><textarea class="input" style="margin:0; height:50px; width:500px;" autocomplete="off" spellcheck="false" id="source_com" name="source_com" placeholder="Link to the source of information (forum post, review, etc.)"></textarea></div>
	</div>
	<input type="hidden" name="intr" value="1">
	<input type="hidden" name="table" value="COMMENTS">
	<input type="hidden" name="model_names" id="model_names" value="">
	<?php if($form_redirect){ ?><input type="hidden" name="com_redirect" id="com_redirect" value="<?php echo $form_redirect;?>"><?php } ?>
	<input type="submit" value="Submit" id="coms_form_btn" name="submit" style="display:inline-block; width: 150px; margin-left:108px;" >
</div>
</form>
<div><span>Comments for linked models:</span><br><span id="models_msc"></span></div>
<script>var path_modifier="<?php echo $root_path_2; ?>"; $.getScript("<?php echo $root_path_3; ?>lib/js/cominfo.js");
setTimeout(function (){
<?php

if($error)
{
	if(isset($_POST['model_names'])&&isset($model_id)) { $model_names=explode(",",str_replace('"','',clean_string($_POST['model_names']))); foreach($model_names as $key=>$el){ echo "$('#model_ids').append('<option selected=".'"'."selected".'"'." value=".'"'.intval($model_id[$key]).'"'.">".$model_names[$key]."</option>');";  } }
	if(isset($info_com)) { echo "document.getElementById('info_com').value='".$info_com."';"; }
	if(isset($source_com)) { echo "document.getElementById('source_com').value='".implode(" ",$source_com_parts_final)."';"; }
}
?>
}, 200);
</script>
<?php include_once($root_path_2."../etc/scripts_pages.php"); ?>
<link rel="stylesheet" href="<?php echo $root_path_2; ?>../admin/lib/css/bootstrap.min.css" crossorigin="anonymous">
<link rel="stylesheet" href="<?php echo $root_path_2; ?>../lib/fonts/fontawesome/css/all.min.css" crossorigin="anonymous">
<link rel="stylesheet" href="<?php echo $root_path_2; ?>../admin/lib/css/select2.min.css" type="text/css" /> 
<link href="<?php echo $root_path_2; ?>../admin/model/lib/css/model.css" rel="stylesheet" type="text/css" />
</body>