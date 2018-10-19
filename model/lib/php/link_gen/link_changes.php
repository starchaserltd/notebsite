<?php
switch($row["prod"])
{
	case (stripos($row["prod"],"Razer")!==FALSE):
	{
		$return[$key]["link"]=str_ireplace("n:13896617011,","n:172282,n:541966,",$return[$key]["link"]); break;
	}
	default :
	{
		break;
	}
}
?>