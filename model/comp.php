<?php
require_once("../etc/conf.php");
if (!isset($_SERVER['HTTP_REFERER']) || stripos($_SERVER['HTTP_REFERER'], $site_name) == FALSE)
{
	$actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	header("Location: " . $port_type . "://" . str_replace($site_name . "/", $site_name . "/?", $actual_link) . "");
	die();
}
require_once("lib/php/headercomp.php");

if ($nrconf < 1 && $nrgetconfs < 1) // nrconf is from headercomp.php
{
?>
	<div class="col-md-8 col-md-offset-2" style="border:1px solid #ddd; background-color:#f6f6f6;">
		<?php
		echo "<br><b>Here you can compare two or more laptop configurations.</b><br><br>";
		echo "To do this, search for the desired model/configuration using this website's search functionalities and then add it to the compare list. <br> You can view your current list of saved configurations in the lower-right corner of your browser.";
		echo '<br><br><span style="color:#BF1A1A;text-align:center; font-weight:bold;">Currently you have ' . ($nrconf + 1) . ' configuration';
		if (($nrconf + 1) != 1) { echo "s"; }
		echo ' in your list.<br>Or maybe the laptop configurations you are trying to compare no longer exist.</span><br><br>';
		?>
	</div>
<?php
}
else 
{
?>
	<link rel="stylesheet" href="model/lib/css/compare.css?v=30" type="text/css" />
	<?php include_once("../libnb/php/aff_modal.php"); ?>

	<div id="tableRoot" class="compare__container linked"></div>

	<script>
		$.getScript("model/lib/js/gencomp.php")
			.done(function() {
				$.getScript("model/lib/js/comp.js")
			});
	</script>

<?php } ?>
<?php include_once("../etc/scripts_pages.php"); ?>