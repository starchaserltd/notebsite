<?php
/* SELECT CONFIG IDs */
if(!$components_found)
{
	if($conf) 
	{
		$init_conf=$conf;
		require_once("../etc/con_sdb.php");
		$t=table($conf); $conf=$t[0];

		$change_model_region=true;
		foreach(get_regions_model($con,$t[1]) as $val){if(($val=="0")||($val=="1")||in_array($val,$ex_regions)){$change_model_region=false;} }
		$sel3="SELECT * FROM notebro_temp.all_conf_".$t[1]." WHERE id=".$t[0]." LIMIT 1";
		$cons=dbs_connect();
		$result=mysqli_query($cons,$sel3);
		if(have_results($result))
		{
			$row=mysqli_fetch_assoc($result);
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
			$cf=intval($row["rating"]);
			$cprice=floatval($row["price"]);
			$cperr=floatval($row["err"]);

			if(in_array($idwar,$ex_war)||$change_model_region||intval($row["price"])<1)
			{
				$conf=array(); $conf[0]=$idmodel; $conf[1]=$idcpu; $conf[2]=$iddisplay; $conf[3]=$idmem; $conf[4]=$idhdd; $conf[5]=$idshdd; $conf[6]=$idgpu; $conf[7]=$idwnet; $conf[8]=$idodd; $conf[9]=$idmdb; $conf[10]=$idchassis; $conf[11]=$idacum; $conf[12]=implode(",",$ex_war); $conf[13]=$idsist; if($conf[12]==""||$conf[12]==null){$conf[12]="-1000";}
				$include_getconf=true; $conf_only_search=true; if($change_model_region){$conf_only_search=false;} $warnotin=" NOT"; $excode=$exchcode; $comp="1=1";
				require_once("lib/php/query/getconf.php");
				if(isset($rows["cid"])&&intval($rows["cid"])!=NULL)
				{
					$idcpu=$rows["all"]["cpu"]; 
					$iddisplay=$rows["all"]["display"];
					$idmem=$rows["all"]["mem"];
					$idhdd=$rows["all"]["hdd"];
					$idshdd=$rows["all"]["shdd"];
					$idgpu=$rows["all"]["gpu"];
					$idwnet=$rows["all"]["wnet"];
					$idodd=$rows["all"]["odd"];
					$idmdb=$rows["all"]["mdb"];
					$idchassis=$rows["all"]["chassis"];
					$idacum=$rows["all"]["acum"];
					$idwar=$rows["all"]["war"];
					$idsist=$rows["all"]["sist"];
					$idmodel=$rows["cmodel"];
					$cf=intval($rows["all"]["rating"]);
					$cprice=floatval($rows["all"]["price"]);
					$cperr=floatval($rows["all"]["err"]);
					$conf=$rows["cid"];
				}
				else
				{ $conf=$t[0]; $result=null; }
			}
			else
			{
				require_once("lib/php/query/get_best_low.php");
				$best_low=get_best_low($cons,$ex_regions,$idmodel);
			}
			mysqli_free_result($result);
		}
		mysqli_close($cons);
	} 
	else 
	{	
		$afismodel=1;
		if($model)
		{ $idmodel=$model; }
		else	
		{ $idmodel=$conf; }
	}
}

