<?php
require_once("../../etc/conf.php");
$rootpath = realpath($_SERVER["DOCUMENT_ROOT"]).$root_mod;
require_once("../../etc/con_db.php");
$quiz_css_addr="";
?>
<head>
	<script><?php echo 'var siteroot = "'.$web_address.'";'; ?> var locationPath = location.pathname;</script>
	<script type="text/javascript" src="../../lib/js/jquery.min.js"></script>
	<link rel="stylesheet" href="../../lib/css/bootstrap.min.css" crossorigin="anonymous">
	<link rel="stylesheet" href="../../lib/fonts/fontawesome/css/all.min.css" crossorigin="anonymous">
	<link rel="stylesheet" href="../../libnb/css/loading.css" type="text/css" />
	<link rel="stylesheet" href="lib/css/quiz.css?v=0.5" type="text/css"/>
</head>
<body>
	<div class="row containerNquiz">
		<div class="opacity"></div>
		<div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-sm-12 offset-sm-0">
			<div class="quiz_container">
				<?php include ("quiz.php");?>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript" src="lib/js/nquiz.js"></script>
<script type="text/javascript" src="../../lib/js/classList.min.js"></script>
<?php include_once("../etc/scripts_pages.php"); ?>