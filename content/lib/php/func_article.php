<?php 
function gettoolid($tname)
{
	$lenghtname=strlen($tname);
	if($lenghtname<20)
	{
		if(is_numeric($tname))
		{
			$tooltipid=$tname;
		}
		else
		{
			$sql = "SELECT id FROM `".$GLOBALS['global_notebro_site']."`.`tooltip` WHERE name='".$tname."'";
			$result = mysqli_query($GLOBALS['con'], $sql);
			$row=mysqli_fetch_array($result, MYSQLI_NUM);
			$tooltipid=$row[0];
		}
	}
	return $tooltipid;
}

function maketooltip($tooltipid,$text)
{ return '<span class="toolinfo" data-toolid="'.$tooltipid.'" data-load="1" data-html="true" data-toggle="tooltip" data-delay=\'{"show": 600, "hide": 800}\' data-placement="top" data-original-title="Loading...">'.$text.' <i class="fa fa-question toolinfo-icon"></i></span>'; }

include("../libnb/php/urlproc.php");

function maketab($name,$text)
{	
	global $nrtabs,$tabnames,$tabcontent;
	$tabnames[$nrtabs]=$name;
	$tabcontent[$nrtabs]=$text; 
	$nrtabs++;
}
?>