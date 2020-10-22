<?php
require_once("../../../etc/con_db.php");
require_once("../../../etc/conf.php");
function intsanitize($somestring)
{
	$somestring=explode(",",filter_var($somestring, FILTER_SANITIZE_STRING));
	foreach($somestring as $key=>$el){ $somestring[$key]=intval($el); }
	return implode(",",$somestring);
}

$id_model=intval($_POST["idmodel"]); $model_prod=clean_string(strval($_POST["mprod"])); $org_buy_regions=intsanitize($_POST["buyregions"]); $buy_regions=$org_buy_regions.",1"; $lang=intval(intsanitize($_POST["lang"])); $price=intsanitize($_POST["price"]); $usertag=mysqli_real_escape_string($con,filter_var($_POST["usertag"], FILTER_SANITIZE_STRING));if(isset($_POST["pmodel"])&&$_POST["pmodel"]!=NULL&&$_POST["pmodel"]!=""){$pmodel=intval($_POST["pmodel"]);}else{$pmodel=$id_model;}
$conf_complete=True; foreach($laptop_comp_list as $comp){ if(isset($_POST[$comp])){ ${"id_".$comp}=intval($_POST[$comp]); }else{ if($comp!="shdd"){ $conf_complete=False; } else { $id_shdd=0;} } }

/** FIND OTHER MODELS WITH SIMILAR CONFIG **/
require("../../../etc/con_sdb.php");
$gen_buy_regions=""; $org_buy_regions_array=explode(",",$org_buy_regions);

if($org_buy_regions!="0"){ $buy_regions_ids=array_unique(array_map('intval',explode(",",$buy_regions))); $buy_regions=implode(",",$buy_regions_ids); if(count($buy_regions_ids)>0){ $gen_buy_regions_sql=array(); $gen_buy_regions="AND ("; foreach($buy_regions_ids as $el){ $gen_buy_regions_sql[$el]="FIND_IN_SET(".$el.",`regions`)>0";} $gen_buy_regions.=implode(" OR ",$gen_buy_regions_sql).")";} }

$generated_buy_list=array(); $link_list=array(); $seller_list=array();
$tags=array(); $ref_only=0;
if(isset($usertag)&&$usertag!="")
{
	$result=mysqli_query($con,"SELECT * FROM `notebro_buy`.`TAGS` WHERE `usertag`='".$usertag."' LIMIT 1");
	if(!($result && mysqli_num_rows($result)>0)){ $usertag=""; }
	else
	{ $row=mysqli_fetch_array($result); $tags=json_decode($row[2],true); $ref_only=intval($row[3]); }
}

$excluded_sellers=array(); foreach($tags as $val_k){ foreach($val_k as $key=>$val){ $tags[$key]=$val; } }
if($ref_only==1&&count($tags)>0){ $included_sellers=" AND `seller` IN ( SELECT `notebro_buy`.`SELLERS`.`id`  FROM `notebro_buy`.`SELLERS` WHERE "; foreach($tags as $key=>$val){ $included_sellers.=" `notebro_buy`.`SELLERS`.`name`='".$key."' OR"; } $included_sellers=substr($included_sellers, 0, -3).")"; } else { $included_sellers="";}

$new_prices=0;
if($conf_complete)
{
	if(in_array(1,$org_buy_regions_array)==False){ $gen_buy_regions=str_replace(" OR FIND_IN_SET(1,`regions`)>0","",$gen_buy_regions); }
	$SELECT_NEW_PRICE="SELECT * FROM `notebro_buy`.`CONFIG` WHERE `type`='new_price_gen' AND `data_1`='".$model_prod."' ".str_replace("regions","data_2",$gen_buy_regions)." LIMIT 1";
	$new_price_q=mysqli_query($con,$SELECT_NEW_PRICE);
	if(have_results($new_price_q))
	{ $new_prices=1; mysqli_free_result($new_price_q);}
	else { $new_prices=0; }
}

