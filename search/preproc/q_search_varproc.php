<?php
/* Quiz SEARCH */
//Initialising some generic values
//$cpu_tdpmin=0.01; 
$war_yearsmin=1;  $totalcapmin = 0; $totalcapmax = 8192;  $chassis_weightmin=0.01; $diffsearch=0;
//$batlife_min=0;
//$batlife_max=1000;
//$acum_capmin=0.01;
$isquiz = 1;
$hdd_type = array();$chassis_made= array(); $chassis_msc=array();
$chassis_ports=array();$gpu_model = array();$cpu_misc = array();
$chassis_vports=array();
$fam_model = array();

// BUDGET val min and max

if(isset($_GET['qtype'])) { $qsearchtype = strval($_GET['qtype']); } else { $qsearchtype=""; }

$result = mysqli_query($GLOBALS['con'], "SELECT * FROM notebro_site.nomen WHERE type = 18 OR type=21 OR type=22 OR type=33 OR type=34 OR type = 35 OR type = 36 OR type=59 OR type=60  OR type = 61 OR type = 62 OR type=67 OR type=68  OR type =70 OR type=71  OR type =81 ORDER BY type ASC");
while( $row=mysqli_fetch_array($result)){ $nomenvalues[]=$row; }

$cpu_ldatemax = $nomenvalues[0][2];//echo $cpu_ldatemin ;
$cpu_tdpmin = $nomenvalues[1][2];
$cpu_tdpmax = $nomenvalues[2][2];
$hdd_capmin = round($nomenvalues[3][2]); //echo $hdd_capmin;
$hdd_capmax = round($nomenvalues[4][2]); 
$mem_capmin=round($nomenvalues[5][2]); //echo $mem_capmin;
$mem_capmax=round($nomenvalues[6][2]); //echo $mem_capmax;
$batlife_min=$nomenvalues[7][2];  // from nomen
$batlife_max=$nomenvalues[8][2];// from nomen 
$gpu_powermin = round($nomenvalues[9][2]);
$gpu_powermax = round($nomenvalues[10][2]);
$display_vresmin=$nomenvalues[11][2];
$display_vresmax=$nomenvalues[12][2];
$price_min=$nomenvalues[13][2];
$price_max=$nomenvalues[14][2];
$gpu_ldatemax = $nomenvalues[15][2]; //echo $gpu_ldatemin;

//pt selectia anului si scaderea cu 2 pt procesoare
$datecpu = array();
$datecpu = explode("-",$cpu_ldatemax);//echo $date[0];
$datecpu[0] = $datecpu[0]-2;

$chassis_weightmin = 0;
$size = 0;
$batlife = 0;
$cadratemin="15"; $cadratemax=""; $gameratemin="30"; $gameratemax="";


