<?php

/* ********* SELECT MODEL BASED ON FILTERS ***** */

function search_model ($mmodel,$prodmodel,$fammodel,$msc,$regions,$class)
{
	$sel_model="SELECT id FROM notebro_db.MODEL WHERE 1=1";

	// Add models to filter
	$i=0;
	if(gettype($mmodel)!="array") { $mmodel=(array)$mmodel; }
	foreach($mmodel as $x)
	{
		if($i)
		{  
			$sel_model.=" OR ";
		}
		else
		{
			$sel_model.=" AND ( ";
		}
		
		$sel_model.="model='";
		$sel_model.=$x;
		$sel_model.="'";
		$i++;
	}
	if($i>0)
	{ $sel_model.=" ) "; }

	// Add prod to filter	
	$i=0;
	if(gettype($prodmodel)!="array") { $prodmodel=(array)$prodmodel; }
	foreach($prodmodel as $x)
	{
		if($i)
		{  
			$sel_model.=" OR ";
		}
		else
		{
			$sel_model.=" AND ( ";
		}
		
		$sel_model.="prod='";
		$sel_model.=$x;
		$sel_model.="'";
		$i++;
	}
	if($i>0)
	{ $sel_model.=" ) "; }

	// Add fam to filter	
	$i=0;
	if(gettype($fammodel)!="array") { $fammodel=(array)$fammodel; }
	
	foreach($fammodel as $x)
	{
		$fam_parts=explode(" ",$x); unset($fam_parts[0]); $x=implode(" ",$fam_parts);
		if($i)
		{  
			$sel_model.=" OR ";
		}
		else
		{
			$sel_model.=" AND idfam IN ( SELECT id FROM `FAMILIES` WHERE ";
		}
		
		$sel_model.="fam='";
		$sel_model.=$x;
		$sel_model.="'";
		$i++;
	}
	if($i>0)
	{ $sel_model.=" ) "; }

	// Add class to filter

	if($class!==-1)	{ $sel_model.=" AND idfam IN ( SELECT id FROM `FAMILIES` WHERE business=".$class.")"; }

	// MSC search	
	$i=0;
	if(gettype($msc)!="array") { $msc=(array)$msc; }
	foreach($msc as $x)
	{
		if($i)
		{  
			$sel_model.=" OR ";
		}
		else
		{
			$sel_model.=" AND ( ";
		}
		
		$sel_model.="msc LIKE '%";
		$sel_model.=$x;
		$sel_model.="%'";
		$i++;
	}
	if($i>0)
	{ $sel_model.=" ) "; }
	
	//REGIONS search
	$i=0;
	if(gettype($regions)!="array") { $regions=(array)$regions; }
	foreach($regions as $x)
	{
		if($GLOBALS['dispregion']==1)
		{
			if(!$i)
			{
				$sel_model.=" AND ( ";
				$sel_model.="FIND_IN_SET('";
				$sel_model.="0";
				$sel_model.="',regions)=0";
			}
			$i++;
		}
		else
		{
			if($i)
			{  
				$sel_model.=" OR ";
			}
			else
			{
				$sel_model.=" AND ( ";
			}
			
			$sel_model.="FIND_IN_SET('";
			$sel_model.=$x;
			$sel_model.="',regions)>0";
			$i++;
		}
	}
	if($i>0)
	{ $sel_model.=" ) "; }
		
	$sel_model.=" ORDER BY idabc ASC";
	
	// DO THE SEARCH
	# echo "Query to select the MODELS:";
    # echo "<br>";
	# echo "<pre>" . $sel_model . "</pre>";
	
	$result = mysqli_query($GLOBALS['con'], "$sel_model");
	$model_return = array();
	
	while($rand = mysqli_fetch_array($result)) 
	{
		$model_return[intval($rand[0])]=array("id"=>intval($rand[0]));
	}
		mysqli_free_result($result);
		return($model_return);
}
?>