if($new_prices)
{	
	$price_data=array();
	
	$disabled_cond="1=1";
	require_once("get_disabled_conf.php");
	
	//GETTING FIXED PRICES
	$sql_price_q="SELECT `PRICES`.*,`SELLERS`.*,`SELLERS`.`id` AS `seller_id`,`PRICES`.`id` AS `price_id`,`EXCH`.`sign` AS `exch_sign` FROM `notebro_buy`.`FIXED_CONF_PRICES` AS `PRICES` JOIN `notebro_buy`.`SELLERS` AS `SELLERS` ON `PRICES`.`retailer`=`SELLERS`.`name` JOIN `notebro_site`.`exchrate` AS `EXCH` ON `SELLERS`.`exchrate`=`EXCH`.`id` WHERE `PRICES`.`model`='".$id_model."' AND (".$disabled_cond.") ORDER BY `PRICES`.`price` ASC";
	#var_dump($sql_price_q);
	$price_data_q_r=mysqli_query($con,$sql_price_q);
	$id_modifiers=array();
	if(have_results($price_data_q_r))
	{
		while($some_row=mysqli_fetch_assoc($price_data_q_r))
		{
			foreach($laptop_comp_list as $comp)
			{ $some_row[$comp]=[intval($some_row[$comp])];}
			$id_modifiers=json_decode($some_row["eq_modifiers"],True);
			foreach($id_modifiers as $comp_data=>$id_info)
			{
				if(isset($id_info["eq_id"]))
				{
					foreach($id_info["eq_id"] as $key=>$val)
					{
						$some_row[$comp_data][]=intval($key);
					}
					$some_row[$comp_data]=array_unique($some_row[$comp_data]);
				}
			}
			unset($some_row["eq_modifiers"]);
			$price_data[$some_row["price_id"]]=$some_row;
		}
		unset($some_row);
		mysqli_free_result($price_data_q_r);
	}
	$prices_list=array(); $i=0;
	
	$tries=2;
	while($tries>0)
	{
		foreach($price_data as $price_values)
		{
			$ok_to_add=True;
			foreach($laptop_comp_list as $comp)
			{
				if($tries==1 && $comp=="war")
				{ continue; }
				else
				{	
					if(!(in_array(${"id_".$comp},$price_values[$comp])))
					{ $ok_to_add=False; /*var_dump(${"id_".$comp}); var_dump($comp); var_dump($price_values); echo "<br><br>";*/ break; }
				}
			}
			if($ok_to_add)
			{ 
				if(!(isset($prices_list[$price_values["seller_id"]]) && count($prices_list[$price_values["seller_id"]])>2))
				{ 
					$generated_buy_list[$i]=["price"=>($price_values["exch_sign"].intval($price_values["price"])),"logo"=>$price_values["logo"],"type"=>1]; $link_list[$i]=$price_values["url"]; $seller_list[$i]=$price_values["seller_id"]; $i++;
					$prices_list[$price_values["seller_id"]][$i]=intval($price_values["price"]);
				}
				else
				{
					/*put_smallest_price($price_values["seller_id"],intval($price_values["price"]),$price_values["url"]);*/ //Since prices are selected by smallest to highest, just display the first 3.
				}
			}
		}
		if(isset($prices_list)&&count($prices_list)>0)
		{ $tries=-1; }
		else
		{ $tries--; }
	}

	//GETTING VAR PRICES
	$sql_price_q="SELECT `PRICES`.*,`SELLERS`.*,`SELLERS`.`id` AS `seller_id`,`EXCH`.`sign` AS `exch_sign` FROM `notebro_buy`.`VAR_CONF_PRICES` AS `PRICES` JOIN `notebro_buy`.`SELLERS` AS `SELLERS` ON `PRICES`.`retailer`=`SELLERS`.`name` JOIN `notebro_site`.`exchrate` AS `EXCH` ON `SELLERS`.`exchrate`=`EXCH`.`id` WHERE `PRICES`.`model`='".$id_model."' AND (".$disabled_cond.") ORDER BY `PRICES`.`time` ASC";
	$price_data_q_r=mysqli_query($con,$sql_price_q);
	if(have_results($price_data_q_r))
	{
		require_once("calc_price.php");
		$conf_to_calc=array(); foreach($laptop_comp_list as $comp){ $conf_to_calc[$comp]=${"id_".$comp}; } $conf_to_calc["model"]=$id_model;
		while($some_row=mysqli_fetch_assoc($price_data_q_r))
		{
			$conf_price_data=json_decode($some_row["price_data"],True);
			$new_price=calc_conf_price($conf_to_calc,$noteb_pid=NULL,$retailer_pid=NULL,$retailer=NULL,$set_price_list=$conf_price_data,$con=$con);
			if(isset($new_price[0]))
			{ 
				$price_values=$new_price[0];
				$generated_buy_list[]=["price"=>($some_row["exch_sign"].intval($price_values[0])),"logo"=>$some_row["logo"],"type"=>1]; $link_list[]=$some_row["url"]; $seller_list[]=$some_row["seller_id"];
			}
			else
			{
				if(isset($conf_price_data["wnet"]))
				{
					asort($conf_price_data["wnet"]);
					foreach($conf_price_data["wnet"] as $key=>$val)
					{
						$conf_to_calc["wnet"]=$key;
						$new_price=calc_conf_price($conf_to_calc,$noteb_pid=NULL,$retailer_pid=NULL,$retailer=NULL,$set_price_list=$conf_price_data,$con=$con);
						if(isset($new_price[0]))
						{ 
							$price_values=$new_price[0];
							$generated_buy_list[]=["price"=>($some_row["exch_sign"].intval($price_values[0])),"logo"=>$some_row["logo"],"type"=>1]; $link_list[]=$some_row["url"]; $seller_list[]=$some_row["seller_id"];
							break;
						}
						else
						{ }
					}
				}
			}
		}
		unset($some_row);
		mysqli_free_result($price_data_q_r);
	}
	
	$excluded_sellers=["2","3"];
}
else
{	
	$sql="SELECT `id` AS `models` FROM `notebro_db`.`MODEL` WHERE `p_model`=".$pmodel." AND `id`!=".$id_model." AND FIND_IN_SET(".$id_cpu.",`cpu`)>0 AND FIND_IN_SET(".$id_gpu.",`gpu`)>0 AND FIND_IN_SET(".$id_display.",`display`)>0"." ".$gen_buy_regions."";
	$result=mysqli_query($con,$sql); $add_models=array();
	if($result&&mysqli_num_rows($result)>0)
	{
		while($row=mysqli_fetch_row($result))
		{
			$sql="SELECT `id` FROM `notebro_temp`.`all_conf_".$row[0]."` WHERE `model`=".$row[0]." AND `cpu`=".$id_cpu." AND `gpu`=".$id_gpu." AND `display`=".$id_display." LIMIT 1";
			$result2=mysqli_query($cons,$sql);
			if($result2&&mysqli_num_rows($result2)>0)
			{ $add_models[]=$row[0]; mysqli_free_result($result2); }
		}
	}

	if(isset($gen_buy_regions_sql[0])){unset($gen_buy_regions_sql[0]);}
	if(isset($gen_buy_regions_sql[1])){unset($gen_buy_regions_sql[1]);}
	$gen_buy_regions_sql = array_values($gen_buy_regions_sql);

	if(isset($gen_buy_regions_sql[0]))
	{
		$gen_buy_regions_nodef=implode(" OR ",$gen_buy_regions_sql);
		$test_current_sql="SELECT `regions` from `notebro_temp`.`ex_map_table` WHERE (".$gen_buy_regions_nodef.") AND `ex_id`=".$lang." LIMIT 1";
		$result2=mysqli_query($cons,$test_current_sql);

		if(!($result2&&mysqli_num_rows($result2)>0))
		{
			$test_current_sql="SELECT `regions`,`ex_id` from `notebro_temp`.`ex_map_table` WHERE (".$gen_buy_regions_nodef.") LIMIT 1";
			$result2=mysqli_query($cons,$test_current_sql);
			if($result2&&mysqli_num_rows($result2)>0){ $lang=intval(mysqli_fetch_assoc($result2)["ex_id"]); mysqli_data_seek($result2,0); }
		}
	}
	else
	{ $result2=mysqli_query($cons,"SELECT `regions` FROM `notebro_temp`.`ex_map_table` WHERE `ex_id`=".$lang." LIMIT 1"); $buy_regions="0"; }

	if($result2&&mysqli_num_rows($result2)>0)
	{
		$sql="SELECT GROUP_CONCAT(`ex_id`) as lang_regions FROM `notebro_temp`.`ex_map_table` WHERE 1=1";
		foreach(explode(",",mysqli_fetch_assoc($result2)["regions"]) as $val){ $sql.=" AND FIND_IN_SET($val,`regions`)>0";}
		mysqli_free_result($result2);
		$result2=mysqli_query($cons,$sql);
		if($result2&&mysqli_num_rows($result2)>0)
		{ $extended_lang=mysqli_fetch_assoc($result2)["lang_regions"]; }
	}
	else
	{ $lang=1; $extended_lang=1; }

	mysqli_close($cons);
	$add_models[]=$id_model;

	if($buy_regions=="0"){ $region_sel=""; }else{ $region_sel=", (SELECT `notebro_buy`.`SELLERS`.`region` FROM `notebro_buy`.`SELLERS` WHERE `notebro_buy`.`PRICES`.`seller`=`notebro_buy`.`SELLERS`.id AND `notebro_buy`.`SELLERS`.`region` IN (".$buy_regions.") LIMIT 1) as region"; }
	$sql="SELECT abs(`notebro_buy`.`PRICES`.`price`-".$price.") as diff, `notebro_buy`.`PRICES`.`seller`,`notebro_buy`.`PRICES`.`link`,`notebro_buy`.`PRICES`.`price`,(SELECT `notebro_buy`.`SELLERS`.`logo` FROM `notebro_buy`.`SELLERS` WHERE `notebro_buy`.`PRICES`.`seller`=`notebro_buy`.`SELLERS`.id LIMIT 1) AS `logo`,(SELECT `notebro_buy`.`SELLERS`.`id` FROM `notebro_buy`.`SELLERS` WHERE `notebro_buy`.`PRICES`.`seller`=`notebro_buy`.`SELLERS`.id LIMIT 1) AS `seller_id`,(SELECT `notebro_buy`.`SELLERS`.`exchrate` FROM `notebro_buy`.`SELLERS` WHERE `notebro_buy`.`PRICES`.`seller`=`notebro_buy`.`SELLERS`.id AND `notebro_buy`.`SELLERS`.`exchrate` IN (".$extended_lang.") LIMIT 1) AS `exch_test`,(SELECT `notebro_site`.`exchrate`.`sign` FROM `notebro_site`.`exchrate` WHERE `notebro_site`.`exchrate`.`id`=(SELECT `notebro_buy`.`SELLERS`.`exchrate` FROM `notebro_buy`.`SELLERS` WHERE `notebro_buy`.`PRICES`.`seller`=`notebro_buy`.`SELLERS`.id LIMIT 1) LIMIT 1) AS `exch` ".$region_sel." FROM `notebro_buy`.`PRICES` WHERE `notebro_buy`.`PRICES`.`model_id` IN (".implode(",",$add_models).")".$included_sellers." ORDER BY diff ASC,`notebro_buy`.`PRICES`.`price`";
	$seller_count_links=array();

	$result=mysqli_query($con,$sql);
	if($result && mysqli_num_rows($result)>0)
	{
		$seller_rows=array();
		while($row=mysqli_fetch_assoc($result))
		{
			if($row["exch_test"]!==NULL&&((isset($row["region"])&&$row["region"]!==NULL)||(!isset($row["region"]))))
			{
				$generated_buy_list[]=["price"=>$row["exch"].$row["price"],"logo"=>$row["logo"],"type"=>1]; $link_list[]=$row["link"]; $seller_list[]=$row["seller_id"];
				$seller_count_links[$row["seller"]][]=array_key_last($generated_buy_list);
				$excluded_sellers[]=$row["seller"];
			}
		}
	}

	/* SOMETIMES WE MAY HAVE A VERY LONG LIST OF PRODUCTS FROM THE SAME RETAILER AND WE NEED TO TRIM IT DOWN */
	$ids_to_unset=array();
	foreach($seller_count_links as $seller_name=>$links)
	{
		if(is_countable($links))
		{
			$max_count=count($links);
			if($max_count>4)
			{
				#Replacing position 2 and 3 from the buy list with the medium values of the entire list.
				$replace_id=$seller_count_links[$seller_name][3]; $replace_with=NULL; if(isset($seller_count_links[$seller_name][($max_count-1)])) { $replace_with=$seller_count_links[$seller_name][($max_count-1)]; }
				if(isset($generated_buy_list[$replace_with])&&$generated_buy_list[$replace_with]) { $generated_buy_list[$replace_id]=$generated_buy_list[$replace_with]; $link_list[$replace_id]=$link_list[$replace_with]; $seller_list[$replace_id]=$seller_list[$replace_with]; }
				
				$replace_id=$seller_count_links[$seller_name][2]; $replace_with=NULL; if(isset($seller_count_links[$seller_name][ceil($max_count/2)])) { $replace_with=$seller_count_links[$seller_name][ceil($max_count/2)]; }
				if(isset($generated_buy_list[$replace_with])&&$generated_buy_list[$replace_with]) { $generated_buy_list[$replace_id]=$generated_buy_list[$replace_with]; $link_list[$replace_id]=$link_list[$replace_with]; $seller_list[$replace_id]=$seller_list[$replace_with]; }
				
				#Setting keys for deletion for everything that is over 4 records.
				unset($replace_with); unset($replace_id);
				#var_dump($generated_buy_list); echo "<br><br>"; var_dump($seller_count_links);
				for($i=4;$i<10000;$i++)
				{ 
					if(isset($seller_count_links[$seller_name][$i]) && isset($generated_buy_list[$seller_count_links[$seller_name][$i]]))
					{ /*var_dump($generated_buy_list[$seller_count_links[$seller_name][$i]]);*/ $ids_to_unset[]=$seller_count_links[$seller_name][$i]; }
					else
					{ break; }
				}
			}
		}
	}
	#DELETING the extra keys
	foreach($ids_to_unset as $id_to_unset)
	{
		unset($generated_buy_list[$id_to_unset]); unset($link_list[$id_to_unset]); unset($seller_list[$id_to_unset]);
	}
}

