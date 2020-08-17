<?php
function get_price_list($model,$noteb_pid=NULL,$retailer_pid=NULL,$retailer=NULL,$provided_price_list=NULL,$con=NULL)
{
	$to_return=NULL;
	$prod=NULL;
	$abort=False;
	if($con==NULL)
	{
		try
		{ $con=$GLOBALS["con"];}
		catch  (Exception $e)
		{ require_once("../etc/con_db.php"); }
	}
	if(!$con){$abort=True; echo "No database connection<br>";}
	
	if(!$abort)
	{
		$sql_cond="";
		$abort=True;
		if($noteb_pid!=NULL){ $abort=False; $sql_cond=" AND `noteb_pid`='".$noteb_pid."'";}
		if($retailer_pid!=NULL){ $abort=False; $sql_cond=" AND `retailer_pid`='".$retailer_pid."'";}
		if($retailer!=NULL){ $abort=False; $sql_cond=$sql_cond." AND `retailer`='".$retailer."'";}
		if($model!=NULL){ $abort=False; $sql_cond=$sql_cond." AND `model`='".$model."'";}
	}
	
	if(!$abort)
	{
		if($provided_price_list==NULL)
		{
			$all_price_list=NULL;
			$discount=1;
			$sql="SELECT `price_conf_data`,`valid_read_time` FROM `stch_retail_data`.`retailer_conf_id_assoc` WHERE 1=1 ".$sql_cond." ORDER BY `valid_read_time` DESC";
			$result=mysqli_query($con,$sql);
			if(have_results($result))
			{
				while($row=mysqli_fetch_assoc($result))
				{
					$price_calc_data=[];
					$price_calc_data=json_decode($row["price_conf_data"],TRUE);
					$price_calc_data["valid_read_time"]=$row["valid_read_time"];
					$all_price_list[]=$price_calc_data;
				}
				mysqli_free_result($result);
			}
		}
		else
		{ $provided_price_list["valid_read_time"]=date("Y-m-d H:i:s"); $all_price_list[]=$provided_price_list; }
			
		if($all_price_list!=NULL && count($all_price_list)>0)
		{
			foreach($all_price_list as $price_list)
			{
				$abort=False;
				$price_list_not_ok=True;
				foreach($price_list as $el)
				{ if(is_array($el) && count($el)>1){$price_list_not_ok=False; } }
			
				if(isset($price_list["nodiscount"]) && $price_list["nodiscount"]!==NULL && $price_list["nodiscount"]!="")
				{ $nodiscount=$price_list["nodiscount"]; }
				else
				{ $nodiscount=0; }
			
				if($prod==NULL)
				{
					if(isset($price_list["prod"]) && $price_list["prod"]!==NULL && $price_list["prod"]!="")
					{ $prod=$price_list["prod"]; }
					else
					{ $sql="SELECT `prod` FROM `notebro_db`.`MODEL` WHERE `id`='".$model."'"; $prod=mysqli_fetch_assoc(mysqli_query($con,$sql))["prod"]; if(!(isset($prod) && $prod)) { $prod=""; } }
				}

				if(isset($price_list["discounted_price"]) && $price_list["discounted_price"]!==NULL && $price_list["discounted_price"]!="")
				{
					if(isset($price_list["normal_price"]) && $price_list["normal_price"]!==NULL && $price_list["normal_price"]!="")
					{ if($prod!="Dell" && !$nodiscount ){ $normal_price=$price_list["discounted_price"]; $discount=$price_list["normal_price"]/$price_list["discounted_price"]; } else { $normal_price=$price_list["normal_price"]; $discount=1;} }
					else 
					{ $abort=True; }
				}
				else 
				{ $abort=True; }
			
				if(!$abort)
				{
					$price_list["prod"]=$prod; $price_list["discount"]=$discount; $price_list["normal_price"]=$normal_price;
					$price_list["info"]=$price_list_not_ok;
					$price_list["time"]=$price_list["valid_read_time"];
					$to_return[]=$price_list;
				}
			}
		}
		
	}
	return $to_return;
}

