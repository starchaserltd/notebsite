<?php
require_once("../etc/session.php");
require_once("../etc/con_sdb.php");
require_once("../etc/con_db.php");
//HERE WE PROCESS THE CONFIGURATIONS FROM GET AND SESSION
$getconfs=array();	$nrgetconfs=0;
if(isset($_GET['ex'])){ $_SESSION['excomp']=$_GET['ex']; }
$addtojava="<script> $(document).ready(function() { if(firstcompare) {";
$_SESSION['compare_list']=array(); $_SESSION['toalert']=array();
$cons=dbs_connect();
for($i=0;$i<10;$i++)
{
	if(isset($_GET["conf$i"]))
	{
		$getconfs[$nrgetconfs]=$_GET["conf$i"];
		$t=table($getconfs[$nrgetconfs]); $getconfs[$nrgetconfs]=$t[0]."_".$t[1];
		$sql="SELECT * FROM notebro_temp.all_conf_".$t[1]." WHERE id = ".$t[0]."";
		if($result = mysqli_query($cons,$sql))
		{
			$_SESSION['compare_list'][$getconfs[$nrgetconfs]] = mysqli_fetch_assoc($result);
			$addtojava.=" addcompare('".$getconfs[$nrgetconfs]."'); ";
			$nrgetconfs++;
		}
		else
		{ $_SESSION['toalert'][]=$getconfs[$nrgetconfs]; unset($getconfs[$nrgetconfs]); }
	}
}
$addtojava.="} });"; 
if(count($_SESSION['toalert'])>0){ $addtojava.=' alert("We are sorry, but the following laptop configurations no longer exist: \n'.implode("\\n",$_SESSION['toalert']).'");'; }
$addtojava.=" </script>";
echo $addtojava;

if($nrgetconfs==1) { $_SESSION['toalert'][]=$getconfs[0]; unset($getconfs[0]); }

/* GETTING INFORMATION FROM SESSION */
$nrconf = 0; $session_idconf = array();
if($nrgetconfs<2)
{	
	$k = 0; $nrgetconfs=0;
	while ($k<10)
	{
		// var_dump($_SESSION['conf'.$k]); echo "<br><br>";
		if (isset($_SESSION['conf'.$k]) && $_SESSION['conf'.$k]['id'])
		{
			if ($_SESSION['conf'.$k]["checked"]==1)
			{
				$session_idconf[$nrconf] = $k;
				$t=table($_SESSION['conf'.$k]['id']); $_SESSION['conf'.$k]['id']=$t[0]."_".$t[1];
				$sql="SELECT * FROM notebro_temp.all_conf_".$t[1]." WHERE id = ".$t[0]."";
				if($result = mysqli_query($cons,$sql))
				{
					$_SESSION['compare_list'][$_SESSION['conf'.$k]['id']] = mysqli_fetch_assoc($result);
					$addtojava.=" addcompare('".$_SESSION['conf'.$k]['id']."'); ";
					$nrconf++;
				}
				else
				{ $_SESSION['toalert'][]=$_SESSION['conf'.$k]['id']; unset($_SESSION['conf'.$k]['id']); }
			
				if ($nrconf >= 4) {$k = 100;}
			}
		}
		$k++;
	}
}
$nrconf--;
mysqli_close($cons); mysqli_close($con);

$_SESSION['java_nrconf']=$nrconf; $_SESSION['java_nrgetconfs']=$nrgetconfs; $_SESSION['java_getconfs']=$getconfs; $_SESSION['java_session_idconf']=$session_idconf;
//DONE PROCESSING
?>