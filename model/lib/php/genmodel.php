<?php
/* SELECT CONFIG IDs */
$afismodel=0;

if($conf) 
{
	$sel3="SELECT * FROM notebro_temp.all_conf_".table($conf)." WHERE id=$conf LIMIT 1"; 
	$result = mysqli_query($con, $sel3) ;
	$row = mysqli_fetch_array($result);

	$idcpu=$row["cpu"]; 
	$iddisplay=$row["display"];
	$idmem=$row["mem"];
	$idhdd=$row["hdd"];
	$idshdd=$row["shdd"];
	$idgpu=$row["gpu"];
	$idwnet=$row["wnet"];
	$idodd=$row["odd"];
	$idmdb=$row["mdb"];
	$idchassis=$row["chassis"];
	$idacum=$row["acum"];
	$idwar=$row["war"];
	$idsist=$row["sist"];
	$idmodel=$row["model"];
} 
else 
{	
	$afismodel=1;
	if($model)
	{ $idmodel=$model; }
	else	
	{ $idmodel=$conf; }
}

/* SELECT MODEL IDs */
if($idmodel)
{
	$sel3="SELECT * FROM notebro_db.MODEL WHERE id=$idmodel LIMIT 1"; 
	$result = mysqli_query($con, $sel3) ;

	if($result->num_rows)
	{
		$nonexistent=0;
		$onetime=1;
		$row = mysqli_fetch_array($result);

		$modelcpu=$row["cpu"]; 
		$modeldisplay=$row["display"];
		$modelmem=$row["mem"];
		$modelhdd=$row["hdd"];
		$modelshdd=$row["shdd"];
		$modelgpu=$row["gpu"];
		$modelwnet=$row["wnet"];
		$modelodd=$row["odd"];
		$modelmdb=$row["mdb"];
		$modelchassis=$row["chassis"];
		$modelacum=$row["acum"];
		$modelwar=$row["warranty"];
		$modelsist=$row["sist"];
		$modelprod=$row["prod"];
			
		if($afismodel)
		{
			$idcpu=current(array_slice(explode(',',$modelcpu),0,1));
			$iddisplay=current(array_slice(explode(',',$modeldisplay),0,1));
			$idmem=current(array_slice(explode(',',$modelmem),0,1));
			$idhdd=current(array_slice(explode(',',$modelhdd),0,1));
			$idshdd=current(array_slice(explode(',',$modelshdd),0,1));
			$idgpu=current(array_slice(explode(',',$modelgpu),0,1));
			$idwnet=current(array_slice(explode(',',$modelwnet),0,1));
			$idodd=current(array_slice(explode(',',$modelodd),0,1));
			$idmdb=current(array_slice(explode(',',$modelmdb),0,1));
			$idchassis=current(array_slice(explode(',',$modelchassis),0,1));
			$idacum=current(array_slice(explode(',',$modelacum),0,1));
			$idwar=current(array_slice(explode(',',$modelwar),0,1));
			$idsist=current(array_slice(explode(',',$modelsist),0,1));
		}
	}
}
function showcurrency($exc)
{
	$exc=round($exc,5);
	$result = mysqli_query($GLOBALS['con'], "SELECT code, sign, ROUND( convr, 5 ) rounded FROM notebro_site.exchrate HAVING rounded = $exc");
	$item = mysqli_fetch_array($result);
	return $item['sign'];
}

