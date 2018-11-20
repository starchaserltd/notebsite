<?php
require_once("../../../etc/con_rdb.php");
require_once("../../../etc/con_db.php");
require_once("../../../etc/con_sdb.php");
require_once("../../../etc/conf.php");
mysqli_select_db($rcon,"notebro_site");
function clean($x){ return mysqli_real_escape_string($GLOBALS['con'],clean_string($x));}

if(isset($_POST['id'])){ $id = intval($_POST['id']);}

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
		$sql = "UPDATE notebro_site.top_laptops SET type = '".clean($_POST['typenew'])."',ord = '".intval($_POST['order'])."',name = '".clean($_POST['name'])."', price = ".intval($_POST['price'])." WHERE id=".$id.""; //echo $sql;
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
		$ord = intval($_POST['order']);
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
		$price = intval($_POST['price']);
		$valid = 1;
		
		if ($ord ==''){$ord = 'DEFAULT';} else {$ord = $ord;}
		
		$query = "INSERT INTO notebro_site.top_laptops (id, type, ord, m_id, c_id, img, name, cpu, display, mem, hdd, shdd, gpu, wnet, odd, mdb, chassis, acum, warranty, sist, price, valid) values (".$ids.",'".$types."',".$ord.",".$m_id.",'".$c_id."_".$m_id."','".$img."','".$names."',".$cpu.",".$display.",".$mem.",".$hdd.",".$shdd.",".$gpu.",".$wnet.",".$odd.",".$mdb.",".$chassis.",".$acum.",".$war.",".$sist.",".$price.",".$valid.")"; 

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