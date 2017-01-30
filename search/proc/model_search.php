<?php

/* ********* SELECT MODEL BASED ON FILTERS ***** */

function search_model ($mmodel,$prodmodel,$fammodel,$msc)
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
		if($i)
		{  
			$sel_model.=" OR ";
		}
		else
		{
			$sel_model.=" AND ( ";
		}
		
		$sel_model.="fam='";
		$sel_model.=$x;
		$sel_model.="'";
		$i++;
	}
	if($i>0)
	{ $sel_model.=" ) "; }

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