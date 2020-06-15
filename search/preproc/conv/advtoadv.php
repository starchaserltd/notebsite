<?php
	if(isset($_GET['Regions']))
	{	$regions="";
		foreach ($_GET['Regions'] as $element)
		{	$regions.='<option selected="selected">'.$element.'</option>'; }
	}

	if(isset($_GET['Family_fam']))
	{
		foreach ($_GET['Family_fam'] as $element)
		{	if ($element =="All business families")	{$model_minclass=1;$model_maxclass =3;$model_advclass=1;} 
			if ($element =="All consumer families")	{$model_minclass=0;$model_maxclass =1;$model_advclass=1;} 
			$family.='<option selected="selected">'.$element.'</option>';}
	}
	
	if(isset($_GET['Producer_prod']))
	{	foreach ($_GET['Producer_prod'] as $element)
		{	$producer.='<option selected="selected">'.$element.'</option>'; }
	}
	
	if(isset($_GET['CPU_model_id']))
	{	foreach ($_GET['CPU_model_id'] as $element)
		{	$cpumodel.='<option selected="selected">'.$element.'</option>'; }
	}
	
	if(isset($_GET['CPU_socket_id']))
	{	foreach ($_GET['CPU_socket_id'] as $element)
		{	$cpusocket.='<option selected="selected">'.$element.'</option>'; }
	}
	if(isset($_GET['CPU_msc_id']))
	{	foreach ($_GET['CPU_msc_id'] as $element)
		{	$cpumsc.='<option selected="selected">'.$element.'</option>';	}
	}
	
	if(isset($_GET['exchadv'])&&is_string($_GET['exchadv']))
	{
		$excode=clean_string($_GET['exchadv']);
		$sel2 = "SELECT convr,id FROM notebro_site.exchrate WHERE code='".$excode."'";
		$result = mysqli_query($con,$sel2);
		$value=mysqli_fetch_array($result);
		$exch=floatval($value[0]);
		$lang=$value[1]; $_SESSION['lang']=$lang;
	}

	if(isset($_GET['bdgminadv'])){ $bdgmin = floatval($_GET['bdgminadv'])/$exch; }else{$bdgmin=-10;}
	if(isset($_GET['bdgmaxadv'])){ $bdgmax = floatval($_GET['bdgmaxadv'])/$exch; }else{$bdgmax=-10;}
	
	if(isset($_GET['CPU_prod_id'])) { $valuetype[11] = $_GET['CPU_prod_id']; } // values for CPU producer
	
	if(isset($_GET['launchdatemin'])) { $cpumindate = $_GET['launchdatemin']; }else{$cpumindate=1900;}
	if(isset($_GET['launchdatemax'])) { $cpumaxdate = $_GET['launchdatemax']; }else{$cpumaxdate=10500;}
	if(isset($_GET['nrcoresmin']))	{ $cpucoremin = $_GET['nrcoresmin'];	}
	if(isset($_GET['nrcoresmax'])) { $cpucoremax = $_GET['nrcoresmax']; }
	
	if(isset($_GET['cputdpmin'])) { $cputdpmin = $_GET['cputdpmin']; }
	if(isset($_GET['cputdpmax'])) { $cputdpmax = $_GET['cputdpmax']; }
	if(isset($_GET['cpufreqmin'])) { $cpufreqmin = $_GET['cpufreqmin']; }
	if(isset($_GET['cpufreqmax'])) { $cpufreqmax = $_GET['cpufreqmax']; }
	if(isset($_GET['cputechmax'])) { $cputechmin = $_GET['cputechmax']; }
	if(isset($_GET['cputechmin'])) { $cputechmax = $_GET['cputechmin']; }
	
	if(isset($_GET['gputype'])) { $gputype = $_GET['gputype']; }else{$gputype=2;}
	
	if ($gputype==1)
	{
		if(isset($_GET['gputype2']))
		{
			foreach ($_GET['gputype2'] as $element)
			{ $gputypesel[$element]="selected"; } // values for GPU type
		}
		if(isset($_GET['gpumemmin'])){ $gpumemmin = $_GET['gpumemmin']; }
		if(isset($_GET['gpumemmax'])){ $gpumemmax = $_GET['gpumemmax']; }
		if(isset($_GET['gpubusmin'])){ $gpumembusmin = $_GET['gpubusmin']; }
		if(isset($_GET['gpubusmax'])) { $gpumembusmax = $_GET['gpubusmax']; }
		if(isset($_GET['gpupowermin'])){ $gpupowermin = $_GET['gpupowermin']; }
		if(isset($_GET['gpupowermax'])) { $gpupowermax = $_GET['gpupowermax']; }
		if(isset($_GET['gpulaunchdatemin'])) { $gpumindate = $_GET['gpulaunchdatemin']; }else{$gpumindate=1900; }
		if(isset($_GET['gpulaunchdatemax'])) { $gpumaxdate = $_GET['gpulaunchdatemax']; }else{$gpumaxdate=10500;}
		
		if(isset($_GET['GPU_arch_id']))
		{	foreach ($_GET['GPU_arch_id'] as $element)
			{	$gpuarch.='<option selected="selected">'.$element.'</option>'; }
		}
		
		if(isset($_GET['GPU_msc_id']))
		{	foreach ($_GET['GPU_msc_id'] as $element)
			{	$gpumsc.='<option selected="selected">'.$element.'</option>'; }
		}
		
		if(isset($_GET['GPU_name_id']))
		{	foreach ($_GET['GPU_name_id'] as $element)
			{	$gpumodel.='<option selected="selected">'.$element.'</option>'; }
		}
	}
	else
	{ }
	
	if(isset($_GET['displaymin'])){$displaysizemin = $_GET['displaymin'];}
	if(isset($_GET['displaymax'])) { $displaysizemax = $_GET['displaymax'];	}
	if(isset($_GET['DISPLAY_ratio']))
	{ 
		$valuetype[8] = $_GET['DISPLAY_ratio'];  // Display format
	}
	if(isset($_GET['DISPLAY_resol_id']))
	{
		foreach ($_GET['DISPLAY_resol_id'] as $element)
		{	$displayres.='<option selected="selected">'.$element.'</option>';	}
	}
	
	if(isset($_GET['DISPLAY_msc_id']))
	{
		foreach ($_GET['DISPLAY_msc_id'] as $element)
		{	$displaymsc.='<option selected="selected">'.$element.'</option>';	}
	}
	
	if(isset($_GET['verresmin'])){ $displayvresmin = $_GET['verresmin']; }
	if(isset($_GET['verresmax'])){ $displayvresmax = $_GET['verresmax']; }
	
	
	if(isset($_GET['capacitymin'])) { $totalcapmin = $_GET['capacitymin']; }else{$totalcapmin=0;}
	if(isset($_GET['capacitymax'])) { $totalcapmax = $_GET['capacitymax']; }else{$totalcapmax=2147483600;}
	$hddcapmin=$totalcapmin;
	$hddcapmax=$totalcapmax;
	if(isset($_GET['nrhdd'])){ $nrhdd = intval($_GET['nrhdd']);}else{$nrhdd=0;}
	if ($nrhdd == 2) {$nrhddselect = "selected";}
	if ($nrhdd == 3) {$nrhddselect2 = "selected";}
	
	if(isset($_GET['mdbslots'])){ $mdbslots = $_GET['mdbslots']; }else{$mdbslots=null;}
	
	if ($mdbslots == 1) {$mdbslotsel1 = 'selected="selected"';}
	else if ($mdbslots == 2) {$mdbslotsel2 = 'selected="selected"';}
		else if ($mdbslots ==3) {$mdbslotsel3 = 'selected="selected"';}
			else if ($mdbslots == 4) {$mdbslotsel4 = 'selected="selected"';}
				else {$mdbslotsel0 = 'selected="selected"';}
	
	if(isset($_GET['mdbwwan']))
	{
		$mdbwwansel0=""; $mdbwwan = $_GET['mdbwwan'];
			if ($mdbwwan ==1) {$mdbwwansel1 = 'selected="selected"';}
				else if ($mdbwwan == 2) {$mdbwwansel2 = 'selected="selected"';}
					else {$mdbwwansel0 = 'selected="selected"';}
	}
	//MDB_vport_id
	if(isset($_GET['MDB_vport_id']))
	{	foreach ($_GET['MDB_vport_id'] as $element)
		{	$mdbvport.='<option selected="selected">'.$element.'</option>'; }
	}
	//MDB_port_id
	if(isset($_GET['MDB_port_id']))
	{	foreach ($_GET['MDB_port_id'] as $element)
		{	$mdbport.='<option selected="selected">'.$element.'</option>'; }
	}

	if(isset($_GET['rammin'])){ $memcapmin = $_GET['rammin'];}else{$memcapmin=0;}
	if(isset($_GET['rammax'])){ $memcapmax = $_GET['rammax'];}else{$memcapmax=2147483600;}
	if(isset($_GET['freqmin'])){ $memfreqmin = $_GET['freqmin'];}else{ $memfreqmin=0; }
	if(isset($_GET['freqmax'])){ $memfreqmax = $_GET['freqmax']; } else {$memfreqmax=2147483600;}
	
	if(isset($_GET['batlifemin'])){ $batlifemin = $_GET['batlifemin'];}else{$batlifemin=0;}
 	if(isset($_GET['batlifemax'])){ $batlifemax = $_GET['batlifemax'];}else{$batlifemax=2147483600;}
	if(isset($_GET['acumcapmin'])) { $acumcapmin = $_GET['acumcapmin']; }else {$acumcapmin=0;}
	if(isset($_GET['acumcapmax'])) { $acumcapmax = $_GET['acumcapmax'];}else {$acumcapmax=2147483600;}
	
	if(isset($_GET['weightmin'])) { $chassisweightmin = $_GET['weightmin']; }else{$chassisweightmi=0;}
	if(isset($_GET['weightmax'])) { $chassisweightmax = $_GET['weightmax']; }else{ $chassisweightmax=2147483600;}
	if(isset($_GET['thicmin'])){ $chassisthicmin = $_GET['thicmin']; }else{$chassisthicmin=0;}
	if(isset($_GET['thicmax'])){ $chassisthicmax = $_GET['thicmax']; }else{$chassisthicmax=2147483600;}
	if(isset($_GET['depthmin'])){ $chassisdepthmin = $_GET['depthmin']; } else {$chassisdepthmin=0;}
	if(isset($_GET['depthmax'])){ $chassisdepthmax = $_GET['depthmax']; }else {$chassisdepthmax=2147483600;}
	if(isset($_GET['widthmin'])){ $chassiswidthmin = $_GET['widthmin'];}else{$chassiswidthmin=0;}
	if(isset($_GET['widthmax'])){ $chassiswidthmax = $_GET['widthmax']; }else{$chassiswidthmax=2147483600;}
	if(isset($_GET['webmin'])){ $chassiswebmin = $_GET['webmin']; }else{ $chassiswebmin=0;}
	if(isset($_GET['webmax'])) { $chassiswebmax = $_GET['webmax']; }else{$chassiswebmax=2147483600;}
	
	//******************************************************************************************************************************
	if(isset($_GET['twoinone-no']) && $_GET['twoinone-no'] == "on") {$classiclap_check = "checked";}
	if(isset($_GET['twoinone-yes']) && $_GET['twoinone-yes'] == "on") {$twoinone_check = "checked";}

	if(isset($_GET['oddtype'])) { $valuetype[52] = $_GET['oddtype']; }
	if(isset($_GET['memtype'])) { $valuetype[53] = $_GET['memtype']; }
	if(isset($_GET['opsist'])) { $valuetype[25] = $_GET['opsist']; } //var_dump($valuetype[25]);
	if(isset($_GET['GPU_prod_id'])) { $valuetype[12] = $_GET['GPU_prod_id']; }
	if(isset($_GET['material'])) { $valuetype[26] = $_GET['material']; }
	$chassisstuff="";
	
	if(isset($_GET['CHASSIS_stuff_id']))
	{	foreach ($_GET['CHASSIS_stuff_id'] as $element)
		{ $chassisstuff.='<option selected="selected">'.$element.'</option>'; }
	}
	
	if(isset($_GET['surface'])) { $valuetype[56] = $_GET['surface']; }
	if(isset($_GET['typehdd'])) { $valuetype[54] = $_GET['typehdd']; foreach($valuetype[54] as $val){if($val=="HDD"){$show_rpm=1; break;}} }
	if(isset($_GET['rpm'])) { $valuetype[55] = $_GET['rpm']; }
	if(isset($_GET['wnetspeed'])) { $valuetype[51] = array($_GET['wnetspeed']); }
	$wnetspeedmax = 9999999;	

	if(isset($_GET['bluetooth']) && $_GET['bluetooth'] == "on") {$btcheck = "checked"; $wnet_bluetooth = "1";} else {$wnet_bluetooth = "2";}
	if(isset($_GET['premiumadv']) && $_GET['premiumadv'] == "on") {$nbdcheck = "checked"; $war_typewar = "1";} else {$war_typewar = "2";}
	if(isset($_GET['touchscreen']) && $_GET['touchscreen'] == "on") {$tcheck = "checked";}
	if(isset($_GET['nontouchscreen']) && $_GET['nontouchscreen'] == "on") {$ntcheck = "checked";} 

	if(isset($_GET['yearsmin'])){ $waryearsmin = $_GET['yearsmin']; $waryearsset=true;}
	if(isset($_GET['yearsmax'])){ $waryearsmax = $_GET['yearsmax']; }else{$waryearsmax=2147483600;}

	if($hddcapmin)
	{
		$totalcapmin=$hddcapmin;
		$hddcapmin=0;
	}
	else { $totalcapmin=0; }
	
	if(isset($_GET['sort_by'])){$sort_by=clean_string($_GET['sort_by']);}
?>