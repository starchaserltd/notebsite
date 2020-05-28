<?php
define("VERBOSE",0);
define("default_time_zone",-10);
?>
<!DOCTYPE html>
<html>
<head>
<style>
a:visited { color: blue; }
</style>
<?php
if(constant("VERBOSE")>0){ echo "Program started!"."<br>"; }
require_once("../../../etc/con_hp_db.php");
require_once("../../../libnb/php/show_error.php");
?>
<?php

if(isset($_GET["date"])){ $proc_date=strval($_GET["date"]); }else{ $proc_date=date("Y-m-d"); }
if(isset($_GET["format"])){ $table_format=strval($_GET["format"]); }else{ $table_format="normal_format"; }
if(strtotime($proc_date)<strtotime("2020-01-01")){ echo "Wrong date. Showing data for the current date.<br>"; $proc_date=date("Y-m-d"); }
if(strtotime($proc_date)>strtotime("2050-01-01")){ echo "Wrong date. Showing data for the current date.<br>"; $proc_date=date("Y-m-d"); }

$retailers_to_compare=["hp_store"=>"HP Store","market"=>"Market Median","amazoncom"=>"Amazon US","bhphotovideo"=>"B&H Photo Video","bestbuyus"=>"Best Buy"];
mysqli_select_db($con, "stch_retail_data");
?>
<?php
$sql_select="SELECT * FROM `hp_price_data` WHERE `date`='".$proc_date."' AND `type`='p_model' AND `retailer`='hpcom'";
$result=mysqli_query($con,$sql_select);
$table_data=array();
$add_table_data=array();
$time_zone=constant("default_time_zone");
$min_time=date("3000-01-01"); $max_time=0;
$red_color_threshold=-10;
$green_color_threshold=10;
if(have_results($result))
{
	#CREATING TABLE HEADERS AND ROWS
	while($row=mysqli_fetch_assoc($result))
	{
		if(!isset($table_data[$row["value"]]))
		{
			$table_data[$row["value"]]=array(); 
			$table_data[$row["value"]]["pid_info"]=array();
		}
		
		$table_data[$row["value"]]["pid_info"][$row["noteb_pid"]]=array();
	}

	#ADDING MODEL NAME INFO
	$sql_select="SELECT `noteb_pid`,`retailer_pid`,`value`,`value_2` FROM `hp_price_data` WHERE `date`='".$proc_date."' AND `type`='model_name' AND `retailer`='hpcom'";
	$result=mysqli_query($con,$sql_select);
	while($row=mysqli_fetch_assoc($result))
	{
		foreach($table_data as $key=>$val)
		{
			foreach($val["pid_info"] as $pid_key=>$pid_val)
			{
				if($pid_key==$row["noteb_pid"])
				{ 
					if(!isset($table_data[$key]["model_name"]))
					{ $table_data[$key]["model_name"]=""; $table_data[$key]["fam_name"]=""; }
					$table_data[$key]["model_name"]=$row["value"]; 
					$table_data[$key]["fam_name"]=$row["value_2"]; 
				}
			}
		}
	}
	
	#ADDING HP PRICES
	$sql_select="SELECT `noteb_pid`,`retailer_pid`,`value`,`time`,`value_2` FROM `hp_price_data` WHERE `date`='".$proc_date."' AND `type`='price' AND `retailer`='hpcom'";
	$result=mysqli_query($con,$sql_select);
	while($row=mysqli_fetch_assoc($result))
	{
		foreach ($table_data as $key=>$val)
		{
			foreach($val["pid_info"] as $pid_key=>$pid_val)
			{
				if($pid_key==$row["noteb_pid"])
				{
					$table_data[$key]["pid_info"][$pid_key]["hp_store"]["min_price"]=[$row["value"],$row["time"],$row["value_2"],$row["retailer_pid"]];
					//if(date($row["time"])<$min_time)
					//$min_time=date($row["time"]);
					if(date($row["time"])>$max_time)
					$max_time=date($row["time"]);
				}
			
				if(!isset($table_columns[$retailers_to_compare["hp_store"]]))
				{ $table_columns[$retailers_to_compare["hp_store"]]=array(); }
				
				if(!in_array("SKU",$table_columns[$retailers_to_compare["hp_store"]]))
				{ array_push($table_columns[$retailers_to_compare["hp_store"]],"SKU"); }
				
				if(!in_array("min_price",$table_columns[$retailers_to_compare["hp_store"]]))
				{ array_push($table_columns[$retailers_to_compare["hp_store"]],"min_price"); }
			}
		}
	}
	
	#ADDING RETAILER PRICES
	foreach ($retailers_to_compare as $retailer=>$retailer_name)
	{
		$sql_select="SELECT `noteb_pid`,`retailer_pid`,`value`,`time`,`value_2` FROM `hp_price_data` WHERE `date`='".$proc_date."' AND `type`='min_price' AND `retailer`='".$retailer."'";
		$result=mysqli_query($con,$sql_select);
		while($row=mysqli_fetch_assoc($result))
		{
			foreach ($table_data as $key=>$val)
			{
				foreach($val["pid_info"] as $pid_key=>$pid_val)
				{
					if($pid_key==$row["noteb_pid"])
					{ 
						if($retailer=="amazoncom"){ $url="https://www.amazon.com/gp/product/".$row["retailer_pid"]."/"; $row["value_2"]=$url; }
						$table_data[$key]["pid_info"][$pid_key][$retailer]["min_price"]=[$row["value"],$row["time"],$row["value_2"],$row["retailer_pid"]];
						
						if(date($row["time"])<$min_time && date($row["time"])>date("2020-01-01"))
						$min_time=date($row["time"]);
						if(date($row["time"])>$max_time)
						$max_time=date($row["time"]);
						
						if(!isset($table_columns[$retailers_to_compare[$retailer]]))
						{ $table_columns[$retailers_to_compare[$retailer]]=array(); }
						if(!in_array("min_price",$table_columns[$retailers_to_compare[$retailer]]))
						{ array_push($table_columns[$retailers_to_compare[$retailer]],"min_price"); };
					}
				}
			}
		}
		
		$sql_select="SELECT `noteb_pid`,`retailer_pid`,`value`,`time`,`value_2` FROM `hp_price_data` WHERE `date`='".$proc_date."' AND `type`='median_price' AND `retailer`='".$retailer."'";
		$result=mysqli_query($con,$sql_select);
		while($row=mysqli_fetch_assoc($result))
		{
			foreach ($table_data as $key=>$val)
			{
				foreach($val["pid_info"] as $pid_key=>$pid_val)
				{
					if($pid_key==$row["noteb_pid"])
					{ 
						if($retailer=="amazoncom"){ $url="https://www.amazon.com/gp/product/".$row["retailer_pid"]."/"; $row["value_2"]=$url; }
						$table_data[$key]["pid_info"][$pid_key][$retailer]["median_price"]=[$row["value"],$row["time"],$row["value_2"],$row["retailer_pid"]];
						
						if(date($row["time"])<$min_time  && date($row["time"])>date("2020-01-01"))
						$min_time=date($row["time"]);
						if(date($row["time"])>$max_time)
						$max_time=date($row["time"]);
						
						if(!isset($table_columns[$retailers_to_compare[$retailer]]))
						{ $table_columns[$retailers_to_compare[$retailer]]=array(); }
						if(!in_array("median_price",$table_columns[$retailers_to_compare[$retailer]]))
						{ array_push($table_columns[$retailers_to_compare[$retailer]],"median_price"); }
					}
				}
			}
		}
	
		$sql_select="SELECT `noteb_pid`,`retailer_pid`,`value`,`time`,`value_2`,`type` FROM `hp_price_data` WHERE `date`='".$proc_date."' AND `type` LIKE 'avg%' AND `retailer`='".$retailer."'";
		$result=mysqli_query($con,$sql_select);
		if(have_results($result))
		{
			while($row=mysqli_fetch_assoc($result))
			{ $add_table_data[$retailer][$row["retailer_pid"]][$row["noteb_pid"]][$row["type"]]=[$row["value"],$row["value_2"]]; }
		}
	}
	#var_dump($table_data);
}

