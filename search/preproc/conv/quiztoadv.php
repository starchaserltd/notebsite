<?php
require_once("../search/proc/init.php");
if(isset($_GET['qtype'])) { $qsearchtype = strval($_GET['qtype']); } else { $qsearchtype=""; }
$result = mysqli_query($GLOBALS['con'], "SELECT * FROM notebro_site.nomen WHERE type = 18 OR type=21 OR type=22 OR type=33 OR type=34 OR type = 35 OR type = 36 OR type=59 OR type=60  OR type = 61 OR type = 62 OR type=67 OR type=68  OR type =70 OR type=71  OR type =81 ORDER BY type ASC");
while( $row=mysqli_fetch_array($result)){ $nomenvalues[]=$row; }

$totalcapmin = round($nomenvalues[3][2]);
$totalcapmax = round($nomenvalues[4][2]);

$cpucoremin=1; $to_search["gpu"]=0; $memcapmin=2; $mdbslots=-1; $gpupowermin=0; $gpupowermax=500; $displayvresmax=99999; $displayvresmin=0; $waryearsmin=1; $waryearsset=true;

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

//REGIONAL Conditions
$regions_name[]="United States";
if(isset($_SESSION['exchcode'])&&$_SESSION['exchcode']!="USD")
{ $regions_name=explode(",",$_SESSION['dregion']); }

// Laptop Class Conditions
$model_minclass=999; $model_maxclass=-1;
if (isset($_GET['casual']) && $_GET['casual']==1)
{	if($model_minclass>0) { $model_minclass=0; }  if($model_maxclass<2){ $model_maxclass=1; } } 

if (isset($_GET['content']) && $_GET['content']==1)
{	if($model_minclass>0) { $model_minclass=0; }  if($model_maxclass<3){ $model_maxclass=3; } if (isset($_GET['gaming']) && $_GET['gaming']==1) {$model_maxclass=3;} } 

if (isset($_GET['coding']) && $_GET['coding']==1)
{	if($model_minclass>0) { $model_minclass=0; }  if($model_maxclass<3){ $model_maxclass=3; } } 

if (isset($_GET['gaming']) && $_GET['gaming']==1)
{	if($model_minclass>0) { $model_minclass=0; }  if($model_maxclass<2){ $model_maxclass=1; } } 

if (isset($_GET['cad3d']) && $_GET['cad3d']==1)
{	if($model_minclass>0) { $model_minclass=0; }  if($model_maxclass<3){ $model_maxclass=3; } }

if (isset($_GET['business']) && $_GET['business']==1)
{	$model_minclass=1;  $model_maxclass=3; }	

// CPU Conditions
$cores=1.5;
if (isset($_GET['calc']) && $_GET['calc']==1)
{	$cpufreqmin = 3.1; $cpu_misc[]="Multithreading"; $cores=2.5; }
	
if (isset($_GET['heavybrowsing']) && $_GET['heavybrowsing']==1)
{	$cpufreqmin = 3.1; $cpu_misc[]="Multithreading"; $cores=2.5; }
	
if (isset($_GET['coding']) && $_GET['coding']==1)
{	if($cores<2) { $cpucoremin = 2; $cpufreqmin = 3.1; $cores=2.5;} $cpu_misc[]="Multithreading"; }

if (isset($_GET['vmnone']) && $_GET['vmnone']==1)
{	}

if (isset($_GET['vmsmall']) && $_GET['vmsmall']==1)
{	if($cores<2) { $cpucoremin = 2; $cores=2.5; array_push($cpu_misc,"Multithreading","VT-d/AMD-Vi"); } }

if (isset($_GET['vmmedium']) && $_GET['vmmedium']==1)
{	if($cores<4) { $cpucoremin = 4; $cores=4; $cpu_misc=array_diff($cpu_misc,["Multithreading"]); array_push($cpu_misc,"VT-d/AMD-Vi"); } }

if (isset($_GET['vmheavy']) && $_GET['vmheavy']==1)
{	if($cores<5) { $cpucoremin = 4; $cores=5; array_push($cpu_misc,"Multithreading","VT-d/AMD-Vi"); } }

if (isset($_GET['lvedit']) && $_GET['lvedit']==1 && $cpucoremin < 2)
{	$cpucoremin = 2;  $cpu_misc[]="Multithreading"; $cores=2.5; }

if (isset($_GET['hvedit']) && $_GET['hvedit']==1 )
{	$cpucoremin = 4;  $cpu_misc[]="Multithreading"; }			
					
if (isset($_GET['swlight']) && $_GET['swlight']==1  && $cpucoremin < 2)
{	$cpucoremin = 2;  $cpu_misc[]="Multithreading"; $cores=2.5; if($cpufreqmin<3){ $cpufreqmin=3; } }

if (isset($_GET['swmedium']) && $_GET['swmedium']==1 ) 
{	$cpucoremin = 4; if($cores>2 && $cores <4) { $cpu_misc=array_diff($cpu_misc,["Multithreading"]); $cores=4;} }

if (isset($_GET['swheavy']) && $_GET['swheavy']==1 )
{	$cpucoremin = 4; if($cores>2 && $cores <4) { $cpu_misc=array_diff($cpu_misc,["Multithreading"]); $cores=4;} }

if (isset($_GET['3dsmaxlight']) && $_GET['3dsmaxlight']==1  && $cpucoremin < 2)
{	$cpucoremin = 2;  $cpu_misc[]="Multithreading"; if($cpufreqmin<3){ $cpufreqmin=3; } }

if (isset($_GET['3dsmaxmedium']) && $_GET['3dsmaxmedium']==1) 
{	$cpucoremin = 4; if($cores>2 && $cores <4) { $cpu_misc=array_diff($cpu_misc,["Multithreading"]); $cores=4;} }

if (isset($_GET['3dsmaxheavy']) && $_GET['3dsmaxheavy']==1 ) 
{	$cpucoremin = 4; if($cores>2 && $cores <4) { $cpu_misc=array_diff($cpu_misc,["Multithreading"]); $cores=4;} }

