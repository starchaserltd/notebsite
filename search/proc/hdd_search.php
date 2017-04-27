<?php

/* ********* SELECT HDD BASED ON FILTERS ***** */

function search_hdd ($model, $capmin, $capmax, $type, $readspeedmin, $readspeedmax, $writesmin, $writesmax, $rpmmin, $rpmmax, $misc, $ratemin, $ratemax, $pricemin, $pricemax)
{
	$sel_hdd="SELECT id,price,rating,err FROM notebro_db.HDD WHERE 1=1";
	
	// Add models to filter
	$i=0;
	if(gettype($model)!="array") { $model=(array)$model; }
	foreach($model as $x)
	{		
		if($i)
		{  
			$sel_hdd.=" OR ";
		}
		else
		{
			$sel_hdd.=" AND ( ";
		}
		
		$sel_hdd.="model='";
		$sel_hdd.=$x;
		$sel_hdd.="'";
		$i++;
	}
	if($i>0)
	{ $sel_hdd.=" ) "; }

	// Add cap to filter
	if($capmin)
	{
		$sel_hdd.=" AND ";
		$sel_hdd.="cap>=";
		$sel_hdd.=$capmin;
	}
 
	if($capmax)
	{
		$sel_hdd.=" AND ";
		$sel_hdd.="cap<=";
		$sel_hdd.=$capmax;
	}
	
	// Add type to filter	
	$i=0;
	if(gettype($type)!="array") { $type=(array)$type; }
	foreach($type as $x)
	{
		if($i)
		{  
			$sel_hdd.=" OR ";
		}
		else
		{
			$sel_hdd.=" AND ( ";
		}
		
		$sel_hdd.="type='";
		$sel_hdd.=$x;
		$sel_hdd.="'";
		$i++;
	}
	if($i>0)
	{ $sel_hdd.=" ) "; }
	
	// Add readspeed to filter - smaller is better here		
	if($readspeedmin)
	{
		$sel_hdd.=" AND ";
		$sel_hdd.="readspeed>=";
		$sel_hdd.=$readspeedmin;
	}
 
	if($readspeedmax)
	{
		$sel_hdd.=" AND ";
		$sel_hdd.="readspeed<=";
		$sel_hdd.=$readspeedmax;
	}

	// Add write speed to filter	
	if($writesmin)
	{
		$sel_hdd.=" AND ";
		$sel_hdd.="writes>=";
		$sel_hdd.=$writesmin;
	}
 
	if($writesmax)
	{
		$sel_hdd.=" AND ";
		$sel_hdd.="writes<=";
		$sel_hdd.=$writesmax;
	}	
	
	// Add rpm to filter	
	if($rpmmin)
	{
		$sel_hdd.=" AND ";
		$sel_hdd.="rpm>=";
		$sel_hdd.=$rpmmin;
	}
 
	if($rpmmax)
	{
		$sel_hdd.=" AND ";
		$sel_hdd.="rpm<=";
		$sel_hdd.=$rpmmax;
	}	
	
	// Add MISC to filter
	$i=0;
	if(gettype($misc)!="array") { $misc=(array)$misc; }
	foreach($misc as $x)
	{		
		if($i)
		{  
			$sel_hdd.=" AND ";
		}
		else
		{
			$sel_hdd.=" AND ( ";
		}
		
		$sel_hdd.="FIND_IN_SET('";
		$sel_hdd.=$x;
		$sel_hdd.="',msc)>0";
		$i++;
	}
	if($i>0)
	{ $sel_hdd.=" ) "; }

	// Add rating to filter	
	if($ratemin)
	{
		$sel_hdd.=" AND ";
		$sel_hdd.="rating>=";
		$sel_hdd.=$ratemin;
	}
 
	if($ratemax)
	{
		$sel_hdd.=" AND ";
		$sel_hdd.="rating<=";
		$sel_hdd.=$ratemax;
	}		
	
	// Add price to filter		
	if ($pricemin)
	{
		$sel_hdd.=" AND ";
		$sel_hdd.="(price+price*err)>=";
		$sel_hdd.=$pricemin;
	}
 
	if($pricemax)
	{
		$sel_hdd.=" AND ";
		$sel_hdd.="(price-price*err)<=";
		$sel_hdd.=$pricemax;
	}

	// DO THE SEARCH
	# echo "Query to select the HDDs:";
    # echo "<br>";
	#echo "<pre>" . $sel_hdd . "</pre>";
	
	$result = mysqli_query($GLOBALS['con'], "$sel_hdd");
	$hdd_return = array();
	
	while($rand = mysqli_fetch_array($result)) 
	{ 
		$hdd_return[intval($rand[0])]=array("price"=>intval($rand[1]),"rating"=>intval($rand[2]),"err"=>intval($rand[3]));
	}

	mysqli_free_result($result);
	return($hdd_return);
}
?>