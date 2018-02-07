<?php
require_once("../../etc/session.php"); 
require_once("../../etc/con_db.php");

$id=strval($_POST['conf']);
for($i=0;$i<=9;$i++)
{
	if(isset($_SESSION['conf'.$i]["id"]))
	{
		if($_SESSION['conf'.$i]["id"]==$id)
		{ unset($_SESSION['conf'.$i]); }
	}			
}

$j=-1;
for($i=0;$i<=9;$i++)
{
	if((!isset($_SESSION['conf'.$i])) || ($_SESSION['conf'.$i]["id"]=="0"))
	{
		if($j<0)
		$j=$i;
	}
	else
	{
		if($j>=0)
		{
			$_SESSION['conf'.$j]=$_SESSION['conf'.$i];
			unset($_SESSION['conf'.$i]);
			$i=$j;
			$j=-1;
		}
	}
}
?>

