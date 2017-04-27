<?php

/* ********* SELECT DISPLAYS BASED ON FILTERS ***** */

function search_display ($model, $sizemin, $sizemax, $format, $hresmin, $hresmax, $vresmin, $vresmax, $surft, $backt, $touch,  $misc, $resolutions, $ratingmin, $ratingmax, $pricemin, $pricemax, $selsize)
{
	//var_dump($touch);
	if($selsize>0)
	{ $sel_display="SELECT id,price,rating,err,size FROM notebro_db.DISPLAY WHERE 1=1"; }
	else
	{ $sel_display="SELECT id,price,rating,err FROM notebro_db.DISPLAY WHERE 1=1"; }
	
	// Add model to filter
	$i=0;
	if(gettype($model)!="array") { $model=(array)$model; }
	foreach($model as $x)
	{
		if($i) 	
		{  
			$sel_display.=" OR ";
		}
		else
		{
			$sel_display.=" AND ( ";
		}
		
		$sel_display.="model='";
		$sel_display.=$x;
		$sel_display.="'";
		$i++;
	}
	if($i>0)
	{ $sel_display.=" ) "; }
	
	// Add size to filter - smaller is better here		
	if($sizemin)
	{
		$sel_display.=" AND ";
		$sel_display.="size>=";
		$sel_display.=$sizemin;
	}

	if($sizemax)
	{
		$sel_display.=" AND ";
		$sel_display.="size<=";
		$sel_display.=$sizemax;
	}
	
	//Add format to filter
	$i=0;
	if(gettype($format)!="array") { $format=(array)$format; }
	foreach($format as $x)
	{
		if($i) 	
		{  
			$sel_display.=" OR ";
		}
		else
		{
			$sel_display.=" AND ( ";
		}
		
		$sel_display.="format='";
		$sel_display.=$x;
		$sel_display.="'";
		$i++;
	}
	if($i>0)
	{ $sel_display.=" ) "; }

	//Add surfic to filter
	$i=0;
	if(gettype($surft)!="array") { $surft=(array)$surft; }
	foreach($surft as $x)
	{	
		if($i) 	
		{  
			$sel_display.=" OR ";
		}
		else
		{
			$sel_display.=" AND ( ";
		}
		
		$sel_display.="surft='";
		$sel_display.=$x;
		$sel_display.="'";
		$i++;
	}
	if($i>0)
	{ $sel_display.=" ) "; }
	
	//Add backlight to filter
	$i=0;
	if(gettype($backt)!="array") { $backt=(array)$backt; }
	foreach($backt as $x)
	{	
		if($i) 	
		{  
			$sel_display.=" OR ";
		}
		else
		{
			$sel_display.=" AND ( ";
		}
		
		$sel_display.="backt='";
		$sel_display.=$x;
		$sel_display.="'";
		$i++;
	}
	if($i>0)
	{ $sel_display.=" ) "; }

	// Add touch to filter
	$i=0;
	if(gettype($touch)!="array") { $touch=(array)$touch; }
	foreach($touch as $x)
	{
		if($i) 	
		{  
			$sel_display.=" OR ";
		}
		else
		{
			$sel_display.=" AND ( ";
		}
		
		$sel_display.="touch='";
		$sel_display.=$x;
		$sel_display.="'";
		$i++;
	}
	if($i>0)
	{ $sel_display.=" ) "; }

	// Add resolutions to the filter
	$i=0;
	if($resolutions)
	{
		if(gettype($resolutions)!="array") { $resolutions=(array)$resolutions; }
			
		$sel_display.=" AND (";
	
		$c=0;
		foreach ($resolutions as $resolution)
		{
			if($c)
			{ $sel_display.=" OR "; }
		
			$sel_display.="(";
			$resolution2=explode("x",$resolution);
			$sel_display.="hres=";
			$sel_display.=$resolution2[0];
			$sel_display.=" AND ";
			$sel_display.="vres=";
			$sel_display.=$resolution2[1];
			$sel_display.=")";
			$c=1;
		}
		
		$sel_display.=" ) "; 
	}
	else // If no resolutions are supplied add vres and hres to filter	
	{
		if($vresmin)
		{
			$sel_display.=" AND ";
			$sel_display.="vres>=";
			$sel_display.=$vresmin;
		}

		if($vresmax)
		{
			$sel_display.=" AND ";
			$sel_display.="vres<=";
			$sel_display.=$vresmax;
		}
	}

	// Add MISC to filter
	$i=0;
	if(gettype($misc)!="array") { $misc=(array)$misc; }
	foreach($misc as $x)
	{
		if($i)
		{  
			$sel_display.=" AND ";
		}
		else
		{
			$sel_display.=" AND ( ";
		}
		
		$sel_display.="FIND_IN_SET('";
		$sel_display.=$x;
		$sel_display.="',msc)>0";
		$i++;
	}
	if($i>0)
	{ $sel_display.=" ) "; }

	// Add rating to filter	
	if($ratingmin)
	{
		$sel_display.=" AND ";
		$sel_display.="rating>=";
		$sel_display.=$ratingmin;
	}
 
	if($ratingmax)
	{
		$sel_display.=" AND ";
		$sel_display.="rating<=";
		$sel_display.=$ratingmax;
	}		
		
	// Add price to filter		
	if ($pricemin)
	{
		$sel_display.=" AND ";
		$sel_display.="(price+price*err)>=";
		$sel_display.=$pricemin;
	}

	if($pricemax)
	{
		$sel_display.=" AND ";
		$sel_display.="(price-price*err)<=";
		$sel_display.=$pricemax;
	}

	// DO THE SEARCH
	# echo "Query to select the DISPLAYs:";
    # echo "<br>";
	echo "<pre>" . $sel_display . "</pre>";

	$result = mysqli_query($GLOBALS['con'], "$sel_display");
	$display_return = array();

	while($rand = mysqli_fetch_array($result)) 
	{ 
		if($selsize>0)
		{ $display_return[intval($rand[0])]=array("price"=>intval($rand[1]),"rating"=>intval($rand[2]),"err"=>intval($rand[3]),"size"=>intval($rand[4])); }
		else
		{ $display_return[intval($rand[0])]=array("price"=>intval($rand[1]),"rating"=>intval($rand[2]),"err"=>intval($rand[3])); }
	}
		mysqli_free_result($result);
		return($display_return);
}
?>