/* MAKE CPU */
function show_cpu ($model)
{
	$list=explode(',',$model);
	
	if (count($list) > 1)
	{
		echo '<form><SELECT name="CPU" onchange="showCPU(this.value)">';
		foreach($list as $key=>$id)
		{
			$sel="SELECT prod,model FROM notebro_db.CPU WHERE id=$id";
			$result = mysqli_query($GLOBALS['con'], $sel);
			$row = mysqli_fetch_array($result);
	
			if(strcasecmp($row['prod'],"INTEL")==0){$row['prod']=ucfirst(strtolower($row['prod'])); }
			if($id!=$GLOBALS['idcpu'])
			{ echo "<option value=".$id.">".$row["prod"]." ".$row["model"]."</option>"; }
			else
			{ echo "<option value=".$id." SELECTED >".$row["prod"]." ".$row["model"]."</option>"; }
		}
		echo "</SELECT></form>";
	}
	else
	{
		foreach($list as $key=>$id)
		{
			$sel="SELECT prod,model FROM notebro_db.CPU WHERE id=$id"; 
			$result = mysqli_query($GLOBALS['con'], $sel);
			$row = mysqli_fetch_array($result);
			if(strcasecmp($row['prod'],"INTEL")==0){$row['prod']=ucfirst(strtolower($row['prod'])); }
			echo $row["prod"]." ".$row["model"];
		}
	}	
}

/* MAKE GPU */
function show_gpu ($model)
{
	$a=0; 
	$b=1;
	$list=explode(',',$model);
	$havecpuint=0;
	echo '<form><SELECT name="GPU" id="GPU" onchange="showGPU(this.value)">';

	foreach($list as $key=>$id)
	{
		$sel="SELECT prod,model,typegpu FROM notebro_db.GPU WHERE id=$id"; 
		$result = mysqli_query($GLOBALS['con'], $sel);
		$row = mysqli_fetch_array($result);
		$gpulist=$id;
		
		if($row["typegpu"]>0)
		{	
			if($id!=$GLOBALS['idgpu'])
			{ $int_gpu.="<option value=".$id.">".$row["prod"]." ".$row["model"]."</option>"; }
			else
			{ $int_gpu.="<option value=".$id." SELECTED >".$row["prod"]." ".$row["model"]."</option>"; $a=1;}
	
			if($b)
			{ $gpulist=$id; $b=0; }
	
		}
		else
		{ $havecpuint=1;}
	}
	
	if(($int_gpu || $b==1) && $havecpuint)
	{
		$int_gpu=$int_gpu."<option value='-1' ";
		if(!$a)
		{ $int_gpu=$int_gpu."SELECTED"; }
		$int_gpu=$int_gpu." >CPU Integrated</option>";
	}
	
	echo $int_gpu;
	echo "</SELECT></form>";
	echo "<script>var gpudet=".$gpulist."; </script>";
}

/* MAKE DISPLAY */
function show_display ($model)
{
	$list=explode(',',$model);
	if (count($list) > 1) 
	{
		echo '<form><SELECT name="DISPLAY" onchange="showDISPLAY(this.value)">';
		foreach($list as $key=>$id)
		{
			$sel="SELECT model,touch FROM notebro_db.DISPLAY WHERE id=$id"; //echo $sel;
			$result = mysqli_query($GLOBALS['con'], $sel);
			$row = mysqli_fetch_array($result);
	
			$touch="";
			if($row["touch"]==1)
			{ $touch=" T"; }
	
			if($id!=$GLOBALS['iddisplay'])
			{ echo "<option value=".$id.">".$prodm." ".$row["model"].$touch."</option>"; }
			else
			{ echo "<option value=".$id." SELECTED >".$prodm." ".$row["model"].$touch."</option>"; }
		
		}
		echo "</SELECT></form>";
	}
	else 
	{
		foreach($list as $key=>$id)
		{
			$sel="SELECT model FROM notebro_db.DISPLAY WHERE id=$id";
			$result = mysqli_query($GLOBALS['con'], $sel);
			$row = mysqli_fetch_array($result);
			echo $prodm." ".$row["model"];
		}
	}
}

/* MAKE HDD */
function show_hdd ($model)
{
	$list=explode(',',$model);

	echo '<form><SELECT name="HDD" onchange="showHDD(this.value)">';
	foreach($list as $key=>$id)
	{
		$sel="SELECT model,cap,rpm FROM notebro_db.HDD WHERE id=$id"; 
		$result = mysqli_query($GLOBALS['con'], $sel);
		$row = mysqli_fetch_array($result);
		$rpm="";
		
		if($row["rpm"])
		{ $rpm=" ".round((floatval($row["rpm"])/1000),1)."K"; }

		if($id!=$GLOBALS['idhdd'])
		{ echo "<option value=".$id.">".$extra." ".$row["model"]." - ".$row["cap"]."GB".$rpm."</option>"; }
		else
		{ echo "<option value=".$id." SELECTED >".$extra." ".$row["model"]." - ".$row["cap"]."GB".$rpm."</option>"; }
	}
	echo "</SELECT></form>";
}

