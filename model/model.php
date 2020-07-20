<?php
require_once("../etc/conf.php");
if (!isset($_SERVER['HTTP_REFERER']) || stripos($_SERVER['HTTP_REFERER'],$site_name) ==FALSE) 
{	$actual_link="$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	header("Location: http://".str_replace($site_name."/",$site_name."/?",$actual_link)."");
	die();
}
$rootpath=realpath($_SERVER["DOCUMENT_ROOT"]).$root_mod;
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
.modal-header { padding:0px!important; border-bottom: none!important;}
button.close {padding:2px 7px 0px 10px!important}
.modal-header .close {margin-top:0px!important;}
.modal-body {padding:0px 15px 15px 15px!important;}
.btn.active, .btn:active { box-shadow:none!important;}
.btn.active.focus, .btn.active:focus, .btn.focus, .btn:active.focus, .btn:active:focus, .btn:focus {outline:none!important}
.rating.currency select {
	color: #fff;
	background: var(--main-color) url("<?php echo $web_address; ?>/lib/fonts/fontawesome/svgs/solid/caret-down-white.svg") no-repeat right .75rem center;
	background-size: 12px;
}
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
	
	<div class="container bg-white modelContainer">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-lg-offset-0">
				<div class="model-main-title">
					<h2 class="modelHeader bold-font">
			<?php
					$_SESSION['model']=$idmodel; $model_data=show_vars('model.prod, families.fam, families.subfam, families.showsubfam, model.model,model.submodel,model.regions,model.keywords', 'notebro_db.MODEL model JOIN notebro_db.FAMILIES families ON model.idfam=families.id',$idmodel); $mprod=$model_data["prod"]; if(isset($model_data["subfam"])&&$model_data["showsubfam"]!=0){ $model_data["subfam"]=" ".$model_data["subfam"]; } else { $model_data["subfam"]=""; } $mfam=$model_data["fam"].$model_data["subfam"]; $mmodel=$model_data["model"]; if($model_data["submodel"]!=""&&$model_data["submodel"]!=NULL){ $msubmodel="".$model_data["submodel"];} $veto_mname=show_vars('value','notebro_site.vars',2);
					$mregion_id=explode(",",$model_data['regions']); if(array_search("1",$mregion_id)===FALSE){ $mregion=" (".show_vars("disp","REGIONS",intval($mregion_id[0])).")"; $buy_regions=$model_data['regions']; } else { $mregion=""; $buy_regions=0; }
			?>
							
			<?php	
						echo "<span class='textModel' id='model_title'>".$mprod." ".$mfam." ".$mmodel.$msubmodel.$mregion."</span>"."<br>";
			?>			
					</h2>
					<p><span id="cpu_title"></span>, <span style="font-size: 0;">processor</span>
					<span id="gpu_title"></span>, <span style="font-size: 0;">video card</span>
					<span id="mem_title"></span>, <span style="font-size: 0;">of Ram</span>
					<span id="hdd_title"></span>, <span style="font-size: 0;">storage</span>
					<span id="display_title"></span> inch display<span id="odd_title"></span><span id="sist_title"></span></p>
				</div>
			</div>
		</div>

<?php 
	echo "<script> var mprod='".$mprod."'; var mfamily='".$mfam."';  var mmodel='".$mmodel."'; var msubmodel='".$msubmodel."'; var mid='".$idmodel."'; var pmodel='".$p_model."'; var keywords='".$keywords."'; var veto_mname='".$veto_mname."'.split(',');</script>";
?>
		<!-- Pictures -->
<?php
		show_vars('img_1,img_2,img_3,img_4','MODEL',$idmodel);
		$imglist=$show_vars;
