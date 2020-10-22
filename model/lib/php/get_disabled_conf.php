<?php

//GETTING DISABLED_CONF AND ENABLED_CONF FOR RETAILER
$SELECT_PRICE_DATA="SELECT * FROM `notebro_buy`.`DISABLED_CONF` WHERE  ( `comp`=0 OR `comp`=1 )  AND `model`='".$id_model."' AND (`retailer` IS NOT NULL AND `retailer`!='' AND `retailer`!='1')";
$select_q_r=mysqli_query($con,$SELECT_PRICE_DATA); $var_conf_disabled=array(); $var_conf_enabled=array(); $total_enabled=0;
if(have_results($select_q_r))
{
	while($temp_row=mysqli_fetch_assoc($select_q_r))
	{
		$set_comp=-1; if(isset($temp_row["comp"])){$set_comp=intval($temp_row["comp"]);}
		#GETTING DISABLED_CONF FOR RETAILER
		if($set_comp==0)
		{
			$var_conf_disabled[$temp_row["id"]]=array();
			if(!isset($var_conf_disabled[$temp_row["id"]]["nr_valid"]))
			{ $var_conf_disabled[$temp_row["id"]]["nr_valid"]=0; $var_conf_disabled[$temp_row["id"]]["retailer"]=$temp_row["retailer"]; $var_conf_disabled[$temp_row["id"]]["retailer_pid"]=$temp_row["retailer_pid"]; }
			foreach($laptop_comp_list as $comp_name)
			{ $var_conf_disabled[$temp_row["id"]][$comp_name]=array(); if($temp_row[$comp_name]!==NULL){ $var_conf_disabled[$temp_row["id"]][$comp_name]=explode(",",$temp_row[$comp_name]); $var_conf_disabled[$temp_row["id"]]["nr_valid"]++; }else{ $var_conf_disabled[$temp_row["id"]][$comp_name]=NULL; } }
		}
		elseif($set_comp==1)
		{
			#GETTING ENABLED_CONF FOR RETAILER
			if($set_comp && isset($temp_row["comp_order"]))
			{
				$var_conf_enabled[$temp_row["id"]]=array();
				$var_conf_enabled[$temp_row["id"]]["part_1"]=array();
				$var_conf_enabled[$temp_row["id"]]["part_2"]=array();
				$var_conf_enabled[$temp_row["id"]]["all_part"]=array();
				$var_conf_enabled[$temp_row["id"]]["retailer"]=$temp_row["retailer"]; $var_conf_enabled[$temp_row["id"]]["retailer_pid"]=$temp_row["retailer_pid"]; 
				
				$comp_order_row=explode(",",$temp_row["comp_order"]);
				$i=1;
				foreach($comp_order_row as $key=>$val)
				{
					$var_conf_enabled[$temp_row["id"]]["all_part"][]=$val;
					if($i==1)
					{ $var_conf_enabled[$temp_row["id"]]["part_1"][]=$val; }
					else
					{ $var_conf_enabled[$temp_row["id"]]["part_2"][]=$val; }
					$i++; 
				}
				$var_conf_enabled[$temp_row["id"]]["all_part"]["nr"]=count($var_conf_enabled[$temp_row["id"]]["all_part"]);
				$var_conf_enabled[$temp_row["id"]]["part_1"]["nr"]=count($var_conf_enabled[$temp_row["id"]]["part_1"]);
				$var_conf_enabled[$temp_row["id"]]["part_2"]["nr"]=count($var_conf_enabled[$temp_row["id"]]["part_2"]);
			}
			if($set_comp && isset($var_conf_enabled[$temp_row["id"]]["part_1"]["nr"]) && $var_conf_enabled[$temp_row["id"]]["part_1"]["nr"]>0)
			{
				foreach($laptop_comp_list as $comp_name)
				{
					$var_conf_enabled[$temp_row["id"]][$comp_name]=array();
					if($temp_row[$comp_name]!==NULL)
					{
						if(in_array($comp_name,$var_conf_enabled[$temp_row["id"]]["all_part"]))
						{ $var_conf_enabled[$temp_row["id"]][$comp_name]=explode(",",$temp_row[$comp_name]); }
						else
						{ if(isset($var_conf_enabled[$temp_row["id"]])){ unset($var_conf_enabled[$temp_row["id"]]); } break; }
					}
					else
					{
						if(!in_array($comp_name,$var_conf_enabled[$temp_row["id"]]["all_part"]))
						{ $var_conf_enabled[$temp_row["id"]][$comp_name]=NULL; }
						else
						{ if(isset($var_conf_enabled[$temp_row["id"]])){ unset($var_conf_enabled[$temp_row["id"]]); } break; }
					}
				}
			}
		}
	}

	$total_enabled=count($var_conf_enabled);
	unset($temp_row); mysqli_free_result($select_q_r);

	//CHECK DISABLED CONF
	$disabled_confs=array();
	foreach($var_conf_disabled as $disabled_key=>$disabled_data)
	{
		$disb_vote=0;
		foreach($laptop_comp_list as $comp_name)
		{
			if($disabled_data[$comp_name]!=NULL)
			{
				if(in_array(strval(${"id_".$comp_name}),$disabled_data[$comp]))
				{ $disb_vote++; }
				else
				{ $disb_vote=-99999; break; }
			}
			if($disb_vote>=$disabled_data["nr_valid"])
			{ $disabled_confs[$disabled_key]=["retailer"=>$disabled_data["retailer"],"retailer_pid"=>$disabled_data["retailer_pid"]]; break; }
		}
	}
	
	//CHECK ENABLED CONF
	$d_enabled_confs=array();
	foreach($var_conf_enabled as $enabled_key=>$enabled_data)
	{
		$enab_vote_1=0; $pos_disable=0;
		foreach($enabled_data["part_1"] as $some_key=>$comp_name)
		{	
			if($some_key!=="nr")
			{
				if(in_array(strval(${"id_".$comp_name}),$enabled_data[$comp_name]))
				{ $enab_vote_1++; }

			}
		}
		$enab_vote_2=0;
		if($enab_vote_1>0 && $enab_vote_1==$enabled_data["part_1"]["nr"])
		{
			foreach($enabled_data["part_2"] as $some_key=>$comp_name)
			{
				if($some_key!=="nr")
				{
					if(!in_array(strval(${"id_".$comp_name}),$enabled_data[$comp_name]))
					{ $pos_disable=1; break; }
					else
					{ $enab_vote_2++; }
				}
			}
		}
		if($enab_vote_2>0 && $enab_vote_1>0 && $enab_vote_2==$enabled_data["part_2"]["nr"] && $enab_vote_1==$enabled_data["part_1"]["nr"])
		{ $pos_disable=-1; $d_enabled_confs=array();  break; }
		elseif($enab_vote_2>0 && $enab_vote_1>0 && $enab_vote_2!=$enabled_data["part_2"]["nr"] && $enab_vote_1==$enabled_data["part_1"]["nr"])
		{ $pos_disable=1; }
		
		if($pos_disable==1)
		{ $d_enabled_confs[$enabled_key]=["retailer"=>$enabled_data["retailer"],"retailer_pid"=>$enabled_data["retailer_pid"]]; }
	}

	if(count($d_enabled_confs)>0)
	{
		foreach($d_enabled_confs as $enabled_key=>$some_data)
		{ $disabled_confs[$enabled_key."_en"]=$some_data; }
		unset($d_enabled_confs);
		unset($some_data);
	}
	
	$sql_parts=array();
	foreach($disabled_confs as $disabled_conf)
	{
		if($disabled_conf["retailer_pid"]==NULL || empty($disabled_conf["retailer_pid"]) || strlen($disabled_conf["retailer_pid"])<3)
		{ $sql_parts[]="(`retailer`!='".$disabled_conf["retailer"]."')"; }
		else
		{ $sql_parts[]="(`retailer`!='".$retailer."' AND `retailer_pid`!='".$disabled_conf["retailer_pid"]."')"; }
	}
	if(count($sql_parts)>0) { $disabled_cond=implode(" AND ",$sql_parts); }
	unset($sql_parts);
}

?>