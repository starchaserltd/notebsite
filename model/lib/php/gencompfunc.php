<?php
function normal_rating($x){ $x*=10; return(((1.25/1000000*pow($x,2))+1.305*$x+(-4.3/100000000000*pow($x,3)))/10); }
function show($tab, $id)
{
	if(stripos($tab,"JOIN")!==FALSE)
	{ $sel2 = "SELECT * FROM $tab WHERE model.id=$id LIMIT 1"; }
	else
	{ $sel2 = "SELECT * FROM $tab WHERE id=$id LIMIT 1"; }

	$rea = mysqli_query($GLOBALS['con'], $sel2); 
	global $resu; global $buy_regions_model;
	$resu = mysqli_fetch_array($rea);

	if(isset($resu['rating'])){ $resu['rating']=round(floatval($resu['rating']),1)." / 100";}
	
	switch($tab)
	{
		case 'CPU':
		{
			if(strcmp($resu['prod'],"INTEL")==0){$resu['prod']=ucfirst(strtolower($resu['prod']));}
			$resu['ldate'] = date('F Y', strtotime($resu['ldate']));
			$resu['tdp']=floatval($resu['tdp']);
			$resu['price']=floatval($resu['price']);
			
			switch (true)
			{
				case ((in_array($resu['tdp'],range(0,15))) && ($resu['price'])>=200): {	$resu['class']="Ultrabook"; break; }
				case ((in_array($resu['tdp'],range(0,10))) && ($resu['price'])<200):  { $resu['class']="Netbook/Tablet"; break; }
				case ((in_array($resu['tdp'],range(10,30))) && ($resu['price'])<200): { $resu['class']="Value"; break; }
				case ((in_array($resu['tdp'],range(30,40))) && ($resu['price'])<200): { $resu['class']="Value"; break; }
				case ((in_array($resu['tdp'],range(40,60))) && ($resu['price'])<200): { $resu['class']="Value"; break; }
				case ((in_array($resu['tdp'],range(15,30))) && ($resu['price'])>=200):{	$resu['class']="Mainstream"; break; }
				case ((in_array($resu['tdp'],range(30,40))) && ($resu['price'])>=200):{ $resu['class']="Mainstream"; break; }
				case ((in_array($resu['tdp'],range(40,60))) && ($resu['price'])>=200):{ $resu['class']="High performance"; break; }
				case (in_array($resu['tdp'],range(60,150))):						  { $resu['class']="Desktop"; break; }
				default: 															  { $resu['class']="Undefined"; break; }
			}
			break;
		}
	
		case 'GPU':
		{
			$resu['power']=floatval($resu['power']);
			if(strcmp($resu['prod'],"INTEL")==0){$resu['prod']=ucfirst(strtolower($resu['prod']));}
			if(!$resu['msc']){$resu['msc']="-";}
			if(!$resu['typegpu'])
			{
				$resu['power']="-";
				$resu['cspeed']=$resu['cspeed']." to ".$resu['bspeed'];
			}
			else
			{
				$resu['cspeed']=$resu['cspeed']." to ".$resu['bspeed'];
			}
		
			if($resu['sharem']== 1) {$resu['sharem'] = "NO";}
			else {$resu['sharem'] = "YES";}
	
			switch (true)
			{
				case ($resu['power']<10): 						 {	$class="Basic/Integrated"; break; }
				case ($resu['power']>=10 && $resu['power']<=25): { $class="Basic/Multimedia"; break; }
				case ($resu['power']>25 && $resu['power']<45):   { $class="Budget/Casual gaming"; break; }
				case ($resu['power']>=45 && $resu['power']<70):  { $class="Low mid-range"; break; }
				case ($resu['power']>=70 && $resu['power']<90):  { $class="Mid-range"; break; }
				case ($resu['power']>=90 && $resu['power']<500): {	$class="High-end"; break; }
				default: 										 { $resu['class']="Undefined"; break; }
			}
			$resu['gpuclass']=$class;
			break;
		}
	
		case 'MDB':
		{
			if(!($resu['ram']) || $resu['ram']=="0" ){$resu['ram']="Soldered";}
			if(!($resu['interface'])){$resu['interface']="-";}
			if(!($resu['hdd'])){$resu['hdd']="-";}
			if(strcasecmp($resu['netw'],"NONE")==0){$resu['netw']="No";}
			$resu['interface']=str_replace(",", ", ",$resu['interface']);
			$resu['hdd']=str_replace(",", ", ",$resu['hdd']);
			break;
		}
	
		case 'MEM':
		{
			$resu['type']=$resu['type']." - ".$resu['freq'];
			break;
		}

		case 'ACUM':
		{
			if($resu['weight'] && (floatval($resu['weight'])!=0))
			{ $resu['weight']=round($resu['weight'],2)." kg (".round($resu['weight']*2.20462,2)." lb)"; }
			else
			{$resu['weight']="-";}
			if(!$resu['msc']){$resu['msc']="-";}
			break;
		}
	
		case 'CHASSIS':
		{
			$resu['weight']=number_format(floatval($resu['weight']),2,".","")." Kg (".number_format((floatval($resu['weight'])*2.20462),2,".","")." lb)";
			$resu['thic']=round($resu['thic']/10,2)." cm (".round($resu['thic']*0.0393701,2).'")';
			$resu['depth']=round($resu['depth']/10,2)." cm (".round($resu['depth']*0.0393701,2).'")';
			$resu['width']=round($resu['width']/10,2)." cm (".round($resu['width']*0.0393701,2).'")';
			$resu['web']=floatval($resu['web']);
		
			if($resu['touch']=="" || !($resu['touch']))
			{ $resu['touch']="Standard"; }
		
			if($resu['keyboard']=="" || !($resu['keyboard']))
			{ $resu['keyboard']="Standard"; }
	
			$resu['pi']=str_replace(",", ", ",$resu['pi']);
			$resu['vi']=str_replace(",", ", ",$resu['vi']);	
			$resu['made']=str_replace(",", ", ",$resu['made']);
			$resu['color']=str_replace(",", ", ",$resu['color']);
			$resu['keyboard']=str_replace(",", ", ",$resu['keyboard']);
			if(!$resu['vi']) { if(stripos($resu['pi'],"thunderbolt")!==FALSE) { $resu['vi']="1 X mDP (Thunderbolt)"; } else { $resu['vi']="-"; } }else { if(stripos($resu['pi'],"thunderbolt")!==FALSE&&stripos($resu['vi'],"DP")===FALSE) { $resu['vi'].=", 1 X mDP (Thunderbolt)"; } }		
			if(!($resu['pi'])){$resu['pi']="-";}
			if(!($resu['color'])){$resu['color']="-";}	
			if(!($resu['web'])){$resu['web']="-";}
			if(!($resu['msc'])){$resu['msc']="-";}
			break;
		}

		case 'SIST':
		{
			if(is_numeric($resu['vers']))
			{
				if(floatval($resu['vers'])!=0)
				{ $resu['vers']=floatval($resu['vers']); }
				else
				{ $resu['vers']=""; }
			}
			break;
		}

		case 'HDD':
		{
			if(!isset($resu['cap']) && !$resu['cap'])
			{ $resu['cap']="-"; }
		
			if($resu['rpm']=="0" || $resu["rpm"]=="")
			{ $resu['rpm']="-"; }
			break;
		}

		case 'SHDD':
		{
			if($resu['rpm']=="0" || $resu["rpm"]=="")
			{	$resu['rpm']="-"; }
			break;
		}
	
		case 'DISPLAY':
		{
			if ($resu['touch'] == 1) {$resu['touch'] = "YES";}
			else {$resu['touch'] = "NO";}
			if(intval($resu['sRGB'])>0){ $resu['msc'].=", ".$resu['sRGB']."% sRGB"; }
			if(intval($resu['lum'])>0){ $resu['msc'].=", ".$resu['lum']." nits"; }
			break;
		}
	
		case 'MDB':
		{
			if ($resu['gpu'] == 1) {$resu['gpu'] = "On Board";}
			if(!$resu['interface']) { $resu['interface']="-"; }
			if(!$resu['hdd']) { $resu['hdd']="-"; }
			if(!$resu['msc']) { $resu['msc']="-"; }
			if(!$resu['ram'] || $resu['ram']=="0") { $resu['ram']="Soldered"; }
			else if ($resu['gpu'] == 2) {$resu['gpu'] = "Replaceable";}
				else {$resu['gpu'] = "MXM replaceable";}
			break;
		}
		
		case 'WNET':
		{
			if(!$resu['msc']){$resu['msc']="-";}
			$resu['model']=$resu['prod']." ".$resu['model'];
			break;
		}
		
		case 'WAR':
		{
			if(!$resu['msc']){$resu['msc']="-";}
			break;
		}
	
		case 'ODD':
		{
			if(!($resu['msc'])){$resu['msc']="-";}
			if(strcasecmp($resu['type'],"NONE")==0){$resu['type']="-";}
			if ($resu['speed']=="0") {$resu['speed'] = "-";}else {$resu['speed'].="x";}
			break;
		}
	
		case stripos($tab,'MODEL')!==FALSE:
		{	if(intval($resu["showsubfam"])==1) { $resu["fam"]=$resu["fam"]." ".$resu["subfam"]; }
			$mregion_id=explode(",",$resu['regions']); if(array_search("1",$mregion_id)===FALSE){ $sel2 = "SELECT disp FROM REGIONS WHERE id = ".intval($mregion_id[0]); $rea = mysqli_query($GLOBALS['con'], $sel2); $resu1 = mysqli_fetch_array($rea); $resu["region"]="(".$resu1["disp"].")"; $buy_regions_model=$resu['regions'];  } else { $resu["region"]=""; $buy_regions_model=0; }
			$id_mdb=$GLOBALS["mdb_conf_mdb"];
			$sel2 = "SELECT submodel FROM MDB WHERE id=".$id_mdb.""; 
			$rea = mysqli_query($GLOBALS['con'], $sel2); 
			$resu1 = mysqli_fetch_array($rea);
			if(!isset($resu['mdbname'])){$resu['mdbname']="";}
			if(strcasecmp($resu1['submodel'],"Standard")!=0)
			{ $resu['mdbname']=" ".$resu1['submodel']; }
			$sel2 = "SELECT submodel FROM MDB WHERE id=".$id_mdb.""; 
			$rea = mysqli_query($GLOBALS['con'], $sel2);
			$m_msc=show_msc($id);
			if(!isset($m_msc["p_model"]["com"])){ $m_msc["p_model"]["com"]=""; }
			$resu['msc']=preg_replace("/\s+/"," ",str_replace(",", ", ",$m_msc["model_msc"]." ".$m_msc["p_model"]["com"]));
			break;
		}

		default:
		{ break; }
	}
}

function bluered($value,$maxmin,$x,$field,$rev)
{
	if(!isset($maxmin->$field[2])){ $maxmin->$field[0]=array(); $maxmin->$field[2]=$value; }
	if(!isset($maxmin->$field[3])){ $maxmin->$field[1]=array(); $maxmin->$field[3]=$value; }
	
		if((($value>=$maxmin->$field[2]) && (!$rev))||(($value<=$maxmin->$field[2])&& ($rev)))
		{ 
			if($value==$maxmin->$field[2])
			{ $maxmin->$field[0][]=$x; }
			else
			{ unset($maxmin->$field[0]); $maxmin->$field[0][]=$x; $maxmin->$field[2]=$value; }
		}

		if((($value<=$maxmin->$field[3])&& (!$rev)) || (($value>=$maxmin->$field[3])&& ($rev)))
		{ 
			if($value==$maxmin->$field[3])
			{ $maxmin->$field[1][]=$x; }
			else
			{ unset($maxmin->$field[1]); $maxmin->$field[1][]=$x; $maxmin->$field[3]=$value; }
		}

	return $maxmin;
}

require_once("query/show_msc.php");
?>