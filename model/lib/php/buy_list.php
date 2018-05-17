<?php
	require("../../../etc/con_db.php");
	function intsanitize($somestring)
	{
		$somestring=explode(",",filter_var($somestring, FILTER_SANITIZE_STRING));
		foreach($somestring as $key=>$el){ $somestring[$key]=intval($el); }
		return implode(",",$somestring);
	}
	$idmodel=intval($_POST["idmodel"]); $buy_regions=intsanitize($_POST["buyregions"]); $lang=intsanitize($_POST["lang"]); $usertag=mysqli_real_escape_string($con,filter_var($_POST["usertag"], FILTER_SANITIZE_STRING));
	
	$excluded_sellers=array();
	if($buy_regions==0){ $region_sel=""; }else{ $region_sel=", (SELECT `notebro_buy`.`SELLERS`.`region` FROM `notebro_buy`.`SELLERS` WHERE `notebro_buy`.`PRICES`.`seller`=`notebro_buy`.`SELLERS`.id AND `notebro_buy`.`SELLERS`.`region` IN (".$buy_regions.") LIMIT 1) as region"; }
	$sql="SELECT `notebro_buy`.`PRICES`.`seller`,`notebro_buy`.`PRICES`.`link`,`notebro_buy`.`PRICES`.`price`,(SELECT `notebro_buy`.`SELLERS`.`logo` FROM `notebro_buy`.`SELLERS` WHERE `notebro_buy`.`PRICES`.`seller`=`notebro_buy`.`SELLERS`.id LIMIT 1) as logo,(SELECT `notebro_buy`.`SELLERS`.`exchrate` FROM `notebro_buy`.`SELLERS` WHERE `notebro_buy`.`PRICES`.`seller`=`notebro_buy`.`SELLERS`.id AND `notebro_buy`.`SELLERS`.`exchrate` IN (".$lang.") LIMIT 1) as exch_test,(SELECT `notebro_site`.`exchrate`.`sign` FROM `notebro_site`.`exchrate` WHERE `notebro_site`.`exchrate`.`id`=(SELECT `notebro_buy`.`SELLERS`.`exchrate` FROM `notebro_buy`.`SELLERS` WHERE `notebro_buy`.`PRICES`.`seller`=`notebro_buy`.`SELLERS`.id LIMIT 1) LIMIT 1) as exch".$region_sel." FROM `notebro_buy`.`PRICES` WHERE `notebro_buy`.`PRICES`.`model_id`=$idmodel";
	// var_dump($sql);
	$result=mysqli_query($con,$sql);
	if($result && mysqli_num_rows($result)>0)
	{
		while($row=mysqli_fetch_assoc($result))
		{
			if($row["exch_test"]!==NULL&&((isset($row["region"])&&$row["region"]!==NULL)||(!isset($row["region"]))))
			{
				echo '<li></span><a href="'.$row["link"].'" target="blank"><span><span style="font-size: 12px;display:block;" class="searchLink">from </span><span style="font-weight: bold; font-size: 14px;" class="searchLink">'.$row["exch"].$row["price"].'</span></span><span class="buyProducerImg"> <img src="res/img/logo/'.$row["logo"].'" class="logoheight" alt="other seller"/></span></a></li>';
				$excluded_sellers[]=$row["seller"];
			}
		}
	}
	if(count($excluded_sellers)>0){ $excluded_sellers="AND id NOT IN (".implode(",",$excluded_sellers).")"; } else { $excluded_sellers=""; }
	if($buy_regions==3&&$lang!=1&&$lang!=3){$lang=1;}
	if($buy_regions==0){ $result=mysqli_query($con,"SELECT `notebro_buy`.`SELLERS`.`name` FROM `notebro_buy`.`SELLERS` WHERE `exchrate` IN (".$lang.") AND id IN (2,3,4,5,6,7,8,9,10) ".$excluded_sellers." ORDER BY priority DESC"); }
	else { $result=mysqli_query($con,"SELECT `notebro_buy`.`SELLERS`.`name` FROM `notebro_buy`.`SELLERS` WHERE `region` IN (".$buy_regions.") AND id IN (2,3,4,5,6,7,8,9,10) AND `exchrate` IN (".$lang.") ".$excluded_sellers." ORDER BY priority DESC" ); }
	if(!($result && mysqli_num_rows($result)>0)){  $result=mysqli_query($con,"SELECT `notebro_buy`.`SELLERS`.`name` FROM `notebro_buy`.`SELLERS` WHERE `region` IN (".$buy_regions.") AND id IN (2,3,4,5,6,7,8,9,10) ".$excluded_sellers." ORDER BY priority DESC"); }
	if(!($result && mysqli_num_rows($result)>0))  {$result=mysqli_query($con,"SELECT `notebro_buy`.`SELLERS`.`name` FROM `notebro_buy`.`SELLERS` WHERE `region` IN (1,2) AND id IN (2,3,4,5,6,7,8,9,10) ".$excluded_sellers." ORDER BY priority DESC"); }
	$sellers=array(); while($row=mysqli_fetch_assoc($result)){ $sellers[]=$row["name"]; }
	$_GET["model_id"]=$idmodel; $_GET["seller"]=$sellers; $_GET["keys"]=0;
	include("buy_links.php");
	foreach($return as $el)
	{
		echo '<li><a href="'.$el["link"].'" target="blank"><span style="font-weight: bold; font-size: 14px;" class="searchLink">Search</span> <img src="res/img/logo/'.$el["seller_logo"].'" class="logoheight" alt="other seller"/></a></li>';
	}
?>