?> 		<div class="row ">
				<div class="col-lg-5 col-xl-5">
		<?php	if(isset($imglist["img_1"]))
				{ ?>
				<div id="model-carousel" class="row owl-carousel">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 firstImageModel" data-dot="<img class='pics' src='res/img/models/<?php echo $imglist["img_1"];?>' alt='<?php $mmodel ?>'>" data-toggle="modal" data-target="#galleryModal">
							<img class="pics" src="res/img/models/<?php echo $imglist["img_1"];?>" alt="<?php $mmodel ?>">
						</div>
						<?php 	}

				if($imglist["img_2"])
				{ ?>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 firstImageModel" data-dot="<img class='pics' src='res/img/models/<?php echo $imglist["img_2"];?>' alt='<?php $mmodel ?>'>" data-toggle="modal" data-target="#galleryModal">
						<img class="pics" src="res/img/models/<?php echo $imglist["img_2"];?>" alt="<?php $mmodel ?>">
					</div>
		<?php 	}
				if($imglist["img_3"])
				{ ?>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 firstImageModel" data-dot="<img class='pics' src='res/img/models/<?php echo $imglist["img_3"];?>' alt='<?php $mmodel ?>'>" data-toggle="modal" data-target="#galleryModal">
					<img class="pics" src="res/img/models/<?php echo $imglist["img_3"];?>" alt="<?php $mmodel ?>">
				</div>
		<?php 	} 
				if($imglist["img_4"])
				{ ?>	
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 firstImageModel" data-dot="<img class='pics' src='res/img/models/<?php echo $imglist["img_4"];?>' alt='<?php $mmodel ?>'>" data-toggle="modal" data-target="#galleryModal">
						<img class="pics" src="res/img/models/<?php echo $imglist["img_4"];?>" alt="<?php $mmodel ?>">
					</div>
				
		<?php 	} ?>
			</div>
				
		</div>
		<div class="col-lg-7 col-xl-7 ptop">
		<div class="row">
			<div class="col-lg-5 col-xl-5 ratingContainer">
				<div  class="rating">
					<p class="bold-font">Battery: <span id="bat_life1" class="labelblue"></span> - <span id="bat_life2" class="labelblue"></span><span> <?php echo " h"; ?></span></p>
				</div>
				<!-- Comentate temporar -->
				<!-- <div class="rating-element productvity-rating hide-when-affix">
					<div class="rating-label">Productivity</div>
					<div class="progress-container">
						<?php echo $rating_svg ?>
						<span class="progress-value" id="notebro_productivity_rate">4.82</span>			
					</div>
				</div>
				<div class="rating-element gaming-rating hide-when-affix">
					<div class="rating-label">Gaming</div>
					<div class="progress-container">
						<?php echo $rating_svg ?>
						<span class="progress-value" id="notebro_gaming_rate">6.35</span>
					</div>
				</div>
				<div class="rating-element mobility-rating hide-when-affix">
					<div class="rating-label">Mobility</div>
					<div class="progress-container">
						<?php echo $rating_svg ?>
						<span class="progress-value" id="notebro_mobility_rate">3.69</span>	
					</div>
				</div> -->
				<div class="rating-element overall-rating hide-when-affix">
					<div class="rating-label bold-font">
						<span class="toolinfo" data-toolid="102" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
							Overall rating: <i class="fa fa-question toolinfo-icon"></i>
						</span>
					</div>
					<div class="progress-container">
						<?php echo $rating_svg ?>
							<span class="progress-value bold-font labelblue" id="notebro_rate" ></span>
					</div>
				</div>
			</div>
			<div class="col-lg-7 col-xl-7 actionsContainer">		
				<div class="buy">
				<div  class="officialSiteContainer rating">	
						<div class="officialSite">
							<p>Official Site:</p>
						</div>
						<div class="officialSite officialSiteLogo">
							<?php $imgprod=mysqli_fetch_array(mysqli_query($con,"SELECT pic,pic2 FROM notebro_site.brands WHERE brand='".$mprod."'")); show_vars('link,link2', 'MODEL',$idmodel );
							$aff_link=null;
							if(isset($show_vars["link2"]) && $show_vars["link2"] && isset($usertag)&& $usertag!="" && $usertag!="noref")
							{
								$include_aff_gen=true; $function_replay=null; $_POST["usertag"]=$usertag; $_POST["links"]=$show_vars["link"]; $_POST["sellers"]=$show_vars["link2"]; require_once("../libnb/php/aff_gen.php");
								if($function_replay!=null&&isset($function_replay[0])&&$function_replay[0]!=null)
								{ 
									$function_replay=json_decode($function_replay);
									if($function_replay!=null&&isset($function_replay[0])&&$function_replay[0]!=null)
									{ 	$aff_link=$function_replay; }
								}
							}
							if($aff_link&&isset($aff_link[0])&&$aff_link[0]!=NULL&&$aff_link[0]!=""){$show_vars["link"]=$aff_link[0];}
							?>
							<a href="<?php echo $show_vars["link"]; ?>" target="blank"><img src="<?php echo str_replace("//","/","/res/".$imgprod["pic"]); ?>" class="logoheightof" alt="Product consumer page"></a>
						</div>
				</div>
				<div class="rating currency d-flex btn btn-outline-secondary btn-lg actionButton">
						<div class="input-group">
							<select class="custom-select bold-font" style="font-size:13pt;" id="m_currency" aria-label="Currency change" onchange="change_m_currency(this);">
							<?php
								foreach($model_ex_list as $val)
								{
									$selected=""; if($selected_ex==$val){$selected=' selected="selected"';}
									echo '<option data-id="'.$exchange_list->{$val}["id"].'" data-exch="'.$exchange_list->{$val}["convr"].'" value="'.$val.'"'.$selected.'>'.$exchange_list->{$val}["sign"].'</option>';
								}									
								?>
							</select>								 
						</div>
						<span class="price-range bold-font"><span id="config_price1"></span> - <span id="config_price2"></span></span>
					</div>
					<div class="dropdown actionButton">
						<button id="dLabel" class="btn btn-primary btn-lg addtocpmp buyBtn bold-font" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-ref="<?php if(isset($usertag)&&$usertag!=""){ echo $usertag; } else { echo "";} ?>" data-target="buylist-0" data-price="0" data-idmodel="<?php echo $idmodel; ?>" data-idmodel="<?php echo $idmodel; ?>" data-buyregions="<?php echo $buy_regions; ?>" data-lang="<?php echo $lang; ?>" data-cpu="" data-gpu="" data-iddisplay="" data-pmodel="<?php echo $p_model; ?>" onclick="get_buy_list(this);">
							Buy now
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu buyDropdownMenu" aria-labelledby="dLabel" id="buylist-0">
							<li class="loaderContainer">
								<span class="loader"></span>
							</li>
						</ul>
						<?php include_once("../libnb/php/aff_modal.php"); ?>
					</div><!-- Dropdown end div-->		
					<div class="btn btn-outline-primary btn-lg findsimilar actionButton bold-font" id="findsimilar" onclick="similar_model_search();">
						<a>Similar laptops</a>
					</div><!-- addtocpmp-->	
					<div class="d-flex actionButtonsContainer">
						<div class="btn btn-outline-primary btn-lg addtocpmp actionButton" id="addcompare" >
							<a>Add to compare</a>
						</div><!-- addtocpmp-->	
						<div class="dropdown config actionButton">
							<button id="dLabel" class="btn btn-outline-primary btn-lg addtocpmp showConfigOption" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Configure for
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu configDropdown" aria-labelledby="dLabel">
								<li class="configOptions" id="best_value_id" <?php if(!isset($best_low["best_value"])||(isset($best_low["best_value"])&&$best_low["best_value"]=="")){ echo 'style="display:none;"'; } ?> onmousedown="OpenPage('<?php echo "model/model.php?conf=".$best_low["best_value"]."&ex=".$exchcode.""; ?>',event);">Best Value</li>
								<li class="configOptions" id="best_performance_id" <?php if(!isset($best_low["best_performance"])||(isset($best_low["best_performance"])&&$best_low["best_performance"]=="")){ echo 'style="display:none;"'; } ?> onmousedown="OpenPage('<?php echo "model/model.php?conf=".$best_low["best_performance"]."&ex=".$exchcode.""; ?>',event);">Max Performance</li>
								<li class="configOptions" id="lowest_price_id" <?php if(!isset($best_low["lowest_price"])||(isset($best_low["lowest_price"])&&$best_low["lowest_price"]=="")){ echo 'style="display:none;"'; } ?> onmousedown="OpenPage('<?php echo "model/model.php?conf=".$best_low["lowest_price"]."&ex=".$exchcode.""; ?>',event);">Lowest Price</li>						
							</ul>
						</div><!-- End Configuration div-->	
					</div>
				</div>
			</div>
		</div>
		</div>
		</div>
	</div>
	<!-- start specs -->
	<div class="container bg-transparent modelContainer px-0">
		<div class="row no-gutters">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 d-flex">
					<h4>Technical Specification</h4>
					<div class="btn btn-md btn-outline-primary toggler compmod showDetailsButton ml-5" data-hide="all">
						<span class="showDetails"> Expand all specs</span>
						<span class="showLessDetails"> Collapse all specs</span>
						<span class="glyphicon glyphicon-menu-down fas fa-angle-down ml-2 detailsArrow"></span>
						<!-- We take great effort to assure component compatibility for each configuration. If you think we made a mistake, please contact us. -->
					</div>
				</div>
		</div>
	</div>
	<div class="container bg-white modelContainer pb-0">
		<div class="row accordion" id="specificationsAccordion">
			<!-- START FIRST HALF OF MODEL -->
			<!-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 specificationContainer"> -->
			<div id="firstCol" class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<!-- CPU -->
					<div class="specification-card">
						<div class="row modelwidht" id="title-1">
							<div class="col-md-12 titlucomp text-center bold-font">
							<div class="headerComponents">
								<div class="header-collapse" data-toggle="collapse" data-target="#collapse-1" aria-expanded="true" aria-controls="collapse-1">
									Processor
								</div>
							</div>
							</div>
						</div>
						<div id="collapse-1" class="collapse show specification-content" aria-labelledby="title-1">
							<div class="row modelwidht">	
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
									<div class="row detaliicomp">					
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="0" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-load="1" data-original-title="data-loading...">
												Model: <i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 col-7 rows"><?php show_cpu($modelcpu);?></div>							
									</div>
									<div class="row detaliicomp">					
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">Launch date:</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows" id="cpu_ldate"></div>					
									</div>	
									<div class="row hidecpu hideall detaliicomp" style="display:none">					
										<div class="col-md-5 col-xs-5 col-5 col-sm-5 col-lg-5 rows">
											<span class="toolinfo" data-toolid="1" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left"  data-original-title="data-loading...">
												Socket:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id="cpu_socket"></span>
										</div>
									</div>
									<div class="row hidecpu hideall detaliicomp" style="display:none">					
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="6" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Technology:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id="cpu_tech"></span> nm
										</div>							
									</div>	
									<div class="row hidecpu hideall detaliicomp" style="display:none">					
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="7" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Cache:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 co7-sm-7 col-lg-7 rows">
											<span id="cpu_cache"></span> MB
										</div>							
									</div>	
									<div class="row hidecpu hideall detaliicomp" style="display:none">					
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="2" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Base Speed:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id="cpu_speed"></span> GHz
										</div>										
									</div>
									<div class="row detaliicomp">					
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="4" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Max. Speed:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id="cpu_turbo"></span> GHz
										</div>							
									</div>	
									<div class="row hidecpu hideall detaliicomp" style="display:none">					
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="8" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												TDP:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id="cpu_tdp"></span> W
										</div>							
									</div>	
									<div class="row detaliicomp">					
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="3" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Nr. of cores:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id="cpu_cores"></span>
										</div>	
									</div>
									<div class="row hidecpu hideall detaliicomp" style="display:none">					
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">Miscellaneous:</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows" id="cpu_misc"></div>						
									</div>	
									<div class="row detaliicomp">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">Performance class:</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows" id="cpu_class"></div>
									</div>
									<div class="row detaliicomp">					
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="5" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Rating:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span class="labelblue-s" id="cpu_rating" ></span><span class="labelblue-s">/ 100</span>
										</div>							
									</div>	
									<div class="expandContainer">
										<a class="toggler" data-hide="cpu">
											<span class="more-specs-text">More Specs</span>
											<span class="glyphicon glyphicon-menu-down fas fa-angle-down ml-2 detailsArrow"></span>
										</a>					
									</div>
								</div>
							</div>	
						</div>
					</div>
					<!-- Video Card -->
					<div class="specification-card">
						<div class="row modelwidht" id="title-2">
							<div class="col-md-12 titlucomp text-center bold-font">
								<div class="headerComponents">
									<div class="header-collapse" data-toggle="collapse" data-target="#collapse-2" aria-expanded="true" aria-controls="collapse-2">
										Video card
									</div> 
								</div>
							</div>
						</div>
						<div id="collapse-2" class="collapse show specification-content" aria-labelledby="title-2">
							<div class="row modelwidht">				
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
									<div class="row detaliicomp">					
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="20" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Model:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows gpuhddd"><?php show_gpu($modelgpu); ?></div>							
									</div>	
									<div class="row hidegpu hideall detaliicomp" style="display:none">					
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="22" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Architecture:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id="gpu_arch"></span>
										</div>					
									</div>
									<div class="row hidegpu hideall detaliicomp" style="display:none">					
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="32" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Technology:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id="gpu_tech"></span> nm
										</div>
									</div>
									<div class="row hidegpu hideall detaliicomp" style="display:none">					
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="23" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Pipelines:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id="gpu_shaders"></span> pipelines
										</div>
									</div>
									<div class="row detaliicomp">					
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="21" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Core Speed:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id="gpu_speed"></span> MHz
										</div>		
									</div>	
									<div class="row hidegpu hideall detaliicomp" style="display:none">					
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="24" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Shader model:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id="gpu_shadermodel"></span>
										</div>		
									</div>						
									<div class="row detaliicomp" >					
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="25" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Memory speed:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id="gpu_memspeed"></span> MHz
										</div>
									</div>
									<div class="row hidegpu hideall detaliicomp" style="display:none">					
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="26" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Memory bus:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id="gpu_bus"></span> bit
										</div>
									</div>
									<div class="row detaliicomp">					
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="28" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Memory size:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id="gpu_mem"></span>
										</div>		
									</div>			
									<div class="row hidegpu hideall detaliicomp" style="display:none">					
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="27" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Shared memory:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id="gpu_smem"></span>
										</div>
									</div>
									<div class="row hidegpu hideall detaliicomp" style="display:none">					
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="29" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												TDP:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id="gpu_tdp"></span> W
										</div>
									</div>
									<div class="row hidegpu hideall detaliicomp" style="display:none">					
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">Miscellaneous:</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows" id="gpu_misc"></div>
									</div>
									<div class="row detaliicomp">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">Performance class:</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows" id="gpu_class"></div>		
									</div>	
									<div class="row detaliicomp">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="30" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Rating:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span class="labelblue-s" id="gpu_rating"></span><span class="labelblue-s"> / 100</span>
										</div>
									</div>		
									<div class="expandContainer">
										<a class="toggler" data-hide="gpu">
											<span class="more-specs-text">More Specs</span>
											<span class="glyphicon glyphicon-menu-down fas fa-angle-down ml-2 detailsArrow"></span>
										</a>					
									</div>
								</div>															
							</div>
						</div>
					</div>
					<!-- Display Mobile-->
					<div class="specification-card">
						<div class="row modelwidht" id="title-3">
							<div class="col-md-12 titlucomp text-center bold-font">
								<div class="headerComponents">
									<div class="header-collapse" data-toggle="collapse" data-target="#collapse-3" aria-expanded="true" aria-controls="collapse-3">
										Display
									</div>
								</div>
							</div>
						</div>
						<div id="collapse-3" class="collapse show specification-content" aria-labelledby="title-3">
							<div class="row modelwidht">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="row detaliicomp">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">Model:</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows"><?php show_display($modeldisplay); ?></div>					
									</div>
									<div class="row detaliicomp">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="43" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Size:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span class="display_size" id="display_size"></span> inch
										</div>
									</div>
									<div class="row hidedis hideall detaliicomp" style="display:none">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="44" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Format:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span class="display_format" id="display_format"></span>
										</div>
									</div>
									<div class="row detaliicomp">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="45" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Resolution:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span class="display_hres" id="display_hres"></span> x <span class="display_vres" id="display_vres"></span> pixels
										</div>
									</div>
									<div class="row hidedis hideall detaliicomp" style="display:none">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="46" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Surface type:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span class="display_surft" id="display_surft"></span>
										</div>
									</div>
									<div class="row detaliicomp">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="47" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Technology:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span class="display_backt" id="display_backt"></span>
										</div>
									</div>
									<div class="row detaliicomp">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">Touchscreen:</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows" class="display_touch" id="display_touch"></div>
									</div>
									<div class="row detaliicomp"> 
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">Miscellaneous:</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows" class="display_misc" id="display_misc"></div>
									</div>
									<div class="row hidedis hideall detaliicomp" style="display:none">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="48" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Rating:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span class="display_rating" id="display_rating"></span> / 100
										</div>
									</div>
									<div class="expandContainer">
										<a class="toggler" data-hide="dis">
											<span class="more-specs-text">More Specs</span>
											<span class="glyphicon glyphicon-menu-down fas fa-angle-down ml-2 detailsArrow"></span>
										</a>					
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- Storage -->
					<div class="specification-card">
						<div class="row modelwidht" id="title-4">
							<div class="col-md-12 titlucomp text-center bold-font">
								<div class="headerComponents">
									<div class="header-collapse" data-toggle="collapse" data-target="#collapse-4" aria-expanded="true" aria-controls="collapse-4">
										Storage
									</div>
								</div>
							</div>
							</div>
						<div id="collapse-4" class="collapse show specification-content" aria-labelledby="title-4">
							<div class="row modelwidht">						
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="row detaliicomp">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="50" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Model/Capacity:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows gpuhdd"><?php show_hdd($modelhdd); ?></div>
									</div>
									<div class="row hidesto hideall detaliicomp" style="display:none">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="49" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												RPM:
											</span>
											<i class="fa fa-question toolinfo-icon"></i>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id ="hdd_rpm"></span>
										</div>
									</div>
									<div class="row hidesto hideall detaliicomp" style="display:none">					
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="51" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Type:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id ="hdd_type"></span>
										</div>
									</div>
									<div class="row detaliicomp">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">Read Speed:</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows"><span id ="hdd_readspeed"></span> MB/s</div>
									</div>
									<div class="row hidesto hideall detaliicomp" style="display:none">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">Write Speed:</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows"><span id ="hdd_writes"></span> MB/s</div>
									</div>
									<div class="row hidesto hideall detaliicomp" style="display:none">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">Miscellaneous:</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows" id ="hdd_misc"></div>
									</div>
									<div class="expandContainer">
										<a class="toggler" data-hide="sto">
											<span class="more-specs-text">More Specs</span>
											<span class="glyphicon glyphicon-menu-down fas fa-angle-down ml-2 detailsArrow"></span>
										</a>					
									</div>
								</div>
							</div>
						</div>
					</div>
	<?php
					$shddtext=show_shdd($modelshdd); 
					if($shddtext)
					{ 
	?>	
						<!-- Secondary Storage (if exists) -->
					<div class="specification-card">	
						<div class="row modelwidht" id="title-5">					
							<div class="col-md-12 titlucomp text-center bold-font">
								<div class="headerComponents">
									<div class="header-collapse" data-toggle="collapse" data-target="#collapse-5" aria-expanded="true" aria-controls="collapse-5">
										Secondary Storage
									</div>
								</div>
							</div>
						</div>
						<div id="collapse-5" class="collapse show specification-content" aria-labelledby="title-5">
							<div class="row modelwidht">						
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="row detaliicomp">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="50" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Capacity:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows"><?php echo $shddtext; ?></div>
									</div>
									<div class="row hidesto1 hideall detaliicomp" style="display:none">	
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="49" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												RPM:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id ="shdd_rpm"></span>
										</div>
									</div>
									<div class="row hidesto1 hideall detaliicomp" style="display:none">						
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="51" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Type:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id ="shdd_type"></span>
										</div>
									</div>
									<div class="row hidesto1 hideall detaliicomp" style="display:none">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">Read Speed:</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows" ><span id ="shdd_readspeed"></span> MB/s</div>
									</div>
									<div class="row hidesto1 hideall detaliicomp" style="display:none">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">Write Speed:</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows" ><span id ="shdd_writes"></span> MB/s</div>
									</div>
									<div class="expandContainer">
										<a class="toggler" data-hide="sto1">
											<span class="more-specs-text">More Specs</span>
											<span class="glyphicon glyphicon-menu-down fas fa-angle-down ml-2 detailsArrow"></span>
										</a>					
									</div>
								</div>
							</div>
						</div>
					</div>	
	<?php			} ?>
					<!-- Motherboard -->	
					<div class="specification-card">	
						<div class="row modelwidht" id="title-6">	
							<div class="col-md-12 titlucomp text-center bold-font">
							<div class="headerComponents">
								<div class="header-collapse" data-toggle="collapse" data-target="#collapse-6" aria-expanded="true" aria-controls="collapse-6">
									Motherboard
								</div>
							</div>
							</div>
						</div>
						<div id="collapse-6" class="collapse specification-content hide-spec-in-mobile" aria-labelledby="title-6">
							<div class="row modelwidht">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="row detaliicomp">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="53" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Submodel:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows"><?php show_mdb($modelmdb); ?></div>
									</div>
									<div class="row detaliicomp">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="54" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Memory Slots:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id="mdb_ram"></span>
										</div>
									</div>
									<div class="row detaliicomp hideall hidemdb" style="display:none">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="52" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Video on board:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id="mdb_gpu"></span>
										</div>					
									</div>
									<div class="row detaliicomp">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="55" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Chipset:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id="mdb_chipset"></span>
										</div>
									</div>
									<div class="row hidemdb hideall detaliicomp" style="display:none">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="56" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Int. Interfaces:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id="mdb_interface"></span>
										</div>
									</div>
									<div class="row detaliicomp">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="58" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Network:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id="mdb_netw"></span>
										</div>
									</div>
									<div class="row hidemdb hideall detaliicomp" style="display:none">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="57" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												HDD Interfaces:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id="mdb_hdd"></span>
										</div>
									</div>
									<div class="row hidemdb hideall detaliicomp" style="display:none">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">Miscellaneous:</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows" id="mdb_misc"></div>
									</div>
									<div class="expandContainer">
										<a class="toggler" data-hide="mdb">
											<span class="more-specs-text">More Specs</span>
											<span class="glyphicon glyphicon-menu-down fas fa-angle-down ml-2 detailsArrow"></span>
										</a>					
									</div>
								</div>
							</div>
						</div>
					</div>
			</div>
			<!-- END FIRST HALF OF MODEL -->
			<!-- START SECOND HALF OF MODEL -->
			<div id="secondCol" class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="specification-card">
						<div class="row modelwidht" id="title-7">
							<div class="col-md-12 titlucomp text-center bold-font">
							<div class="headerComponents">
								<div class="header-collapse" data-toggle="collapse" data-target="#collapse-7" aria-expanded="true" aria-controls="collapse-7">
									Memory
								</div>
							</div>
							</div>
						</div>
						<div id="collapse-7" class="collapse show specification-content" aria-labelledby="title-7">
							<div class="row modelwidht">						
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="row detaliicomp">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="62" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Capacity:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows"><?php show_mem($modelmem); ?></div>
									</div>
									<div class="row hidemem hideall detaliicomp" style="display:none">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="61" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Standard:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id="mem_stan"></span>
										</div>
									</div>
									<div class="row detaliicomp">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="60" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Type:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id="mem_type"></span> - <span id="mem_freq"></span> MHz
										</div>
									</div>
									<div class="row hidemem hideall detaliicomp" style="display:none">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="63" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												CAS Latency :
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id="mem_lat"></span>
										</div>
									</div>
									<div class="row hidemem hideall detaliicomp" style="display:none">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">Miscellaneous:</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows" id="mem_misc"></div>
									</div>
									<div class="expandContainer">
										<a class="toggler" data-hide="mem">
											<span class="more-specs-text">More Specs</span>
											<span class="glyphicon glyphicon-menu-down fas fa-angle-down ml-2 detailsArrow"></span>
										</a>					
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--Optical Drive (if exists) -->		
					<div class="specification-card">
						<div class="row modelwidht" id="title-8">
							<div class="col-md-12 titlucomp text-center bold-font">
								<div class="headerComponents">
									<div class="header-collapse" data-toggle="collapse" data-target="#collapse-8" aria-expanded="true" aria-controls="collapse-8">
										Optical drive
									</div>
								</div>
							</div>
						</div>
						<div id="collapse-8" class="collapse show specification-content" aria-labelledby="title-8">
							<div class="row modelwidht">					
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="row detaliicomp">					
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="65" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Type:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
												<?php $showodd=show_odd($modelodd); ?>
											</span>
										</div>
									</div>
			<?php					if($showodd) 
									{ ?>
										<div class="row hideodd hideall detaliicomp" style="display:none">
											<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
												<span class="toolinfo" data-toolid="66" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
													Speed:
													<i class="fa fa-question toolinfo-icon"></i>
												</span>
											</div>
											<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
												<span class="odd_speed" id="odd_speed"></span>X
											</div>
										</div>					
										<div class="row hideodd hideall detaliicomp" style="display:none">
											<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">Miscellaneous:</div>
											<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows odd_misc" id="odd_misc"></div>
										</div>
										<div class="expandContainer">
											<a class="toggler" data-hide="odd">
												<span class="more-specs-text">More Specs</span>
												<span class="glyphicon glyphicon-menu-down fas fa-angle-down ml-2 detailsArrow"></span>
											</a>					
										</div>
			<?php					} ?>
								</div>			
							</div>
						</div>
					</div>	
					<!-- Battery -->	
					<div class="specification-card">
						<div class="row modelwidht" id="title-9">
							<div class="col-md-12 titlucomp text-center bold-font">
								<div class="headerComponents">
									<div class="header-collapse" data-toggle="collapse" data-target="#collapse-9" aria-expanded="true" aria-controls="collapse-9">
										Battery
									</div>
								</div>
							</div>
						</div>
						<div id="collapse-9" class="collapse specification-content hide-spec-in-mobile" aria-labelledby="title-9">
							<div class="row modelwidht">					
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="row detaliicomp">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="67" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Capacity:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows"><?php show_acum($modelacum); ?></div>
									</div>
									<div class="row detaliicomp">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">Cell Number:</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows acum_cell" id="acum_cell"></div>
									</div>
									<div class="row hideacu hideall detaliicomp" style="display:none">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">Cell Type:</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows acum_tipc" id="acum_tipc"></div>
									</div>
									<div class="row hideacu hideall detaliicomp" style="display:none">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">Voltage:</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows acum_volt"><span id="acum_volt"></span></div>
									</div>	
									<div class="row hideacu hideall detaliicomp" style="display:none">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">Weight:</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows acum_weight"><span id="acum_weight"></span><span id="acum_weight_i"></span></div>
									</div>
									<div class="row hideacu hideall detaliicomp" style="display:none">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">Miscellaneous:</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows acum_misc" id="acum_misc"></div>
									</div>
									<div class="expandContainer">
										<a class="toggler" data-hide="acu">
											<span class="more-specs-text">More Specs</span>
											<span class="glyphicon glyphicon-menu-down fas fa-angle-down ml-2 detailsArrow"></span>
										</a>					
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- Chassis -->	
					<div class="specification-card">
						<div class="row modelwidht" id="title-10">
								<div class="col-md-12 titlucomp text-center bold-font">
									<div class="headerComponents">
										<div class="header-collapse" data-toggle="collapse" data-target="#collapse-10" aria-expanded="true" aria-controls="collapse-10">
											Chassis
										</div>
									</div>
								</div>
							</div>
						<div id="collapse-10" class="collapse show specification-content" aria-labelledby="title-10">
							<div class="row modelwidht">					
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<?php
								$chassistext=show_chassis($modelchassis);
								if($chassistext && (strcasecmp($chassistext,"standard")!=0))
								{ ?>
									<div class="row hidecha hideall detaliicomp" style="display:none">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">Type:</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows"><?php echo $chassistext; ?></div>
									</div>				
			<?php				 } ?>									
									<div class="row detaliicomp">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="70" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Peripheral Interfaces:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id="chassis_pi"></span>
										</div>
									</div>
									<div class="row hidecha hideall detaliicomp" style="display:none">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="77" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Video Interfaces:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id="chassis_vi"></span>
										</div>
									</div>
									<div class="row hidecha hideall detaliicomp" style="display:none">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="76" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Webcam:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id="chassis_web"></span>
										</div>
									</div>
									<div class="row hidecha hideall detaliicomp" style="display:none">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">Touchpad:</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows" id="chassis_touch"></div>
									</div>
									<div class="row hidecha hideall detaliicomp" style="display:none">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">Keyboard:</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows" id="chassis_keyboard"></div>
									</div>
									<div class="row hidecha hideall detaliicomp" style="display:none">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">Charger:</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows"><span id="chassis_charger"></span></div>
									</div>				
									<div class="row detaliicomp">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="84" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-load="1" data-original-title="data-loading...">
												Weight:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id="chassis_weight"></span> Kg (<span id="chassis_weight_i"></span> lb)
										</div>
									</div>
									<div class="row detaliicomp">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="85" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-load="1" data-original-title="data-loading...">
												Thickness:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id="chassis_thic"></span> cm (<span id="chassis_thic_i"></span>")
										</div>
									</div>
									<div class="row detaliicomp">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">Depth:</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows"><span id="chassis_depth"></span> cm (<span id="chassis_depth_i"></span>")</div>
									</div>
									<div class="row detaliicomp">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">Width:</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows"><span id="chassis_width"></span> cm (<span id="chassis_width_i"></span>")</div>
									</div>
									<div class="row hidecha hideall detaliicomp" style="display:none">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">Colors:</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows" id="chassis_color"></div>
									</div>
									<div class="row hidecha hideall detaliicomp" style="display:none">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">Material:</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows" id="chassis_material"></div>
									</div>
									<div class="row hidecha hideall detaliicomp" style="display:none">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">Miscellaneous:</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows" id="chassis_misc"></div>
									</div>
									<div class="expandContainer">
										<a class="toggler" data-hide="cha">
										<span class="more-specs-text">More Specs</span>
										<span class="glyphicon glyphicon-menu-down fas fa-angle-down ml-2 detailsArrow"></span>
									</a>					
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- Wireless card -->	
					<div class="specification-card">
						<div class="row modelwidht" id="title-11">
							<div class="col-md-12 titlucomp text-center bold-font">
							<div class="headerComponents">
								<div class="header-collapse" data-toggle="collapse" data-target="#collapse-11" aria-expanded="true" aria-controls="collapse-11">
									Wireless card
								</div>
							</div>
							</div>
						</div>
						<div id="collapse-11" class="collapse specification-content hide-spec-in-mobile" aria-labelledby="title-11">
							<div class="row modelwidht">				
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="row detaliicomp">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">Model:</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows"><?php show_wnet($modelwnet); ?></div>
									</div>
									<div class="row detaliicomp">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">Slot:</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows"><span id="wnet_slot"></span></div>
									</div>					
									<div class="row hidewnet hideall detaliicomp" style="display:none">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="72" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Speed:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id="wnet_speed"></span>
										</div>
									</div>
									<div class="row detaliicomp">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="73" data-load="1" data-html="true" data-toggle="tooltip1" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Standard:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id="wnet_stand"></span>
										</div>
									</div>
									<div class="row hidewnet hideall detaliicomp" style="display:none">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">Miscellaneous:</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows" id="wnet_misc"></div>
									</div>
									<div class="expandContainer">
										<a class="toggler" data-hide="wnet">
											<span class="more-specs-text">More Specs</span>
											<span class="glyphicon glyphicon-menu-down fas fa-angle-down ml-2 detailsArrow"></span>
										</a>					
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- Warranty -->		
					<div class="specification-card">	
						<div class="row modelwidht" id="title-12">
							<div class="col-md-12 titlucomp text-center bold-font">
								<div class="headerComponents">
									<div class="header-collapse" data-toggle="collapse" data-target="#collapse-12" aria-expanded="true" aria-controls="collapse-12">
										Warranty
									</div>
								</div>
							</div>
						</div>
						<div id="collapse-12" class="collapse specification-content hide-spec-in-mobile" aria-labelledby="title-12">
							<div class="row modelwidht">					
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="row detaliicomp">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">Years:</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows"><?php show_war($modelwar); ?></div>					
									</div>
									<div class="row detaliicomp">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="74" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												Miscellaneous:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows">
											<span id="war_misc"></span>
										</div>
									</div>
								</div>				
							</div>
						</div>
					</div>
					<!-- Operating System -->
					<div class="specification-card">	
						<div class="row modelwidht" id="title-13">
							<div class="col-md-12 titlucomp text-center bold-font">
							<div class="headerComponents">
								<div class="header-collapse" data-toggle="collapse" data-target="#collapse-13" aria-expanded="true" aria-controls="collapse-13">
									Operating System
								</div>
							</div>
							</div>
						</div>
						<div id="collapse-13" class="collapse specification-content hide-spec-in-mobile" aria-labelledby="title-13">
							<div class="row modelwidht">					
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="row detaliicomp">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows">
											<span class="toolinfo" data-toolid="75" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 600, "hide": 400}' data-placement="left" data-original-title="data-loading...">
												System:
												<i class="fa fa-question toolinfo-icon"></i>
											</span>
										</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows"><?php show_sist($modelsist); ?></div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- Miscellaneous -->
	<?php
					$msctext=show_msc($idmodel); 
					if($msctext)
					{ ?>
					<div class="specification-card">	
						<div class="row modelwidht" id="title-13">
							<div class="col-md-12 titlucomp text-center bold-font">
								<div class="headerComponents">
									<div class="header-collapse" data-toggle="collapse" data-target="#collapse-14" aria-expanded="true" aria-controls="collapse-14">
										Miscellaneous
									</div>
								</div>
							</div>
						</div>
						<div id="collapse-14" class="collapse show specification-content hide-spec-in-mobile" aria-labelledby="title-14">
							<div class="row modelwidht">					
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="row detaliicomp">
										<div class="col-md-5 col-xs-5 col-sm-5 col-lg-5 col-5 rows" data-placement="left" title="data-loading...">About:</div>
										<div class="col-md-7 col-xs-7 col-7 col-sm-7 col-lg-7 rows"><span><?php if(isset($msctext["p_model"]["com"])&&$msctext["p_model"]["com"]!=NULL) { echo $msctext["p_model"]["com"]." "; } if(isset($msctext["p_model"]["src"])&&$msctext["p_model"]["src"]!=NULL) { $src_msc_parts=array(); $src_msc_parts=explode(" ",$msctext["p_model"]["src"]); $k=0; foreach($src_msc_parts as $val){$k++; echo "<a target='_blank' href='".$val."'>[".$k."]</a>"; } } ?></span><span id="model_msc"><?php echo $msctext["model_msc"]; ?></span></div>
									</div>
								</div>
							</div>
						</div>
					</div>
	<?php 		} ?>
				
			</div> 
			<!-- END SECOND HALF OF MODEL -->
		</div>
		
		<!-- end specs -->
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 px-0">
				<div class="disclaimer-container">
					<p class="disclaimernb"><span class="font-weight-bold">Disclaimer.</span> We can not guarantee that the information on this page is 100% correct. <a href="<?php echo $web_address; ?>?footer/contact.php">Submit correction.</a></p>
				</div>
			</div>
		</div>
			<span style="color:#FFFFFF; position:fixed; top:-100; left:0; max-width:500px; display:hidden;" id="hiddenDiv" class="hiddenDiv"></span>
<?php
	include("lib/php/db_reviews.php");
?>
</div>

<!-- external reviews div-->
<div class="container bg-transparent modelContainer reviewsContainer px-0">
	<div class="row no-gutters">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 d-md-flex ListTitle">
				<h4><?php if(!($nr_int_reviews+$nr_nb_reviews)) {echo "No ";} ?>Reviews</h4>
				<div class="ml-md-5">Do you have an intresting review?</div>
				<div class="ml-md-3">
					<a onclick="OpenPage('public/ireviews.php?model_id=<?php echo $p_model; ?>',event);" class="btn btn-md btn-primary d-block" id="gototop">
						<span class="align-middle">Add review</span>
					</a>
				</div>
			</div>
	</div>
</div>
<?php 
	if(($nr_int_reviews+$nr_nb_reviews)>0)
	{
		?>
	
	<div class="container bg-white modelContainer reviewsListContainer">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ListBox">
				<ul class="list-group ListElem">
				<?php foreach(array_merge($nb_reviews, $int_reviews) as $el)
					{ ?>	
					<li class="list-group-item border-top-0 border-right-0 border-left-0">
					<a style="cursor: pointer;" class="d-flex justify-content-between align-items-center" 
					<?php if($el["notebreview"]==1) { ?> onmousedown="OpenPage('<?php echo $el["link"]; ?>',event);"> <?php }
					else { ?> href="<?php echo $el["link"]; ?>" target="blank"> <?php } ?>
					<?php
						if($el["notebreview"]==1)
						{ ?> <img class="review-image" src="model/lib/images/review-noteb.svg" alt="Noteb Review" /> <?php }
						else
						{
							if(intval($el["video"])==1)
							{ ?> <img class="review-image" src="model/lib/images/review-video.svg" alt="Video Review" /> <?php  }
							else
							{ ?> <img class="review-image" src="model/lib/images/review-write.svg" alt="Write Review" /> <?php } ?>
					<?php } ?>
						<div class="container">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 d-md-flex justify-content-between align-items-center">
									<h5 class="bold-font"><?php echo $el["site"]; ?></h5>
									<span class="btn btn-md btn-outline-primary">
										<?php if(intval($el["video"])==1)
										{ ?> Watch Video <?php }
										else
										{ ?> Read More <?php }?>
									</span>
								</div>
							</div>
						</div>
						</a>
					</li>
				<?php } ?>
				</ul>
			</div>		
		</div>
		</div>
<?php } ?>
</div>
	<!-- REVIEWS -->

	<!-- COMMENTS -->
	<div id="disqus_thread" style="margin-left: 10px;"></div>
	<div id="leave_comment"></div>
	<!-- BANNER -->
	<!-- <div class="container bg-transparent modelContainer banner">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<img src="https://dummyimage.com/970x250/cccccc/cccccc/" alt="Mock" />
			</div>
		</div>
	</div> -->
	<!-- GALLERY MODAL -->
	<div class="modal fade galleryModal" id="galleryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close fa fa-times" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
				<i class="fas fa-chevron-left imgControl prevImage"></i>
				<i class="fas fa-chevron-right imgControl nextImage"></i>
				</div>
			</div>
		</div>
	</div>
	<!-- NOTOFICATIONS MODAL -->
	<div class="modal fade notificationsModal" id="notificationsModal" tabindex="-1" role="dialog" aria-labelledby="notificationsModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<div class="notification-message"></div>
					<button type="button" class="btn btn-outline-primary btn-md" data-dismiss="modal" aria-label="Close">OK</button>
				</div>
			</div>
		</div>
	</div>
<script>
<?php include("lib/php/genjsmodel.php"); ?>
$.getScript("model/lib/js/model.js",function(){$.getScript("lib/js/owl.carousel.min.js",function(){ getScripts(["model/lib/js/model_post.js","model/lib/js/sim_model.js"],function(){});});});
</script>
<?php  
} } ?>
</div>
<link rel="stylesheet" href="model/lib/css/model.css?v=97" type="text/css"/>
<link rel="stylesheet" href="lib/css/owl.carousel.min.css" type="text/css"/>
<link rel="stylesheet" href="lib/css/owl.theme.default.min.css" type="text/css"/>
<?php include_once("../etc/scripts_pages.php"); ?>