/* MAKE SHDD */
function show_shdd ($model)
{
	$text="";	
	$list=explode(',',$model);
	$nrel=count($list);

	if(!(in_array("0",$list,true)))
	{ array_unshift($list,"0"); }
	
	$text='<form><SELECT name="SHDD" onchange="showSHDD(this.value)">';
	foreach($list as $key=>$id)
	{
		$sel="SELECT id,model,cap,rpm,type FROM notebro_db.HDD WHERE id=$id"; 
		$result = mysqli_query($GLOBALS['con'], $sel);
		$row = mysqli_fetch_array($result);
		$rpm="";
		
		if(intval($row["rpm"]))
		{ $rpm=" ".round((floatval($row["rpm"])/1000),1)."K"; }
		else
		{  $rpm=" ".$row["type"]; }
		
		if($id!=0)
		{			
			if($id!=$GLOBALS['idshdd'])
			{ $text.="<option value=".$id.">".$row["cap"]."GB".$rpm."</option>"; }
			else
			{ $text.="<option value=".$id." SELECTED >".$row["cap"]."GB".$rpm."</option>"; }
		}
		else
		{
			if($id!=$GLOBALS['idshdd'])
			{ $text.="<option value="."0".">"."None"."</option>"; }
			else
			{ $text.="<option value="."0"." SELECTED >"."None"."</option>"; }	
		}
	}
	$text.="</SELECT></form>";
	
	if($nrel==1 &&  !(strcmp($row["model"],"N/A")))
	{ $text=""; }
return $text;
}

/* MAKE MDB */
function show_mdb ($model)
{
	$list=explode(',',$model);
	if (count($list) > 1)
	{
		echo '<form><SELECT name="MDB" onchange="showMDB(this.value)">';
		foreach($list as $key=>$id)
		{
			$sel="SELECT prod,submodel FROM notebro_db.MDB WHERE id=$id"; 
			$result = mysqli_query($GLOBALS['con'], $sel);
			$row = mysqli_fetch_array($result);
										
			if($id!=$GLOBALS['idmdb'])
			{ echo "<option value=".$id.">".$row["submodel"]."</option>"; }
			else
			{ echo "<option value=".$id." SELECTED >".$row["submodel"]."</option>"; }
		}
		echo "</SELECT></form>";
	}
	else 
	{
		foreach($list as $key=>$id)
		{
			$sel="SELECT prod,submodel FROM notebro_db.MDB WHERE id=$id"; 
			$result = mysqli_query($GLOBALS['con'], $sel);
			$row = mysqli_fetch_array($result);
			echo $row["submodel"];
		}
	}
}

/* MAKE MEM */
function show_mem ($model)
{
	$list=explode(',',$model);
	if (count($list) > 1) 
	{
		echo '<form><SELECT name="MEM" onchange="showMEM(this.value)">';
		foreach($list as $key=>$id)
		{
			$sel="SELECT prod,cap FROM notebro_db.MEM WHERE id=$id"; 
			$result = mysqli_query($GLOBALS['con'], $sel);
			$row = mysqli_fetch_array($result);
			
			if($id!=$GLOBALS['idmem'])
			{ echo "<option value=".$id.">".$extra." ".$row["prod"]." - ".$row["cap"]." GB </option>"; }
			else
			{ echo "<option value=".$id." SELECTED >".$extra." ".$row["prod"]." - ".$row["cap"]." GB </option>"; }
		}
		echo "</SELECT></form>";
	}
	else
	{
		foreach($list as $key=>$id)
		{
			$sel="SELECT prod,cap FROM notebro_db.MEM WHERE id=$id"; //echo $sel;
			$result = mysqli_query($GLOBALS['con'], $sel);
			$row = mysqli_fetch_array($result);
			echo $extra." ".$row["prod"]." - ".$row["cap"]." GB";
		}
	}
}