/* SELECT MODEL IDs */
if($idmodel)
{
	$p_model=$idmodel; $sel3="SELECT `notebro_db`.`MODEL`.`p_model`,`notebro_db`.`MODEL`.`regions` FROM `notebro_db`.`MODEL` WHERE `id`=".$idmodel." LIMIT 1";
	$result=mysqli_query($con,$sel3); $change_model_region=false; if($result->num_rows){$row=mysqli_fetch_assoc($result); $p_model=intval($row["p_model"]); $change_model_region=true; $model_regions=array_map('strval', explode(",",$row["regions"])); foreach($model_regions as $val){ if(($val=="0")||($val=="1")||in_array($val,$ex_regions)){ $change_model_region=false;} if(!isset($model_ex)){ $model_ex=$region_ex[intval($val)][0];} } unset($row); }
	?>
	<script>var model_ex="<?php if($change_model_region){ echo $model_ex; $exch=floatval($exchange_list->{$model_ex}["convr"]); $selected_ex=$model_ex;} else{ echo $exchcode; $selected_ex=$exchcode; } ?>";  var exch=<?php echo $exch; ?>; </script>
	<?php
	if(isset($model_ex))
	{
		$region_sel="SELECT `regions` FROM `notebro_site`.`exchrate` WHERE `code`='".$model_ex."' LIMIT 1";
		$region_result=mysqli_query($con,$region_sel);
		if(have_results($region_result))
		{
			$region_row=mysqli_fetch_assoc($region_result);
			$model_regions=explode(",",$region_row["regions"]);
			mysqli_free_result($region_result);
		}
	}
	if(!(isset($model_regions) && $model_regions!=NULL)){ $model_regions=array(); }
	$model_regions=array_map('intval',$model_regions); $model_regions=array_unique($model_regions);
	if(count($model_regions)<2 && $model_regions[0]==0){$model_regions[]=1; $model_regions[]=2; }
	$sql_parts=[]; foreach($model_regions as $model_region){  $sql_parts[]="FIND_IN_SET(".$model_region.",`regions`)>0"; }
	$sel3="SELECT `model`.*,GROUP_CONCAT(`model`.`cpu`) AS `gcpu`,GROUP_CONCAT(`model`.`display`) AS `gdisplay`,GROUP_CONCAT(`model`.`mem`) AS `gmem`,GROUP_CONCAT(`model`.`hdd`) AS `ghdd`,GROUP_CONCAT(`model`.`shdd`) AS `gshdd`,GROUP_CONCAT(`model`.`gpu`) AS `ggpu`,";
	$sel3.="GROUP_CONCAT(`model`.`wnet`) AS `gwnet`,GROUP_CONCAT(`model`.`odd`) AS `godd`,GROUP_CONCAT(`model`.`mdb`) AS `gmdb`,GROUP_CONCAT(`model`.`chassis`) AS `gchassis`,GROUP_CONCAT(`model`.`acum`) AS `gacum`,";
	$sel3.="GROUP_CONCAT(`model`.`warranty`) AS `gwarranty`,GROUP_CONCAT(`model`.`sist`) AS `gsist`,GROUP_CONCAT(CONCAT(`comments`.`type`,'+++',`comments`.`comment`)) AS `gcomments` FROM `notebro_db`.`MODEL` AS `model` LEFT JOIN `notebro_db`.`COMMENTS` AS `comments` ON `model`.`p_model`=`comments`.`model`";
	$sel3.=" WHERE `model`.`p_model`=".$p_model." AND (".implode(" OR ",$sql_parts).") LIMIT 1";
	unset($sql_parts);
	$result=mysqli_query($con,$sel3);

	if($result&&($result->num_rows)>0)
	{
		$row=mysqli_fetch_array($result);
		if(isset($row[0])&&$row[0]!=NULL)
		{
			$nonexistent=0;
			$onetime=1;

			$modelcpu=array_unique(explode(",",$row["gcpu"])); 
			$modeldisplay=array_unique(explode(",",$row["gdisplay"]));
			$modelmem=array_unique(explode(",",$row["gmem"]));
			$modelhdd=array_unique(explode(",",$row["ghdd"]));
			$modelshdd=array_unique(explode(",",$row["gshdd"]));
			$modelgpu=array_unique(explode(",",$row["ggpu"]));
			$modelwnet=array_unique(explode(",",$row["gwnet"]));
			$modelodd=array_unique(explode(",",$row["godd"]));
			$modelmdb=array_unique(explode(",",$row["gmdb"]));
			$modelchassis=array_unique(explode(",",$row["gchassis"]));
			$modelacum=array_unique(explode(",",$row["gacum"]));
			$modelwar=array_unique(explode(",",$row["gwarranty"]));
			$modelsist=array_unique(explode(",",$row["gsist"]));
			$modelcomments=array_unique(explode(",",$row["gcomments"]));
			$modelprod=$row["prod"];
				
			if($afismodel)
			{
				$idcpu=current(array_slice($modelcpu,0,1));
				$iddisplay=current(array_slice($modeldisplay,0,1));
				$idmem=current(array_slice($modelmem,0,1));
				$idhdd=current(array_slice($modelhdd,0,1));
				$idshdd=current(array_slice($modelshdd,0,1));
				$idgpu=current(array_slice($modelgpu,0,1));
				$idwnet=current(array_slice($modelwnet,0,1));
				$idodd=current(array_slice($modelodd,0,1));
				$idmdb=current(array_slice($modelmdb,0,1));
				$idchassis=current(array_slice($modelchassis,0,1));
				$idacum=current(array_slice($modelacum,0,1));
				$idwar=current(array_slice($modelwar,0,1));
				$idsist=current(array_slice($modelsist,0,1));
			}

			require_once("../etc/con_sdb.php"); $cons=dbs_connect();
			
			$sel3="SELECT * FROM notebro_temp.m_map_table WHERE model_id=".$idmodel." LIMIT 1";
			$model_ex_list=array();
			$some_result=mysqli_query($cons,$sel3);
			if(have_results($some_result))
			{
				$row=mysqli_fetch_array(mysqli_query($cons,$sel3));
				foreach($row as $key=>$el){ if($key!="model_id"&&$key!="pmodel"&&$el!=NULL&&$el!=""){ if(isset($region_ex[$key])){ $model_ex_list=array_merge($model_ex_list,$region_ex[$key]);} } }
				$model_ex_list=array_unique($model_ex_list);
				mysqli_free_result($some_result);
			}
			if(isset($rows["best_low"])){$best_low=$rows["best_low"];}
			if(!(isset($best_low["best_value"])&&$best_low["best_value"]!=""&&$best_low["best_value"]!=NULL))
			{
				require_once("lib/php/query/get_best_low.php");
				$best_low=get_best_low($cons,$ex_regions,$idmodel);
			}
			mysqli_close($cons);
		}
	}
}

