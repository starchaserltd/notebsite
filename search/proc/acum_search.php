<?php

/* ********* SELECT BATTERY BASED ON FILTERS ***** */
 
function search_acum ($tipc, $nrcmin, $nrcmax, $volt, $capmin, $capmax, $pricemin, $pricemax, $misc, $selcap)
{

	if($selcap>0)
	{ $sel_acum="SELECT id,price,rating,err,cap FROM notebro_db.ACUM WHERE 1=1 AND valid=1"; }
	else
	{ $sel_acum="SELECT id,price,rating,err FROM notebro_db.ACUM WHERE 1=1 AND valid=1"; }
	
	// Add cells type to filter
	$i=0;
	if(gettype($tipc)!="array") { $tipc=(array)$tipc; }
	foreach($tipc as $x)
	{
			
		if($i)
		{  
			$sel_acum.=" OR ";
		}
		else
		{
			$sel_acum.=" AND ( ";
		}
		
		$sel_acum.="tipc='";
		$sel_acum.=$x;
		$sel_acum.="'";
		$i++;
	}
	if($i>0)
	{ $sel_acum.=" ) "; }

	// Add nr of cells to filter	
	if($nrcmin)
	{
		$sel_acum.=" AND ";
		$sel_acum.="nrc>=";
		$sel_acum.=$nrcmin;
	}
	
	if($nrcmax)
	{
		$sel_acum.=" AND ";
		$sel_acum.="nrc<=";
		$sel_acum.=$nrcmax;
	}	
	
	// Voltage
	if($volt)
	{
		$sel_acum.=" AND ";
		$sel_acum.="volt=";
		$sel_acum.=$volt;
	}	
	
	// Capacity
	if($capmin)
	{
		$sel_acum.=" AND ";
		$sel_acum.="cap>=";
		$sel_acum.=$capmin;
	}

 	if($capmax)
	{
		$sel_acum.=" AND ";
		$sel_acum.="cap<=";
		$sel_acum.=$capmax;
	}

	// MSC Search
	$i=0;
	if(gettype($misc)!="array") { $misc=(array)$misc; }
	foreach($misc as $x)
	{
			
		if($i)
		{  
			$sel_acum.=" AND ";
		}
		else
		{
			$sel_acum.=" AND ( ";
		}
		
		$sel_acum.="FIND_IN_SET('";
		$sel_acum.=$x;
		$sel_acum.="',msc)>0";
		$i++;
	}
	
	if($i>0)
	{ $sel_acum.=" ) "; }

	// Add price to filter		
	if ($pricemin)
	{
		$sel_acum.=" AND ";
		$sel_acum.="IF(err>0,(price-price*err)>=";
		$sel_acum.=$pricemin;
		$sel_acum.=",1)";
	}

	if($pricemax)
	{
		$sel_acum.=" AND ";
		$sel_acum.="IF(err>0,(price-price*err)<=";
		$sel_acum.=$pricemax;
		$sel_acum.=",1)";
	}
	
	// DO THE SEARCH
	# echo "Query to select the ACUM:";
    # echo "<br>";
	# echo "<pre>" . $sel_acum . "</pre>";
	
	$result = mysqli_query($GLOBALS['con'], "$sel_acum");
	$acum_return = array();

	while($rand = mysqli_fetch_array($result)) 
	{ 
		if($selcap>0)
		{ $acum_return[intval($rand[0])]=array("price"=>intval($rand[1]),"rating"=>intval($rand[2]),"err"=>intval($rand[3]),"cap"=>floatval($rand[4])); }
		else
		{ $acum_return[intval($rand[0])]=array("price"=>intval($rand[1]),"rating"=>intval($rand[2]),"err"=>intval($rand[3])); }
	}
	
	mysqli_free_result($result);
	return($acum_return);
	
}
?>