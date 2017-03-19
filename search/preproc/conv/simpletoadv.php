<?php

	$valuetype[54] = $_GET['storage'];
	$waryearsmin = $_GET['warmin']; 					//echo $waryearsmin; 
	$waryearsmax = $_GET['warmax'];						//echo $waryearsmax; 
	if(isset($_GET['premium']) && $_GET['premium'] == "on") {$nbdcheck = "checked"; $war_typewar = "1";} else {$war_typewar = "2";}
	$hdd_type = array();		

/***************************   LAPTOP TYPE********************************/

	switch ($_GET['type']) 
	{
        case "1":		//normal
			$cputdpmin = 5; 
			$cputdpmax = 45; 
			$displaysizemin = 14;
			$displaysizemax = 17.5;
			$memcapmin = 4;
			$memcapmax = 8;
			$batlifemin = 3;
			$batlifemax = 8;
			$chassisweightmin= 1.8;
			$chassisweightmax=3;
			$wnetspeedmin = 433;
			break;
		case "2":		//ultraportable
			$cputdpmin = 1;
			$cputdpmax = 25;
			$displaysizemax = 16;
			$memcapmin = 4;
			$memcapmax = 8;
			$batlifemin = 5;
			$chassisweightmax=1.8; 
			$wnetspeedmin = 867;      
			$chassisthicmax = 19;
			$hdd_type[] = "SSD";
			$mdbwwansel0 = "selected";
			$mdbwwan = 0;
			break;
		case "3":		//business
		   $cputdpmin = 10;
			$cputdpmax = 45;
			$displaysizemin = 14;
			$displaysizemax = 17.3;
			$valuetype[56][0] = "Matte";      
			$memcapmin = 4;
			$memcapmax = 16;
			$batlifemin = 5;
			$chassisweightmin=1.5;
			$chassisthicmin = 17;
			$wnetspeedmin = 867;       					 
			$wartypewar = array(2,3,4);  		  
			//$budgetmin = 400;
			$hddcapmin = 100;
			$chassis_ports=array(); $chassis_vports=array();
			$mdbvport='<option selected="selected">1 X HDMI</option>';
			$mdbport='<option selected="selected">1 X LAN</option>';
			$chassis_ports[]="LAN";                 					  
			$chassis_vports[]="HDMI";
			$diffsearch=1;
			$chassiswebmin=0.9;
			$hdd_type[]="SSD";
			$mdbwwansel0 = "selected";
			$mdbwwan = 0;
			break;
		case "4":		// gaming
			$cputdpmin = 15; 
			$displaysizemin = 13;
			$memcapmin = 8;
			$chassisthicmin = 20;
			//$budgetmin = 400;
			$hddcapmin = 200;
			$wnetspeedmin = 867;     
			$gputypegpumin = 1;
			$displayhresmin = 1600;  
			$displayvresmin = 900;
			$gpumindate=($gpumaxdatei-1);			
			$hdd_type[] = "SSD";
			break;
		case "5":		// cad/3d design
			$cpufreqmin = 0.45*$cpufreqmaxi;
			$cputdpmin = 15;
			$cputdpmax = 55;
			$displaysizemin = 14;
			$memcapmin = 8;
			$gputypegpumin = 3;
			$gputype = 1;	//dedicated quadro video card
			$displayhresmin = 1920; 		 
			$displayvresmin = 1080;  	     
			$hddcapmin = 200;  
			$mdbwwansel0 = "selected";
			$mdbwwan = 0;			 
			 break;
	}
	
