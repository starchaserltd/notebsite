<?php
/* Quiz SEARCH */
//Initialising some generic values

$cpu_tdpmin = 0.01; $gpu_powermin = 0; $gpu_maxmemmin = 1; //$hdd_capmin = $totalcapmin;
$war_yearsmin = 0.01; $acum_capmin = 0.01; $wnet_ratemin = 0.01; $sist_pricemax = 1;
$odd_speedmin = 0; $mem_capmin = 1; $mdb_ratemin = 0; $chassis_weightmin = 0.01; $addmsc=array(); $regions_name = array(); $display_srgb = 0; $chassis_addpi=array(); $regions=array(); $war_typewar=array();
$totalcapmax = 8192; 
$mdbslots = 0;

$isquiz = 1;
$hdd_type = array();$chassis_made= array(); $chassis_msc=array();
$chassis_ports=array();$gpu_model = array();$cpu_misc = array();
$chassis_vports=array();
$fam_model = array();

// BUDGET val min and max
$budgetmin=2;
if(isset($_GET['qtype'])) { $qsearchtype = strval($_GET['qtype']); } else { $qsearchtype=""; }

$result = mysqli_query($GLOBALS['con'], "SELECT * FROM notebro_site.nomen WHERE type = 18 OR type=21 OR type=22 OR type=33 OR type=34 OR type = 35 OR type = 36 OR type=59 OR type=60 OR type = 61 OR type = 62 OR type=67 OR type=68  OR type =70 OR type=71  OR type =81 ORDER BY type ASC");
while( $row=mysqli_fetch_array($result)){ $nomenvalues[]=$row; }

$cpu_ldatemax = $nomenvalues[0][2];
$cpu_tdpmin = $nomenvalues[1][2];
$cpu_tdpmax = $nomenvalues[2][2];
$totalcapmin = round($nomenvalues[3][2]);
$hdd_capmax = round($nomenvalues[4][2]);
$mem_capmin=round($nomenvalues[5][2]); 
$mem_capmax=round($nomenvalues[6][2]);
$batlife_min=$nomenvalues[7][2];  
$batlife_max=$nomenvalues[8][2];
$gpu_powermin = round($nomenvalues[9][2]);
$gpu_powermax = 0;
$display_vresmin=$nomenvalues[11][2];
$display_vresmax=$nomenvalues[12][2];
$price_min=$nomenvalues[13][2];
$price_max=$nomenvalues[14][2];
$gpu_ldmax = $nomenvalues[15][2]; 

//year selection -2 year for processors
$datecpu = array();
$datecpu = explode("-",$cpu_ldatemax);
$datecpu[0] = $datecpu[0]-2;

$chassis_weightmin = 0;
$size = 0;
$batlife = 0;
$cadratemin="15"; $cadratemax=""; $gameratemin="30"; $gameratemax=""; $wnet_speedmin="150";
$model_minclass=999; $model_maxclass=-1;

//LIST OF COMPONENTS WE WILL FILTER
$to_search = array(
	"model"   => 1,
    "acum"    => 1,  
    "chassis" => 1,
    "cpu"     => 1,
    "display" => 1,
    "gpu"     => 0, 
    "hdd"     => 1,
    "mdb"     => 1,
    "mem"     => 1,
    "odd"     => 0,
    "shdd"    => 0,
    "sist"    => 1,
    "war"     => 1,
    "wnet"    => 0, 
	"regions" => 1
);


if (isset($_GET['casual']) && $_GET['casual']==1 && !(isset($_GET['office'])))
{	$_GET['relax']=1; }

if (isset($_GET['content']) && $_GET['content']==1 && !(isset($_GET['vedit'])))
{	$_GET['lvedit']=1; }

if (isset($_GET['coding']) && $_GET['coding']==1 && !(isset($_GET['vms'])))
{	$_GET['vmnone']=1; }

if (isset($_GET['business']) && $_GET['business']==1 && !(isset($_GET['office'])))
{	$_GET['relax']=1; }

if (isset($_GET['gaming']) && $_GET['gaming']==1 && !(isset($_GET['games'])))
{	$_GET['mmohigh']=1; }

if (isset($_GET['cad3d']) && $_GET['cad3d']==1 && !(isset($_GET['3dmodel'])))
{	$_GET['3dsmaxlight']=1; }

