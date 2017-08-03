<?php
/* Quiz SEARCH */
//Initialising some generic values
//$cpu_tdpmin=0.01; 
$war_yearsmin=0.01;  $wnet_ratemin=0.00; $sist_pricemax=1; $odd_speedmin=0.01; $totalcapmin = 0; 
 $mdb_ratemin=0.01; $chassis_weightmin=0.01;
$diffsearch=0;
//$batlife_min=0;
//$batlife_max=1000;
$acum_capmin=0.01;
$mdb_wwan = 1;
$isquiz = 1;
$hdd_type = array();$chassis_made= array(); $chassis_msc=array();
$chassis_ports=array();
$chassis_vports=array();
$fam_model = array();


// BUDGET val min and max

if($_GET['bdgmin']) { $budgetmin = (floatval($_GET['bdgmin'])/$exch)-1; } 
if($_GET['bdgmax']) { $budgetmax = (floatval($_GET['bdgmax'])/$exch)+1; }

$result = mysqli_query($GLOBALS['con'], "SELECT * FROM notebro_site.nomen WHERE type = 18 OR type=21 OR type=22 OR type=33 OR type=34 OR type = 35 OR type = 36 OR type=59 OR type=60  OR type = 61 OR type = 62 OR type=65 OR type=66 OR type=67 OR type=68  OR type =81 ORDER BY type ASC");

while( $row=mysqli_fetch_array($result))
{
	$nomenvalues[]=$row; 
}
$cpu_ldatemax = $nomenvalues[0][2];//echo $cpu_ldatemin ;
$cpu_tdpmin = $nomenvalues[1][2];
$cpu_tdpmax = $nomenvalues[2][2];
$hdd_capmin = round($nomenvalues[3][2]); //echo $hdd_capmin;
$hdd_capmax = round($nomenvalues[4][2]); 
$mem_capmin=round($nomenvalues[5][2]); //echo $mem_capmin;
$mem_capmax=round($nomenvalues[6][2]); //echo $mem_capmax;
$batlife_min=round($nomenvalues[7][2]);  // from nomen
$batlife_max=round($nomenvalues[8][2]);// from nomen 
$gpu_powermin = round($nomenvalues[9][2]);
$gpu_powermax = round($nomenvalues[10][2]);
$display_hresmin=$nomenvalues[11][2];
$display_hresmax=$nomenvalues[12][2];
$display_vresmin=$nomenvalues[13][2];
$display_vresmax=$nomenvalues[14][2];
$gpu_ldatemax = $nomenvalues[15][2]; //echo $gpu_ldatemin;

//pt selectia anului si scaderea cu 2 pt procesoare
$datecpu = array();
$datecpu = explode("-",$cpu_ldatemax);//echo $date[0];
$datecpu[0] = $datecpu[0]-2;

//Selectam by default toate sistemele de operare si apoi eliminam din ele. (silviu)


//LIST OF COMPONENTS WE WILL FILTER
$to_search = array(
	"model"   => 1,
    "acum"    => 1,
    "chassis" => 1,
    "cpu"     => 1,
    "display" => 1,
    "gpu"     => 1,
    "hdd"     => 1,
    "mdb"     => 1,
    "mem"     => 1,
    "odd"     => 0,
    "prod"    => 1,
    "shdd"    => 0,
    "sist"    => 1,
    "war"     => 1,
    "wnet"    => 1,
	"regions" => 1
);

 //*************************************You will use your laptop mainly ...

if (isset($_GET['athome'])) 
{
	switch ($_GET['athome']) 
	{
		case "1": //normal
		{
			$gpu_typelist[] = 0;
			$gpu_typelist[] = 1;
			$gpu_typelist[] = 2;
			$gpu_typelist[] = 4;
			break;
		}
	}
} else {}

if (isset($_GET['atwork']))
{
	switch ($_GET['atwork'])	
	{	
		case "1"://business
		{	//$gpu_typelist[] = 3;
			$fam_model = array('latitude 12','latitude 14','latitude 14 extreme','precision 15','precision 17', 'thinkpad', 'toughbook', 'toughpad','workstation','zbook studio','zbook'); //var_dump($family_model);
			//+ HDMI port (Silviu)
			break;
		}
	}
} else {}

if (isset($_GET['atroad']))
{
	switch ($_GET['atroad'])
	{	
		case "1"://ultraportable
		{
			break;
		}
	}
} else {}


//********************************************* You will keep it mainly ...

if (isset($_GET['desk']))
{
	switch ($_GET['desk'])  
	{  			
		case "1":  //on a desk
		{
		// 14 inch display min
			break;
		}
	}
} else {}

if (isset($_GET['bed']))
{
	switch ($_GET['bed'])
	{  
		case "1": // in bed
		{
			$chassis_weightmax=2;
			$cpu_tdpmax = 30;
			// metal chassis
			break;
		}
	}
} else {}