#Rebuilding the arrayss
$generated_buy_list=array_values($generated_buy_list); $link_list=array_values($link_list); $seller_list=array_values($seller_list);

if(count($excluded_sellers)>0){ /*$excluded_sellers[]="3";*/ $excluded_sellers="AND id NOT IN (".implode(",",$excluded_sellers).")"; } else { $excluded_sellers=""; }

if(($buy_regions=="3" || $org_buy_regions=="3")&&$lang!=1&&$lang!=3){$lang=1;}
if($buy_regions=="0" || $org_buy_regions=="0"){ $result=mysqli_query($con,"SELECT GROUP_CONCAT(`notebro_buy`.`SELLERS`.`id`) AS `id` FROM `notebro_buy`.`SELLERS` WHERE `exchrate` IN (".$lang.") AND id IN (2,3,4,5,6,7,8,9,10) ".$excluded_sellers." ORDER BY `priority` DESC"); }
else { $result=mysqli_query($con,"SELECT GROUP_CONCAT(`notebro_buy`.`SELLERS`.`id`) AS `id` FROM `notebro_buy`.`SELLERS` WHERE `region` IN (".$buy_regions.") AND id IN (2,3,4,5,6,7,8,9,10) AND `exchrate` IN (".$lang.") ".$excluded_sellers." ORDER BY `priority` DESC"); }
if(!(have_results($result))){ $result=mysqli_query($con,"SELECT GROUP_CONCAT(`notebro_buy`.`SELLERS`.`id`) AS `id` FROM `notebro_buy`.`SELLERS` WHERE `region` IN (".$buy_regions.") AND id IN (2,3,4,5,6,7,8,9,10) ".$excluded_sellers." ORDER BY `priority` DESC"); }
if(!(have_results($result))){ $result=mysqli_query($con,"SELECT GROUP_CONCAT(`notebro_buy`.`SELLERS`.`id`) AS `id` FROM `notebro_buy`.`SELLERS` WHERE `region` IN (1,2) AND id IN (2,3,4,5,6,7,8,9,10) ".$excluded_sellers." ORDER BY `priority` DESC"); }
$sellers=array(); if(have_results($result)){ $sellers=array_unique(explode(",",mysqli_fetch_assoc($result)["id"])); mysqli_free_result($result);}
$_GET["model_id"]=$id_model; $_GET["seller"]=$sellers; $_GET["keys"]=0;
include("buy_links.php");

