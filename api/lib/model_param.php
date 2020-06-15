<?php
function comp_details($comp,$id)
{
	switch($comp)
	{
		case "model_name_msearch":
		{
			$res=array();
			foreach($GLOBALS["m_search_included"] as $el)
			{
				if($el["id"]==intval($id))
				{
					if($el["submodel"]!=""){ $el["submodel_info"][]=$el["submodel"]; }
					if($el["mdb_submodel"]!=""){ $el["submodel_info"][]=$el["mdb_submodel"]; }
					if($el["region"]!=""){ $el["submodel_info"][]=$el["region"]; }
					unset($el["submodel"]); unset($el["mdb_submodel"]); unset($el["region"]);
					$res[]=$el; 
				}
			}
			return $res; break;
		}
		case "model_res":
		{
			$limit=substr_count($id,","); 
			$sel="SELECT IF(STRCMP(img_1,''),CONCAT('".$GLOBALS['web_address']."res/img/models/thumb/t_"."',img_1),NULL) as thumbnail,IF(STRCMP(img_1,''),CONCAT('".$GLOBALS['web_address']."res/img/models/"."',img_1),NULL) as image_1,IF(STRCMP(img_2,''),CONCAT('".$GLOBALS['web_address']."res/img/models/"."',img_2),NULL) as image_2,IF(STRCMP(img_3,''),CONCAT('".$GLOBALS['web_address']."res/img/models/"."',img_3),NULL) as image_3,IF(STRCMP(img_4,''),CONCAT('".$GLOBALS['web_address']."res/img/models/"."',img_4),NULL) as image_4,link as official_link,IF(STRCMP(link2,''),link2,NULL) as official_link2,`ldate` as `launch_date`,cpu,display,mem,hdd,shdd,gpu,wnet,odd,mdb,chassis,acum,warranty,sist,id,`p_model` AS `primary_model` FROM `notebro_db`.`MODEL` WHERE id IN (".$id.") LIMIT ".($limit+1);
			$res=array(); $result=mysqli_query($GLOBALS['con'], $sel);
			if($result)
			{
				while($row=mysqli_fetch_assoc($result)){ $res[]=$row; }
				if(isset($res[0]))
				{
					if($limit>0){ return $res; }
					else { return $res[0];}
				}
			}
			break; 
		}
		case "get_primary_models":
		{
			$sel="SELECT `id` FROM `notebro_db`.`MODEL` WHERE `p_model`=(SELECT `p_model` FROM `notebro_db`.`MODEL` WHERE `id`='".$id."' LIMIT 1)";
			$result=mysqli_query($GLOBALS['con'], $sel);
			$res=array(); $key=0;
			if($result&&mysqli_num_rows($result)>0)
			{ 
				while($row=mysqli_fetch_assoc($result)){ $res[$key]=$row["id"]; $key++; }
				if($key>0){ return $res; }
			}
			break;
		}
		case "cpu":
		{
			$sel="SELECT id,prod,model,tech as lithography,cache,ROUND(clocks,2) as base_speed,ROUND(maxtf,2) as boost_speed,cores,ROUND(tdp,0) as tdp,msc as other_info,ROUND(rating,1) as rating,gpu as integrated_video_id FROM notebro_db.CPU WHERE id=".$id."";
			$res=array(); $res=mysqli_fetch_assoc(mysqli_query($GLOBALS['con'], $sel));
			$res["prod"]=ucfirst(strtolower($res["prod"]));
			$cpugpu = mysqli_fetch_row(mysqli_query($GLOBALS['con'],"SELECT `prod`,`model_name` FROM `notebro_db`.`GPU` WHERE `id` = ".$res['integrated_video_id'].""));
			$res['integrated_video'] = ucfirst(strtolower($cpugpu[0]))." ".$cpugpu[1];
			return $res; break;
		}
		case "display":
		{
			$sel="SELECT id,size,hres as horizontal_resolution,vres as vertical_resolution,backt as type,sRGB,touch,msc as other_info FROM notebro_db.DISPLAY WHERE id=".$id."";
			$res=array(); $res=mysqli_fetch_assoc(mysqli_query($GLOBALS['con'], $sel));
			if ($res['touch']==0) {$row_display['touch'] = "yes";}else {$res['touch'] = "no";}
			return $res; break;
		}
		case "mem":
		{
			$sel="SELECT id,cap as size,freq as speed,type FROM notebro_db.MEM WHERE id=".$id.""; 
			$res=array(); $res=mysqli_fetch_assoc(mysqli_query($GLOBALS['con'], $sel));
			return $res; break;
		}
		case "hdd":
		{
			$sel="SELECT id,model,cap,rpm,readspeed as read_speed FROM notebro_db.HDD WHERE id=".$id.""; 
			$res=array(); $res=mysqli_fetch_assoc(mysqli_query($GLOBALS['con'], $sel));
			if(intval($res["rpm"])==0) { $res["rpm"]=NULL; } if(intval($res["read_speed"])==0) { $res["read_speed"]=NULL; }
			return $res; break;
		}
		case "gpu":
		{		
			$sel="SELECT `id`,`prod`,`name` AS `model`,`arch` AS `architecture`,`tech` AS `lithography`,`pipe` AS `shaders`,`cspeed` AS `base_speed`,bspeed as boost_speed,sspeed as shader_speed,mspeed as memory_speed,mbw as memory_bandwidth,maxmem as memory_size,mtype as memory_type,ROUND(power,0) as tdp,msc as other_info,ROUND(rating,1) as rating,typegpu FROM notebro_db.GPU WHERE id=".$id.""; 
			$res=array(); $res=mysqli_fetch_assoc(mysqli_query($GLOBALS['con'], $sel));
			$res["prod"]=ucfirst(strtolower($res["prod"]));
			return $res; break;
		}
		case "wnet":
		{		
			$sel="SELECT id,model,speed,msc as other_info FROM notebro_db.WNET WHERE id=".$id.""; 
			$res=array(); $res=mysqli_fetch_assoc(mysqli_query($GLOBALS['con'], $sel));
			return $res; break;
		}
		case "odd":
		{
			$sel="SELECT id,type,msc as other_info FROM notebro_db.ODD WHERE id=".$id.""; 
			$res=array(); $res=mysqli_fetch_assoc(mysqli_query($GLOBALS['con'], $sel));
			if($res["type"]=="NONE"){ $res["type"]=strtolower($res["type"]); }
			return $res; break;
		}	
		case "mdb":
		{
			$sel="SELECT id,ram as ram_slots,netw as lan_card,hdd as storage_slots,msc as other_info FROM notebro_db.MDB WHERE id=".$id.""; 
			$res=array(); $res=mysqli_fetch_assoc(mysqli_query($GLOBALS['con'], $sel));
			if(intval($res["ram_slots"])==0) { $res["ram_slots"]="soldered"; }
			if($res["lan_card"]=="NONE"){ $res["lan_card"]=strtolower($res["lan_card"]); }
			if(intval($res["storage_slots"])==0) { $res["storage_slots"]="soldered"; }
			return $res; break;
		}			
		case "chassis":
		{
			$sel="SELECT id,ROUND(thic/10,2) as height_cm, ROUND(thic*0.0393701,2) as height_inch,ROUND(depth/10,2) as depth_cm, ROUND(depth*0.0393701,2) as depth_inch, ROUND(width/10,2) as width_cm, ROUND(width*0.0393701,2) as width_inch, color as colors,made as build_materials,pi as peripheral_interfaces, vi as video_interfaces, web as webcam_mp,keyboard as keyboard_type,charger,msc as other_info FROM notebro_db.CHASSIS WHERE id=".$id.""; 
			$res=array(); $res=mysqli_fetch_assoc(mysqli_query($GLOBALS['con'], $sel));
			return $res; break;
		}
		case "acum":
		{
			$sel="SELECT id,cap as capacity,tipc as cell_type,msc as other_info FROM notebro_db.ACUM WHERE id=".$id."";
			$res=array(); $res=mysqli_fetch_assoc(mysqli_query($GLOBALS['con'], $sel));
			return $res; break;
		}	
		case "war":
		{	
			$sel="SELECT id,years,prod as type_short,msc as type_long FROM notebro_db.WAR WHERE id=".$id.""; 
			$res=array(); $res=mysqli_fetch_assoc(mysqli_query($GLOBALS['con'], $sel));
			return $res; break;
		}
		case "sist":
		{
			$sel="SELECT id,CONCAT(sist,' ',type,' ',vers) as name FROM notebro_db.SIST WHERE id=".$id.""; 
			$res=array(); $res=mysqli_fetch_assoc(mysqli_query($GLOBALS['con'], $sel));
			return $res; break;
		}
		default:
		{
			$response->code=32; $response->message.=" Something went wrong retrieving component info."; 
		}
	}
}
?>