//LIST OF COMPONENTS WE WILL FILTER
$to_search = array(
	"model"   => 1,
    "acum"    => 0,
    "chassis" => 1,
    "cpu"     => 1,
    "display" => 1,
    "gpu"     => 1,
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

foreach (array("model","cpu", "display", "gpu", "acum", "war", "hdd", "shdd", "wnet", "sist", "odd", "mem", "mdb", "chassis","battery","budget") as $v) 
{
	switch($v)
	{
		case 'model' :
		{
			$regions_name[]="US and Canada";
			if (isset($_GET['atwork']) && $_GET['atwork']==1)
			{ $model_class=1; }

			if (isset($_GET['athome']) && $_GET['athome']==1)
			{ $model_class=0; }
							
			break;
		}
		
		case 'cpu':
		{
			if (isset($_GET['calc']) && $_GET['calc']==1)
			{ 
				$cpu_turbomax = 3.5;
				$cpu_misc[]="HT";							
			}
				
			if (isset($_GET['coding']) && $_GET['coding']==1)
			{ $cpu_coremin = 4; }
		
			if (isset($_GET['sysadmin']) && $_GET['sysadmin']==1)
			{ $cpu_coremin = 4; }
		
			if (isset($_GET['lvedit']) && $_GET['lvedit']==1 && $cpu_coremin < 2)
			{ $cpu_coremin = 2;  $cpu_misc[]="HT"; }

			if (isset($_GET['hvedit']) && $_GET['hvedit']==1 )
			{ $cpu_coremin = 4;  $cpu_misc[]="HT"; }			
								
			if (isset($_GET['swlight']) && $_GET['swlight']==1  && $cpu_coremin < 2)
			{$cpu_coremin = 2;  $cpu_misc[]="HT"; $cpu_maxtfmax > 3; }

			if (isset($_GET['swmedium']) && $_GET['swmedium']==1 ) 
			{ $cpu_coremin = 4;}
	
			if (isset($_GET['swheavy']) && $_GET['swheavy']==1 )
			{ $cpu_coremin = 4;}
	
			if (isset($_GET['3dsmaxlight']) && $_GET['3dsmaxlight']==1  && $cpu_coremin < 2)
			{$cpu_coremin = 2;  $cpu_misc[]="HT"; $cpu_maxtfmax > 3; }

			if (isset($_GET['3dsmaxmedium']) && $_GET['3dsmaxmedium']==1) 
			{ $cpu_coremin = 4;}
	
			if (isset($_GET['3dsmaxheavy']) && $_GET['3dsmaxheavy']==1 ) 
			{$cpu_coremin = 4; }
	
			if (isset($_GET['catialight']) && $_GET['catialight']==1 && $cpu_coremin < 2)
			{$cpu_coremin = 2;  $cpu_misc[]="HT"; $cpu_maxtfmax > 3.5; }

			if (isset($_GET['catiamedium']) && $_GET['catiamedium']==1 ) 
			{ $cpu_coremin = 4; }
	
			if (isset($_GET['catiaheavy']) && $_GET['catiaheavy']==1) 
			{ $cpu_coremin = 4;}
	
			if (isset($_GET['rhinolight']) && $_GET['rhinolight']==1  && $cpu_coremin < 2) 
			{ $cpu_coremin = 2;  $cpu_misc[]="HT"; $cpu_maxtfmax > 3;}

			if (isset($_GET['rhinomedium']) && $_GET['rhinomedium']==1) 
			{ $cpu_coremin = 4;}
	
			if (isset($_GET['rhinoheavy']) && $_GET['rhinoheavy']==1 ) 
			{ $cpu_coremin = 4;}
	
			if (isset($_GET['cadolight']) && $_GET['cadolight']==1  && $cpu_coremin < 2) 
			{ $cpu_coremin = 2;  $cpu_misc[]="HT"; $cpu_maxtfmax > 3.5; }

			if (isset($_GET['cadomedium']) && $_GET['cadomedium']==1 ) 
			{  $cpu_coremin = 4;}
	
			if (isset($_GET['cadoheavy']) && $_GET['cadoheavy']==1 ) 
			{  $cpu_coremin = 4;}
	
			break ;
		}
		case 'display' :
		{
			if (isset($_GET['bed']) && $_GET['bed']==1) 
			{	$display_sizemin =13;	$display_sizemax =16; }
								
			if (isset($_GET['house']) && $_GET['house']==1) 
			{	$display_sizemin =13; $display_sizemax =16;	}
													
			if (isset($_GET['lap'])	&& $_GET['lap']==1 ) 
			{   $display_sizemin =10;	$display_sizemax =14; }
								
			if (isset($_GET['everywhere']) && $_GET['everywhere']==1) 
			{	$display_sizemin =10;	$display_sizemax =14; }
								
			if (isset($_GET['60srgb']) && $_GET['60srgb'] ==1) 
			{ $display_backt[] = "LED IPS";		$display_backt[] = "LED IPS PenTile"; }
																	
			if (isset($_GET['90srgb']) && $_GET['90srgb']==1) 
			{  $display_backt[] = "LED IPS"; $display_sRGB = 80; }
									
			if (isset($_GET['media'])&& $_GET['media']==1 ) 
			{ $display_backt[] = "LED IPS";	$display_backt[] = "LED IPS PenTile"; }
		
			if (isset($_GET['FHDplus'])&& $_GET['FHDplus']==1 ) 
			{ $display_vresmin = 1080; }
			break ;
		}
		case 'mem' :
		{   
			if (isset($_GET['oldgameslow']) && $_GET['oldgameslow']==1 && $mem_capmin < 4) 
			{ $mem_capmin = 4;}
																	
			if (isset($_GET['oldgamesmedium']) && $_GET['oldgamesmedium']==1 && $mem_capmin < 8) 
			{$mem_capmin = 8;}
																						
			if (isset($_GET['oldgameshigh']) && $_GET['oldgameshigh']==1 && $mem_capmin < 8) 
			{$mem_capmin = 8;}
																
			if (isset($_GET['mmolow']) && $_GET['mmolow']==1 && $mem_capmin < 8) 
			{$mem_capmin = 8;}
																
			if (isset($_GET['mmomedium']) && $_GET['mmomedium']==1 && $mem_capmin < 8) 
			{ $mem_capmin = 8;}
																						
			if (isset($_GET['mmohigh']) && $_GET['mmohigh']==1 && $mem_capmin < 8) 
			{ $mem_capmin = 8;}
													
			if (isset($_GET['3dgameslow']) && $_GET['3dgameslow']==1 && $mem_capmin < 16) 
			{ $mem_capmin = 16;}
														
			if (isset($_GET['3dgamesmedium']) && $_GET['3dgamesmedium']==1 && $mem_capmin < 16) 
			{	$mem_capmin = 16;}
																						
			if (isset($_GET['3dgameshigh']) && $_GET['3dgameshigh']==1 && $mem_capmin < 16) 
			{  $mem_capmin = 16;}
										
			if (isset($_GET['internet']) && $_GET['internet']==1 && $mem_capmin < 4) 
			{$mem_capmin = 4;}
									
			if (isset($_GET['calc']) && $_GET['calc']==1 && $mem_capmin < 4) 
			{ $mem_capmin = 4;	}

			if (isset($_GET['coding']) && $_GET['coding']==1 && $mem_capmin < 16) 
			{ $mem_capmin = 16;	}
									
			if (isset($_GET['sysadmin']) && $_GET['sysadmin'] && $mem_capmin < 16) 
			{	$mem_capmin = 16;}
			
			if (isset($_GET['autocadmedium']) && $_GET['autocadmedium']==1 && $mem_capmin < 8) 
			{  $mem_capmin = 8; }
		
			if (isset($_GET['autocadheavy']) && $_GET['autocadheavy']==1 && $mem_capmin < 16) 
			{  $mem_capmin = 16; }
		
			if (isset($_GET['swlight']) && $_GET['swlight']==1 && $mem_capmin < 8) 
			{	$mem_capmin = 8;}

			if (isset($_GET['swmedium']) && $_GET['swmedium']==1 && $mem_capmin < 16) 
			{	$mem_capmin = 16;}
		
			if (isset($_GET['swheavy']) && $_GET['swheavy']==1 && $mem_capmin < 16) 
			{	$mem_capmin = 16;}
		
			if (isset($_GET['3dsmaxlight']) && $_GET['3dsmaxlight']==1 && $mem_capmin < 8) 
			{	$mem_capmin = 8;}

			if (isset($_GET['3dsmaxmedium']) && $_GET['3dsmaxmedium']==1 && $mem_capmin < 16) 
			{	$mem_capmin = 16;}
		
			if (isset($_GET['3dsmaxheavy']) && $_GET['3dsmaxheavy']==1 && $mem_capmin < 16) 
			{	$mem_capmin = 16;}
		
			if (isset($_GET['catialight']) && $_GET['catialight']==1 && $mem_capmin < 8) 
			{	$mem_capmin = 8;}

			if (isset($_GET['rhinolight']) && $_GET['rhinolight']==1 && $mem_capmin < 8) 
			{	$mem_capmin = 8;}

			if (isset($_GET['rhinomedium']) && $_GET['rhinomedium']==1 && $mem_capmin < 16) 
			{	$mem_capmin = 16;}
		
			if (isset($_GET['rhinoheavy']) && $_GET['rhinoheavy']==1 && $mem_capmin < 16) 
			{	$mem_capmin = 16;}
		
			if (isset($_GET['cadolight']) && $_GET['cadolight']==1 && $mem_capmin < 8) 
			{	$mem_capmin = 8;}       
		
			break ;
		}				
		case 'hdd' :
		{
			if (isset($_GET['3dgameslow']) && $_GET['3dgameslow']==1 && $hdd_capmin < 500) 
			{ $hdd_capmin = 500;	}
											
			if (isset($_GET['3dgamesmedium']) && $_GET['3dgamesmedium']==1 && $hdd_capmin = 500) 
			{ $hdd_capmin = 500;}
											
			if (isset($_GET['3dgameshigh']) && $_GET['3dgameshigh']==1 && $hdd_capmin < 500) 
			{ $hdd_capmin = 500;}
										
			if (isset($_GET['60srgb']) && $_GET['60srgb']==1 && $hdd_capmin < 200) 
			{ $hdd_capmin = 200;}
																		
			if (isset($_GET['90srgb']) && $_GET['90srgb']==1 && $hdd_capmin < 500) 
			{ $hdd_capmin = 500; }
																											
			if (isset($_GET['lvedit']) && $_GET['lvedit']==1 && $hdd_capmin < 200) 
			{	$hdd_capmin = 200;	}
																	
			if (isset($_GET['hvedit']) && $_GET['hvedit']==1 && $hdd_capmin < 1000) 
			{	$hdd_capmin = 1000;	}
		
			if (isset($_GET['swlight']) && $_GET['swlight']==1 && $hdd_capmin < 500) 
			{	$hdd_capmin = 500; }

			if (isset($_GET['swmedium']) && $_GET['swmedium']==1 && $hdd_capmin < 500) 
			{ $hdd_capmin = 500; }
		
			if (isset($_GET['swheavy']) && $_GET['swheavy']==1 && $hdd_capmin < 500) 
			{ $hdd_capmin = 500;}
		
			if (isset($_GET['3dsmaxlight']) && $_GET['3dsmaxlight']==1 && $hdd_capmin < 500) 
			{	$hdd_capmin = 500;}

			if (isset($_GET['3dsmaxmedium']) && $_GET['3dsmaxmedium']==1 && $hdd_capmin < 500) 
			{  $hdd_capmin = 500;}
		
			if (isset($_GET['3dsmaxheavy']) && $_GET['3dsmaxheavy']==1 && $hdd_capmin < 500) 
			{$hdd_capmin = 500; }
		
			if (isset($_GET['catialight']) && $_GET['catialight']==1 && $hdd_capmin < 500) 
			{	$hdd_capmin = 500; }

			if (isset($_GET['catiamedium']) && $_GET['catiamedium']==1 && $hdd_capmin < 500) 
			{ $hdd_capmin = 500; }
		
			if (isset($_GET['catiaheavy']) && $_GET['catiaheavy']==1 && $hdd_capmin < 500) 
			{ $hdd_capmin = 500;}
		
			if (isset($_GET['rhinolight']) && $_GET['rhinolight']==1 && $hdd_capmin < 500) 
			{ $hdd_capmin = 500;}

			if (isset($_GET['rhinomedium']) && $_GET['rhinomedium']==1 && $hdd_capmin < 500) 
			{ $hdd_capmin = 500;}
		
			if (isset($_GET['rhinoheavy']) && $_GET['rhinoheavy']==1 && $hdd_capmin < 500) 
			{  $hdd_capmin = 500;}
		
			if (isset($_GET['cadolight']) && $_GET['cadolight']==1 && $hdd_capmin < 500) 
			{ $hdd_capmin = 500; }

			if (isset($_GET['cadomedium']) && $_GET['cadomedium']==1 && $hdd_capmin < 500) 
			{  $hdd_capmin = 500;}
		
			if (isset($_GET['cadoheavy']) && $_GET['cadoheavy']==1 && $hdd_capmin < 500) 
			{  $hdd_capmin = 500;}
		
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
			if (isset($_GET['oldgameslow']) && $_GET['oldgameslow']==1) 
			{ $gpu_typelist[] = 0; $gpu_typelist[] = 1; }
																	
			if (isset($_GET['oldgamesmedium']) && $_GET['oldgamesmedium']==1) 
			{ $gpu_typelist[] = 1; }
																							
			if (isset($_GET['oldgameshigh']) && $_GET['oldgameshigh']==1) 
			{ $gpu_typelist[] = 2; $gpu_powermax = 35; }
											
			if (isset($_GET['mmolow']) && $_GET['mmolow']==1) 
			{$gpu_typelist[] = 0; $gpu_typelist[] = 1;	}
											
			if (isset($_GET['mmomedium']) && $_GET['mmomedium']==1) 
			{ $gpu_powermin = 30; $gpu_powermax = 69; }
											
			if (isset($_GET['mmohigh']) && $_GET['mmohigh']==1 && $gpu_powermin < 55) 
			{ $gpu_powermin = 55; }
										
			if (isset($_GET['3dgameslow']) && $_GET['3dgameslow']==1) 
			{ $gpu_powermin = 30; $gpu_powermax = 69; }
																	
			if (isset($_GET['3dgamesmedium']) && $_GET['3dgamesmedium']==1 && $gpu_powermin < 55) 
			{ $gpu_powermin = 55; }
															
			if (isset($_GET['3dgameshigh']) && $_GET['3dgameshigh']==1) 
			{ $gpu_typelist[] = 4; }
							
			$cadratemin="0"; $cadratemax="0"; $gameratemin="0"; $gameratemax="100";
			
			if (isset($_GET['autocadlight']) && $_GET['autocadlight']==1) 
			{	$gpu_typelist[] = 0; $gpu_typelist[] = 1; $gpu_typelist[] = 3; $gpu_powermax = 35; }

			if (isset($_GET['autocadmedium']) && $_GET['autocadmedium']==1) 
			{	$gpu_typelist[] = 2; $gpu_typelist[] = 3; $cadratemin="15"; $cadratemax="25"; $gameratemin="30"; $gameratemax="50"; }
		
			if (isset($_GET['autocadheavy']) && $_GET['autocadheavy']==1) 
			{ $cadratemin="20"; $cadratemax="35"; $gameratemin="40"; $gameratemax="65";	$gpu_typelist[] = 2; $gpu_typelist[] = 3; $gpu_typelist[] = 4; }
		
			if (isset($_GET['swlight']) && $_GET['swlight']==1) 
			{ $cadratemin="15"; $cadratemax="30"; $gameratemin="30"; $gameratemax="50"; $gpu_typelist[] = 2; $gpu_typelist[] = 3;  }

			if (isset($_GET['swmedium']) && $_GET['swmedium']==1) 
			{ $cadratemin="30"; $cadratemax="50"; $gameratemin="45"; $gameratemax="65"; $gpu_typelist[] = 2; $gpu_typelist[] = 3; $gpu_typelist[] = 4; }
		
			if (isset($_GET['swheavy']) && $_GET['swheavy']==1) 
			{ $cadratemin="50"; $gpu_typelist[] = 2; $gpu_typelist[] = 3; $gpu_typelist[] = 4; }
		
			if (isset($_GET['3dsmaxlight']) && $_GET['3dsmaxlight']==1) 
			{	$cadratemin="20"; $cadratemax="35"; $gameratemin="30"; $gameratemax="60"; $gpu_typelist[] = 2; $gpu_typelist[] = 3;  $gpu_typelist[] = 4; }

			if (isset($_GET['3dsmaxmedium']) && $_GET['3dsmaxmedium']==1) 
			{ $cadratemin="35"; $cadratemax="60"; $gameratemin="50"; $gameratemax="80"; $gpu_typelist[] = 2; $gpu_typelist[] = 3; $gpu_typelist[] = 4; }
		
			if (isset($_GET['3dsmaxheavy']) && $_GET['3dsmaxheavy']==1) 
			{ $cadratemin="60"; $gpu_typelist[] = 2; $gpu_typelist[] = 3; $gpu_typelist[] = 4; }
		
			if (isset($_GET['catialight']) && $_GET['catialight']==1) 
			{	$cadratemin="25"; $cadratemax="35"; $gameratemin="50"; $gameratemax="70"; $gpu_typelist[] = 2; $gpu_typelist[] = 3;  $gpu_typelist[] = 4; }

			if (isset($_GET['catiamedium']) && $_GET['catiamedium']==1) 
			{ $cadratemin="35"; $cadratemax="60"; $gameratemin="70"; $gpu_typelist[] = 2; $gpu_typelist[] = 3; $gpu_typelist[] = 4; }
		
			if (isset($_GET['catiaheavy']) && $_GET['catiaheavy']==1) 
			{ $cadratemin="60"; $gpu_typelist[] = 3; }
		
			if (isset($_GET['rhinolight']) && $_GET['rhinolight']==1) 
			{	$cadratemin="20"; $cadratemax="35"; $gameratemin="30"; $gameratemax="60"; $gpu_typelist[] = 2; $gpu_typelist[] = 3;  $gpu_typelist[] = 4; }

			if (isset($_GET['rhinomedium']) && $_GET['rhinomedium']==1) 
			{ $cadratemin="35"; $cadratemax="60"; $gameratemin="50"; $gameratemax="80"; $gpu_typelist[] = 2; $gpu_typelist[] = 3; $gpu_typelist[] = 4; }
		
			if (isset($_GET['rhinoheavy']) && $_GET['rhinoheavy']==1) 
			{  $cadratemin="60"; $gpu_typelist[] = 2; $gpu_typelist[] = 3; $gpu_typelist[] = 4; }
		
			if (isset($_GET['cadolight']) && $_GET['cadolight']==1) 
			{ $cadratemin="25"; $cadratemax="35"; $gameratemin="50"; $gameratemax="70"; $gpu_typelist[] = 2; $gpu_typelist[] = 3;  $gpu_typelist[] = 4; }

			if (isset($_GET['cadomedium']) && $_GET['cadomedium']==1) 
			{ $cadratemin="35"; $cadratemax="60"; $gameratemin="70"; $gpu_typelist[] = 2; $gpu_typelist[] = 3; $gpu_typelist[] = 4; }
		
			if (isset($_GET['cadoheavy']) && $_GET['cadoheavy']==1) 
			{  $cadratemin="60"; $gpu_typelist[] = 3; }
		
		
		//variabile de test
			//$cadratemin = 15;$cadratemax = 30;
			if($cadratemin!=="0")
			{
				$query = "SELECT DISTINCT model FROM notebro_db.GPU WHERE (rating>=".$cadratemin." AND rating<=".$cadratemax." AND typegpu=3) OR (rating>=".$gameratemin." AND rating<=".$gameratemax." AND typegpu IN (1,2,4))";  //echo $query;
				$result = mysqli_query($GLOBALS['con'],$query); 
				while($row=mysqli_fetch_row($result)){$gpu_model[]=$row[0];}
			}
			
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
			// $to_search["odd"] = 1;
            break ;
		}	
	
		
		case 'mdb' :
		{	
			if (isset($_GET['atwork']) && $_GET['atwork']==1)
			{ $mdb_wwan=0; }

			if (isset($_GET['athome']) && $_GET['athome']==1)
			{ $mdb_wwan=1; }
			
			if (isset($_GET['atboth']) && $_GET['atboth']==1)
			{ $mdb_wwan=0; }
            
			break ;	
		}	
		case 'chassis' :
		{
			if (isset($_GET['bed']) && $_GET['bed']==1) 
			{ $chassis_weightmax = 2.4;	$chassis_thicmax = 26;}
									
			if (isset($_GET['house']) && $_GET['house']==1) 
			{$chassis_weightmax = 2.7; $chassis_thicmax = 30;}
											
		    if (isset($_GET['lap']) && $_GET['lap']==1) 
			{	$chassis_weightmax = 2.3;	$chassis_thicmax = 23; }
									
			if (isset($_GET['everywhere']) && $_GET['everywhere']==1 ) 
			{	$chassis_weightmax = 2.1;	$chassis_thicmax = 20.5;}
			
			if (isset($_GET['metal']) && $_GET['metal']==1 ) 
			{	$chassis_made[] = "Metal"; 	$chassis_made[] = "Aluminium"; 	$chassis_made[] = "Lithium";  $chassis_made[] = "Carbon"; $chassis_made[] = "Magnesium"; $chassis_made[] = "Glass fiber"; $chassis_made[] = "Shock-absorbing ultra-polymer";}		
			
			if (isset($_GET['stylus']) && $_GET['stylus']==1) 
			{ $chassis_misc[] = "stylus";} 
		
			if (isset($_GET['convertible']) && $_GET['convertible']==1 ) 
			{	$chassis_twoinone = 1;	}
		
			if (isset($_GET['comm']) && $_GET['comm']==1 ) 
			{	$chassis_webmin = 0.92;	}

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
			{ $sist_sist=["Windows+Home","Windows+S"]; }
		
			if (isset($_GET['atboth']) && $_GET['atboth']==1)
			{ $sist_sist=["Windows+Home","Windows+Pro","Windows+S"]; } 
					
			break ;	
		}	
		
		case 'battery' :
		{
			if (isset($_GET['2hour']) && $_GET['2hour']==1) 
			{ $batlife_min = 1; }
			
			if (isset($_GET['6hour']) && $_GET['6hour']==1) 
			{ $batlife_min = 3; }
		
			if (isset($_GET['10hour']) && $_GET['10hour']==1) 
			{ $batlife_min = 6; }
		
			if (isset($_GET['12hour']) && $_GET['12hour']==1) 
			{ $batlife_min = 9; }
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

//$chassis_twoinone = 1;
//$chassis_weightmax = 2.1;	
//$chassis_thicmax = 2.05;

//$mem_capmin = 8;

//$nrhdd =2;
// $hdd_capmin = 500;
 
// $gpu_typelist[] = 2; 
// $gpu_typelist[] = 3;  
// $gpu_typelist[] = 4;
// $gpu_powermin = 30; 
// $gpu_powermax = 69;

// $cadratemin="15"; 
//$cadratemax="30"; 
//$gameratemin="30"; 
//$gameratemax="50";
 
// $cpu_turbomax = 3.5;
 //$cpu_misc[]="HT";	
 //$cpu_coremin = 4;
 
//$display_sizemin =13;	
//$display_sizemax =16; 
 //$display_backt[] = "LED IPS";	
 //$display_backt[] = "LED IPS PenTile"; 
//$display_vresmin = 1080; 
 
}

/* some adjustments based on budget*/

if($budgetmax>800)
{
	$sist_sist[]="macOS"; 
  //FHDplus
  //LED IPS , IPS PentTile TN WVA OLED
  //SSD min 179 GB
  // 8GB mem 
  //Windows 10 Home , 10 Pro, 10 S , macOS
}
else
{
	$sist_sist[]="Chrome OS"; 
}

?>