?>
<?php
if(constant("VERBOSE")>0){ echo "Program executed!"."<br>"; }
?>
</head>
<body>
<?php 
if($table_format!="excel_format")
{
	?>
	<form target="_self" action="hp_price_table.php" method="get">
		<select name="date" id="date">
	<?php
	$SQL_dates="SELECT DISTINCT `date` FROM `hp_price_data` ORDER BY `date` DESC";
	$dates_result=mysqli_query($con,$SQL_dates);
	if(have_results($dates_result))
	{
		while($row=mysqli_fetch_assoc($dates_result))
		{
			$selected="";
			if($row["date"]==$proc_date){$selected="selected";}
			echo "<option value='".$row["date"]."' ".$selected.">".$row["date"]."</option>"; 
		}
		mysqli_free_result($dates_result);
	}
	?>
		</select>
		<button type="submit" name="format" value="normal_format">Select date</button>
		<button type="submit" formtarget="_blank" name="format" formaction="hp_price_table.php" value="excel_format">Excel friendly</button>
	<form>
	<br><br>
	<?php
	if(constant("VERBOSE")>0){ echo "<br>Now displaying the table:"."<br>"; }
	?>
	<?php
	echo "Prices collected between: ".date("Y-m-d H:i:s",(strtotime($min_time)+($time_zone*3600)))." and ".date("Y-m-d H:i:s",(strtotime($max_time)+($time_zone*3600)))." PST";
}