if (isset($_GET['catialight']) && $_GET['catialight']==1 && $cpucoremin < 2)
{	$cpucoremin = 2;  $cpu_misc[]="Multithreading"; if($cpufreqmin<3.1){ $cpufreqmin=3.1; } $cores=2.5; }

if (isset($_GET['catiamedium']) && $_GET['catiamedium']==1 ) 
{	$cpucoremin = 4; if($cores>2 && $cores <4) { $cpu_misc=array_diff($cpu_misc,["Multithreading"]); $cores=4;} }

if (isset($_GET['catiaheavy']) && $_GET['catiaheavy']==1) 
{	$cpucoremin = 4; if($cores>2 && $cores <4) { $cpu_misc=array_diff($cpu_misc,["Multithreading"]); $cores=4;} }

if (isset($_GET['rhinolight']) && $_GET['rhinolight']==1  && $cpucoremin < 2) 
{	$cpucoremin = 2;  $cpu_misc[]="Multithreading"; if($cpufreqmin<3){ $cpufreqmin=3; } $cores=2.5; }

if (isset($_GET['rhinomedium']) && $_GET['rhinomedium']==1) 
{	$cpucoremin = 4; if($cores>2 && $cores <4) { $cpu_misc=array_diff($cpu_misc,["Multithreading"]); $cores=4;} }

if (isset($_GET['rhinoheavy']) && $_GET['rhinoheavy']==1 ) 
{	$cpucoremin = 4; if($cores>2 && $cores <4) { $cpu_misc=array_diff($cpu_misc,["Multithreading"]); $cores=4;} }

if (isset($_GET['cadolight']) && $_GET['cadolight']==1  && $cpucoremin < 2) 
{	$cpucoremin = 2;  $cpu_misc[]="Multithreading"; if($cpufreqmin<3.1){ $cpufreqmin=3.1; } $cores=2.5; }

if (isset($_GET['cadomedium']) && $_GET['cadomedium']==1 ) 
{	$cpucoremin = 4; if($cores>2 && $cores <4) { $cpu_misc=array_diff($cpu_misc,["Multithreading"]); $cores=4;} }

if (isset($_GET['cadoheavy']) && $_GET['cadoheavy']==1 ) 
{	$cpucoremin = 4; if($cores>2 && $cores <4) { $cpu_misc=array_diff($cpu_misc,["Multithreading"]); $cores=4;} }
	
$cpu_misc=array_unique($cpu_misc);

		
// DISPLAY Conditions			
$displaysizemin=0; $displaysizemax=30;
if ((isset($_GET['desk']) && $_GET['desk']==1)&&(!isset($_GET['bed'])&&!isset($_GET['house'])&&!isset($_GET['lap'])&&!isset($_GET['bage'])))
{	if($displaysizemin<14) { $displaysizemin =14; }	if($displaysizemax>24) { $displaysizemax =24; } }

if (isset($_GET['bed']) && $_GET['bed']==1) 
{	if($displaysizemin<13) { $displaysizemin =13; }	if($displaysizemax>16.2) { $displaysizemax=16.2; } }
					
if (isset($_GET['house']) && $_GET['house']==1) 
{	if($displaysizemin<13) { $displaysizemin =13; }	if($displaysizemax>16.2) { $displaysizemax=16.2; } }
										
if (isset($_GET['lap'])	&& $_GET['lap']==1 ) 
{ 
	if($displaysizemin<10) { $displaysizemin =10; }	if($displaysizemax>14) { $displaysizemax =14; } 
	if((isset($_GET['oldgamesmedium']) && $_GET['oldgamesmedium']==1) || (isset($_GET['oldgameshigh']) && $_GET['oldgameshigh']==1) || (isset($_GET['mmomedium']) && $_GET['mmomedium']==1) || (isset($_GET['mmohigh']) && $_GET['mmohigh']==1 ) || (isset($_GET['3dgameslow']) && $_GET['3dgameslow']==1) || (isset($_GET['3dgamesmedium']) && $_GET['3dgamesmedium']==1) || (isset($_GET['3dgameshigh']) && $_GET['3dgameshigh']==1) || (isset($_GET['autocadmedium']) && $_GET['autocadmedium']==1) || (isset($_GET['autocadheavy']) && $_GET['autocadheavy']==1) || (isset($_GET['swlight']) && $_GET['swlight']==1) || (isset($_GET['swmedium']) && $_GET['swmedium']==1) ||  (isset($_GET['swheavy']) && $_GET['swheavy']==1) || (isset($_GET['3dsmaxlight']) && $_GET['3dsmaxlight']==1) || (isset($_GET['3dsmaxmedium']) && $_GET['3dsmaxmedium']==1) || (isset($_GET['3dsmaxheavy']) && $_GET['3dsmaxheavy']==1) || (isset($_GET['catialight']) && $_GET['catialight']==1) || (isset($_GET['catiamedium']) && $_GET['catiamedium']==1) || (isset($_GET['catiaheavy']) && $_GET['catiaheavy']==1) || (isset($_GET['rhinolight']) && $_GET['rhinolight']==1) || (isset($_GET['rhinomedium']) && $_GET['rhinomedium']==1) || (isset($_GET['rhinoheavy']) && $_GET['rhinoheavy']==1) || (isset($_GET['cadolight']) && $_GET['cadolight']==1) || (isset($_GET['cadomedium']) && $_GET['cadomedium']==1) || (isset($_GET['cadoheavy']) && $_GET['cadoheavy']==1)) { if($displaysizemax<16.2) { $displaysizemax =16.2; } }
}

if (isset($_GET['bag']) && $_GET['bag']==1) 
{	if($displaysizemin<13) { $displaysizemin =13; }	if($displaysizemax>16.2) { $displaysizemax =16.2; } }
					
