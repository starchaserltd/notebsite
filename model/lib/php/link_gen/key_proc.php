<?php
function standard_key_proc($keys,$idmodel,$submodel)
{
	global $gpu_name;
	if(stripos($submodel,"i3")!==FALSE) { $keys.="+i3"; }
	if(stripos($submodel,"i5")!==FALSE) { $keys.="+i5"; }
	if(stripos($submodel,"i7")!==FALSE) { $keys.="+i7"; }
	if(stripos($submodel,"Xeon")!==FALSE) { $keys.="+Xeon"; }
	if(stripos($submodel,"DDR3")!==FALSE) { $keys.="+DDR3"; }
	if(stripos($submodel,"DDR4")!==FALSE) { $keys.="+DDR4"; }
	if(stripos($submodel,"Android")!==FALSE) { $keys.="+Android"; }
	if(stripos($submodel,"chrome")!==FALSE) { $keys.="+chrome"; }
	if(stripos($submodel,"windows")!==FALSE) { $keys.="+windows"; }
	
	if(stripos($submodel,"dGPU")!==FALSE)
	{ 
		$sql="SELECT `notebro_db`.`GPU`.`model` FROM `notebro_db`.`GPU` WHERE FIND_IN_SET(`notebro_db`.`GPU`.`id`,(SELECT `notebro_db`.`MODEL`.`gpu` FROM `notebro_db`.`MODEL` WHERE `notebro_db`.`MODEL`.`id`=".$idmodel." LIMIT 1))>0 AND `notebro_db`.`GPU`.`typegpu`>0 LIMIT 1"; 
		$result=mysqli_query($GLOBALS['con'],$sql);
		if($result && mysqli_num_rows($result)>0){ $gpu_name=mysqli_fetch_array($result)[0]; } else { $gpu_name=NULL; }
		if(stripos($gpu_name,"radeon")!==FALSE) { $gpu_name=str_ireplace("radeon","",$gpu_name); }
		if(stripos($gpu_name,"firepro")!==FALSE) { $gpu_name=str_ireplace("firepro","",$gpu_name); }
		if(stripos($gpu_name,"geforce")!==FALSE) { $gpu_name=str_ireplace("geforce","",$gpu_name); }
		if(stripos($gpu_name,"quadro")!==FALSE) { $gpu_name=str_ireplace("quadro","",$gpu_name); }
		if(stripos($gpu_name,"pro ")!==FALSE) { $gpu_name=str_ireplace("pro ","",$gpu_name); }
		if(stripos($gpu_name,"Vega M ")!==FALSE) { $gpu_name=NULL;  }
		if(stripos($gpu_name,"max-q")!==FALSE) { $gpu_name=str_ireplace("max-q","",$gpu_name); }
		if($gpu_name){ $keys.="+".trim($gpu_name); }
	}	else {$gpu_name=NULL;}
	
	if(stripos($submodel,"Celeron")!==FALSE) { $keys.="+Celeron"; }
	if(stripos($submodel,"AMD")!==FALSE&&stripos($submodel,"GPU")===FALSE) { $keys.="+AMD"; }
	$matches=array(); if(preg_match("/[0-99]th/",$submodel,$matches)){  $keys.="+".$matches[0]; }
	if(stripos($submodel,"QHD")!==FALSE) {  $keys.="+QHD"; }
	elseif(stripos($submodel,"UHD")!==FALSE) {  $keys.="+UHD"; }
	elseif(stripos($submodel,"2K")!==FALSE) {  $keys.="+2K"; }
	elseif(stripos($submodel,"3K")!==FALSE) {  $keys.="+3K"; }
	elseif(stripos($submodel,"4K")!==FALSE) {  $keys.="+4K"; }
	else
	{
		/*$sql="SELECT DISTINCT `notebro_db`.`DISPLAY`.`vres` FROM `notebro_db`.`DISPLAY` WHERE FIND_IN_SET(`notebro_db`.`DISPLAY`.`id`,(SELECT `notebro_db`.`MODEL`.`display` FROM `notebro_db`.`MODEL` WHERE `notebro_db`.`MODEL`.`id`=760 LIMIT 1))>0 ORDER BY vres ASC LIMIT 1"; 
		$result=mysqli_query($GLOBALS['con'],$sql);
		if($result && mysqli_num_rows($result)>0){ $vres=mysqli_fetch_array($result)[0]; } else { $vres=NULL; }
		if($vres!==""){ }*/
	}
	$keys=str_ireplace(" ","+",trim($keys));
	$keys=str_ireplace("++","+",$keys); $keys=str_ireplace("++","+",$keys);
	return $keys;
}

function longest_string($model){ $l=0; foreach(explode(" ",$model) as $el){ if(strlen($el)>$l){$to_model=$el; $l=strlen($el);} } return $to_model; }
function remove_short_string($model){ $l=999; $i=0; foreach(explode(" ",$model) as $el){ if(strlen($el)<$l){$to_delete=$el; $l=strlen($el);} $i++; } if($i>1){ $model=preg_replace("/^\s*".$to_delete."/i","",$model); } return $model; }

function valid_keys($keys,$prod,$fam,$cond)
{
	$remove_keys=$GLOBALS['remove_keywords'];
	foreach($remove_keys as $el){  if(stripos($keys,$el)!==NULL){ $keys=str_ireplace($el,"",$keys); } } $keys=preg_replace("/\+\++/"," ",$keys);
	$keys=str_ireplace("+"," ",$keys); if($GLOBALS['gpu_name']!==NULL){ $keys=str_ireplace($GLOBALS['gpu_name'],"",$keys); } if(stripos($keys,"windows")!==NULL){ $keys=str_ireplace(" windows","",$keys); } if(stripos($keys,"chrome")!==NULL){ $keys=str_ireplace(" chrome","",$keys); }
	$matches=array(); if(($prod=="Microsoft")&&preg_match("/(^|\s)[a-zA-Z]* \d{1}($|\s)/",$keys,$matches)){ $extra_key=trim($matches[0]);}else{$extra_key=NULL;}
	$keys=explode(" ",$keys); if($extra_key){ array_push($keys,$extra_key); } array_push($keys,"!refurbished"); array_push($keys,"!used"); array_push($keys,"!service"); array_push($keys,"!discontinued");
	if($fam==""||$fam==" ")
	{ $sql2="SELECT DISTINCT fam from `notebro_db`.`FAMILIES` WHERE prod='".$prod."' AND fam !=' ' AND fam!='' AND fam IS NOT null".$cond; $result2=mysqli_query($GLOBALS['con'],$sql2); while($row2=mysqli_fetch_array($result2)){ array_push($keys,("!".$row2[0])); } } $keys=json_encode($keys);
	return $keys;
}

function strip_garbage($string)
{
	$to_delete=["v1","T-bolt","switch","flip","zephyrus","strix","scar","(",")"," gen","non-touch","education","gaming","2-in-1","special edition","edition","rugged","extreme","FHD","Tobii-805"];
	foreach($to_delete as $el) { if(stripos($string,$el)!==FALSE){ $string=trim(str_ireplace($el,"",$string)); } }
	return $string;
}
?>