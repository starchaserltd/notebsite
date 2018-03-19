<?php
//THIS is a security key to prevent unauthorised access of code, basically we allow this script to work only when it has been accessed by solosearch.php 
if(!defined('ROOT_PATH')){ $root=define('ROOT_PATH', str_ireplace("/search","",dirname(__DIR__))); } $root=ROOT_PATH."/search/";
if(strcmp("kMuGLmlIzCWmkNbtksAh",$_SESSION['auth'])==0)
{
    $comp_lists = array();

	/* FILTER BY REGION, MODEL , FMAILY, PRODUCER */
	if($to_search["regions"])
	{
		require_once($root."proc/regions_search.php");
		$regions_id = search_regions ($regions_name);
	}	else {	$dispregion=1;	}
	
	if($to_search["model"])
    {
		require_once($root."proc/model_search.php");
		$comp_lists["model"] = search_model ($model_model, $prod_model, $fam_model,$msc_model, $regions_id, $model_minclass, $model_maxclass, $model_advclass);
	}

    /* FIRST LETS GET THE COMPONENT FILTER LIST */
	if($to_search["cpu"])
	{
		require_once($root."proc/cpu_search.php");
		$comp_lists["cpu"] = search_cpu ($cpu_prod, $cpu_model, $cpu_ldmin, $cpu_ldmax, $cpu_status, $cpu_socket, $cpu_techmin, $cpu_techmax, $cpu_cachemin, $cpu_cachemax, $cpu_clockmin, $cpu_clockmax, $cpu_turbomin, $cpu_turbomax, $cpu_tdpmax,$cpu_tdpmin, $cpu_coremin, $cpu_coremax, $cpu_intgpu, $cpu_misc, $cpu_ratemin, $cpu_ratemax, $pricemin, $budgetmax, $battery_life);
	}

	if($to_search["display"])
	{
		require_once($root."proc/display_search.php");
		$comp_lists["display"] = search_display ($display_model, $display_sizemin, $display_sizemax, $display_format, $display_hresmin, $display_hresmax, $display_vresmin, $display_vresmax, $display_surft, $display_backt, $display_touch,  $display_misc, $display_resolutions, $display_ratingmin, $display_ratingmax, $pricemin, $budgetmax, $battery_life,$display_srgb);
	}
	
	if($to_search["mem"])
	{
		require_once($root."proc/mem_search.php");
		$comp_lists["mem"]=search_mem ($mem_prod, $mem_capmin, $mem_capmax, $mem_stan, $mem_freqmin, $mem_freqmax, $mem_type, $mem_latmin, $mem_latmax, $mem_voltmin, $mem_voltmax, $mem_misc, $mem_ratemin, $mem_ratemax, $pricemin,$budgetmax);
	}

	if($to_search["hdd"])
	{
		require_once($root."proc/hdd_search.php");
		$comp_lists["hdd"] = search_hdd ($hdd_model, $hdd_capmin, $hdd_capmax, $hdd_type, $hdd_readspeedmin, $hdd_readspeedmax, $hdd_writesmin, $hdd_writesmax, $hdd_rpmmin, $hdd_rpmmax, $hdd_misc, $hdd_ratemin, $hdd_ratemax, $pricemin, $budgetmax);
	}

	if($to_search["shdd"])
	{
		require_once($root."proc/shdd_search.php");
		$comp_lists["shdd"] = search_shdd ($nr_hdd);
	}

	if($to_search["gpu"])
	{ 
		require_once($root."proc/gpu_search.php");
		$comp_lists["gpu"] = search_gpu ($gpu_typelist, $gpu_prod, $gpu_model, $gpu_arch, $gpu_techmin, $gpu_techmax, $gpu_shadermin, $gpu_cspeedmin, $gpu_cspeedmax, $gpu_sspeedmin, $gpu_sspeedmax, $gpu_mspeedmin, $gpu_mspeedmax, $gpu_mbwmin, $gpu_mbwmax, $gpu_mtype, $gpu_maxmemmin, $gpu_maxmemmax, $gpu_sharem, $gpu_powermin, $gpu_powermax, $gpu_ldmin, $gpu_ldmax, $gpu_misc, $gpu_ratemin, $gpu_ratemax, $pricemin ,$budgetmax, $battery_life);
	}

	if($to_search["wnet"])
	{
		require_once($root."proc/wnet_search.php");
		$comp_lists["wnet"] = search_wnet ($wnet_prod, $wnet_model, $wnet_misc, $wnet_speedmin, $wnet_speedmax, $wnet_bluetooth, $wnet_ratemin, $wnet_ratemax, $pricemin, $budgetmax);
	}
	
	if($to_search["odd"])
	{
		require_once($root."proc/odd_search.php");
		$comp_lists["odd"] = search_odd ($odd_type, $odd_prod, $odd_misc, $odd_speedmin, $odd_speedmax, $odd_ratemin, $odd_ratemax, $pricemin, $budgetmax);
	}
	
	if($to_search["mdb"])
	{
		require_once($root."proc/mdb_search.php");
		$comp_lists["mdb"] = search_mdb ($mdb_prod, $mdb_model, $mdb_ramcap, $mdb_gpu, $mdb_chip, $mdb_socket, $mdb_interface, $mdb_netw, $mdb_hdd, $mdb_misc, $mdb_ratemin, $mdb_ratemax, $pricemin,$budgetmax,$mdb_wwan);
	}

	if($to_search["chassis"])
	{
		require_once($root."proc/chassis_search.php");
		$comp_lists["chassis"] = search_chassis ($chassis_prod, $chassis_model, $chassis_thicmin, $chassis_thicmax, $chassis_depthmin, $chassis_depthmax, $chassis_widthmin, $chassis_widthmax, $chassis_color, $chassis_weightmin, $chassis_weightmax, $chassis_made, $chassis_ports, $chassis_vports, $chassis_webmin, $chassis_webmax, $chassis_touch, $chassis_misc, $chassis_stuff, $chassis_ratemin, $chassis_ratemax, $pricemin,$budgetmax,$chassis_extra_stuff,$chassis_twoinone,$chassis_addpi);
	}
	
	if($to_search["acum"])
	{
		require_once($root."proc/acum_search.php");
		$comp_lists["acum"] = search_acum ($acum_tipc, $acum_nrcmin, $acum_nrcmax, $acum_volt, $acum_capmin, $acum_capmax, $pricemin, $budgetmax, $acum_misc, $battery_life);
	}

	if($to_search["war"])
	{
		require_once($root."proc/war_search.php");
		$comp_lists["war"] = search_war ($war_prod, $war_yearsmin, $war_yearsmax, $war_typewar, $war_misc, $war_ratemin, $war_ratemax, $pricemin,$budgetmax);
	}


	if($to_search["sist"])
	{
		require_once($root."proc/sist_search.php");
		$comp_lists["sist"] = search_sist ($sist_sist, $sist_vers, $sist_misc, $pricemin, $budgetmax);
	}
}	
else
{
	echo "Heh! What are you trying to do?";
} 
?>
