<?php
require_once("../etc/session.php");
//HERE WE PROCESS THE CONFIGURATIONS FROM GET AND SESSION
$getconfs=array();	$nrgetconfs=0;
if(isset($_GET['ex'])){ $_SESSION['excomp']=$_GET['ex']; }
$addtojava="<script> $(document).ready(function() { if(firstcompare) {";
for($i=0;$i<10;$i++)
{
	if(isset($_GET["conf$i"]))
	{
		$getconfs[$i]=$_GET["conf$i"];
		$addtojava.=" addcompare('".$getconfs[$i]."'); ";
		$nrgetconfs++;
	}
}
$addtojava.="} }); </script>";
echo $addtojava;

/* GETTING INFORMATION FROM SESSION */
$idconf = array(); $k = 0; $nrconf = 0;
while ($k<10)
{
	// var_dump($_SESSION['conf'.$k]); echo "<br><br>";
	if (isset($_SESSION['conf'.$k]) && $_SESSION['conf'.$k]['id'])
	{
		if ($_SESSION['conf'.$k]["checked"]==1)
		{
			$idconf[$nrconf] = $k;
			$nrconf++;
			if ($nrconf >= 4) {$k = 100;}
		}
	}
	$k++;
}
$nrconf--;
$_SESSION['java_nrconf']=$nrconf; $_SESSION['java_nrgetconfs']=$nrgetconfs; $_SESSION['java_getconfs']=$getconfs; $_SESSION['java_idconf']=$idconf;
//DONE PROCESSING
?>