<?php
if(!isset($relativepath)){ $relativepath="../../../"; $p_model_only=true; }else{$p_model_only=false;}
if(!isset($close_con)) { $close_con=1; }
require_once($relativepath."etc/session.php");
require_once($relativepath."etc/con_db.php");

//WE GET THE INPUTS
$keys = mysqli_real_escape_string($con,filter_var($_POST["keys"], FILTER_SANITIZE_STRING));
if(isset($_POST["ex"])){$excode=mysqli_real_escape_string($con,filter_var($_POST["ex"], FILTER_SANITIZE_STRING));}else{$excode=false;}
$show_submodel=false; $reg_sql=""; $current_regions_array=array();
//$keys="7%20aspire";

if(strlen($keys)>2 && $keys[-3]=="%")
{ $keys=substr($keys, 0, -3); }

$doing_id_search=false;
if(stripos($keys,"id:")===FALSE)
{ $keysparts=explode(" ",$keys); }
else
{ $keysparts=explode(":",$keys); $id_set=intval($keysparts[1]); unset($keysparts); }

$conditions_model=""; $conditions_altmodel=""; $conditions="";

if($excode)
{
	$ex_result=mysqli_query($con,"SELECT `notebro_site`.`exchrate`.`regions` FROM `notebro_site`.`exchrate` WHERE `notebro_site`.`exchrate`.`code`='".$excode."' LIMIT 1");
	if($ex_result && mysqli_num_rows($ex_result)>0)
	{ $regions=mysqli_fetch_assoc($ex_result)["regions"]; $current_regions_array=explode(",",$regions); $reg_sql=" AND ("; foreach($current_regions_array as $val){ $reg_sql.="FIND_IN_SET(".$val.",`regions`)>0 OR "; } $reg_sql=substr($reg_sql,0,-4).")"; }
}

if(isset($keysparts))
{
	foreach($keysparts as $el)
	{
		$conditions_model.="`notebro_db`.GEN_NAME(`MODEL`.`id`) LIKE '%".$el."%' AND ";
		$conditions_altmodel.="`alt_model`.`name` LIKE '%".$el."%' AND ";
	}
}

$conditions_model=substr($conditions_model, 0, -5); $conditions_altmodel=substr($conditions_altmodel, 0, -5);

if(isset($id_set) && $id_set){ $and=""; if(isset($conditions_model[1])){ $and=" AND";} $conditions_model.=$and." `MODEL`.`id` IN ($id_set)"; }
elseif(isset($m_search_included)&&isset($from_date)){ $conditions_model.=" AND `MODEL`.`ldate` >= '".$from_date."'"; $conditions_altmodel.=" AND `model`.`ldate` >= '".$from_date."'"; }

if($p_model_only){ $conditions_model.=" GROUP BY `p_model`,`show_smodel`"; $conditions_altmodel.=" GROUP BY `model`.`p_model`"; }

// CONSTRUCTING THE SEARCH QUERY
$sel="SELECT `MODEL`.`id`,`MODEL`.`mdb`,`MODEL`.`submodel`,`MODEL`.`p_model` as `c_p_model`,(SELECT GROUP_CONCAT(`MODEL`.`regions`) FROM `MODEL` WHERE `MODEL`.`p_model`=`c_p_model`) as `regions`,GEN_NAME(`MODEL`.`id`) as `name`,'1' as `pmodel_count`,`MODEL`.`extra_modelname` as `extra_modelname` FROM `notebro_db`.`MODEL` WHERE ".$conditions_model;
if(!(isset($id_set) && $id_set))
{
	$sel.=" UNION ";
	$sel.="SELECT `model`.`id`,`model`.`mdb`,`model`.`submodel`,`model`.`p_model` as `c_p_model`,`model`.`regions` as `regions`,`alt_model`.`name` as `name`,'0' as `pmodel_count`,`model`.`extra_modelname` as `extra_modelname` FROM `notebro_db`.`MODEL` `model`  JOIN `notebro_db`.`ALT` `alt_model` ON (`model`.id=`alt_model`.`model_id`) WHERE ".$conditions_altmodel." ORDER BY `name` ASC";
}

//DOING THE SEARCH;
$p_model_count=0; $p_model=0;
$result=mysqli_query($con, $sel);

