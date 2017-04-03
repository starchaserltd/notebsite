<?php
require_once("../../etc/session.php"); 

$id=strval($_POST['conf']);

	for($i=0;$i<=9;$i++)
	{
		if(isset($_SESSION['conf'.$i]["id"]))
		{
			if($_SESSION['conf'.$i]["id"]==$id)
			{
				if($_SESSION['conf'.$i]["checked"])
				{ 
					$_SESSION['conf'.$i]["checked"]=0; 
				}
				else
				{
					$_SESSION['conf'.$i]["checked"]=1;
				}
			}	
		}		
	}
?>

