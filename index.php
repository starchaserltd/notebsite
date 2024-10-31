<?php
require_once("etc/session.php");
require_once("etc/conf.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Noteb</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- <script data-ad-client="ca-pub-6919058555572408" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> -->
	<meta name="description" content="Looking for a laptop? Search, Compare or even take a Quiz with Noteb.com to find the perfect laptop for your work, home or suggest one to your friends from over 3.000.000 configurations derived from over 900 models.">
	<meta name="keywords" content="find,cheap,best,laptop,notebook,gaming,ultraportable,business">
	<meta name="author" content="Starchaser">
	<!-- CSS Libraries we want to load before everthing else -->
	<link rel="stylesheet" href="lib/css/bootstrap.min.css" crossorigin="anonymous">
	<link rel="stylesheet" href="lib/css/bootstrap-icons.min.css" type="text/css" />
	<!-- JavaScript libraries -->
	<script src="lib/js/jquery.min.js"></script>
	<script src="lib/js/popper.min.js"></script>
	<script src="lib/js/bootstrap.min.js"></script>
	<script src="lib/js/select2.min.js"></script>
	<script src="lib/js/classList.min.js"></script>
	<!-- Bootstrap Mutliselect JavaScript -->
	<script src="lib/js/bootstrap-multiselect.min.js"></script>
	<script src="lib/js/nouislider.min.js"></script>
	<!-- Lightbox js -->
	<script src="lib/js/lightbox.min.js"></script>
	<script src="lib/js/slick.min.js"></script>
	<?php echo "<script>var excode='";
	if (isset($_SESSION['exchcode'])) {
		echo $_SESSION['exchcode'];
	} else {
		echo "USD";
	}
	echo "';</script>"; ?>
	<style>
	</style>
</head>

<body>
	<?php require_once("libnb/php/nb_closing.php"); ?>
	<!-- upper buttons desktop -->
	<div class="container-fluid containerNavigation">
		<div class="navigation container">
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12" style="padding:0px; float:left; position:relative;">
					<div class="btn-group-justified btn-group siteMenu d-flex justify-content-around">
						<h1 class="btn blue logonb lognb menuItems" onmousedown="OpenPage('content/home.php',event);">Looking for a laptop? Search, compare or use our quiz to find the laptop for you with Noteb search engine.</h1>
						<!-- <a class="btn btn-sus blue menuItems" onmousedown="OpenPage('search/adv_search.php',event);">Search</a> -->
						<div class="col-md-12 col-xs-12 cod-sm-12 col-lg-12 searchDetailsFirstContainer">
							<i class="fas fa-search d-lg-none d-sm-inline-block d-md-none d-inline-block searcButtonMobile"></i>
							<form action="javascript:void(0);" method="post" id="modelfind" class="d-lg-block d-sm-none d-md-block d-none">
								<a class="" style="cursor: pointer;" onmousedown="OpenPage('search/adv_search.php',event); scrolltoid('content',1);">
									<img class="controlSvg" src="../res/img/controls.svg" alt="Adv search ctrl">
								</a>
								<select class="modelsearch js-example-responsive" id="model_id" name="model_id" data-placeholder="Search a laptop model" data-initvalue="search for a model" style="width: 100%; margin:5px 0px 10px 0px; border-radius:1px;">
								</select>
							</form>
						</div>
						<a class="btn btn-sus blue menuItems" onmousedown="OpenPage('content/articles.php',event);">Articles</a>
						<a class="btn btn-sus blue menuItems" onmousedown="OpenPage('content/reviews.php',event);">Reviews</a>
						<div class="d-md-block d-none menuItems last" style="padding:0px;">
							<div id="usermenu" class="btn-group dropdown">
								<button class="dropbtn helpus"><span>Tools</span></button>
								<div class="dropdown-content">
									<a class="addrev" onmousedown="OpenPage('public/ireviews.php',event);">Add laptop review</a>
									<a class="addrev" onmousedown="OpenPage('public/api.php',event);">API</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-2 col-lg-2 col-sm-2 col-xs-12" style="padding:0px">
					<!-- min-height:134px;-->

				</div>
			</div>
			<!-- right area -->
		</div>
	</div>
	<div class="socialArea container-fluid">
		<div class="container">
			<div class="row">
				<div class="col-12 col-sm-12 col-md-6 cssmenu"><a style="color:#1D94DA" onmousedown="OpenPage('content/brands.php',event); scrolltoid('content',1);"><span class="browseButton d-lg-inline-block d-md-inline-block d-sm-none d-none col-3" style="font-weight: bold;">Browse laptops</span></a>
					<ul class="browseLaptopClass">
						<li class='has-sub'><a>By brand</a>
							<ul>
								<li><a onmousedown="OpenPage('search/search.php?prod=HP&browse_by=prod',event); scrolltoid('content',1);">HP</a></li>
								<li><a onmousedown="OpenPage('search/search.php?prod=Lenovo&browse_by=prod',event); scrolltoid('content',1);">Lenovo</a></li>
								<li><a onmousedown="OpenPage('search/search.php?prod=Dell&browse_by=prod',event); scrolltoid('content',1);">Dell</a></li>
								<li><a onmousedown="OpenPage('search/search.php?prod=Apple&browse_by=prod',event); scrolltoid('content',1);">Apple</a></li>
								<li><a onmousedown="OpenPage('search/search.php?prod=Asus&browse_by=prod',event); scrolltoid('content',1);">Asus</a></li>
								<li><a onmousedown="OpenPage('search/search.php?prod=Acer&browse_by=prod',event); scrolltoid('content',1);">Acer</a></li>
								<li><a onmousedown="OpenPage('search/search.php?prod=Samsung&browse_by=prod',event); scrolltoid('content',1);">Samsung</a></li>
								<li><a onmousedown="OpenPage('content/brands.php',event); scrolltoid('content',1);">Other brands</a></li>
							</ul>
						</li>
					</ul>
					<ul class="browseLaptopClass">
						<li class='has-sub'><a>By class</a>
							<ul>
								<li><a onmousedown="OpenPage('search/search.php?browse_by=budget',event); scrolltoid('content',1);">Budget</a></li>
								<li><a onmousedown="OpenPage('search/search.php?browse_by=mainstream',event); scrolltoid('content',1);">Mainstream</a></li>
								<li><a onmousedown="OpenPage('search/search.php?browse_by=ultraportable',event); scrolltoid('content',1);">Ultraportable</a></li>
								<li><a onmousedown="OpenPage('search/search.php?browse_by=business',event); scrolltoid('content',1);">Business</a></li>
								<li><a onmousedown="OpenPage('search/search.php?browse_by=gaming',event); scrolltoid('content',1);">Gaming</a></li>
								<li><a onmousedown="OpenPage('search/search.php?browse_by=professional',event); scrolltoid('content',1);">CAD/3D modeling</a></li>
							</ul>
						</li>
					</ul>
					<ul class="browseLaptopClass">
						<li class='has-sub'><a>By screen size</a>
							<ul>
								<li><a onmousedown="OpenPage('search/search.php?browse_by=smalldisplay',event); scrolltoid('content',1);">10" - 13.9"</a></li>
								<li><a onmousedown="OpenPage('search/search.php?browse_by=mediumdisplay',event); scrolltoid('content',1);">14" - 16.9" </a></li>
								<li><a onmousedown="OpenPage('search/search.php?browse_by=largedisplay',event); scrolltoid('content',1);">17" - 21" </a></li>
							</ul>
						</li>
					</ul>
					<ul class="d-lg-none d-sm-block d-md-none d-bloc">
						<li class='has-sub'><a id="browse_menu">Browse laptops</a>
							<ul class="browseMobile">
								<li class='has-sub'><a>By brand</a>
									<ul>
										<li><a onmousedown="OpenPage('search/search.php?prod=HP&browse_by=prod',event); scrolltoid('content',0);">HP</a></li>
										<li><a onmousedown="OpenPage('search/search.php?prod=Lenovo&browse_by=prod',event); scrolltoid('content',0);">Lenovo</a></li>
										<li><a onmousedown="OpenPage('search/search.php?prod=Dell&browse_by=prod',event); scrolltoid('content',0);">Dell</a></li>
										<li><a onmousedown="OpenPage('search/search.php?prod=Apple&browse_by=prod',event); scrolltoid('content',0);">Apple</a></li>
										<li><a onmousedown="OpenPage('search/search.php?prod=Asus&browse_by=prod',event); scrolltoid('content',0);">Asus</a></li>
										<li><a onmousedown="OpenPage('search/search.php?prod=Acer&browse_by=prod',event); scrolltoid('content',0);">Acer</a></li>
										<li><a onmousedown="OpenPage('search/search.php?prod=Samsung&browse_by=prod',event); scrolltoid('content',0);">Samsung</a></li>
										<li><a style="color:#1D94DA" onmousedown="OpenPage('content/brands.php',event); scrolltoid('content',0);">Other brands</a></li>
									</ul>
								</li>
								<li class='has-sub'><a>By class</a>
									<ul>
										<li><a onmousedown="OpenPage('search/search.php?browse_by=budget',event); scrolltoid('content',0);">Budget</a></li>
										<li><a onmousedown="OpenPage('search/search.php?browse_by=mainstream',event); scrolltoid('content',0);">Mainstream</a></li>
										<li><a onmousedown="OpenPage('search/search.php?browse_by=ultraportable',event); scrolltoid('content',0);">Ultraportable</a></li>
										<li><a onmousedown="OpenPage('search/search.php?browse_by=business',event); scrolltoid('content',0);">Business</a></li>
										<li><a onmousedown="OpenPage('search/search.php?browse_by=gaming',event); scrolltoid('content',0);">Gaming</a></li>
										<li><a onmousedown="OpenPage('search/search.php?browse_by=professional',event); scrolltoid('content',0);">CAD/3D modeling</a></li>
									</ul>
								</li>
								<li class='has-sub'><a>By screen size</a>
									<ul>
										<li><a onmousedown="OpenPage('search/search.php?browse_by=smalldisplay',event); scrolltoid('content',0);">10" - 13.9"</a></li>
										<li><a onmousedown="OpenPage('search/search.php?browse_by=mediumdisplay',event); scrolltoid('content',0);">14" - 16.9" </a></li>
										<li><a onmousedown="OpenPage('search/search.php?browse_by=largedisplay',event); scrolltoid('content',0);">17" - 21" </a></li>
									</ul>
								</li>
							</ul>
						</li>
					</ul>
				</div>
				<div class="socialButtons col-12 col-sm-12 col-md-6">
					<span class="support">Support Us:</span>
					<a onclick="scrolltoid('supportUs',0);"><span class="donate">Donate</span></a>
					<span class="faInfo"><a style="cursor:pointer;color: #fff;" onmousedown="OpenPage('footer/howto.php',event);"><i class="fas fa-info"></i><span class="faTutorial"> Tutorial</span></a></span>
					<span class="faSocial"><a style="cursor:pointer;color: #fff;" href="https://www.youtube.com/notebcom"><i class="fab fa-youtube"></i></a></span>
					<span class="faSocial"><a style="cursor:pointer;color: #fff;" href="https://www.facebook.com/Noteb-162949570886382/"><i class="fab fa-facebook-f"></i></a></span>
					<span class="faSocial"><a style="cursor:pointer;color: #fff;" href="https://twitter.com/notebcom"><i class="fab fa-twitter"></i></a></span>
					<span class="faSocial"><a style="cursor:pointer;color: #fff;" href="https://www.instagram.com/notebcom/"><i class="fab fa-instagram"></i></a></span>
					<span class="faSocial"><a style="cursor:pointer;color: #fff;" href="https://discord.com/invite/aXqPsz4"><i class="fab fa-discord"></i></a></span>
				</div>
			</div>
		</div>
	</div>
	<div class="container headerback">
		<div class="row containerContentIndex">

			<!-- left area -->
			<script src="libnb/js/compjsf.js"></script><!-- compare list functions -->
			<div class="col-lg-3 col-md-4 col-xs-12 col-sm-12 firstContainer presearch-modal-anchor">
				<div class="row">
					<nav class="navbar-collapse d-block">
						<div style="cursor:pointer; padding:0px;" class="col-md-12 col-xs-12 col-sm-12 searchMenu">
							<h3 id="presearch-header">Search for your laptop</h3>
						</div>
						<div class="quickSearchContainer">
							<!-- <button class="btn btn-title leftMenuFilters" onclick=""><span style="color:white;">Quick search</span></button> -->
							<div class="SearchParameters" id="SearchParameters" style="display: block;">
								<?php include("search/s_search.php"); ?>
							</div>
							<div style="text-align:center;" class="advancedSearchBtn">
								<button id="sadvsearch" onmousedown="OpenPage('search/adv_search.php',event); scrolltoid('content',0);" type="button" class="btn  leftMenuAdvSearch"><span style="text-decoration:none;color:white;">Advanced search</span></button>
							</div>
						</div>

						<div class="col-md-12 col-xs-12 col-sm-12 cssmenu compareDropdown" style="padding:0px">
							<ul>
								<li class='has-sub'><a style="color: #fff;">Compare</a>
									<ul style="background-color: white;">
										<li class="comparelistContainer">
											<table class="table" id="comparelist" style="margin-bottom:2px;">
												<tbody>
													<!-- GENERATING COMPARE LIST FROM SESSION -->
													<?php include("libnb/php/complist.php"); ?>
												</tbody>
												<tfoot>
													<tr id="toptrcomp">
														<td colspan="1" style="text-align:center; background:#FFF; font-weight:600"></td>
														<td></td>
														<td></td>
														<td></td>
													</tr>
												</tfoot>
											</table>
										</li>
									</ul>
								</li>
							</ul>
						</div>
					</nav>
					<!-- end left menu-->
				</div>
			</div>

			<!-- end left area-->

			<!-- main content -->
			<div class="col-md-8 col-sm-12 col-xs-12 col-lg-9 mainContentDiv" id="content">
				Loading main content.... Please wait.<br>
				This website requires modern browsers, it will not work on IE 9.0 or earlier.
			</div>
			<!-- loading animation -->
			<div class="col-md-8 offset-md-4 col-sm-12 col-xs-12 loadingdiv col-lg-9 offset-lg-3" id="loadingNB">
				<div class="loadingdivsec" id="loadingNoteB">
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
			<span id="back-to-top">
				<a href="#top" style="color:#fff; text-decoration:none; z-index: 99;" onclick="$('html,body').animate({scrollTop:0},'slow');return false;">
					<i class="glyphicon glyphicon-chevron-up fas fa-angle-up"></i><span class="backTop">Back to Top</span>
				</a>
			</span><!-- /top-link-block -->
			<div class="howToUse" id="howToUse">
				<span class="glyphicon glyphicon-remove fas fa-times" aria-hidden="true"></span>
				<p><span class="tutorialClick hiddenMobile" onclick="OpenPage('footer/howto.php',event);">If you are new to Noteb.com <span>click here</span> for a short tutorial.</span><span class="tutorialClick displayMobile" onclick="OpenPage('footer/howto.php',event);">How to use Noteb.</span></p>
			</div>
			<!-- end main content -->
			<!--left promotional space-->
			<div class="col-md-2 hidden-xs hidden-sm" style="float: right; position: relative">
				<!-- <img src="someimage.png" class="img-responsive"> -->
			</div>
			<!-- end left promotional space-->
			<!-- NOTOFICATIONS MODAL -->
			<div class="modal fade notificationsModal" id="notificationsModal" tabindex="-1" role="dialog" aria-labelledby="notificationsModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- footer-->
	<?php include("footer/footer.php"); ?>
	<!-- end footer-->

	<!-- CSS FOR INDEX -->
	<link rel="stylesheet" href="lib/fonts/fontawesome/css/all.min.css" crossorigin="anonymous">
	<link rel="stylesheet" href="lib/css/select2.min.css" type="text/css" />
	<link rel="stylesheet" href="lib/css/bootstrap-multiselect.min.css" type="text/css" />
	<!-- for multiselect forms -->
	<link rel="stylesheet" href="lib/css/extra-fonts.css" type="text/css" />
	<!-- menu fonts -->
	<link rel="stylesheet" href="lib/css/socicon.min.css" type="text/css" />
	<link rel="stylesheet" href="lib/css/bootstrap-social.css" type="text/css" />
	<!-- socicon, bootstrap social - css for social media-->
	<link rel="stylesheet" href="lib/css/nouislider.min.css" type="text/css" />
	<!--custom OK	-->
	<link rel="stylesheet" href="libnb/css/responsive.css" type="text/css" />
	<link rel="stylesheet" href="libnb/css/loading.css" type="text/css" />
	<!--Lightbox css	-->
	<link rel="stylesheet" href="lib/css/lightbox.min.css" type="text/css" />
	<!--SLick slider css	-->
	<link rel="stylesheet" href="lib/css/slick.min.css" type="text/css" />
	<link rel="stylesheet" href="lib/css/slick-theme.min.css" type="text/css" />
	<!--custom css	-->
	<link rel="stylesheet" href="libnb/css/nb.css" type="text/css" />
	<!-- Custom Theme JavaScript -->
	<script>
		<?php echo 'var siteroot = "' . $web_address . '";'; ?>
	</script>
	<script src="libnb/js/tooltip.js"></script>
	<script src="libnb/js/affil.js"></script>
	<script src="libnb/js/index.js"></script>
	<script src="libnb/js/notifications-modal.js"></script>
	<script src="libnb/js/presearch.js"></script>
	<script src="search/ui/js/search_data.js"></script>
</body>

</html>