/***************************   FOCUS ON ********************************/
	switch ($issimple)
	{											 
		case "1":		//balanced features(preselectat)
		//DO NOTHING
        break;
    
		case "2": // LONG BATTERY LIFE
			if (($_GET['type'])==1)
			{
				$displaysizemin = 13;
				$batlifemin = 4;
				$cputdpmax = 40;
			}
			else if (($_GET['type'])==2)
			{
				$displaysizemin = 11;
				$batlifemin = 6;
				$cputdpmax = 22;
			}
			else if (($_GET['type'])==3)
			{
				$displaysizemin = 11;
				$batlifemin = 7;
				$cputdpmax = 40;
			}
			else if (($_GET['type'])==4)
			{
				$batlifemin = 4;
				$cputdpmax = 45;
			}
			else if (($_GET['type'])==5)
			{
				$displaysizemin = 13;
				$batlifemin = 4.5;
				$cputdpmax = 40 ;
			}	
			break;

		case "3":
			$memcapmin = 8;
			$memcapmax = 32;
			if (($_GET['type'])==1) // NORMAL
			{
				$cpufreqmin = 0.55*$cpufreqmaxi;
				$cputdpmin = 15;
			}
			else if (($_GET['type'])==2) // ULTRAP
			{
				$cpufreqmin = 0.50*$cpufreqmaxi;
				$cputdpmin = 15;
				$cputdpmax = 45;
				$chassisweightmax= 1.9;
				$chassisthicmax = 19;
			}
			else if (($_GET['type'])==3) // BUSINESS
			{
				$cpufreqmin = 0.55*$cpufreqmaxi;
				$cputdpmin = 15;
			}
			else if (($_GET['type'])==4) // GAMING
			{
				$cpufreqmin = 0.50*$cpufreqmaxi;
				$cputdpmin = 45;
			}
			else if (($_GET['type'])==5) //PRO
			{
				$cpufreqmin = 0.55*$cpufreqmaxi;
				$cputdpmin = 40;
				$cputdpmax = 150;
			}
			break;
	}

/***************************  GRAPHIC NEED********************************/
	switch ($_GET['graphics'])
	{
		case "1":	//essential
			$wnetspeedmin=433;
			$gputype=1;  //
			$gputypesel[0]="selected";
			if (($_GET['type'])==4) //GAMING
			{
				$gpupowermin = 15;
				$gpupowermax = 40;
				$gpumemmax = 4096;
				$gputypesel[2]="selected";
				$gputypesel[1]="selected";
				$gputypesel[0]="";
			}
			else if (($_GET['type'])==5) //PROFESIONAL
			{
				$gpupowermin = 20;
				$gpupowermax = 40;
				$gputype=1;
				$gputypesel[0]="";
				$gputypesel[3]="selected";
			}
			
        break;
		
		case "2":		//casual
			$gputype=1;
			if (($_GET['type'])==1) // NORMAL
			{
				$gputypesel[1]="selected";
				$gputypesel[2]="selected";
				$gpupowermin = 30;
				$gpupowermax = 50;
				$gpumemmax = 4096;
			}
			else if (($_GET['type'])==2) // ULTRAPOR
			{
				if($issimple=="2")
				{ $batlifemin = 4; }
				else
				{ $batlifemin = 3; }
				$gputypesel[1]="selected";
				$gputypesel[2]="selected";
				$gpupowermin = 20;
				$gpupowermax = 50;
				$gpumemmax = 4096;
				$chassisweightmax= 2.0;
				$chassisthicmax = 20;			
			}
			else if (($_GET['type'])==3) //BUSINESS
			{
				$gputypesel[1]="selected";
				$gputypesel[2]="selected";
				$gputypesel[3]="selected";
				$gpupowermin = 25;
				$gpupowermax = 50;
				$gpumemmax = 4096;
			}
			else if (($_GET['type'])==4) //GAMING
			{
				$gputypesel[1]="selected";
				$gputypesel[2]="selected";
				$gpupowermin = 34;
				$gpupowermax = 78;
				$gpumemmax = 4096;
			}
			else if (($_GET['type'])==5) //PROFESIONAL
			{
				$gputypesel[3]="selected";
				$gpupowermin = 34;
				$gpupowermax = 79;
			}
			break;
	
		case "3":	//high performance
			$gputype=1;
			if (($_GET['type'])==5) //PROFESIONAL
			{  $gputypesel[3]="selected"; }
			else if (($_GET['type'])==2) // ULTRAPOR
			{
				$chassisweightmax= 2.0;
				$chassisthicmax = 20;
				if($issimple=="2")
				{ $batlifemin = 4; }
				else
				{ $batlifemin = 3; }
				$gputypesel[2]="selected"; $gputypesel[1]="selected";
			}
			else if (($_GET['type'])==3) //BUSINESS
			{ 	
				$gputypesel[1]="selected";
				$gputypesel[2]="selected";
				$gputypesel[3]="selected";				
			}
			else if (($_GET['type'])==4) //GAMING
			{
				$gputypesel[2]="selected";
				$gputypesel[4]="selected";
			}
			else
			{
				$gputypesel[1]="selected";
				$gputypesel[2]="selected";
				$gputypesel[4]="selected";
			}

			$gpupowermin = 50;
			$gpumbwmin = 128;
			$gpumaxmemmin = 2048;
			break;
	}

	