if (isset($_GET['60srgb']) && $_GET['60srgb'] ==1) 
{	$display_backt = ["LED IPS","LED IPS PenTile","OLED","mLED"]; }
														
if (isset($_GET['90srgb']) && $_GET['90srgb']==1) 
{	$display_backt = ["LED IPS","LED IPS PenTile","OLED","mLED"]; $display_srgb = 80; }
						
if (isset($_GET['media'])&& $_GET['media']==1 && !((isset($_GET['60srgb']) && $_GET['60srgb'] ==1) || (isset($_GET['90srgb']) && $_GET['90srgb']==1)) ) 
{	$display_backt = ["LED IPS","LED IPS PenTile","LED TN WVA","OLED","mLED"]; }

if (isset($_GET['FHD'])&& $_GET['FHD']==1 )
{	$displayvresmin = 1080; }
else
{
	if (isset($_GET['FHDplus'])&& $_GET['FHDplus']==1 ) 
	{	$displayvresmin = 1440; }
}

if (isset($_GET['hrefresh']) && $_GET['hrefresh']==1)
{
	$display_backt = ["LED IPS","LED IPS PenTile","LED TN WVA","OLED","mLED","120Hz","144Hz","240Hz"];
}

/*de vazut daca ia touch*/
if (isset($_GET['ntouch'])&& $_GET['ntouch']==1 ) 
{	$displaytouch[] = "1"; $tcheck = "checked"; }
/**/					
if ((isset($_GET['dispxsmall']) && $_GET['dispxsmall']==1 ) || (isset($_GET['dispsmall'])	&& $_GET['dispsmall']==1 ) || (isset($_GET['dispmedium']) && $_GET['dispmedium']==1 ) || (isset($_GET['displarge'])	&& $_GET['displarge']==1 ) )
{	$displaysizemin=30; $displaysizemax=0; }

if (isset($_GET['dispxsmall'])	&& $_GET['dispxsmall']==1 ) 
{	if($displaysizemin>10) { $displaysizemin =10; }	if($displaysizemax<13) { $displaysizemax =13; } }

if (isset($_GET['dispsmall'])	&& $_GET['dispsmall']==1 ) 
{	if($displaysizemin>13) { $displaysizemin =13; }	if($displaysizemax<14) { $displaysizemax =14; } }

if (isset($_GET['dispmedium'])	&& $_GET['dispmedium']==1 ) 
{	if($displaysizemin>14) { $displaysizemin =14; }	if($displaysizemax<16.2) { $displaysizemax =16.2; } }

if (isset($_GET['displarge'])	&& $_GET['displarge']==1 ) 
{	if($displaysizemin>16) { $displaysizemin =16; }	if($displaysizemax<24) { $displaysizemax =24; } }

$display_backt=array_unique($display_backt);


// MEMORY Conditions
if (isset($_GET['heavybrowsing']) && $_GET['heavybrowsing']==1)
{	$memcapmin = 4;}

if (isset($_GET['oldgameslow']) && $_GET['oldgameslow']==1 && $memcapmin < 4) 
{	$memcapmin = 4;}
														
if (isset($_GET['oldgamesmedium']) && $_GET['oldgamesmedium']==1 && $memcapmin < 8) 
{	$memcapmin = 8;}
																			
if (isset($_GET['oldgameshigh']) && $_GET['oldgameshigh']==1 && $memcapmin < 8) 
{	$memcapmin = 8;}
													
if (isset($_GET['mmolow']) && $_GET['mmolow']==1 && $memcapmin < 8) 
{	$memcapmin = 8;}
													
if (isset($_GET['mmomedium']) && $_GET['mmomedium']==1 && $memcapmin < 8) 
{	$memcapmin = 8;}
																			
if (isset($_GET['mmohigh']) && $_GET['mmohigh']==1 && $memcapmin < 8) 
{	$memcapmin = 8;}
										
if (isset($_GET['3dgameslow']) && $_GET['3dgameslow']==1 && $memcapmin < 8) 
{	$memcapmin = 8;}
											
if (isset($_GET['3dgamesmedium']) && $_GET['3dgamesmedium']==1 && $memcapmin < 16) 
{	$memcapmin = 16;}
																			
if (isset($_GET['3dgameshigh']) && $_GET['3dgameshigh']==1 && $memcapmin < 16) 
{	$memcapmin = 16;}
							
if (isset($_GET['calc']) && $_GET['calc']==1 && $memcapmin < 4) 
{	$memcapmin = 4;	}

if (isset($_GET['coding']) && $_GET['coding']==1 && $memcapmin < 16) 
{	$memcapmin = 8;	}

if (isset($_GET['lvedit']) && $_GET['lvedit']==1 && $memcapmin  < 4) 
{	$memcapmin  = 4;	}
																	
if (isset($_GET['hvedit']) && $_GET['hvedit']==1 && $memcapmin  < 8) 
{	$memcapmin  = 8; }

if (isset($_GET['vmnone']) && $_GET['vmnone']==1)
{	}
						
if (isset($_GET['vmsmall']) && $_GET['vmsmall']==1)
{	if($memcapmin<8) { $memcapmin=8; } }

if (isset($_GET['vmedium']) && $_GET['vmmedium']==1)
{	if($memcapmin<16) { $memcapmin=16; } }

if (isset($_GET['vmheavy']) && $_GET['vmheavy']==1)
{	if($memcapmin<32) { $memcapmin=32; } }

if (isset($_GET['autocadmedium']) && $_GET['autocadmedium']==1 && $memcapmin < 8) 
{	$memcapmin = 8; }

if (isset($_GET['autocadheavy']) && $_GET['autocadheavy']==1 && $memcapmin < 16) 
{	$memcapmin = 16; }

if (isset($_GET['swlight']) && $_GET['swlight']==1 && $memcapmin < 8) 
{	$memcapmin = 8;}

if (isset($_GET['swmedium']) && $_GET['swmedium']==1 && $memcapmin < 16) 
{	$memcapmin = 16;}

