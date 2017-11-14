
<?php
require_once("../../etc/conf.php");
$rootpath = realpath($_SERVER["DOCUMENT_ROOT"]).$root_mod;
require_once("../../etc/con_db.php");
?>
<link rel="stylesheet" href="../../lib/css/bootstrap.min.css" type="text/css" />
<link rel="stylesheet" href="../../libnb/css/loading.css" type="text/css" />
<link rel="stylesheet" href="quiz.css" type="text/css"/>
<div class="row containerNquiz">
<div class="opacity"></div>
<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0">
<div class="quiz_container">
	<?php include ("quiz.php");?>
</div>
</div>
<script type="text/javascript" src="../../lib/js/jquery.min.js"></script>
<script type="text/javascript" src="../../libnb/js/tooltip.js" async></script>
<script type="text/javascript" src="../quiz/classList.min.js"></script>
<script type="text/javascript" src="../../libnb/js/index.js"></script>
<script><?php echo 'var siteroot = "'.$web_address.'";'; ?></script>
</div>