foreach (array("model","cpu", "display", "gpu", "acum", "war", "hdd", "shdd", "wnet", "sist", "odd", "mem", "mdb", "chassis","battery","budget") as $v) 
{
	switch($v)
	{
		case 'model' :
		{		
			$regions_name[]="USA and Canada";
			
			if (isset($_GET['casual']) && $_GET['casual']==1)
			{	if($model_minclass>0) { $model_minclass=0; }  if($model_maxclass<2){ $model_maxclass=1; } } 
			
			if (isset($_GET['content']) && $_GET['content']==1)
			{	if($model_minclass>0) { $model_minclass=0; }  if($model_maxclass<2){ $model_maxclass=1; } } 
		
			if (isset($_GET['coding']) && $_GET['coding']==1)
			{	if($model_minclass>0) { $model_minclass=0; }  if($model_maxclass<3){ $model_maxclass=3; } } 
		
			if (isset($_GET['gaming']) && $_GET['gaming']==1)
			{	if($model_minclass>0) { $model_minclass=0; }  if($model_maxclass<2){ $model_maxclass=1; } } 
		
			if (isset($_GET['cad3d']) && $_GET['cad3d']==1)
			{	if($model_minclass>0) { $model_minclass=0; }  if($model_maxclass<3){ $model_maxclass=3; } }

			if (isset($_GET['business']) && $_GET['business']==1)
			{	$model_minclass=1;  $model_maxclass=3; }		
			break;
		}
		
		case 'cpu':
		{
			$cores=2;
			if (isset($_GET['calc']) && $_GET['calc']==1)
			{	$cpu_turbomin = 3.1; $cpu_misc[]="HT"; $cores=2.5; }
		
			if (isset($_GET['heavybrowsing']) && $_GET['heavybrowsing']==1)
			{	$cpu_turbomin = 3.1; $cpu_misc[]="HT"; $cores=2.5; }
				
			if (isset($_GET['coding']) && $_GET['coding']==1)
			{	if($cores<2) { $cpu_coremin = 2; $cpu_turbomin = 3.1; $cores=2.5;} $cpu_misc[]="HT"; }
		
			if (isset($_GET['vmnone']) && $_GET['vmnone']==1)
			{ }
		
			if (isset($_GET['vmsmall']) && $_GET['vmsmall']==1)
			{	if($cores<2) { $cpu_coremin = 2; $cores=2.5; array_push($cpu_misc,"HT","VT-d/AMD-Vi"); } }
		
			if (isset($_GET['vmmedium']) && $_GET['vmmedium']==1)
			{	if($cores<4) { $cpu_coremin = 4; $cores=4; $cpu_misc=array_diff($cpu_misc,["HT"]); array_push($cpu_misc,"VT-d/AMD-Vi"); } }
		
			if (isset($_GET['vmheavy']) && $_GET['vmheavy']==1)
			{	if($cores<5) { $cpu_coremin = 4; $cores=5; array_push($cpu_misc,"HT","VT-d/AMD-Vi"); } }
		
			if (isset($_GET['lvedit']) && $_GET['lvedit']==1 && $cpu_coremin < 2)
			{	$cpu_coremin = 2;  $cpu_misc[]="HT"; $cores=2.5; }

			if (isset($_GET['hvedit']) && $_GET['hvedit']==1 )
			{	$cpu_coremin = 4;  $cpu_misc[]="HT"; }			
								
			if (isset($_GET['swlight']) && $_GET['swlight']==1  && $cpu_coremin < 2)
			{	$cpu_coremin = 2;  $cpu_misc[]="HT"; $cores=2.5; if($cpu_turbomin<3){ $cpu_turbomin=3; } }

			if (isset($_GET['swmedium']) && $_GET['swmedium']==1 ) 
			{	$cpu_coremin = 4; if($cores>2 && $cores <4) { $cpu_misc=array_diff($cpu_misc,["HT"]); $cores=4;} }
	
			if (isset($_GET['swheavy']) && $_GET['swheavy']==1 )
			{	$cpu_coremin = 4; if($cores>2 && $cores <4) { $cpu_misc=array_diff($cpu_misc,["HT"]); $cores=4;} }
	
			if (isset($_GET['3dsmaxlight']) && $_GET['3dsmaxlight']==1  && $cpu_coremin < 2)
			{	$cpu_coremin = 2;  $cpu_misc[]="HT"; if($cpu_turbomin<3){ $cpu_turbomin=3; } }

			if (isset($_GET['3dsmaxmedium']) && $_GET['3dsmaxmedium']==1) 
			{	$cpu_coremin = 4; if($cores>2 && $cores <4) { $cpu_misc=array_diff($cpu_misc,["HT"]); $cores=4;} }
	
			if (isset($_GET['3dsmaxheavy']) && $_GET['3dsmaxheavy']==1 ) 
			{	$cpu_coremin = 4; if($cores>2 && $cores <4) { $cpu_misc=array_diff($cpu_misc,["HT"]); $cores=4;} }
	
			if (isset($_GET['catialight']) && $_GET['catialight']==1 && $cpu_coremin < 2)
			{	$cpu_coremin = 2;  $cpu_misc[]="HT"; if($cpu_turbomin<3.1){ $cpu_turbomin=3.1; } $cores=2.5; }

			if (isset($_GET['catiamedium']) && $_GET['catiamedium']==1 ) 
			{	$cpu_coremin = 4; if($cores>2 && $cores <4) { $cpu_misc=array_diff($cpu_misc,["HT"]); $cores=4;} }
	
			if (isset($_GET['catiaheavy']) && $_GET['catiaheavy']==1) 
			{	$cpu_coremin = 4; if($cores>2 && $cores <4) { $cpu_misc=array_diff($cpu_misc,["HT"]); $cores=4;} }
	
			if (isset($_GET['rhinolight']) && $_GET['rhinolight']==1  && $cpu_coremin < 2) 
			{	$cpu_coremin = 2;  $cpu_misc[]="HT"; if($cpu_turbomin<3){ $cpu_turbomin=3; } $cores=2.5; }

			if (isset($_GET['rhinomedium']) && $_GET['rhinomedium']==1) 
			{	$cpu_coremin = 4; if($cores>2 && $cores <4) { $cpu_misc=array_diff($cpu_misc,["HT"]); $cores=4;} }
	
			if (isset($_GET['rhinoheavy']) && $_GET['rhinoheavy']==1 ) 
			{	$cpu_coremin = 4; if($cores>2 && $cores <4) { $cpu_misc=array_diff($cpu_misc,["HT"]); $cores=4;} }
	
			if (isset($_GET['cadolight']) && $_GET['cadolight']==1  && $cpu_coremin < 2) 
			{	$cpu_coremin = 2;  $cpu_misc[]="HT"; if($cpu_turbomin<3.1){ $cpu_turbomin=3.1; } $cores=2.5; }

			if (isset($_GET['cadomedium']) && $_GET['cadomedium']==1 ) 
			{	$cpu_coremin = 4; if($cores>2 && $cores <4) { $cpu_misc=array_diff($cpu_misc,["HT"]); $cores=4;} }
	
			if (isset($_GET['cadoheavy']) && $_GET['cadoheavy']==1 ) 
			{	$cpu_coremin = 4; if($cores>2 && $cores <4) { $cpu_misc=array_diff($cpu_misc,["HT"]); $cores=4;} }
			
			$cpu_misc=array_unique($cpu_misc);
			
			break ;
		}
		case 'display' :
		{
			$display_sizemin=0; $display_sizemax=30;
			if ((isset($_GET['desk']) && $_GET['desk']==1)&&(!isset($_GET['bed'])&&!isset($_GET['house'])&&!isset($_GET['lap'])&&!isset($_GET['bage'])))
			{	if($display_sizemin<14) { $display_sizemin =14; }	if($display_sizemax>24) { $display_sizemax =24; } }
		
			if (isset($_GET['bed']) && $_GET['bed']==1) 
			{	if($display_sizemin<13) { $display_sizemin =13; }	if($display_sizemax>16) { $display_sizemax =16; } }
								
			if (isset($_GET['house']) && $_GET['house']==1) 
			{	if($display_sizemin<13) { $display_sizemin =13; }	if($display_sizemax>16) { $display_sizemax =16; } }
													
			if (isset($_GET['lap'])	&& $_GET['lap']==1 ) 
			{ 
				if($display_sizemin<10) { $display_sizemin =10; }	if($display_sizemax>14) { $display_sizemax =14; } 
				if((isset($_GET['oldgamesmedium']) && $_GET['oldgamesmedium']==1) || (isset($_GET['oldgameshigh']) && $_GET['oldgameshigh']==1) || (isset($_GET['mmomedium']) && $_GET['mmomedium']==1) || (isset($_GET['mmohigh']) && $_GET['mmohigh']==1 ) || (isset($_GET['3dgameslow']) && $_GET['3dgameslow']==1) || (isset($_GET['3dgamesmedium']) && $_GET['3dgamesmedium']==1) || (isset($_GET['3dgameshigh']) && $_GET['3dgameshigh']==1) || (isset($_GET['autocadmedium']) && $_GET['autocadmedium']==1) || (isset($_GET['autocadheavy']) && $_GET['autocadheavy']==1) || (isset($_GET['swlight']) && $_GET['swlight']==1) || (isset($_GET['swmedium']) && $_GET['swmedium']==1) ||  (isset($_GET['swheavy']) && $_GET['swheavy']==1) || (isset($_GET['3dsmaxlight']) && $_GET['3dsmaxlight']==1) || (isset($_GET['3dsmaxmedium']) && $_GET['3dsmaxmedium']==1) || (isset($_GET['3dsmaxheavy']) && $_GET['3dsmaxheavy']==1) || (isset($_GET['catialight']) && $_GET['catialight']==1) || (isset($_GET['catiamedium']) && $_GET['catiamedium']==1) || (isset($_GET['catiaheavy']) && $_GET['catiaheavy']==1) || (isset($_GET['rhinolight']) && $_GET['rhinolight']==1) || (isset($_GET['rhinomedium']) && $_GET['rhinomedium']==1) || (isset($_GET['rhinoheavy']) && $_GET['rhinoheavy']==1) || (isset($_GET['cadolight']) && $_GET['cadolight']==1) || (isset($_GET['cadomedium']) && $_GET['cadomedium']==1) || (isset($_GET['cadoheavy']) && $_GET['cadoheavy']==1)) { if($display_sizemax<16) { $display_sizemax =16; } }
			}
								
			if (isset($_GET['bag']) && $_GET['bag']==1) 
			{	if($display_sizemin<13) { $display_sizemin =13; }	if($display_sizemax>16) { $display_sizemax =16; } }
								
			if (isset($_GET['60srgb']) && $_GET['60srgb'] ==1) 
			{	$display_backt = ["LED IPS","LED IPS PenTile","OLED"]; }
																	
			if (isset($_GET['90srgb']) && $_GET['90srgb']==1) 
			{	$display_backt = ["LED IPS","LED IPS PenTile","OLED"]; $display_srgb = 80; }
									
			if (isset($_GET['media'])&& $_GET['media']==1 && !((isset($_GET['60srgb']) && $_GET['60srgb'] ==1) || (isset($_GET['90srgb']) && $_GET['90srgb']==1)) ) 
			{	$display_backt = ["LED IPS","LED IPS PenTile","LED TN WVA","OLED"]; }
		
			if (isset($_GET['FHD'])&& $_GET['FHD']==1 ) 
			{	$display_vresmin = 1080; }
			else
			{	if (isset($_GET['FHDplus'])&& $_GET['FHDplus']==1 ) 
				{	$display_vresmin = 1440; }
			}
			
			if (isset($_GET['ntouch'])&& $_GET['ntouch']==1 ) 
			{	$display_touch[] = "1"; }
							
			if ((isset($_GET['dispxsmall']) && $_GET['dispxsmall']==1 ) || (isset($_GET['dispsmall'])	&& $_GET['dispsmall']==1 ) || (isset($_GET['dispmedium']) && $_GET['dispmedium']==1 ) || (isset($_GET['displarge'])	&& $_GET['displarge']==1 ) )
			{	$display_sizemin=30; $display_sizemax=0; }

			if (isset($_GET['dispxsmall'])	&& $_GET['dispxsmall']==1 ) 
			{	if($display_sizemin>10) { $display_sizemin =10; }	if($display_sizemax<13) { $display_sizemax =13; } }
		
			if (isset($_GET['dispsmall'])	&& $_GET['dispsmall']==1 ) 
			{	if($display_sizemin>13) { $display_sizemin =13; }	if($display_sizemax<14) { $display_sizemax =14; } }
		
			if (isset($_GET['dispmedium'])	&& $_GET['dispmedium']==1 ) 
			{	if($display_sizemin>14) { $display_sizemin =14; }	if($display_sizemax<16) { $display_sizemax =16; } }

			if (isset($_GET['displarge'])	&& $_GET['displarge']==1 ) 
			{	if($display_sizemin>17) { $display_sizemin =17; }	if($display_sizemax<24) { $display_sizemax =24; } }

			$display_backt=array_unique($display_backt);
		
			break ;
		}
		case 'mem' :
		{   
			if (isset($_GET['heavybrowsing']) && $_GET['heavybrowsing']==1)
			{	$mem_capmin = 4; }
		
			if (isset($_GET['oldgameslow']) && $_GET['oldgameslow']==1 && $mem_capmin < 4) 
			{	$mem_capmin = 4; }
																	
			if (isset($_GET['oldgamesmedium']) && $_GET['oldgamesmedium']==1 && $mem_capmin < 8) 
			{	$mem_capmin = 8; }
																						
			if (isset($_GET['oldgameshigh']) && $_GET['oldgameshigh']==1 && $mem_capmin < 8) 
			{	$mem_capmin = 8; }
																
			if (isset($_GET['mmolow']) && $_GET['mmolow']==1 && $mem_capmin < 8) 
			{	$mem_capmin = 8; }
																
			if (isset($_GET['mmomedium']) && $_GET['mmomedium']==1 && $mem_capmin < 8) 
			{	$mem_capmin = 8; }
																						
			if (isset($_GET['mmohigh']) && $_GET['mmohigh']==1 && $mem_capmin < 8) 
			{	$mem_capmin = 8; }
													
			if (isset($_GET['3dgameslow']) && $_GET['3dgameslow']==1 && $mem_capmin < 16) 
			{	$mem_capmin = 16; }
														
			if (isset($_GET['3dgamesmedium']) && $_GET['3dgamesmedium']==1 && $mem_capmin < 16) 
			{	$mem_capmin = 16; }
																						
			if (isset($_GET['3dgameshigh']) && $_GET['3dgameshigh']==1 && $mem_capmin < 16) 
			{	$mem_capmin = 16; }
									
			if (isset($_GET['calc']) && $_GET['calc']==1 && $mem_capmin < 4) 
			{	$mem_capmin = 4; }

			if (isset($_GET['coding']) && $_GET['coding']==1 && $mem_capmin < 8) 
			{	$mem_capmin = 8; }
		
			if (isset($_GET['vmnone']) && $_GET['vmnone']==1)
			{	}
									
			if (isset($_GET['vmsmall']) && $_GET['vmsmall']==1)
			{	if($mem_capmin<8) { $mem_capmin=8; } }
		
			if (isset($_GET['vmedium']) && $_GET['vmmedium']==1)
			{	if($mem_capmin<16) { $mem_capmin=16; } }
		
			if (isset($_GET['vmheavy']) && $_GET['vmheavy']==1)
			{	if($mem_capmin<32) { $mem_capmin=32; } }
			
			if (isset($_GET['autocadmedium']) && $_GET['autocadmedium']==1 && $mem_capmin < 8) 
			{	$mem_capmin = 8; }
		
			if (isset($_GET['autocadheavy']) && $_GET['autocadheavy']==1 && $mem_capmin < 16) 
			{	$mem_capmin = 16; }
		
			if (isset($_GET['swlight']) && $_GET['swlight']==1 && $mem_capmin < 8) 
			{	$mem_capmin = 8; }

			if (isset($_GET['swmedium']) && $_GET['swmedium']==1 && $mem_capmin < 16) 
			{	$mem_capmin = 16; }
		
			if (isset($_GET['swheavy']) && $_GET['swheavy']==1 && $mem_capmin < 16) 
			{	$mem_capmin = 16; }
		
			if (isset($_GET['3dsmaxlight']) && $_GET['3dsmaxlight']==1 && $mem_capmin < 8) 
			{	$mem_capmin = 8; }

			if (isset($_GET['3dsmaxmedium']) && $_GET['3dsmaxmedium']==1 && $mem_capmin < 16) 
			{	$mem_capmin = 16; }
		
			if (isset($_GET['3dsmaxheavy']) && $_GET['3dsmaxheavy']==1 && $mem_capmin < 16) 
			{	$mem_capmin = 16; }
		
			if (isset($_GET['catialight']) && $_GET['catialight']==1 && $mem_capmin < 8) 
			{	$mem_capmin = 8; }

			if (isset($_GET['rhinolight']) && $_GET['rhinolight']==1 && $mem_capmin < 8) 
			{	$mem_capmin = 8; }

			if (isset($_GET['rhinomedium']) && $_GET['rhinomedium']==1 && $mem_capmin < 16) 
			{	$mem_capmin = 16; }
		
			if (isset($_GET['rhinoheavy']) && $_GET['rhinoheavy']==1 && $mem_capmin < 16) 
			{	$mem_capmin = 16; }
		
			if (isset($_GET['cadolight']) && $_GET['cadolight']==1 && $mem_capmin < 8) 
			{	$mem_capmin = 8; }       
		
			break ;
		}				
		case 'hdd' :
		{
			$hdd_type=["SSD"];
			if (isset($_GET['3dgameslow']) && $_GET['3dgameslow']==1 && $totalcapmin < 500) 
			{	$totalcapmin = 500;	}
											
			if (isset($_GET['3dgamesmedium']) && $_GET['3dgamesmedium']==1 && $totalcapmin < 500) 
			{	$totalcapmin = 500; }
											
			if (isset($_GET['3dgameshigh']) && $_GET['3dgameshigh']==1 && $totalcapmin < 500) 
			{	$totalcapmin = 500; }
										
			if (isset($_GET['60srgb']) && $_GET['60srgb']==1 && $totalcapmin < 200) 
			{	$totalcapmin = 200; }
																		
			if (isset($_GET['90srgb']) && $_GET['90srgb']==1 && $totalcapmin < 500) 
			{	$totalcapmin = 500; }
																											
			if (isset($_GET['lvedit']) && $_GET['lvedit']==1 && $totalcapmin < 200) 
			{	$totalcapmin = 200;	}
																	
			if (isset($_GET['hvedit']) && $_GET['hvedit']==1 && $totalcapmin < 1000) 
			{	$totalcapmin = 1000; }
		
			if (isset($_GET['swlight']) && $_GET['swlight']==1 && $totalcapmin < 500) 
			{	$totalcapmin = 500; }

			if (isset($_GET['swmedium']) && $_GET['swmedium']==1 && $totalcapmin < 500) 
			{	$totalcapmin = 500; }
		
			if (isset($_GET['swheavy']) && $_GET['swheavy']==1 && $totalcapmin < 500) 
			{	$totalcapmin = 500; }
		
			if (isset($_GET['3dsmaxlight']) && $_GET['3dsmaxlight']==1 && $totalcapmin < 500) 
			{	$totalcapmin = 500; }

			if (isset($_GET['3dsmaxmedium']) && $_GET['3dsmaxmedium']==1 && $totalcapmin < 500) 
			{	$totalcapmin = 500; }
		
			if (isset($_GET['3dsmaxheavy']) && $_GET['3dsmaxheavy']==1 && $totalcapmin < 500) 
			{	$totalcapmin = 500; }
		
			if (isset($_GET['catialight']) && $_GET['catialight']==1 && $totalcapmin < 500) 
			{	$totalcapmin = 500; }

			if (isset($_GET['catiamedium']) && $_GET['catiamedium']==1 && $totalcapmin < 500) 
			{	$totalcapmin = 500; }
		
			if (isset($_GET['catiaheavy']) && $_GET['catiaheavy']==1 && $totalcapmin < 500) 
			{	$totalcapmin = 500; }
		
			if (isset($_GET['rhinolight']) && $_GET['rhinolight']==1 && $totalcapmin < 500) 
			{	$totalcapmin = 500; }

			if (isset($_GET['rhinomedium']) && $_GET['rhinomedium']==1 && $totalcapmin < 500) 
			{	$totalcapmin = 500; }
		
			if (isset($_GET['rhinoheavy']) && $_GET['rhinoheavy']==1 && $totalcapmin < 500) 
			{	$totalcapmin = 500; }
		
			if (isset($_GET['cadolight']) && $_GET['cadolight']==1 && $totalcapmin < 500) 
			{	$totalcapmin = 500; }

			if (isset($_GET['cadomedium']) && $_GET['cadomedium']==1 && $totalcapmin < 500) 
			{	$totalcapmin = 500; }
		
			if (isset($_GET['cadoheavy']) && $_GET['cadoheavy']==1 && $totalcapmin < 500) 
			{	$totalcapmin = 500; }
		
			break ;	
		}	
		
		case 'shdd' :
		{   
			if (isset($_GET['shdd']) && $_GET['shdd']==1) 
			{	$to_search['shdd'] = 1; $nr_hdd=2; }
		
			break ;	
		}
	
		case 'gpu' :
		{
			if($model_maxclass>=2) {  array_push($gpu_typelist,"3"); }
			$quiz_mingputype=0; $gpu_typelist=array("-1");
			if (isset($_GET['oldgameslow']) && $_GET['oldgameslow']==1) 
			{	array_push($gpu_typelist,"0","1"); if($quiz_mingputype<0) { $quiz_mingputype=0; } $to_search["gpu"]=1; }
																	
			if (isset($_GET['oldgamesmedium']) && $_GET['oldgamesmedium']==1) 
			{	if($quiz_mingputype<1) { $quiz_mingputype=1; } if($gpu_powermin<15) { $gpu_powermin = 15; } array_push($gpu_typelist,"1"); $to_search["gpu"]=1; }
																							
			if (isset($_GET['oldgameshigh']) && $_GET['oldgameshigh']==1) 
			{	if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2"); if($gpu_powermin<40) { $gpu_powermin = 40; } $to_search["gpu"]=1; }
											
			if (isset($_GET['mmolow']) && $_GET['mmolow']==1) 
			{	if($quiz_mingputype<0) { $quiz_mingputype=0; } array_push($gpu_typelist,"0","1"); $to_search["gpu"]=1; }
											
			if (isset($_GET['mmomedium']) && $_GET['mmomedium']==1) 
			{	if($gpu_powermin<36) { $gpu_powermin = 36; } if($gpu_powermax<69) { $gpu_powermax = 69; } if($model_maxclass>1 && $gpu_powermax<500) { $gpu_powermax=500; } if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2"); $to_search["gpu"]=1; }
											
			if (isset($_GET['mmohigh']) && $_GET['mmohigh']==1 ) 
			{	if($gpu_powermin<59) { $gpu_powermin = 59; } $to_search["gpu"]=1; if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","4"); $gpu_ldmin=gmdate("Y-01-01",time()-31536000*1.5 ); }
										
			if (isset($_GET['3dgameslow']) && $_GET['3dgameslow']==1) 
			{	if($gpu_powermin<30) { $gpu_powermin = 30; } if($gpu_powermax<69) { $gpu_powermax = 69; } $to_search["gpu"]=1; if($quiz_mingputype<2) { $quiz_mingputype=1; } array_push($gpu_typelist,"1","2"); $gpu_ldmin=gmdate("Y-01-01",time()-31536000*2 ); $gpu_arch=["Maxwell","Pascal","GCN 1.2","GCN 1.3"];  }
																	
			if (isset($_GET['3dgamesmedium']) && $_GET['3dgamesmedium']==1) 
			{	if($gpu_powermin<59) { $gpu_powermin = 59; } $to_search["gpu"]=1; if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","4");  $gpu_ldmin=gmdate("Y-01-01",time()-31536000*1.5 ); }
															
			if (isset($_GET['3dgameshigh']) && $_GET['3dgameshigh']==1) 
			{	$gpu_typelist[] = 4; $to_search["gpu"]=1; if($quiz_mingputype<4) { $quiz_mingputype=4; } array_push($gpu_typelist,"4");  $gpu_ldmin=gmdate("Y-m-d",time()-31536000*1.5 ); }
						
			$cadratemin=0; $cadratemax=0; $gameratemin=0; $gameratemax=0;
			
			if (isset($_GET['autocadlight']) && $_GET['autocadlight']==1) 
			{	$gpu_typelist[] = 0; $gpu_typelist[] = 1; $gpu_typelist[] = 3; $gpu_powermax = 36; $to_search["gpu"]=1; }

			if (isset($_GET['autocadmedium']) && $_GET['autocadmedium']==1) 
			{	if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2"); if($cadratemin<15) { $cadratemin=15; } if($cadratemax<25) { $cadratemax=25; } if ($gameratemin<24) { $gameratemin=24; } if($gameratemax<50) { $gameratemax=50; }	$to_search["gpu"]=1; }
		
			if (isset($_GET['autocadheavy']) && $_GET['autocadheavy']==1) 
			{	if($cadratemin<20) { $cadratemin=20; } if($cadratemax<35) { $cadratemax=35; } if ($gameratemin<40) { $gameratemin=40; } if($gameratemax<65) { $gameratemax=65; }	if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","4"); $to_search["gpu"]=1; }
		
			if (isset($_GET['swlight']) && $_GET['swlight']==1) 
			{	if($cadratemin<10) { $cadratemin=10; } if($cadratemax<30) { $cadratemax=30; } if ($gameratemin<24) { $gameratemin=24; } if($gameratemax<50) { $gameratemax=50; }	if($quiz_mingputype<2) { $quiz_mingputype=2; }; if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2"); $to_search["gpu"]=1; }

			if (isset($_GET['swmedium']) && $_GET['swmedium']==1) 
			{	if($cadratemin<30) { $cadratemin=30; } if($cadratemax<50) { $cadratemax=50; } if ($gameratemin<45) { $gameratemin=45; } if($gameratemax<65) { $gameratemax=65; }	if($quiz_mingputype<2) { $quiz_mingputype=2; } if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","4"); $to_search["gpu"]=1; }
		
			if (isset($_GET['swheavy']) && $_GET['swheavy']==1) 
			{	if($cadratemin<50) { $cadratemin=50; }  if($cadratemax<200) { $cadratemax=200; } if ($gameratemin<90) { $gameratemin=1000; } if($gameratemax<200) { $gameratemax=200; } if($quiz_mingputype<3) { $quiz_mingputype=3; } array_push($gpu_typelist,"4"); $to_search["gpu"]=1; }
		
			if (isset($_GET['3dsmaxlight']) && $_GET['3dsmaxlight']==1) 
			{	if($cadratemin<20) { $cadratemin=20; } if($cadratemax<35) { $cadratemax=35; } if ($gameratemin<30) { $gameratemin=30; } if($gameratemax<60) { $gameratemax=60; } if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","4"); $to_search["gpu"]=1; }

			if (isset($_GET['3dsmaxmedium']) && $_GET['3dsmaxmedium']==1) 
			{	if($cadratemin<35) { $cadratemin=35; } if($cadratemax<60) { $cadratemax=60; } if ($gameratemin<60) { $gameratemin=60; } if($gameratemax<80) { $gameratemax=80; } if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","4"); $to_search["gpu"]=1; }
		
			if (isset($_GET['3dsmaxheavy']) && $_GET['3dsmaxheavy']==1) 
			{	if($cadratemin<60) { $cadratemin=60; } if($cadratemax<200) { $cadratemax=200; } if ($gameratemin<90) { $gameratemin=90; } if($gameratemax<200) { $gameratemax=200; } if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","4"); $to_search["gpu"]=1; }
		
			if (isset($_GET['catialight']) && $_GET['catialight']==1) 
			{	if($cadratemin<25) { $cadratemin=25; } if($cadratemax<35) { $cadratemax=35; } if ($gameratemin<48) { $gameratemin=48; } if($gameratemax<70) { $gameratemax=70; } if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","4"); $to_search["gpu"]=1; }

			if (isset($_GET['catiamedium']) && $_GET['catiamedium']==1) 
			{	if($cadratemin<35) { $cadratemin=35; } if($cadratemax<60) { $cadratemax=60; } if ($gameratemin<70) { $gameratemin=70; } if($gameratemax<200) { $gameratemax=200; } if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","4"); $to_search["gpu"]=1; }
		
			if (isset($_GET['catiaheavy']) && $_GET['catiaheavy']==1) 
			{	if($cadratemin<60) { $cadratemin=60; }  if($cadratemax<200) { $cadratemax=200; }  if ($gameratemin<1000) { $gameratemin=1000; } if($gameratemax<200) { $gameratemax=200; } if($quiz_mingputype<3) { $quiz_mingputype=3; } array_push($gpu_typelist,"2","4"); $to_search["gpu"]=1; }
		
			if (isset($_GET['rhinolight']) && $_GET['rhinolight']==1) 
			{	if($cadratemin<20) { $cadratemin=20; } if($cadratemax<35) { $cadratemax=35; } if ($gameratemin<30) { $gameratemin=30; } if($gameratemax<60) { $gameratemax=60; } if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","4"); $to_search["gpu"]=1; }

			if (isset($_GET['rhinomedium']) && $_GET['rhinomedium']==1) 
			{	if($cadratemin<35) { $cadratemin=35; } if($cadratemax<60) { $cadratemax=60; } if ($gameratemin<48) { $gameratemin=48; } if($gameratemax<80) { $gameratemax=80; } if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","4"); $to_search["gpu"]=1; }
		
			if (isset($_GET['rhinoheavy']) && $_GET['rhinoheavy']==1) 
			{	if($cadratemin<60) { $cadratemin=60; } if($cadratemax<200) { $cadratemax=200; }  if ($gameratemin<1000) { $gameratemin=90; } if($gameratemax<200) { $gameratemax=200; } if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"4"); $to_search["gpu"]=1; }
		
			if (isset($_GET['cadolight']) && $_GET['cadolight']==1) 
			{	if($cadratemin<25) { $cadratemin=25; } if($cadratemax<35) { $cadratemax=35; } if ($gameratemin<48) { $gameratemin=48; } if($gameratemax<70) { $gameratemax=70; }  if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","4"); $to_search["gpu"]=1; }
			
			if (isset($_GET['cadomedium']) && $_GET['cadomedium']==1) 
			{	if($cadratemin<30) { $cadratemin=30; } if($cadratemax<60) { $cadratemax=60; } if ($gameratemin<70) { $gameratemin=70; }if($gameratemax<200) { $gameratemax=200; }  if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","4"); $to_search["gpu"]=1; }
		
			if (isset($_GET['cadoheavy']) && $_GET['cadoheavy']==1) 
			{	if($cadratemin<60) { $cadratemin=60; } if($cadratemax<200) { $cadratemax=200; }  if ($gameratemin<1000) { $gameratemin=1000; } if($gameratemax<200) { $gameratemax=200; }   if($quiz_mingputype<3) { $quiz_mingputype=3; } $to_search["gpu"]=1; }

			if($to_search["gpu"]) {	$gpu_typelist=array_unique($gpu_typelist); for($i=0;$i<=$quiz_mingputype;$i++) { array_diff($gpu_typelist,array(strval($i))); } }
			
			if($cadratemin!==0)
			{	
				$addgaming="";
				if (isset($_GET['gaming']) && $_GET['gaming']==1) { if($gpu_powermax<1){$gpu_powermax=999999;} $addgaming=" AND (power>=".$gpu_powermin." AND power<=".$gpu_powermax.")"; }
				$query = "SELECT DISTINCT model FROM notebro_db.GPU WHERE (rating>=".$cadratemin." AND rating<=".$cadratemax." AND typegpu=3) OR (rating>=".$gameratemin." AND rating<=".$gameratemax.$addgaming." AND typegpu IN (".implode(",",$gpu_typelist)."))";
				$result = mysqli_query($GLOBALS['con'],$query);
				array_push($gpu_typelist,"3");
				while($row=mysqli_fetch_row($result)){$gpu_model[]=$row[0];}
				if(count($gpu_model)<1)
				{
					if(isset($_GET['gaming']) && $_GET['gaming']==1)
					{
						if($gamerating<$gpu_powermin)
						{ $query = "SELECT DISTINCT model FROM notebro_db.GPU WHERE (".$addgaming." AND typegpu IN (1,2,3,4))"; }
						else
						{ $query = "SELECT DISTINCT model FROM notebro_db.GPU WHERE (rating>=".$cadratemin." AND rating<=".$cadratemax." AND typegpu=3) OR (rating>=".$gameratemin." AND rating<=".$gameratemax." AND typegpu IN (".implode(",",$gpu_typelist)."))"; }
						
						$result = mysqli_query($GLOBALS['con'],$query);
						array_push($gpu_typelist,"3");
						while($row=mysqli_fetch_row($result)){$gpu_model[]=$row[0];}
						if(count($gpu_model)<1){ $gpu_typelist=["10"]; }
					}
					else
					{
						$gpu_typelist=["10"]; 
					}
				}
			}
			if(!$to_search["gpu"]) { if($quiz_mingputype<1) { $quiz_mingputype=0; } array_push($gpu_typelist,"0","1"); if($model_maxclass>=2) { $gpu_powermax=36; }; $to_search["gpu"]=1; } 
			$gpu_typelist=array_unique($gpu_typelist);
			break ;
		}
		
		case 'wnet' :
		{  
			$to_search["wnet"] = 1;
			break ;	
		}
		
		case 'odd' :
		{
			if (isset($_GET['odd']) && $_GET['odd']==1) 
			{ $odd_type=["DVD-RW","BD-ROM","BD-RW","Modular bay","DVD-ROM"]; $to_search["odd"] = 1; }
            break ;
		}
		
		case 'mdb' :
		{	
			if ((isset($_GET['casual']) && $_GET['casual']==1)||(isset($_GET['content']) && $_GET['content']==1)||(isset($_GET['gaming']) && $_GET['gaming']==1)||(isset($_GET['coding']) && $_GET['coding']==1))
			{	$mdb_wwan=1; }
			
			if ((isset($_GET['business']) && $_GET['business']==1)||(isset($_GET['cad3d']) && $_GET['cad3d']==1))
			{	$mdb_wwan=0; }
            
			break ;	
		}	
		case 'chassis' :
		{
			$chassis_weightmax=999999; $chassis_thicmax=999999;
			
			if (isset($_GET['desk']) && $_GET['desk']==1) 
			{	if($chassis_weightmax>20) { $chassis_weightmax = 20; } if($chassis_thicmax>200){ $chassis_thicmax = 200;} }
			
			if (isset($_GET['bed']) && $_GET['bed']==1) 
			{	if($chassis_weightmax>2.35) { $chassis_weightmax = 2.35; } if($chassis_thicmax>27){ $chassis_thicmax = 27;}}
 									
			if (isset($_GET['house']) && $_GET['house']==1) 
			{	if($chassis_weightmax>2.8) { $chassis_weightmax = 2.8; } if($chassis_thicmax>31){ $chassis_thicmax = 31;} }
											
		    if (isset($_GET['lap']) && $_GET['lap']==1) 
			{	if($chassis_weightmax>2.1) { $chassis_weightmax = 2.1; } if($chassis_thicmax>24){ $chassis_thicmax = 24;} }
									
			if (isset($_GET['bag']) && $_GET['bag']==1) 
			{ 
				if(isset($_GET['displarge']) && $_GET['displarge']==1)
				{	if($chassis_weightmax>3.6) { $chassis_weightmax = 3.6; } if($chassis_thicmax>37){ $chassis_thicmax = 37;} }
				else
				{	if($chassis_weightmax>2.9) { $chassis_weightmax = 2.9; } if($chassis_thicmax>35){ $chassis_thicmax = 35;} }
			}
		
			if (isset($_GET['metal']) && $_GET['metal']==1 ) 
			{	$chassis_made[] = "Metal"; 	$chassis_made[] = "Aluminium"; 	$chassis_made[] = "Lithium";  $chassis_made[] = "Carbon"; $chassis_made[] = "Magnesium"; $chassis_made[] = "Glass fiber"; $chassis_made[] = "Shock-absorbing ultra-polymer";}		
			
			if (isset($_GET['media']) && $_GET['media']==1) 
			{	$chassis_vports[] = "HDMI"; $diffvisearch=2;} 
			
			if (isset($_GET['stylus']) && $_GET['stylus']==1) 
			{	$chassis_stuff[] = "stylus";} 
		
			if (isset($_GET['convertible']) && $_GET['convertible']==1 ) 
			{	$chassis_twoinone = 1;	}
		
			if (isset($_GET['comm']) && $_GET['comm']==1 ) 
			{	$chassis_webmin = 0.92;	$chassis_stuff[]="Microphone array";}

			if(isset($chassis_made) && count($chassis_made)>0) { $chassis_made=array_unique($chassis_made); }
			
			break ;	
		}
		
		case 'acum' :
		{
			//$to_search["acum"] = 1;
			break ;
		}
	
		case 'war' :
		{   
			$to_search["war"] = 1;
			$war_typewar=["1","2"];
			break ;	
		}
		
		case 'sist' :
		{
			if ((isset($_GET['casual']) && $_GET['casual']==1)||(isset($_GET['content']) && $_GET['content']==1)||(isset($_GET['gaming']) && $_GET['gaming']==1))
			{	$sist_sist=["Windows+Home","Windows+S"]; if($model_maxclass>=2) {  $sist_sist[]="Windows+Pro"; } }
		
		     if ((isset($_GET['business']) && $_GET['business']==1)||(isset($_GET['cad3d']) && $_GET['cad3d']==1)||(isset($_GET['coding']) && $_GET['coding']==1))
			{	$sist_sist=["Windows+Home","Windows+Pro"]; $sist_sist=array_diff($sist_sist,["Windows+S"]); }

			break ;	
		}	
		
		case 'battery' :
		{
			if (isset($_GET['2hour']) && $_GET['2hour']==1) 
			{	$batlife_min = 0.9; }
			
			if (isset($_GET['6hour']) && $_GET['6hour']==1) 
			{	$batlife_min = 2.7; }
		
			if (isset($_GET['10hour']) && $_GET['10hour']==1) 
			{	$batlife_min = 4.9; }
		
			if (isset($_GET['12hour']) && $_GET['12hour']==1) 
			{	$batlife_min = 7.5; }
			break ;	
		}
		
		case 'budget' :
		{
			if($qsearchtype!="p" && $qsearchtype!="b"){ $budgetmin=99999999; $budgetmax=0; }
			if (isset($_GET['b500']) && $_GET['b500']==1)
			{	if(isset($budgetmin) && $budgetmin>169) { $budgetmin=169; } if(isset($budgetmax) && $budgetmax<500) { $budgetmax=505; } }
			
			if (isset($_GET['b750']) && $_GET['b750']==1) 
			{	if(isset($budgetmin) && $budgetmin>480) { $budgetmin=480; } if(isset($budgetmax) && $budgetmax<790) { $budgetmax=790; } }
		
			if (isset($_GET['b1000']) && $_GET['b1000']==1)
			{	if(isset($budgetmin) && $budgetmin>740) { $budgetmin=740; } if(isset($budgetmax) && $budgetmax<1085) { $budgetmax=1085; } }
		
			if (isset($_GET['b1500']) && $_GET['b1500']==1)
			{	if(isset($budgetmin) && $budgetmin>950) { $budgetmin=950; } if(isset($budgetmax) && $budgetmax<1635) { $budgetmax=1635; } }
		
			if (isset($_GET['b2000']) && $_GET['b2000']==1)
			{	if(isset($budgetmin) && $budgetmin>1425) { $budgetmin=1425; } if(isset($budgetmax) && $budgetmax<2179) { $budgetmax=2179; } }
		
			if (isset($_GET['b3000']) && $_GET['b3000']==1)
			{	if(isset($budgetmin) && $budgetmin>1850) { $budgetmin=1850; } if(isset($budgetmax) && $budgetmax<8000) { $budgetmax=99999; } }
			$budgetmin=$budgetmin-1;
			$budgetmax=$budgetmax+1;
			break ;	
		}
	}
}

/* some adjustments based on budget*/
if($qsearchtype!=="p" && $qsearchtype!=="b")
{
	if($budgetmax<1100)
	{ 
		if($totalcapmin>200) { $totalcapmin/=2; } 
	}
	
	if($budgetmax>800)
	{
		$sist_sist[]="macOS";
		if(count($display_backt)<1) { $display_backt = ["LED IPS","LED IPS PenTile","LED TN WVA","OLED"]; }
		if($display_vresmin<1080) { $display_vresmin=1080; }
		if($totalcapmin<179) { $totalcapmin =180; }
		if($mem_capmin<8){$mem_capmin=8;}
		
		if($budgetmax>2100)
		{	}
	}
	else
	{
		$sist_sist[]="Chrome OS";

		if($budgetmax>506)
		{ 
			$totalcapmin=100;
			if($to_search["gpu"] && $quiz_mingputype>1 ) { $hdd_type=["HDD","SSD"]; }
			if($display_vresmin<1080) { $display_vresmin=1080; }
		}
		else
		{
			$hdd_type=[];
		}
	}
}
else
{
	$sist_sist[]="macOS"; $sist_sist[]="Chrome OS"; 
}
$sist_sist=array_unique($sist_sist);
?>