/* MAKE ODD */
function show_odd ($model)
{
	$x=1;
	$list=explode(',',$model);
	$nrel=count($list);
	
	if (count($list) > 1) 
	{
		echo '<form><SELECT name="ODD" onchange="showODD(this.value)">';
		foreach($list as $key=>$id)
		{
			$sel="SELECT type FROM notebro_db.ODD WHERE id=$id"; 
			$result = mysqli_query($GLOBALS['con'], $sel);
			$row = mysqli_fetch_array($result);
			if(strcasecmp($row["type"],"NONE")==0){$row["type"]=ucfirst(strtolower($row["type"]));}
			if($id!=$GLOBALS['idodd']) 
			{ echo "<option value=".$id.">".$row["type"]."</option>"; }
			else
			{ echo "<option value=".$id." SELECTED >".$row["type"]."</option>"; }
		}
		echo "</SELECT></form>";
	}
	else
	{
		foreach($list as $key=>$id)
		{
			$sel="SELECT type FROM notebro_db.ODD WHERE id=$id"; 
			$result = mysqli_query($GLOBALS['con'], $sel);
			$row = mysqli_fetch_array($result);
			if(strcasecmp($row["type"],"NONE")==0){$row["type"]=ucfirst(strtolower($row["type"]));}
			echo $row["type"];
		}
	}

	if($nrel==1&&((!(strcasecmp($row["type"],"NONE"))) || $row["type"]==NULL ))
	{ $x=0; }
	
	return $x;
}

/* MAKE BAT */
function show_acum ($model)
{
	$list=explode(',',$model);
	
	if (count($list) > 1)
	{
		echo '<form><SELECT name="ACUM" onchange="showACUM(this.value)">';
		foreach($list as $key=>$id)
		{
			$sel="SELECT model,nrc,cap FROM notebro_db.ACUM WHERE id=$id";
			$result = mysqli_query($GLOBALS['con'], $sel);
			$row = mysqli_fetch_array($result);
	
			if($id!=$GLOBALS['idacum'])
			{ echo "<option value=".$id.">".$row["cap"]." WHr</option>"; }
			else
			{ echo "<option value=".$id." SELECTED >".$row["cap"]." Whr</option>"; }
		}
		echo "</SELECT></form>";
	}
	else
	{
		foreach($list as $key=>$id)
		{
			$sel="SELECT cap FROM notebro_db.ACUM WHERE id=$id"; 
			$result = mysqli_query($GLOBALS['con'], $sel);
			$row = mysqli_fetch_array($result);
			echo $row["cap"]." WHr";
		}
	}
}

/* MAKE CHASSIS */
function show_chassis ($model)
{
	$chassistext="";
	$list=explode(',',$model);
	
	if (count($list) > 1)
	{
		$chassistext.='<form><SELECT name="CHASSIS" onchange="showCHASSIS(this.value)">';
		foreach($list as $key=>$id)
		{
			$sel="SELECT submodel FROM notebro_db.CHASSIS WHERE id=$id"; 
			$result = mysqli_query($GLOBALS['con'], $sel);
			$row = mysqli_fetch_array($result);
	
			if($id!=$GLOBALS['idchassis'])
			{ $chassistext.="<option value=".$id.">".$row["submodel"]."</option>"; }
			else
			{ $chassistext.="<option value=".$id." SELECTED >".$row["submodel"]."</option>"; }
		}
		$chassistext.="</SELECT></form>";
	}
	else
	{
		foreach($list as $key=>$id)
		{
			$sel="SELECT submodel,price,err FROM notebro_db.CHASSIS WHERE id=$id"; 
			$result = mysqli_query($GLOBALS['con'], $sel);
			$row = mysqli_fetch_array($result);
		}
	}
	
	return $chassistext;
}

