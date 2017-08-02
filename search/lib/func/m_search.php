<?php
require_once("../../../etc/session.php");
require_once("../../../etc/con_db.php");

//WE GET THE INPUTS
$q = filter_input(INPUT_POST,'q',FILTER_SANITIZE_ENCODED);
$select = filter_input(INPUT_POST,'list',FILTER_SANITIZE_ENCODED);
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

//NOW WE ARE DOING A SEARCH LIKE THIS: FIRST WE SEARCH FOR PROD, TAKE OUT THE KEYS THAT MATCHED, THEN CONTINUE WITH FAMILY AND MODEL IN THE SAME WAY
$prod2=array(); $fam2=array(); $model2=array();
$keysparts=explode("%20",$keys);

$sel="SELECT DISTINCT prod FROM notebro_db.MODEL WHERE prod LIKE '".$keysparts[0]."%' LIMIT 1";
$result = mysqli_query($con, $sel);
$prod=mysqli_fetch_all($result);

if($keysparts)
{		
	foreach($prod as $x)
	{
		foreach($keysparts as $key=>$y)
		{
			if(stripos($x[0],$y)!==FALSE)
			{
				$keystounset[]=$key;
				$prod2[]=$x[0];
			}
		}
	}
	if(isset($keystounset)){ foreach($keystounset as $x) {  unset($keysparts[$x]); } }
}

	if(isset($prod2[0]) && $prod2[0])
	{ $prodsel=" AND model.prod LIKE '".implode("' model.prod LIKE '",$prod2)."'";} else { $prodsel=""; }

if($keysparts)
{
	if(!isset($keysparts[current(array_keys($keysparts))])){ $keysparts[current(array_keys($keysparts))]="";}
	if(isset($keysparts[current(array_keys($keysparts))+1]))
	{
		$sel="SELECT DISTINCT families.fam FROM notebro_db.MODEL model JOIN notebro_db.FAMILIES families  ON model.idfam=families.id WHERE families.fam LIKE '%".$keysparts[current(array_keys($keysparts))]." ".$keysparts[current(array_keys($keysparts))+1]."%'";
	}
	else
	{
		$sel="SELECT DISTINCT families.fam FROM notebro_db.MODEL model JOIN notebro_db.FAMILIES families ON model.idfam=families.id WHERE families.fam LIKE '%".$keysparts[current(array_keys($keysparts))]." %'";
	}
	
	$sel.=$prodsel;
	
	$result = mysqli_query($con, $sel);
	
	if($result!==FALSE && mysqli_num_rows($result)==0)
	{
		$sel="SELECT DISTINCT families.fam FROM notebro_db.MODEL model JOIN notebro_db.FAMILIES families ON model.idfam=families.id WHERE families.fam LIKE  '".implode("%' OR families.fam LIKE '",$keysparts)."%'";
		$sel.=$prodsel;
		$result = mysqli_query($con, $sel);
	}
	if($result!==FALSE)
	{
		$fam=mysqli_fetch_all($result);

		foreach($fam as $x)
		{
			foreach($keysparts as $key=>$y)
			{
				if(stripos($x[0],$y)!==FALSE)
				{
					$keystounset[]=$key;
					$fam2[]=$x[0];
				}
			}
		}
		if(isset($keystounset)){ foreach($keystounset as $x) {  unset($keysparts[$x]); } }
	}
}

if(isset($fam2[0]) && $fam2[0])
{ $famsel=" AND model.prod LIKE '".implode("' model.prod LIKE '",$prod2)."'";} else { $famsel=""; }