function get_regions_model($con,$idmodel)
{
	$sql="SELECT `regions` FROM `notebro_db`.`MODEL` WHERE `id`=".$idmodel." LIMIT 1";
	$result=mysqli_query($con,$sql);
	if($result && mysqli_num_rows($result)>0)
	{ return explode(",",mysqli_fetch_assoc($result)["regions"]);}
	else
	{ return array(); }
}

/* MAKE CPU */
function show_cpu($list)
{
	$s_list=false; if(count($list)<2){$s_list=true;}
	
	$sel="SELECT `id`,`prod`,`model`,`gpu` FROM `notebro_db`.`CPU` WHERE `id` IN (".implode(",",$list).") ORDER BY `rating` ASC";
	if($s_list){$sel.=" LIMIT 1";}
	
	$result=mysqli_query($GLOBALS['con'], $sel);
	if($result&&mysqli_num_rows($result)>0)
	{
		if(mysqli_num_rows($result)>1)
		{
			echo '<form><SELECT name="CPU" onchange="getconf('."'".'CPU'."'".',this.value)">';
			while($row=mysqli_fetch_array($result))
			{
				if(strcasecmp($row['prod'],"INTEL")==0){$row['prod']=ucfirst(strtolower($row['prod'])); }
				
				$selected=""; if($row["id"]==$GLOBALS['idcpu']){$selected=" selected='selected'";}
				if(isset($row["id"])){ echo "<option value=".$row["id"].$selected." data-gpu='".$row["gpu"]."' >".$row["prod"]." ".$row["model"]."</option>"; } 
			}
			echo "</SELECT></form>";
		}
		else
		{
			$row=mysqli_fetch_array($result);
			if(strcasecmp($row['prod'],"INTEL")==0){$row['prod']=ucfirst(strtolower($row['prod'])); }
			echo $row["prod"]." ".$row["model"];
		}
	}
	else
	{ echo "Error. Sorry."; }
}

