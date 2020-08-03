<?php
define("VERBOSE",0);
define("default_time_zone",-10);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Daily HP laptop price data</title>
<style>
a:visited { color: blue; }
td { border: 1px solid #000000; }
</style>
<script>
function enable_all_conf(hp_pid)
{
	button_value=document.getElementById("main_"+hp_pid).innerHTML;
	var x = document.getElementsByClassName(hp_pid);
	if(button_value=="Show conf")
	{	for (var i = 0; i < x.length; i++) { x[i].style.display = "table-row"; document.getElementById("main_"+hp_pid).innerHTML="Hide conf"; } }
	else
	{	for (var i = 0; i < x.length; i++) { x[i].style.display = "none"; document.getElementById("main_"+hp_pid).innerHTML="Show conf"; } }
}

function search_fields(text)
{
	text=text.toString().trim().toUpperCase();
	if(text.length>0)
	{
		var ele = document.getElementsByClassName('data_table_rows');
		for (var i=0; i<ele.length; i++)
		{ if(ele[i].style.display!="none") { ele[i].style.display="none"; } }
	
		var element_list=document.querySelectorAll("[name*="+'"'+text+'"'+"]");
	
		for (var key in element_list)
		{
			if(typeof element_list[key]!=="undefined" &&  typeof element_list[key].classList!=="undefined")
			{
				if(element_list[key].classList.contains("data_table_rows"))
				{
					if(element_list[key].style.display!="table-row") { element_list[key].style.display="table-row"; }
				}
			}
		}
	}
	else
	{
		var ele = document.getElementsByClassName('data_table_rows');
		for (var i=0; i<ele.length; i++)
		{ if(ele[i].style.display!="table-row") { ele[i].style.display="table-row"; } }
	}
}

setInterval(function() {
	if(document.getElementById("filter_fields"))
	{ search_fields(document.getElementById("filter_fields").value); }
}, 300);//milliseconds
</script>
</head>
<body>
<?php
if(constant("VERBOSE")>0){ echo "Program started!"."<br>"; }
require_once("../../../etc/con_hp_db.php");
require_once("../../../libnb/php/show_error.php");

?>
<?php

if(isset($_GET["date"])){ $proc_date=date('Y-m',strtotime(strval($_GET["date"]))); }else{ $proc_date=date("Y-m"); }
if(isset($_GET["format"])){ $table_format=strval($_GET["format"]); }else{ $table_format="normal_format"; }
if(strtotime($proc_date)<strtotime("2020-01")){ echo "Wrong date. Showing data for the current date.<br>"; $proc_date=date("Y-m"); }
if(strtotime($proc_date)>strtotime("2050-01")){ echo "Wrong date. Showing data for the current date.<br>"; $proc_date=date("Y-m"); }

if($proc_date==date("Y-m")){$proc_date=date('Y-m',strtotime("first day of previous month"));}
if(isset($_GET["ref_retailer"])){ $ref_retailer=strval($_GET["ref_retailer"]); }else{ $ref_retailer=NULL; }
$ref_retailer="hpcom";
if($ref_retailer==NULL){ echo "Reference retailer improperly set."; }

$table_columns["retailers"]=[$ref_retailer=>"Ref Store","market_price"=>"Market Median"];

$SELECT_RETAILER_TO_COMPARE="SELECT `data` FROM `stch_laptop_price`.`retailer_config` WHERE `conf_name`='".$ref_retailer."' LIMIT 1";
$result_r_t_comp=mysqli_query($rcon,$SELECT_RETAILER_TO_COMPARE);
if(have_results($result_r_t_comp))
{
	$retailers_to_compare_row=mysqli_fetch_assoc($result_r_t_comp);
	if(isset($retailers_to_compare_row["data"]))
	{
		$retailer_names=array();
		$retailers_to_compare=array_unique(explode(",",$retailers_to_compare_row["data"]));
		$SELECT_RETAILER_NAMES="SELECT `data` FROM `stch_laptop_price`.`retailer_config` WHERE `conf_name`='retailer_name_map' LIMIT 1";
		$result_r_names=mysqli_query($rcon,$SELECT_RETAILER_NAMES);
		if(have_results($result_r_names))
		{	
			$retailer_names_row=mysqli_fetch_assoc($result_r_names);
			if(isset($retailer_names_row["data"]))
			{
				$retailer_to_names=explode(",",$retailer_names_row["data"]);
				$nr_retailers=intval(count($retailer_to_names));
				for($i=0;$i<=$nr_retailers;$i+=2)
				{
					if(isset($retailer_to_names[$i+1])){ $retailer_names[$retailer_to_names[$i]]=$retailer_to_names[$i+1]; }
				}
			}
			mysqli_free_result($result_r_names);
		}
		foreach($retailers_to_compare as $retailer) { $table_columns["retailers"][$retailer]=$retailer_names[$retailer]; }
	}
	mysqli_free_result($result_r_t_comp);
}

$table_columns["price_types"]=["min_price","median_price"];
$nr_table_columns=count($table_columns["retailers"])*count($table_columns["price_types"])+1;
$table_data=array();
mysqli_select_db($rcon, "stch_hp_data");

if($table_format!="excel_format")
{
	?>
	<form target="_self" action="hp_monthly_price_table.php" method="get">
		<select name="date" id="date" size="5">
	<?php
	$SQL_dates="SELECT DISTINCT DATE_FORMAT(`proc_date`,'%Y-%m') AS `proc_date` FROM `monthly_price_table` ORDER BY `proc_date` DESC";
	$dates_result=mysqli_query($rcon,$SQL_dates);
	if(have_results($dates_result))
	{
		while($row=mysqli_fetch_assoc($dates_result))
		{
			$selected="";
			if($row["proc_date"]==$proc_date){$selected="selected";}
			echo "<option value='".$row["proc_date"]."' ".$selected.">".$row["proc_date"]."</option>"; 
		}
		mysqli_free_result($dates_result);
	}
	?>
		</select>
		<button type="submit" name="format" value="normal_format">Select date</button>
		<button type="submit" formtarget="_blank" name="format" formaction="hp_monthly_price_table.php" value="excel_format">Excel friendly</button>
	</form>
	<br>
	<form target="_self" action="javascript:void(0);" method="get">
	Filter models: <input id="filter_fields" type="text"></input>
	</form>
<?php
}
$proc_date_max=$proc_date."-31";
$proc_date=$proc_date."-01";
$sql_select="SELECT * FROM `monthly_price_table` WHERE `proc_date`='".$proc_date."' ORDER BY `fam` ASC, `model` ASC, `hp_pid` ASC, `noteb_pid` ASC ";
$result=mysqli_query($rcon,$sql_select);
$table_data=array();
$add_table_data=array();
$time_zone=constant("default_time_zone");
$min_time=date("3000-01-01"); $max_time=0;
$red_color_threshold=-10;
$green_color_threshold=10;

if($table_format=="normal_format" && isset($table_columns))
{
	$select_time="SELECT MIN(`price_time`) AS `min_time`, MAX(`price_time`) AS `max_time` FROM `daily_price_data` WHERE `proc_date`>='".$proc_date."' AND `proc_date`<='".$proc_date_max."'  LIMIT 1";
	$time_result=mysqli_query($rcon,$select_time);
	if(have_results($time_result))
	{
		$data_times=mysqli_fetch_assoc($time_result);
		echo "<br><br>Prices collected between: ".date("Y-m-d H:i:s",(strtotime($data_times["min_time"])+($time_zone*3600)))." and ".date("Y-m-d H:i:s",(strtotime($data_times["max_time"])+($time_zone*3600)))." PST";
		echo "<br>";
		mysqli_free_result($time_result);
	}
}

if(have_results($result))
{
	$SELECT_CONF_INFO="SELECT `info`.* FROM `noteb_pid_info` AS `info` JOIN `monthly_price_table` AS `price_table` ON `info`.`notebpid`=`price_table`.`noteb_pid` WHERE `proc_date`='".$proc_date."'";
	$conf_info_result=mysqli_query($rcon,$SELECT_CONF_INFO);
	$conf_info_array=array();
	if(have_results($conf_info_result))
	{
		while($info_row=mysqli_fetch_assoc($conf_info_result))
		{
			$conf_info_array[$info_row["notebpid"]]=$info_row["conf_info"];
		}
		mysqli_free_result($conf_info_result);
	}
	
	echo "<table style='border-collapse: collapse; border: 2px solid #000;'>";
	if($table_format=="normal_format" && isset($table_columns))
	{
		
		$print_header=0;
		$first_header=1;
		$current_model_name="";
		while($row=mysqli_fetch_assoc($result))
		{
			$tr_style="";
			$conf_table="";
			if($print_header==0)
			{
				if($first_header){$hide_columns=False;}else{$hide_columns=True;}
				print_the_table_header($table_columns,$hide_columns);
				$print_header=10;
				$first_header=0;
			}
			
			if($row["noteb_pid"]=="0")
			{
				$new_model_name=trim($row["fam"]." ".$row["model"]);
				if($new_model_name!=$current_model_name)
				{
					$current_model_name=$new_model_name;
					echo "<tr name='".$current_model_name."' class='data_table_rows'><th colspan='".$nr_table_columns."'><span style='padding-right:20%;'>".$row["fam"]." ".$row["model"]."</span><span style='padding-right:0%;'>".$row["fam"]." ".$row["model"]."</span><span style='padding-left:20%;'>".$row["fam"]." ".$row["model"]."</span></th></tr>";
				}
				$print_header--;
				$tr_style="style='display: table-row;'";
				$tr_class=[];
			}
			else
			{
				$tr_style="style='display: none; background-color:#CCCCCC;'";
				$tr_class=[$row["hp_pid"]];
				if(isset($conf_info_array[$row["noteb_pid"]]))
				{
					$conf_info=$conf_info_array[$row["noteb_pid"]];
					if(strlen($conf_info)>10)
					{
						$conf_info=str_replace('"{','{',$conf_info);
						$conf_info=str_replace('}"','}',$conf_info);
						#var_dump($conf_info]);
						$conf_data=json_decode($conf_info,true);
						#var_dump($conf_data);
						if($conf_data!=NULL)
						{
							$conf_table="";
							$conf_table_tr=array(); $conf_table_tr="|";
							foreach($conf_data as $key=>$data)
							{
								$comp_desc=show_comp_info([$key=>$data]);
								if($comp_desc!=NULL)
								{
									$conf_table_tr=$conf_table_tr."|".$key.": ".$comp_desc."|";
								}
							}
							$conf_table_tr.="|"; 
							$conf_table.=$conf_table_tr;
							$conf_table.="";
							#var_dump($conf_table);
						}
						else
						{ /*var_dump($conf_info["conf_info"]);*/ }
					}
				}
			}	
			if($row["noteb_pid"]=="0"){$tr_class[]="data_table_rows";} else{$tr_class[]="data_table_subrows";}
			echo "<tr ".$tr_style." name='".$current_model_name."' class='".implode(" ",$tr_class)."'>";
			echo "<td style='text-align:center;'>".$row["hp_pid"]."</td>";
			$row_data=json_decode($row["price_data"],true); $skipped=False;
			foreach($table_columns["retailers"] as $retailer_key=>$retailer_name)
			{
				foreach($table_columns["price_types"] as $price_type)
				{
					if(isset($row_data[$retailer_key]))
					{
						#SKIPPING ONE PRICE AND PUTTING THE BUTTON
						if($retailer_key=="hpcom" && !$skipped && $row["noteb_pid"]=="0")
						{ echo "<td><button onclick='javascript:void(0);' id='main_".$row["hp_pid"]."'>No conf</button></td>"; $skipped=True; continue;}
						else if($retailer_key=="hpcom" && !$skipped && $row["noteb_pid"]!="0")
						{ echo "<td>".$conf_table."</td>"; $skipped=True; continue;}
						
						$the_data=$row_data[$retailer_key][$price_type];
						if(isset($the_data["count"])){ $vars="(".$the_data["count"]." vars)"; }else{$vars="(1 vars)";} 
						$delta=round($the_data["diff"]*100,2);
						$show_delta="";
						if($retailer_key!="hpcom")
						{
							$color_delta="color:#2c3134;";
							if($delta<$red_color_threshold){$color_delta="color:red;";}
							else if($delta>$green_color_threshold){$color_delta="color:green;";}
							if($delta>0){$delta="+".strval($delta);}
							$show_delta='<span style="'.$color_delta.'">  ['.$delta.'%]</span>';
						}
						$time=date("Y-m-d H:i:s",(strtotime($the_data["time"])+($time_zone*3600)));
						if($retailer_key=="market_price")
						{ echo "<td style='text-align:center; background-color:#F8F8F8;'>"; }
						else
						{ echo "<td style='text-align:center;'>"; }
						echo '<div title="'.$time.' '.$vars.'"><a target="_blank" href="'.$the_data["url"].'">$'.intval($the_data["price"]).$show_delta.'</a></div>';
						echo '</td>';
					}
					else
					{
						echo "<td style='text-align:center;'>-</td>";
					}
				}
			}
			echo "</tr>";
		}
	}
	else if($table_format=="excel_format" && isset($table_columns))
	{
		print_the_table_header_excel($table_columns);
		$current_model_name="";
		while($row=mysqli_fetch_assoc($result))
		{
			$tr_style="";
						
			if($row["noteb_pid"]=="0")
			{

				$tr_style="style='display: table-row;'";
			}
			else
			{
				$tr_style="style='display: none; background-color:#CCCCCC;' class='".$row["hp_pid"]."'";
				if(isset($conf_info_array[$row["noteb_pid"]]))
				{
					$conf_info=$conf_info_array[$row["noteb_pid"]];
					$conf_data=json_decode($conf_info,true);
				}
			}	
			echo "<tr ".$tr_style.">";
			echo "<td><span style='padding-right:20%;'>".$row["fam"]."</span></td><td><span style='padding-right:0%;'>".$row["model"]."</span></td><td style='text-align:center;'>".$row["hp_pid"]."</td>";
			$row_data=json_decode($row["price_data"],true); $skipped=False;
			foreach($table_columns["retailers"] as $retailer_key=>$retailer_name)
			{
				foreach($table_columns["price_types"] as $price_type)
				{
					if(isset($row_data[$retailer_key]))
					{
						
						#SKIPPING ONE PRICE AND PUTTING THE BUTTON
						if($retailer_key=="hpcom" && !$skipped && $row["noteb_pid"]=="0")
						{ echo "<td></td>"; $skipped=True; continue;}
						else if($retailer_key=="hpcom" && !$skipped && $row["noteb_pid"]!="0")
						{ echo "<td></td>"; $skipped=True; continue;}
						
						$the_data=$row_data[$retailer_key][$price_type];
						if(isset($the_data["count"])){ $vars="(".$the_data["count"]." vars)"; }else{$vars="(1 vars)";} 
						$delta=round($the_data["diff"]*100,2);
						$show_delta="";
						if($retailer_key!="hpcom")
						{
							$color_delta="color:blue;";
							if($delta<$red_color_threshold){$color_delta="color:red;";}
							else if($delta>$green_color_threshold){$color_delta="color:green;";}
							if($delta>0){$delta="+".strval($delta);}
							$show_delta='<span style="'.$color_delta.'">'.$delta.'</span>';
						}
						$time=date("Y-m-d H:i:s",(strtotime($the_data["time"])+($time_zone*3600)));
						if($retailer_key=="market_price")
						{ echo "<td style='text-align:center; background-color:#F8F8F8;'>"; }
						else
						{ echo "<td style='text-align:center;'>"; }
						echo '<div title="'.$time.' '.$vars.'"><a target="_blank" href="'.$the_data["url"].'">'.intval($the_data["price"]).'</a></div></td>';

						if($retailer_key=="market_price")
						{ echo "<td style='text-align:center; background-color:#F8F8F8;'>"; }
						else
						{ if($retailer_key!="hpcom"){echo "<td style='text-align:center;'>"; } }
						echo ''.$show_delta.'</td>';
					}
					else
					{
						echo "<td style='text-align:center;'>-</td><td style='text-align:center;'>-</td>";
					}
				}
			}
			echo "</tr>";
		}
	}
	else
	{
		if(isset($table_columns)){ echo "<tr><td>Unknown table format selected.</td></tr>"; } else { echo "<tr><td>Not data available for ".$proc_date."</td></tr>"; }
	}
	echo "\n";
	echo "</table>";
}
?>
<?php
if($table_format!="excel_format")
{
?>
	<br><br>
	<u>Legend</u><br><br>
	<b>min_price</b>=For SKUs it is the minimum price on the retailer's website for which that configuration can be bought.<br>For Configurable SKUs, it is the retailer's smallest price for the cheapest configuration on the market. If the cheapest market configuration is not available from that retailer, then it is the lowest price on the retailer's website. <br>
	<br>
	<b>[diff]</b>=For SKUs it is the percentage difference between the displayed price and the equivalent HP store listing price.
	<br>For Configurable SKUs, the minimum percentage difference is calculated based on the smallest price of the variations available on the retailer's website. The median percentage difference is for the median price of the variations available on the retailer's website.<br>
	<br>
	<b>median_price</b>=For SKUs it is the median price on the retailer's website for which that configuration can be bought.<br>For Configurable SKUs, it is the price for the configuration which matches the market's median configuration. If the market median configuration is not available from that retailer, then it is the median price on the retailer's website.<br>
	<br>
	<b>HP min_price</b>=For SKUs it is the smallest price at which the SKU can be bought from HP's website (including bundles).<br>For configurable SKU's it is HP Store's price for the market median configuration.<br>
<?php
} ?>
</body>
</html>
<?php
#RANDOM FUNCTIONS
function print_the_table_header($table_columns,$hide_column=False)
{
	#Here we print the header
	$tr_to_print="<tr>";
	if($hide_column){$tr_to_print="<tr class='data_table_rows'>"; }
	echo $tr_to_print;
	foreach($table_columns["retailers"] as $retailer_key=>$retailer_name)
	{ $colspan=count($table_columns["price_types"]); if($retailer_key=="hpcom"){$colspan++;}  echo "<td style='text-align:center;' colspan='".$colspan."'><b>".$retailer_name."</b></td>"; }
	echo "</tr>";

	echo $tr_to_print;
	foreach($table_columns["retailers"] as $retailer_key=>$retailer_name)
	{  
		if($retailer_key=="hpcom"){ echo "<td style='text-align:center;'>SKU</td>"; ; }
		foreach($table_columns["price_types"] as $price_types)
		{ echo "<td style='text-align:center;'>".$price_types."</td>";  }
	}
	echo "</tr>";
}

function print_the_table_header_excel($table_columns,$hide_column=False)
{
	$to_return=0;
	#Here we print the header
	$skip_columns=array();
	echo "<tr>";
	echo "<td>Product line</td><td>Model</td><td>SKU</td>";
	foreach($table_columns["retailers"] as $retailer_key=>$retailer_name)
	{  
		if(in_array($retailer_key,$skip_columns)==False)
		{
			foreach($table_columns["price_types"] as $price_type)
			{
				if(in_array($price_type,$skip_columns)==False)
				{ echo "<td style='text-align:center;'>".$retailer_name." ".$price_type."</td>"; $to_return++; if($retailer_key!="hpcom") { echo "<td style='text-align:center;'>".$retailer_name." ".$price_type." diff</td>"; $to_return++; } }
			}
		}
	}
	echo "</tr>";
	return $to_return;
}
function show_comp_info($comp)
{
	$to_return=NULL;
	$comp_data=$comp[key($comp)];
	switch(key($comp))
	{
		case "cpu":
		{
			if(isset($comp_data["prod"])&&isset($comp_data["model"]))
			{ $to_return=$comp_data["prod"]." ".$comp_data["model"]; }
			break;
		}
		case "display":
		{
			if(isset($comp_data["size"])&&isset($comp_data["backt"])&&isset($comp_data["hres"])&&isset($comp_data["vres"])&&isset($comp_data["touch"]))
			{
				if(intval($comp_data["touch"])==1){$touch="Touch";}else{$touch="Non-Touch";}
				$to_return=$comp_data["size"].'" '.$comp_data["backt"]." ".$comp_data["hres"]."x".$comp_data["vres"]." ".$touch;
			}
			break;
		}
		case "mem":
		{
			if(isset($comp_data["cap"]))
			{ $to_return=$comp_data["cap"]." GB"; }
			break;
		}
		case "hdd":
		{
			if(isset($comp_data["cap"])&&isset($comp_data["type"]))
			{ $to_return=$comp_data["type"]." ".$comp_data["cap"]." GB"; }
			break;
		}
		case "shdd":
		{
			if(isset($comp_data["cap"])&&isset($comp_data["type"]))
			{ $to_return=$comp_data["type"]." ".$comp_data["cap"]." GB"; }
			break;
		}
		case "gpu":
		{
			if(isset($comp_data["prod"])&&isset($comp_data["model"]))
			{ $to_return=$comp_data["prod"]." ".$comp_data["model"]; }
			break;
		}
		case "wnet":
		{
			if(isset($comp_data["stand"])&&isset($comp_data["speed"]))
			{ $to_return=$comp_data["speed"]." Mbps ".$comp_data["stand"]; }
			break;
		}
		case "odd":
		{
			if(isset($comp_data["type"]))
			{ $to_return=$comp_data["type"]; }
			break;
		}
		case "mdb":
		{
			$to_return="";
			if(isset($comp_data["submodel"]))
			{ $to_return=$comp_data["submodel"]; }
			if(isset($comp_data["wwan"]) && intval($comp_data["wwan"])==1)
			{ $to_return.=" WWAN: Yes"; }
			else
			{ $to_return.=" WWAN: No"; }
			break;
		}
		case "chassis":
		{
			break;
		}
		case "acum":
		{
			if(isset($comp_data["cap"]))
			{ $to_return=$comp_data["cap"]." Whr"; }
			break;
		}
		case "warranty":
		{
			if(isset($comp_data["years"])&&isset($comp_data["prod"]))
			{ $to_return=$comp_data["years"]." year(s) ".$comp_data["prod"]; }
			break;
		}
		case "sist":
		{
			if(isset($comp_data["sist"])&&isset($comp_data["vers"])&&isset($comp_data["type"]))
			{ $to_return=$comp_data["sist"]." ".$comp_data["vers"]." ".$comp_data["type"]; }
			break;
		}
		default:
		{ break; }
	}
	return $to_return;
}

?>