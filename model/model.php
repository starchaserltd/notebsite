<?php
require_once("../etc/conf.php");
if (!isset($_SERVER['HTTP_REFERER']) || stripos($_SERVER['HTTP_REFERER'],$site_name) ==FALSE) 
{	$actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	header("Location: http://".str_replace($site_name."/",$site_name."/?",$actual_link)."");
	die();
}
$rootpath = realpath($_SERVER["DOCUMENT_ROOT"]).$root_mod;
require_once($rootpath.$admin_address.'/wp/wp-blog-header.php');
require_once("../etc/session.php");
require_once("../etc/con_db.php");
if($underwork)
{
	$hourtext="hour"; if($underwork>1){$hourtext="hours";}
	echo "<div class='serverMaintenance'><div class='animationContainer'><span class='glyphicon glyphicon-cog' aria-hidden='true'></span>
	<span class='glyphicon glyphicon-cog' aria-hidden='true'></span>
	<span class='glyphicon glyphicon-cog' aria-hidden='true'></span></div><p>We apologies, but we are currently undergoing server maintenance.<br><br>Our laptop database has been temporarily disabled.<br>We will be back in approximately ".$underwork." ".$hourtext."!</p></div>";
}
else {
require_once("lib/php/headermodel.php");
require_once("lib/php/genmodel.php");
?>
<style>
.modal-header {
    padding:0px!important;
    border-bottom: none!important;}
button.close {padding:2px 7px 0px 10px!important}
.modal-header .close {margin-top:0px!important;}
.modal-body {padding:0px 15px 15px 15px!important;}
.btn.active, .btn:active { box-shadow:none!important;}
.btn.active.focus, .btn.active:focus, .btn.focus, .btn:active.focus, .btn:active:focus, .btn:focus {outline:none!important}
</style>
<div class="container-fluid headerback" style="margin-right:0px;padding-right: 0px; padding-left: 0px;">

<?php
if($nonexistent)
{
	echo "<b>The model you are looking for doesn't exist.</b><br>";
	echo "<a href='../index.php' target='_self'> Let's go back to the home page, shall we?</a>";
}
else
{ 
?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-8 col-xl-offset-2 col-lg-offset-0" style="font-size:16px; color:#575757;">
		<h2 class="h4 strong modelHeader">
<?php
		$_SESSION['model'] = $idmodel; $model_data=show_vars('model.prod, families.fam, families.subfam, families.showsubfam, model.model,model.submodel,model.regions,model.keywords', 'notebro_db.MODEL model JOIN notebro_db.FAMILIES families ON model.idfam=families.id',$idmodel); $mprod=$model_data["prod"]; if(isset($model_data["subfam"])&&$model_data["showsubfam"]!=0){ $model_data["subfam"]=" ".$model_data["subfam"]; } else { $model_data["subfam"]=""; } $mfam=$model_data["fam"].$model_data["subfam"];  $mmodel=$model_data["model"];  $msubmodel=$model_data["submodel"]; 
		$mregion_id=explode(",",$model_data['regions']); if(array_search("1",$mregion_id)===FALSE){ $mregion="(".show_vars("disp","REGIONS",intval($mregion_id[0])).")"; $buy_regions=$model_data['regions']; } else { $mregion=""; $buy_regions=0; }
?>
				
<?php	
			echo "<span class='textModel'>".$mprod." ".$mfam." ".$mmodel." ".$msubmodel.$mregion."</span>"."<br>";
?>			
			<span id="cpu_title"></span>, <span style="font-size: 0;">processor</span>
			<span id="gpu_title"></span>, <span style="font-size: 0;">video card</span>
			<span id="mem_title"></span>, <span style="font-size: 0;">of Ram</span>
			<span id="hdd_title"></span>, <span style="font-size: 0;">storage</span>
			<span id="display_title"></span> inch display<span id="odd_title"></span><span id="sist_title"></span>
		</h2>
	</div>
<?php 
	echo "<script> var mprod='".$mprod."'; var mfamily='".$mfam."';  var mmodel='".$mmodel."'; var mid='".$idmodel."'; var keywords='".$keywords."';
	mmodel=(mmodel.replace(' dGPU','')); mmodel=(mmodel.replace(' FHD','')); mmodel=(mmodel.replace(' HD','')); mmodel=(mmodel.replace(' QHD','')); mmodel=(mmodel.replace(' WWAN','')); mmodel=(mmodel.replace(' vPro',''));
	metakeys(mprod.replace(' ',',')+','+mfamily.replace(' ',',')+','+mmodel.replace(' ',',')+',notebook,laptop'); exchsign='".showcurrency($exch)."'; document.title = mprod + ' ' + mfamily + ' ' + mmodel; </script>";
?>
	<div class="col-md-12 col-sm-12 col-xs-12 modelContainer" style="background-color:white; font-family:arial">
		<!-- Pictures -->
<?php
		show_vars('img_1,img_2,img_3,img_4','MODEL',$idmodel);
		$imglist=$show_vars;
?> 		<div class="row">
				<div class="col-lg-12 col-xl-8 col-xl-offset-2 col-lg-offset-0 modelImageContainer">
		<?php	if(isset($imglist["img_1"]))
				{ ?>
				<div class="row" style="display:flex;flex-wrap:wrap;">
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 firstImageModel" style="align-self:center"><a href="res/img/models/<?php echo $imglist["img_1"];?>" data-lightbox="slider"><img class="pics" style="width:100%; height:auto;" src="res/img/models/<?php echo $imglist["img_1"];?>" alt="<?php $mmodel ?>"></a></div>
		<?php 	}
				if($imglist["img_2"])
				{ ?>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4" style="align-self:center"><a href="res/img/models/<?php echo $imglist["img_2"];?>" data-lightbox="slider" data-lightbox="slider"><img class="pics" style="width:100%; height:auto;" src="res/img/models/<?php echo $imglist["img_2"];?>" alt="<?php $mmodel ?>"></a></div>
		<?php 	}
				if($imglist["img_3"])
				{ ?>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4" style="align-self:center"><a href="res/img/models/<?php echo $imglist["img_3"];?>" data-lightbox="slider" data-lightbox="slider"><img class="pics" style="width:100%; height:auto;" src="res/img/models/<?php echo $imglist["img_3"];?>" alt="<?php $mmodel ?>"></a></div>
		<?php 	} 
				if($imglist["img_4"])
				{ ?>	
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4" style="align-self:center"><a href="res/img/models/<?php echo $imglist["img_4"];?>" data-lightbox="slider" data-lightbox="slider"><img class="pics" style="width:100%; height:auto;" src="res/img/models/<?php echo $imglist["img_4"];?>" alt="<?php $mmodel ?>" data-lightbox="slider"></a></div>
		<?php 	} ?>
					<div  class="officialSiteContainer rating">	
						<div class="officialSite" style="padding:0px;">
							<p style="color:black;text-decoration:none; font-weight:bold">Official Site:</p>
						</div>
						<div class="officialSite" style="padding:0 0 0 5px;">
							<?php $imgprod=mysqli_fetch_array(mysqli_query($con,"SELECT pic,pic2 FROM notebro_site.brands WHERE brand='".$mprod."'")); show_vars('link,link2', 'MODEL',$idmodel );?>
							<a href="<?php echo $show_vars["link"].'" target="blank"><img src=res/'.$imgprod["pic"].' class="logoheightof" alt="Product consumer page">'; ?></a>
							<?php if(isset($show_vars["link2"]) && $show_vars["link2"]){ ?><a href="<?php echo $show_vars["link2"].'" target="blank"><img src=res/'.$imgprod["pic2"].' class="logoheightof" style="margin-left:2px" alt="Product business page">'; ?></a> <?php } ?>
						</div>
				</div>	
			</div>			
		</div> 
		</div>	<!-- row-->	
		<div class="row">
			<div class="col-lg-12 ptop col-xl-8 col-xl-offset-2 col-lg-offset-0">
				<div class="ratingContainer">
						<div class="rating" style="padding: 0px;">
							<p style="text-align:center;"><span><b>Rating: </b></span><span  class="labelblue"><span id="notebro_rate" style="margin-left:4px;"></span><span> / 100</span></span></p>
						</div>
						<div class="rating" style="padding: 0px;">
							<p style="text-align:center;"><span style=""><b>Price: </b></span><span  class="labelblue"><span style="margin-left:4px;"><?php echo " "; echo showcurrency($exch); ?></span><span id="config_price1" style="margin-left:2px;"></span> - <span id="config_price2"></span></span></p>
						</div>
						<div  class=" rating" style="padding: 0px;">
							<p style="text-align:center;"><span style=""><b>Battery: </b></span><span  class="labelblue"><span id="bat_life1" style="margin-left:4px;"></span> - <span id="bat_life2"></span><span> <?php echo " h"; ?></span></span></p>
						</div>	
				</div>				
				<div class="buy">
					<div class="dropdown">
						<button id="dLabel" class="btn addtocpmp buyBtn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-ref="<?php if(isset($usertag)&&$usertag!=""){ echo $usertag; } else { echo "";} ?>" data-target="buylist-0" data-price="0" data-idmodel="<?php echo $idmodel; ?>" data-idmodel="<?php echo $idmodel; ?>" data-buyregions="<?php echo $buy_regions; ?>" data-lang="<?php echo $lang; ?>" onclick="get_buy_list(this);">
							<span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Buy
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu" aria-labelledby="dLabel" id="buylist-0">
							<li class="loaderContainer">
								<span class="loader"></span>
							</li>
						</ul>
					</div><!-- Dropdown end div-->		
					<div class="btn addtocpmp" id="addcompare" >
						<a style="text-decoration:none;">Add to compare</a>
					</div><!-- addtocpmp-->	
					<div class="dropdown config">
						<button id="dLabel" class="btn addtocpmp showConfigOption" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Configure for
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu configDropdown" aria-labelledby="dLabel">
							<li class="configOptions" <?php if(!isset($best_low["best_value"])||(isset($best_low["best_value"])&&$best_low["best_value"]=="")){ echo 'style="display:none;"'; } ?> onmousedown="OpenPage('<?php echo "model/model.php?conf=".$best_low["best_value"]."_".$idmodel."&ex=".$exchcode.""; ?>',event)";>Best Value</li>
							<li class="configOptions" <?php if(!isset($best_low["best_performance"])||(isset($best_low["best_performance"])&&$best_low["best_performance"]=="")){ echo 'style="display:none;"'; } ?> onmousedown="OpenPage('<?php echo "model/model.php?conf=".$best_low["best_performance"]."_".$idmodel."&ex=".$exchcode.""; ?>',event)";>Max Performance</li>
							<li class="configOptions" <?php if(!isset($best_low["lowest_price"])||(isset($best_low["lowest_price"])&&$best_low["lowest_price"]=="")){ echo 'style="display:none;"'; } ?> onmousedown="OpenPage('<?php echo "model/model.php?conf=".$best_low["lowest_price"]."_".$idmodel."&ex=".$exchcode.""; ?>',event)";>Lowest Price</li>						
						</ul>
					</div><!-- End Configuration div-->	
				</div>
			</div>
		</div>	<!-- row-->		
		<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12" style="padding:0px" >
			<!-- <div class="col-md-5 col-sm-6 col-xs-12 col-lg-5" style="margin-top:15px; padding:0px;">
				<a style="font-weight:bold; color:black;text-decoration:none; cursor:pointer;" onclick="scrolltoid('leave_comment');">Leave a comment !</a>
				<br>				
			</div> -->
			<div class="col-md-7 col-sm-6 col-xs-12 col-lg-7" style="margin-top:10px; padding:0px;"></div>
		</div>		
		<!-- start specs -->
		<div class="col-md-12 col-sm-12 col-xs-12" style="background-color:white; font-family:arial;padding:0px;text-align:left;">
			<div class="col-md-4 col-sm-6 col-lg-4 col-xs-12 btn" style="text-align:left;padding-top:0px">
				<div>
					<span class="toggler compmod showDetailsButton" data-hide="all" style="color:black;padding:2px 20px;font-weight:normal"><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span><span class="showDetails"> Show all</span><span class="showLessDetails"> Show less</span></span>
					<!-- We take great effort to assure component compatibility for each configuration. If you think we made a mistake, please contact us. -->
				</div>
			</div>
			<br><br>
			<!-- START FIRST HALF OF MODEL -->
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<!-- CPU -->
				<div class="row modelwidht">
					<div class="col-md-12 titlucomp toolinfo text-center" data-toolid="0" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-load="1" data-original-title="data-loading..."><strong><span class="toolinfo1 headerComponents">Processor</span></strong></div>
				</div>
				<div class="row modelwidht">	
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
						<div class="row detaliicomp">					
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Model:</div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows"><?php show_cpu($modelcpu);?></div>							
						</div>
						<div class="row detaliicomp">					
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Launch date:</div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows" id="cpu_ldate"></div>					
						</div>	
						<div class="row hidecpu hideall detaliicomp" style="display:none">					
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="1" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top"  data-original-title="data-loading..."><span class="toolinfo1">Socket:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="1" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id="cpu_socket"></span></span></div>
						</div>
						<div class="row hidecpu hideall detaliicomp" style="display:none">					
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="6" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Technology:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="6" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id="cpu_tech"></span> nm</span></div>							
						</div>	
						<div class="row hidecpu hideall detaliicomp" style="display:none">					
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="7" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Cache:</span></div>
							<div class="col-md-7 col-xs-7 co7-sm-7 col-lg-7 rows toolinfo" data-toolid="7" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id="cpu_cache"></span> MB</span></div>							
						</div>	
						<div class="row hidecpu hideall detaliicomp" style="display:none">					
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="2" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Base Speed:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="2" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id="cpu_speed"></span> GHz</span></div>										
						</div>
						<div class="row detaliicomp">					
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="4" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Max. Speed:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="4" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id="cpu_turbo"></span> GHz</span></div>							
						</div>	
						<div class="row hidecpu hideall detaliicomp" style="display:none">					
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="8" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">TDP:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="8" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id="cpu_tdp"></span> W</span></div>							
						</div>	
						<div class="row detaliicomp">					
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="3" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Nr. of cores:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="3" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id="cpu_cores"></span></span></div>	
						</div>
						<div class="row hidecpu hideall detaliicomp" style="display:none">					
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Miscellaneous:</div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows" id="cpu_misc"></div>						
						</div>	
						<div class="row detaliicomp">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Performance class:</div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows" id="cpu_class"></div>
						</div>
						<div class="row detaliicomp">					
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="5" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Rating:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="5" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><b><span  class="labelblue-s"><span id="cpu_rating" ></span> / 100</span></b></span></div>							
						</div>	
						<div class="expandContainer">
							<a class="toggler toolinfo" data-hide="cpu" data-toolid="100" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 700}' data-placement="top" data-original-title="data-loading..." style="text-decoration:none; color:black;margin-top: 10px;"><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></a>					
						</div>
					</div>
				</div>	
				<br>
				<!-- Video Card -->
				<div class="row titlucomp toolinfo modelwidht" data-toolid="20" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading...">
					<div class="col-md-12 text-center"><strong><span class="toolinfo1 headerComponents">Video card</span></strong></div>
				</div>
				<div class="row modelwidht">						
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
						<div class="row detaliicomp">					
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Model:</div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows gpuhddd"><?php show_gpu($modelgpu); ?></div>							
						</div>	
						<div class="row hidegpu hideall detaliicomp" style="display:none">					
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="22" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Architecture:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="22" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id="gpu_arch"></span></span></div>					
						</div>
						<div class="row hidegpu hideall detaliicomp" style="display:none">					
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="32" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Technology:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="32" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id="gpu_tech"></span> nm</span></div>
						</div>
						<div class="row hidegpu hideall detaliicomp" style="display:none">					
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="23" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Pipelines:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="23" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id="gpu_shaders"></span> pipelines</span></div>
						</div>
						<div class="row detaliicomp">					
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="21" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Core Speed:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="21" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id="gpu_speed"></span> MHz</span></div>		
						</div>	
						<div class="row hidegpu hideall detaliicomp" style="display:none">					
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="24" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Shader model:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="24" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id="gpu_shadermodel"></span></span></div>		
						</div>						
						<div class="row detaliicomp" >					
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="25" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Memory speed:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="25" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id="gpu_memspeed"></span> MHz</span></div>
						</div>
						<div class="row hidegpu hideall detaliicomp" style="display:none">					
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="26" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Memory bus:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="26" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id="gpu_bus"></span> bit</span></div>
						</div>
						<div class="row detaliicomp">					
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="28" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Memory size:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="28" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id="gpu_mem"></span></span></div>		
						</div>			
						<div class="row hidegpu hideall detaliicomp" style="display:none">					
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="27" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Shared memory:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="27" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><b><span id="gpu_smem"></span></b></span></div>
						</div>
						<div class="row hidegpu hideall detaliicomp" style="display:none">					
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="29" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">TDP:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="29" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id="gpu_tdp"></span> W</span></div>
						</div>
						<div class="row hidegpu hideall detaliicomp" style="display:none">					
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Miscellaneous:</div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows" id="gpu_misc"></div>
						</div>
						<div class="row detaliicomp">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Performance class:</div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows" id="gpu_class"></div>		
						</div>	
						<div class="row detaliicomp">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="30" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Rating:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="30" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><b><span  class="labelblue-s"><span id="gpu_rating"></span> / 100</span></b></span></div>
						</div>		
						<div class="expandContainer">
							<a class="toggler toolinfo" data-hide="gpu" data-toolid="100" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 700}' data-placement="top" data-original-title="data-loading..." style="text-decoration:none; color:black;margin-top: 10px;"><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></a>					
						</div>
					</div>															
				</div>
				<br>	
				<!-- Display -->
				<div class="row titlucomp toolinfo modelwidht" data-toolid="42" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading...">
					<div class="col-md-12 text-center"><strong><span class="toolinfo1 headerComponents">Display</span></strong></div>
				</div>
				<div class="row modelwidht">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="row detaliicomp">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Model:</div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows"><?php show_display($modeldisplay); ?></div>					
						</div>
						<div class="row detaliicomp">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="43" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Size:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="43" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id="display_size"></span> inch</span></div>
						</div>
						<div class="row hidedis hideall detaliicomp" style="display:none">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="44" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Format:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="44" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id="display_format"></span></span></div>
						</div>
						<div class="row detaliicomp">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="45" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Resolution:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="45" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span  class="labelblue-s"><span id="display_hres"></span> x <span id="display_vres"></span> pixels</span></span></div>
						</div>
						<div class="row detaliicomp">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="46" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Surface type:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="46" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id="display_surft"></span></span></div>
						</div>
						<div class="row detaliicomp">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="47" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Technology:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="47" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id="display_backt"></span></span></div>
						</div>
						<div class="row detaliicomp">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Touchscreen:</div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows" id="display_touch"></div>
						</div>
						<div class="row hidedis hideall detaliicomp" style="display:none"> 
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Miscellaneous:</div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows" id="display_misc"></div>
						</div>
						<div class="row hidedis hideall detaliicomp" style="display:none">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="48" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Rating:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="48" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id="display_rating"></span> / 100</span></div>
						</div>
						<div class="expandContainer">
							<a class="toggler toolinfo" data-hide="dis" data-toolid="100" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 700}' data-placement="top" data-original-title="data-loading..." style="text-decoration:none; color:black;margin-top: 10px;"><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></a>					
						</div>
					</div>
				</div>
				<br>
				<!-- Storage -->
				<div class="row titlucomp modelwidht">
					<div class="col-md-12 text-center"><strong><span class="headerComponents">Storage</span></strong></div>
				</div>
				<div class="row modelwidht">						
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="row detaliicomp">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="50" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Model/Capacity:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows gpuhdd"><?php show_hdd($modelhdd); ?></div>
						</div>
						<div class="row detaliicomp">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="49" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">RPM:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="49" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id ="hdd_rpm"></span></span></div>
						</div>
						<div class="row hidesto hideall detaliicomp" style="display:none">						
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="51" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Type:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="51" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id ="hdd_type"></span></span></div>
						</div>
						<div class="row hidesto hideall detaliicomp" style="display:none">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Read Speed:</div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows"><span id ="hdd_readspeed"></span> MB/s</div>
						</div>
						<div class="row hidesto hideall detaliicomp" style="display:none">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Write Speed:</div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows"><span id ="hdd_writes"></span> MB/s</div>
						</div>
						<div class="row hidesto hideall detaliicomp" style="display:none">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Miscellaneous:</div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows" id ="hdd_misc"></div>
						</div>
						<div class="expandContainer">
							<a class="toggler toolinfo" data-hide="sto" data-toolid="100" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 700}' data-placement="top" data-original-title="data-loading..." style="text-decoration:none; color:black;margin-top: 10px;"><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></a>					
						</div>
					</div>
				</div>