foreach($return as $el)
{ $generated_buy_list[]=["price"=>null,"logo"=>$el["seller_logo"],"type"=>2]; $link_list[]=$el["link"]; $seller_list[]=$el["id"]; }


$include_aff_gen=true; $function_replay=null;
if(isset($usertag)&&$usertag!=""){ $_POST["usertag"]=$usertag; };
$_POST["links"]=$link_list;
$_POST["sellers"]=$seller_list;
require_once("../../../libnb/php/aff_gen.php");

if($function_replay!=null&&isset($function_replay[0])&&$function_replay[0]!=null)
{ 
	$function_replay=json_decode($function_replay);
	if($function_replay!=null&&isset($function_replay[0])&&$function_replay[0]!=null)
	{ 	$link_list=$function_replay; }
}

# DELETING DUPLICATES
$keys_to_unset=array();
foreach($link_list as $key=>$el)
{
	foreach($link_list as $key_2=>$el_2)
	{
		if($el_2==$el && $key_2!=$key)
		{ $keys_to_unset[]=$key; }
	}
}
$keys_to_unset=array_unique($keys_to_unset);
foreach($keys_to_unset as $key)
{ unset($generated_buy_list[$key]); unset($link_list[$key]); unset($seller_list[$key]); }


/* *** Finally the links are displayed *** */

