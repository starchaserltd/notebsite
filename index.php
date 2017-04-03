<?php 
require_once("etc/session.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Noteb</title>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="World largest notebook and laptop information hub.">
	<meta name="keywords" content="find,cheap,best,laptop,notebook,gaming,ultraportable,business">
	<meta name="author" content="Starchaser">

	<!-- JavaScript libraries -->   
	<script type="text/javascript" src="lib/js/jquery.min.js"></script> 		
	<script type="text/javascript" src="lib/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="lib/js/select2.min.js"></script>
	<!-- Bootstrap Mutliselect JavaScript -->
	<script type="text/javascript" src="lib/js/bootstrap-multiselect.js"></script>
	<script type="text/javascript" src="lib/js/nouislider.min.js"></script>
</head>
<body>
<div class="container-fluid headerback" style="height:100%;">
	<div class="row" style="height:100%;">
	<!-- upper buttons desktop -->
		<div class="col-md-10 col-xs-12 col-sm-12" style="padding:0px; float:left; position:relative;">
			<div class="btn-group-justified btn-group siteMenu">
				<a class="btn btn-sus logonb"  onmousedown="OpenPage('content/home.php',event);">HOME</a>
				<a class="btn btn-sus advsearch" >SEARCH</a>
				<a class="btn btn-sus" onmousedown="OpenPage('content/articles.php',event);">ARTICLES</a>
				<a class="btn btn-sus" onmousedown="OpenPage('content/reviews.php',event);">REVIEWS</a>
				
			
		
		
				
			</div>
		</div>		
		<!-- right area -->
		<div class="col-md-2 col-sm-6 socialButton"><!-- min-height:134px;-->
		<!-- social buttons -->
		
			<div class="col-xs-3 col-md-12 col-md-12 col-lg-12" style="padding:0px;">
			
			<div class="btn-group" role="group">
			<button type="button" class="btn btn-sus dropdown-toggle" style="width:inherit;margin-left:-1px;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			  <span class="socicon-sharethis"></span>
			  <span class="caret"></span>
			</button>
			<div class="dropdown-menu">
				  <div class="shareText" style="margin:5px;">
				  Share page on...
				  </div>
				  <div style="margin:5px;">			
					  <a class="btn btn-block btn-social btn-facebook" onclick="_gaq.push(['_trackEvent', 'btn-social', 'click', 'btn-facebook']); " id="sharefb" href="">
					<span class="socicon socicon-facebook sheight"></span> Facebook
					  </a>
				  </div>
				  <div style="margin:5px;">
					 <a class="btn btn-block btn-social btn-twitter" onclick="_gaq.push(['_trackEvent', 'btn-social', 'click', 'btn-twitter']);" id="sharetw" href="">
					<span class="socicon socicon-twitter sheight"></span> Twitter
					 </a>
				  </div>
				  <div style="margin:5px;">
					 <a class="btn btn-block btn-social btn-google" onclick="_gaq.push(['_trackEvent', 'btn-social', 'click', 'btn-google']);" id="sharegp" href="">
					<span class="socicon socicon-google-plus sheight"></span> Google
					 </a>
				  </div>
				   <div style="margin:5px;">
					<a class="btn btn-block btn-social btn-reddit" onclick="_gaq.push(['_trackEvent', 'btn-social', 'click', 'btn-reddit']);" id="sharerd" href="">
					<span class="socicon socicon-reddit sheight"></span> Reddit
					</a>
				  </div>
			</div>
			</div>
			
			</div>
			
			
		<!-- end social buttons -->
		</div>
		
				
		<!-- end div middle -->
		<!-- end right area -->
		<!-- left area -->	
		<div class="col-md-2 col-xs-12 col-sm-12 firstContainer" style="padding:0px; float:left; position:relative;">
		
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
					<select class="modelsearch js-example-responsive" id="model_id" name ="model_id" data-placeholder="Find a laptop model" data-initvalue="search for a model"  style="width: 100%; margin:5px 0px 10px 0px; border-radius:1px;"> 
					</select>
				</form>
			</div>
			<!-- end left menu-->
			<!-- simple search -->
			<button class="visible-xs btn btn-search" style="font-size:14px!important; font-weight:bold" data-toggle="collapse" data-target="#SearchParameters">Quick Search</button>
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