<?php
				$shddtext=show_shdd($modelshdd); 
				if($shddtext)
				{ 
?>	
					<br>
					<!-- Secondary Storage (if exists) -->						
					<div class="row titlucomp modelwidht">
						<div class="col-md-12 text-center"><strong><span class="headerComponents">Secondary Storage</span></strong></div>
					</div>
					<div class="row modelwidht">						
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="row detaliicomp">
								<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="50" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Capacity:</span></div>
								<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows"><?php echo $shddtext; ?></div>
							</div>
							<div class="row hidesto1 hideall detaliicomp" style="display:none">	
								<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="49" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">RPM:</span></div>
								<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="49" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..." ><span class="toolinfo1"><span id ="shdd_rpm"></span></span></div>
							</div>
							<div class="row hidesto1 hideall detaliicomp" style="display:none">						
								<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="51" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Type:</span></div>
								<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="51" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..." ><span class="toolinfo1"><span id ="shdd_type"></span></span></div>
							</div>
							<div class="row hidesto1 hideall detaliicomp" style="display:none">
								<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Read Speed:</div>
								<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows" ><span id ="shdd_readspeed"></span> MB/s</div>
							</div>
							<div class="row hidesto1 hideall detaliicomp" style="display:none">
								<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Write Speed:</div>
								<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows" ><span id ="shdd_writes"></span> MB/s</div>
							</div>
							<div class="expandContainer">
								<a class="toggler toolinfo" data-hide="sto1" data-toolid="100" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 700}' data-placement="top" data-original-title="data-loading..." style="text-decoration:none; color:black;margin-top: 10px;"><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></a>					
							</div>
						</div>
					</div>		