foreach($link_list as $key=>$el)
{
	switch($generated_buy_list[$key]["type"])
	{
		case 1:{ echo '<li><a href="'.$el.'" target="blank"><span><span style="font-size: 12px;display:block;" class="searchLink">from </span><span style="font-weight: bold; font-size: 14px;" class="searchLink">'.$generated_buy_list[$key]["price"].'</span></span><span class="buyProducerImg"><img src="res/img/logo/'.$generated_buy_list[$key]["logo"].'" class="logoheight" alt="other seller"/></span></a></li>'; break;}
		case 2: {echo '<li><a href="'.$el.'" target="blank"><span style="font-weight: bold; font-size: 14px;" class="searchLink">Search</span> <img src="res/img/logo/'.$generated_buy_list[$key]["logo"].'" class="logoheight" alt="other seller"/></a></li>'; break;}
		default:{ echo '<li><a href="'.$el.'" target="blank"><span class="buyProducerImg"><img src="res/img/logo/'.$generated_buy_list[$key]["logo"].'" class="logoheight" alt="other seller"/></span></a></li>'; break;}
	}
}
mysqli_close($con);

function put_smallest_price($seller_id,$new_price,$new_url)
{
	$some_array=$GLOBALS["price_list"][$seller_id];
	foreach($some_array as $key=>&$values)
	{ 
		if($values>$new_price)
		{ $old_price=$values; $old_url=$GLOBALS["link_list"][$key]; $values=$new_price; $GLOBALS["link_list"][$key]=$new_url; put_smallest_price($sellWer_id,$old_price,$old_url); break; }
	}
}
?>