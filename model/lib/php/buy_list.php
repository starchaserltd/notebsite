<?php
	require("../../../etc/con_db.php");
	function intsanitize($somestring)
	{
		$somestring=explode(",",filter_var($somestring, FILTER_SANITIZE_STRING));
		foreach($somestring as $key=>$el){ $somestring[$key]=intval($el); }
		return implode(",",$somestring);
	}
	$idmodel=intval($_POST["idmodel"]); $buy_regions=intsanitize($_POST["buyregions"]); $lang=intsanitize($_POST["lang"]); $price=intsanitize($_POST["price"]); $usertag=mysqli_real_escape_string($con,filter_var($_POST["usertag"], FILTER_SANITIZE_STRING));
	
	$tags=array(); $ref_only=0;
	if(isset($usertag)&&$usertag!="")
	{
		$result=mysqli_query($con,"SELECT * FROM `notebro_buy`.`TAGS` WHERE usertag='".$usertag."' LIMIT 1");
		if(!($result && mysqli_num_rows($result)>0)){ $usertag=""; }
		else
		{ $row=mysqli_fetch_array($result); $tags=json_decode($row[2],true); $ref_only=intval($row[3]); }
	}

	$excluded_sellers=array(); foreach($tags as $val_k){ foreach($val_k as $key=>$val){ $tags[$key]=$val; } }
	if($ref_only==1&&count($tags)>0){ $included_sellers=" AND seller IN ( SELECT `notebro_buy`.`SELLERS`.`id`  FROM `notebro_buy`.`SELLERS` WHERE "; foreach($tags as $key=>$val){ $included_sellers.=" `notebro_buy`.`SELLERS`.`name`='".$key."' OR"; } $included_sellers=substr($included_sellers, 0, -3).")"; } else { $included_sellers="";}
		
	if($buy_regions==0){ $region_sel=""; }else{ $region_sel=", (SELECT `notebro_buy`.`SELLERS`.`region` FROM `notebro_buy`.`SELLERS` WHERE `notebro_buy`.`PRICES`.`seller`=`notebro_buy`.`SELLERS`.id AND `notebro_buy`.`SELLERS`.`region` IN (".$buy_regions.") LIMIT 1) as region"; }
	$sql="SELECT abs(`notebro_buy`.`PRICES`.`price`-".$price.") as diff, `notebro_buy`.`PRICES`.`seller`,`notebro_buy`.`PRICES`.`link`,`notebro_buy`.`PRICES`.`price`,(SELECT `notebro_buy`.`SELLERS`.`logo` FROM `notebro_buy`.`SELLERS` WHERE `notebro_buy`.`PRICES`.`seller`=`notebro_buy`.`SELLERS`.id LIMIT 1) as logo,(SELECT `notebro_buy`.`SELLERS`.`name` FROM `notebro_buy`.`SELLERS` WHERE `notebro_buy`.`PRICES`.`seller`=`notebro_buy`.`SELLERS`.id LIMIT 1) as seller_name,(SELECT `notebro_buy`.`SELLERS`.`tag_name` FROM `notebro_buy`.`SELLERS` WHERE `notebro_buy`.`PRICES`.`seller`=`notebro_buy`.`SELLERS`.id LIMIT 1) as tag_name,(SELECT `notebro_buy`.`SELLERS`.`first_tag` FROM `notebro_buy`.`SELLERS` WHERE `notebro_buy`.`PRICES`.`seller`=`notebro_buy`.`SELLERS`.id LIMIT 1) as first_tag,(SELECT `notebro_buy`.`SELLERS`.`exchrate` FROM `notebro_buy`.`SELLERS` WHERE `notebro_buy`.`PRICES`.`seller`=`notebro_buy`.`SELLERS`.id AND `notebro_buy`.`SELLERS`.`exchrate` IN (".$lang.") LIMIT 1) as exch_test,(SELECT `notebro_site`.`exchrate`.`sign` FROM `notebro_site`.`exchrate` WHERE `notebro_site`.`exchrate`.`id`=(SELECT `notebro_buy`.`SELLERS`.`exchrate` FROM `notebro_buy`.`SELLERS` WHERE `notebro_buy`.`PRICES`.`seller`=`notebro_buy`.`SELLERS`.id LIMIT 1) LIMIT 1) as exch".$region_sel." FROM `notebro_buy`.`PRICES` WHERE `notebro_buy`.`PRICES`.`model_id`=$idmodel".$included_sellers." ORDER BY diff ASC,`notebro_buy`.`PRICES`.`price`";
	$result=mysqli_query($con,$sql);
	if($result && mysqli_num_rows($result)>0)
	{
		$seller_rows=array();
		while($row=mysqli_fetch_assoc($result))
		{
			if($row["exch_test"]!==NULL&&((isset($row["region"])&&$row["region"]!==NULL)||(!isset($row["region"]))))
			{
				$tag=""; $first_tag="";
				if(isset($tags[$row["seller_name"]])&&$row["first_tag"]!=""&&$row["first_tag"]!=NULL){ $first_tag=str_replace("tagname",$tags[$row["seller_name"]],$row["first_tag"]); } 
				if(isset($tags[$row["seller_name"]])&&$row["tag_name"]!=""&&$row["tag_name"]!=NULL){ $tag="&".$row["tag_name"]."=".$tags[$row["seller_name"]];} 
				if($first_tag!==""){$row["link"]=urlencode($row["link"]); $tag=urlencode($tag);}
				if(isset($seller_rows[$row["seller_name"]])){ $seller_rows[$row["seller_name"]]++; }else{$seller_rows[$row["seller_name"]]=0;}
				if($seller_rows[$row["seller_name"]]<3)
				{
					echo '<li></span><a href="'.$first_tag.$row["link"].$tag.'" target="blank"><span><span style="font-size: 12px;display:block;" class="searchLink">from </span><span style="font-weight: bold; font-size: 14px;" class="searchLink">'.$row["exch"].$row["price"].'</span></span><span class="buyProducerImg"> <img src="res/img/logo/'.$row["logo"].'" class="logoheight" alt="other seller"/></span></a></li>';
					$excluded_sellers[]=$row["seller"];
				}
			}
		}
	}
	if(count($excluded_sellers)>0){ $excluded_sellers="AND id NOT IN (".implode(",",$excluded_sellers).")"; } else { $excluded_sellers=""; }
	if($buy_regions==3&&$lang!=1&&$lang!=3){$lang=1;}
	if($buy_regions==0){ $result=mysqli_query($con,"SELECT `notebro_buy`.`SELLERS`.`name`,`notebro_buy`.`SELLERS`.`tag_name`,`SELLERS`.`first_tag`  FROM `notebro_buy`.`SELLERS` WHERE `exchrate` IN (".$lang.") AND id IN (2,3,4,5,6,7,8,9,10) ".$excluded_sellers." ORDER BY priority DESC"); }
	else { $result=mysqli_query($con,"SELECT `notebro_buy`.`SELLERS`.`name`,`notebro_buy`.`SELLERS`.`tag_name`,`SELLERS`.`first_tag` FROM `notebro_buy`.`SELLERS` WHERE `region` IN (".$buy_regions.") AND id IN (2,3,4,5,6,7,8,9,10) AND `exchrate` IN (".$lang.") ".$excluded_sellers." ORDER BY priority DESC" ); }
	if(!($result && mysqli_num_rows($result)>0)){  $result=mysqli_query($con,"SELECT `notebro_buy`.`SELLERS`.`name`,`notebro_buy`.`SELLERS`.`tag_name`,`SELLERS`.`first_tag` FROM `notebro_buy`.`SELLERS` WHERE `region` IN (".$buy_regions.") AND id IN (2,3,4,5,6,7,8,9,10) ".$excluded_sellers." ORDER BY priority DESC"); }
	if(!($result && mysqli_num_rows($result)>0))  {$result=mysqli_query($con,"SELECT `notebro_buy`.`SELLERS`.`name`,`notebro_buy`.`SELLERS`.`tag_name`,`SELLERS`.`first_tag` FROM `notebro_buy`.`SELLERS` WHERE `region` IN (1,2) AND id IN (2,3,4,5,6,7,8,9,10) ".$excluded_sellers." ORDER BY priority DESC"); }
	$sellers=array(); $tag_names=array(); while($row=mysqli_fetch_assoc($result)){ $sellers[]=$row["name"]; $tag_names[$row["name"]]=$row["tag_name"]; $first_tags[$row["name"]]=$row["first_tag"];  }
	$_GET["model_id"]=$idmodel; $_GET["seller"]=$sellers; $_GET["keys"]=0;
	include("buy_links.php");
	foreach($return as $el)
	{
		$tag=""; $first_tag="";
		if(isset($tags[$el["seller_name"]])&&isset($first_tags[$el["seller_name"]])&&$first_tags[$el["seller_name"]]!=""&&$first_tags[$el["seller_name"]]!=NULL){ $first_tag=str_replace("tagname",$tags[$el["seller_name"]],$first_tags[$el["seller_name"]]); } 
		if(isset($tags[$el["seller_name"]])&&isset($tag_names[$el["seller_name"]])&&$tag_names[$el["seller_name"]]!=""&&$tag_names[$el["seller_name"]]!=NULL){ $tag="&".$tag_names[$el["seller_name"]]."=".$tags[$el["seller_name"]];}
		if($first_tag!==""){$el["link"]=urlencode($el["link"]); $tag=urlencode($tag);}
		echo '<li><a href="'.$first_tag.$el["link"].$tag.'" target="blank"><span style="font-weight: bold; font-size: 14px;" class="searchLink">Search</span> <img src="res/img/logo/'.$el["seller_logo"].'" class="logoheight" alt="other seller"/></a></li>';
	}
?>