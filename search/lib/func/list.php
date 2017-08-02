<?php
require_once("../../../etc/session.php"); 
require("../../../etc/con_db.php");
$cpu_prod=array(); $cpu_model=array(); $cpu_ldmin=0; $cpu_ldmax=0; $cpu_status=0; $cpu_socket=array(); $cpu_techmin=0; $cpu_techmax=0; $cpu_cachemin=0; $cpu_cachemax=0; $cpu_clockmin=0; $cpu_clockmax=0; $cpu_turbomin=0; $cpu_turbomax=0; $cpu_tdpmax=0;$cpu_tdpmin=0; $cpu_coremin=0; $cpu_coremax=0; $cpu_intgpu=0; $cpu_misc=array(); $cpu_ratemin=0; $cpu_ratemax=0; $battery_life=0; $cpu_pricemin=0; $cpu_pricemax=0;
$gpu_type=array(); $gpu_prod=array(); $gpu_model=array(); $gpu_arch=array(); $gpu_techmin=0; $gpu_techmax=0; $gpu_shadermin=0; $gpu_cspeedmin=0; $gpu_cspeedmax=0; $gpu_sspeedmin=0; $gpu_sspeedmax=0; $gpu_mspeedmin=0; $gpu_mspeedmax=0; $gpu_mbwmin=0; $gpu_mbwmax=0; $gpu_mtype=array(); $gpu_maxmemmin=0; $gpu_maxmemmax=0; $gpu_sharem=0; $gpu_powermin=0;$gpu_powermax=0; $gpu_ldmin="1970"; $gpu_ldmax="2999"; $gpu_misc=array(); $gpu_ratemin=0; $gpu_ratemax=0; $seltdp=0; $gpu_pricemin=0; $gpu_pricemax=0;
$q = filter_input(INPUT_POST,'q',FILTER_SANITIZE_ENCODED);
$select = filter_input(INPUT_POST,'list',FILTER_SANITIZE_ENCODED);
$keys = filter_input(INPUT_POST,'keys',FILTER_SANITIZE_ENCODED);

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
if(!isset($cpu_ldmin)){ $cpu_ldmin="";} if(!isset($cpu_ldmax)){ $cpu_ldmax="";} if(!isset($sockmin)){ $sockmin="";} if(!isset($sockmax)){ $sockmax="";}

if($cpu_ldmin || $sockmin)
{
	$cpu_ldmin=$cpu_ldmin."-01-01";
	$sockmin=$sockmin."-01-01";
}
if($cpu_ldmax || $sockmax)
{
	$cpu_ldmax=$cpu_ldmax."-12-30";
	$sockmax=$sockmax."-12-30";
}

