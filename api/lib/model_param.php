<?php
$resulti = mysqli_query($GLOBALS['con'], "SELECT * FROM notebro_temp.all_conf_".$idmodel[0]." WHERE id = ".$result['id']." LIMIT 1");
$i=0;
while( $row=mysqli_fetch_assoc($resulti))
{
	$response->result->{$i}=new stdClass(); $object_addr=$response->result->{$i};
	// Model info
	$object_addr->config_id=$row["id"];
	foreach($m_search_included as $el)
	{
		if($el["id"]==intval($row["model"]))
		{
			if($el["submodel"]!=""){ $el["submodel_info"][]=$el["submodel"]; }
			if($el["mdb_submodel"]!=""){ $el["submodel_info"][]=$el["mdb_submodel"]; }
			if($el["region"]!=""){ $el["submodel_info"][]=$el["region"]; }
			unset($el["submodel"]); unset($el["mdb_submodel"]); unset($el["region"]);
			$object_addr->model_info=$el; 
		}
	}
	
	$sel="SELECT IF(STRCMP(img_1,''),CONCAT('".$web_address."res/img/models/"."',img_1),NULL) as image_1,IF(STRCMP(img_2,''),CONCAT('".$web_address."res/img/models/"."',img_2),NULL) as image_2,IF(STRCMP(img_3,''),CONCAT('".$web_address."res/img/models/"."',img_3),NULL) as image_3,IF(STRCMP(img_4,''),CONCAT('".$web_address."res/img/models/"."',img_4),NULL) as image_4,link as official_link,IF(STRCMP(link2,''),link2,NULL) as official_link2,ldate as launch_date FROM `notebro_db`.`MODEL` WHERE id=".$idmodel[0]." LIMIT 1";
	$res=array(); $res=mysqli_fetch_assoc(mysqli_query($GLOBALS['con'], $sel));
	$object_addr->model_resources=$res;

	//CPU	
	$sel="SELECT prod,model,tech as lithography,cache,ROUND(clocks,2) as base_speed,ROUND(maxtf,2) as boost_speed,cores,ROUND(tdp,0) as tdp,msc as other_info,ROUND(rating,1) as rating,gpu FROM notebro_db.CPU WHERE id=".$row['cpu']."";
	$res=array(); $res=mysqli_fetch_assoc(mysqli_query($GLOBALS['con'], $sel));
	$res["prod"]=ucfirst(strtolower($res["prod"]));
	$cpugpu = mysqli_fetch_row(mysqli_query($con,"SELECT prod,model FROM notebro_db.GPU WHERE id = ".$res['gpu'].""));
	$res['integrated_video'] = ucfirst(strtolower($cpugpu[0]))." ".$cpugpu[1]; $cpugpu=$res['gpu']; unset($res['gpu']);
	$object_addr->cpu=$res;
					
	//GPU	
	$sel="SELECT prod,model,arch as architecture,tech as lithography,pipe as shaders,cspeed as base_speed,bspeed as boost_speed,sspeed as shader_speed,mspeed as memory_speed,mbw as memory_bandwidth,maxmem as memory_size,mtype as memory_type,ROUND(power,0) as tdp,msc as other_info,ROUND(rating,1) as rating FROM notebro_db.GPU WHERE id=".$row['gpu'].""; 
	$res=array(); $res=mysqli_fetch_assoc(mysqli_query($GLOBALS['con'], $sel));
	$res["prod"]=ucfirst(strtolower($res["prod"]));
	$object_addr->gpu=$res;
					
	//DISPLAY
	$sel="SELECT size,hres as horizontal_resolution,vres as vertical_resolution,backt as type,sRGB,touch,msc as other_info FROM notebro_db.DISPLAY WHERE id=".$row['display']."";
	$res=array(); $res=mysqli_fetch_assoc(mysqli_query($GLOBALS['con'], $sel));
	if ($res['touch']==0) {$row_display['touch'] = "yes";}else {$res['touch'] = "no";}
	$object_addr->display=$res;

	//HDD
	$sel="SELECT model,cap,rpm,readspeed as read_speed FROM notebro_db.HDD WHERE id=".$row['hdd'].""; 
	$res=array(); $res=mysqli_fetch_assoc(mysqli_query($GLOBALS['con'], $sel));
	if(intval($res["rpm"])==0) { $res["rpm"]=NULL; }
	$object_addr->primary_storage=$res;
	
	//SHDD
	$sel="SELECT model,cap,rpm,readspeed as read_speed  FROM notebro_db.HDD WHERE id=".$row['shdd'].""; 
	$res=array(); $res=mysqli_fetch_assoc(mysqli_query($GLOBALS['con'], $sel));
	if(intval($res["rpm"])==0) { $res["rpm"]=NULL; } if(intval($res["read_speed"])==0) { $res["read_speed"]=NULL; }
	$object_addr->secondary_storage=$res;
		
	//MDB
	$sel="SELECT ram as ram_slots,netw as lan_card,hdd as storage_slots,msc as other_info FROM notebro_db.MDB WHERE id=".$row['mdb'].""; 
	$res=array(); $res=mysqli_fetch_assoc(mysqli_query($GLOBALS['con'], $sel));
	if(intval($res["ram_slots"])==0) { $res["ram_slots"]="soldered"; }
	if($res["lan_card"]=="NONE"){ $res["lan_card"]=strtolower($res["lan_card"]); }
	if(intval($res["storage_slots"])==0) { $res["storage_slots"]="soldered"; }
	$object_addr->motherboard=$res;
					
	//MEM
	$sel="SELECT cap as size,freq as speed,type FROM notebro_db.MEM WHERE id=".$row['mem'].""; 
	$res=array(); $res=mysqli_fetch_assoc(mysqli_query($GLOBALS['con'], $sel));
	$object_addr->memory=$res;
				
	//ODD
	$sel="SELECT type,msc as other_info FROM notebro_db.ODD WHERE id=".$row['odd'].""; 
	$res=array(); $res=mysqli_fetch_assoc(mysqli_query($GLOBALS['con'], $sel));
	if($res["type"]=="NONE"){ $res["type"]=strtolower($res["type"]); }
	$object_addr->optical_drive=$res;
					
	//ACUM
	$sel="SELECT cap as capacity,tipc as cell_type,msc as other_info FROM notebro_db.ACUM WHERE id=".$row['acum']."";
	$res=array(); $res=mysqli_fetch_assoc(mysqli_query($GLOBALS['con'], $sel));
	$object_addr->battery=$res;
					
	//CHASSIS
	$sel="SELECT ROUND(thic/10,2) as height_cm, ROUND(thic*0.0393701,2) as height_inch,ROUND(depth/10,2) as depth_cm, ROUND(depth*0.0393701,2) as depth_inch, ROUND(width/10,2) as width_cm, ROUND(width*0.0393701,2) as width_inch, color as colors,made as build_materials,pi as peripheral_interfaces, vi as video_interfaces, web as webcam_mp,keyboard as keyboard_type,charger,msc as other_info FROM notebro_db.CHASSIS WHERE id=".$row['chassis'].""; 
	$res=array(); $res=mysqli_fetch_assoc(mysqli_query($GLOBALS['con'], $sel));
	$object_addr->chassis=$res;
					
	//WNET
	$sel="SELECT model,speed,msc as other_info FROM notebro_db.WNET WHERE id=".$row['wnet'].""; 
	$res=array(); $res=mysqli_fetch_assoc(mysqli_query($GLOBALS['con'], $sel));
	$object_addr->wireless_card=$res;
					
	//WAR
	$sel="SELECT years,prod as type_short,msc as type_long FROM notebro_db.WAR WHERE id=".$row['war'].""; 
	$res=array(); $res=mysqli_fetch_assoc(mysqli_query($GLOBALS['con'], $sel));
	$object_addr->warranty=$res;
					
	//SIST
	$sel="SELECT CONCAT(sist,' ',type,' ',vers) as name FROM notebro_db.SIST WHERE id=".$row['sist'].""; 
	$res=array(); $res=mysqli_fetch_assoc(mysqli_query($GLOBALS['con'], $sel));
	$object_addr->operating_system=$res["name"];

	//OTHER CONFIG INFO
	$object_addr->config_score=strval(floatval($row["rating"])/100);
	$object_addr->config_price=strval(intval($row["price"]));
	$object_addr->config_price_min=strval(round((floatval($row["price"])-(floatval($row["err"])/2)),0));
	$object_addr->config_price_max=strval(round((floatval($row["price"])+(floatval($row["err"])/2)),0));
	$object_addr->battery_life_raw=strval(round(floatval($row["batlife"]),1));
	$hours=intval($row["batlife"]); $minutes=floatval($row["batlife"]); $minutes=intval(($minutes-floor($minutes))*60);
	$object_addr->battery_life_hours=$hours.":".sprintf("%02d", $minutes);
	$object_addr->total_storage_capacity=$row["capacity"];
	$i++;
} 
		
?>