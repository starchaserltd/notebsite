<?php

/* ********* SELECT WNET BASED ON FILTERS ***** */

function search_wnet ($prod, $model, $misc, $speedmin, $speedmax, $bt, $ratemin, $ratemax, $pricemin, $pricemax)
{
	$sel_wnet="SELECT id,price,rating,err FROM WNET WHERE 1=1 AND valid=1";
	
	// Add producers to filter
	$i=0;
	if(gettype($prod)!="array") { $prod=(array)$prod; }
	foreach($prod as $x)
	{
		if($i)
		{  
			$sel_wnet.=" OR ";
		}
		else
		{
			$sel_wnet.=" AND ( ";
		}
		
		$sel_wnet.="prod='";
		$sel_wnet.=$x;
		$sel_wnet.="'";
		$i++;
	}
	if($i>0)
	{ $sel_wnet.=" ) "; }

	// Add models to filter	
	$i=0;
	if(gettype($model)!="array") { $model=(array)$model; }
	foreach($model as $x)
	{
		if($i)
		{  
			$sel_wnet.=" OR ";
		}
		else
		{
			$sel_wnet.=" AND ( ";
		}
		
		$sel_wnet.="model='";
		$sel_wnet.=$x;
		$sel_wnet.="'";
		$i++;
	}
	if($i>0)
	{ $sel_wnet.=" ) "; }

	// Add MISC to filter
	$i=0;
	if(gettype($misc)!="array") { $misc=(array)$misc; }
	foreach($misc as $x)
	{
		if($i)
		{  
			$sel_wnet.=" AND ";
		}
		else
		{
			$sel_wnet.=" AND ( ";
		}
		
		$sel_wnet.="FIND_IN_SET('";
		$sel_wnet.=$x;
		$sel_wnet.="',msc)>0";
		$i++;
	}
	if($i>0)
	{ $sel_wnet.=" ) "; }

	//Add speed to filter
	if($speedmin)
	{
		$sel_wnet.=" AND ";
		$sel_wnet.="speed>=";
		$sel_wnet.=$speedmin;
	}
 
	if($speedmax)
	{
		$sel_wnet.=" AND ";
		$sel_wnet.="speed<=";
		$sel_wnet.=$speedmax;
	}
	
	//Add bluetooth to filter
	if($bt=="1")
	{
		$sel_wnet.=" AND ";
		$sel_wnet.="LOWER(`MSC`) LIKE LOWER('%bluetooth%')";
	}		

	// Add rating to filter	
	if($ratemin)
	{
		$sel_wnet.=" AND ";
		$sel_wnet.="rating>=";
		$sel_wnet.=$ratemin;
	}
 
	if($ratemax)
	{
		$sel_wnet.=" AND ";
		$sel_wnet.="rating<=";
		$sel_wnet.=$ratemax;
	}		
		
	// Add price to filter		
	if ($pricemin)
	{
		$sel_wnet.=" AND ";
		$sel_wnet.="IF(err>0,(price-price*err)>=";
		$sel_wnet.=$pricemin;
		$sel_wnet.=",1)";
	}

	if($pricemax)
	{
		$sel_wnet.=" AND ";
		$sel_wnet.="IF(err>0,(price-price*err)<=";
		$sel_wnet.=$pricemax;
		$sel_wnet.=",1)";
	}

	// DO THE SEARCH
	# echo "Query to select the WNET:";
    # echo "<br>";
	# echo "<pre>" . $sel_wnet . "</pre>";
	
	$result = mysqli_query($GLOBALS['con'], $sel_wnet);
	$wnet_return = array();
	
	while($rand = mysqli_fetch_array($result)) 
	{ 
		$wnet_return[intval($rand[0])]=array("price"=>intval($rand[1]),"rating"=>intval($rand[2]),"err"=>intval($rand[3]));
	}
		mysqli_free_result($result);
		return($wnet_return);
}
?>