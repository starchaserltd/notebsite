<?php
require_once("../etc/conf.php");
if (!isset($_SERVER['HTTP_REFERER']) || stripos($_SERVER['HTTP_REFERER'],$site_name) ==FALSE) 
{	$actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	header("Location: ".$port_type."://".str_replace($site_name."/",$site_name."/?",$actual_link)."");
	die();
}
?>
	<div style="margin-top:50px; margin-left: 20px; margin-right: 40px;">
	<p style="font-size:18px"><b> Noteb.com is a laptop search engine that helps you find the right laptop for you.</b><span style="font-size:16px"><br>Noteb.com does not directly sell laptops, but it recommends places where you can buy a laptop from.</span></p>
	<br>
	<p style="font-size:16px"><b>There are 5 types of search:</b></p>
	<p class="howtop" onclick="$('html,body').animate({scrollTop:0},'slow'); close_quick_search(); close_browse(); OpenPage('search/adv_search.php',event); return false;"><b>Full Search</b><br>
	<img src="../res/img/howto/adv_search.PNG" width="833" height="300">
	</p>
	<p class="howtop" onclick="$('html,body').animate({scrollTop:0},'slow'); close_browse(); if(document.getElementById('SearchParameters').style.display=='none') { $('.SearchParameters').toggle('slow'); $('.leftMenuFilters').toggleClass('rotate'); } return false;"><b>Quick Search</b><br>
	<img src="../res/img/howto/quick_search.png" width="328" height="300">
	</p>
	<p class="howtop" onclick="$('html,body').animate({scrollTop:0},'slow'); close_quick_search(); close_browse();  OpenPage('content/home.php',event); return false;"><b>Quiz Search</b><br>
	<img src="../res/img/howto/quiz_search.png" width="507" height="250">
	</p>
	<p class="howtop" onclick="$('html,body').animate({scrollTop:0},'slow'); close_quick_search(); close_browse(); return false;"><b>Model Search</b><br>
	<img src="../res/img/howto/model_search.PNG" width="265" height="200">
	</p>
	<p class="howtop" onclick="$('html,body').animate({scrollTop:0},'slow'); close_quick_search(); if(($('li.open')[0])==undefined) { document.getElementById('browse_menu').click(); } return false;"><b>Browse</b><br>
	<img src="../res/img/howto/browse_search.png" width="450" height="250">
	</p>
	<br>
	<p><b>How do use the budget range?</b></p>
	Prices are sourced from producer websites, Amazon and other similar websites. Sometimes there can be slight differences between the price on noteb.com and prices found in shops, especially during discount season or when a laptop model is being phased out of production. For this reason, we recommend to search within a slightly larger budget range than your desired target, eg. search for $750 - $870 when your target budget is $800.
	<br><br>
	<p><b>What is the Noteb Rating?</b></p>
	Our rating evaluates the characteristic of every laptop component currently available on the market on scale from 1 to 100, where 100 is the best available on the market and 1 is the worse.
	<br>
	This rating can be very useful when comparing laptop processors or laptop video card. For these components a higher rating means better performance.
	<br><br>
	No laptop can achieve a rating of 100% simply because in a laptop everything is a trade-off. For instance, a high performance processors will necessarily sacrifice portability and battery life. Still there are laptops with low performance and poor battery life, which get a low rating from Noteb and there are laptops which provide good performance and very good battery life which get a much higher rating. 
	Be advised that a higher rating will most certainly imply a higher price.
	<br><br>
	<p><b>How do we estimate a laptop's battery life?</b></p>
	Actual battery life may vary wildly depending on usage: a laptop will last a very long time on battery when browsing the internet or writing documents, but will get drained really fast when running 3D games.<br>
	Our estimate is for normal usage with simple tasks, like watching movies, browsing the internet or doing office work, while keeping the display still decently lit (200 nit).
	<br><br>		
	 </div>
	 <script type="text/javascript">
	 $(document).ready(function(){
	  actbtn("HOME");
	 });
	 
	 function close_quick_search(){ if(document.getElementById("SearchParameters").style.display!="none") { $('.SearchParameters').toggle('slow'); $('.leftMenuFilters').toggleClass('rotate'); } }
	 function close_browse(){ if(($("li.open")[0])!=undefined) { document.getElementById('browse_menu').click(); } }
	 
	 </script>
	 <link rel="stylesheet" href="footer/lib/css/footer.css?v=1" type="text/css"/>
	 <?php include_once("../etc/scripts_pages.php"); ?>