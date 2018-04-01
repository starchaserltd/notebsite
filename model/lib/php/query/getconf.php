<?php
if(isset($_GET['c'])){ $c=preg_replace('~[\x00\x0A\x0D\x1A\x22\x27\x5C]~u', '\\\$0', filter_var($_GET['c'],FILTER_SANITIZE_STRING)); if(stripos($c,"undefined")==FALSE){ $conf = explode("-",$c);}else{$c=0;} } else {$conf=array(); $c=0;}
if(isset($_GET['comp'])){ $comp=preg_replace('~[\x00\x0A\x0D\x1A\x22\x27\x5C]~u', '\\\$0', filter_var($_GET['comp'],FILTER_SANITIZE_STRING)); if(stripos($comp,"undefined")!=FALSE){ $comp=NULL; } }
if(isset($_GET['cf'])&&($_GET['cf']!="undefined")){ $cf=floatval($_GET['cf']); } else {$cf=0;}

if($c)
{
	$rows = array(); require("../../../../etc/con_sdb.php"); 
	$sql="SELECT id,price,err FROM notebro_temp.all_conf_".$conf[0]." WHERE model=".$conf[0]." AND cpu=".$conf[1]." AND display=".$conf[2]." AND mem=".$conf[3]." AND hdd=".$conf[4]." AND shdd=".$conf[5]." AND gpu=".$conf[6]." AND wnet=".$conf[7]." AND odd=".$conf[8]." AND mdb=".$conf[9]." AND chassis=".$conf[10]." AND acum=".$conf[11]." AND war=".$conf[12]." AND sist=".$conf[13]." LIMIT 1";
	$result = mysqli_query($cons,$sql);
	
	$retry=0;
	if($result!==FALSE)
	{
		$confdata = mysqli_fetch_row($result);
		if(intval($confdata[1])>0)
		{
			$rows["cid"]=$confdata[0];
			$rows["cprice"]=$confdata[1];
			$rows["cerr"]=$confdata[2];
		}
		else { $retry=1; }
	}
	else { $retry=1; }
	
	if($retry)
	{
		$filter="";
		if($cf!==-1)
		{
			switch($comp)
			{
				case "CPU":	{ $filter="cpu=".$conf[1]; break; }
				case "DISPLAY": { $filter="display=".$conf[2]; break; }
				case "MEM": { $filter="mem=".$conf[3]; break; }
				case "HDD":	{ $filter="hdd=".$conf[4]; break; }
				case "SHDD": { $filter="shdd=".$conf[5]; break; }
				case "GPU":	{ $filter="gpu=".$conf[6]; break; } 
				case "WNET": { $filter="wnet=".$conf[7]; break; } 
				case "ODD":	{ $filter="odd=".$conf[8]; break; } 
				case "MDB":	{ $filter="mdb=".$conf[9]; break; } 
				case "CHASSIS": { $filter="chassis=".$conf[10]; break; } 
				case "ACUM": { $filter="acum=".$conf[1]; break; } 
				case "WAR":	{ $filter="war=".$conf[12]; break; }  
				case "SIST": { $filter="sist=".$conf[13]; break; }
			}
		}
		
		if(intval($conf[13])!=999) { $filter.=" AND sist!=999"; }
		
		$sql="(SELECT * FROM `notebro_temp`.`all_conf_".$conf[0]."` WHERE model=".$conf[0]." AND ".$filter." AND price>0 AND value>=".$cf." order by value asc limit 1) UNION (SELECT * FROM notebro_temp.all_conf_".$conf[0]." WHERE model=".$conf[0]." AND ".$filter." AND price>0 AND value<".$cf." order by value desc limit 1) order by abs(value - ".$cf.") limit 1";
		$result = mysqli_query($cons,$sql);
		if($result!==FALSE)
		{
			$confdata = mysqli_fetch_assoc($result);
			$rows["cid"]=$confdata["id"];
			$rows["cprice"]=$confdata["price"];
			$rows["cerr"]=$confdata["err"];
			$a=array();
			if(intval($conf[1])!=intval($confdata["cpu"])){ $a[]="processor"; $rows["changes"]["CPU"]=intval($confdata["cpu"]); } if(intval($conf[2])!=intval($confdata["display"])){ $a[]="display"; $rows["changes"]["DISPLAY"]=intval($confdata["display"]); } if(intval($conf[3])!=intval($confdata["mem"])){ $a[]="memory"; $rows["changes"]["MEM"]=intval($confdata["mem"]); } if(intval($conf[4])!=intval($confdata["hdd"])){ $a[]="hard drive"; $rows["changes"]["HDD"]=intval($confdata["hdd"]); }
			if(intval($conf[5])!=intval($confdata["shdd"])){ $a[]="secondary hard drive"; $rows["changes"]["SHDD"]=intval($confdata["shdd"]); } if(intval($conf[6])!=intval($confdata["gpu"])){ $a[]="video card"; $rows["changes"]["GPU"]=intval($confdata["gpu"]); } if(intval($conf[7])!=intval($confdata["wnet"])){ $a[]="wireless"; $rows["changes"]["WNET"]=intval($confdata["wnet"]); } if(intval($conf[8])!=intval($confdata["odd"])){ $a[]="optical drive"; $rows["changes"]["ODD"]=intval($confdata["odd"]); }
			if(intval($conf[9])!=intval($confdata["mdb"])){ $a[]="motherboard"; $rows["changes"]["MDB"]=intval($confdata["mdb"]); } if(intval($conf[10])!=intval($confdata["chassis"])){ $a[]="chassis"; $rows["changes"]["CHASSIS"]=intval($confdata["chassis"]); } if(intval($conf[11])!=intval($confdata["acum"])){ $a[]="battery"; $rows["changes"]["ACUM"]=intval($confdata["acum"]); } if(intval($conf[12])!=intval($confdata["war"])){ $a[]="warranty"; $rows["changes"]["WAR"]=intval($confdata["war"]); } if(intval($conf[13])!=intval($confdata["sist"])){ $a[]="operating system"; $rows["changes"]["SIST"]=intval($confdata["sist"]); }
			$rows["changes"]["txt"]=preg_replace('/(,(?!.*,))/', ' and',implode(", ",$a));
		}
		else
		{ $rows["cid"]=0; $rows["cprice"]=0; $rows["cerr"]=0; }
	}
	mysqli_close($cons);
	print json_encode($rows);
}
else
{ header('X-PHP-Response-Code: 204', true, 204); }
?>