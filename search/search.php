<?php
require_once("../etc/conf.php");
if (!isset($_SERVER['HTTP_REFERER']) || stripos($_SERVER['HTTP_REFERER'],$site_name) ==FALSE) 
{	$actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	header("Location: ".$port_type."://".str_replace($site_name."/",$site_name."/?",$actual_link)."");
	die();
}
require_once("../etc/session.php");
require_once("../libnb/php/urlproc.php");
require_once("proc/init.php");
$absolute_url = str_replace($web_address,"",full_url( $_SERVER ));
$absolute_url=explode("&page=",$absolute_url,2);

//THIS is a security key to prevent unauthorised access of code, basically we allow this script to work only when it has been accessed by another php page 
if(strcmp("kMuGLmlIzCWmkNbtksAh",$_SESSION['auth'])==0)
{
	//$_SESSION['auth']=0;
	require_once("../etc/con_db.php");
	
	/********************************************************************/
	/* GENERIC SEARCH VARIABLES */	
	/********************************************************************/
	if(isset($_GET['advsearch'])) { $isadvanced=intval($_GET['advsearch']); }
	if(isset($_GET['s_memmin'])) { $issimple=intval($_GET['s_memmin']); }
	if(isset($_GET['sort_by'])){$sort_by=clean_string($_GET['sort_by']);}
	$name_button=""; $performance_button=""; $value_button=""; $price_button="";
	//SET PARAMETERS FOR ORDERING
	switch($sort_by) 
	{
		case "performance":
		{
			$orderby =  "ORDER BY rating DESC";
			$orderby_index = "USE INDEX FOR ORDER BY (rating)";
			$performance_button = " active";
			$sort_func = "sort_func_by_rating";
			break;
		}
		case "value":
		{
			$orderby = "ORDER BY value DESC";
			$orderby_index = "USE INDEX FOR ORDER BY (value)";
			$value_button = " active";
			$sort_func = "sort_func_by_value";
			break;
		}
		case "price":
		{
			$orderby = "ORDER BY price ASC";
			$orderby_index = "USE INDEX FOR ORDER BY (price)";
			$price_button = " active";
			$sort_func = "sort_func_by_price";
			break;
		}
		case "name":
		{
			$orderby =  "";
			$name_button = " active";
			$sort_func = "id";
			break;
		}
		default:
		{
			$orderby = "ORDER BY value DESC";
			$orderby_index = "USE INDEX FOR ORDER BY (value_desc)";
			$value_button = " active";
			$sort_func = "sort_func_by_value";
			break;
		}
	}
	
	/*GET exchange rate list*/
	$sel2="SELECT id,convr,code,sign,ROUND(convr,5) as rconvr,regions as region,country_long,(SELECT GROUP_CONCAT(regions) as regions FROM notebro_site.exchrate) as regions FROM notebro_site.exchrate";
	$result = mysqli_query($con,$sel2); $exchange_list=new stdClass();$region_ex=array(); $region_ex[0]="USD"; $always_model_region=false;
	while($row=mysqli_fetch_assoc($result))
	{
		foreach(explode(",",$row["region"]) as $el){ $el=intval($el); if(!isset($region_ex[$el])){$region_ex[$el]=$row["code"];}}
		$exchange_list->{$row["code"]}=array("id"=>$row["id"],"convr"=>floatval($row["rconvr"]),"sign"=>$row["sign"],"region"=>$row["region"],"regions"=>$row["regions"]);
		$exchange_list->{$row["country_long"]}=array("id"=>$row["id"],"convr"=>floatval($row["rconvr"]),"sign"=>$row["sign"],"region"=>$row["region"],"regions"=>$row["regions"],"ex_code"=>$row["code"]);
	}
	
	if((isset($_GET['exchange']) && is_string($_GET['exchange']))||(isset($_GET['exchadv']) && is_string($_GET['exchadv'])))
	{
		if(isset($_GET['exchadv'])){ $exchcode=strtoupper(clean_string($_GET['exchadv'])); }
		elseif(isset($_GET['exchange'])){ $exchcode=strtoupper(clean_string($_GET['exchange'])); }
		$regional_type="region";
	}
	else
	{ if(isset($_SESSION['exchcode'])){ $exchcode=$_SESSION['exchcode']; if(isset($_SESSION['regional_type'])){$regional_type=$_SESSION['regional_type'];}else{$regional_type="region"; $always_model_region=true;} }else{$exchcode="USD"; $regional_type="region"; $always_model_region=true;} }
	$value=$exchange_list->{$exchcode};

	$exch=$value["convr"];
	$exchsign=$value["sign"];
	$search_regions_array=array_unique(explode(",",$value[$regional_type]));
	$search_regions_results=implode(",",$search_regions_array);
	$_SESSION['regional_type']=$regional_type;
	$_SESSION['exchcode']=$exchcode;
	$_SESSION['exch']=$exch;
	$_SESSION['exchsign']=$value["sign"];
	$_SESSION['lang']=$value["id"]; $exch_id=$value["id"];
	include_once("../etc/scripts_pages.php");
	if($underwork==0)
	{
		if(isset($_GET['page'])){$page=intval($_GET['page']);} 
		else {$page=1;}
		
		if(isset($_GET['detailed'])) { $isdetailed=(is_numeric($_GET['detailed'])) ? intval($_GET['detailed']) : NULL; }
		
		/********************************************************************/
		/* CHECKING IF DOING SIMPLE SEARCH */	
		/********************************************************************/

		if ($issimple) 
		{ include ("preproc/s_search_varproc.php"); }

		/********************************************************************/
		/* CHECKING IF DOING ADVANCED SEARCH */	
		/********************************************************************/

		else if ( isset($_GET['advsearch']) && $_GET['advsearch'])
		{ include ("preproc/adv_search_varproc.php"); }
		
		/********************************************************************/
		/* CHECKING IF DOING QUIZ SEARCH */	
		/********************************************************************/

		else if ( isset($_GET['quizsearch']) && $_GET['quizsearch'])
		{ include ("preproc/q_search_varproc.php"); }
	
		/********************************************************************/
		/* CHECKING IF DOING BROWSE SEARCH */	
		/********************************************************************/

		else if (isset($_GET['browse_by']) && $_GET['browse_by'])
		{ $mem_capmax=32; include ("preproc/b_search_varproc.php"); }
		
		/* DEBUGGING CODE */
		#$time_start = microtime(true);
		
		if(!(isset($_GET["presearch"])&&intval($_GET["presearch"])==1)){$show_presearch=1; $presearch_comp_limit=0;}else{$show_presearch=0; $presearch_comp_limit=250;}
		
		require("proc/search_filters.php");
		require("proc/presearch.php");
		if($show_presearch)
		{ include("results.php"); }
		else
		{ echo "+++++".count(array_unique($count_p_models));}
		
		exit();
	}
	else
	{	$hourtext="hour"; if($underwork>1){$hourtext="hours";}
		echo "<div class='serverMaintenance'><div class='animationContainer'><span class='glyphicon glyphicon-cog' aria-hidden='true'></span>
		<span class='glyphicon glyphicon-cog' aria-hidden='true'></span>
		<span class='glyphicon glyphicon-cog' aria-hidden='true'></span></div><p>We apologies, but we are currently undergoing server maintenance.<br><br>The search functionality has been temporarily disabled.<br>We will be back in approximately ".$underwork." ".$hourtext."!</p></div>";
	}
}
else
{
	echo "Heh! What are you trying to do?";
}
?>