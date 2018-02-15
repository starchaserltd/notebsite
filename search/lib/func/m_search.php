<?php

if(!isset($relativepath)){ $relativepath="../../../"; }
require_once($relativepath."etc/session.php");
require_once($relativepath."etc/con_db.php");

//WE GET THE INPUTS
$keys = filter_input(INPUT_POST,'keys',FILTER_SANITIZE_ENCODED);

//$keys="7%20aspire";
//HERE I TAKE PROP AND CLEAN IT
foreach ( array_slice($_POST,2) as $param_name => $param_val) 
{
   switch( gettype($param_val))
   {
		case "string":
			${$param_name} = filter_var($param_val, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			break;
		case "array":
			${$param_name} = filter_var_array($param_val, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			break;
		case "integer":
			${$param_name} = filter_var($param_val, FILTER_SANITIZE_NUMBER_INT);
			break;
		case "float":
			${$param_name} = filter_var($param_val, FILTER_SANITIZE_NUMBER_FLOAT);
			break;
	   default:
			${$param_name} ="Something went wrong!"; 
	}
}

if(strlen($keys)>2 && $keys[-3]=="%")
{ $keys=substr($keys, 0, -3); }
$keysparts=explode("%20",$keys); $conditions="";

foreach($keysparts as $el)
{
	$conditions.="REGEXP_REPLACE(CONCAT(prod,' ',IFNULL((SELECT fam FROM `notebro_db`.`FAMILIES` WHERE id=idfam),''),' ',IFNULL((SELECT subfam FROM `notebro_db`.`FAMILIES` WHERE id=idfam and showsubfam=1),''),' ',model),'[[:space:]]+', ' ') LIKE '%".$el."%' AND ";
}
$conditions=substr($conditions, 0, -5);

// CONSTRUCTING THE SEARCH QUERY
$sel="SELECT id,mdb,submodel,regions,REGEXP_REPLACE(CONCAT(prod,' ',IFNULL((SELECT fam FROM `notebro_db`.`FAMILIES` WHERE id=idfam),''),' ',IFNULL((SELECT subfam FROM `notebro_db`.`FAMILIES` WHERE id=idfam and showsubfam=1),''),' ',model),'[[:space:]]+', ' ') as name from `notebro_db`.`MODEL` WHERE ".$conditions;
$i=0;

//DOING THE SEARCH		
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
	
	if(strlen($rand[2])>6 && !preg_match("/\(.*\)/",$rand[2])){ $rand[2]=substr($rand[2],0,6)."."; } 
	$regions=array(); $regions=explode(",",$rand[3]); $show_reg=1;  $region=array(); $region["disp"]="";
	foreach($regions as $el) { if(intval($el)===1 || intval($el)===0 ) { $show_reg=0; } }
	if($show_reg) { $sel_r="SELECT disp FROM notebro_db.REGIONS WHERE id=".$regions[0]." LIMIT 1"; $result_r = mysqli_query($con, $sel_r); $region=mysqli_fetch_array($result_r); $region["disp"]="(".$region["disp"].")"; }
	//SENDING THE RESULTS
	$list[]=["id"=>intval($rand[0]),"model"=>strval($rand[4]." ".$rand[2].$mdb_submodel.$region["disp"])];
}
mysqli_free_result($result);			
//SUPPLYING RESULTS				
/*if(count($list)>20)
$list[]=["id"=>"-1","model"=>"More available..."];
*/
if(!isset($m_search_included)){ print preg_replace('/,\s*"[^"]+":null|"[^"]+":null,?/', '', json_encode($list)); }
else { $m_search_included=$list; }

mysqli_close($con);
?>