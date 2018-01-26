<?php

/* ********* SELECT WARRANTY BASED ON FILTERS ***** */

function search_war ($prod, $yearsmin, $yearsmax, $typewar, $misc, $ratemin, $ratemax, $pricemin, $pricemax)
{
	$sel_war="SELECT id,price,rating,err FROM WAR WHERE 1=1";
	
	// Add models to filter
	$i=0;
	if(gettype($prod)!="array") { $prod=(array)$prod; }
	if(gettype($typewar)!="array") { $typewar=(array)$typewar; }

	foreach($prod as $x)
	{
		if($i)
		{ $sel_war.=" OR "; }
		else
		{ $sel_war.=" AND ( "; }
		
		$sel_war.="prod='";
		$sel_war.=$x;
		$sel_war.="'";
		$i++;
	}
	if($i>0){ $sel_war.=" ) "; }

	// Add years to filter 		
	if($yearsmin)
	{
		$sel_war.=" AND ";
		$sel_war.="years>=";
		$sel_war.=$yearsmin;
	}
 
	if($yearsmax)
	{
		$sel_war.=" AND ";
		$sel_war.="years<=";
		$sel_war.=$yearsmax;
	}
	
	// Add type to filter	
	if($typewar)
	{
		foreach($typewar as $x)
		{
			if($i)
			{ $sel_war.=" OR "; }
			else
			{ $sel_war.=" AND ( "; }
			
			$sel_war.="typewar='";
			$sel_war.=$x;
			$sel_war.="'";
			$i++;
		}
		
		if($i>0){ $sel_war.=" ) "; }
	}

	// Add MISC to filter
	$i=0;
	if(gettype($misc)!="array") { $misc=(array)$misc; }
	foreach($misc as $x)
	{
		if($i)
		{ $sel_war.=" AND "; }
		else
		{ $sel_war.=" AND ( "; }
		
		$sel_war.="FIND_IN_SET('";
		$sel_war.=$x;
		$sel_war.="',msc)>0";
		$i++;
	}
	if($i>0){ $sel_war.=" ) "; }

	// Add rating to filter	
	if($ratemin)
	{
		$sel_war.=" AND ";
		$sel_war.="rating>=";
		$sel_war.=$ratemin;
	}
 
	if($ratemax)
	{
		$sel_war.=" AND ";
		$sel_war.="rating<=";
		$sel_war.=$ratemax;
	}		

	// Add price to filter		
	if ($pricemin)
	{
		$sel_war.=" AND ";
		$sel_war.="IF(err>0,(price-price*err)>=";
		$sel_war.=$pricemin;
		$sel_war.=",1)";
	}

	if($pricemax)
	{
		$sel_war.=" AND ";
		$sel_war.="IF(err>0,(price-price*err)<=";
		$sel_war.=$pricemax;
		$sel_war.=",1)";
	}
	
	// DO THE SEARCH
	# echo "Query to select the WARRANTYs:";
    # echo "<br>";
	# echo "<pre>" . $sel_war . "</pre>";
	
	$result = mysqli_query($GLOBALS['con'], "$sel_war");
	$war_return = array();

	while($rand = mysqli_fetch_array($result)) 
	{ 
		$war_return[intval($rand[0])]=array("price"=>intval($rand[1]),"rating"=>intval($rand[2]),"err"=>intval($rand[3]));
	}
		mysqli_free_result($result);
		return($war_return);
}
?>