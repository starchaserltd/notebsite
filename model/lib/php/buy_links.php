<?php
$return=array(); $key=0; $show_keys=0;
if(isset($_GET["model_id"])&&isset($_GET["seller"]))
{
	if(isset($keys) && $keys) { require_once("../../../etc/con_db.php"); } else { }
	$model_id=intval($_GET["model_id"]); if($model_id!==0){$model_cond=" WHERE id=".$model_id;}else{$model_cond="";}
	if(isset($_GET["keys"])){$show_keys=intval($_GET["keys"]);}else{$show_keys=0;}
	$seller=array();
	if(gettype($_GET["seller"])=="array")
	{ foreach($_GET["seller"] as $el) { $seller[]=mysqli_real_escape_string($con,filter_var($el, FILTER_SANITIZE_STRING)); } }
	else
	{ $seller[]=mysqli_real_escape_string($con,filter_var($_GET["seller"], FILTER_SANITIZE_STRING)); }

	require_once("link_gen/key_proc.php");
	require_once("link_gen/link_gen.php");
	
	foreach($seller as $seller_id)
	{
		if($seller_id!=NULL && intval($seller_id)!=0)
		{
			$sql="SELECT `id`,`name`,`logo`,`region`,(SELECT `notebro_site`.`exchrate`.`sign` FROM `notebro_site`.`exchrate` WHERE `notebro_site`.`exchrate`.`id`=`notebro_buy`.`SELLERS`.`exchrate`) AS `exchsign` FROM `notebro_buy`.`SELLERS` WHERE `notebro_buy`.`SELLERS`.`id`='".$seller_id."' LIMIT 1";
			$result_s=mysqli_query($con,$sql);
		}
		else
		{$result_s=NULL;}
		
		if(have_results($result_s)){ $seller_info=mysqli_fetch_assoc($result_s); $region=intval($seller_info["region"]); mysqli_free_result($result_s); } else { $seller_info["name"]="unknown"; $seller_info["logo"]="generic_seller_logo.png"; $seller_info["region"]=1; $seller_info["exchsign"]="$"; }
		
		switch($seller_info["name"])
		{	
			case "googleuk":
			{ $key_proc='standard_key_proc'; $link_gen='google_uk_link'; $region=3; break;}
			case "googleeu":
			{ $key_proc='standard_key_proc'; $link_gen='google_eu_link'; $region=3; break;}
			case "googlecom":
			{ $key_proc='standard_key_proc'; $link_gen='google_com_link'; break;}
			case "amazoncom":
			{ $key_proc='standard_key_proc'; $link_gen='amazon_com_link'; $region=2; break;}
			case "amazonuk":
			{ $key_proc='standard_key_proc'; $link_gen='amazon_uk_link'; $region=3; break;}
			case "compareeu":
			{ $key_proc='standard_key_proc'; $link_gen='compare_eu_link'; $region=3; break;}
			case "compareuk":
			{ $key_proc='standard_key_proc'; $link_gen='compare_uk_link'; $region=3; break;}
			case "amazonde":
			{ $key_proc='standard_key_proc'; $link_gen='amazon_de_link'; $region=3; break;}
			case "neweggcom":
			{ $key_proc='standard_key_proc'; $link_gen='newegg_link'; break;}
			default:
			{ $key_proc='standard_key_proc'; $link_gen='google_com_link'; $region=2; break;}
		}
		
		$sql="SELECT `id`,(SELECT `notebro_db`.`MDB`.`submodel` FROM `notebro_db`.`MDB` WHERE FIND_IN_SET(`notebro_db`.`MDB`.`id`,`notebro_db`.`MODEL`.`mdb`)>0 LIMIT 1) AS `mdb`,`model`,`submodel`,`regions`,`prod`,`keywords`,REGEXP_REPLACE(CONCAT(IFNULL((SELECT `fam` FROM `notebro_db`.`FAMILIES` WHERE `id`=`idfam`),''),' ',IFNULL((SELECT `subfam` FROM `notebro_db`.`FAMILIES` WHERE `id`=`idfam` AND `showsubfam`=1),'')),'[[:space:]]+', ' ') AS `fam` FROM `notebro_db`.`MODEL`".$model_cond;
		$result=mysqli_query($con,$sql);

		while($row=mysqli_fetch_assoc($result))
		{
			$row["fam"]=str_ireplace("education "," ",$row["fam"]); $cond="";
			//$return[$key]["name"]=$row["prod"]." ".$row["model"]." | ".$row["submodel"]." | ".$row["fam"]." | ".$row["mdb"];
			$remove_keywords=array();
			switch($row["prod"])
			{
				case (stripos($row["prod"],"Acer")!==FALSE):
				{
					switch($region)
					{
						default:
						{ break; }
					}
					switch($seller_info["name"])
					{
						default:
						{ break; }
					}
					$row["model"]=strip_garbage($row["model"]);
					$row["model"]=longest_string($row["model"]);	
					break;
				}
				case (stripos($row["prod"],"Asus")!==FALSE):
				{
					switch($region)
					{
						default:
						{ break; }
					}
					switch($seller_info["name"])
					{
						case "amazonde":
						{ $row["prod"]="ASUS Computer"; break;}
						default:
						{ break; }
					}
					$row["model"]=strip_garbage($row["model"]);
					$row["model"]=longest_string($row["model"]);
					break;
				}
				case (stripos($row["prod"],"HP")!==FALSE):
				{
					switch($region)
					{
						case 3:
						{ foreach (["Intel","AMD","ARM"] as $cpu_prod){ $row["model"]=preg_replace("/(\d{2})(t)/", '${1} '.$cpu_prod,$row["model"]); } break;}
						default:
						{ break;}
					}
					switch($seller_info["name"])
					{
						default:
						{ break; }
					}
					$row["model"]=strip_garbage($row["model"]);
					$row["model"]=$row["fam"].$row["model"];
					$cond=" AND fam!='Chromebook'";
					break;
				}
				case (stripos($row["prod"],"Lenovo")!==FALSE):
				{
					if(stripos(trim($row["fam"])," ")!==FALSE){ $parts=explode(" ",trim($row["fam"])); if(stripos($parts[0],"ideapad")!==FALSE){ $row["fam"]=$parts[1]." "; }elseif(stripos($parts[0],"thinkpad")!==FALSE){ $row["fam"]=$parts[0]." "; } }
					if(stripos($row["model"],"legion")!==FALSE) { $row["fam"]="Laptop "; } if(stripos($row["model"],"Miix")!==FALSE) { $row["fam"]=" "; } if(stripos(trim($row["fam"]),"Flex")!==FALSE){ $row["model"]=str_replace("-"," ",$row["model"]);}
					$row["model"]=strip_garbage($row["model"]);
					$row["model"]=$row["fam"].$row["model"];
					break;
				}
				case (stripos($row["prod"],"Dell")!==FALSE):
				{
					if(stripos($row["fam"]," rugged")!==FALSE) { $row["fam"]=str_ireplace(" rugged","",$row["fam"]); }
					if(stripos($row["fam"],"alienware")!==FALSE) { $row["prod"]="Alienware"; $row["fam"]=""; $matches=array(); preg_match("/[0-99]* R[0-99]*/i",$row["model"],$matches);  if(isset($matches[0])) { $row["model"]="AW".str_ireplace($matches[0],str_replace(" ","",$matches[0]),$row["model"]); } }
					switch($region)
					{
						case 3:
						{
							if(stripos($row["fam"],"alienware")!==FALSE)
							{
								$row["model"]=str_replace("AW","Alienware ",$row["model"]); $row["model"]=str_replace("R"," R",$row["model"]);
								$row["prod"]="Dell"; $row["submodel"]=preg_replace("/i\d+/","",$row["submodel"]);
							}
							break;
						}
						default:
						{ break;}
					}
					switch($seller_info["name"])
					{
						default:
						{ break; }
					}
					
					$row["model"]=strip_garbage($row["model"]);
					$row["model"]=remove_short_string($row["model"]);
					$row["model"]=$row["fam"]." ".$row["model"];
					break;
				}
				case (stripos($row["prod"],"Apple")!==FALSE):
				{
					if(stripos($row["model"],"H1")!==FALSE){$row["model"]=str_ireplace("H1","",$row["model"]);}elseif(stripos($row["model"],"H2")!==FALSE){$row["model"]=str_ireplace("H2","",$row["model"]);} if($row["fam"]=="MacBook " && stripos($row["model"],"air")===FALSE){ $row["model"].=' 12"';} 
					switch($region)
					{
						case 3:
						{
							$matches=array(); preg_match("/\d{4}/",$row["model"],$matches); $remove_keywords=array_merge($remove_keywords,$matches); 
							break;
						}
						default:
						{ break;}
					}
					switch($seller_info["name"])
					{
						case "amazoncom":
						{
							if($row["fam"]=="MacBook Pro"){ $row["model"]=preg_replace("/\d{4}/","newest",$row["model"]); }
							break;
						}
						default:
						{ break; }
					}
					$sql="SELECT `notebro_db`.`CPU`.`clocks` FROM `notebro_db`.`CPU` WHERE FIND_IN_SET(`notebro_db`.`CPU`.`id`,(SELECT `notebro_db`.`MODEL`.`cpu` FROM `notebro_db`.`MODEL` WHERE `notebro_db`.`MODEL`.`id`=".$row["id"]." LIMIT 1))>0 ORDER BY clocks ASC LIMIT 1"; 
					$result2=mysqli_query($con,$sql); if($result2 && mysqli_num_rows($result2)>0){ if((stripos($row["model"],"2016")!==FALSE)&&($row["fam"]=="MacBook ")){ $freq=rtrim(rtrim(strval(floatval(mysqli_fetch_array($result2)[0])+0.1),"0"),"."); } else { $freq=rtrim(rtrim(strval(floatval(mysqli_fetch_array($result2)[0])+0),"0"),"."); } $row["model"].=" ".$freq; }
					$row["model"]=strip_garbage($row["model"]);
					$row["model"]=$row["fam"]." ".$row["model"];
					break;
				}
				case (stripos($row["prod"],"Samsung")!==FALSE):
				{
					if(stripos($row["fam"],"notebook")!==FALSE) { $row["fam"]=trim(str_ireplace("notebook","",$row["fam"])); }
					switch($region)
					{
						default:
						{ break;}
					}
					switch($seller_info["name"])
					{
						default:
						{ break; }
					}
					$row["model"]=strip_garbage($row["model"]);
					$row["model"]=$row["fam"]." ".$row["model"];
					break;
				}
				case (stripos($row["prod"],"Vaio")!==FALSE):
				{
					$row["model"]=preg_replace("/\d{4}/","",$row["model"]); $row["model"]="+Vaio+".$row["model"]; $row["prod"]="Sony";
					switch($region)
					{
						default:
						{ break;}
					}
					switch($seller_info["name"])
					{
						default:
						{ break; }
					}
					$row["model"]=strip_garbage($row["model"]);
					$row["model"]=$row["fam"]." ".$row["model"];
					break;
				}
				case (stripos($row["prod"],"Fujitsu")!==FALSE):
				{
					switch($region)
					{
						default:
						{ break;}
					}
					switch($seller_info["name"])
					{
						default:
						{ break; }
					}
					$row["model"]=strip_garbage($row["model"]);
					$row["model"]=$row["fam"]." ".$row["model"];
					break;
				}
				case (stripos($row["prod"],"MSI")!==FALSE):
				{
					switch($region)
					{
						default:
						{ break;}
					}
					switch($seller_info["name"])
					{
						default:
						{ break; }
					}
					$row["fam"]="";
					$row["model"]=strip_garbage($row["model"]);
					$row["model"]=$row["fam"]." ".$row["model"];
					break;
				}
				case (stripos($row["prod"],"Gigabyte")!==FALSE):
				{
					if(stripos($row["fam"],"aorus")!==FALSE){ if($seller_info["name"]!=="amazonde"){ $row["prod"]="Aorus"; $row["fam"]="";} }
					switch($region)
					{
						default:
						{ break;}
					}
					switch($seller_info["name"])
					{
						default:
						{ break; }
					}
					$row["model"]=strip_garbage($row["model"]);
					$row["model"]=$row["fam"]." ".$row["model"];
					break;
				}
				case (stripos($row["prod"],"Microsoft")!==FALSE):
				{
					if(preg_match("/\d{4}/",$row["submodel"])){ $row["model"].=" ".$row["submodel"]; }
					switch($region)
					{
						default:
						{ break;}
					}
					switch($seller_info["name"])
					{
						default:
						{ break; }
					}
					$row["model"]=strip_garbage($row["model"]);
					$row["model"]=$row["fam"]." ".$row["model"];
					break;
				}
				case (stripos($row["prod"],"Clevo")!==FALSE):
				{
					switch($region)
					{
						case 3:
						{
							 $row["prod"]="XMG";  $row["model"]="";
							 break;
						}
						default:
						{ break;}
					}
					switch($seller_info["name"])
					{
						case "amazonuk":
						{
							$row["prod"]=""; $row["model"]="pcspecialists|XMG|cyberpowerpc"; $remove_keywords=["pcspecialists|XMG|cyberpowerpc"]; 
							break;
						}
						case  "googleuk":
						{
							$row["prod"]="pcspecialists or XMG or cyberpowerpc";
							break;
						}
						default:
						{  $prod=""; break; }
					}
					$row["model"]=strip_garbage($row["model"]);
					$row["model"]=$row["fam"]." ".$row["model"];
					break;
				}
				case (stripos($row["prod"],"Tongfang")!==FALSE):
				{
					switch($region)
					{
						case 3:
						{
							 $row["prod"]="XMG";  $row["model"]="";
							 break;
						}
						default:
						{ break;}
					}
					switch($seller_info["name"])
					{
						case "amazonuk":
						{
							$row["prod"]=""; $row["model"]="pcspecialists|XMG|cyberpowerpc"; $remove_keywords=["pcspecialists|XMG|cyberpowerpc"]; 
							break;
						}
						case  "googleuk":
						{
							$row["prod"]="pcspecialists or XMG or cyberpowerpc";
							break;
						}
						default:
						{  $prod=""; break; }
					}
					$row["model"]=strip_garbage($row["model"]);
					$row["model"]=$row["fam"]." ".$row["model"];
					break;
				}
				case (stripos($row["prod"],"Razer")!==FALSE):
				{
					$sql2="SELECT `notebro_db`.`DISPLAY`.`size` FROM `notebro_db`.`DISPLAY` WHERE FIND_IN_SET(`notebro_db`.`DISPLAY`.`id`,(SELECT `notebro_db`.`MODEL`.`display` FROM `notebro_db`.`MODEL` WHERE `notebro_db`.`MODEL`.`id`=".$row["id"]." LIMIT 1))>0 ORDER BY vres ASC LIMIT 1"; 
					$result2=mysqli_query($GLOBALS['con'],$sql2);
					if($result2 && mysqli_num_rows($result2)>0){ $row["model"].=" ".rtrim(rtrim(strval(mysqli_fetch_array($result2)[0]), "0"), "."); }
					switch($region)
					{
						default:
						{ break;}
					}
					switch($seller_info["name"])
					{
						default:
						{ break; }
					}
					$row["model"]=strip_garbage($row["model"]);
					$row["model"]=$row["fam"]." ".$row["model"];
					break;
				}
				case ($row["prod"]=="LG"):
				{
					$matches=array(); if(preg_match("/\d{2} [a-zA-Z]\d{1,10}($|\s)/",$row["model"],$matches)){ $row["model"]=str_replace($matches[0]," ".str_replace(" ","",$matches[0])." ",$row["model"]);}
					switch($region)
					{
						default:
						{ break;}
					}
					switch($seller_info["name"])
					{
						default:
						{ break; }
					}
					$row["model"]=strip_garbage($row["model"]);
					$row["model"]=$row["fam"]." ".$row["model"];
					break;
				}
				case (stripos($row["prod"],"toshiba")!==FALSE):
				{
					switch($region)
					{
						default:
						{ break;}
					}
					switch($seller_info["name"])
					{
						default:
						{ break; }
					}
					$row["model"]=strip_garbage($row["model"]);
					$row["model"]=$row["fam"]." ".$row["model"];
					break;
				}
				case (stripos($row["prod"],"xiaomi")!==FALSE):
				{
					switch($region)
					{
						default:
						{ break;}
					}
					switch($seller_info["name"])
					{
						default:
						{ break; }
					}
					$row["model"]=$row["prod"]." ".$row["model"]; $row["prod"]="";
					$row["model"]=strip_garbage($row["model"]);
					$row["model"]=$row["fam"]." ".$row["model"];
					break;
				}
				case (stripos($row["prod"],"google")!==FALSE):
				{
					$matches=array(); if(preg_match("/[a-zA-Z]+\d{1,10}[-a-zA-Z]+($|\s)/",$row["model"],$matches)){ $row["model"]=str_replace($matches[0],"",$row["model"]);}
					switch($region)
					{
						default:
						{ break;}
					}
					switch($seller_info["name"])
					{
						default:
						{ break; }
					}
					$row["model"]=strip_garbage($row["model"]);
					$row["model"]=$row["fam"]." ".$row["model"];
					break;
				}
				case (stripos($row["prod"],"quanta")!==FALSE):
				{
					switch($region)
					{
						default:
						{ break;}
					}
					switch($seller_info["name"])
					{
						default:
						{ break; }
					}
					$row["model"]=strip_garbage($row["model"]);
					$row["model"]=$row["fam"]." ".$row["model"];
					break;
				}
				default :
				{
					switch($region)
					{
						default:
						{ break;}
					}
					switch($seller_info["name"])
					{
						default:
						{ break; }
					}
					$row["model"]=strip_garbage($row["model"]);
					$row["model"]=$row["fam"]." ".$row["model"];
					break;
				}
			}

			$keys=$key_proc($row["model"],$row["id"],$row["submodel"]);
			$return[$key]["model_id"]=$row["id"];
			$return[$key]["link"]=$link_gen($row["prod"],$keys); $return[$key]["id"]=$seller_id;
			require_once("link_gen/link_changes.php");
			if($show_keys==1) { $return[$key]["keys"]=valid_keys($keys,$row["prod"],$row["fam"],$cond);} else { $return[$key]["seller_logo"]=$seller_info["logo"]; $return[$key]["seller_exchsign"]=$seller_info["exchsign"]; }
			$key++;
		}
	}
}
if($show_keys==1) { echo json_encode($return); }
//foreach($return as $el){ echo "<br>"; var_dump($el); }
?>