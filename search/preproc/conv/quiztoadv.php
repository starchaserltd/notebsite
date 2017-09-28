<?php
foreach (array("model","cpu", "display", "gpu", "acum", "war", "hdd", "shdd", "wnet", "sist", "odd", "mem", "mdb", "chassis","battery","budget") as $v) 
{
	switch($v)
	{
		case 'model' :
		{
			$regions_name[]="USA and Canada";
			if (isset($_GET['atwork']) && $_GET['atwork']==1)
			{ $model_minclass=1; $model_maxclass=3; if(((isset($_GET['lap']) && $_GET['lap']==1)||(isset($_GET['dispsmall']) && $_GET['dispsmall']==1 ))&& (isset($_GET['3dmodel']) && $_GET['3dmodel']==1 )) { $model_minclass=0; } }

			if (isset($_GET['athome']) && $_GET['athome']==1)
			{ $model_minclass=0; $model_maxclass=1;	if ((isset($_GET['sysadmin']) && $_GET['sysadmin']==1) || (isset($_GET['coding']) && $_GET['coding']==1)){ $model_maxclass=3; } }
							
			break;
		}
		
		case 'cpu':
		{
			$cores=2;
			if (isset($_GET['calc']) && $_GET['calc']==1)
			{ $cpufreqmin = 3.1; $cpu_misc[]="HT"; $cpucoremin=3; }
				
			if (isset($_GET['coding']) && $_GET['coding']==1)
			{ $cpucoremin = 4;  if($cores>2 && $cores <4) { $cpu_misc=array_diff($cpu_misc,["HT"]); $cores=4;} if((isset($_GET['lap']) && $_GET['lap']==1)||(isset($_GET['dispxsmall']) && $_GET['dispxsmall']==1)||(isset($_GET['dispsmall']) && $_GET['dispsmall']==1)) {  $cpucoremin = 2; $cpufreqmin = 3.1; $cpu_misc[]="HT"; $cores=2.5; } }
		
			if (isset($_GET['sysadmin']) && $_GET['sysadmin']==1)
			{ $cpucoremin = 4; }   
		
			if (isset($_GET['lvedit']) && $_GET['lvedit']==1 && $cpucoremin < 2)
			{ $cpucoremin = 2;  $cpu_misc[]="HT"; $cores=2.5; }

			if (isset($_GET['hvedit']) && $_GET['hvedit']==1 )
			{ $cpucoremin = 4;  $cpu_misc[]="HT"; }			
								
			if (isset($_GET['swlight']) && $_GET['swlight']==1  && $cpucoremin < 2)
			{$cpucoremin = 2;  $cpu_misc[]="HT"; $cores=2.5; if($cpufreqmin<3){ $cpufreqmin=3; } }

			if (isset($_GET['swmedium']) && $_GET['swmedium']==1 ) 
			{ $cpucoremin = 4; if($cores>2 && $cores <4) { $cpu_misc=array_diff($cpu_misc,["HT"]); $cores=4;} }
	
			if (isset($_GET['swheavy']) && $_GET['swheavy']==1 )
			{ $cpucoremin = 4; if($cores>2 && $cores <4) { $cpu_misc=array_diff($cpu_misc,["HT"]); $cores=4;} }
	
			if (isset($_GET['3dsmaxlight']) && $_GET['3dsmaxlight']==1  && $cpucoremin < 2)
			{$cpucoremin = 2;  $cpu_misc[]="HT"; if($cpufreqmin<3){ $cpufreqmin=3; } }

			if (isset($_GET['3dsmaxmedium']) && $_GET['3dsmaxmedium']==1) 
			{ $cpucoremin = 4; if($cores>2 && $cores <4) { $cpu_misc=array_diff($cpu_misc,["HT"]); $cores=4;} }
	
			if (isset($_GET['3dsmaxheavy']) && $_GET['3dsmaxheavy']==1 ) 
			{$cpucoremin = 4; if($cores>2 && $cores <4) { $cpu_misc=array_diff($cpu_misc,["HT"]); $cores=4;} }
	
			if (isset($_GET['catialight']) && $_GET['catialight']==1 && $cpucoremin < 2)
			{$cpucoremin = 2;  $cpu_misc[]="HT"; if($cpufreqmin<3.1){ $cpufreqmin=3.1; } $cores=2.5; }

			if (isset($_GET['catiamedium']) && $_GET['catiamedium']==1 ) 
			{ $cpucoremin = 4; if($cores>2 && $cores <4) { $cpu_misc=array_diff($cpu_misc,["HT"]); $cores=4;} }
	
			if (isset($_GET['catiaheavy']) && $_GET['catiaheavy']==1) 
			{ $cpucoremin = 4; if($cores>2 && $cores <4) { $cpu_misc=array_diff($cpu_misc,["HT"]); $cores=4;} }
	
			if (isset($_GET['rhinolight']) && $_GET['rhinolight']==1  && $cpucoremin < 2) 
			{ $cpucoremin = 2;  $cpu_misc[]="HT"; if($cpufreqmin<3){ $cpufreqmin=3; } $cores=2.5; }

			if (isset($_GET['rhinomedium']) && $_GET['rhinomedium']==1) 
			{ $cpucoremin = 4; if($cores>2 && $cores <4) { $cpu_misc=array_diff($cpu_misc,["HT"]); $cores=4;} }
	
			if (isset($_GET['rhinoheavy']) && $_GET['rhinoheavy']==1 ) 
			{ $cpucoremin = 4; if($cores>2 && $cores <4) { $cpu_misc=array_diff($cpu_misc,["HT"]); $cores=4;} }
	
			if (isset($_GET['cadolight']) && $_GET['cadolight']==1  && $cpucoremin < 2) 
			{ $cpucoremin = 2;  $cpu_misc[]="HT"; if($cpufreqmin<3.1){ $cpufreqmin=3.1; } $cores=2.5; }

			if (isset($_GET['cadomedium']) && $_GET['cadomedium']==1 ) 
			{  $cpucoremin = 4; if($cores>2 && $cores <4) { $cpu_misc=array_diff($cpu_misc,["HT"]); $cores=4;} }
	
			if (isset($_GET['cadoheavy']) && $_GET['cadoheavy']==1 ) 
			{  $cpucoremin = 4; if($cores>2 && $cores <4) { $cpu_misc=array_diff($cpu_misc,["HT"]); $cores=4;} }
			
			$cpu_misc=array_unique($cpu_misc);
			
			break ;
		}
		case 'display' :
		{
			$displaysizemin=0; $displaysizemax=30;
			if ((isset($_GET['desk']) && $_GET['desk']==1)&&(!isset($_GET['bed'])&&!isset($_GET['house'])&&!isset($_GET['lap'])&&!isset($_GET['bage'])))
			{ if($displaysizemin<14) { $displaysizemin =14; }	if($displaysizemax>24) { $displaysizemax =24; } }
		
			if (isset($_GET['bed']) && $_GET['bed']==1) 
			{ if($displaysizemin<13) { $displaysizemin =13; }	if($displaysizemax>16) { $displaysizemax =16; } }
								
			if (isset($_GET['house']) && $_GET['house']==1) 
			{ if($displaysizemin<13) { $displaysizemin =13; }	if($displaysizemax>16) { $displaysizemax =16; } }
													
			if (isset($_GET['lap'])	&& $_GET['lap']==1 ) 
			{ if($displaysizemin<10) { $displaysizemin =10; }	if($displaysizemax>14) { $displaysizemax =14; } } //MATTE?
								
			if (isset($_GET['bag']) && $_GET['bag']==1) 
			{ if($displaysizemin<13) { $displaysizemin =13; }	if($displaysizemax>16) { $displaysizemax =16; } }
								
			if (isset($_GET['60srgb']) && $_GET['60srgb'] ==1) 
			{ $display_backt = ["LED IPS","LED IPS PenTile","OLED"]; }
																	
			if (isset($_GET['90srgb']) && $_GET['90srgb']==1) 
			{ $display_backt = ["LED IPS","LED IPS PenTile","OLED"]; $display_srgb = 80; }
									
			if (isset($_GET['media'])&& $_GET['media']==1 && !((isset($_GET['60srgb']) && $_GET['60srgb'] ==1) || (isset($_GET['90srgb']) && $_GET['90srgb']==1)) ) 
			{ $display_backt = ["LED IPS","LED IPS PenTile","LED TN WVA","OLED"]; }
		
			if (isset($_GET['FHDplus'])&& $_GET['FHDplus']==1 ) 
			{ $displayvresmin = 1081; }
							
			if ((isset($_GET['disxsmall']) && $_GET['disxsmall']==1 ) || (isset($_GET['dispsmall'])	&& $_GET['dispsmall']==1 ) || (isset($_GET['dispmedium']) && $_GET['dispmedium']==1 ) || (isset($_GET['displarge'])	&& $_GET['displarge']==1 ) )
			{ $displaysizemin=30; $displaysizemax=0; }
	 
			if (isset($_GET['disxsmall'])	&& $_GET['disxsmall']==1 ) 
			{ if($displaysizemin>10) { $displaysizemin =10; }	if($displaysizemax<13) { $displaysizemax =13; } }
		
			if (isset($_GET['dispsmall'])	&& $_GET['dispsmall']==1 ) 
			{ if($displaysizemin>13) { $displaysizemin =13; }	if($displaysizemax<14) { $displaysizemax =14; } }
		
			if (isset($_GET['dispmedium'])	&& $_GET['dispmedium']==1 ) 
			{ if($displaysizemin>14) { $displaysizemin =14; }	if($displaysizemax<16) { $displaysizemax =16; } }
		
			if (isset($_GET['displarge'])	&& $_GET['displarge']==1 ) 
			{ if($displaysizemin>16) { $displaysizemin =16; }	if($displaysizemax<24) { $displaysizemax =24; } }

			$display_backt=array_unique($display_backt);
		
			break ;
		}
		case 'mem' :
		{   
			if (isset($_GET['oldgameslow']) && $_GET['oldgameslow']==1 && $memcapmin < 4) 
			{ $memcapmin = 4;}
																	
			if (isset($_GET['oldgamesmedium']) && $_GET['oldgamesmedium']==1 && $memcapmin < 8) 
			{$memcapmin = 8;}
																						
			if (isset($_GET['oldgameshigh']) && $_GET['oldgameshigh']==1 && $memcapmin < 8) 
			{$memcapmin = 8;}
																
			if (isset($_GET['mmolow']) && $_GET['mmolow']==1 && $memcapmin < 8) 
			{$memcapmin = 8;}
																
			if (isset($_GET['mmomedium']) && $_GET['mmomedium']==1 && $memcapmin < 8) 
			{ $memcapmin = 8;}
																						
			if (isset($_GET['mmohigh']) && $_GET['mmohigh']==1 && $memcapmin < 8) 
			{ $memcapmin = 8;}
													
			if (isset($_GET['3dgameslow']) && $_GET['3dgameslow']==1 && $memcapmin < 16) 
			{ $memcapmin = 16;}
														
			if (isset($_GET['3dgamesmedium']) && $_GET['3dgamesmedium']==1 && $memcapmin < 16) 
			{	$memcapmin = 16;}
																						
			if (isset($_GET['3dgameshigh']) && $_GET['3dgameshigh']==1 && $memcapmin < 16) 
			{  $memcapmin = 16;}
										
			if (isset($_GET['internet']) && $_GET['internet']==1 && $memcapmin < 4) 
			{$memcapmin = 4;}
									
			if (isset($_GET['calc']) && $_GET['calc']==1 && $memcapmin < 4) 
			{ $memcapmin = 4;	}

			if (isset($_GET['coding']) && $_GET['coding']==1 && $memcapmin < 16) 
			{ $memcapmin = 16;	}
									
			if (isset($_GET['sysadmin']) && $_GET['sysadmin'] && $memcapmin < 16) 
			{	$memcapmin = 16;}
			
			if (isset($_GET['autocadmedium']) && $_GET['autocadmedium']==1 && $memcapmin < 8) 
			{  $memcapmin = 8; }
		
			if (isset($_GET['autocadheavy']) && $_GET['autocadheavy']==1 && $memcapmin < 16) 
			{  $memcapmin = 16; }
		
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

			if (isset($_GET['rhinolight']) && $_GET['rhinolight']==1 && $memcapmin < 8) 
			{	$memcapmin = 8;}

			if (isset($_GET['rhinomedium']) && $_GET['rhinomedium']==1 && $memcapmin < 16) 
			{	$memcapmin = 16;}
		
			if (isset($_GET['rhinoheavy']) && $_GET['rhinoheavy']==1 && $memcapmin < 16) 
			{	$memcapmin = 16;}
		
			if (isset($_GET['cadolight']) && $_GET['cadolight']==1 && $memcapmin < 8) 
			{	$memcapmin = 8;}       
		
			break ;
		}				
		case 'hdd' :
		{
			$hdd_type=["SSD"];
			if (isset($_GET['3dgameslow']) && $_GET['3dgameslow']==1 && $totalcapmin < 500) 
			{ $totalcapmin = 500;	}
											
			if (isset($_GET['3dgamesmedium']) && $_GET['3dgamesmedium']==1 && $totalcapmin = 500) 
			{ $totalcapmin = 500;}
											
			if (isset($_GET['3dgameshigh']) && $_GET['3dgameshigh']==1 && $totalcapmin < 500) 
			{ $totalcapmin = 500;}
										
			if (isset($_GET['60srgb']) && $_GET['60srgb']==1 && $totalcapmin < 200) 
			{ $totalcapmin = 200;}
																		
			if (isset($_GET['90srgb']) && $_GET['90srgb']==1 && $totalcapmin < 500) 
			{ $totalcapmin = 500; }
																											
			if (isset($_GET['lvedit']) && $_GET['lvedit']==1 && $totalcapmin < 200) 
			{	$totalcapmin = 200;	}
																	
			if (isset($_GET['hvedit']) && $_GET['hvedit']==1 && $totalcapmin < 1000) 
			{	$totalcapmin = 1000;	}
		
			if (isset($_GET['swlight']) && $_GET['swlight']==1 && $totalcapmin < 500) 
			{	$totalcapmin = 500; }

			if (isset($_GET['swmedium']) && $_GET['swmedium']==1 && $totalcapmin < 500) 
			{ $totalcapmin = 500; }
		
			if (isset($_GET['swheavy']) && $_GET['swheavy']==1 && $totalcapmin < 500) 
			{ $totalcapmin = 500;}
		
			if (isset($_GET['3dsmaxlight']) && $_GET['3dsmaxlight']==1 && $totalcapmin < 500) 
			{	$totalcapmin = 500;}

			if (isset($_GET['3dsmaxmedium']) && $_GET['3dsmaxmedium']==1 && $totalcapmin < 500) 
			{  $totalcapmin = 500;}
		
			if (isset($_GET['3dsmaxheavy']) && $_GET['3dsmaxheavy']==1 && $totalcapmin < 500) 
			{$totalcapmin = 500; }
		
			if (isset($_GET['catialight']) && $_GET['catialight']==1 && $totalcapmin < 500) 
			{	$totalcapmin = 500; }

			if (isset($_GET['catiamedium']) && $_GET['catiamedium']==1 && $totalcapmin < 500) 
			{ $totalcapmin = 500; }
		
			if (isset($_GET['catiaheavy']) && $_GET['catiaheavy']==1 && $totalcapmin < 500) 
			{ $totalcapmin = 500;}
		
			if (isset($_GET['rhinolight']) && $_GET['rhinolight']==1 && $totalcapmin < 500) 
			{ $totalcapmin = 500;}

			if (isset($_GET['rhinomedium']) && $_GET['rhinomedium']==1 && $totalcapmin < 500) 
			{ $totalcapmin = 500;}
		
			if (isset($_GET['rhinoheavy']) && $_GET['rhinoheavy']==1 && $totalcapmin < 500) 
			{  $totalcapmin = 500;}
		
			if (isset($_GET['cadolight']) && $_GET['cadolight']==1 && $totalcapmin < 500) 
			{ $totalcapmin = 500; }

			if (isset($_GET['cadomedium']) && $_GET['cadomedium']==1 && $totalcapmin < 500) 
			{  $totalcapmin = 500;}
		
			if (isset($_GET['cadoheavy']) && $_GET['cadoheavy']==1 && $totalcapmin < 500) 
			{  $totalcapmin = 500;}
		
			break ;	
		}	
		
		case 'shdd' :
		{   
			if (isset($_GET['shdd']) && $_GET['shdd']==1) 
			{  $to_search['shdd'] = 1; $nr_hdd=2;}
		
			break ;	
		}
	
		case 'gpu' :
		{
			$quiz_mingputype=0; $gpu_typelist=[];
			if (isset($_GET['oldgameslow']) && $_GET['oldgameslow']==1) 
			{ array_push($gpu_typelist,"0","1"); if($quiz_mingputype<0) { $quiz_mingputype=0; } $to_search["gpu"]=1; }
																	
			if (isset($_GET['oldgamesmedium']) && $_GET['oldgamesmedium']==1) 
			{ if($quiz_mingputype<1) { $quiz_mingputype=1; } if($gpupowermin<15) { $gpupowermin = 15; } array_push($gpu_typelist,"1"); $to_search["gpu"]=1; }
																							
			if (isset($_GET['oldgameshigh']) && $_GET['oldgameshigh']==1) 
			{ if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2");  if($gpupowermin<40) { $gpupowermin = 40; } $to_search["gpu"]=1; }
											
			if (isset($_GET['mmolow']) && $_GET['mmolow']==1) 
			{ if($quiz_mingputype<0) { $quiz_mingputype=0; } array_push($gpu_typelist,"0","1"); $to_search["gpu"]=1; }
											
			if (isset($_GET['mmomedium']) && $_GET['mmomedium']==1) 
			{ if($gpupowermin<35) { $gpupowermin = 35; } if($gpupowermax<69) { $gpupowermax = 69; } if((isset($_GET['atwork']) && $_GET['atwork']==1) && $gpupowermax<500) { $gpupowermax=500; } if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2"); $to_search["gpu"]=1; }
											
			if (isset($_GET['mmohigh']) && $_GET['mmohigh']==1 ) 
			{ if($gpupowermin<56) { $gpupowermin = 56; } $to_search["gpu"]=1; if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","4"); $gpu_ldmin=gmdate("Y-01-01",time()-31536000*1.5 ); }
										
			if (isset($_GET['3dgameslow']) && $_GET['3dgameslow']==1) 
			{ if($gpupowermin<30) { $gpupowermin = 30; } if($gpupowermax<69) { $gpupowermax = 69; } $to_search["gpu"]=1; if($quiz_mingputype<2) { $quiz_mingputype=1; } array_push($gpu_typelist,"1","2"); $gpu_ldmin=gmdate("Y-01-01",time()-31536000*2 ); $gpu_arch=["Maxwell","Pascal","GCN 1.2","GCN 1.3"];  }
																	
			if (isset($_GET['3dgamesmedium']) && $_GET['3dgamesmedium']==1) 
			{ if($gpupowermin<56) { $gpupowermin = 56; } $to_search["gpu"]=1; if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","4");  $gpu_ldmin=gmdate("Y-01-01",time()-31536000*1.5 ); }
															
			if (isset($_GET['3dgameshigh']) && $_GET['3dgameshigh']==1) 
			{ $gpu_typelist[] = 4; $to_search["gpu"]=1; if($quiz_mingputype<4) { $quiz_mingputype=4; } array_push($gpu_typelist,"4");  $gpu_ldmin=gmdate("Y-m-d",time()-31536000*1.5 ); }
							
			$cadratemin=0; $cadratemax=0; $gameratemin=0; $gameratemax=0;
			
			if (isset($_GET['autocadlight']) && $_GET['autocadlight']==1) 
			{	$gpu_typelist[] = 0; $gpu_typelist[] = 1; $gpu_typelist[] = 3; $gpupowermax = 35; $to_search["gpu"]=1; }

			if (isset($_GET['autocadmedium']) && $_GET['autocadmedium']==1) 
			{	if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","3"); if($cadratemin<15) { $cadratemin=15; } if($cadratemax<25) { $cadratemax=25; } if ($gameratemin<30) { $gameratemin=30; } if($gameratemax<50) { $gameratemax=50; }	$to_search["gpu"]=1; }
		
			if (isset($_GET['autocadheavy']) && $_GET['autocadheavy']==1) 
			{ if($cadratemin<20) { $cadratemin=20; } if($cadratemax<35) { $cadratemax=35; } if ($gameratemin<40) { $gameratemin=40; } if($gameratemax<65) { $gameratemax=65; }	if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","3","4"); $to_search["gpu"]=1; }
		
			if (isset($_GET['swlight']) && $_GET['swlight']==1) 
			{ if($cadratemin<10) { $cadratemin=10; } if($cadratemax<30) { $cadratemax=30; } if ($gameratemin<24) { $gameratemin=24; } if($gameratemax<50) { $gameratemax=50; }	if($quiz_mingputype<2) { $quiz_mingputype=2; }; if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","3"); $to_search["gpu"]=1; }

			if (isset($_GET['swmedium']) && $_GET['swmedium']==1) 
			{ if($cadratemin<30) { $cadratemin=30; } if($cadratemax<50) { $cadratemax=50; } if ($gameratemin<45) { $gameratemin=45; } if($gameratemax<65) { $gameratemax=65; }	if($quiz_mingputype<2) { $quiz_mingputype=2; } if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","3","4"); $to_search["gpu"]=1; }
		
			if (isset($_GET['swheavy']) && $_GET['swheavy']==1) 
			{ if($cadratemin<50) { $cadratemin=50; } if ($gameratemin<1000) { $gameratemin=1000; }  if($quiz_mingputype<3) { $quiz_mingputype=3; } array_push($gpu_typelist,"3","4"); $to_search["gpu"]=1; }
		
			if (isset($_GET['3dsmaxlight']) && $_GET['3dsmaxlight']==1) 
			{ if($cadratemin<20) { $cadratemin=20; } if($cadratemax<35) { $cadratemax=35; } if ($gameratemin<30) { $gameratemin=30; } if($gameratemax<60) { $gameratemax=60; } if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","3","4"); $to_search["gpu"]=1; }

			if (isset($_GET['3dsmaxmedium']) && $_GET['3dsmaxmedium']==1) 
			{ if($cadratemin<35) { $cadratemin=35; } if($cadratemax<60) { $cadratemax=60; } if ($gameratemin<60) { $gameratemin=60; } if($gameratemax<80) { $gameratemax=80; } if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","3","4"); $to_search["gpu"]=1; }
		
			if (isset($_GET['3dsmaxheavy']) && $_GET['3dsmaxheavy']==1) 
			{ if($cadratemin<60) { $cadratemin=60; } if ($gameratemin<1000) { $gameratemin=1000; } if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","3","4"); $to_search["gpu"]=1; }
		
			if (isset($_GET['catialight']) && $_GET['catialight']==1) 
			{ if($cadratemin<25) { $cadratemin=25; } if($cadratemax<35) { $cadratemax=35; } if ($gameratemin<50) { $gameratemin=50; } if($gameratemax<70) { $gameratemax=70; } if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","3","4"); $to_search["gpu"]=1; }

			if (isset($_GET['catiamedium']) && $_GET['catiamedium']==1) 
			{ if($cadratemin<35) { $cadratemin=35; } if($cadratemax<60) { $cadratemax=60; } if ($gameratemin<70) { $gameratemin=70; } if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","3","4"); $to_search["gpu"]=1; }
		
			if (isset($_GET['catiaheavy']) && $_GET['catiaheavy']==1) 
			{ if($cadratemin<60) { $cadratemin=60; } if ($gameratemin<1000) { $gameratemin=1000; } if($quiz_mingputype<3) { $quiz_mingputype=3; } array_push($gpu_typelist,"3"); $to_search["gpu"]=1; }
		
			if (isset($_GET['rhinolight']) && $_GET['rhinolight']==1) 
			{ if($cadratemin<20) { $cadratemin=20; } if($cadratemax<35) { $cadratemax=35; } if ($gameratemin<30) { $gameratemin=30; } if($gameratemax<60) { $gameratemax=60; } if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","3","4"); $to_search["gpu"]=1; }

			if (isset($_GET['rhinomedium']) && $_GET['rhinomedium']==1) 
			{ if($cadratemin<35) { $cadratemin=35; } if($cadratemax<60) { $cadratemax=60; } if ($gameratemin<50) { $gameratemin=50; } if($gameratemax<80) { $gameratemax=80; } if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","3","4"); $to_search["gpu"]=1; }
		
			if (isset($_GET['rhinoheavy']) && $_GET['rhinoheavy']==1) 
			{ if($cadratemin<60) { $cadratemin=60; } if ($gameratemin<1000) { $gameratemin=1000; } if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","3","4"); $to_search["gpu"]=1; }
		
			if (isset($_GET['cadolight']) && $_GET['cadolight']==1) 
			{ if($cadratemin<25) { $cadratemin=25; } if($cadratemax<35) { $cadratemax=35; } if ($gameratemin<50) { $gameratemin=50; } if($gameratemax<70) { $gameratemax=70; }  if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","3","4"); $to_search["gpu"]=1; }
			
			if (isset($_GET['cadomedium']) && $_GET['cadomedium']==1) 
			{ if($cadratemin<30) { $cadratemin=30; } if($cadratemax<60) { $cadratemax=60; } if ($gameratemin<70) { $gameratemin=70; } if($quiz_mingputype<2) { $quiz_mingputype=2; } array_push($gpu_typelist,"2","3","4"); $to_search["gpu"]=1; }
		
			if (isset($_GET['cadoheavy']) && $_GET['cadoheavy']==1) 
			{ if($cadratemin<60) { $cadratemin=60; } if ($gameratemin<1000) { $gameratemin=1000; }  if($quiz_mingputype<3) { $quiz_mingputype=3; } array_push($gpu_typelist,"3"); $to_search["gpu"]=1; }

			if($to_search["gpu"]) {  $gpu_typelist=array_unique($gpu_typelist); for($i=0;$i<=$quiz_mingputype;$i++) { array_diff($gpu_typelist,strval($i)); } }
			
		//variabile de test
			//$cadratemin = 15;$cadratemax = 30;
			if($cadratemin!==0)
			{
				$query = "SELECT DISTINCT model FROM notebro_db.GPU WHERE (rating>=".$cadratemin." AND rating<=".$cadratemax." AND typegpu=3) OR (rating>=".$gameratemin." AND rating<=".$gameratemax." AND typegpu IN (".implode(",",$gpu_typelist)."))";
				//echo $query;
				$result = mysqli_query($GLOBALS['con'],$query); 
				while($row=mysqli_fetch_row($result)){$gpu_model[]=$row[0];} if(count($gpu_model)<1){ $gpu_typelist=["10"]; }
			}
			
			if(!$to_search["gpu"]) { if($quiz_mingputype<1) { $quiz_mingputype=0; } array_push($gpu_typelist,"0","1"); if($model_maxclass>=2) { $gpupowermax=35; }; $to_search["gpu"]=1; } 
			if($model_maxclass>=2) {  array_push($gpu_typelist,"3"); }
			$gpu_typelist=array_unique($gpu_typelist);
			//var_dump($gpu_model);
			break ;
		}
		
		case 'wnet' :
		{  
			//$to_search["wnet"] = 1;
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
			if (isset($_GET['atwork']) && $_GET['atwork']==1)
			{ $mdb_wwan=0; }

			if (isset($_GET['athome']) && $_GET['athome']==1)
			{ $mdb_wwan=1; }
			
			if (isset($_GET['atroad']) && $_GET['atroad']==1)
			{ $mdb_wwan=0; }
            
			break ;	
		}	
		case 'chassis' :
		{
			$chassisweightmax=999999; $chassisthicmax=999999;
			
			if (isset($_GET['desk']) && $_GET['desk']==1) 
			{ if($chassisweightmax>10) { $chassisweightmax = 10; } if($chassisthicmax>100){ $chassisthicmax = 100;} }
			
			if (isset($_GET['bed']) && $_GET['bed']==1) 
			{ if($chassisweightmax>2.35) { $chassisweightmax = 2.35; } if($chassisthicmax>27){ $chassisthicmax = 27;} /*$chassis_made[] = "Metal"; $chassis_made[] = "Aluminium"; $chassis_made[] = "Lithium"; $chassis_made[] = "Magnesium";*/ }
 									
			if (isset($_GET['house']) && $_GET['house']==1) 
			{ if($chassisweightmax>2.8) { $chassisweightmax = 2.8; } if($chassisthicmax>31){ $chassisthicmax = 31;} }
											
		    if (isset($_GET['lap']) && $_GET['lap']==1) 
			{ if($chassisweightmax>2.1) { $chassisweightmax = 2.1; } if($chassisthicmax>24){ $chassisthicmax = 24;} }
									
			if (isset($_GET['bag']) && $_GET['bag']==1) 
			{ 
				if(isset($_GET['displarge']) && $_GET['displarge']==1)
				{ if($chassisweightmax>3.6) { $chassisweightmax = 3.6; } if($chassisthicmax>37){ $chassisthicmax = 37;} }
				else
				{ if($chassisweightmax>2.8) { $chassisweightmax = 2.8; } if($chassisthicmax>35){ $chassisthicmax = 35;} }
			}
		
			if (isset($_GET['metal']) && $_GET['metal']==1 ) 
			{	$chassis_made[] = "Metal"; 	$chassis_made[] = "Aluminium"; 	$chassis_made[] = "Lithium";  $chassis_made[] = "Carbon"; $chassis_made[] = "Magnesium"; $chassis_made[] = "Glass fiber"; $chassis_made[] = "Shock-absorbing ultra-polymer";}		
			
			if (isset($_GET['media']) && $_GET['media']==1) 
			{ $chassis_vports[] = "HDMI"; $diffvisearch=2;} 
			
			if (isset($_GET['stylus']) && $_GET['stylus']==1) 
			{ $chassis_misc[] = "stylus";} 
		
			if (isset($_GET['convertible']) && $_GET['convertible']==1 ) 
			{	$chassis_twoinone = 1;	}
		
			if (isset($_GET['comm']) && $_GET['comm']==1 ) 
			{	$chassiswebmin = 0.92;	$chassis_misc[]="Microphone array"; }

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
			//$sist_sist=["Windows+Home","Windows+Pro","Windows+S","macOS","Chrome OS"]; } 
        	if (isset($_GET['atwork']) && $_GET['atwork']==1)
			{ $sist_sist=["Windows+Home","Windows+Pro"];  }

			if (isset($_GET['athome']) && $_GET['athome']==1)
			{ $sist_sist=["Windows+Home","Windows+S"]; if($model_maxclass>=2) {  $sist_sist[]="Windows+Pro"; } }
		
			if (isset($_GET['atroad']) && $_GET['atroad']==1)
			{ $sist_sist=["Windows+Home","Windows+Pro","Windows+S"]; } 
					
			break ;	
		}	
		
		case 'battery' :
		{
			if (isset($_GET['2hour']) && $_GET['2hour']==1) 
			{ $batlifemin = 0.9; }
			
			if (isset($_GET['6hour']) && $_GET['6hour']==1) 
			{ $batlifemin = 2.7; }
		
			if (isset($_GET['10hour']) && $_GET['10hour']==1) 
			{ $batlifemin = 4.9; }
		
			if (isset($_GET['12hour']) && $_GET['12hour']==1) 
			{ $batlifemin = 7.5; }
			break ;	
		}
		case 'budget' :
		{
			if($qsearchtype!="p" && $qsearchtype!="b"){ $budgetmin=99999999; $budgetmax=0; }
			if (isset($_GET['b500']) && $_GET['b500']==1)
			{ if(isset($budgetmin) && $budgetmin>150) { $budgetmin=150; } if(isset($budgetmax) && $budgetmax<550) { $budgetmax=550; } }
			
			if (isset($_GET['b750']) && $_GET['b750']==1) 
			{ if(isset($budgetmin) && $budgetmin>485) { $budgetmin=485; } if(isset($budgetmax) && $budgetmax<790) { $budgetmax=790; } }
		
			if (isset($_GET['b1000']) && $_GET['b1000']==1)
			{ if(isset($budgetmin) && $budgetmin>740) { $budgetmin=740; } if(isset($budgetmax) && $budgetmax<1095) { $budgetmax=1095; } }
		
			if (isset($_GET['b1500']) && $_GET['b1500']==1)
			{ if(isset($budgetmin) && $budgetmin>950) { $budgetmin=950; } if(isset($budgetmax) && $budgetmax<1600) { $budgetmax=1600; } }
		
			if (isset($_GET['b2000']) && $_GET['b2000']==1)
			{ if(isset($budgetmin) && $budgetmin>1425) { $budgetmin=1425; } if(isset($budgetmax) && $budgetmax<2150) { $budgetmax=2150; } }
		
			if (isset($_GET['b3000']) && $_GET['b3000']==1)
			{ if(isset($budgetmin) && $budgetmin>1850) { $budgetmin=1850; } if(isset($budgetmax) && $budgetmax<8000) { $budgetmax=99999; } }
			break ;	
		}
	}
}

foreach ($cpu_misc as $element)
		{	$cpumsc.='<option selected="selected">'.$element.'</option>';	}

foreach ($display_backt as $element)
		{	$displaymsc.='<option selected="selected">'.$element.'</option>';	}
		
foreach ($chassis_misc as $element)
		{	$chassisstuff.='<option selected="selected">'.$element.'</option>';	}	
if ($nr_hdd == 2) {$nrhddselect = "selected";}
if ($nr_hdd == 3) {$nrhddselect2 = "selected";}
if(isset($hdd_type)) { $valuetype[54] = $hdd_type; }
// de verificat de ce nu
foreach ($sist_sist as $element) 
		{ $valuetype[25][] = $element; }

foreach ($regions_name as $element)
		{	$regions.='<option selected="selected">'.$element.'</option>';	}
foreach ($gpu_typelist as $element)
			{ if ($element>=1)  {$gputype =2;}
			$gputypesel[$element]="selected"; }		
foreach ($chassis_made as $element)
		{	$valuetype[26][] = $element;	}	
if(isset($chassis_twoinone) && $chassis_twoinone == 1) {$twoinone_check = "checked";}
$bdgmin=$budgetmin;
$bdgmax=$budgetmax;
?>