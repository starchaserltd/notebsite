<?php
require_once("../etc/con_sdb.php");

$ignored_comp=array();
$sql_presearch="(SELECT COUNT(id) FROM CHASSIS WHERE valid=1) UNION (SELECT COUNT(id) FROM MDB WHERE valid=1) UNION (SELECT COUNT(id) FROM DISPLAY WHERE valid=1) UNION (SELECT COUNT(id) FROM ACUM WHERE valid=1) UNION (SELECT COUNT(id) FROM CPU WHERE valid=1) UNION (SELECT COUNT(id) FROM GPU WHERE valid=1) UNION (SELECT COUNT(id) FROM MEM WHERE valid=1) UNION (SELECT COUNT(id) FROM WNET WHERE valid=1)";
$result=mysqli_query($con,$sql_presearch); $row=mysqli_fetch_all($result);
$list_comps_to_ignore=["chassis","mdb","display","acum","cpu","gpu","mem","wnet"]; $i=0;
foreach($list_comps_to_ignore as $val)
{
	if(isset($comp_lists[$val])&&is_array($comp_lists[$val])){ if(count($comp_lists[$val])>intval(0.8*intval($row[$i][0]))){$ignored_comp[]=$val;}}
	$i++;
}

$sql_presearch="SELECT GROUP_CONCAT(`model_id`) as `ids` FROM `notebro_temp`.`presearch_tbl` WHERE "; $model_id_new=array(); $start_id_model=0; $has_or=0;

foreach($comp_lists as $key=>$val)
{
	$sql_presearch.="("; $empty_cond=0;
	if(isset($val)&&$val!=NULL&&reset($val)!==NULL)
	{
		foreach($val as $key2=>$val2)
		{
			if($key=="model")
			{
				$start_id_model=1;
				$model_id_new[]=$key2;
			}
			else
			{ 	
				$start_id_model=0;
				if(!in_array($key,$ignored_comp))
				{
					$sql_presearch.=" FIND_IN_SET(".$key2.",`".$key."`)>0 OR"; $has_or=1;
				}
				else
				{ $empty_cond=1; }
			}
		}
	}
	else
	{ $empty_cond=1;}

	if($empty_cond){$sql_presearch.="1=1";}
	
	if($has_or){$sql_presearch=substr($sql_presearch, 0, -3); $has_or=0;}
	if($start_id_model){ $sql_presearch.=" `model_id` IN (".implode(",",$model_id_new).")";}
	$sql_presearch.=") AND ";
}
//$sql_presearch=substr($sql_presearch, 0, -4);
$sql_presearch.="(`price` < " . $budgetmax . ")";
$result=mysqli_query($cons,$sql_presearch);

if($result&&mysqli_num_rows($result)>0)
{ $valid_ids=explode(",",mysqli_fetch_assoc($result)["ids"]); $valid_ids=array_flip($valid_ids); }
else
{ $comp_lists["model"]=array(); }

foreach($comp_lists["model"] as $key=>$val)
{ if(!isset($valid_ids[$key])){unset($comp_lists["model"][$key]);} }
?>