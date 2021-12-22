<?php
	require_once("../../../etc/conf.php");
	if (!isset($_SERVER['HTTP_REFERER']) || stripos($_SERVER['HTTP_REFERER'],$site_name) ==FALSE) 
	{	$actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		header("Location: ".$port_type."://".str_replace($site_name."/",$site_name."/?",$actual_link)."");
		die();
	}
	require_once("../../../etc/session.php");
	require_once("../../../etc/con_db.php");
	/** DEFAULTS **/
	$lang=1; $reset=0; $sort_by="value";
	if(isset($_GET['sort_by'])){$sort_by=clean_string($_GET['sort_by']);}
	$search_form_id="searchform";
?>
	<script>
	
	
	
		<?php echo "var lang=".$lang.";"; ?>
		get_nom_search_data();
		var istime=0; var main_search_scripts_loaded=false; $.getScript("search/ui/js/search_func.js").done(function(){ setparams=get_url_params(); main_search_scripts_loaded=true;});
	</script>
	<form  method="post" id="<?php echo $search_form_id;?>" name="<?php echo $search_form_id;?>" style="background-color: #fff; padding: 0 15px;">
		<input type="hidden" name="advsearch" value="1">
		<input type="hidden" name="sort_by" value="<?php echo $sort_by;?>">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<a onclick="reset_search('<?php echo $search_form_id; ?>');" style="cursor:pointer; font-size:15px; float:right; margin:20px 0px -5px 0px; padding:0px 25px 0px 25px; border-radius:2px; background-color:#49505a; color:#fff; text-decoration:none;margin-left: 10px;" id="gototop">Reset</a>
								<a class="setRecommended" onclick="setrecommended('<?php echo $search_form_id; ?>');" style="cursor:pointer;  font-size:15px; float:right; margin:20px 0px 10px 0px; padding:0px 25px 0px 25px; border-radius:2px; background-color:#0066cb; color:#fff; text-decoration:none;">Set recommended filters</a>
						    </div>
						</div>					
					</div><!-- End Col -->
					<?php require_once("../components/model.php"); ?>
					<!-- CPU -->	
					<?php require_once("../components/cpu.php"); ?>
					<!-- GPU -->	
					<?php //require_once("../components/gpu.php"); ?>
					<!-- DISPLAY -->	
					<?php require_once("../components/mdb.php"); ?>
			
				</div><!-- End Row -->
			</div> <!-- End Col -->	
		</div> <!-- End row -->
		<!-- SUBMIT BUTTON -->		
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top: 20px;">		
			<nav style="margin-bottom:20px!important">		
				<a id="submit"></a>	
				<input type="submit" class="btn submitbutton" value="Submit" onclick="event.preventDefault(); scrolltoid('gototop',0); submit_search('#<?php echo $search_form_id; ?>');">
			</nav>
		</div>
	</form>	
	<script>
		var nouisliders=document.getElementsByClassName('advslider');
		for(var key in nouisliders){ if(nouisliders[key].noUiSlider!==undefined){ nouisliders[key].noUiSlider.on('update', function( values, handle ){presearch("#<?php echo $search_form_id; ?>");});} }
		pause_presearch=1; setTimeout(function(){ pause_presearch=0; },2500);
	</script>
	<?php unset($search_form_id); ?>
	<?php include_once("../../../etc/scripts_pages.php"); ?>