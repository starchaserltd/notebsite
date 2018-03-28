<?php
require_once("etc/session.php");
require_once("etc/conf.php");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Noteb</title>
		<meta charset="utf-8"/>	
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Looking for a laptop? Search, Compare or even take a Quiz with Noteb.com to find the perfect laptop for your work, home or suggest one to your friends from over 6.000.000 configurations derived from over 900 models.">
		<meta name="keywords" content="find,cheap,best,laptop,notebook,gaming,ultraportable,business">
		<meta name="author" content="Starchaser">	
		<!-- JavaScript libraries -->   
		<script type="text/javascript" src="lib/js/jquery.min.js"></script> 		
		<script type="text/javascript" src="lib/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="lib/js/select2.min.js"></script>
		<script type="text/javascript" src="lib/js/classList.min.js"></script>
		<!-- Bootstrap Mutliselect JavaScript -->
		<script type="text/javascript" src="lib/js/bootstrap-multiselect.js"></script>
		<script type="text/javascript" src="lib/js/nouislider.min.js"></script>
		<!-- Lightbox js -->
		<script src="lib/js/lightbox.min.js"></script> 
		<style>
			btn.active.focus,.btn.active:focus, .btn.focus, .btn:active.focus, .btn:active:focus, .btn:focus
			 {outline: none!important;outline-offset:initial!important}
		</style>
	</head>
	<body>
	<div class="container-fluid headerback" style="height:100%;">
		<div class="row containerContentIndex" style="height:100%;">
			<!-- upper buttons desktop -->
			<div class="navigation">	
				<div class="col-md-10 col-xs-12 col-sm-12" style="padding:0px; float:left; position:relative;">
					<div class="btn-group-justified btn-group siteMenu">
						<h1 class="btn blue logonb lognb"  onmousedown="OpenPage('content/home.php',event);">Looking for a laptop? Search, compare or use our quiz to find the laptop for you with Noteb search engine.</h1>
						<a class="btn btn-sus blue advsearch" >SEARCH</a>
						<a class="btn btn-sus blue" onmousedown="OpenPage('content/articles.php',event);">ARTICLES</a>
						<a class="btn btn-sus blue" onmousedown="OpenPage('content/reviews.php',event);">REVIEWS</a>
					</div>
				</div>		
				<!-- right area -->
				<div class="col-md-2 col-lg-2" style="padding:0px"><!-- min-height:134px;-->
					<div class="hidden-sm hidden-xs col-md-12 col-lg-12" style="padding:0px;">			
						<div id="usermenu" class="btn-group dropdown">
							<button disabled class="blue dropbtn helpus"><span class="helpimg">Review</span></button>
							<div class="dropdown-content">
								<a class="addrev" onmousedown="OpenPage('public/ireviews.php',event);">Add laptop review</a>
								<a class="addrev" onmousedown="OpenPage('public/api.php',event);">API</a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- left area -->	
			<script type="text/javascript" src="libnb/js/compjsf.js" ></script><!-- compare list functions -->		
			<div class="col-md-2 col-xs-12 col-sm-12 firstContainer">		
				<div class="col-md-12 col-xs-12 cod-sm-12 col-lg-12 searchDetailsFirstContainer" style="padding:5px">
						<form action="javascript:void(0);" method="post" id="modelfind" style="text-align: -webkit-center;">		
							<select class="modelsearch js-example-responsive" id="model_id" name ="model_id" data-placeholder="Search a laptop model" data-initvalue="search for a model"  style="width: 100%; margin:5px 0px 10px 0px; border-radius:1px;"> 
							</select>
						</form>
				</div>
				<!-- left area -->
				
				<!-- simple search -->		
				<div class="clearfix"></div>
				<div class="navbar-header">
					<span class="navbar-brand">Menu</span>
					<button type="button" class="navbar-toggle navbarToggleMenu">
						  <span class="sr-only">Menu</span>
						  <span class="icon-bar"></span>
						  <span class="icon-bar"></span>
						  <span class="icon-bar"></span>			      
					</button>
				</div>
				<nav class="navbar-collapse" role="navigation">	
					<div class="col-md-12 col-xs-12 col-sm-12 blue cssmenu" style="padding:0px">
						<ul >
						   <li  class='has-sub'><a >Browse laptops</a>
								<ul>
									<li class='has-sub'><a >By brand</a>
										<ul>
											<li><a  onmousedown="OpenPage('search/search.php?prod=HP&browse_by=prod',event); scrolltoid('content');">HP</a></li>
											<li><a  onmousedown="OpenPage('search/search.php?prod=Lenovo&browse_by=prod',event); scrolltoid('content');">Lenovo</a></li>
											<li><a  onmousedown="OpenPage('search/search.php?prod=Dell&browse_by=prod',event); scrolltoid('content');">Dell</a></li>
											<li><a  onmousedown="OpenPage('search/search.php?prod=Apple&browse_by=prod',event); scrolltoid('content');">Apple</a></li>
											<li><a  onmousedown="OpenPage('search/search.php?prod=Asus&browse_by=prod',event); scrolltoid('content');">Asus</a></li>
											<li><a  onmousedown="OpenPage('search/search.php?prod=Acer&browse_by=prod',event); scrolltoid('content');">Acer</a></li>
											<li><a  onmousedown="OpenPage('search/search.php?prod=Samsung&browse_by=prod',event); scrolltoid('content');">Samsung</a></li>
											<li><a  style="color:#1D94DA" onmousedown="OpenPage('content/brands.php',event); scrolltoid('content');">Other brands</a></li>
										</ul>
									</li>	
									<li class='has-sub'><a >By class</a>
										<ul>
											<li><a  onmousedown="OpenPage('search/search.php?browse_by=budget',event); scrolltoid('content');">Budget</a></li>
											<li><a  onmousedown="OpenPage('search/search.php?browse_by=mainstream',event); scrolltoid('content');">Mainstream</a></li>
											<li><a  onmousedown="OpenPage('search/search.php?browse_by=ultraportable',event); scrolltoid('content');">Ultraportable</a></li>
											<li><a  onmousedown="OpenPage('search/search.php?browse_by=business',event); scrolltoid('content');">Business</a></li>
											<li><a  onmousedown="OpenPage('search/search.php?browse_by=gaming',event); scrolltoid('content');">Gaming</a></li>
											<li><a  onmousedown="OpenPage('search/search.php?browse_by=professional',event); scrolltoid('content');">CAD/3D modeling</a></li>
										</ul>
									</li>		
									<li class='has-sub'><a >By screen size</a>
										<ul>
											<li><a  onmousedown="OpenPage('search/search.php?browse_by=smalldisplay',event); scrolltoid('content');">10" - 13.9"</a></li>
											<li><a  onmousedown="OpenPage('search/search.php?browse_by=mediumdisplay',event); scrolltoid('content');">14" - 16.9" </a></li>
											<li><a  onmousedown="OpenPage('search/search.php?browse_by=largedisplay',event); scrolltoid('content');">17" - 21" </a></li>
										</ul>
									</li>				
								</ul>
							</li>	
						</ul>
					</div>		
						
					<div>
						<button class="btn btn-title leftMenuFilters"  onclick=""><span style="color:white;">Quick search</span></button>
						<div class="SearchParameters" id="SearchParameters" style="display: none;">			
							<?php include ("search/s_search.php");?>
						</div>			
					</div>	
					<div style="text-align:center;">
					 <button  id="sadvsearch" onmousedown="OpenPage('search/adv_search.php',event);" type="button" class="btn blue leftMenuAdvSearch"><span style="text-decoration:none;color:white;">Advanced search</span></button>
					 </div>					
					<div class="col-md-12 col-xs-12 col-sm-12 blue cssmenu compareDropdown" style="padding:0px">
						<ul>				
							<li class='has-sub'><a >Compare</a>
								<ul style="background-color: white;">
									<li>
										<table class="table" id="comparelist" style="margin-bottom:2px;">
											<tbody>
												<tr id="toptrcomp"><td colspan="1" style="text-align:center; background:#FFF; font-weight:600"></td></tr>
												<!-- GENERATING COMPARE LIST FROM SESSION -->
												<?php include("libnb/php/complist.php"); ?>
											</tbody>
										</table>
									</li>
								</ul>								
							</li>
						</ul>
					</div>	
				</nav>
				<!-- end left menu--> 	
			</div>
			<!-- end left area-->
			
			<!-- main content -->
			<div class="col-md-8 col-sm-12 col-xs-12 container" style="border-left:1px solid #ddd;padding:3px;" id="content">
				Loading main content.... Please wait.<br>
				This website requires modern browsers, it will not work on IE 9.0 or earlier.	
			</div>
			<!-- loading animation -->
			<div class="col-md-8 col-md-offset-2 col-sm-12 col-xs-12 loadingdiv" id="loadingNB">
				<div class="loadingdivsec"  id="loadingNoteB">
					<div id="loadingNoteB_1" class="loadingNoteB"></div>
					<div id="loadingNoteB_2" class="loadingNoteB"></div>
					<div id="loadingNoteB_3" class="loadingNoteB"></div>
					<div id="loadingNoteB_4" class="loadingNoteB"></div>
					<div id="loadingNoteB_5" class="loadingNoteB"></div>
					<div id="loadingNoteB_6" class="loadingNoteB"></div>
					<div id="loadingNoteB_7" class="loadingNoteB"></div>
					<div id="loadingNoteB_8" class="loadingNoteB"></div>
				</div>
			</div>
			<!-- Back to Top Button -->
			<span id="top-link-block" class="hidden">
				<a href="#top" style="color:#fff; text-decoration:none;" onclick="$('html,body').animate({scrollTop:0},'slow');return false;">
					<i class="glyphicon glyphicon-chevron-up"></i><span class="backTop">Back to Top</span>
				</a>
			</span><!-- /top-link-block -->
			<!-- end main content -->
			<!--left promotional space-->
			<div class="col-md-2 hidden-xs hidden-sm" style="float: right; position: relative"><!-- <img src="someimage.png" class="img-responsive"> --></div>
		<!-- end left promotional space-->
		</div>
	</div>
		<!-- footer-->
		<?php include ("footer/footer.php");?>
		<!-- end footer-->
			
		<!-- CSS FOR INDEX -->
		<link rel="stylesheet" href="lib/css/bootstrap.min.css" type="text/css" />
		<link rel="stylesheet" href="lib/css/bootstrap-theme.min.css" type="text/css" />
		<link rel="stylesheet" href="lib/css/select2.min.css" type="text/css" /> 
		<link rel="stylesheet" href="lib/css/bootstrap-multiselect.css" type="text/css" />
		<!-- for multiselect forms -->  
		<link rel="stylesheet" href="lib/css/extra-fonts.css" type="text/css" />
		<!-- menu fonts -->
		<link rel="stylesheet" href="lib/css/socicon.min.css" type="text/css" />
		<link rel="stylesheet" href="lib/css/bootstrap-social.css" type="text/css" />
		<!-- socicon, bootstrap social - css for social media-->
		<link rel="stylesheet" href="lib/css/nouislider.min.css" type="text/css"/>
		<link rel="stylesheet" href="lib/css/nouislider.min.css" type="text/css" />
		<link rel="stylesheet" href="libnb/css/nb.css" type="text/css" />
		<!--custom OK	-->
		<link rel="stylesheet" href="libnb/css/responsive.css" type="text/css" />
		<link rel="stylesheet" href="libnb/css/loading.css" type="text/css" />	
		<!--Lightbox css	-->
		<link rel="stylesheet" href="lib/css/lightbox.min.css" type="text/css"/>

		<!-- Custom Theme JavaScript -->
		<script><?php echo 'var siteroot = "'.$web_address.'";'; ?></script>
		<script type="text/javascript" src="libnb/js/tooltip.js" async></script>
		<script type="text/javascript" src="libnb/js/index.js"></script>
		<script type="text/javascript" src="lib/js/nouislider.min.js"></script>	
	</body>
</html>