if (isset($_GET['swheavy']) && $_GET['swheavy']==1 && $memcapmin < 16) 
{	$memcapmin = 16;}

if (isset($_GET['3dsmaxlight']) && $_GET['3dsmaxlight']==1 && $memcapmin < 8) 
{	$memcapmin = 8;}

if (isset($_GET['3dsmaxmedium']) && $_GET['3dsmaxmedium']==1 && $memcapmin < 16) 
{	$memcapmin = 16;}

if (isset($_GET['3dsmaxheavy']) && $_GET['3dsmaxheavy']==1 && $memcapmin < 16) 
{	$memcapmin = 16;}

if (isset($_GET['catialight']) && $_GET['catialight']==1 && $memcapmin < 8) 
{	$memcapmin = 8;}

if (isset($_GET['catiamedium']) && $_GET['catiamedium']==1 && $memcapmin < 16) 
{	$memcapmin = 16;}

if (isset($_GET['catiaheavy']) && $_GET['catiaheavy']==1 && $memcapmin < 16) 
{	$memcapmin = 16;}

if (isset($_GET['rhinolight']) && $_GET['rhinolight']==1 && $memcapmin < 8) 
{	$memcapmin = 8;}

if (isset($_GET['rhinomedium']) && $_GET['rhinomedium']==1 && $memcapmin < 16) 
{	$memcapmin = 16;}

if (isset($_GET['rhinoheavy']) && $_GET['rhinoheavy']==1 && $memcapmin < 16) 
{	$memcapmin = 16;}

if (isset($_GET['cadolight']) && $_GET['cadolight']==1 && $memcapmin < 8) 
{	$memcapmin = 8;}

if (isset($_GET['cadomedium']) && $_GET['cadomedium']==1 && $memcapmin < 16) 
{	$memcapmin = 16;}

if (isset($_GET['cadoheavy']) && $_GET['cadoheavy']==1 && $memcapmin < 16) 
{	$memcapmin = 16;}
   
if (isset($_GET['memxsmall']) && $_GET['memxsmall']==1 && $memcapmin < 4) 
{	$memcapmin = 4; }

if (isset($_GET['memsmall']) && $_GET['memsmall']==1 && $memcapmin < 8) 
{	$memcapmin = 8; }

if (isset($_GET['memmedium']) && $_GET['memmedium']==1 && $memcapmin < 16) 
{	$memcapmin = 16; }

if (isset($_GET['memlarge']) && $_GET['memlarge']==1 && $memcapmin < 32) 
{	$memcapmin = 32; }

if (isset($_GET['memxlarge']) && $_GET['memxlarge']==1 && $memcapmin < 64) 
{	$memcapmin = 64; }

// STORAGE Conditions
$hdd_type=["SSD"];
if (isset($_GET['3dgameslow']) && $_GET['3dgameslow']==1 && $totalcapmin < 500)
{	$totalcapmin = 500;	}
								
if (isset($_GET['3dgamesmedium']) && $_GET['3dgamesmedium']==1 && $totalcapmin < 500) 
{	$totalcapmin = 500;}
								
if (isset($_GET['3dgameshigh']) && $_GET['3dgameshigh']==1 && $totalcapmin < 500) 
{	$totalcapmin = 500;}
							
if (isset($_GET['60srgb']) && $_GET['60srgb']==1 && $totalcapmin < 200) 
{	$totalcapmin = 200;}
															
if (isset($_GET['90srgb']) && $_GET['90srgb']==1 && $totalcapmin < 500) 
{	$totalcapmin = 500; }
																								
if (isset($_GET['lvedit']) && $_GET['lvedit']==1 && $totalcapmin < 200) 
{	$totalcapmin = 200;	}
														
if (isset($_GET['hvedit']) && $_GET['hvedit']==1 && $totalcapmin < 1000) 
{	$totalcapmin = 1000;	}

if (isset($_GET['swlight']) && $_GET['swlight']==1 && $totalcapmin < 500) 
{	$totalcapmin = 500; }

if (isset($_GET['swmedium']) && $_GET['swmedium']==1 && $totalcapmin < 500) 
{	$totalcapmin = 500; }

if (isset($_GET['swheavy']) && $_GET['swheavy']==1 && $totalcapmin < 500) 
{	$totalcapmin = 500;}

if (isset($_GET['3dsmaxlight']) && $_GET['3dsmaxlight']==1 && $totalcapmin < 500) 
{	$totalcapmin = 500;}

if (isset($_GET['3dsmaxmedium']) && $_GET['3dsmaxmedium']==1 && $totalcapmin < 500) 
{	$totalcapmin = 500;}

if (isset($_GET['3dsmaxheavy']) && $_GET['3dsmaxheavy']==1 && $totalcapmin < 500) 
{	$totalcapmin = 500; }

if (isset($_GET['catialight']) && $_GET['catialight']==1 && $totalcapmin < 500) 
{	$totalcapmin = 500; }

if (isset($_GET['catiamedium']) && $_GET['catiamedium']==1 && $totalcapmin < 500) 
{	$totalcapmin = 500; }

if (isset($_GET['catiaheavy']) && $_GET['catiaheavy']==1 && $totalcapmin < 500) 
{	$totalcapmin = 500;}

if (isset($_GET['rhinolight']) && $_GET['rhinolight']==1 && $totalcapmin < 500) 
{	$totalcapmin = 500;}

if (isset($_GET['rhinomedium']) && $_GET['rhinomedium']==1 && $totalcapmin < 500) 
{	$totalcapmin = 500;}

if (isset($_GET['rhinoheavy']) && $_GET['rhinoheavy']==1 && $totalcapmin < 500) 
{	$totalcapmin = 500;}

if (isset($_GET['cadolight']) && $_GET['cadolight']==1 && $totalcapmin < 500) 
{	$totalcapmin = 500; }

if (isset($_GET['cadomedium']) && $_GET['cadomedium']==1 && $totalcapmin < 500) 
{	$totalcapmin = 500;}

