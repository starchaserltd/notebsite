<?php

/* BIG SELECT FOR SETTING PREDEFINED DATABASE VALUES */

$to_return=false;
function list_to_int($list){return array_map(fn(string $id): int => (int) $id, $list);}
$gen_new_data=0;
if(isset($_POST['get_new_search_data'])){ $gen_new_data=filter_var($_POST['get_new_search_data'], FILTER_VALIDATE_INT); }
$gen_new_data=1;
if($gen_new_data==1)
{
	require("../../../etc/con_db.php");
	mysqli_select_db($con,"notebro_site");
	$list_keys=["8","11","12","25","26","51","52","53","54","55","56"];

	/** GETING NOMEN KEYS DATA **/
	$nomen_key=array(); $row=null;
	$sel="SELECT * FROM `notebro_site`.`nomen_key`";
	$result=mysqli_query($con,$sel);
	if(have_results($result))
	{
		while($row=mysqli_fetch_assoc($result))
		{
			$nomen_key[$row["id"]]=["name"=>$row["name"],"type"=>$row["type"]];
		}
		mysqli_free_result($result);
		unset($row);
	}
	
	/** GETING NOMEN DATA **/
	if(count($nomen_key)>0)
	{
		$sel="";
		$sel.=" SELECT `name`,`type` FROM `notebro_site`.`nomen`;";

		//echo $sel;
		$result=mysqli_query($con,$sel);
		if(have_resultS($result))
		{
			$row=null; $type_info=null; $val=null;
			while($row=mysqli_fetch_assoc($result))
			{
				$type_info=$nomen_key[$row["type"]];
				$val=$row["name"];
				$keys=explode("_",$type_info["name"]);
				switch($type_info["type"])
				{
					case "int":
					{ $val=intval($val); break;}
					case "float":
					{ $val=floatval($val); break;}
					case "list":
					{ $val=explode(",",$val); break;}
					default:
					{ break; }
				}
				if(!isset($to_return[$keys[0]][$keys[1]]))
				{
					$to_return[$keys[0]][$keys[1]]=$val;
				}
				else
				{
					if(is_array($to_return[$keys[0]][$keys[1]]))
					{
						//var_dump($to_return[$keys[0]][$keys[1]]); var_dump($val); echo "<br>";
						if(is_array($val))
						{ $to_return[$keys[0]][$keys[1]]=array_merge($to_return[$keys[0]][$keys[1]],$val); }
						else
						{ array_push($to_return[$keys[0]][$keys[1]],$val); }
					}
					else
					{
						$to_return[$keys[0]][$keys[1]]=$val;
					}
				}
			}
			unset($row);
			mysqli_free_result($result);
		}

		/** POST PROCESSING **/
		if(isset($to_return["price"])) { $to_return["model"]["pricemin"]=$to_return["price"]["min"]; $to_return["model"]["pricemax"]=$to_return["price"]["max"]; }
		$to_return["model"]["regions"]=["United States"];
		if(isset($to_return["hdd"]["capmax"])) { $to_return["hdd"]["capmax"]=$to_return["hdd"]["capmax"]*2; }
		if(isset($to_return["cpu"]["tdps"])) { $to_return["cpu"]["tdps"]=list_to_int($to_return["cpu"]["tdps"]); }
		if(isset($to_return["cpu"]["techlist"])) { $to_return["cpu"]["techlist"]=list_to_int($to_return["cpu"]["techlist"]); }		
		if(isset($to_return["war"]["yearsmax"])) { if(intval($to_return["war"]["yearsmax"])>3){ $to_return["war"]["yearsmax"]=3; } }
		if(isset($to_return["chassis"]["webmin"])) { $to_return["chassis"]["webmin"]=round(floatval($to_return["chassis"]["webmin"]),2); }
		if(isset($to_return["chassis"]["webmax"])) { $x=$to_return["chassis"]["webmin"]; while($x<round(floatval($to_return["chassis"]["webmax"]),2)){ $x+=0.1; } $to_return["chassis"]["webmax"]=$x; }
		/* ROUND CHASSIS CHARACTERISTICS TO GET ALL RESULTS */
		if(isset($to_return["chassis"]["thicmax"])) { $to_return["chassis"]["thicmax"]=ceil(floatval($to_return["chassis"]["thicmax"])*10)/10; }
		if(isset($to_return["chassis"]["thicmin"])) { $to_return["chassis"]["thicmax"]=floor(floatval($to_return["chassis"]["thicmax"])*10)/10; }
		if(isset($to_return["chassis"]["widthmax"])) { $to_return["chassis"]["widthmax"]=ceil(floatval($to_return["chassis"]["widthmax"])*10)/10; }
		if(isset($to_return["chassis"]["widthmin"])) { $to_return["chassis"]["widthmin"]=floor(floatval($to_return["chassis"]["widthmin"])*10)/10; }
		if(isset($to_return["chassis"]["depthmax"])) { $to_return["chassis"]["depthmax"]=ceil(floatval($to_return["chassis"]["depthmax"])*10)/10; }
		if(isset($to_return["chassis"]["depthmin"])) { $to_return["chassis"]["depthmin"]=floor(floatval($to_return["chassis"]["depthmin"])*10)/10; }
		if(isset($to_return["chassis"]["weightmax"])) { $to_return["chassis"]["weightmax"]=ceil(floatval($to_return["chassis"]["weightmax"])*10)/10; }
		if(isset($to_return["chassis"]["weightmin"])) { $to_return["chassis"]["weightmin"]=floor(floatval($to_return["chassis"]["weightmin"])*10)/10; }
	}
	mysqli_close($con);
}

print json_encode($to_return);

?>