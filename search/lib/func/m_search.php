<?php
if(!isset($relativepath)){ $relativepath="../../../"; $p_model_only=true; }else{$p_model_only=false;}
if(!isset($close_con)) { $close_con=1; }
require_once($relativepath."etc/session.php");
require_once($relativepath."etc/con_db.php");

//WE GET THE INPUTS
$keys = mysqli_real_escape_string($con,filter_var($_POST["keys"], FILTER_SANITIZE_STRING));

//$keys="7%20aspire";

if(strlen($keys)>2 && $keys[-3]=="%")
{ $keys=substr($keys, 0, -3); }
$keysparts=explode(" ",$keys); $conditions="";

foreach($keysparts as $el)
{
	$conditions.="REGEXP_REPLACE(CONCAT(prod,' ',IFNULL((SELECT fam FROM `notebro_db`.`FAMILIES` WHERE id=idfam),''),' ',IFNULL((SELECT subfam FROM `notebro_db`.`FAMILIES` WHERE id=idfam and showsubfam=1),''),' ',model),'[[:space:]]+', ' ') LIKE '%".$el."%' AND ";
}
$conditions=substr($conditions, 0, -5);
if(isset($id_set) && $id_set){ $conditions.="AND id IN ($id_set)"; }
if($p_model_only){ $conditions.=" AND `p_model`=`id`"; }

// CONSTRUCTING THE SEARCH QUERY
$sel="SELECT id,mdb,submodel,regions,REGEXP_REPLACE(CONCAT(prod,' ',IFNULL((SELECT fam FROM `notebro_db`.`FAMILIES` WHERE id=idfam),''),' ',IFNULL((SELECT subfam FROM `notebro_db`.`FAMILIES` WHERE id=idfam and showsubfam=1),''),' ',model),'[[:space:]]+', ' ') as name from `notebro_db`.`MODEL` WHERE ".$conditions;
$i=0;

//DOING THE SEARCH;
$result = mysqli_query($con, $sel);
$list = array();
while($rand = mysqli_fetch_row($result))
{ 
	$region="";
	//GETTING MDB SUBMODEL
	preg_match("/[^,]*/",$rand[1],$id);
	$sel="SELECT submodel FROM notebro_db.MDB WHERE id=".$id[0]." AND ( submodel NOT LIKE '%submodel%' AND submodel NOT LIKE '%tandard%') LIMIT 1";
	$result2 = mysqli_query($con, $sel);
	if($result2)
	{
		$mdb_submodel=mysqli_fetch_row($result2);
		if($mdb_submodel){ $mdb_submodel=" ".$mdb_submodel[0];}
	}
	if(strlen($rand[2])>6 && !preg_match("/\(.*\)/",$rand[2])){ if(isset($rand[2][7])){ if($rand[2][6]!=' '){  if($rand[2][5]!=' '){$rand[2]=substr($rand[2],0,6).".";}else{$rand[2]=substr($rand[2],0,5)."";}}else{$rand[2]=substr($rand[2],0,6)."";} } } 
	$regions=array(); $regions=explode(",",$rand[3]); $show_reg=1;  $region=array(); $region["disp"]="";
	foreach($regions as $el) { if(intval($el)===1 || intval($el)===0 ) { $show_reg=0; } }
	if($show_reg) { $sel_r="SELECT disp FROM notebro_db.REGIONS WHERE id=".$regions[0]." LIMIT 1"; $result_r = mysqli_query($con, $sel_r); $region=mysqli_fetch_array($result_r); $region["disp"]="(".$region["disp"].")"; }
	//SENDING THE RESULTS
	if(!isset($m_search_included)){ $rand[2]=""; $region["disp"]=""; $pre_name=strval($rand[4]." ".$rand[2].$mdb_submodel); if(substr($pre_name,-1)!=" "&&isset($region["disp"])&&$region["disp"]!=""){ $pre_name.=" "; } $list[]=["id"=>intval($rand[0]),"model"=>strval($pre_name.$region["disp"])]; }
	else { $pre_name=strval($rand[4]." ".$rand[2].$mdb_submodel); if(substr($pre_name,-1)!=" "&&isset($region["disp"])&&$region["disp"]!=""){ $pre_name.=" "; } $list[]=["id"=>intval($rand[0]),"noteb_name"=>strval($pre_name.$region["disp"]),"submodel"=>strval($rand[2]),"mdb_submodel"=>strval($mdb_submodel),"region"=>strval($region["disp"]),"name"=>strval($rand[4])]; }
}
mysqli_free_result($result);			
//SUPPLYING RESULTS				
/*if(count($list)>20)
$list[]=["id"=>"-1","model"=>"More available..."];
*/
if(!isset($m_search_included)){ print preg_replace('/,\s*"[^"]+":null|"[^"]+":null,?/', '', json_encode($list)); }
else { $m_search_included=$list; }

if($close_con){ mysqli_close($con); }
?>