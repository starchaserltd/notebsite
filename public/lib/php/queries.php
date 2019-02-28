<?php
require_once("../../../etc/session.php");
require_once("../../../etc/con_db.php");

//WE GET THE INPUTS
$keys = mysqli_real_escape_string($con,filter_input(INPUT_POST,'keys',FILTER_SANITIZE_STRING));
$select = filter_input(INPUT_POST,'list',FILTER_SANITIZE_STRING);

if(strlen($keys)>2 && $keys[-3]=="%"){ $keys=substr($keys, 0, -3); }
$keys=str_ireplace(" "," ",$keys);
$list=array();
switch($select)
{
	case "review_websites":
	{
		$query="SELECT DISTINCT site FROM `notebro_db`.`REVIEWS` WHERE site LIKE '%".$keys."%' ORDER BY site ASC";
		$result=mysqli_query($con,$query);
		$i=1;
		while($rand = mysqli_fetch_row($result)) { $list[]=["id"=>$i,"name"=>strval($rand[0])]; $i++; }
		break;
	}
	case "com_info":
	{
		$query="SELECT DISTINCT model,comment FROM `notebro_db`.`COMMENTS` WHERE type='com' AND model='".$keys."'";
		$result=mysqli_query($con,$query);
		$i=1;
		while($rand = mysqli_fetch_row($result)) { $list[]=["model"=>$rand[0],"comment"=>strval($rand[1])]; $i++; }
		break;
	}
	default:
	{
		//nothing
		break;
	}
}

print preg_replace('/,\s*"[^"]+":null|"[^"]+":null,?/', '', json_encode($list));
mysqli_close($con);
?>