if (isset($_GET['lap']))
{
	switch ($_GET['lap'])
	{	  
		case "1": // on your lap
		{ 	
			$chassis_weightmax=1.8;
			$cpu_tdpmax = 25;	
			$display_surft = "matte";
			//max display size 15 inch
			break;
		}
	}
} else {}

if (isset($_GET['house']))
{
	switch ($_GET['house'])
	{  
		case "1": // around the house
		{
			$chassis_weightmax=2.1;
			break;
		}
}
} else {}

if (isset($_GET['everywhere']))
{
	switch ($_GET['everywhere'])
	{  
		case "1": // with you, everywhere
		{
			$display_surft = "matte";  
			$chassis_weightmax=1.5;
			//display size max 14 inch
			//wireless
			break;
		}
	}
} else {}

$gpu_typelist=array_unique($gpu_typelist);

//******************************You will user it daily for (multiple choices):

if (isset($_GET['internet']))
{
	switch ($_GET['internet']) 
	{
		case "1":  //internet browsing
		{
			$mem_capmin = 4;
			break;
		}
	}
} else {}

if (isset($_GET['comm']))
{
	switch ($_GET['comm']) 
	{			
		case "1": //chatting and video calls
		{
			$chassis_webmin= 0.9;
			$chassis_msc[]="microphone";  //microphone array!!!
			$mem_capmin = 4;
			break;
		}
	}
} else {}

if (isset($_GET['writing']))
{
	switch ($_GET['writing']) 
	{		
		case "1": //document writing
		{
			$mem_capmin = 2;
			break;
		}
	}	
}else {}

if (isset($_GET['calc']))
{
	switch ($_GET['calc']) 
	{	
		case "1": //struggling with spreadsheets
		{
			if ($cpu_tdpmin <= 5) {$cpu_tdpmin = 5;}
			$mem_capmin = 4;
			//hyperthreading
			$display_vresmin = 1080;
			break;
		}
	}
} else {}

if (isset($_GET['coding']))
{
	switch ($_GET['coding']) 
	{	
		case "1":  //computer coding
		{
			if ($mem_capmin <= 8) {$mem_capmin = 8;}
			if ($mem_capmax <= 16) {$mem_capmax = 16;}
			$cpu_tdpmin = 5;
			$display_vresmin = 1080; 
			break;
		}
	}
} else {}

if (isset($_GET['media']))
{
	switch ($_GET['media']) 
	{	
		case "6": 
		{
			$hdd_capmin = 128;
			if ($cpu_tdpmin <= 5){ $cpu_tdpmin = 5; }
			if ($mem_capmin <= 4) { $mem_capmin = 4; }
			if ($mem_capmax <= 16) { $mem_capmax = 16; }
			$display_vresmin = 1080; 
			$display_hresmin = 1920;
			// add LED IPS , IPS Pen-tile sau LED TN WVA
			break;
		}	
	} 
} else {}



  //*******************************You will also use it for (multiple choices):
if (isset($_GET['games']))
{  
	switch ($_GET['games'])
	{
		case "1": //playing games
		{
			$sist_sist[]="Windows+Pro"; $sist_sist[]="Windows+Home";
			$cpu_ldmin = $datecpu[0].'-06-01';
			if ($hdd_capmin<=256){$hdd_capmin=256;}	

			if (isset($_GET['2dgames']))
			{ 	
				switch ($_GET['2dgames']) 
				{
					case "1":
					{	
						//integrated + basic
						/*$batlife_min =$batlife_min*40/100;// echo $mem_capmin;*/
						break;
					}
				}
			}
			
			if (isset($_GET['oldgames']))
			{
				switch ($_GET['oldgames']) 
				{
					case "1": 
					if (isset($_GET['athome'])) {$gpu_typelist = array(1,2,4);} else {$gpu_typelist = array(1,2,3,4);}
					if ($mem_capmin<=2){$mem_capmin=2;}
					//integrated + basic
					break;
				}
			}
			
			if (isset($_GET['mmo']))
			{
				switch ($_GET['mmo']) 
				{
					case "1": 
					{
						if ($mem_capmin <= 4 ){$mem_capmin = 4;}
						if ($gpu_powermin <= 30) {$gpu_powermin = 30;}
						$gpu_maxmemmin = 2048;
						if (isset($_GET['athome'])) {$gpu_typelist = array(1,2,4);} else {$gpu_typelist = array(1,2,3,4);}
						$sist_sist[]="Windows+Pro"; $sist_sist[]="Windows+Home";
						// basic + gaming
						break;
					}
				}
			}

			if (isset($_GET['3dgames']))
			{
				switch ($_GET['3dgames']) 
				{
					case "1": 
					{
						if ($mem_capmin <= 16 ){$mem_capmin = 16;}
						if ($gpu_powermin <= 70) {$gpu_powermin = 70;}
						$gpu_maxmemmin = 2048;
						if (isset($_GET['athome'])) {$gpu_typelist = array(1,2,4);} else {$gpu_typelist = array(1,2,3,4);}
						$cpu_coremin = 4;
						break;
					}
				}
			}

			break;
		}
	}
} else {}