if($keysparts)
{
	if(!isset($keysparts[current(array_keys($keysparts))])){ $keysparts[current(array_keys($keysparts))]="";}
	if(isset($keysparts[current(array_keys($keysparts))+1]))
	{
		$sel="SELECT model.model FROM notebro_db.MODEL model JOIN notebro_db.FAMILIES families ON model.idfam=families.id WHERE families.fam LIKE '%".$keysparts[current(array_keys($keysparts))]." ".$keysparts[current(array_keys($keysparts))+1]."%'";
	}
	else
	{
		$sel="SELECT DISTINCT families.fam FROM notebro_db.MODEL model JOIN notebro_db.FAMILIES families ON model.idfam=families.id WHERE families.fam LIKE '%".$keysparts[current(array_keys($keysparts))]." %'";
	}
	$sel.=$prodsel;
	$result = mysqli_query($con, $sel);
	if($result!==FALSE && mysqli_num_rows($result)==0)
	{
		$sel="SELECT DISTINCT model.model FROM notebro_db.MODEL model JOIN notebro_db.FAMILIES families ON model.idfam=families.id WHERE model.model LIKE '%".implode("%' OR model.model LIKE '%",$keysparts)."%'";
		$sel.=$famsel;
		$sel.=$prodsel;
		$result = mysqli_query($con, $sel);
	}

	if($result!==FALSE)
	{
		$model=mysqli_fetch_all($result);
		foreach($model as $x)
		{
			foreach($keysparts as $key=>$y)
			{
				if(stripos($x[0],$y)!==FALSE)
				{
					$keystounset[]=$key;
					$model2[]=$x[0];
				}
			}
		}
		if(isset($keystounset)){ foreach($keystounset as $x) {  unset($keysparts[$x]); } }
	}
}
	
// CONSTRUCTING THE SEARCH QUERY
$sel="SELECT model.id, model.prod,families.fam,model.model,model.mdb,model.submodel,model.regions,families.subfam,families.showsubfam FROM notebro_db.MODEL model JOIN notebro_db.FAMILIES families ON model.idfam=families.id";
$i=0;
if(isset($prod) && $prod)
{
	if($i) { $sel.=" AND"; } else { $sel.=" WHERE"; };
	$sel=$sel." model.prod IN ('".implode("','",$prod2)."')";
	$i=1;
}
if(isset($fam) && $fam)
{
	if($i) { $sel.=" AND"; } else { $sel.=" WHERE"; };
	$sel=$sel." families.fam IN ('".implode("','",$fam2)."')";
	$i=1;
}

if(isset($model) && $model)
{
	if($i) { $sel.=" AND"; } else { $sel.=" WHERE"; };
	$sel=$sel." model.model IN ('".implode("','",$model2)."')";
	$i=1;
}
		
//DOING THE SEARCH		
$result = mysqli_query($con, $sel);
$list = array();
while($rand = mysqli_fetch_row($result)) 
{ 
	$region="";
	//GETTING MDB SUBMODEL
	preg_match("/[^,]*/",$rand[4],$id);
	$sel="SELECT submodel FROM notebro_db.MDB WHERE id=".$id[0]." AND ( submodel NOT LIKE '%submodel%' AND submodel NOT LIKE '%tandard%') LIMIT 1";
	$result2 = mysqli_query($con, $sel);
	if($result2)
	{
		$mdb_submodel=mysqli_fetch_row($result2);
		if($mdb_submodel){ $mdb_submodel=" ".$mdb_submodel[0];}
	}
	
	if(intval($rand[8])==1) { $rand[2]=$rand[2]." ".$rand[7]; }
	if(strlen($rand[5])>6 && !preg_match("/\(.*\)/",$rand[5])){ $rand[5]=substr($rand[5],0,6)."."; } 
	$regions=array(); $regions=explode(",",$rand[6]); $show_reg=1;
	foreach($regions as $el) { if(intval($el)===1 || intval($el)===0 ) { $show_reg=0; } }
	if($show_reg) { $sel_r="SELECT disp FROM notebro_db.REGIONS WHERE id=".$regions[0]." LIMIT 1"; $result_r = mysqli_query($con, $sel_r); $region=mysqli_fetch_array($result_r); $region["disp"]="(".$region["disp"].")"; }
	//SENDING THE RESULTS
	$list[]=["id"=>intval($rand[0]),"model"=>strval($rand[1]." ".$rand[2]." ".$rand[3]." ".$rand[5].$mdb_submodel.$region["disp"])];
}
mysqli_free_result($result);
				
//SUPPLYING RESULTS				
/*if(count($list)>20)
$list[]=["id"=>"-1","model"=>"More available..."];
*/
print preg_replace('/,\s*"[^"]+":null|"[^"]+":null,?/', '', json_encode($list));

mysqli_close($con);
?>