function calc_conf_price($conf,$noteb_pid=NULL,$retailer_pid=NULL,$retailer=NULL,$set_price_list=NULL,$con=NULL)
{
	$to_return=NULL;
	$model_comp_fields=["cpu","display","mem","hdd","shdd","gpu","mdb","wnet","odd","sist","chassis","acum","war","model"];
	$abort=False;
	$info=NULL;
	if($con==NULL)
	{
		try
		{ $con=$GLOBALS["con"];}
		catch  (Exception $e)
		{ require_once("../etc/con_db.php"); }
	}
	if(!$con){$abort=True; echo "No database connection<br>";}
	
	if($conf!=NULL && is_array($conf)) 
	{	foreach($model_comp_fields as $field)
		{
			if(!in_array($field,array_keys($conf)))
			{ $abort=True; break; }
		}
	}
	else
	{ $abort=True; }
	
	if(!$abort)
	{
		$all_price_info=get_price_list($conf["model"],$noteb_pid,$retailer_pid,$retailer,$provided_price_list=$set_price_list,$con);

		# echo " "; echo "<br><br>"; var_dump($all_price_info);echo "<br>".var_dump($conf)."<br>";
		if($all_price_info!=NULL && count($all_price_info)>0)
		{
			foreach($all_price_info as $price_info)
			{
				#if($retailer_pid=="7AX33AV_1"){ echo "<br>"; var_dump($price_info); echo "<br>";}
				$abort=False;
				if($price_info==NULL)
				{ $abort=True; }

				if(!$abort)
				{
					$discount=$price_info["discount"]; $normal_price=$price_info["normal_price"]; $prod=$price_info["prod"];
					foreach($conf as $key=>$val)
					{
						if($key!="model")
						{
							if((!isset($price_info[$key]) || !isset($price_info[$key][$val]) || is_null($price_info[$key][$val]) || $price_info[$key][$val] === "" ) && in_array($key,$model_comp_fields))
							{  /*echo "<br>"; var_dump($key); var_dump($price_info[$key][$val]); echo "<br>";*/ $abort=True; break; }
						}
					}

					if(!$abort)
					{
						$no_disc_price=$normal_price+$price_info["cpu"][$conf["cpu"]]+$price_info["display"][$conf["display"]]+$price_info["mem"][$conf["mem"]]+$price_info["hdd"][$conf["hdd"]];
						$no_disc_price=$no_disc_price+$price_info["shdd"][$conf["shdd"]]+$price_info["odd"][$conf["odd"]]+$price_info["wnet"][$conf["wnet"]]+$price_info["mdb"][$conf["mdb"]];
						$no_disc_price=$no_disc_price+$price_info["chassis"][$conf["chassis"]]+$price_info["acum"][$conf["acum"]]+$price_info["sist"][$conf["sist"]]+$price_info["gpu"][$conf["gpu"]];
						
						$conf_price=intval($no_disc_price)*$discount;
						#if($retailer_pid=="5HC96AV_MB"){	echo "<br>"; var_dump($conf_price); echo " "; var_dump($conf); echo $abort; echo "<br>"; }
						#Calculate warranty price based on retailer rules
						switch($prod)
						{
							case "Lenovo": { $conf_price=intval($conf_price+$price_info["war"][$conf["war"]]); break; }
							case "HP": { $conf_price=intval($conf_price+$price_info["war"][$conf["war"]]*$discount); break; }
							case "Dell": { $conf_price=intval($conf_price+$price_info["war"][$conf["war"]]*$discount)/$discount; break; }
							default: { $conf_price=intval($conf_price+$price_info["war"][$conf["war"]]*$discount); break; }
						}
						$info=$price_info["info"];
						$to_return[]=[$conf_price,$info,$price_info["time"]];
					}
				}
			}
		}
	}
	return $to_return;
}

?>