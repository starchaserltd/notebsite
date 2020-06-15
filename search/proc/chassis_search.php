<?php

/* ********* SELECT CHASSIS BASED ON FILTERS ***** */

function search_chassis ($prod, $model, $thicmin, $thicmax, $depthmin, $depthmax, $widthmin, $widthmax, $color, $weightmin, $weightmax, $made, $charger, $ports, $vports, $webmin, $webmax, $touch, $misc, $special_misc, $ratemin, $ratemax, $pricemin, $pricemax, $addmsc, $twoinone,$addpi)
{
	
//var_dump($addmsc);
	$sel_chassis="SELECT id,price,rating,err FROM notebro_db.CHASSIS WHERE 1=1 AND valid=1";
	
	// Add producers to filter
	$i=0;
	if(gettype($prod)!="array") { $prod=(array)$prod; }
	foreach($prod as $x)
	{
		if($i) { $sel_chassis.=" OR "; }
		else { $sel_chassis.="AND ( "; }
			
		$sel_chassis.="prod='";
		$sel_chassis.=$x;
		$sel_chassis.="'";
		$i++;
	}
	if($i>0)
	{ $sel_chassis.=" ) "; }

	// Add models to filter	
	$i=0;
	if(gettype($model)!="array") { $model=(array)$model; }
	foreach($model as $x)
	{
		if($i) { $sel_chassis.=" OR "; }
		else { $sel_chassis.="AND ( "; }

		$sel_chassis.="model='";
		$sel_chassis.=$x;
		$sel_chassis.="'";
		$i++;
	}

	if($i>0){ $sel_chassis.=" ) "; }
	
	// Add thickness to filter 	
	if($thicmin)
	{
		$sel_chassis.=" AND ";
		$sel_chassis.="thic>=";
		$sel_chassis.=$thicmin;
	}

	if($thicmax)
	{
		$sel_chassis.=" AND ";
		$sel_chassis.="thic<=";
		$sel_chassis.=$thicmax;
	}
	
	// Add depth to filter 	
	if($depthmin)
	{
		$sel_chassis.=" AND ";
		$sel_chassis.="depth>=";
		$sel_chassis.=$depthmin;
	}
 
	if($depthmax)
	{
		$sel_chassis.=" AND ";
		$sel_chassis.="depth<=";
		$sel_chassis.=$depthmax;
	}

	// Add width to filter 	
	if($widthmin)
	{
		$sel_chassis.=" AND ";
		$sel_chassis.="width>=";
		$sel_chassis.=$widthmin;
	}
 
	if($widthmax)
	{
		$sel_chassis.=" AND ";
		$sel_chassis.="width<=";
		$sel_chassis.=$widthmax;
	}	
	
	// Add color to filter		
	$i=0;
	if(gettype($color)!="array") { $color=(array)$color; }
	foreach($color as $x)
	{
		if($i) { $sel_chassis.=" OR "; }
		else { $sel_chassis.="AND ( "; }

		$sel_chassis.="color='";
		$sel_chassis.=$x;
		$sel_chassis.="'";
		$i++;
	}

	if($i>0){ $sel_chassis.=" ) "; }
	
	// Add weight to filter 	
	if($weightmin)
	{
		$sel_chassis.=" AND ";
		$sel_chassis.="weight>=";
		$sel_chassis.=$weightmin;
	}
 
	if($weightmax)
	{
		$sel_chassis.=" AND ";
		$sel_chassis.="weight<=";
		$sel_chassis.=$weightmax;
	}	
	
	// Add material made of  to filter		
	$i=0;
	if(isset($made[0]))
	{
		if(gettype($made)!="array") { $made=(array)$made; }
		foreach($made as $x)
		{
			if($i) { $sel_chassis.=" OR "; }
			else { $sel_chassis.=" AND ( "; }

			/* This is for a more stricter search
			$sel_chassis.="FIND_IN_SET('";
			$sel_chassis.=$x;
			$sel_chassis.="',made)>0";
			*/
		
			$sel_chassis.="made LIKE ";
			$sel_chassis.="'%".$x."%'";
			$i++;
		}
		
		if($i>0){ $sel_chassis.=" ) "; }
	}
	
	if($charger && $charger!="")
	{
		$sel_chassis.=" AND ";
		$sel_chassis.="charger LIKE '%".$charger."%'";
	}	
	
	// Port intreface filter
	$i=0;
	if(gettype($ports)!="array") { $ports=(array)$ports; }
	foreach($ports as $x)
	{	
		if($i){ $sel_chassis.=" AND "; }
		else { $sel_chassis.=" AND ( "; }

		if(!($GLOBALS['diffpisearch']))
		{
			$x2=explode(" X ",$x);
			$closeme=0;	
			if(isset($addpi[$x])||isset($addmsc[$x]))
			{ $sel_chassis.="("; }
			
			$sel_chassis.="(";
			
			if(strcasecmp($x2[0],$x)==0)
			{
				$sel_chassis.="FIND_IN_SET('";
				$sel_chassis.=$x;
				$sel_chassis.="',pi)>0";
			}
			else
			{ 			
				$sel_chassis.='pi LIKE "%';
				$sel_chassis=$sel_chassis.$x2[0]." X ".$x2[1]; 
				$sel_chassis.='%"';
				
				for($z=(intval($x2[0])+1);$z<7;$z++) 
				{
					$sel_chassis.=" OR ";
					$sel_chassis.='pi LIKE "%';
					$sel_chassis=$sel_chassis.$z." X ".$x2[1]; 
					$sel_chassis.='%"';
				}
			}
		
			//some ports include other ports as well
			if(isset($addpi[$x]))
			{
				foreach($addpi[$x] as $x3)
				{
					$sel_chassis.=" OR ";
					$sel_chassis.="FIND_IN_SET('";
					$sel_chassis.=$x3;
					$sel_chassis.="',pi)>0";
				}
			}
			
			if(isset($addmsc[$x]))
			{ 
				foreach($addmsc[$x] as $x4)
				{	
					$sel_chassis.=" OR ";
					$sel_chassis.=" msc LIKE ";
					$sel_chassis.="'%".$x4."%' ";
				}
			}
			
			if(isset($addpi[$x])||isset($addmsc[$x]))
			{
				$sel_chassis.=")"; unset($addmsc[$x]);
			}
			
			$sel_chassis.=")";
		}
		else
		{
			$x2=explode(" X ",$x);
			$sel_chassis.="pi LIKE ";
			$sel_chassis.="'%".$x2[1]."%'";
			$i++;
		}
		$i++;
	}
	if($i>0){ $sel_chassis.=" ) "; }

	// video port intreface filter
	$i=0;
	if(gettype($vports)!="array") { $vports=(array)$vports; }
	$add_part_link=false;
	foreach($vports as $x)
	{
		if(!$i){ $sel_chassis.=" AND ("; $i++; }
		if($x=="group"){if($add_part_link){ $sel_chassis.="AND (";}else{$sel_chassis.="(";} $add_part_link=false; continue;}
		if($x=="ungroup"){$sel_chassis.=")"; $add_part_link=true; $i++; continue;}
		
		if($add_part_link){	if(isset($x["or"])&&$x["or"]){ $sel_chassis.=" OR "; }else{ $sel_chassis.=" AND "; } }
		
		$table="`vi`";
		if(isset($x["alt"])){$table=$x["alt"];}

		if(isset($x["value"]))
		{
			if(isset($x["prop"])&&$x["prop"]=="diffvisearch")
			{ $sel_chassis.=$table." LIKE '%".$x["value"]."%'"; $add_part_link=true; }
			else
			{ $sel_chassis.="FIND_IN_SET('".$x["value"]."',".$table.")>0"; $add_part_link=true; }
		}
	
		$i++;
	}
	if($i>0){ $sel_chassis.=" ) "; }

	// Add webcam to filter 	
	if($webmin)
	{
		$sel_chassis.=" AND ";
		$sel_chassis.="web>=";
		$sel_chassis.=$webmin;
	}

 	if($webmax)
	{
		$sel_chassis.=" AND ";
		$sel_chassis.="web<=";
		$sel_chassis.=$webmax;
	}	

	// Add touch	
	$i=0;
	if(gettype($touch)!="array") { $touch=(array)$touch; }
	foreach($touch as $x)
	{
		if($i){ $sel_chassis.=" AND "; }
		else { $sel_chassis.=" AND ( "; }

		$sel_chassis.="FIND_IN_SET('";
		$sel_chassis.=$x;
		$sel_chassis.="',touch)>0";
		$i++;
	}
	if($i>0){ $sel_chassis.=" ) "; }
		
	// Add MISC to filter
	$i=0;
	if(gettype($misc)!="array") { $misc=(array)$misc; }
	foreach($misc as $x)
	{	
		if($i){ $sel_chassis.=" AND "; }
		else { $sel_chassis.=" AND ( "; }

		$sel_chassis.="FIND_IN_SET('";
		$sel_chassis.=$x;
		$sel_chassis.="',msc)>0";
		$i++;
	}
	if($i>0){ $sel_chassis.=" ) "; }
	
	// Add stuff  to filter		
	$i=0; $ii=0;
	if(gettype($special_misc)!="array") { $special_misc=(array)$special_misc; }
	if($special_misc)
	{
		$group=0;
		foreach($special_misc as $x)
		{
			if(!strcmp($x,"group")){$group=1; $ii=0; continue;}
			if(!strcmp($x,"ungroup")){$group=0; if($ii){ $sel_chassis.=" ) ";  } continue;}
			if($i)
			{  
				if(!$group)
				{ $sel_chassis.=" AND ";}
				else
				{ 	if($ii)
					{ $sel_chassis.=" OR "; }
					else
					{ $sel_chassis.=" AND ( "; $ii++; }
				}
			}
			else
			{
				if(!$group)
				{ $sel_chassis.=" AND ( "; }
				else
				{ $sel_chassis.=" AND ( ( "; $ii++; }
			}
			
			$sel_chassis.="( keyboard LIKE ";
			$sel_chassis.="'%".$x."%'";
			$sel_chassis.=" OR ";
			$sel_chassis.="msc LIKE ";
			$sel_chassis.="'%".$x."%'";
			$sel_chassis.=" OR ";
			$sel_chassis.="touch LIKE ";
			$sel_chassis.="'%".$x."%' )";
			$i++;
		}
	}
	if($i>0){ $sel_chassis.=" ) "; }

	// Add rating to filter	
	if($ratemin)
	{
		$sel_chassis.=" AND ";
		$sel_chassis.="rating>=";
		$sel_chassis.=$ratemin;
	}

 	if($ratemax)
	{
		$sel_chassis.=" AND ";
		$sel_chassis.="rating<=";
		$sel_chassis.=$ratemax;
	}		
		
	// Add price to filter		
	if ($pricemin)
	{
		$sel_chassis.=" AND ";
		$sel_chassis.="IF(err>0,(price-price*err)>=";
		$sel_chassis.=$pricemin;
		$sel_chassis.=",1)";
	}

	if($pricemax)
	{
		$sel_chassis.=" AND ";
		$sel_chassis.="IF(err>0,(price-price*err)<=";
		$sel_chassis.=$pricemax;
		$sel_chassis.=",1)";
	}

	//EXTRA MSC SEARCH ELEMENTS	
	$i=0;
	if(gettype($addmsc)!="array") { $addmsc=(array)$addmsc; } 
	if(isset($addmsc[0]))
	{
		foreach($addmsc[0] as $x)
		{
			if($i) { $sel_chassis.=" AND "; }
			else { $sel_chassis.=" OR ( "; }

			$sel_chassis.="msc LIKE ";
			$sel_chassis.="'%".$x."%'";
			
			$i++;
		}
	}
		
	if($i>0){ $sel_chassis.=" ) "; }
//********************************************************************************************************************

	// Add twoinone to filter

	$i=0;
	if(gettype($twoinone)!="array") { $twoinone=(array)$twoinone; }
	foreach($twoinone as $x)
	{
		if($i) { $sel_chassis.=" OR "; }
		else { $sel_chassis.=" AND ( "; }
		
		$sel_chassis.="twoinone='";
		$sel_chassis.=$x;
		$sel_chassis.="'";
		$i++;
	}
	if($i>0){ $sel_chassis.=" ) "; }
	
	// DO THE SEARCH
	# echo "Query to select the CHASSIS:";
	# echo "<br>";
	# echo "<pre>" . $sel_chassis. "</pre>";

	$result = mysqli_query($GLOBALS['con'], "$sel_chassis");
	$chassis_return = array();
	
	while($rand = mysqli_fetch_array($result)) 
	{ 
		$chassis_return[intval($rand[0])]=array("price"=>intval($rand[1]),"rating"=>intval($rand[2]),"err"=>intval($rand[3]));
	}
	mysqli_free_result($result);
	return($chassis_return);
	}
?>
