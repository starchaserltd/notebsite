<?php

function search_gpu ($typelist, $prod, $model, $variant, $name, $arch, $techmin, $techmax, $shadermin, $cspeedmin, $cspeedmax, $sspeedmin, $sspeedmax, $mspeedmin, $mspeedmax, $mbwmin, $mbwmax, $mtype, $maxmemmin, $maxmemmax, $sharem, $powermin, $powermax, $ldmin, $ldmax, $misc, $ratemin, $ratemax, $pricemin, $pricemax, $seltdp)
{
	if($seltdp>0)
	{ $sel_gpu="SELECT `id`,`name`,`variant`,`rating`,`typegpu` FROM `".$GLOBALS['global_notebro_db']."`.`GPU` WHERE `valid`=1 "; }
	else
	{ $sel_gpu="SELECT `id`,`name`,`variant`,`rating`,`typegpu` FROM `".$GLOBALS['global_notebro_db']."`.`GPU` WHERE `valid`=1 "; }
	
	// Add Type filter (Integrated / Dedicated / Professional)
	
	$i=0; $k=0; $dend=0;
	if(gettype($typelist)!="array") { $typelist=(array)$typelist; }
	foreach($typelist as $x)
	{
		if($x==0){ $x=1; }
		
		if($i)
		{ $sel_gpu.=" OR "; }
		else
		{ $sel_gpu.=" AND ( "; }

		$sel_gpu.="`typegpu`='";
		$sel_gpu.=$x;
		$sel_gpu.="'";
		$i++;
	}
	if($i>0) { $sel_gpu.=" ) "; }
	
	// Add prod to filter	
	$i=0;
	if(gettype($prod)!="array") { $prod=(array)$prod; }
	foreach($prod as $x)
	{
		if($i)
		{ $sel_gpu.=" OR ";	}
		else
		{ $sel_gpu.=" AND ( "; }

		$sel_gpu.="`prod`='";
		$sel_gpu.=$x;
		$sel_gpu.="'";
		$i++;
	}
	if($i>0) { $sel_gpu.=" ) "; }

	// Add models to filter	
	$i=0;
	if(gettype($model)!="array") { $model=(array)$model; }
	foreach($model as $x)
	{
		if($i)
		{ $sel_gpu.=" OR ";	}
		else
		{ $sel_gpu.=" AND ( "; }

		$sel_gpu.="`model`='";
		$sel_gpu.=$x;
		$sel_gpu.="'";
		$i++;
	}
	if($i>0) { $sel_gpu.=" ) "; }
	
	// Add variant to filter	
	$i=0;
	if(gettype($variant)!="array") { $variant=(array)$variant; }
	foreach($variant as $x)
	{
		if($i)
		{ $sel_gpu.=" OR ";	}
		else
		{ $sel_gpu.=" AND ( "; }

		$sel_gpu.="`variant`='";
		$sel_gpu.=$x;
		$sel_gpu.="'";
		$i++;
	}
	if($i>0) { $sel_gpu.=" ) "; }

	// Add name to filter	
	$i=0;
	if(gettype($name)!="array") { $name=(array)$name; }
	foreach($name as $x)
	{
		if($i)
		{ $sel_gpu.=" OR ";	}
		else
		{ $sel_gpu.=" AND ( "; }

		$sel_gpu.="`name`='";
		$sel_gpu.=$x;
		$sel_gpu.="'";
		$i++;
	}
	if($i>0) { $sel_gpu.=" ) "; }
		
	// Add gpu architecture to filter	
	$i=0;
	if(gettype($arch)!="array") { $arch=(array)$arch; }
	foreach($arch as $x)
	{
		if($i)
		{ $sel_gpu.=" OR ";	}
		else
		{ $sel_gpu.=" AND ( "; }

		$sel_gpu.="`arch`='";
		$sel_gpu.=$x;
		$sel_gpu.="'";
		$i++;
	}
	if($i>0) { $sel_gpu.=" ) "; }
		
	// Add tech to filter - smaller is better here		
	if($techmin)
	{
		$sel_gpu.=" AND ";
		$sel_gpu.="`tech`>=";
		$sel_gpu.=$techmin;
	}

	if($techmax)
	{
		$sel_gpu.=" AND ";
		$sel_gpu.="`tech`<=";
		$sel_gpu.=$techmax;
	}
	
	// Minimum Shader model filter
	if($shadermin)
	{
		$sel_gpu.=" AND ";
		$sel_gpu.="`shader`>=";
		$sel_gpu.=$shadermin;
	}

	// Add core speed to filter 	
	if($cspeedmin)
	{
		$sel_gpu.=" AND ";
		$sel_gpu.="`cspeed`>=";
		$sel_gpu.=$cspeedmin;
	}

	if($cspeedmax)
	{
		$sel_gpu.=" AND ";
		$sel_gpu.="`cspeed`<=";
		$sel_gpu.=$cspeedmax;
	}

	// Add shader speed to filter 	
	if($sspeedmin)
	{
		$sel_gpu.=" AND ";
		$sel_gpu.="`sspeed`>=";
		$sel_gpu.=$sspeedmin;
	}

	if($sspeedmax)
	{
		$sel_gpu.=" AND ";
		$sel_gpu.="`sspeed`<=";
		$sel_gpu.=$sspeedmax;
	}	

	// Add memory speed to filter 	
	if($mspeedmin)
	{
		$sel_gpu.=" AND ";
		$sel_gpu.="`sspeed`>=";
		$sel_gpu.=$mspeedmin;
	}
 
	if($mspeedmax)
	{
		$sel_gpu.=" AND ";
		$sel_gpu.="`sspeed`<=";
		$sel_gpu.=$mspeedmax;
	}
	
	// Add memory bus filter 	**************
	if($mbwmin)
	{
		$sel_gpu.=" AND ";
		$sel_gpu.="`mbw`>=";
		$sel_gpu.=$mbwmin;
	}
	
	if($mbwmax)
	{
		$sel_gpu.=" AND ";
		$sel_gpu.="`mbw`<=";
		$sel_gpu.=$mbwmax;
	}
	
// Add memory type to the filter	
	$i=0;
	if(gettype($mtype)!="array") { $mtype=(array)$mtype; }
	foreach($mtype as $x)
	{
		if($i)
		{ $sel_gpu.=" OR ";	}
		else
		{ $sel_gpu.=" AND ( "; }

		$sel_gpu.="`mtype`='";
		$sel_gpu.=$x;
		$sel_gpu.="'";
		$i++;
	}
	if($i>0) { $sel_gpu.=" ) "; }

	// Add memory size to filter 	
	if($maxmemmin)
	{
		$sel_gpu.=" AND ";
		$sel_gpu.="`maxmem`>=";
		$sel_gpu.=$maxmemmin;
	}
 
	if($maxmemmax)
	{
		$sel_gpu.=" AND ";
		$sel_gpu.="`maxmem`<=";
		$sel_gpu.=$maxmemmax;
	}
	
	// ADD shared memory filter
	if($sharem!=NULL)
	{
		$sel_gpu.=" AND ";
		$sel_gpu.="`sharem`=";
		$sel_gpu.=$sharem;
	}
	
	// Add TDP filter	
	if($powermin)
	{
		$sel_gpu.=" AND ";
		$sel_gpu.="`power`>=";
		$sel_gpu.=$powermin;
	}

	if($powermax)
	{
		$sel_gpu.=" AND ";
		$sel_gpu.="power<=";
		$sel_gpu.=$powermax;
	}
	
	// Add date to filter		
	if($ldmin)
	{
		$sel_gpu.=" AND";
		$sel_gpu.=" (";
		$sel_gpu.="`ldate` BETWEEN '";
		$sel_gpu.=$ldmin;
	}
	else
	{
		$sel_gpu.=" AND";
		$sel_gpu.=" (";
		$sel_gpu.="`ldate` BETWEEN ";
		$sel_gpu.="'0000-00-00";
	}

 	if($ldmax)
	{
		$sel_gpu.="' AND '";
		$sel_gpu.=$ldmax;
		$sel_gpu.="')";
	}
	else
	{
		$sel_gpu.="' AND '";
		$sel_gpu.=date('Y-m-d', strtotime("-1 days"));
		$sel_gpu.="')";
	}
	
	// Add MISC to filter
	$i=0;
	if(gettype($misc)!="array") { $misc=(array)$misc; }
	foreach($misc as $x)
	{
			
		if($i)
		{ $sel_gpu.=" OR ";	}
		else
		{ $sel_gpu.=" AND ( "; }

		$sel_gpu.="FIND_IN_SET('";
		
		if(strpbrk($x,"/"))
		{		
			$z=explode("/",$x);
			$sel_gpu.=$z[0];	
			$sel_gpu.="',`msc`)>0";
			unset($z[0]);
			foreach($z as $t)
			{	$sel_gpu.=" OR "; $sel_gpu.="FIND_IN_SET('"; $sel_gpu.=$t;	$sel_gpu.="',`msc`)>0";	}
		}	
		else
		{
			$sel_gpu.=$x;	
			$sel_gpu.="',`msc`)>0";
		}
		$i++;
	}
	if($i>0) { $sel_gpu.=" ) "; }	
	
	// Add rating to filter	
	if($ratemin)
	{
		$sel_gpu.=" AND ";
		$sel_gpu.="`rating`>=";
		$sel_gpu.=$ratemin;
	}

	if($ratemax)
	{
		$sel_gpu.=" AND ";
		$sel_gpu.="`rating`<=";
		$sel_gpu.=$ratemax;
	}
	
	// Add price to filter		
	if ($pricemin)
	{
		$sel_gpu.=" AND ";
		$sel_gpu.="(`price`+`price`*`err`)>=";
		$sel_gpu.=$pricemin;
	
	}
	
	if($pricemax)
	{
		$sel_gpu.=" AND ";
		$sel_gpu.="(`price`+`price`*`err`)<=";
		$sel_gpu.=$pricemax;
	}
	
	$sel_gpu.=" GROUP BY `name`";
	$sel_gpu.=" ORDER BY `rating` DESC";
	
	// DO THE SEARCH
	$result = mysqli_query($GLOBALS['con'], $sel_gpu);
	//error_log($sel_gpu);
	$gpu_return = array();
	while($rand = mysqli_fetch_array($result)) 
	{ 
		if($seltdp>0)
		{ $gpu_return[]=["id"=>intval($rand[0]), "model"=>(strval($rand[1])." (".strval(round($rand[3])/10)."/10)"), "typegpu"=>(intval($rand[4]))]; }
		else
		{ $gpu_return[]=["id"=>intval($rand[0]), "model"=>(strval($rand[1])." (".strval(round($rand[3])/10)."/10)"), "typegpu"=>(intval($rand[4]))];	}

	}
	
	mysqli_free_result($result);
	return($gpu_return);
}
?>