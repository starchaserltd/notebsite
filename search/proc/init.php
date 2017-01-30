<?php
/* TO HELP PHP DEAL WITH EMPTY VARIABLES*/ //adaugat chassis_twoinone
$isadvanced=0; $issimple=0;
$model_model=array(); $prod_model=array(); $fam_model=array(); $msc_model=array();
$cpu_prod=array(); $cpu_model=array(); $cpu_ldmin=0; $cpu_ldmax=0; $cpu_status=0; $cpu_socket=array(); $cpu_techmin=0; $cpu_techmax=0; $cpu_cachemin=0; $cpu_cachemax=0; $cpu_clockmin=0; $cpu_clockmax=0; $cpu_turbomin=0; $cpu_turbomax=0; $cpu_tdpmax=0;$cpu_tdpmin=0; $cpu_coremin=0; $cpu_coremax=0; $cpu_intgpu=0; $cpu_misc=array(); $cpu_ratemin=0; $cpu_ratemax=0;
$display_model=array(); $display_sizemin=0; $display_sizemax=0; $display_format=array(); $display_hresmin=0; $display_hresmax=0; $display_vresmin=0; $display_vresmax=0; $display_surft=array(); $display_backt=array(); $display_touch=array();   $display_misc=array(); $display_resolutions=0; $display_ratingmin=0; $display_ratingmax=0;
$gpu_typegpumin=0; $gpu_typegpumax=0; $gpu_prod=array(); $gpu_model=array(); $gpu_arch=array(); $gpu_techmin=0; $gpu_techmax=0; $gpu_shadermin=0; $gpu_cspeedmin=0; $gpu_cspeedmax=0; $gpu_sspeedmin=0; $gpu_sspeedmax=0; $gpu_mspeedmin=0; $gpu_mspeedmax=0; $gpu_mbwmin=0; $gpu_mbwmax=0; $gpu_mtype=array(); $gpu_maxmemmin=0; $gpu_maxmemmax=0; $gpu_sharem=0; $gpu_powermin=0; $gpu_powermax=0; $gpu_misc=array(); $gpu_ratemin=0; $gpu_ratemax=0;
$acum_tipc=array(); $acum_nrcmin=0; $acum_nrcmax=0; $acum_volt=0; $acum_capmin=0; $acum_capmax=0; $acum_misc=array();
$war_prod=array(); $war_yearsmin=0; $war_yearsmax=0; $war_typewar=array(); $war_misc=array(); $war_ratemin=0; $war_ratemax=0;
$hdd_model=array(); $hdd_capmin=0; $hdd_capmax=0; $hdd_type=array(); $hdd_readspeedmin=0; $hdd_readspeedmax=0; $hdd_writesmin=0; $hdd_writesmax=0; $hdd_rpmmin=0; $hdd_rpmmax=0; $hdd_misc=array(); $hdd_ratemin=0; $hdd_ratemax=0;
$nr_hdd=0;
$wnet_prod=array(); $wnet_model=array(); $wnet_misc=array(); $wnet_speedmin=0; $wnet_speedmax=0; $wnet_bluetooth=0; $wnet_ratemin=0; $wnet_ratemax=0;
$sist_sist=array(); $sist_vers=array(); $sist_misc=array();
$odd_type=array(); $odd_prod=array(); $odd_misc=array(); $odd_speedmin=0; $odd_speedmax=0; $odd_ratemin=0; $odd_ratemax=0; $odd_pricemin=0;
$mem_prod=array(); $mem_capmin=0; $mem_capmax=0; $mem_stan=array(); $mem_freqmin=0; $mem_freqmax=0; $mem_type=array(); $mem_latmin=0; $mem_latmax=0; $mem_voltmin=0; $mem_voltmax=0; $mem_misc=array(); $mem_ratemin=0; $mem_ratemax=0;
$mdb_prod=array(); $mdb_model=array(); $mdb_ramcap=array(); $mdb_gpu=array(); $mdb_chip=array(); $mdb_socket=array(); $mdb_interface=array(); $mdb_netw=array(); $mdb_hdd=array(); $mdb_misc=array(); $mdb_ratemin=0; $mdb_ratemax=0; $mdb_wwan=0;
$chassis_prod=array(); $chassis_model=array(); $chassis_thicmin=0; $chassis_thicmax=0; $chassis_depthmin=0; $chassis_depthmax=0; $chassis_widthmin=0; $chassis_widthmax=0; $chassis_color=array(); $chassis_weightmin=0; $chassis_weightmax=0; $chassis_made=array(); $chassis_made[0]="0"; $chassis_ports=array(); $chassis_vports=array(); $chassis_webmin=0; $chassis_webmax=0; $chassis_touch=array(); $chassis_twoinone=array(); $chassis_misc=array(); $chassis_stuff=array(); $chassis_ratemin=0; $chassis_ratemax=0; $chassis_extra_stuff=array();
$pricemin=0; $budgetmax=0; $battery_life=0;
$browse_by=0;
$sortby=array();
$diffpisearch=0;
$diffvisearch=0;
$mdb_list=array(); $mem_list=array(); $shdd_list=array(); $wnet_list=array(); $odd_list=array(); $chassis_list=array();
?>