<?php			} ?>
				<br>
				<!-- Motherboard -->	
				<div class="row titlucomp toolinfo modelwidht" data-toolid="53" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading...">
					<div class="col-md-12 text-center"><strong><span class="toolinfo1 headerComponents">Motherboard</span></strong></div>
				</div>
				<div class="row modelwidht">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="row detaliicomp">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Submodel:</div>
								<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows"><?php show_mdb($modelmdb); ?></div>
						</div>
						<div class="row detaliicomp">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="54" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Memory Slots:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="54" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id = "mdb_ram"></span></span></div>
						</div>
						<div class="row detaliicomp hideall hidemdb" style="display:none">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="52" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Video on board:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="52" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id = "mdb_gpu"></span></span></div>					
						</div>
						<div class="row detaliicomp">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="55" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Chipset:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="55" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id = "mdb_chipset"></span></span></div>
						</div>
						<div class="row hidemdb hideall detaliicomp" style="display:none">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="56" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Int. Interfaces:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="56" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id = "mdb_interface"></span></span></div>
						</div>
						<div class="row detaliicomp">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="58" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Network:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="58" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id = "mdb_netw"></span></span></div>
						</div>
						<div class="row hidemdb hideall detaliicomp" style="display:none">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="57" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">HDD Interfaces:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="57" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id = "mdb_hdd"></span></span></div>
						</div>
						<div class="row hidemdb hideall detaliicomp" style="display:none">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Miscellaneous:</div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows" id = "mdb_misc"></div>
						</div>
						<div class="expandContainer">
							<a class="toggler toolinfo" data-hide="mdb" data-toolid="100" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 700}' data-placement="top" data-original-title="data-loading..." style="text-decoration:none; color:black;margin-top: 10px;"><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></a>					
						</div>
					</div>
				</div>
			</div>
			<!-- END FIRST HALF OF MODEL -->
			<!-- START SECOND HALF OF MODEL -->
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">				
				<div class="row titlucomp toolinfo modelwidht" data-toolid="59" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading...">
					<div class="col-md-12 text-center"><strong><span class="toolinfo1 headerComponents">Memory</span></strong></div>
				</div>
				<div class="row modelwidht">						
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="row detaliicomp">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="62" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Capacity:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows"><?php show_mem($modelmem); ?></div>
						</div>
						<div class="row hidemem hideall detaliicomp" style="display:none">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="61" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Standard:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="61" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id = "mem_stan"></span></span></div>
						</div>
						<div class="row detaliicomp">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="60" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Type:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="60" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id = "mem_type"></span> - <span id = "mem_freq"></span> MHz</span></div>
						</div>
						<div class="row hidemem hideall detaliicomp" style="display:none">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="63" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">CAS Latency :</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="63" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id = "mem_lat"></span></span></div>
						</div>
						<div class="row hidemem hideall detaliicomp" style="display:none">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Miscellaneous:</div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows" id = "mem_misc"></div>
						</div>
						<div class="expandContainer">
							<a class="toggler toolinfo" data-hide="mem" data-toolid="100" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 700}' data-placement="top" data-original-title="data-loading..." style="text-decoration:none; color:black;margin-top: 10px;"><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></a>					
						</div>
					</div>
				</div>
				<br>
				<!--Optical Drive (if exists) -->		
				<div class="row titlucomp toolinfo modelwidht" data-toolid="64" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading...">
					<div class="col-md-12 text-center"><strong><span class="toolinfo1 headerComponents">Optical drive</span></strong></div>
				</div>
				<div class="row modelwidht">					
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="row detaliicomp">					
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="65" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Type:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="65" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><?php $showodd=show_odd($modelodd); ?></span></div>
						</div>