if (isset($_GET['pedit']))
{
	switch ($_GET['pedit']) 
	{
		case "1":  //photo editing, illustration
		{
			$display_backt = 'LED IPS'; // IPS Pen-tile
			if ($mem_capmin <= 6) {$mem_capmin = 6;}
			if ($mem_capmax <= 32) {$mem_capmax = round($nomenvalues[5][2]);}
			IF ($cpu_tdpmin <= 5){$cpu_tdpmin = 5;}

			if (isset($_GET['athome'])) {$gpu_typelist = array(1,2,4);} else {$gpu_typelist = array(1,2,3,4);}
			if ($display_vresmin <= 1080){$display_vresmin = 1080;} 
			if ($display_hresmin <= 1920){$display_hresmin = 1920;}
			break;
		}
	}
	//$gpu_typelist[] = 1;
	break;
}
} else {}

if (isset($_GET['vedit']))
{
	switch ($_GET['vedit']) 
	{	
		case "1": //video editing
		{
			$mem_capmin = 8;
			if ($mem_capmax <= 32) {$mem_capmax = round($nomenvalues[5][2]);}
			$cpu_coremin = 4; //Hyperthreading
			if ($gpu_powermin <= 30) {$gpu_powermin = 30;}
			//at home, merge orice placa video , at work trebuie o placa video dedicate cu 30W TDP min, both mergem pe ceea ce ste la work
			if (isset($_GET['athome'])) {$gpu_typelist = array(1,2,4);} else {$gpu_typelist = array(1,2,3,4);}
			if ($display_vresmin <= 1080){$display_vresmin = 1080;} 
			if ($display_hresmin <= 1920){$display_hresmin = 1920;}
			if ($hdd_capmin <= 512) {$hdd_capmin = 512;}
			$sist_sist[]="Windows+Pro"; $sist_sist[]="Windows+Home";$sist_sist[]="macOS";
			break;
		}
	}
	break;
}
} else {}

if (isset($_GET['3dmodel']))
{
	switch ($_GET['3dmodel']) 
	{		
		case "1": //3D modeling
		{
			if ($mem_capmin <= 8) {$mem_capmin = 8;}
			if ($mem_capmax <= 32) {$mem_capmax = round($nomenvalues[5][2]);}
			if ($cpu_tdpmin <= 10) {$cpu_tdpmin = 10;}
			if ($gpu_powermin <= 30) {$gpu_powermin = 30;}
			$sist_sist[]="Windows+Pro"; $sist_sist[]="Windows+Home";$sist_sist[]="macOS";
			if (isset($_GET['athome'])) {$gpu_typelist = array(1,2,4);} else {$gpu_typelist = array(1,2,3,4);}
			break;
		}
	}
} else {}

if (isset($_GET['sysadmin']))
{
	switch ($_GET['sysadmin']) 
	{		
		case "1": //IT management
		{
			$mem_capmin = 16;
			$cpu_coremin=4; //hyperthreading
			if ($mem_capmax <= 32){$mem_capmax=round($nomenvalues[5][2]);}
			if ($hdd_capmin <= 512) {$hdd_capmin = 512;}
			break;
		}
	}
}
} else {}

//*********************************************Everyday you will use it for about ...
if (isset($_GET['2hour']))
{
	switch ($_GET['2hour'])
	{											  
		case "1": // 0 - 2h  
		{
			$batlife_max = 2;
			break;
		}
	}
} else {}

if (isset($_GET['6hour']))
{
	switch ($_GET['6hour'])
	{			
		case "1": // 2-6h
		{
			$batlife_min=2;
			$batlife_max=6; 
			break;
		}
	}
} else {}

if (isset($_GET['10hour']))
{	
	switch ($_GET['10hour'])
	{
		case "1": //6-10h
		{
			$batlife_min=6;
			$batlife_max=10;
			if (isset($_GET['lap'])OR isset($_GET['vedit'])) {$batlife_min = 4;}
			if (isset($_GET['games']) OR isset($_GET['sysadmin'])) {$batlife_min = 3;}  	
			break;
		}
	}
} else {}

if (isset($_GET['12hour']))
{
	switch ($_GET['12hour'])			
	{
		case "1":// 10+h
		{
			$batlife_min=10;
			if (isset($_GET['lap'])OR isset($_GET['vedit'])) {$batlife_min = 5;} 
			if (isset($_GET['games']) OR isset($_GET['sysadmin'])) {$batlife_min = 4;}    	
			break;
		}
	}
} else {}


?>