/* MAKE GPU */
function show_gpu($list)
{
	$s_list=false; if(count($list)<2){$s_list=true;}
	
	$sel="SELECT `id`,`prod`,`name`,`typegpu` FROM `notebro_db`.`GPU` WHERE `id` IN (".implode(",",$list).") ORDER BY `typegpu` ASC, `rating` ASC";
	if($s_list){$sel.=" LIMIT 1";}
	
	$a=false; $b=true; $havecpuint=0; $gpu_list=array(); $gpu_name=array(); $opt_nr=1; $gpulist=0; $no_select='var gpu_noselect=1;'; 
	$result=mysqli_query($GLOBALS['con'], $sel);
	if($result&&mysqli_num_rows($result)>0)
	{
		if(mysqli_num_rows($result)>1)
		{
			while($row=mysqli_fetch_array($result))
			{
				$selected=""; if($row["id"]==$GLOBALS['idcpu']){$selected=" selected='selected'"; $a=true;}
				
				$gpulist=$row["id"];
				if($row["typegpu"]>0)
				{
					$selected=""; if($row["id"]!=$GLOBALS['idcpu']){$selected=" selected='selected'";} $gpu_name[$opt_nr]=array(); $gpu_name[$opt_nr]["name"]=$row["prod"]." ".$row["name"]; $gpu_name[$opt_nr]["value"]=$row["id"];
					$gpu_list[$opt_nr]="<option value='".$gpu_name[$opt_nr]["value"]."'".$selected.">".$gpu_name[$opt_nr]["name"]."</option>"; $opt_nr++;
					if($b){ $gpulist=$row["id"]; $b=false; }
				}
				else
				{ $havecpuint=1; }
			}
		}
		else
		{ $row=mysqli_fetch_array($result); if($row["typegpu"]>0){ $gpu_name[$opt_nr]["value"]=$row["id"]; $gpu_name[$opt_nr]["name"]=$row["prod"]." ".$row["name"]; $opt_nr++; if($b){ $gpulist=$row["id"]; $b=false; } }else{ $havecpuint=1;} }
	}
	else
	{ $havecpuint=1;}

	if(($opt_nr>1 || $b==true) && $havecpuint)
	{
		$gpu_name[$opt_nr]=array();
		$gpu_name[$opt_nr]["value"]=-1;
		$gpu_list[$opt_nr]="<option value='".$gpu_name[$opt_nr]["value"]."' ";
		if(!$a)
		{ $gpu_list[$opt_nr].="selected='selected'"; }
		$gpu_list[$opt_nr].=" >CPU Integrated</option>";
		$gpu_name[$opt_nr]["name"]="CPU Integrated";
		$opt_nr++;
	}

	if($opt_nr>2){ $gpu_list[0]='<form><SELECT id="GPU" name="GPU" onchange="getconf('."'".'GPU'."'".',this.value)">'; $gpu_list[$opt_nr]="</SELECT></form>"; ksort($gpu_list); echo implode($gpu_list); }
	else
	{ echo '<span id="GPU" name="GPU" value='.$gpu_name[1]["value"].'>'.$gpu_name[1]["name"].'</span>'; if(intval($gpu_name[1]["value"])<1){ $no_select='var gpu_noselect=-1;'; }else{$no_select='var gpu_noselect=0;'; } }

	echo "<script>var gpudet=".$gpulist."; ".$no_select." </script>";
}