switch ($q) {
		case "CPU":
			switch ($select){
			case "model":
				require_once("list_cpu.php");
				$list=search_cpu ($cpu_prod, $cpu_model, $cpu_ldmin, $cpu_ldmax, $cpu_status, $cpu_socket, $cpu_techmin, $cpu_techmax, $cpu_cachemin, $cpu_cachemax, $cpu_clockmin, $cpu_clockmax, $cpu_turbomin, $cpu_turbomax, $cpu_tdpmax,$cpu_tdpmin, $cpu_coremin, $cpu_coremax, $cpu_intgpu, $cpu_misc, $cpu_ratemin, $cpu_ratemax, $cpu_pricemin, $cpu_pricemax, $battery_life);	
				$t=0;
				if($keys)
					foreach($list as &$list2)
					{
						if(stripos($list2["model"],$keys) === false)
						{	
							unset($list[$t]); //echo " delete time ";
							}
					$t++;
					}
			//	$list[]=["id"=>"0","model"=>$cpu_clockmax];
				break;
			case "prod":
				$cpu_prod='"%'.$keys.'%"';
				$sel="SELECT id, name FROM notebro_site.nomen WHERE type=11 AND name LIKE $cpu_prod";
				$result = mysqli_query($con, $sel);
				$list = array();
				while($rand = mysqli_fetch_row($result)) 
				{ 
					$list[]=["id"=>intval($rand[0]),"model"=>strval($rand[1])];
				}
				mysqli_free_result($result);
				break;
			case "socket":
				$b=0; $y="";
				if(isset($prop) && $prop)
				{
					$y=" AND"; $b=1;
					if(gettype($prop)!="array") { $prop=(array)$prop; }
					foreach ($prop as $x)
					{ $y.=" (prop='$x') OR"; }
					$y=substr($y, 0, -3);
	//			echo $y;
				}
				
				if($sockmin)
				{
					$y.=" AND"; $b=1;
					$y.=" prop2>='$sockmin'";
				}
				
				if($sockmax)
				{
					$y.=" AND"; $b=1;
					$y.=" prop2<='$sockmax'";
				}
				/// --- Socketnm
				if($socktechmin)
				{
					$y.=" AND"; $b=1;
					$y.=" prop1<='$socktechmin'";
				}
				
				if($socktechmax)
				{
					$y.=" AND"; $b=1;
					$y.=" prop1>='$socktechmax'";
				}
				$cpu_socket='"%'.$keys.'%"';
				$sel="SELECT id, name FROM notebro_site.nomen WHERE type=1 AND name LIKE $cpu_socket".$y;
				$result = mysqli_query($con, $sel);
				$list = array();
				while($rand = mysqli_fetch_row($result)) 
				{ 
					$list[]=["id"=>intval($rand[0]),"model"=>strval($rand[1])];
				}
//				$list[]=["id"=>intval($rand[0]),"model"=>$sel];
				mysqli_free_result($result);
				break;
			case "msc":
				$b=0; $y="";
				$cpu_msc='"%'.$keys.'%"';
				$sel="SELECT id, name FROM notebro_site.nomen WHERE type=7 AND name LIKE $cpu_msc".$y;
				$result = mysqli_query($con, $sel);
				$list = array();
				while($rand = mysqli_fetch_row($result)) 
				{ 
					$list[]=["id"=>intval($rand[0]),"model"=>strval($rand[1])];
				}
				mysqli_free_result($result);
				break;
			}
			break;
		case "GPU":
			switch ($select){
				case "model":
					require_once("list_gpu.php"); 
					$gpu_ldmin.="-01-01"; $gpu_ldmax.="-12-31";
					$list=search_gpu ($gpu_type, $gpu_prod, $gpu_model, $gpu_arch, $gpu_techmin, $gpu_techmax, $gpu_shadermin, $gpu_cspeedmin, $gpu_cspeedmax, $gpu_sspeedmin, $gpu_sspeedmax, $gpu_mspeedmin, $gpu_mspeedmax, $gpu_mbwmin, $gpu_mbwmax, $gpu_mtype, $gpu_maxmemmin, $gpu_maxmemmax, $gpu_sharem, $gpu_powermin, $gpu_powermax, $gpu_ldmin, $gpu_ldmax, $gpu_misc, $gpu_ratemin, $gpu_ratemax, $gpu_pricemin,$gpu_pricemax, $seltdp);
					$t=0;
					if($keys)
					foreach($list as &$list2)
					{
						if(stripos($list2["model"],$keys) === false)
						{	//echo $list2["model"];
							unset($list[$t]); //echo " delete time ";
						}
					$t++;
					}
					break;
				case "prod":
					$gpu_prod='"%'.$keys.'%"';
					$sel="SELECT id, name FROM notebro_site.nomen WHERE type=12 AND name LIKE $gpu_prod";
					$result = mysqli_query($con, $sel);
					$list = array();
					while($rand = mysqli_fetch_row($result)) 
					{ 
						$list[]=["id"=>intval($rand[0]),"model"=>strval($rand[1])];
					}
					mysqli_free_result($result);
					break;
				case "msc":
					$gpu_msc='"%'.$keys.'%"';
					$b=0; $y="";
					$sel="SELECT id, name FROM notebro_site.nomen WHERE type=4 AND name LIKE $gpu_msc".$y;
					$result = mysqli_query($con, $sel);
					$list = array();
					while($rand = mysqli_fetch_row($result)) 
					{ 
						$list[]=["id"=>intval($rand[0]),"model"=>strval($rand[1])];
					}
					mysqli_free_result($result);
					break;
				case "arch":
					$gpu_arch='"%'.$keys.'%"';
					$b=0; 
					$y="";
					if(isset($prop) && $prop)
					{
						$y=" AND"; $b=1;
						if(gettype($prop)!="array") { $prop=(array)$prop; }
							foreach ($prop as $x)
							{ $y.=" (prop='$x') OR"; }
							$y=substr($y, 0, -3);
	//			echo $y;
					}
					$y.=" AND prop!='INTEL'";
					$sel="SELECT id, name FROM notebro_site.nomen WHERE type=3 AND name LIKE $gpu_arch".$y;
					$result = mysqli_query($con, $sel);
					$list = array();
					while($rand = mysqli_fetch_row($result)) 
					{ 
						$list[]=["id"=>intval($rand[0]),"model"=>strval($rand[1])];
					}
					mysqli_free_result($result);
					break;
				}
				break;
		case "DISPLAY":
			switch ($select){
				case "resol":
					$dis_res='"%'.$keys.'%"';
					$b=0; $y="";
					if(isset($prop) && $prop)
					{
					$y=" AND"; $b=1;
					if(gettype($prop)!="array") { $prop=(array)$prop; }
					foreach ($prop as $x)
					{ $y.=" (prop='$x') OR"; }
					$y=substr($y, 0, -3);
					}
					if(isset($vresmin)){ $y.=" AND CAST(prop1 AS UNSIGNED)>=".$vresmin; }
					if(isset($vresmax)){ $y.=" AND CAST(prop1 AS UNSIGNED)<=".$vresmax; }
					$sel="SELECT id, name FROM notebro_site.nomen WHERE type=9 AND name LIKE $dis_res".$y." ORDER BY name ASC";
					$result = mysqli_query($con, $sel);
					$list = array();
					while($rand = mysqli_fetch_row($result)) 
					{ 
						$list[]=["id"=>intval($rand[0]),"model"=>strval($rand[1])];
					}
					mysqli_free_result($result);
					break;
				case "msc":
					$dis_msc='"%'.$keys.'%"';
					$sel="SELECT id, name FROM notebro_site.nomen WHERE type=10 AND name LIKE $dis_msc ORDER BY name DESC";
					$result = mysqli_query($con, $sel);
					$list = array();
					while($rand = mysqli_fetch_row($result)) 
					{ 
						$list[]=["id"=>intval($rand[0]),"model"=>strval($rand[1])];
					}
					mysqli_free_result($result);
					break;
			}
			break;
		case "MDB":
			switch ($select){
				case "port":
					$dis_res='"%'.$keys.'%"';
					$b=0; $y="";
					if(isset($prop) && $prop)
					{
					$y=" AND"; $b=1;
					if(gettype($prop)!="array") { $prop=(array)$prop; }
					foreach ($prop as $x)
					{ $y.=" (prop='$x') OR"; }
					$y=substr($y, 0, -3);
	//				echo $y;
					}	
					$sel="SELECT id, name FROM notebro_site.nomen WHERE type=24 AND name LIKE $dis_res".$y." ORDER BY name ASC";
					$result = mysqli_query($con, $sel);
					$list = array();
					while($rand = mysqli_fetch_row($result)) 
					{ 
						$list[]=["id"=>intval($rand[0]),"model"=>strval($rand[1])];
					}
					//var_dump($list);
					mysqli_free_result($result);
					break;
				case "vport":
					$dis_res='"%'.$keys.'%"';
					$b=0; $y="";
					if(isset($prop) && $prop)
					{
					$y=" AND"; $b=1;
					if(gettype($prop)!="array") { $prop=(array)$prop; }
					foreach ($prop as $x)
					{ $y.=" (prop='$x') OR"; }
					$y=substr($y, 0, -3);
	//				echo $y;
					}	
					$sel="SELECT id, name FROM notebro_site.nomen WHERE type=23 AND name LIKE $dis_res".$y." ORDER BY name ASC";
					$result = mysqli_query($con, $sel);
					$list = array();
					while($rand = mysqli_fetch_row($result)) 
					{ 
						$list[]=["id"=>intval($rand[0]),"model"=>strval($rand[1])];
					}
					//var_dump($list);
					mysqli_free_result($result);
					break;
			}
			break;
		case "CHASSIS":
			switch ($select){
				case "stuff":
					$dis_res='"%'.$keys.'%"';
					$b=0; $y="";
					if(isset($prop) && $prop)
					{
					$y=" AND"; $b=1;
					if(gettype($prop)!="array") { $prop=(array)$prop; }
					foreach ($prop as $x)
					{ $y.=" (prop='$x') OR"; }
					$y=substr($y, 0, -3);
	//				echo $y;
					}	
					$sel="SELECT id, name FROM notebro_site.nomen WHERE type=69 AND name LIKE $dis_res".$y." ORDER BY name ASC";
					$result = mysqli_query($con, $sel);
					$list = array();
					while($rand = mysqli_fetch_row($result)) 
					{ 
						$list[]=["id"=>intval($rand[0]),"model"=>strval($rand[1])];
					}
					//var_dump($list);
					mysqli_free_result($result);
					break;
			}
			break;
		case "Producer":
			$prod='"%'.$keys.'%"';
			$sel="SELECT DISTINCT id, prod FROM notebro_site.nomen_models WHERE prod LIKE $prod GROUP BY prod ORDER BY prod ASC";
			$result = mysqli_query($con, $sel);
			$list = array();
			while($rand = mysqli_fetch_row($result)) 
			{ 
				$list[]=["id"=>intval($rand[0]),"model"=>strval($rand[1])];
			}
			mysqli_free_result($result);
			break;
		case "Family":
			$search='"%'.$keys.'%"';
			$y="";
			$y='WHERE fam!="" AND ';
			if(isset($prod))
			{
				if(gettype($prod)!="array") { $prod=(array)$prod; }
				foreach ($prod as $x)
				{ $y.=" (prod='$x') OR"; }
				$y=substr($y, 0, -3);
	//			echo $y;
			$y.=" AND";
			}
				
			$sel="SELECT DISTINCT prod,fam,CONCAT(prod,' ',fam) as disfam FROM `FAMILIES` ".$y." ( fam LIKE $search OR prod LIKE $search ) ORDER BY `FAMILIES`.`prod` ASC, `FAMILIES`.`fam` ASC";
			$result = mysqli_query($con, $sel);
			$list = array();
			$r=1;
			while($rand = mysqli_fetch_row($result)) 
			{ 
				$list[]=["id"=>intval($r),"model"=>strval($rand[2])];
				$r++;
			}
			mysqli_free_result($result);
			break;
						
			case "Regions":
			{
				$search='"%'.$keys.'%"';
				$y="";
				$y="WHERE";
				
				//$y.=" AND";
				
				$sel="SELECT id, name, valid FROM notebro_db.REGIONS ".$y." name LIKE $search AND valid = 1";
				$sel.=" AND id>0";
				$result = mysqli_query($con, $sel);
				$list = array();
				while($rand = mysqli_fetch_row($result)) 
				{ 
					$list[]=["id"=>intval($rand[0]),"model"=>strval($rand[1])];
				}
				mysqli_free_result($result);
				break;
			}
			
}
/*
if(count($list)>20)
{ $list[]=["id"=>"-1","model"=>"More available..."]; }
*/
print preg_replace('/,\s*"[^"]+":null|"[^"]+":null,?/', '', json_encode($list));

	
mysqli_close($con);

?>
