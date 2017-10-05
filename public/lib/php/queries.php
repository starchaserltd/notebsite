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
$keys=str_ireplace("%20"," ",$keys);
$list=array();
switch($select)
{
	case "review_websites":
	{
		$query="SELECT DISTINCT site FROM `notebro_db`.`REVIEWS` WHERE site LIKE '%".$keys."%' ORDER BY site ASC";
		$result=mysqli_query($con,$query);
		$i=1;
		while($rand = mysqli_fetch_row($result)) 
		{ 
			$list[]=["id"=>$i,"name"=>strval($rand[0])];
			$i++;
		}
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