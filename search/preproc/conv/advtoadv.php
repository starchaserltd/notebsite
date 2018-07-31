<?php
	if(isset($_GET['Regions']))
	{	foreach ($_GET['Regions'] as $element)
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
	
	if(is_string($_GET['exchadv']))
	{
		$excode=$_GET['exchadv'];
		$sel2 = "SELECT convr,id FROM notebro_site.exchrate WHERE code='".$excode."'";
		$result = mysqli_query($con,$sel2);
		$value=mysqli_fetch_array($result);
		$exch=floatval($value[0]);
		$lang=$value[1]; $_SESSION['lang']=$lang;
	}

	if(isset($_GET['bdgminadv'])) $bdgmin = floatval($_GET['bdgminadv'])/$exch;
	if(isset($_GET['bdgmaxadv'])) $bdgmax = floatval($_GET['bdgmaxadv'])/$exch;
	
	if(isset($_GET['CPU_prod_id'])) { $valuetype[11] = $_GET['CPU_prod_id']; } // values for CPU producer
	
	if($_GET['launchdatemin']) { $cpumindate = $_GET['launchdatemin']; }
	if($_GET['launchdatemax']) { $cpumaxdate = $_GET['launchdatemax']; }
	if($_GET['nrcoresmin'])	{ $cpucoremin = $_GET['nrcoresmin'];	}
	if($_GET['nrcoresmax']) { $cpucoremax = $_GET['nrcoresmax']; }
	
	$cputdpmin = $_GET['cputdpmin'];
	$cputdpmax = $_GET['cputdpmax'];
	$cpufreqmin = $_GET['cpufreqmin'];
	$cpufreqmax = $_GET['cpufreqmax'];
	$cputechmin = $_GET['cputechmax'];
	$cputechmax = $_GET['cputechmin'];
	
	$gputype = $_GET['gputype'];
	
	if ($gputype==1)
	{
		if(isset($_GET['gputype2']))
		{
			foreach ($_GET['gputype2'] as $element)
			{ $gputypesel[$element]="selected"; } // values for GPU type
		}
		$gpumemmin = $_GET['gpumemmin'];
		$gpumemmax = $_GET['gpumemmax'];
		$gpumembusmin = $_GET['gpubusmin'];
		$gpumembusmax = $_GET['gpubusmax'];
		$gpupowermin = $_GET['gpupowermin'];
		$gpupowermax = $_GET['gpupowermax'];
		if($_GET['gpulaunchdatemin']) { $gpumindate = $_GET['gpulaunchdatemin']; }
		if($_GET['gpulaunchdatemax']) { $gpumaxdate = $_GET['gpulaunchdatemax']; }
		
		if(isset($_GET['GPU_arch_id']))
		{	foreach ($_GET['GPU_arch_id'] as $element)
			{	$gpuarch.='<option selected="selected">'.$element.'</option>'; }
		}
		
		if(isset($_GET['GPU_msc_id']))
		{	foreach ($_GET['GPU_msc_id'] as $element)
			{	$gpumsc.='<option selected="selected">'.$element.'</option>'; }
		}
		
		if(isset($_GET['GPU_model_id']))
		{	foreach ($_GET['GPU_model_id'] as $element)
			{	$gpumodel.='<option selected="selected">'.$element.'</option>'; }
		}
	}
	else
	{ }
	
	$displaysizemin = $_GET['displaymin'];	
	$displaysizemax = $_GET['displaymax'];	
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
	
	if($_GET['verresmin']){ $displayvresmin = $_GET['verresmin']; }
	if($_GET['verresmax']){ $displayvresmax = $_GET['verresmax']; }
	
	
	$totalcapmin = $_GET['capacitymin'];
	$totalcapmax = $_GET['capacitymax'];
	$hddcapmin=$totalcapmin;
	$hddcapmax=$totalcapmax;
	$nrhdd = intval($_GET['nrhdd']);
	if ($nrhdd == 2) {$nrhddselect = "selected";}
	if ($nrhdd == 3) {$nrhddselect2 = "selected";}
	
	$mdbslots = $_GET['mdbslots'];
	
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
	$memcapmin = $_GET['rammin'];
	$memcapmax = $_GET['rammax'];
	$memfreqmin = $_GET['freqmin'];
	$memfreqmax = $_GET['freqmax'];
	
	$batlifemin = $_GET['batlifemin'];
 	$batlifemax = $_GET['batlifemax'];
	$acumcapmin = $_GET['acumcapmin'];
	$acumcapmax = $_GET['acumcapmax'];
	
	$chassisweightmin = $_GET['weightmin'];
	$chassisweightmax = $_GET['weightmax'];
	$chassisthicmin = $_GET['thicmin'];
	$chassisthicmax = $_GET['thicmax'];
	$chassisdepthmin = $_GET['depthmin'];
	$chassisdepthmax = $_GET['depthmax'];
	$chassiswidthmin = $_GET['widthmin'];
	$chassiswidthmax = $_GET['widthmax'];
	$chassiswebmin = $_GET['webmin'];
	$chassiswebmax = $_GET['webmax'];
	
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
	if(isset($_GET['typehdd'])) { $valuetype[54] = $_GET['typehdd']; }
	if(isset($_GET['rpm'])) { $valuetype[55] = $_GET['rpm']; }
	if(isset($_GET['wnetspeed'])) { $valuetype[51] = array($_GET['wnetspeed']); }
	$wnetspeedmax = 9999999;	

	if(isset($_GET['bluetooth']) && $_GET['bluetooth'] == "on") {$btcheck = "checked"; $wnet_bluetooth = "1";} else {$wnet_bluetooth = "2";}
	if(isset($_GET['premiumadv']) && $_GET['premiumadv'] == "on") {$nbdcheck = "checked"; $war_typewar = "1";} else {$war_typewar = "2";}
	if(isset($_GET['premiumadvadp']) && $_GET['premiumadvadp'] == "on") {$nbdcheckadp = "checked"; $war_typewar = "3";} else { }
	if(isset($_GET['touchscreen']) && $_GET['touchscreen'] == "on") {$tcheck = "checked";}
	if(isset($_GET['nontouchscreen']) && $_GET['nontouchscreen'] == "on") {$ntcheck = "checked";} 

	$waryearsmin = $_GET['yearsmin'];
	$waryearsmax = $_GET['yearsmax'];

	if($hddcapmin)
	{
		$totalcapmin=$hddcapmin;
		$hddcapmin=0;
	}
	else { $totalcapmin=0; }	
	
?>