/* MAKE DISPLAY */
function show_display($list,$diff_id="")
{
	if(!function_exists("replace_surft_type"))
	{
		function replace_surft_type($target,$backt)
		{
			$get_map="SELECT GROUP_CONCAT(`word`) AS `words` FROM `notebro_db`.`WORD_MAPS` WHERE `type`='display_type' AND `action`='replace_phrase';";
			$get_map.="SELECT GROUP_CONCAT(`word`) AS `words` FROM `notebro_db`.`WORD_MAPS` WHERE `type`='display_surface' AND `action`='replace_phrase';";
			$result=nb_multiquery($GLOBALS['con'], $get_map);
			if(isset($result[0][0]))
			{ $backt_types=explode(",",$result[0][0]["words"]); }
			if(isset($result[1][0]))
			{ $surface_types=explode(",",$result[1][0]["words"]); }

			foreach($backt_types as $el)
			{
				if(stripos($backt,$el)!==FALSE){ foreach($surface_types as $val){ if(stripos($target,$val)!==FALSE){ $target=str_ireplace($val,$el,$target); break(2); } } }
			}
			$target=preg_replace("/([^ ]* )([0-9.]+)(.*)/", "$1$2".'"'."$3", $target);
			return $target;
		}
	}
	if(count($list)>1) 
	{
		echo '<form><SELECT id="DISPLAY'.$diff_id.'" name="DISPLAY" onchange="getconf('."'".'DISPLAY'."'".',this.value);">';
		$sel="SELECT id,model,touch,backt,lum FROM notebro_db.DISPLAY WHERE id IN (".implode(",",$list).") ORDER BY `rating` ASC";
		$result=mysqli_query($GLOBALS['con'], $sel);

		if($result&&mysqli_num_rows($result)>0)
		{
			while($row=mysqli_fetch_array($result))
			{				
				$row["model"]=replace_surft_type($row["model"],$row["backt"]);
				$touch=""; if($row["touch"]==1) { $touch=" &#128075;"; }
				$lum=0; $lum=intval($row["lum"]); if($lum>30&&$lum<10000){$lum=" - ".$lum." nits";}else{$lum="";}
	
				if($row["id"]!=$GLOBALS['iddisplay'])
				{ echo "<option value=".$row["id"].">".$prodm." ".$row["model"].$touch.$lum."</option>"; }
				else
				{ echo "<option value=".$row["id"]." selected='selected'>".$prodm." ".$row["model"].$touch.$lum."</option>"; }
			}
		}
		echo "</SELECT></form>";
	}
	else 
	{
		foreach($list as $key=>$id)
		{
			$sel="SELECT model,backt FROM notebro_db.DISPLAY WHERE id=$id ORDER BY `rating` ASC";
			$result = mysqli_query($GLOBALS['con'], $sel);
			$row = mysqli_fetch_array($result);
			$row["model"]=replace_surft_type($row["model"],$row["backt"]);
			echo $prodm." ".$row["model"];
		}
	}
}

/* MAKE HDD */
function show_hdd ($list)
{
	$s_list=false; if(count($list)<2){$s_list=true;}
	
	$sel="SELECT `id`,`model`,`cap`,`rpm` FROM notebro_db.HDD WHERE `id` IN (".implode(",",$list).") ORDER BY `readspeed` ASC,`rating` ASC";
	if($s_list){$sel.=" LIMIT 1";}
	
	$result=mysqli_query($GLOBALS['con'], $sel);
	if($result&&mysqli_num_rows($result)>0)
	{
		if(mysqli_num_rows($result)>1)
		{
			echo '<form><SELECT name="HDD" onchange="getconf('."'".'HDD'."'".',this.value)">';
			while($row=mysqli_fetch_array($result))
			{
				$rpm=""; $id=intval($row["id"]); $selected="";
				if($row["rpm"])
				{ $rpm=" ".round((floatval($row["rpm"])/1000),1)."K"; }
				
				if($id==$GLOBALS['idhdd']){$selected=" selected='selected'";}
				if(isset($id)){ echo "<option value=".$id.$selected.">".$row["model"]." - ".$row["cap"]."GB".$rpm."</option>"; }
			}
			echo "</SELECT></form>";
		}
		else
		{
			$row=mysqli_fetch_array($result);
			if($row["rpm"])
			{ $rpm=" ".round((floatval($row["rpm"])/1000),1)."K"; }
			echo $row["model"]." - ".$row["cap"]."GB".$rpm;
		}
	}
	else
	{ echo "Error. Sorry."; }
}

