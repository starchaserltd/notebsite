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

	$sql = "SELECT * FROM notebro_site.top_laptops WHERE 1=1 ORDER BY type,price";
	if ($results=mysqli_query($con,$sql))
	{
		echo "<div style='float: left;'><br><span style='font-weight:bold;'>Top laptops</span><br><br><table style='background-color:white;'><tr><th>Id</th><th>Name</th><th>Type</th><th>Top Price</th><th>Valid</th><th colspan=1>Controls</th><th>Noteb price</th></tr>";
		while ($row=mysqli_fetch_row($results))
		{
			$conf = explode("_",$row[4]);
			
			$pricegood = mysqli_fetch_row(mysqli_query($rcon,"SELECT realprice,id from notebro_prices.pricing_all_conf where id = '".$conf[0]."'"));
			if ($pricegood[0] == NULL)
			{
				$data="apikey=BHB675VG15n23j4gAz&method=get_conf_info&param[conf_id]=".$conf[0];
				if(stripos($site_name,"noteb.com")!==FALSE){ require_once("../etc/con_sdb.php"); $prldata['result']['config_price']=intval(directPrice($conf[0],$cons));}
				else { $prldata=json_decode(httpPost($url,$data), true); }
				
				if(isset($prldata['result']['config_price'])){$pricegood[0]=intval($prldata['result']['config_price']);}else{$pricegood[0]="";}
			} else {}
			
			?><form method="post" action="lib/toplap/toplap_valid.php"><?php
			echo "<tr><td>&nbsp&nbsp" . $row[0]."&nbsp&nbsp</td><td>&nbsp&nbsp";?>
			
			<input type="text"  autocomplete="off" spellcheck="false" maxlength="40" size="30" name="name" value = "<?php echo $row[6];?>"> 
			<?php echo "&nbsp&nbsp</td><td>&nbsp&nbsp&nbsp&nbsp";?>
			<input type="text"  autocomplete="off" spellcheck="false" maxlength="35" size="10" name="typenew" value = "<?php echo $row[1];?>"> 
			<?php echo "&nbsp&nbsp&nbsp&nbsp</td><td>&nbsp&nbsp&nbsp&nbsp";?>
			<input type="text"  autocomplete="off" spellcheck="false" maxlength="20" size="4" name="price" value = "<?php echo $row[21];?>">
			<?php echo "&nbsp&nbsp&nbsp&nbsp</td><td>&nbsp&nbsp&nbsp&nbsp".$row[22]."&nbsp&nbsp&nbsp&nbsp</td><td>"; $selected[$row[1]]=""; ?>
				<input type="hidden" name="id" value="<?php echo $row[0]; ?>"/>
				<input type="submit" class="button2"  name="action" onclick="if(!confirm('Are you sure to update this line')){return false;}"value="Update"/>
				<input type="submit" class="button2"  name="action" onclick="if(!confirm('Are you trying to delete this laptop<?php echo " ".$row[6]." from top ".$row[1];  ?>')){return false;}" value="Delete"/>
			</form>	<?php echo "</td><td>".$pricegood[0]."</td></tr>";
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






