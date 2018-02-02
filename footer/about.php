<?php
require_once("../etc/conf.php");
if (!isset($_SERVER['HTTP_REFERER']) || stripos($_SERVER['HTTP_REFERER'],$site_name) ==FALSE) 
{	$actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	header("Location: ".$port_type."://".str_replace($site_name."/",$site_name."/?",$actual_link)."");
	die();
}
?>
	<div style="margin-top:50px; margin-left: 20px; margin-right: 40px;">
	<p style="font-size:18px"><b>A bit about Noteb:</b></p>
		 	<p>
	 Noteb is a project that first started in 2010 with the purpose of providing an internet gateway to the laptop world.<br> In 2014 work started on the current website.
	 There are still many features that we hope to implement, provided we get enough visitors to make it count.</p>
	 <p>The core values of Noteb is functionality over everything else. We want this website to be useful and really help people in getting the laptop that best fits their needs and budget. 
	 <br><br>If by any chance you find something that you believe needs improvement, like a missing laptop configuration or a new search feature, please let us know. Well-grounded feedback will always reach our development team.</p>
	 <br><br>
	 <p style="font-size:18px"><b>Frequent questions:</b></p>
	 
	 <p><b>Where can I buy the laptop I found on your website?</b></p>
	 <p>Firstly, we do not sell laptops, we only help you find the right laptop. Best advice is to search for that exact configuration either directly on the producer's website or at on-line shops. We also provide on each notebook page a quick Google/Bing/Amazon search option for buying that exact configuration. We would love to provide direct purchase links from various suppliers but unfortunately this is not currently possible.
	 Also, be advised that configurations vary from country to country and across different regions. Although rare, the same laptop model may sell with different components across different countries or it may not be available at all.</p>

	 	 <p><b>Where do we get our information?</b></p>
	 <p>In takes care and effort in gathering the most complete and accurate information for every laptop model. Most of the information is sourced from the official documentation provided by laptop manufacturers. When the documentation is incomplete or not entirely reliable we do our own research both on-line and off-line. We hope that in the future we will be able to open up the database and make it more like a "wikipedia" for laptops.</p>
	 
	 	 <p><b>How do you estimate prices?</b></p>
Prices are sourced from producer websites, Amazon and other price comparison websites. However, due to the fact that some laptops can have millions of possible configurations, it is impossible to collect market prices for each of them. Consequently, for many models we extrapolate the prices based on the data we constantly collect and update.<br>We can confidently say that 95% of all our prices are within a 7% margin of error compared to what is available on the market, with a very few exception (under 5% of laptops) prices can be off by almost 15%.
Large price differences are almost always due to changes in producer price policies which we have yet to update or changes in technical specifications.
<br>
If you do notice a large price difference please <a href="https://<?php echo $site_name;?>?footer/contact.php">contact us</a> and we will make the necessary adjustments. <br> <br>
		  	 <p><b>What is the Noteb Rating?</b></p>
			Noteb rating evaluates the capabilities of a laptop against other laptops on the market and it is very useful when comparing different laptop models. Our rating evaluates the characteristic of every laptop component currently available on the market on scale from 1 to 100, where 100 is the best available on the market and 1 is the worse.
			No laptop can achieve a rating of 100% simply because in a laptop everything is a trade-off. For instance, a high performance processors will necessarily sacrifice portability and battery life. Still there are laptops with low performance and poor battery life, which get a low rating from Noteb and there are laptops which provide good performance and very good battery life which get a much higher rating. 
			Be advised that a higher rating will most certainly imply a higher price.
 <br><br>
			 <p><b>How do you estimate a laptop's battery life?</b></p>
	 Depending on components and software characteristics we can estimate how much power a laptop will need on battery and since we know the size of the battery, we can estimate how fast the battery will be drained. However, actual battery life may vary wildly depending on usage: a laptop will last a very long time on battery when browsing the internet or writing documents, but will get drained really fast when running 3D games.<br>
Our estimate is for normal usage with simple tasks, like watching movies, browsing the internet or doing office work.	 
			<br><br>
			<p><b>Your search does not give me any results?</b></p>
			There are two likely reasons: <br>
				1. You are searching for a laptop with non-existing characteristics, like a laptop with dual video cards and 10 hours of battery life.<br>
				2. The characteristics you are searching for exist but they do not fit your budget.<br>
				<br>
			Our advice is to adjust the price range and start your search with a more relaxed set of characteristics and make them progressively more restrictive.
			<br><br>
			<p><b>Privacy and cookie policy</b></p>
			Noteb.com does not collect or store any type of personal data nor does it use tracking cookies. We are firm believers that our users are our customers not our product.
	 </div>
	 </div>
	 <script type="text/javascript">
	 $(document).ready(function(){
	  actbtn("HOME");
	 });
	 </script> 