echo "<table border=1>";

if($table_format=="normal_format" && isset($table_columns))
{
	$nr_columns=0;
	#var_dump($table_columns);
	foreach($table_columns as $key=>$second_columns)
	{  $nr_columns=$nr_columns+count($second_columns); }
	
	#Here we print the header
	print_the_table_header($table_columns);
	$print_header=0;

	foreach($table_data as $t_key=>$t_val)
	{
		$nr_columns=10;
		echo "<tr><th colspan='".$nr_columns."'><span style='padding-right:20%;'>".$t_val["fam_name"]." ".$t_val["model_name"]."</span><span style='padding-right:0%;'>".$t_val["fam_name"]." ".$t_val["model_name"]."</span><span style='padding-left:20%;'>".$t_val["fam_name"]." ".$t_val["model_name"]."</span></th></tr>";
		foreach($t_val["pid_info"] as $nbpid_key=>$nbpid_val)
		{
			echo "<tr>";
			#echo "<td>";
			#var_dump($nbpid_key);
			#echo "</td>";
			foreach($retailers_to_compare as $retailer_key=>$retailer_name)
			{
				if(isset($nbpid_val[$retailer_key])&&isset($nbpid_val["hp_store"]))
				{
					$retailer_columns=[];
					$column_nr=0;
					foreach($table_columns[$retailers_to_compare[$retailer_key]] as $column)
					{
						$column_nr++;
						$col_span[$column]=0;
						$retailer_val=$nbpid_val[$retailer_key];
						if(isset($retailer_val[$column][0]))
						{
							$url=str_replace("https //","https://",$retailer_val[$column][2]);
							$time=date("Y-m-d H:i:s",(strtotime($retailer_val[$column][1])+($time_zone*3600)));
							$hp_base_price=floatval($nbpid_val["hp_store"]["min_price"][0]);
							if($hp_base_price!=0)
							{ 
								if(isset($add_table_data[$retailer_key][$retailer_val[$column][3]][$nbpid_key]["avg_".$column]) && $add_table_data[$retailer_key][$retailer_val[$column][3]][$nbpid_key]["avg_".$column]!=NULL)
								{ 
									$add_data=$add_table_data[$retailer_key][$retailer_val[$column][3]][$nbpid_key]["avg_".$column];
									$delta=round(floatval($add_data[0])*100,2); $time=$time." (".$add_data[1]." vars)";
								}
								else
								{ $delta=round((((floatval($retailer_val[$column][0])-$hp_base_price)/$hp_base_price)*100),2); }
								$color_delta="color:blue;";
								if($delta<$red_color_threshold){$color_delta="color:red;";}
								else if($delta>$green_color_threshold){$color_delta="color:green;";}
								if($delta>0){$delta="+".strval($delta);}
							}	
							else
							{ $delta="N/A"; }
							$show_delta="";
							if($retailer_key!="hp_store")
							{ $show_delta='<span style="'.$color_delta.'">  ['.$delta.'%]</span>'; }
							
							
							if($retailer_key!="market")
							{ $retailer_columns[$column_nr]="<td style='text-align:center;'>"; }
							else
							{ $retailer_columns[$column_nr]="<td style='text-align:center; background-color:#F8F8F8;'>"; }
						
							if($retailer_val[$column][2]!=NULL && strlen($retailer_val[$column][2])>10)
							{ $retailer_columns[$column_nr].='<div title="'.$time.'"><a target="_blank" href="'.$url.'">$'.$retailer_val[$column][0].$show_delta.'</a></div>'; }
							else
							{ $retailer_columns[$column_nr].='<div title="'.$time.'">$'.$retailer_val[$column][0].$show_delta.'</div>'; }
							
							$retailer_columns[$column_nr].="</td>";
						}
						else if($column=="SKU")
						{ $retailer_columns[$column_nr]="<td style='text-align:center;'>".$retailer_val["min_price"][3]."</td>"; }
						else
						{ $retailer_columns[$column_nr]="<td style='text-align:center;'>-</td>"; }
					}
					echo implode($retailer_columns);
				}
				else
				{ 
					foreach($table_columns[$retailers_to_compare[$retailer_key]] as $column)
					{echo "<td style='text-align:center;'>-</td>"; }
				}
			}
			echo "</tr>";
		}
		if($print_header>10)
		{
			print_the_table_header($table_columns);
			$print_header=0;
		}
		$print_header++;
	}
}
else if($table_format=="excel_format" && isset($table_columns))
{
	$nr_columns=print_the_table_header_excel($table_columns);
	foreach($table_data as $t_key=>$t_val)
	{
		foreach($t_val["pid_info"] as $nbpid_key=>$nbpid_val)
		{
			echo "<tr>";
			echo "<td><span style='padding-right:20%;'>".$t_val["fam_name"]."</span></td><td><span style='padding-right:0%;'>".$t_val["model_name"]."</span></td>";
			#echo "<td>";
			#var_dump($nbpid_key);
			#echo "</td>";

			foreach($retailers_to_compare as $retailer_key=>$retailer_name)
			{
				if(isset($nbpid_val[$retailer_key])&&isset($nbpid_val["hp_store"]))
				{
					$retailer_columns=[];
					$column_nr=0;
					foreach($table_columns[$retailers_to_compare[$retailer_key]] as $column)
					{
						$column_nr++;
						$col_span[$column]=0;
						$retailer_val=$nbpid_val[$retailer_key];
						if(isset($retailer_val[$column][0]))
						{
							$url=str_replace("https //","https://",$retailer_val[$column][2]);
							$time=date("Y-m-d H:i:s",(strtotime($retailer_val[$column][1])+($time_zone*3600)));
							$hp_base_price=floatval($nbpid_val["hp_store"]["min_price"][0]);
							if($hp_base_price!=0)
							{ 
								if(isset($add_table_data[$retailer_key][$retailer_val[$column][3]][$nbpid_key]["avg_".$column]) && $add_table_data[$retailer_key][$retailer_val[$column][3]][$nbpid_key]["avg_".$column]!=NULL)
								{ 
									$add_data=$add_table_data[$retailer_key][$retailer_val[$column][3]][$nbpid_key]["avg_".$column];
									$delta=round(floatval($add_data[0])*100,2); $time=$time." (".$add_data[1]." vars)";
								}
								else
								{ $delta=round((((floatval($retailer_val[$column][0])-$hp_base_price)/$hp_base_price)*100),2); }
								$color_delta="color:blue;";
								if($delta<$red_color_threshold){$color_delta="color:red;";}
								else if($delta>$green_color_threshold){$color_delta="color:green;";}
								if($delta>0){$delta="+".strval($delta);}
							}	
							else
							{ $delta="N/A"; }
							$show_delta="";
							if($retailer_key!="hp_store")
							{ $show_delta='<span style="'.$color_delta.'">  ['.$delta.'%]</span>'; }
							
							
							if($retailer_key!="market")
							{ $retailer_columns[$column_nr]="<td style='text-align:center;'>"; }
							else
							{ $retailer_columns[$column_nr]="<td style='text-align:center; background-color:#F8F8F8;'>"; }

							if($retailer_val[$column][2]!=NULL && strlen($retailer_val[$column][2])>10)
							{ $retailer_columns[$column_nr].='<div title="'.$time.'"><a target="_blank" href="'.$url.'">$'.$retailer_val[$column][0].'</a></div></td>'; if($show_delta!=""){ $retailer_columns[$column_nr].='<td style="text-align:center;">'.$show_delta.'</td>'; } }
							else
							{ $retailer_columns[$column_nr].='<div title="'.$time.'">$'.$retailer_val[$column][0].'</div></td>'; if($show_delta!=""){ $retailer_columns[$column_nr].='<td style="text-align:center;">'.$show_delta.'</td>'; } }
						}
						else if($column=="SKU")
						{ $retailer_columns[$column_nr]="<td style='text-align:center;'>".$retailer_val["min_price"][3]."</td>"; }
						else
						{ $retailer_columns[$column_nr]="<td style='text-align:center;'></td>"; }

					}
					$to_show_string=implode($retailer_columns);
					$to_replace=["$","[","]","+"];
					foreach($to_replace as $word)
					{ $to_show_string=str_replace($word,"",$to_show_string); }
						
					echo $to_show_string;
				}
				else
				{ 
					foreach($table_columns[$retailers_to_compare[$retailer_key]] as $column)
					{echo "<td style='text-align:center;'></td><td style='text-align:center;'></td>"; }
				}
			}
		echo "</tr>";
		}
	}
}
else
{ if(isset($table_columns)){ echo "<tr><td>Unknown table format selected.</td></tr>"; } else { echo "<tr><td>Not data available for ".$proc_date."</td></tr>"; } }
echo "</table>";
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
function print_the_table_header($table_columns)
{
	#Here we print the header
	echo "<tr>";
	foreach($table_columns as $key=>$second_columns)
	{  echo "<td style='text-align:center;' colspan='".count($second_columns)."'><b>".$key."</b></td>"; }
	echo "</tr>";

	echo "<tr>";
	foreach($table_columns as $key=>$second_columns)
	{  
		foreach($second_columns as $column)
		{ echo "<td style='text-align:center;'>".$column."</td>";  }
	}
	echo "</tr>";
}

function print_the_table_header_excel($table_columns)
{
	$to_return=0;
	#Here we print the header
	$skip_columns=["SKU"];
	echo "<tr>";
	echo "<td>Product line</td><td>Model</td><td>SKU</td>";
	foreach($table_columns as $key=>$second_columns)
	{  
		if(in_array($second_columns,$skip_columns)==False)
		{
			foreach($second_columns as $column)
			{
				if(in_array($column,$skip_columns)==False)
				{ echo "<td style='text-align:center;'>".$key." ".$column."</td>"; $to_return++; if($key!="HP Store") { echo "<td style='text-align:center;'>".$key." ".$column." diff</td>"; $to_return++; } }
			}
		}
	}
	echo "</tr>";
	return $to_return;
}

?>