//IF NO RESULTS FOUND, MAYBE WE ARE SEARCHING FOR A SUBMODEL
if((!$result)||($result&&mysqli_num_rows($result)<=0))
{
	if((strlen($keys)>4)&&!(isset($id_set)))
	{
		$conditions_model=""; $show_submodel=true;
		foreach($keysparts as $el)
		{ $conditions_model.="`notebro_db`.GEN_NAME_WSUBMODEL(`MODEL`.`id`) LIKE '%".$el."%' AND "; } $conditions_model=substr($conditions_model, 0, -5);
		if(isset($m_search_included)&&isset($from_date)){ $conditions_model.=" AND `MODEL`.`ldate` >= '".$from_date."'"; }
		$sel="SELECT `MODEL`.`id`,`MODEL`.`mdb`,`MODEL`.`submodel`,`MODEL`.`p_model` as `c_p_model`,`MODEL`.`regions`,GEN_NAME_WSUBMODEL(`MODEL`.`id`) as `name`,'nop' as `np`,`MODEL`.`extra_modelname` as `extra_modelname` FROM `notebro_db`.`MODEL` WHERE ".$conditions_model."".$reg_sql." ORDER BY `name` ASC";
		$result=mysqli_query($con,$sel);
		if(!($result&&mysqli_num_rows($result)>0)&&$reg_sql!="")
		{
			$sel="SELECT `MODEL`.`id`,`MODEL`.`mdb`,`MODEL`.`submodel`,`MODEL`.`p_model` as `c_p_model`,`MODEL`.`regions`,GEN_NAME_WSUBMODEL(`MODEL`.`id`) as `name`,'nop' as `np`,`MODEL`.`extra_modelname` as `extra_modelname` FROM `notebro_db`.`MODEL` WHERE ".$conditions_model." ORDER BY `name` ASC";
			$result=mysqli_query($con,$sel);
		}
	}
}

unset($p_model); $list=array();
if($result&&mysqli_num_rows($result)>0)
{
	while($rand=mysqli_fetch_array($result))
	{
		$region=""; $mdb_submodel=""; $extra_name="";
		if(strlen($rand["submodel"])>6 && !preg_match("/\(.*\)/",$rand["submodel"])){ if(isset($rand["submodel"][7])){ if($rand["submodel"][6]!=' '){  if($rand["submodel"][5]!=' '){$rand["submodel"]=substr($rand["submodel"],0,6).".";}else{$rand["submodel"]=substr($rand["submodel"],0,5)."";}}else{$rand["submodel"]=substr($rand["submodel"],0,6)."";} } }
		$regions=array(); $regions=array_unique(explode(",",$rand["regions"])); $show_reg=1;  $region=array(); $region["disp"]=""; if(isset($rand["np"])&&$rand["np"]=="nop"){$add_np="_np";}else{$add_np="";}
		foreach($regions as $el) { if(intval($el)===1 || intval($el)===0 ){ $show_reg=0; } else { foreach($current_regions_array as $el2) {if(intval($el)==intval($el2)){$show_reg=0;} } } }
		if($show_reg) { $sel_r="SELECT disp FROM notebro_db.REGIONS WHERE id=".$regions[0]." LIMIT 1"; $result_r = mysqli_query($con, $sel_r); $region=mysqli_fetch_array($result_r); $region["disp"]="(".$region["disp"].")"; }
		if(isset($rand["extra_modelname"])&&$rand["extra_modelname"]!==NULL){ $extra_name=" (".strval($rand["extra_modelname"]).")"; }
		//SENDING THE RESULTS
		if(!isset($m_search_included)){ $rand["submodel"]=""; $pre_name=strval($rand["name"]." ".$rand["submodel"].$mdb_submodel); if(substr($pre_name,-1)!=" "&&isset($region["disp"])&&$region["disp"]!=""){ $pre_name.=" "; } $list[]=["id"=>intval($rand["id"]).$add_np,"model"=>strval($pre_name.$extra_name.$region["disp"])]; }
		else { $pre_name=strval($rand["name"]." ".$rand["submodel"].$mdb_submodel); if(substr($pre_name,-1)!=" "&&isset($region["disp"])&&$region["disp"]!=""){ $pre_name.=" "; } $list[]=["id"=>intval($rand[0]),"noteb_name"=>strval($pre_name.$region["disp"]),"submodel"=>strval($rand["submodel"]),"mdb_submodel"=>strval($mdb_submodel),"region"=>strval($region["disp"]),"name"=>strval($rand["name"]),"extra_name"=>$extra_name]; }
	}
	mysqli_free_result($result);
}
else
{ $list=array(["id"=>"-1","model"=>"No results found"]); }
//SUPPLYING RESULTS				
/*if(count($list)>20)
$list[]=["id"=>"-1","model"=>"More available..."];
*/
if(!isset($m_search_included)){ print preg_replace('/,\s*"[^"]+":null|"[^"]+":null,?/', '', json_encode($list)); }
else { $m_search_included=$list; }

if($close_con){ mysqli_close($con); }
?>