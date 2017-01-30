<?php

/* ********* SELECT ODD BASED ON FILTERS ***** */

function search_odd ($type, $prod, $misc, $speedmin, $speedmax, $ratemin, $ratemax, $pricemin, $pricemax)
{
	$sel_odd="SELECT id,price,rating,err FROM ODD WHERE 1=1";

	// Add producers to filter
	$i=0;
	if(gettype($type)!="array") { $type=(array)$type; }
	foreach($type as $x)
	{
		if($i)
		{  
			$sel_odd.=" OR ";
		}
		else
		{
			$sel_odd.=" AND ( ";
		}
		
		$sel_odd.="type='";
		$sel_odd.=$x;
		$sel_odd.="'";
		$i++;
	}
	if($i>0)
	{ $sel_odd.=" ) "; }

	// Add prod to filter	
	$i=0;
	if(gettype($prod)!="array") { $prod=(array)$prod; }
	foreach($prod as $x)
	{		
		if($i)
		{  
			$sel_odd.=" OR ";
		}
		else
		{
			$sel_odd.=" AND ( ";
		}
		
		$sel_odd.="prod='";
		$sel_odd.=$x;
		$sel_odd.="'";
		$i++;
	
	}
	if($i>0)
	{ $sel_odd.=" ) "; }

	// Add MISC to filter
	$i=0;
	if(gettype($misc)!="array") { $misc=(array)$misc; }
	foreach($misc as $x)
	{
		if($i)
		{  
			$sel_odd.=" AND ";
		}
		else
		{
			$sel_odd.=" AND ( ";
		}
		
		$sel_odd.="FIND_IN_SET('";
		$sel_odd.=$x;
		$sel_odd.="',msc)>0";
		$i++;
	}
	if($i>0)
	{ $sel_odd.=" ) "; }

	//Add speed to filter
	if($speedmin)
	{
		$sel_odd.=" AND "; 
		$sel_odd.="speed>=";
		$sel_odd.=$speedmin;
	}
 
	if($speedmax)
	{
		$sel_odd.=" AND ";
		$sel_odd.="speed<=";
		$sel_odd.=$speedmax;
	}		

	// Add rating to filter	
	if($ratemin)
	{
		$sel_odd.=" AND ";
		$sel_odd.="rating>=";
		$sel_odd.=$ratemin;
	}

	if($ratemax)
	{
		$sel_odd.=" AND ";
		$sel_odd.="rating<=";
		$sel_odd.=$ratemax;
	}		
		
	// Add price to filter		
	if ($pricemin)
	{
		$sel_odd.=" AND ";
		$sel_odd.="(price+price*err)>=";
		$sel_odd.=$pricemin;
	}

 
	if($pricemax)
	{
		$sel_odd.=" AND ";
		$sel_odd.="(price-price*err)<=";
		$sel_odd.=$pricemax;
	}
	
	// DO THE SEARCH
	# echo "Query to select the ODDs:";
    # echo "<br>";
	# echo "<pre>" . $sel_odd . "</pre>";
	
	$result = mysqli_query($GLOBALS['con'], "$sel_odd");
	$odd_return = array();
	
	while($rand = mysqli_fetch_array($result)) 
	{ 
		$odd_return[intval($rand[0])]=array("price"=>intval($rand[1]),"rating"=>intval($rand[2]),"err"=>intval($rand[3]));
	}
		mysqli_free_result($result);
		return($odd_return);
}
?>