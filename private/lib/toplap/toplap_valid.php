<?php
require_once("../../../etc/con_rdb.php");
require_once("../../../etc/con_db.php");
require_once("../../../etc/con_sdb.php");
require_once("../../../etc/conf.php");
mysqli_select_db($rcon,"notebro_site");
function clean($x){ return mysqli_real_escape_string($GLOBALS['con'],clean_string($x));}

if(isset($_POST['id'])){ $id = intval($_POST['id']);} $price_range=0;
if(isset($_POST['order'])&&$_POST['order']!=NULL&&$_POST['order']!=''){$_POST['order']=intval($_POST['order']);}else{$_POST['order']="DEFAULT";}
if(isset($_POST['price_min'])&&$_POST['price_min']!=NULL&&$_POST['price_min']!=''){$price_min=intval($_POST['price_min']); if($price_min!=0){$price_range=1;}}else{$price_min='DEFAULT';}
if(isset($_POST['price_max'])&&$_POST['price_max']!=NULL&&$_POST['price_max']!=''){$price_max=intval($_POST['price_max']);}else{$price_max='DEFAULT';}

if (isset($_POST['action']) && $id) 
{ 
	$_POST['action']=clean($_POST['action']);
	if ($_POST['action'] == 'Delete')
	{
		$sql = "DELETE FROM notebro_site.top_laptops WHERE id=".$id.""; 
		if ($rcon->query($sql) === TRUE){ echo "Record deleted successfully"; }
		else { echo "Error deleting record: " . $rcon->error; }
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=..\\..\\toplap.php\">";
	}
	if ($_POST['action'] == 'Update')
	{
		$sql = "UPDATE notebro_site.top_laptops SET type = '".clean($_POST['typenew'])."',ord = ".$_POST['order'].",name = '".clean($_POST['name'])."', price = ".intval($_POST['price']).", min_price = ".$price_min.", max_price = ".$price_max.", price_range = ".$price_range." WHERE id=".$id.""; //echo $sql;
		if ($rcon->query($sql) === TRUE){ echo "Record updated successfully"; } 
				else { echo "Error updating record: " . mysqli_error($rcon); }
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=..\\..\\toplap.php\">";
	}
}

