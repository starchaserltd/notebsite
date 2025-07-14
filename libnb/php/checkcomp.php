<?php
require_once("../../etc/session.php"); 

$id = preg_replace('~[\x00\x0A\x0D\x1A\x22\x27\x5C]~u','\\\$0', trim(strip_tags($_POST["conf"])));

	for($i=0;$i<=9;$i++)
	{
		if(isset($_SESSION['conf'.$i]["id"]))
		{
			if($_SESSION['conf'.$i]["id"]==$id)
			{
				if($_SESSION['conf'.$i]["checked"])
				{ $_SESSION['conf'.$i]["checked"]=0; }
				else
				{ $_SESSION['conf'.$i]["checked"]=1; }
			}	
		}		
	}
?>