<?php					if($showodd) 
						{ ?>
							<div class="row hideodd hideall detaliicomp" style="display:none">
								<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="66" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Speed:</span></div>
								<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="66" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id = "odd_speed"></span>X</span></div>
							</div>					
							<div class="row hideodd hideall detaliicomp" style="display:none">
								<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Miscellaneous:</div>
								<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows" id = "odd_misc"></div>
							</div>
							<div class="expandContainer">
								<a class="toggler toolinfo" data-hide="odd" data-toolid="100" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 700}' data-placement="top" data-original-title="data-loading..." style="text-decoration:none; color:black;margin-top: 10px;"><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></a>					
							</div>
<?php					} ?>
					</div>			
				</div>	
				<br>
				<!-- Battery -->	
				<div class="row titlucomp modelwidht">
					<div class="col-md-12 text-center"><strong><span class="headerComponents">Battery</span></strong></div>
				</div>
				<div class="row modelwidht">					
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="row detaliicomp">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="67" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Capacity:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows"><?php show_acum($modelacum); ?></div>
						</div>
						<div class="row detaliicomp">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Cell Number:</div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows" id = "acum_cell"></div>
						</div>
						<div class="row hideacu hideall detaliicomp" style="display:none">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Cell Type:</div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows" id = "acum_tipc"></div>
						</div>
						<div class="row hideacu hideall detaliicomp" style="display:none">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Voltage:</div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows"><span id = "acum_volt"></span></div>
						</div>	
						<div class="row hideacu hideall detaliicomp" style="display:none">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Weight:</div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows"><span id = "acum_weight"></span><span id = "acum_weight_i"></span></div>
						</div>
						<div class="row hideacu hideall detaliicomp" style="display:none">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Miscellaneous:</div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows" id = "acum_misc"></div>
						</div>
						<div class="expandContainer">
							<a class="toggler toolinfo" data-hide="acu" data-toolid="100" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 700}' data-placement="top" data-original-title="data-loading..." style="text-decoration:none; color:black;margin-top: 10px;"><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></a>					
						</div>
					</div>
				</div>
				<br>
				<!-- Chassis -->	
				<div class="row titlucomp toolinfo modelwidht" data-toolid="69" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading...">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center"><strong><span class="toolinfo1 headerComponents">Chassis</span></strong></div>
				</div>
				<div class="row modelwidht">					
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<?php
					$chassistext=show_chassis($modelchassis);
					if($chassistext && (strcasecmp($chassistext,"standard")!=0))
					{ ?>
						<div class="row hidecha hideall detaliicomp" style="display:none">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows"><span class="toolinfo1">Type:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows"><?php echo $chassistext; ?></div>
						</div>				
<?php				 } ?>									
						<div class="row detaliicomp">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="70" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Peripheral Interfaces:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="70" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id = "chassis_pi"></span></span></div>
						</div>
						<div class="row hidecha hideall detaliicomp" style="display:none">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="77" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Video Interfaces:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="77" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id = "chassis_vi"></span></span></div>
						</div>
						<div class="row hidecha hideall detaliicomp" style="display:none">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="76" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Webcam:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="76" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id = "chassis_web"></span></span></div>
						</div>
						<div class="row hidecha hideall detaliicomp" style="display:none">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Touchpad:</div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows" id = "chassis_touch"></div>
						</div>
						<div class="row hidecha hideall detaliicomp" style="display:none">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Keyboard:</div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows" id = "chassis_keyboard"></div>
						</div>
						<div class="row hidecha hideall detaliicomp" style="display:none">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Charger:</div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows"><span id = "chassis_charger"></span></div>
						</div>				
						<div class="row detaliicomp">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="84" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-load="1" data-original-title="data-loading..."><span class="toolinfo1">Weight:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="84" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-load="1" data-original-title="data-loading..."><span class="toolinfo1"><span id = "chassis_weight"></span> Kg (<span id = "chassis_weight_i"></span> lb)</span></div>
						</div>
						<div class="row detaliicomp">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="85" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-load="1" data-original-title="data-loading..."><span class="toolinfo1">Thickness:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="85" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-load="1" data-original-title="data-loading..."><span class="toolinfo1"><span id = "chassis_thic"></span> cm (<span id = "chassis_thic_i"></span>")</span></div>
						</div>
						<div class="row detaliicomp">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Depth:</div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows"><span id = "chassis_depth"></span> cm (<span id = "chassis_depth_i"></span>")</div>
						</div>
						<div class="row detaliicomp">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Width:</div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows"><span id = "chassis_width"></span> cm (<span id = "chassis_width_i"></span>")</div>
						</div>
						<div class="row hidecha hideall detaliicomp" style="display:none">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Colors:</div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows" id = "chassis_color"></div>
						</div>
						<div class="row hidecha hideall detaliicomp" style="display:none">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Material:</div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows" id = "chassis_material"></div>
						</div>
						<div class="row hidecha hideall detaliicomp" style="display:none">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Miscellaneous:</div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows" id = "chassis_misc"></div>
						</div>
						<div class="expandContainer">
							<a class="toggler toolinfo" data-hide="cha" data-toolid="100" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 700}' data-placement="top" data-original-title="data-loading..." style="text-decoration:none; color:black;margin-top: 10px;"><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></a>					
						</div>
					</div>
				</div>
				<br>
				<!-- Wireless card -->	
				<div class="row titlucomp toolinfo modelwidht" data-toolid="71" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading...">
					<div class="col-md-12 text-center"><strong><span class="toolinfo1 headerComponents">Wireless card</span></strong> </div>
				</div>
				<div class="row modelwidht">				
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="row detaliicomp">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Model:</div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows"><?php show_wnet($modelwnet); ?></div>
						</div>
						<div class="row detaliicomp">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Slot:</div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows"><span id = "wnet_slot"></span></div>
						</div>					
						<div class="row hidewnet hideall detaliicomp" style="display:none">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="72" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Speed:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="72" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id = "wnet_speed"></span></span></div>
						</div>
						<div class="row detaliicomp">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="73" data-load="1" data-html="true" data-toggle="tooltip1" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Standard:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="73" data-load="1" data-html="true" data-toggle="tooltip1" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id = "wnet_stand"></span></span></div>
						</div>
						<div class="row hidewnet hideall detaliicomp" style="display:none">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Miscellaneous:</div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows" id = "wnet_misc"></div>
						</div>
						<div class="expandContainer">
							<a class="toggler toolinfo" data-hide="wnet" data-toolid="100" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 700}' data-placement="top" data-original-title="data-loading..." style="text-decoration:none; color:black;margin-top: 10px;"><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></a>					
						</div>
					</div>
				</div>
				<br>
				<!-- Warranty -->			
				<div class="row modelwidht">
					<div class="col-md-12 titlucomp text-center"><strong><span class="headerComponents">Warranty</span></strong></div>
				</div>
				<div class="row modelwidht">					
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="row detaliicomp">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">Years:</div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows"><?php show_war($modelwar); ?></div>					
						</div>
						<div class="row detaliicomp">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows toolinfo" data-toolid="74" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1">Miscellaneous:</span></div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows toolinfo" data-toolid="74" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading..."><span class="toolinfo1"><span id = "war_misc"></span></span></div>
						</div>
					</div>				
				</div>
				<br>
				<!-- Operating System -->	
				<div class="row toolinfo modelwidht" data-toolid="75" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600}' data-placement="top" data-original-title="data-loading...">
					<div class="col-md-12 titlucomp text-center"><strong><span class="toolinfo1 headerComponents">Operating System</span></strong></div>
				</div>
				<div class="row modelwidht">					
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="row detaliicomp">
							<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows">System:</div>
							<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows"><?php show_sist($modelsist); ?></div>
						</div>
					</div>
				</div>
				<br>
				<!-- Miscellaneous -->
