<?php

/* ********* SELECT REGIONS BASED ON FILTERS ***** */

function search_regions ($name)
{
	$sel_regions="SELECT id, code, name, disp, valid FROM REGIONS WHERE 1=1";
	// Add models to filter
	$i=0;
	if(gettype($name)!="array") { $name=(array)$name; }

	foreach($name as $x)
	{ 
		if($i)
		{ $sel_regions.=" OR "; }
		else
		{ $sel_regions.=" AND ( "; }
		
		$sel_regions.="name='";
		$sel_regions.=$x;
		$sel_regions.="'";
		$i++;
	}
	if($i>0)
	{ $sel_regions.=" ) "; }

	
	// DO THE SEARCH
	# echo "Query to select the WARRANTYs:";
    # echo "<br>";
	#echo "<pre>" . $sel_regions . "</pre>";
	
	$result = mysqli_query($GLOBALS['con'], "$sel_regions");
	$regions_return = array();
	$alltest=1;
	while($rand = mysqli_fetch_array($result)) 
	{
		$regions_return[]=$rand[0];
		if(intval($rand[0])==1) { $alltest=0; $GLOBALS['dispregion']=1; }
	}
	
	if($alltest) { $regions_return[]="1"; }

		mysqli_free_result($result);
		return($regions_return);
}
?>