<!DOCTYPE html>
<head>
	<script type="text/javascript" src="../lib/js/jquery.min.js"></script> 
	<script type="text/javascript" src="../lib/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../lib/js/select2.min.js"></script>
	
</head>
<body style="background-color:#6BCAE2" >
<?php
require_once("../etc/conf.php"); ?>
<script><?php echo 'var siteroot = "'.$web_address.'";'; ?></script>
<?php 
if(isset($_POST['table'])) { $table = clean_string($_POST['table']); }
if(isset($_POST['model_ids'])){ $model_id=array(); foreach($_POST['model_ids'] as $key=>$el) { $model_id[intval($key)]=intval($el); } }
if(isset($_POST['info_com'])) { $info_com = clean_string(filter_var($_POST['info_com'],FILTER_SANITIZE_STRING)); }
if(isset($_POST['source_com'])) { $source_com = clean_string(filter_var($_POST['source_com'],FILTER_SANITIZE_STRING)); }

$error=1;
if(isset($table ))
{ require_once("lib/php/updatecomments.php"); }
?>
<div id="result"></div>
<form id="com_info_form" action="cominfo.php" method="post">
<div style="min-height:650px">
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
		<div class="col-md-6"><textarea class="input" style="margin:0; width:500px;" autocomplete="off" spellcheck="false" id="info_com" name="info_com" placeholder="Ex: Processor throttling under prologued heavy usage." value=""></textarea></div>
	</div>
	<br><br>
	<div class="row irevtop">
		<div class="Irevm col-md-1">Source Info :</div>
		<div class="col-md-6"><textarea class="input" style="margin:0; height:50px; width:500px;" autocomplete="off" spellcheck="false" id="source_com" name="source_com" placeholder="Link to the source of information (forum post, review, etc.)" value=""></textarea></div>
	</div>
	<input type="hidden" name="intr" value="1">
	<input type="hidden" name="table" value="COMMENTS">
	<input type="hidden" name="model_names" id="model_names" value="">
	<input type="submit" value="Submit" id="coms_form_btn" name="submit" style="display:inline-block; width: 150px; margin-left:108px;" >
</form>
<script>$.getScript("lib/js/cominfo.js");
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
<?php include_once("../etc/scripts_pages.php"); ?>
<link rel="stylesheet" href="../lib/css/bootstrap.min.css" crossorigin="anonymous">
<link rel="stylesheet" href="../lib/fonts/fontawesome/css/all.min.css" crossorigin="anonymous">
<link rel="stylesheet" href="../lib/css/select2.min.css" type="text/css" /> 

<link href="../../../model/model.css" rel="stylesheet" type="text/css" />
</body>