<?php			$msctext=show_vars('msc','MODEL',$idmodel); 
				if(!($msctext==""))
				{ ?>
					<div class="row modelwidht">
						<div class="col-md-12 titlucomp text-center"><strong><span class="headerComponents">Miscellaneous</span></strong></div>
					</div>
					<div class="row modelwidht">					
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="row detaliicomp">
								<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 rows" data-placement="top" title="data-loading...">About:</div>
								<div class="col-md-7 col-xs-7 col-sm-7 col-lg-7 rows"><?php echo $msctext;?></div>
							</div>
						</div>
					</div>
<?php 			} ?>
			</div>
			<!-- END SECOND HALF OF MODEL -->
		</div>
		
		<!-- end specs -->
		<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
			<p class="disclaimernb"><strong> Disclaimer.</strong> We can not guarantee that the information on this page is 100% correct. <a href="<?php echo $web_address; ?>?footer/contact.php">Submit correction.</a></p>
		</div>
<?php
	include("lib/php/db_reviews.php");
	
	if($nr_nb_reviews>0)
	{
?>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
		<div> <!-- internal reviews div-->
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ListTitle">Noteb Reviews</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:0px;">
				<?php foreach($nb_reviews as $el) { ?>	
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ListElem">
					<a onmousedown="OpenPage('<?php echo $el["link"]; ?>',event);"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="font-weight:bold;text-align:center;font-size:medium;cursor: pointer;"><?php echo $el["title"]; ?></div></a>
				</div>
			<?php } ?>
			</div>
		</div>
<?php 
	}
	if($nr_int_reviews>0)
	{
?>
		<div> <!-- external reviews div-->			
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ListTitle">External reviews</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ListBox" style="padding:0px;">
				<?php foreach($int_reviews as $el) { ?>	
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ListElem">
					<a href="<?php echo $el["link"]; ?>" target="blank" >
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="font-weight:bold;font-size:medium;"><?php echo $el["site"]; ?></div					
					</a>
				</div>
				<?php } ?>
			</div>		
		</div>
	</div>
<?php } ?>
</div>
	<!-- REVIEWS -->

	<!-- COMMENTS -->
	<div id="disqus_thread" style="margin-left: 10px;"></div>
	<div id="leave_comment"></div>

 <script><?php include("lib/php/genjsmodel.php"); ?></script>
 <script>$.getScript("model/lib/js/model.js");</script>
 <script>
 $( document ).ready(function() {
    lightbox.option({
      'resizeDuration': 200,
      'fadeDuration' : 200,
      'imageFadeDuration':200     
    });

    $('meta[name=description]').attr('content', mprod + ' ' + mfamily + ' ' + mmodel);
});
</script>
<?php  
} } ?>
</div>
<link rel="stylesheet" href="model/lib/css/model.css?v=70" type="text/css"/>
<?php include_once("../etc/scripts_pages.php"); ?>