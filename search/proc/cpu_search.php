<?php

/* ********* SELECT CPUS BASED ON FILTERS ***** */

function search_cpu ($prod, $model, $ldmin, $ldmax, $status, $socket, $techmin, $techmax, $cachemin, $cachemax, $clockmin, $clockmax, $turbomin, $turbomax, $tdpmax, $tdpmin, $coremin, $coremax, $intgpu, $misc, $ratemin, $ratemax, $pricemin, $pricemax, $seltdp)
{
	if($seltdp>0)
	{ $sel_cpu="SELECT id,price,rating,err,gpu,tdp FROM notebro_db.CPU WHERE 1=1 AND valid=1"; }
	else
	{ $sel_cpu="SELECT id,price,rating,err,gpu FROM notebro_db.CPU WHERE 1=1 AND valid=1"; }
	
	// Add producers to filter
	$i=0;
	if(gettype($prod)!="array") { $prod=(array)$prod; }
	foreach($prod as $x)
	{
		if($i)
		{ $sel_cpu.=" OR "; }
		else
		{ $sel_cpu.=" AND ( "; }
	
		$sel_cpu.="prod='";
		$sel_cpu.=$x;
		$sel_cpu.="'";
		$i++;
	}
	
	if($i>0) { $sel_cpu.=" ) "; }

	// Add models to filter	
	$i=0;
	if(gettype($model)!="array") { $model=(array)$model; }
	foreach($model as $x)
	{	
		if($i)
		{ $sel_cpu.=" OR "; }
		else
		{ $sel_cpu.=" AND ( "; }

		$sel_cpu.="model='";
		$sel_cpu.=$x;
		$sel_cpu.="'";
		$i++;
	}

	if($i>0) { $sel_cpu.=" ) "; }
	
	// Add date to filter		
	if($ldmin)
	{
		$sel_cpu.=" AND";
		$sel_cpu.=" (";
		$sel_cpu.="ldate BETWEEN '";
		$sel_cpu.=$ldmin;
	}
	else
	{
		$sel_cpu.=" AND";
		$sel_cpu.=" (";
		$sel_cpu.="ldate BETWEEN ";
		$sel_cpu.="'0000-00-00";
	}

 	if($ldmax)
	{
		$sel_cpu.="' AND '";
		$sel_cpu.=$ldmax;
		$sel_cpu.="')";
	}
	else
	{
		$sel_cpu.="' AND '";
		$sel_cpu.=date('Y-m-d', strtotime("-1 days"));
		$sel_cpu.="')";
	}

	// Add STATUS to filter		
	if($status)
	{
		$sel_cpu.=" AND ";
		$sel_cpu.="status=";
		$sel_cpu.=$status;
	}	

	// Add SOCKET to filter	
	$i=0;
	if(gettype($socket)!="array") { $socket=(array)$socket; }
	foreach($socket as $x)
	{	
		if($i)
		{ $sel_cpu.=" OR "; }
		else
		{ $sel_cpu.=" AND ( "; }

		$sel_cpu.="socket='";
		$sel_cpu.=$x;
		$sel_cpu.="'";
		$i++;
	}
	if($i>0) { $sel_cpu.=" ) ";	}
	
	// Add tech to filter - smaller is better here		
	if($techmin)
	{
		$sel_cpu.=" AND ";
		$sel_cpu.="tech<=";
		$sel_cpu.=$techmin;
	}
 
	if($techmax)
	{
		$sel_cpu.=" AND ";
		$sel_cpu.="tech>=";
		$sel_cpu.=$techmax;
	}

	// Add cache to filter	
	if($cachemin)
	{
		$sel_cpu.=" AND ";
		$sel_cpu.="cache>=";
		$sel_cpu.=$cachemin;
	}

 	if($cachemax)
	{
		$sel_cpu.=" AND ";
		$sel_cpu.="cache<=";
		$sel_cpu.=$cachemax;
	}	
	
	// Add clock to filter	
	if($clockmin)
	{
		$sel_cpu.=" AND ";
		$sel_cpu.="clocks>=";
		$sel_cpu.=$clockmin;
	}

	if($clockmax)
	{
		$sel_cpu.=" AND ";
		$sel_cpu.="clocks<=";
		$sel_cpu.=$clockmax;
	}	
	
	// Add turbo clock to filter	
	if($turbomin)
	{
		$sel_cpu.=" AND ";
		$sel_cpu.="maxtf>=";
		$sel_cpu.=$turbomin;
	}
 
	if($turbomax)
	{
		$sel_cpu.=" AND ";
		$sel_cpu.="maxtf<=";
		$sel_cpu.=$turbomax;
	}	
	
	// Add tdp to filter		
	if($tdpmin)
	{
		$sel_cpu.=" AND ";
		$sel_cpu.="tdp>=";
		$sel_cpu.=$tdpmin;
	}

 	if($tdpmax)
	{
		$sel_cpu.=" AND ";
		$sel_cpu.="tdp<=";
		$sel_cpu.=$tdpmax;
	}
	
	// Add cores to filter	
	if($coremin)
	{
		$sel_cpu.=" AND ";
		$sel_cpu.="cores>=";
		$sel_cpu.=$coremin;
	}

	if($coremax)
	{
		$sel_cpu.=" AND ";
		$sel_cpu.="cores<=";
		$sel_cpu.=$coremax;
	}	
	
	// Add Integrated GPU to filter		
	if($intgpu)
	{
		$sel_cpu.=" AND ";
		$sel_cpu.="gpu>=";
		$sel_cpu.=$intgpu;
	}	
	
	// Add MISC to filter
	$i=0;
	if(gettype($misc)!="array") { $misc=(array)$misc; }
	foreach($misc as $x)
	{
		if(stripos($x,"Intel Core")===FALSE && stripos($x,"Ryzen")===FALSE && stripos($x,"Intel Xeon")===FALSE)
		{
			if($i)
			{ $sel_cpu.=" AND "; }
			else
			{ $sel_cpu.=" AND ( "; }	
			
			if(strcmp($x,"AVX1.0")==0) { $x="AVX/AVX1.0/AVX2.0"; }
			
			if(strpbrk($x,"/"))
			{	$sel_cpu.=" (";
				$z=explode("/",$x);
				$sel_cpu.="FIND_IN_SET('";
				$sel_cpu.=$z[0];	
				$sel_cpu.="',msc)>0";
				unset($z[0]);
				foreach($z as $t)
				{	$sel_cpu.=" OR "; $sel_cpu.="FIND_IN_SET('"; $sel_cpu.=$t;	$sel_cpu.="',msc)>0";	}
				$sel_cpu.=")";
			}	
			else
			{
				$sel_cpu.="FIND_IN_SET('";
				$sel_cpu.=$x;
				$sel_cpu.="',msc)>0";
			}
			$i++;
		}
	}
	if($i>0){ $sel_cpu.=" ) "; }

	$i=0;
	if(gettype($misc)!="array") { $misc=(array)$misc; }
	foreach($misc as $x)
	{
		if(stripos($x,"Intel Core")!==FALSE||stripos($x,"Intel Xeon")!==FALSE)
		{
			if($i)
			{ $sel_cpu.=" OR "; }
			else
			{ $sel_cpu.=" AND ("; }
			
			if(stripos($x,"Xeon")!==FALSE){$x="Xeon";}else{$x=str_ireplace("Intel Core ","",$x);}
			if(stripos($x,"/")!==FALSE)
			{ 
				$x=explode("/",$x);
				$sel_cpu.="(";
				foreach($x as $part_of_x)
				{
					$sel_cpu.="model LIKE '%".$part_of_x." %' OR model LIKE '%".$part_of_x."-%' OR ";
				}
				$sel_cpu=substr($sel_cpu, 0, -3); //REMOVING trailing OR
				$sel_cpu.=")";
			}
			else
			{ $sel_cpu.="model LIKE '%".$x." %'"; }
			$i++;
		}
		elseif(stripos($x,"Ryzen 3")!==FALSE)
		{
			if($i)
			{ $sel_cpu.=" OR "; }
			else
			{ $sel_cpu.=" AND ("; }
			
			$sel_cpu.="model LIKE '%"."Ryzen 3"."%'";	
			$i++;
		}
		elseif(stripos($x,"Ryzen 5")!==FALSE)
		{
			if($i)
			{ $sel_cpu.=" OR "; }
			else
			{ $sel_cpu.=" AND ("; }
			
			$sel_cpu.="model LIKE '%"."Ryzen 5"."%'";	
			$i++;
		}
		elseif(stripos($x,"Ryzen 7")!==FALSE)
		{
			if($i)
			{ $sel_cpu.=" OR "; }
			else
			{ $sel_cpu.=" AND ("; }
			
			$sel_cpu.="model LIKE '%"."Ryzen 7"."%'";	
			$i++;
		}
		elseif(stripos($x,"Ryzen")!==FALSE)
		{
			if($i)
			{ $sel_cpu.=" OR "; }
			else
			{ $sel_cpu.=" AND ("; }
			
			$sel_cpu.="model LIKE '%"."Ryzen"."%'";	
			$i++;
		}
	}
	if($i>0){ $sel_cpu.=" ) "; }
	
	// Add rating to filter	
	if($ratemin)
	{
		$sel_cpu.=" AND ";
		$sel_cpu.="rating>=";
		$sel_cpu.=$ratemin;
	}

 	if($ratemax)
	{
		$sel_cpu.=" AND ";
		$sel_cpu.="rating<=";
		$sel_cpu.=$ratemax;
	}		
	
	// Add price to filter		
	if ($pricemin)
	{
		$sel_cpu.=" AND ";
		$sel_cpu.="IF(err>0,(price-price*err)>=";
		$sel_cpu.=$pricemin;
		$sel_cpu.=",1)";
	}

	if($pricemax)
	{
		$sel_cpu.=" AND ";
		$sel_cpu.="IF(err>0,(price-price*err)<=";
		$sel_cpu.=$pricemax;
		$sel_cpu.=",1)";
	}
	
	// DO THE SEARCH
	# echo "Query to select the CPUs:";
    # echo "<br>";
    #echo "<pre>" . $sel_cpu . "</pre>";

	$result=mysqli_query($GLOBALS['con'],$sel_cpu);
	$cpu_return = array();
	
	if(!($result&&mysqli_num_rows($result)))
	{
		if(isset($model[0]))
		{
			if($seltdp>0)
			{ $sel_cpu="SELECT id,price,rating,err,gpu,tdp FROM notebro_db.CPU WHERE 1=1 AND valid=1"; }
			else
			{ $sel_cpu="SELECT id,price,rating,err,gpu FROM notebro_db.CPU WHERE 1=1 AND valid=1"; }
			
			$i=0;
			if(gettype($model)!="array") { $model=(array)$model; }
			foreach($model as $x)
			{	
				if($i)
				{ $sel_cpu.=" OR "; }
				else
				{ $sel_cpu.=" AND ( "; }

				$sel_cpu.="model='";
				$sel_cpu.=$x;
				$sel_cpu.="'";
				$i++;
			}
			if($i>0) { $sel_cpu.=" ) "; }
			$result=mysqli_query($GLOBALS['con'],$sel_cpu);
		}
		
	}
	
	while($rand = mysqli_fetch_array($result)) 
	{ 
		if($seltdp>0)
		{ $cpu_return[intval($rand[0])]=array("price"=>intval($rand[1]),"rating"=>intval($rand[2]),"err"=>intval($rand[3]),"gpu"=>intval($rand[4]),"tdp"=>intval($rand[5])); }
		else
		{ $cpu_return[intval($rand[0])]=array("price"=>intval($rand[1]),"rating"=>intval($rand[2]),"err"=>intval($rand[3]),"gpu"=>intval($rand[4])); }
	}

	mysqli_free_result($result);
	return($cpu_return);
}
?>