/* MAKE SHDD */
function show_shdd ($list,$diff_id="")
{
	$text="";	
	sort($list); $nrel=count($list); $lastrow="N/A";
	if($nrel<1){ $list=array("0"); $nrel=1; }
	
	$text='<form><SELECT name="SHDD'.$diff_id.'" onchange="getconf('."'".'SHDD'."'".',this.value)">';

	$sel="SELECT `id`,`model`,`cap`,`rpm`,`type` FROM `notebro_db`.`HDD` WHERE `id` IN (".implode(",",$list).") ORDER BY `readspeed` ASC,`rating` ASC"; 
	$result = mysqli_query($GLOBALS['con'], $sel);

	if($result&&mysqli_num_rows($result)>0)
	{
		while($row=mysqli_fetch_array($result))
		{
			$rpm=""; $id=intval($row["id"]);
			
			if(intval($row["rpm"]))
			{ $rpm=" ".round((floatval($row["rpm"])/1000),1)."K"; }
			else
			{  $rpm=" ".$row["type"]; }
			
			if($id!=0)
			{			
				if($id!=$GLOBALS['idshdd'])
				{ $text.="<option value=".$id.">".$row["cap"]."GB".$rpm."</option>"; }
				else
				{ $text.="<option value=".$id." selected='selected'>".$row["cap"]."GB".$rpm."</option>"; }
			}
			else
			{
				if($id!=$GLOBALS['idshdd'])
				{ $text.="<option value="."0".">"."None"."</option>"; }
				else
				{ $text.="<option value="."0"." selected='selected'>"."None"."</option>"; }	
			}
			$lastrow=$row["model"];
		}
	}
	$text.="</SELECT></form>";

	if($nrel==1 && !(strcmp($lastrow,"N/A")))
	{ $text=""; }
	return $text;
}

/* MAKE MDB */
function show_mdb($list)
{
	if(count($list)>1)
	{
		echo '<form><SELECT name="MDB" onchange="getconf('."'".'MDB'."'".',this.value)">';
		foreach($list as $key=>$id)
		{
			$sel="SELECT `prod`,`submodel` FROM `notebro_db`.`MDB` WHERE `id`=$id ORDER BY `rating` ASC"; 
			$result = mysqli_query($GLOBALS['con'], $sel);
			$row = mysqli_fetch_array($result);
										
			if($id!=$GLOBALS['idmdb'])
			{ echo "<option value=".$id.">".$row["submodel"]."</option>"; }
			else
			{ echo "<option value=".$id." selected='selected'>".$row["submodel"]."</option>"; }
		}
		echo "</SELECT></form>";
	}
	else 
	{
		foreach($list as $key=>$id)
		{
			$sel="SELECT prod,submodel FROM notebro_db.MDB WHERE id=$id ORDER BY `rating` ASC"; 
			$result = mysqli_query($GLOBALS['con'], $sel);
			$row = mysqli_fetch_array($result);
			echo $row["submodel"];
		}
	}
}

/* MAKE MEM */
function show_mem($list)
{
	if(count($list)>1) 
	{
		echo '<form><SELECT name="MEM" onchange="getconf('."'".'MEM'."'".',this.value)">';
		$sel="SELECT `id`,`prod`,`cap`,`type` FROM `notebro_db`.`MEM` WHERE `id` IN (".implode(",",$list).") ORDER BY `rating` ASC";
		$result=mysqli_query($GLOBALS['con'], $sel);

		if($result&&mysqli_num_rows($result)>0)
		{
			while($row=mysqli_fetch_array($result))
			{
				if($row["id"]!=$GLOBALS['idmem'])
				{ echo "<option value=".$row["id"].">".$extra." ".$row["cap"]." GB ".$row["type"]."</option>"; }
				else
				{ echo "<option value=".$row["id"]." selected='selected'>".$extra." ".$row["cap"]." GB ".$row["type"]."</option>"; }
			}
		}
		echo "</SELECT></form>";
	}
	else
	{
		$sel="SELECT prod,cap,type FROM notebro_db.MEM WHERE id=".reset($list)." ORDER BY `rating` ASC"; //echo $sel;
		$result = mysqli_query($GLOBALS['con'], $sel);
		$row = mysqli_fetch_array($result);
		echo $extra." ".$row["cap"]." GB ".$row["type"]."";
	}
}