if (isset($_POST['type']) && isset($_POST['conf_id']))
{ 
	$_POST['conf_id']=clean($_POST['conf_id']);
	if(stripos($_POST['conf_id'],"_")!==FALSE){ $_POST['conf_id']=explode("_",$_POST['conf_id'])[0]; }
	$model = mysqli_fetch_row(mysqli_query($cons,"SELECT model FROM notebro_temp.all_conf WHERE  id =".$_POST['conf_id']."")); //echo $lastid[0]; 
	if($model==NULL) { echo "Counldn't find this config!<br><br>"; }
	else
	{
		$allconfids = mysqli_fetch_row(mysqli_query($cons,"SELECT * FROM notebro_temp.all_conf_".$model[0]." WHERE id=".$_POST['conf_id'])); //echo $allconfids[1]; 
		$name = mysqli_fetch_row(mysqli_query($con,"SELECT model,submodel,idfam,prod,img_1 FROM notebro_db.MODEL WHERE  id =".$model[0]."")); //print_r($name);
		$fam =  mysqli_fetch_row(mysqli_query($con,"SELECT fam,(SELECT subfam FROM notebro_db.FAMILIES WHERE id =".$name[2]." AND showsubfam=1) as subfam FROM notebro_db.FAMILIES WHERE  id =".$name[2].""));
		if(isset($fam[1]) && $fam[1]!==NULL){ $fams = $fam[0]." ".$fam[1]; } else { $fams = $fam[0]; }	
		
		$ids = 0;
		$types = clean($_POST['type']); $selected[$types]="selected";
		$ord = $_POST['order'];
		$m_id = $model[0];
		$c_id = $_POST['conf_id'];
		$img = "res/img/models/".$name[4];
		$names = $name[3]." ".$fams." ".$name[0]." ".$name[1];//echo $names;
		$cpu = $allconfids[2];
		$display = $allconfids[3];
		$mem = $allconfids[4];
		$hdd = $allconfids[5];
		$shdd = $allconfids[6];
		$gpu = $allconfids[7];
		$wnet = $allconfids[8];
		$odd = $allconfids[9];
		$mdb = $allconfids[10];
		$chassis = $allconfids[11];
		$acum = $allconfids[12];
		$war = $allconfids[13];
		$sist = $allconfids[14];
		if(isset($_POST['price'])&&$_POST['price']!=''&&$_POST['price']!=NULL&&$_POST['price']!='0'){$price = intval($_POST['price']);}else{ $price=0; $_POST['price_range']=1; }
		$valid = 1;

		if(isset($_POST['price_range'])&&$_POST['price_range']!==''&&$_POST['price_range']!=NULL){ $price_range=intval($_POST['price_range']); }
		if($price_range)
		{
			require_once("../../../libnb/php/api_access.php");
			if(stripos($site_name,"noteb.com")!==FALSE)
			{
				require_once("../../../etc/con_sdb.php"); 
				$result=mysqli_query($cons,"SELECT * FROM notebro_temp.best_low_opt WHERE id_model=".$m_id." LIMIT 1");
				if($result && mysqli_num_rows($result)>0)
				{
					$row=mysqli_fetch_assoc($result);
					$price_min=intval(directPrice($row["lowest_price"],$cons));
					$price_max=intval(directPrice($row["best_performance"],$cons));
					if($price==0){$price=intval(directPrice($c_id,$cons));}
				}
			}
			else
			{			
				$data="apikey=BHB675VG15n23j4gAz&method=get_optimal_configs&param[model_id]=".$m_id;
				$prldata=json_decode(httpPost($url,$data), true);
				if(isset($prldata['result'][$m_id])){if(intval($prldata['result'][$m_id]['lowest_price'])!=0){$price_min=intval($prldata['result'][$m_id]['lowest_price']);}else{$price_min='DEFAULT';} if(intval($prldata['result'][$m_id]['lowest_price'])!=0){$price_max=intval($prldata['result'][$m_id]['best_performance']);}else{$price_max='DEFAULT';} }
				if($price==0){ $data="apikey=BHB675VG15n23j4gAz&method=get_conf_info&param[conf_id]=".$c_id; $prldata=json_decode(httpPost($url,$data), true); if(isset($prldata['result']['config_price'])){$price=intval($prldata['result']['config_price']);}else{$price=0;}}
			}
		}
		
		if ($ord ==''){$ord = 'DEFAULT';} else {$ord = $ord;}
		if(!isset($price_min)){ $price_min='DEFAULT';} if(!isset($price_max)){ $price_max='DEFAULT';} if(!isset($price_range)){ $price_range='DEFAULT';}
		
		$query = "INSERT INTO notebro_site.top_laptops (id, type, ord, m_id, c_id, img, name, cpu, display, mem, hdd, shdd, gpu, wnet, odd, mdb, chassis, acum, warranty, sist, price, valid, min_price, max_price,price_range) values (".$ids.",'".$types."',".$ord.",".$m_id.",'".$c_id."_".$m_id."','".$img."','".$names."',".$cpu.",".$display.",".$mem.",".$hdd.",".$shdd.",".$gpu.",".$wnet.",".$odd.",".$mdb.",".$chassis.",".$acum.",".$war.",".$sist.",".$price.",1,".$price_min.",".$price_max.",".$price_range.")"; 
		var_dump($query);
		if (mysqli_query($rcon,$query))
		{
			echo '<meta http-equiv="refresh" content="0;URL=..\\..\\toplap.php?selected='.$types.'">';
			echo "<script type='text/javascript'>alert('Record has been successfully introduced')</script>";
		}
		else
		{
			echo '<meta http-equiv="refresh" content="0;URL=..\\..\\toplap.php?selected='.$types.'">';
			echo "<script> type='text/javascript'>alert(\"ERROR: Could not able to execute " . mysqli_error($con)."\")</script>";
		}
	}
}
?>