if (isset($_GET['cadoheavy']) && $_GET['cadoheavy']==1 && $totalcapmin < 500) 
{	$totalcapmin = 500;}

if (isset($_GET['shdd']) && $_GET['shdd']==1) 
{	$to_search['shdd'] = 1; $nr_hdd=2;}


// GPU Conditions
if($model_maxclass>=2) {  array_push($gpu_typelist,"3"); }
$quiz_mingputype=0; $gpu_typelist=array("-1");
if (isset($_GET['oldgameslow']) && $_GET['oldgameslow']==1) 
{	array_push($gpu_typelist,"0","1"); if($quiz_mingputype<0) { $quiz_mingputype=0; } $to_search["gpu"]=1; }
														
if (isset($_GET['oldgamesmedium']) && $_GET['oldgamesmedium']==1) 
{	if($quiz_mingputype<1) { $quiz_mingputype=1; } if($gpupowermin<15) { $gpupowermin = 15; } array_push($gpu_typelist,"1"); $to_search["gpu"]=1; }
																				
if (isset($_GET['oldgameshigh']) && $_GET['oldgameshigh']==1) 
{	if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2"); if($gpupowermin<40) { $gpupowermin = 40; } $to_search["gpu"]=1; }
								
if (isset($_GET['mmolow']) && $_GET['mmolow']==1) 
{	if($quiz_mingputype<0) { $quiz_mingputype=0; } array_push($gpu_typelist,"0","1"); $to_search["gpu"]=1; }
								
if (isset($_GET['mmomedium']) && $_GET['mmomedium']==1) 
{	if($gpupowermin<36) { $gpupowermin = 36; } if($gpupowermax<69) { $gpupowermax = 69; } if($model_maxclass>1 && $gpupowermax<500) { $gpupowermax=500; } if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2"); $to_search["gpu"]=1; }
								
if (isset($_GET['mmohigh']) && $_GET['mmohigh']==1 ) 
{	if($gpupowermin<55) { $gpupowermin = 55; } $to_search["gpu"]=1; if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","4"); $gpu_ldmin=gmdate("Y-01-01",time()-31536000*2 ); } 
							
if (isset($_GET['3dgameslow']) && $_GET['3dgameslow']==1) 
{	if($gpupowermin<30) { $gpupowermin = 30; } if($gpupowermax<69) { $gpupowermax = 69; } $to_search["gpu"]=1; if($quiz_mingputype<2) { $quiz_mingputype=1; } array_push($gpu_typelist,"1","2"); $gpu_ldmin=gmdate("Y-01-01",time()-31536000*2.5 ); $gpu_arch=["Maxwell","Pascal","Turing","GCN 1.2","GCN 1.3","GCN 1.4"];  }
														
if (isset($_GET['3dgamesmedium']) && $_GET['3dgamesmedium']==1) 
{	if($gpupowermin<55) { $gpupowermin = 55; } $to_search["gpu"]=1; if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","4");  $gpu_ldmin=gmdate("Y-01-01",time()-31536000*2 ); }
												
if (isset($_GET['3dgameshigh']) && $_GET['3dgameshigh']==1) 
{	$gpu_typelist[] = 4; $to_search["gpu"]=1; if($quiz_mingputype<4) { $quiz_mingputype=4; } array_push($gpu_typelist,"4");  $gpu_ldmin=gmdate("Y-m-d",time()-31536000*2 ); }
$gpudate = explode("-",$gpu_ldmin);
$gpumindate = $gpudate[0]; 

$cadratemin=0; $cadratemax=0; $gameratemin=0; $gameratemax=0;

if (isset($_GET['autocadlight']) && $_GET['autocadlight']==1) 
{	$gpu_typelist[] = 0; $gpu_typelist[] = 1; $gpu_typelist[] = 3; if($gpupowermax<36) { $gpupowermax = 36; } $to_search["gpu"]=1; }

if (isset($_GET['autocadmedium']) && $_GET['autocadmedium']==1) 
{	if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2"); if($cadratemin<15) { $cadratemin=15; } if($cadratemax<25) { $cadratemax=25; } if ($gameratemin<24) { $gameratemin=24; } if($gameratemax<50) { $gameratemax=50; }	$to_search["gpu"]=1; }

if (isset($_GET['autocadheavy']) && $_GET['autocadheavy']==1) 
{	if($cadratemin<20) { $cadratemin=20; } if($cadratemax<35) { $cadratemax=35; } if ($gameratemin<40) { $gameratemin=40; } if($gameratemax<65) { $gameratemax=65; }	if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","4"); $to_search["gpu"]=1; }

if (isset($_GET['swlight']) && $_GET['swlight']==1) 
{	if($cadratemin<10) { $cadratemin=10; } if($cadratemax<30) { $cadratemax=30; } if ($gameratemin<24) { $gameratemin=24; } if($gameratemax<50) { $gameratemax=50; }	if($quiz_mingputype<2) { $quiz_mingputype=2; }; if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2"); $to_search["gpu"]=1; }

if (isset($_GET['swmedium']) && $_GET['swmedium']==1) 
{	if($cadratemin<30) { $cadratemin=30; } if($cadratemax<50) { $cadratemax=50; } if ($gameratemin<45) { $gameratemin=45; } if($gameratemax<65) { $gameratemax=65; }	if($quiz_mingputype<2) { $quiz_mingputype=2; } if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","4"); $to_search["gpu"]=1; }

if (isset($_GET['swheavy']) && $_GET['swheavy']==1) 
{	if($cadratemin<50) { $cadratemin=50; } if($cadratemax<200) { $cadratemax=200; } if ($gameratemin<90) { $gameratemin=1000; } if($gameratemax<200) { $gameratemax=200; } if($quiz_mingputype<3) { $quiz_mingputype=3; } array_push($gpu_typelist,"4"); $to_search["gpu"]=1; }

if (isset($_GET['3dsmaxlight']) && $_GET['3dsmaxlight']==1) 
{	if($cadratemin<20) { $cadratemin=20; } if($cadratemax<35) { $cadratemax=35; } if ($gameratemin<30) { $gameratemin=30; } if($gameratemax<60) { $gameratemax=60; } if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","4"); $to_search["gpu"]=1; }

if (isset($_GET['3dsmaxmedium']) && $_GET['3dsmaxmedium']==1) 
{	if($cadratemin<30) { $cadratemin=30; } if($cadratemax<60) { $cadratemax=60; } if ($gameratemin<50) { $gameratemin=50; } if($gameratemax<80) { $gameratemax=80; } if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","4"); $to_search["gpu"]=1; }

if (isset($_GET['3dsmaxheavy']) && $_GET['3dsmaxheavy']==1) 
{	if($cadratemin<50) { $cadratemin=50; } if($cadratemax<200) { $cadratemax=200; } if ($gameratemin<90) { $gameratemin=90; } if($gameratemax<200) { $gameratemax=200; } if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","4"); $to_search["gpu"]=1; }

if (isset($_GET['catialight']) && $_GET['catialight']==1) 
{	if($cadratemin<25) { $cadratemin=25; } if($cadratemax<35) { $cadratemax=35; } if ($gameratemin<48) { $gameratemin=48; } if($gameratemax<70) { $gameratemax=70; } if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","4"); $to_search["gpu"]=1; }

if (isset($_GET['catiamedium']) && $_GET['catiamedium']==1) 
{	if($cadratemin<35) { $cadratemin=35; } if($cadratemax<60) { $cadratemax=60; } if ($gameratemin<70) { $gameratemin=70; } if($gameratemax<200) { $gameratemax=200; } if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","4"); $to_search["gpu"]=1; }

if (isset($_GET['catiaheavy']) && $_GET['catiaheavy']==1) 
{	if($cadratemin<60) { $cadratemin=60; }  if($cadratemax<200) { $cadratemax=200; }  if ($gameratemin<1000) { $gameratemin=1000; } if($gameratemax<200) { $gameratemax=200; } if($quiz_mingputype<3) { $quiz_mingputype=3; } array_push($gpu_typelist,"2","4");  $to_search["gpu"]=1; }

if (isset($_GET['rhinolight']) && $_GET['rhinolight']==1) 
{	if($cadratemin<20) { $cadratemin=20; } if($cadratemax<35) { $cadratemax=35; } if ($gameratemin<30) { $gameratemin=30; } if($gameratemax<60) { $gameratemax=60; } if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","4"); $to_search["gpu"]=1; }

if (isset($_GET['rhinomedium']) && $_GET['rhinomedium']==1) 
{	if($cadratemin<30) { $cadratemin=30; } if($cadratemax<60) { $cadratemax=60; } if ($gameratemin<48) { $gameratemin=48; } if($gameratemax<80) { $gameratemax=80; } if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","4"); $to_search["gpu"]=1; }

if (isset($_GET['rhinoheavy']) && $_GET['rhinoheavy']==1) 
{	if($cadratemin<50) { $cadratemin=50; } if($cadratemax<200) { $cadratemax=200; }  if ($gameratemin<1000) { $gameratemin=90; } if($gameratemax<200) { $gameratemax=200; } if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"4"); $to_search["gpu"]=1; }

if (isset($_GET['cadolight']) && $_GET['cadolight']==1) 
{	if($cadratemin<25) { $cadratemin=25; } if($cadratemax<35) { $cadratemax=35; } if ($gameratemin<48) { $gameratemin=48; } if($gameratemax<70) { $gameratemax=70; }  if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","4"); $to_search["gpu"]=1; }

if (isset($_GET['cadomedium']) && $_GET['cadomedium']==1) 
{	if($cadratemin<30) { $cadratemin=30; } if($cadratemax<60) { $cadratemax=60; } if ($gameratemin<70) { $gameratemin=70; }if($gameratemax<200) { $gameratemax=200; }  if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","4"); $to_search["gpu"]=1; }

if (isset($_GET['cadoheavy']) && $_GET['cadoheavy']==1) 
{	if($cadratemin<60) { $cadratemin=60; } if($cadratemax<200) { $cadratemax=200; }  if ($gameratemin<1000) { $gameratemin=1000; } if($gameratemax<200) { $gameratemax=200; }   if($quiz_mingputype<3) { $quiz_mingputype=3; } array_push($gpu_typelist,"2","4"); $to_search["gpu"]=1; }

if($to_search["gpu"]) {	$gpu_typelist=array_unique($gpu_typelist); for($i=0;$i<=$quiz_mingputype;$i++) { array_diff($gpu_typelist,array(strval($i))); } }

if($cadratemin!==0)
{
	$addgaming="";
	if (isset($_GET['gaming']) && $_GET['gaming']==1) { if($gpu_powermax<1){$gpu_powermax=999999;} $addgaming=" AND (power>=".$gpu_powermin." AND power<=".$gpu_powermax.")"; }
	$query = "SELECT DISTINCT `name` FROM `notebro_db`.`GPU` WHERE (rating>=".$cadratemin." AND rating<=".$cadratemax." AND typegpu=3) OR (rating>=".$gameratemin." AND rating<=".$gameratemax.$addgaming." AND typegpu IN (".implode(",",$gpu_typelist)."))";
	$result = mysqli_query($GLOBALS['con'],$query);
	array_push($gpu_typelist,"3");
	while($row=mysqli_fetch_row($result)){	$gpu_name[]=$row[0]; }
	if(count($gpu_name)<1)
	{
		if(isset($_GET['gaming']) && $_GET['gaming']==1)
		{
			if($gameratemin<$gpu_powermin)
			{ $query = "SELECT DISTINCT `name` FROM `notebro_db`.`GPU` WHERE (".$addgaming." AND `typegpu` IN (1,2,3,4))"; }
			else
			{ $query = "SELECT DISTINCT `name` FROM `notebro_db`.`GPU` WHERE (`rating`>=".$cadratemin." AND `rating`<=".$cadratemax." AND typegpu=3) OR (rating>=".$gameratemin." AND rating<=".$gameratemax." AND typegpu IN (".implode(",",$gpu_typelist)."))"; }
			
			$result = mysqli_query($GLOBALS['con'],$query);
			array_push($gpu_typelist,"3");
			while($row=mysqli_fetch_row($result)){$gpu_name[]=$row[0];}
			if(count($gpu_name)<1){ $gpu_typelist=["10"]; }
		}
		else
		{
			$gpu_typelist=["10"]; 
		}
	}
}

if(!$to_search["gpu"]) { if($quiz_mingputype<1) { $quiz_mingputype=0; } array_push($gpu_typelist,"0","1"); if($model_maxclass>=2) { $gpupowermax=36; array_push($gpu_typelist,"3"); } $to_search["gpu"]=1; } 
$gpu_typelist=array_unique($gpu_typelist);
foreach($gpu_typelist as $key=>$el){ if(intval($el)<0){ unset($gpu_typelist[$key]);}}

// ODD Conditions
if (isset($_GET['odd']) && $_GET['odd']==1) 
{	$oddtype=["Any optical drive"];
	foreach ($oddtype as $element)
	{	$valuetype[52][] = $element; }
}
		
// MDB Conditions
if ((isset($_GET['casual']) && $_GET['casual']==1)||(isset($_GET['gaming']) && $_GET['gaming']==1))
{	$mdb_wwan=1; }
            
if ((isset($_GET['business']) && $_GET['business']==1)||(isset($_GET['cad3d']) && $_GET['cad3d']==1)||(isset($_GET['content']) && $_GET['content']==1)||(isset($_GET['coding']) && $_GET['coding']==1))
{	$mdb_wwan=0; }
			
$mdbwwan = $mdb_wwan;
$mdbwwansel0 = '';	
if ($mdbwwan ==1) {	$mdbwwansel1 = 'selected="selected"'; }
else if ($mdbwwan == 2) {	$mdbwwansel2 = 'selected="selected"'; }
else {	$mdbwwansel0 = 'selected="selected"'; }

// CHASSIS Conditions
$chassisweightmax=999999; $chassisthicmax=999999;

if (isset($_GET['desk']) && $_GET['desk']==1) 
{	if($chassisweightmax>10) { $chassisweightmax = 10; } if($chassisthicmax>100){ $chassisthicmax = 100; } }

if (isset($_GET['bed']) && $_GET['bed']==1) 
{	if($chassisweightmax>2.35) { $chassisweightmax = 2.35; } if($chassisthicmax>27){ $chassisthicmax = 27; } }
						
if (isset($_GET['house']) && $_GET['house']==1) 
{	if($chassisweightmax>2.8) { $chassisweightmax = 2.8; } if($chassisthicmax>31){ $chassisthicmax = 31;} }
								
if (isset($_GET['lap']) && $_GET['lap']==1) 
{	if($chassisweightmax>2.1) { $chassisweightmax = 2.1; } if($chassisthicmax>24){ $chassisthicmax = 24;} }
						
if (isset($_GET['bag']) && $_GET['bag']==1) 
{ 
	if(isset($_GET['displarge']) && $_GET['displarge']==1)
	{	if($chassisweightmax>3.6) { $chassisweightmax = 3.6; } if($chassisthicmax>37){ $chassisthicmax = 37;} }
	else
	{	if($chassisweightmax>2.9) { $chassisweightmax = 2.9; } if($chassisthicmax>35){ $chassisthicmax = 35;} }
}

if (isset($_GET['metal']) && $_GET['metal']==1 ) 
{	$chassis_made[] = "Metal"; 	$chassis_made[] = "Aluminium"; $chassis_made[] = "Hard plastic"; $chassis_made[] = "Lithium";  $chassis_made[] = "Carbon"; $chassis_made[] = "Magnesium"; $chassis_made[] = "Glass fiber"; $chassis_made[] = "Shock-absorbing ultra-polymer";}		

if (isset($_GET['media']) && $_GET['media']==1) 
{ $chassis_vports[] = "Any video port"; } 

if (isset($_GET['stylus']) && $_GET['stylus']==1) 
{ $chassis_misc[] = "Stylus";} 

if (isset($_GET['convertible']) && $_GET['convertible']==1 ) 
{	$chassis_twoinone = 1;	}

if (isset($_GET['comm']) && $_GET['comm']==1 ) 
{	$chassiswebmin = 0.92;	$chassis_misc[]="Microphone array"; }

if(isset($chassis_made) && count($chassis_made)>0) { $chassis_made=array_unique($chassis_made); }

// WARRANTY Conditions
$to_search["war"] = 1;
$war_typewar=["1","2","3","4"];

// SIST Conditions
if ((isset($_GET['casual']) && $_GET['casual']==1)||(isset($_GET['content']) && $_GET['content']==1)||(isset($_GET['gaming']) && $_GET['gaming']==1))
{	$sist_sist=["Windows+Home","Windows+S"]; if($model_maxclass>=2) {  $sist_sist[]="Windows+Pro"; } }

if ((isset($_GET['business']) && $_GET['business']==1)||(isset($_GET['cad3d']) && $_GET['cad3d']==1)||(isset($_GET['coding']) && $_GET['coding']==1))
{	$sist_sist=["Windows+Home","Windows+Pro"]; $sist_sist=array_diff($sist_sist,["Windows+S"]); }

//BATTERY Conditions
if (isset($_GET['2hour']) && $_GET['2hour']==1) 
{	$batlifemin = 0.9; }

if (isset($_GET['6hour']) && $_GET['6hour']==1) 
{	$batlifemin = 2.7; }

if (isset($_GET['10hour']) && $_GET['10hour']==1) 
{	$batlifemin = 4.9; }

if (isset($_GET['12hour']) && $_GET['12hour']==1) 
{	$batlifemin = 7.5; }

//BUDGET Conditions
if	($qsearchtype!="p" && $qsearchtype!="b")
{	$budgetmin=2147483647; $budgetmax=0; }

if (isset($_GET['b500']) && $_GET['b500']==1)
{	if(isset($budgetmin) && $budgetmin>150) { $budgetmin=150; } if(isset($budgetmax) && $budgetmax<500) { $budgetmax=505; } }

if (isset($_GET['b750']) && $_GET['b750']==1) 
{	if(isset($budgetmin) && $budgetmin>480) { $budgetmin=480; } if(isset($budgetmax) && $budgetmax<790) { $budgetmax=790; } }

if (isset($_GET['b1000']) && $_GET['b1000']==1)
{	if(isset($budgetmin) && $budgetmin>740) { $budgetmin=740; } if(isset($budgetmax) && $budgetmax<1090) { $budgetmax=1090; } }

if (isset($_GET['b1500']) && $_GET['b1500']==1)
{	if(isset($budgetmin) && $budgetmin>950) { $budgetmin=950; } if(isset($budgetmax) && $budgetmax<1630) { $budgetmax=1630; } }

if (isset($_GET['b2000']) && $_GET['b2000']==1)
{	if(isset($budgetmin) && $budgetmin>1425) { $budgetmin=1425; } if(isset($budgetmax) && $budgetmax<2170) { $budgetmax=2170; } }

if (isset($_GET['b3000']) && $_GET['b3000']==1)
{	if(isset($budgetmin) && $budgetmin>1850) { $budgetmin=1850; } if(isset($budgetmax) && $budgetmax<8000) { $budgetmax=8000*4; if(isset($nomenvalues[14][2])){ $nomenvalues[14][2]=floatval($nomenvalues[14][2]); if($nomenvalues[14][2]>100){ $budgetmax=$nomenvalues[14][2];} } }
} 

if ($qsearchtype!=="p" && $qsearchtype!=="b")
{	
	if($budgetmax<1100)
	{	if($totalcapmin>200) { $totalcapmin/=2; } }

	if($budgetmax>800)
	{
		$sist_sist[]="macOS";
		if(count($display_backt)<1) { $display_backt = ["LED IPS","LED IPS PenTile","LED TN WVA","OLED"]; }
		if($displayvresmin<1080) { $displayvresmin=1080; }
		if($totalcapmin<249) { $totalcapmin =240; }
		if($memcapmin<8){$memcapmin=8;}
		
		if($budgetmax>2100)
		{	}
	}
	else
	{
		$sist_sist[]="Chrome OS";
		
		if($budgetmax>506)
		{ 
			$totalcapmin=100;
			if($to_search["gpu"] && $quiz_mingputype>1 ) {	$hdd_type=["HDD","SSD"]; }
			if($displayvresmin<1080) {	$displayvresmin=1080; }
		}
		else
		{
			$hdd_type=[];
			$memcapmin=4;
			if (isset($_GET['coding']) && $_GET['coding']==1){ $totalcapmin =64; $cpufreqmin *= 0.75; }
		}
	}
}
else
{
	$sist_sist[]="macOS"; $sist_sist[]="Chrome OS"; 
}

if($budgetmin==2147483647){$budgetmin=-10;}
if($budgetmax==0){$budgetmax=-10;}

$sist_sist=array_unique($sist_sist);

//GENERATING Adv_Search html code

if ($model_minclass <= 0 && $model_maxclass>=3) 
{
	$family.='<option selected="selected">All business families</option>';
	$family.='<option selected="selected">All consumer families</option>';
}
else if (	$model_minclass>=1 && $model_maxclass>=3) {	$family.='<option selected="selected">All business families</option>'; }
else if (	$model_minclass>=0 && $model_maxclass<=2) {	$family.='<option selected="selected">All consumer families</option>'; }

foreach ($gpu_name as $element)
{	$gpumodel.='<option selected="selected">'.$element.'</option>'; }
			
foreach ($cpu_misc as $element)
{	$cpumsc.='<option selected="selected">'.$element.'</option>'; }

foreach ($display_backt as $element)
{	$displaymsc.='<option selected="selected">'.$element.'</option>'; }
		
if ($display_srgb>=80)
{	$displaymsc.='<option selected="selected">80% sRGB or better</option>'; }

foreach ($chassis_misc as $element)
{	$chassisstuff.='<option selected="selected">'.$element.'</option>';	}	

if ($nr_hdd == 2) {	$nrhddselect = "selected"; }
if ($nr_hdd == 3) {	$nrhddselect2 = "selected"; }
if(isset($hdd_type)) { $valuetype[54] = $hdd_type; }

foreach ($sist_sist as $element)
{
	$aaa = substr_count($element,"+");
	if ($aaa == 1)
	{
		$aa = str_replace("+"," 10 ",$element);
		$valuetype[25][]= $aa;
	}
	else
	{	$valuetype[25][]= $element; }
} 

foreach ($chassis_vports as $element)
{	$mdbvport.='<option selected="selected">'.$element.'</option>'; }

foreach ($regions_name as $element)
{	$regions='<option selected="selected">'.$element.'</option>'; }

foreach ($gpu_typelist as $element)
{	
	if ($element>=1)  {$gputype =1;}
	$gputypesel[$element]="selected";
}

foreach ($chassis_made as $element)
{	$valuetype[26][] = $element;	}	

if(isset($chassis_twoinone) && $chassis_twoinone == 1)
{	$twoinone_check = "checked"; }

$bdgmin=floatval($budgetmin); 
$bdgmax=floatval($budgetmax)+1;

if ($mdbslots == 1) {	$mdbslotsel1 = "selected"; }
else if ($mdbslots == 2) {	$mdbslotsel2 = "selected"; }
else if ($mdbslots ==3) {	$mdbslotsel3 = "selected"; }
else if ($mdbslots == 4) {	$mdbslotsel4 = "selected"; }
else {	$mdbslotsel0 = "selected"; }
?>