/* MAKE WNET */
function show_wnet ($model)
{
	$list=explode(',',$model);
	
	if (count($list) > 1)
	{
		echo '<form><SELECT name="WNET" onchange="showWNET(this.value)">';
		
		foreach($list as $key=>$id)
		{
			$sel="SELECT prod,model FROM notebro_db.WNET WHERE id=$id"; 
			$result = mysqli_query($GLOBALS['con'], $sel);
			$row = mysqli_fetch_array($result);
	
			if($id!=$GLOBALS['idwnet'])
			{ echo "<option value=".$id.">".$row["prod"]." ".$row["model"]."</option>"; }
			else
			{ echo "<option value=".$id." SELECTED >".$row["prod"]." ".$row["model"]."</option>"; }
		}
		echo "</SELECT></form>";
	}
	else
	{
		foreach($list as $key=>$id)
		{
			$sel="SELECT prod,model,slot,price,err FROM notebro_db.WNET WHERE id=$id"; 
			$result = mysqli_query($GLOBALS['con'], $sel);
			$row = mysqli_fetch_array($result);
			echo $row["prod"]." ".$row["model"];
		}
	}
}

/* MAKE WAR */
function show_war ($model)
{
	$list=explode(',',$model);
	if (count($list) > 1)
	{
		echo '<form><SELECT name="WAR" onchange="showWAR(this.value)">';
		foreach($list as $key=>$id)
		{
			$sel="SELECT years,prod,price,err FROM notebro_db.WAR WHERE id=$id"; 
			$result = mysqli_query($GLOBALS['con'], $sel);
			$row = mysqli_fetch_array($result);
			
			if($id!=$GLOBALS['idwar'])
			{ echo "<option value=".$id.">".$row["years"]." - ".$row["prod"]."</option>"; }
			else
			{ echo "<option value=".$id." SELECTED >".$row["years"]." - ".$row["prod"]."</option>"; }
		}
		echo "</SELECT></form>";
	}
	else
	{
		foreach($list as $key=>$id)
		{
			$sel="SELECT years,price,err FROM notebro_db.WAR WHERE id=$id";
			$result = mysqli_query($GLOBALS['con'], $sel);
			$row = mysqli_fetch_array($result);
			echo $row["years"];
		}
	}
}

/* MAKE SIST */
function show_sist ($model)
{
	$list=explode(',',$model);
	if (count($list) > 1)
	{
		echo '<form><SELECT name="SIST" onchange="showSIST(this.value)">';
		foreach($list as $key=>$id)
		{
			$sel="SELECT sist,vers,type,price,err FROM notebro_db.SIST WHERE id=$id"; 
			$result = mysqli_query($GLOBALS['con'], $sel);
			$row = mysqli_fetch_array($result);
	
			if(is_numeric($row['vers']))
			{ $row['vers']=floatval($row['vers']); }
			if($row["vers"]==0){$row["vers"]="";}
			if($id!=$GLOBALS['idsist'])
			{ echo "<option value=".$id.">".$row["sist"]." ".$row["vers"]." ".$row["type"]."</option>"; }
			else
			{ echo "<option value=".$id." SELECTED >".$row["sist"]." ".$row["vers"]." ".$row["type"]."</option>"; }
		}
		echo "</SELECT></form>";
	}
	else
	{
		foreach($list as $key=>$id)
		{
			$sel="SELECT sist,vers,price,type,err FROM notebro_db.SIST WHERE id=$id"; 
			$result = mysqli_query($GLOBALS['con'], $sel);
			$row = mysqli_fetch_array($result);
			if(is_numeric($row['vers']))
			{ $row['vers']=floatval($row['vers']); }
			if($row["vers"]==0){$row["vers"]="";}
			echo $row["sist"]." ".$row["vers"]." ".$row["type"];
		}
	}
}

/* SELECT AND SHOW VARIOUS ELEMENTS */
function show_vars($col, $tab, $id)
{
	$sel2 = "SELECT $col FROM $tab WHERE id = $id LIMIT 1"; 
	$rea = mysqli_query($GLOBALS['con'], $sel2);
	$resu = mysqli_fetch_array($rea);
	
	global $show_vars;
	$show_vars=$resu;
	return $resu[$col];
}
?>
