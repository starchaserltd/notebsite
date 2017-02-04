<?php 
require_once("etc/session.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Noteb.com</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="World largest notebook and laptop information hub.">
	<meta name="author" content="Starchaser">

	<!-- JavaScript libraries -->   
	<script type="text/javascript" src="lib/js/jquery.min.js"></script> 		
	<script type="text/javascript" src="lib/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="lib/js/select2.min.js"></script>
	<!-- Bootstrap Mutliselect JavaScript -->
	<script type="text/javascript" src="lib/js/bootstrap-multiselect.js"></script>
	<script type="text/javascript" src="lib/js/nouislider.min.js"></script>
</head>
<body class="container-fluid headerback" style="height:100%;">
	<div class="row" style="height:100%;">
	<!-- upper buttons desktop -->
		<div class="col-md-10 hidden-xs col-sm-12" style="padding:0px; float:left; position:relative;">
			<div class="btn-group-justified btn-group">
				<a class="btn btn-sus" onmousedown="OpenPage('content/home.php',event);">HOME</a>
				<a class="btn btn-sus advsearch" >SEARCH</a>
				<a class="btn btn-sus" onmousedown="OpenPage('content/articles.php',event);">ARTICLES</a>
				<a class="btn btn-sus" onmousedown="OpenPage('content/reviews.php',event);">REVIEWS</a>
			</div>
		</div>
		<!-- upper buttons mobile-->
		<div class="hidden-md col-xs-12 hidden-sm hidden-lg" style="padding:0px; float:left; position:relative;">
			<div class="btn-group-justified btn-group">
				<a class="btn btn-sus" style="padding:0px;" onmousedown="OpenPage('content/home.php',event);">NOTEB</a>
				<a class="btn btn-sus advsearch">SEARCH</a>
				<a class="btn btn-sus" onmousedown="OpenPage('content/articles.php',event);">ARTICLES</a>
				<a class="btn btn-sus" onmousedown="OpenPage('content/reviews.php',event);">REVIEWS</a>
			</div>
		</div>
		<!-- right area -->
		<div class="col-md-2 hidden-xs col-sm-6" style="float:right; position:relative; padding-top:10px;<!-- min-height:134px;-->"> 
		<!-- social buttons -->
			<div class="col-md-12 hidden-sm" style="padding:0px 0px 10px 0px;">
				<b>Share this:</b><br>
				<a class="btn btn-social-icon sheight btn-sm btn-facebook" id="sharefb" href=""><i class="socicon socicon-facebook"></i></a>
				<a class="btn btn-social-icon btn-sm btn-twitter sheight" id="sharetw" href=""><i class="socicon socicon-twitter"></i></a>
				<a class="btn btn-social-icon btn-sm btn-google sheight" id="sharegp" href=""><i class="socicon socicon-google-plus"></i></a>
				<a class="btn btn-social-icon btn-sm btn-reddit sheight" href=""><i class="socicon socicon-reddit"></i></a>
			</div>	
		<!-- end social buttons -->
		</div>
		<!-- div for medium resolutions with logo and social buttons-->
		<div class="hidden-md hidden-lg hidden-xs col-sm-12 ">
			<div class="col-sm-6" style="text-align:center"><a style="text-decoration:none" onmousedown="OpenPage('content/home.php',event);"><span style="font-weight:bold;font-size:20px;color:#000;">NOTEB</span></a></div>		
			<div class="col-sm-6 hidden-md hidden-lg hidden-xs" style="padding:10px 0px 10px 0px; text-align:center">
				<a class="btn btn-social-icon btn-sm btn-facebook sheight" href=""><i class="socicon socicon-facebook"></i></a>
				<a class="btn btn-social-icon btn-sm btn-twitter sheight" href=""><i class="socicon socicon-twitter"></i></a>
				<a class="btn btn-social-icon btn-sm btn-google sheight" href=""><i class="socicon socicon-google-plus"></i></a>
				<a class="btn btn-social-icon btn-sm btn-reddit sheight" href=""><i class="socicon socicon-reddit"></i></a>
			</div>
		</div>			
		<!-- end div middle -->
		<!-- end right area -->
		<!-- left area -->	
		<div class="col-md-2 col-xs-12 col-sm-12" style="padding:0px; float:left; position:relative;">
		<!-- div logo-->
			<div class="col-md-12 hidden-xs hidden-sm" style="padding: -30px -30px -30px -30px;text-align:center;">
				<img onmousedown="OpenPage('content/home.php',event);" src="res/img/logo/logo.png" alt="Noteb" style="width:45%; height: 45%; cursor: pointer;">
			</div>
		<!-- div end logo-->
		<!-- left area -->
		<script type="text/javascript" src="libnb/js/compjsf.js" ></script><!-- compare list functions -->
			<div class="col-md-12 col-xs-12 col-sm-12" id='cssmenu' style="padding:0px">
				<ul>
				   <li class='has-sub'><a >Browse models</a>
						<ul>
							<li class='has-sub'><a >By brand</a>
								<ul>
									<li><a  onmousedown="OpenPage('search/search.php?prod=Lenovo&browse_by=prod',event); scrolltoid('content');">Lenovo</a></li>
									<li><a  onmousedown="OpenPage('search/search.php?prod=HP&browse_by=prod',event); scrolltoid('content');">HP</a></li>
									<li><a  onmousedown="OpenPage('search/search.php?prod=Dell&browse_by=prod',event); scrolltoid('content');">Dell</a></li>
									<li><a  onmousedown="OpenPage('search/search.php?prod=Asus&browse_by=prod',event); scrolltoid('content');">Asus</a></li>
									<li><a  onmousedown="OpenPage('search/search.php?prod=Apple&browse_by=prod',event); scrolltoid('content');">Apple</a></li>
									<li><a  onmousedown="OpenPage('search/search.php?prod=Acer&browse_by=prod',event); scrolltoid('content');">Acer</a></li>
									<li><a  onmousedown="OpenPage('search/search.php?prod=Samsung&browse_by=prod',event); scrolltoid('content');">Samsung</a></li>
									<li><a  style="color:#1D94DA" onmousedown="OpenPage('content/brands.php',event); scrolltoid('content');">Other brands</a></li>
								</ul>
							</li>	
							<li class='has-sub'><a >By class</a>
								<ul>
									<li><a  onmousedown="OpenPage('search/search.php?browse_by=mainstream',event); scrolltoid('content');">Mainstream</a></li>
									<li><a  onmousedown="OpenPage('search/search.php?browse_by=ultraportable',event); scrolltoid('content');">Ultraportable</a></li>
									<li><a  onmousedown="OpenPage('search/search.php?browse_by=gaming',event); scrolltoid('content');">Gaming</a></li>
									<li><a  onmousedown="OpenPage('search/search.php?browse_by=professional',event); scrolltoid('content');">Professional</a></li>
								</ul>
							</li>		
							<li class='has-sub'><a >By screen size</a>
								<ul>
									<li><a  onmousedown="OpenPage('search/search.php?browse_by=smalldisplay',event); scrolltoid('content');">10"" - 13.9""</a></li>
									<li><a  onmousedown="OpenPage('search/search.php?browse_by=mediumdisplay',event); scrolltoid('content');">14"" - 17"" </a></li>
									<li><a  onmousedown="OpenPage('search/search.php?browse_by=largedisplay',event); scrolltoid('content');">17.1"" - 18.5"" </a></li>
								</ul>
							</li>				
						</ul>
					</li>					
					<li class='has-sub'><a >Compare</a>
						<ul>
							<li>
								<table class="table" id="comparelist" style="margin-bottom:0px;">
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
			<div class="col-md-12 col-xs-12 cod-sm-12 col-lg-12" style="padding:5px">
				<form action="javascript:void(0);" method="post" id="modelfind" style="text-align: -webkit-center;">		
					<select class="modelsearch js-example-responsive" id="model_id" name ="model_id" data-placeholder="Find a laptop model" data-initvalue="search for a model"  style="width: 80%; margin:5px 0px 10px 0px;"> 
					</select>
					<button type="submit" id="modelfind_btn" class="btn-result" style="border-radius:3px;font-size:inherit;height:29px; padding:2px 7px 2px 7px">
						<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
					</button>
				</form>
			</div>
			<!-- end left menu-->
			<!-- simple search -->
			<button class="visible-xs btn btn-search" data-toggle="collapse" data-target="#SearchParameters">Quick Search</button>
			<div class="hidden-xs SearchParameters" id="SearchParameters">
				<?php include ("search/s_search.php");?>
			</div>
			<!-- end simple search -->	
		</div>
		<!-- end left area-->
		<!-- main content -->
		<div class="col-md-8 col-sm-12 col-xs-12 container" style="padding:3px;border-left:1px solid #ddd;" id="content">
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
		<!-- end main content -->
		<!--left promotional space-->
		<div class="col-md-2 hidden-xs hidden-sm" style="float: right; position: relative">
			<!-- <img src="someimage.png" class="img-responsive"> -->
		</div>
		<!-- end left promotional space-->
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
	<link rel="stylesheet" href="libnb/css/nb.css" type="text/css" />
	<!--custom OK	-->
	<link rel="stylesheet" href="libnb/css/responsive.css" type="text/css" />
	<link rel="stylesheet" href="libnb/css/loading.css" type="text/css" />	

	<!-- Custom Theme JavaScript -->
	<script><?php echo 'var siteroot = "'.$web_address.'";'; ?></script>
	<script type="text/javascript" src="libnb/js/tooltip.js" async></script>
	<script type="text/javascript" src="libnb/js/index.js"></script>
</body>
</html>