/* MAKE ODD */
function show_odd($list,$diff_id="")
{
	$x=1;
	$nrel=count($list);
	
	if(count($list)>1) 
	{
		echo '<form><SELECT name="ODD'.$diff_id.'" onchange="getconf('."'".'ODD'."'".',this.value)">';
		foreach($list as $key=>$id)
		{
			$sel="SELECT type FROM notebro_db.ODD WHERE id=$id ORDER BY `rating` ASC"; 
			$result = mysqli_query($GLOBALS['con'], $sel);
			$row = mysqli_fetch_array($result);
			if(strcasecmp($row["type"],"NONE")==0){$row["type"]=ucfirst(strtolower($row["type"]));}
			if($id!=$GLOBALS['idodd']) 
			{ echo "<option value=".$id.">".$row["type"]."</option>"; }
			else
			{ echo "<option value=".$id." selected='selected'>".$row["type"]."</option>"; }
		}
		echo "</SELECT></form>";
	}
	else
	{
		foreach($list as $key=>$id)
		{
			$sel="SELECT type FROM notebro_db.ODD WHERE id=$id ORDER BY `rating` ASC"; 
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
function show_acum($list,$diff_id="")
{
	if(count($list)>1)
	{
		echo '<form><SELECT name="ACUM'.$diff_id.'" onchange="getconf('."'".'ACUM'."'".',this.value)">';
		
		$sel="SELECT `id`,`model`,`nrc`,`cap` FROM `notebro_db`.`ACUM` WHERE `id` IN (".implode(",",$list).") ORDER BY `rating` ASC";
		$result = mysqli_query($GLOBALS['con'], $sel);
	
		if($result&&mysqli_num_rows($result)>0)
		{
			while($row=mysqli_fetch_array($result))
			{
				if($row["id"]!=$GLOBALS['idacum'])
				{ echo "<option value=".$row["id"].">".$row["cap"]." WHr</option>"; }
				else
				{ echo "<option value=".$row["id"]." selected='selected'>".$row["cap"]." Whr</option>"; }
			}
		}
		echo "</SELECT></form>";
	}
	else
	{
		foreach($list as $key=>$id)
		{
			$sel="SELECT cap FROM notebro_db.ACUM WHERE id=$id ORDER BY `rating` ASC"; 
			$result = mysqli_query($GLOBALS['con'], $sel);
			$row = mysqli_fetch_array($result);
			echo $row["cap"]." WHr";
		}
	}
}

/* MAKE CHASSIS */
function show_chassis($list)
{
	$chassistext="";
	
	if(count($list)>1)
	{
		$chassistext.='<form><SELECT name="CHASSIS" onchange="getconf('."'".'CHASSIS'."'".',this.value)">';
		
		$sel="SELECT `id`,`submodel` FROM `notebro_db`.`CHASSIS` WHERE `id` IN (".implode(",",$list).") ORDER BY `rating` ASC"; 
		$result = mysqli_query($GLOBALS['con'], $sel);

		if($result&&mysqli_num_rows($result)>0)
		{
			while($row=mysqli_fetch_array($result))
			{	
				$id=intval($row["id"]);
				if($id!=$GLOBALS['idchassis'])
				{ $chassistext.="<option value=".$id.">".$row["submodel"]."</option>"; }
				else
				{ $chassistext.="<option value=".$id." selected='selected'>".$row["submodel"]."</option>"; }
			}
		}
		$chassistext.="</SELECT></form>";
	}
	else
	{
		foreach($list as $key=>$id)
		{
			$sel="SELECT submodel,price,err FROM notebro_db.CHASSIS WHERE id=$id ORDER BY `rating` ASC"; 
			$result = mysqli_query($GLOBALS['con'], $sel);
			$row = mysqli_fetch_array($result);
		}
	}
	
	return $chassistext;
}

/* MAKE WNET */
function show_wnet($list)
{
	if(count($list)>1)
	{
		echo '<form><SELECT name="WNET" onchange="getconf('."'".'WNET'."'".',this.value)">';
		
		$sel="SELECT `id`,`prod`,`model` FROM `notebro_db`.`WNET` WHERE `id` IN (".implode(",",$list).") ORDER BY `rating` ASC"; 
		$result = mysqli_query($GLOBALS['con'], $sel);
		
		if($result&&mysqli_num_rows($result)>0)
		{
			while($row=mysqli_fetch_array($result))
			{
				$id=intval($row["id"]);
				if($id!=$GLOBALS['idwnet'])
				{ echo "<option value=".$id.">".$row["prod"]." ".$row["model"]."</option>"; }
				else
				{ echo "<option value=".$id." selected='selected'>".$row["prod"]." ".$row["model"]."</option>"; }
			}
		}
		echo "</SELECT></form>";
	}
	else
	{
		foreach($list as $key=>$id)
		{
			$sel="SELECT prod,model,slot,price,err FROM notebro_db.WNET WHERE id=$id ORDER BY `rating` ASC"; 
			$result = mysqli_query($GLOBALS['con'], $sel);
			$row = mysqli_fetch_array($result);
			echo $row["prod"]." ".$row["model"];
		}
	}
}

/* MAKE WAR */
function show_war($list)
{
	if(count($list)>1)
	{
		echo '<form><SELECT name="WAR" onchange="getconf('."'".'WAR'."'".',this.value)">';
		foreach($list as $key=>$id)
		{
			$sel="SELECT years,prod,price,err FROM notebro_db.WAR WHERE id=$id ORDER BY `rating` ASC"; 
			$result = mysqli_query($GLOBALS['con'], $sel);
			$row = mysqli_fetch_array($result);
			
			if($id!=$GLOBALS['idwar'])
			{ echo "<option value=".$id.">".$row["years"]." - ".$row["prod"]."</option>"; }
			else
			{ echo "<option value=".$id." selected='selected'>".$row["years"]." - ".$row["prod"]."</option>"; }
		}
		echo "</SELECT></form>";
	}
	else
	{
		foreach($list as $key=>$id)
		{
			$sel="SELECT years,price,err FROM notebro_db.WAR WHERE id=$id ORDER BY `rating` ASC";
			$result = mysqli_query($GLOBALS['con'], $sel);
			$row = mysqli_fetch_array($result);
			echo $row["years"];
		}
	}
}

/* MAKE SIST */
function show_sist($list)
{
	if(count($list)>1)
	{
		echo '<form><SELECT name="SIST" onchange="getconf('."'".'SIST'."'".',this.value)">';
		foreach($list as $key=>$id)
		{
			$sel="SELECT sist,vers,type,price,err FROM notebro_db.SIST WHERE id=$id ORDER BY `rating` ASC"; 
			$result = mysqli_query($GLOBALS['con'], $sel);
			$row = mysqli_fetch_array($result);
	
			if(is_numeric($row['vers']))
			{ $row['vers']=floatval($row['vers']); }
			if($row["vers"]==0){$row["vers"]="";}else{$row['vers']=" ".strval($row['vers']);}
			if($id!=$GLOBALS['idsist'])
			{ echo "<option value=".$id.">".$row["sist"].$row["vers"]." ".$row["type"]."</option>"; }
			else
			{ echo "<option value=".$id." selected='selected'>".$row["sist"].$row["vers"]." ".$row["type"]."</option>"; }
		}
		echo "</SELECT></form>";
	}
	else
	{
		foreach($list as $key=>$id)
		{
			$sel="SELECT sist,vers,price,type,err FROM notebro_db.SIST WHERE id=$id ORDER BY `rating` ASC"; 
			$result = mysqli_query($GLOBALS['con'], $sel);
			$row = mysqli_fetch_array($result);
			if(is_numeric($row['vers']))
			{ $row['vers']=floatval($row['vers']); }
			if($row["vers"]==0){$row["vers"]="";}
			echo $row["sist"]." ".$row["vers"]." ".$row["type"];
		}
	}
}

require_once("query/show_msc.php");

/* SELECT AND SHOW VARIOUS ELEMENTS */
function show_vars($col, $tab, $id)
{
	if(stripos($tab,"JOIN")!==FALSE)
	{ $sel2="SELECT $col FROM $tab WHERE model.id = $id LIMIT 1"; }
	else
	{ $sel2="SELECT $col FROM $tab WHERE id = $id LIMIT 1"; }

	$rea=mysqli_query($GLOBALS['con'], $sel2);
	$resu=mysqli_fetch_array($rea);
	
	global $show_vars;
	$show_vars=$resu;
	$col=explode(",",$col); $nrcol=count($col);
	if($nrcol>1)
	{ return $resu; }
	else
	{ return $resu[$col[0]]; }
}
?>