/***************************  STORAGE********************************/

	foreach($_GET['storage'] as $x)
	{  			
		switch($x)
		{
			case "1": //normal
				$hdd_type[] = "HDD"; $hdd_type[] = "EMMC";  $hdd_type[] = "SSHD";
				$hddcapmin = 100;
				$hddcapmax = 1000;
				break;
			case "2":	//high storage
				$hddcapmin = 500;
				$hddcapmax = $nomenvalues[2][2]*2; // adiu
				break;
			case "3":	//high speed
				$hdd_type[] = "SSD" ; 
				break;
		}		
	}

/***************************   DISPLAY********************************/

	switch ($_GET['display'])
	{  			
		case "1": //budget
			if (!(($_GET['type'] == 4) OR ($_GET['type'] == 5)))
			{
				$displayhresmin = "1";
				$displayhresmax = "2000";
				$displayvresmin = "1";
				$displayvresmax = "1300";
			}
			else
			{
				$displayhresmax = "2000";
				$displayvresmax = "1300";
			}
			break;
		
		case "2":	//high resolution
			$displayhresmin= "1919";
			$displayvresmin = "1079";
			break;
	}

		
	if(is_string($_GET['exchange']))
	{
		$excode=$_GET['exchange'];
		$sel2 = "SELECT convr FROM notebro_site.exchrate WHERE code='".$excode."'";
		$result = mysqli_query($con,$sel2);
		$value=mysqli_fetch_array($result);
		$exch=floatval($value[0]);
	}

	if($_GET['bdgmin']) $bdgmin = floatval($_GET['bdgmin'])/$exch;
	if($_GET['bdgmax']) $bdgmax = floatval($_GET['bdgmax'])/$exch;
		
	if(isset($_GET['checkbox66']) && $_GET['checkbox66'] == "on") {$tcheck = "checked"; $display_touch = "1";} else {$display_touch ="2";}
		
/************ LOW BUDGET *******************/
	if($bdgmax<550)
	{
		$hddcapmin = 32;
		// We are on a budget eh? OK, let's make things less strict.
		switch ($_GET['type'])
		{
			case "1": //normal
				$cputdpmin = $cputdpmindb;
				$cputdpmax = 30;
				$displaysizemin = $dispsizemindb;
				$memcapmin = $memcapmindb;
				$memcapmax = 4;
				$chassisweightmin= 1.1;
				break;
			
			case "2":	//ultraportable
				$displaysizemax = 16;
				$memcapmin = $memcapmindb;
				$memcapmax = 4;
				$batlifemin = 54;
				$chassisweightmax=2; //echo  $chassis_weightmax;
				$wnetspeedmin = 300;
				$chassisthicmax = 24;
				break;
		
			case "3":	//business
				$cputdpmin = 4;
				$cputdpmax = 35;
				$displaysizemin = $dispsizemindb;
				$displaysizemax = 16;
				$memcapmin = 4;
				$chassisweightmin=1.8;
				$wnetspeedmin = 433;
				$war_typewar = "2";
				//$budgetmin = 400;
				break;
				
			case "4":// gaming
				$displaysizemin = 11;
				$hddcapmin = 200;
				$memcapmin = 4;
				$wnetspeedmin = 433;
				$displayhresmin= "1360";
				$displayvresmin = "760";
				break;
			
			case "5":// cad/3d design
				$cputdpmin = 4;
				$cputdpmax = 45;
				$cpufreqmin=$cpufreqmin*0.75;
				$displaysizemin = 11;
				$memcapmin = 4;
				$hddcapmin = 100;
				$displayhresmin= "1360";
				$displayvresmin = "760";
				break;
		}
	}		

	$displayres="";
	$result=mysqli_query($con,"SELECT DISTINCT CONCAT(hres,'x',vres) as resol FROM notebro_db.DISPLAY WHERE hres>=$displayhresmin AND hres<=$displayhresmax AND vres>=$displayvresmin AND vres<=$displayvresmax");
	
	while($row=mysqli_fetch_array($result))
	{
		$displayres.='<option selected="selected">'.$row[0].'</option>';
	}
	
	$valuetype[54]=$hdd_type;
	$valuetype[51] = array($wnetspeedmin);	
		
	if($hddcapmin)
	{
		$totalcapmin=$hddcapmin;
		$hddcapmin=0;
	}
	else
	{ $totalcapmin=0; }
	
	$totalcapmax=$hddcapmax;
	$mdbslotsel0 = "selected";
?>