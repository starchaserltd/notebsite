<?php

/* ********* SELECT MEM BASED ON FILTERS ***** */

function search_mem ($prod, $capmin, $capmax, $stan, $freqmin, $freqmax, $type, $latmin, $latmax, $voltmin, $voltmax, $misc, $ratemin, $ratemax, $pricemin, $pricemax)
{
	$sel_mem="SELECT id,price,rating,err FROM `".$GLOBALS['global_notebro_db']."`.MEM WHERE 1=1 AND valid=1";
	
	// Add producers to filter
	$i=0;
	if(gettype($prod)!="array") { $prod=(array)$prod; }
	foreach($prod as $x)
	{
		if($i)
		{ $sel_mem.=" OR "; }
		else
		{ $sel_mem.=" AND ( "; }
		
		$sel_mem.="prod='";
		$sel_mem.=$x;
		$sel_mem.="'";
		$i++;
	}
	if($i>0){ $sel_mem.=" ) "; }

	// Add cap to filter	
	if($capmin)
	{
		$sel_mem.=" AND ";
		$sel_mem.="cap>=";
		$sel_mem.=$capmin;
	}
 
	if($capmax)
	{
		$sel_mem.=" AND ";
		$sel_mem.="cap<=";
		$sel_mem.=$capmax;
	}	
	
	// Add frequency to filter	
	if($freqmin)
	{
		$sel_mem.=" AND ";
		$sel_mem.="freq>=";
		$sel_mem.=$freqmin;
	}
 
	if($freqmax)
	{
		$sel_mem.=" AND ";
		$sel_mem.="freq<=";
		$sel_mem.=$freqmax;
	}
		
	// Add standard to filter		
	$i=0;
	if(gettype($stan)!="array") { $stan=(array)$stan; }
	foreach($stan as $x)
	{
		if($i)
		{ $sel_mem.=" OR "; }
		else
		{ $sel_mem.=" AND ( "; }
		
		$sel_mem.="stan='";
		$sel_mem.=$x;
		$sel_mem.="'";
		$i++;
	}
	if($i>0){ $sel_mem.=" ) "; }

	// Add type to filter	
	$i=0;
	if(gettype($type)!="array") { $type=(array)$type; }
	foreach($type as $x)
	{
		if($i)
		{ $sel_mem.=" OR "; }
		else
		{ $sel_mem.=" AND ( "; }
	
		$sel_mem.="type='";
		$sel_mem.=$x;
		$sel_mem.="'";
		$i++;
	}
	if($i>0){ $sel_mem.=" ) "; }
	
	// Add latency to filter - smaller is better here		
	if($latmin)
	{
		$sel_mem.=" AND ";
		$sel_mem.="lat<=";
		$sel_mem.=$latmin;
	}
 
	if($latmax)
	{
		$sel_mem.=" AND ";
		$sel_mem.="lat>=";
		$sel_mem.=$latmax;
	}

	// Add voltage to filter
	if($voltmin)
	{
		$sel_mem.=" AND ";
		$sel_mem.="volt>=";
		$sel_mem.=$voltmin;
	}
 
	if($voltmax)
	{
		$sel_mem.=" AND ";
		$sel_mem.="volt<=";
		$sel_mem.=$voltmax;
	}	

	// Add MISC to filter
	$i=0;
	if(gettype($misc)!="array") { $misc=(array)$misc; }
	foreach($misc as $x)
	{
		if($i)
		{ $sel_mem.=" AND "; }
		else
		{ $sel_mem.=" AND ( "; }
		
		$sel_mem.="FIND_IN_SET('";
		$sel_mem.=$x;
		$sel_mem.="',msc)>0";
		$i++;
	}
	if($i>0){ $sel_mem.=" ) "; }

	// Add rating to filter	
	if($ratemin)
	{
		$sel_mem.=" AND ";
		$sel_mem.="rating>=";
		$sel_mem.=$ratemin;
	}
 
	if($ratemax)
	{
		$sel_mem.=" AND ";
		$sel_mem.="rating<=";
		$sel_mem.=$ratemax;
	}		
	
	// Add price to filter		
	if ($pricemin)
	{
		$sel_mem.=" AND ";
		$sel_mem.="IF(err>0,(price-price*err)>=";
		$sel_mem.=$pricemin;
		$sel_mem.=",1)";
	}

	if($pricemax)
	{
		$sel_mem.=" AND ";
		$sel_mem.="IF(err>0,(price-price*err)<=";
		$sel_mem.=$pricemax;
		$sel_mem.=",1)";
	}
	
	// DO THE SEARCH
	# echo "Query to select the MEMs:";
    # echo "<br>";
	# echo "<pre>" . $sel_mem . "</pre>";
	
	$result = mysqli_query($GLOBALS['con'], "$sel_mem");
	$mem_return = array();

	while($rand = mysqli_fetch_array($result)) 
	{ 
		$mem_return[intval($rand[0])]=array("price"=>intval($rand[1]),"rating"=>intval($rand[2]),"err"=>intval($rand[3]));
	}

	mysqli_free_result($result);
	return($mem_return);
}
?>