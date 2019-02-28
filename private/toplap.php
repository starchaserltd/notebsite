<!DOCTYPE html>
<html>
	<head>
	<style>
		table, th, td { border: 1px solid black; }
	</style>
	</head>
	<body style="background-color:#a8649b" >
<?php
error_reporting(E_ALL);
require_once("../etc/conf.php");
require_once("../etc/con_rdb.php");
require_once("../etc/con_db.php");
require_once("../libnb/php/api_access.php");
$selected=array();
$current_type="Business";

	$sql = "SELECT * FROM notebro_site.top_laptops WHERE 1=1 ORDER BY type,ord ASC,price";
	if ($results=mysqli_query($con,$sql))
	{
		echo "<div style='float: left;'><br><span style='font-weight:bold;'>Top laptops</span><br><br><table style='background-color:white;'><tr><th>Id</th><th>Order</th><th>Name</th><th>Type</th><th>Config_id</th><th>Top Price</th><th>Top price min</th><th>Top price max</th><th>Valid</th><th colspan=1>Controls</th><th>Noteb price</th><th>Noteb price min</th><th>Noteb price max</th></tr>";
		while ($row=mysqli_fetch_row($results))
		{
			if($current_type!==$row[1]){$current_type=$row[1]; echo "<tr><td colspan=8></tr>"; }
			$conf = explode("_",$row[4]);
			
			$pricegood = mysqli_fetch_row(mysqli_query($rcon,"SELECT realprice,id from notebro_prices.pricing_all_conf where id = '".$conf[0]."'"));
			if ($pricegood[0] == NULL)
			{
				if(stripos($site_name,"noteb.com")!==FALSE){ require_once("../etc/con_sdb.php"); $prldata['result']['config_price']=intval(directPrice($conf[0],$cons));}
				else { $data="apikey=BHB675VG15n23j4gAz&method=get_conf_info&param[conf_id]=".$conf[0]; $prldata=json_decode(httpPost($url,$data), true); }
				
				if(isset($prldata['result']['config_price'])){$pricegood[0]=intval($prldata['result']['config_price']);}else{$pricegood[0]="";}
			} else {}
			
			?><form method="post" action="lib/toplap/toplap_valid.php"><?php
			echo "<tr><td>&nbsp&nbsp" . $row[0]."&nbsp&nbsp</td><td>&nbsp&nbsp";?>
			<input type="text"  autocomplete="off" spellcheck="false" maxlength="4" size="3" name="order" value = "<?php echo $row[2];?>"> 
			<?php echo "&nbsp&nbsp</td><td>&nbsp&nbsp&nbsp&nbsp";?>
			<input type="text"  autocomplete="off" spellcheck="false" maxlength="40" size="30" name="name" value = "<?php echo $row[6];?>"> 
			<?php echo "&nbsp&nbsp</td><td>&nbsp&nbsp&nbsp&nbsp";?>
			<input type="text"  autocomplete="off" spellcheck="false" maxlength="35" size="10" name="typenew" value = "<?php echo $row[1];?>"> 
			<?php echo "&nbsp&nbsp&nbsp&nbsp</td><td>&nbsp&nbsp&nbsp&nbsp";?>
			<input type="text"  autocomplete="off" spellcheck="false" maxlength="35" size="30" name="conf_id" value = "<?php echo $row[4];?>"> 
			<?php echo "&nbsp&nbsp&nbsp&nbsp</td><td>&nbsp&nbsp&nbsp&nbsp";?>
			<input type="text"  autocomplete="off" spellcheck="false" maxlength="20" size="4" name="price" value = "<?php echo $row[21];?>">
			<?php echo "&nbsp&nbsp&nbsp&nbsp</td><td>&nbsp&nbsp&nbsp&nbsp";?>
			<input type="text"  autocomplete="off" spellcheck="false" maxlength="20" size="4" name="price_min" value = "<?php echo $row[23];?>">
			<?php echo "&nbsp&nbsp&nbsp&nbsp</td><td>&nbsp&nbsp&nbsp&nbsp";?>
			<input type="text"  autocomplete="off" spellcheck="false" maxlength="20" size="4" name="price_max" value = "<?php echo $row[24];?>">
			<?php echo "&nbsp&nbsp&nbsp&nbsp</td><td>&nbsp&nbsp&nbsp&nbsp".$row[22]."&nbsp&nbsp&nbsp&nbsp</td><td>"; $selected[$row[1]]=""; ?>
			<input type="hidden" name="conf_id2" value="<?php echo $row[4]; ?>"/>
			<input type="hidden" name="id" value="<?php echo $row[0]; ?>"/>
			<input type="submit" class="button2"  name="action" onclick="if(!confirm('Are you sure to update this line')){return false;}"value="Update"/>
			<input type="submit" class="button2"  name="action" onclick="if(!confirm('Are you trying to delete this laptop<?php echo " ".$row[6]." from top ".$row[1];  ?>')){return false;}" value="Delete"/>
			<?php echo "</td></form><td>".$pricegood[0]."</td>"; ?>
			<?php 
			if(intval($row[25]))
			{
				if(stripos($site_name,"noteb.com")!==FALSE)
				{
					require_once("../etc/con_sdb.php"); 
					$result=mysqli_query($cons,"SELECT * FROM notebro_temp.best_low_opt WHERE id_model=".$row[3]." LIMIT 1");
					if($result && mysqli_num_rows($result)>0)
					{
						$row=mysqli_fetch_assoc($result);
						$lowest_price=intval(directPrice($row["lowest_price"],$cons));
						$best_performance_price=intval(directPrice($row["best_performance"],$cons));
					}
				}
				else
				{
					$data="apikey=BHB675VG15n23j4gAz&method=get_optimal_configs&param[model_id]=".$row[3];
					$prldata=json_decode(httpPost($url,$data), true);
					if(isset($prldata['result'][$row[3]])){if(intval($prldata['result'][$row[3]]['lowest_price'])!=0){ $lowest_price=intval($prldata['result'][$row[3]]['lowest_price']); }}
					if(isset($prldata['result'][$row[3]])){if(intval($prldata['result'][$row[3]]['best_performance'])!=0){$best_performance_price=intval($prldata['result'][$row[3]]['best_performance']); }}
				}
				echo "<td>".$lowest_price."</td><td>".$best_performance_price."</td>";
			}
			else
			{
				echo "<td colspan=2></td>";
			}
			?>
			<?php echo "</form></tr>";
		
		}
		echo "</table></div>";
		mysqli_free_result($results);
	}
	if(isset($_GET['selected'])){ $selected[$_GET['selected']]="selected"; }
	?>
	<div style="float: left;padding-left: 15px;">
	<?php
	require_once('lib/toplap/toplap_add.php');
	?>
	</div>
	</body>
</html>






