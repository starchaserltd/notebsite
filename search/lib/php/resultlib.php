<?php

// col = what to select from table , tab = from what table , id = filter for what id

function show($col, $tab, $id)
{
	$result = mysqli_query($GLOBALS['con'], "SELECT $col FROM $tab WHERE id = '".$id."' LIMIT 1"); 
	$item = mysqli_fetch_array($result);

	if(strcasecmp($item[$col],"Standard")==0)
	{ $item[$col]=""; }

	if(!($col<=>"clocks") && substr($item[$col],-1)==='0')
	{ $item[$col]=sprintf('%0.2f',floatval($item[$col])); }
	
	return $item[$col];
}

function showhdd($col, $tab, $id, $shdd)
{
	if(intval($shdd)==0)
	{
		$result = mysqli_query($GLOBALS['con'], "SELECT $col FROM $tab WHERE id = '".$id."' LIMIT 1"); 
		$item = mysqli_fetch_array($result);
		$item['cap,type,rpm']="";

		echo $item[$col];
		echo $item['cap']." GB - "; if($item['rpm']>0) echo $item['rpm']."rpm ";
		echo ""; echo $item['type']."";
	}
	else
	{
		$result = mysqli_query($GLOBALS['con'], "SELECT $col FROM HDD WHERE id = '".$id."' LIMIT 1"); 
		$item = mysqli_fetch_array($result);
		$item['cap,type,rpm']="";
		echo $item[$col];
		mysqli_free_result($result);
		$result = mysqli_query($GLOBALS['con'], "SELECT $col FROM HDD WHERE id = '".$shdd."' LIMIT 1"); 
		$item2 = mysqli_fetch_array($result);
		$item2['cap,type,rpm']="";
		
		echo (intval($item['cap'])+intval($item2['cap']))." GB - ".$item['type']." + ".$item2['type']."";
	}
}

function showmem($col, $tab, $id)
{
	$result = mysqli_query($GLOBALS['con'], "SELECT $col FROM $tab WHERE id = '".$id."' LIMIT 1"); 
	$item = mysqli_fetch_array($result);
	
	echo $item['cap']." GB ";
	echo $item['type']."";
	//echo $item['freq']." MHz)";
}

function showsist($col, $tab, $id)
{
	$result = mysqli_query($GLOBALS['con'], "SELECT $col FROM $tab WHERE id = '".$id."' LIMIT 1"); 
	$item = mysqli_fetch_array($result);
	
	echo $item['sist']." ";
	
	if(isset($item['vers']) && $item['vers']!=0 )
	{
		$item['vers']=floatval($item['vers']);
		echo $item['vers']." ";
	}

	if($item['type'])
	{
		echo $item['type']."";
	}
}

function getdetails($id)
{
	$result = mysqli_query($GLOBALS['con'], "SELECT model.img_1,model.prod, families.fam, families.subfam, families.showsubfam, model.model,model.submodel,model.regions,model.p_model FROM `".$GLOBALS['global_notebro_db']."`.MODEL model JOIN `".$GLOBALS['global_notebro_db']."`.FAMILIES families on model.idfam=families.id WHERE model.id = '".$id."' LIMIT 1"); 
	$item = mysqli_fetch_array($result);
	
	global $img; global $prod; global $fam; global $submodel; global $model; global $t_img; global $region_m_id; global $buy_regions; global $p_model;
	$img=""; $prod=""; $fam=""; $submodel=""; $model=""; $t_img=""; $region_m_id=""; $buy_regions="";
	$img=$item['img_1'];
	$t_imgpart=explode(".",$img);
	$t_img="t_".$t_imgpart[0].".jpg";
	$prod=$item['prod'];
	if(intval($item['showsubfam'])==1){ $fam=$item['fam']." ".$item['subfam']; } else {  $fam=$item['fam']; }
	$model=$item['model']; $p_model=$item['p_model'];
	$region_m_id=intval(explode(",",$item['regions'])[0]);
	if(isset($item['submodel'])){ $submodel=$item['submodel']; if(strlen($submodel)>6 && !preg_match("/\(.*\)/",$submodel) && stripos($prod,"apple")===FALSE){ $submodel=substr($submodel,0,6)."."; } } 
}
 
function showpricebat($tab, $id, $exc)
{ 
	global $conf_price_text; $conf_price="N/A";
	$result = mysqli_query($GLOBALS['cons'], "SELECT price,err,batlife FROM ".$tab." WHERE id = '".$id."' LIMIT 1"); 
	$item = mysqli_fetch_array($result);
	echo "Estimated battery:";?><br class="sres">  <?php echo round($item['batlife']*0.96,1); echo " - "; echo round($item['batlife']*1.03,1); echo " h";
	//$conf_price_text=intval(($item['price']-($item['err']/2))*$exc)." - ".intval(($item['price']+($item['err']/2))*$exc);
	$conf_price_text=intval(($item['price'])*$exc);
	return intval($item['price']);
}
?>