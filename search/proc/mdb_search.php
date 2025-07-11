<?php

/* ********* SELECT MDB BASED ON FILTERS ***** */

function search_mdb ($prod, $model, $ramcap, $gpu, $chip, $socket, $interface, $netw, $hdd, $misc, $ratemin, $ratemax, $pricemin, $pricemax, $nowwan)
{
//var_dump($misc);
	$sel_mdb="SELECT id,price,rating,err FROM `".$GLOBALS['global_notebro_db']."`.MDB WHERE 1=1 AND valid=1";

	// Add producers to filter
	$i=0;
	if(gettype($prod)!="array") { $prod=(array)$prod; }
	foreach($prod as $x)
	{
		if($i) 	
		{ $sel_mdb.=" OR "; }
		else
		{ $sel_mdb.=" ( "; }
		$sel_mdb.="prod='";
		$sel_mdb.=$x;
		$sel_mdb.="'";
		$i++;
	}
	if($i>0){ $sel_mdb.=" ) "; }
	
	// Add models to filter	
	$i=0;
	if(gettype($model)!="array") { $model=(array)$model; }
	foreach($model as $x)
	{
		if($i)
		{ $sel_mdb.=" OR "; }
		else
		{ $sel_mdb.=" AND ( "; }

		$sel_mdb.="model='";
		$sel_mdb.=$x;
		$sel_mdb.="'";
		$i++;
	}
	if($i>0){ $sel_mdb.=" ) "; }
	
	// Add ram to filter 	
	$i=0;
	if(gettype($ramcap)!="array") { $ramcap=(array)$ramcap; }
	foreach($ramcap as $x)
	{
		if($i)
		{ $sel_mdb.=" OR "; }
		else
		{ $sel_mdb.=" AND ( "; }

		$sel_mdb.="ram>='";
		$sel_mdb.=$x;
		$sel_mdb.="'";
		$i++;
	}
	if($i>0){ $sel_mdb.=" ) "; }

	// ADD integrated GPU to the filter
	$i=0;
	if(gettype($gpu)!="array") { $gpu=(array)$gpu; }
	foreach($gpu as $x)
	{
		if($i)
		{ $sel_mdb.=" OR "; }
		else
		{ $sel_mdb.=" AND ( "; }

		$sel_mdb.="gpu=";
		$sel_mdb.=$x;
		$sel_mdb.="";
		$i++;
	}
	if($i>0){ $sel_mdb.=" ) "; }

	// ADD Chipset to the filter
	$i=0;
	if(gettype($chip)!="array") { $chip=(array)$chip; }
	foreach($chip as $x)
	{	
		if($i)
		{ $sel_mdb.=" OR "; }
		else
		{ $sel_mdb.=" AND ( "; }

		$sel_mdb.="chipset='";
		$sel_mdb.=$x;
		$sel_mdb.="'";
		$i++;
	}
	if($i>0){ $sel_mdb.=" ) "; }
	
	// ADD socket to the filter
	$i=0;
	if(gettype($socket)!="array") { $socket=(array)$socket; }
	foreach($socket as $x)
	{	
		if($i)
		{ $sel_mdb.=" OR "; }
		else
		{ $sel_mdb.=" AND ( "; }

		$sel_mdb.="socket='";
		$sel_mdb.=$x;
		$sel_mdb.="'";
		$i++;
	}
	if($i>0){ $sel_mdb.=" ) "; }
	
	//ADD interfaces to the filter
	$i=0;
	if(gettype($interface)!="array") { $interface=(array)$interface; }
	$group=0;
	foreach($interface as $x)
	{
		if(!strcmp($x,"group")){$group=1; $ii=0; continue;}
		if(!strcmp($x,"ungroup")){$group=0; if($ii){ $sel_mdb.=" ) ";  } continue;}
		if($i)
		{  
			if(!$group)
			{ $sel_mdb.=" AND ";}
			else
			{ 	if($ii)
				{ $sel_mdb.=" OR "; }
				else
				{ $sel_mdb.=" AND ( "; $ii++; }
			}
		}
		else
		{
			if(!$group)
			{ $sel_mdb.=" AND ( "; }
			else
			{ $sel_mdb.=" AND ( ( "; $ii++; }
		}
		
		$sel_mdb.="FIND_IN_SET('";
		$sel_mdb.=$x;
		$sel_mdb.="',interface)>0";
		$i++;
	}
	if($i>0){ $sel_mdb.=" ) "; }

	// ADD network to the filter
	$i=0;
	if(gettype($netw)!="array") { $netw=(array)$netw; }
	foreach($netw as $x)
	{			
		if($i)
		{ $sel_mdb.=" OR "; }
		else
		{ $sel_mdb.=" AND ( "; }

		$sel_mdb.="netw='";
		$sel_mdb.=$x;
		$sel_mdb.="'";
		$i++;
	}
	if($i>0){ $sel_mdb.=" ) ";}

	// ADD network to the filter
	$i=0;
	if(gettype($hdd)!="array") { $hdd=(array)$hdd; }
	foreach($hdd as $x)
	{	
		if($i)
		{ $sel_mdb.=" OR "; }
		else
		{ $sel_mdb.=" AND ( "; }

		$sel_mdb.="hdd='";
		$sel_mdb.=$x;
		$sel_mdb.="'";
		$i++;
	}
	if($i>0){ $sel_mdb.=" ) "; }	

	// Add MISC to filter
	$i=0;
	if(gettype($misc)!="array") { $misc=(array)$misc; }
	foreach($misc as $x)
	{ 
		if($i)
		{ $sel_mdb.=" AND "; }
		else
		{ $sel_mdb.=" AND ( "; }
		
		if(strpbrk($x,"/"))
		{	$sel_mdb.=" (";
			$z=explode("/",$x);
			$sel_mdb.="FIND_IN_SET('";
			$sel_mdb.=$z[0];	
			$sel_mdb.="',msc)>0";
			unset($z[0]);
			foreach($z as $t)
			{	$sel_mdb.=" OR "; $sel_mdb.="FIND_IN_SET('"; $sel_mdb.=$t;	$sel_mdb.="',msc)>0";	}
			$sel_mdb.=")";
		}	
		else
		{
			$sel_mdb.="FIND_IN_SET('";
			$sel_mdb.=$x;
			$sel_mdb.="',msc)>0";
		}
		$i++;
	}
	if($i>0){ $sel_mdb.=" ) "; }

	// Add NO WWAN
	$i=0;
	if($nowwan)
	{
		if($i)
		{ $sel_mdb.=" AND "; }
		else
		{ $sel_mdb.=" AND ( ";  }
		
		if($nowwan==1)
		{ $sel_mdb.="msc NOT LIKE '%WWAN%') "; }
	
		if($nowwan==2)
		{ $sel_mdb.=" msc LIKE '%WWAN%') "; }
	}

	// Add rating to filter	
	if($ratemin)
	{
		$sel_mdb.=" AND ";
		$sel_mdb.="rating>=";
		$sel_mdb.=$ratemin;
	}

	if($ratemax)
	{
		$sel_mdb.=" AND ";
		$sel_mdb.="rating<=";
		$sel_mdb.=$ratemax;
	}		
		
	// Add price to filter		
	if ($pricemin)
	{
		$sel_mdb.=" AND ";
		$sel_mdb.="IF(err>0,(price-price*err)>=";
		$sel_mdb.=$pricemin;
		$sel_mdb.=",1)";
	}

	if($pricemax)
	{
		$sel_mdb.=" AND ";
		$sel_mdb.="IF(err>0,(price-price*err)<=";
		$sel_mdb.=$pricemax;
		$sel_mdb.=",1)";
	}

	// DO THE SEARCH
	# echo "Query to select the MDBs:";
    # echo "<br>";
	# echo "<pre>" . $sel_mdb . "</pre>";
	
	$result = mysqli_query($GLOBALS['con'], "$sel_mdb");
	$mdb_return = array();

	while($rand = mysqli_fetch_array($result)) 
	{ 
		$mdb_return[intval($rand[0])]=array("price"=>intval($rand[1]),"rating"=>intval($rand[2]),"err"=>intval($rand[3]));
	}
	mysqli_free_result($result);
	return($mdb_return);
}
?>