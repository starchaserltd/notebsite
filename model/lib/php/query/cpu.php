<?php
if(isset($_GET['q'])){ $q=filter_var($_GET['q'], FILTER_VALIDATE_INT); if($q===FALSE){ $q=-1; } } else { $q=-1;}
if($q>=0)
{
	require("../../../../etc/con_db.php");
	require("../../../../etc/rates_conf.php");
	
	mysqli_select_db($con,"notebro_db");
	$sql="SELECT * FROM CPU WHERE id = '".$q."'";
	$result = mysqli_query($con,$sql);
	$rows = array();

	while($r = mysqli_fetch_assoc($result)) 
	{
		 while($elm=each($r))
		{
			if(is_numeric($r[$elm["key"]]))
			{ $r[$elm["key"]]+=0; }
		}
		
		$rows[] = $r;
		$rows[0]['clocks']=number_format($rows[0]['clocks'], 2);
		//$rows[0]['price']=round($rows[0]['price']*0.8,2);
		$row[0]['price']=0;
		$rows[0]['maxtf']=number_format($rows[0]['maxtf'], 2); 
		$rows[0]['msc']=str_replace(",", ", ",$rows[0]['msc']);
		$rows[0]['ldate'] = date('F Y', strtotime($rows[0]['ldate']));
		$rows[0]['confrate'] = round($rows[0]['rating'],3)*$cpu_i/100;
		if(strcasecmp($rows[0]['prod'],"INTEL")==0){$rows[0]['prod']=ucfirst(strtolower($rows[0]['prod'])); }
		$float_tdp=floatval($rows[0]['tdp']);
		if(stripos($rows[0]['prod'],"ARM")!==FALSE){ $float_tdp=$float_tdp/3;}
		$rows[0]['bat']=round((0.5+($float_tdp/7)),5);
		if(!$rows[0]['msc']) { $rows[0]['msc']="N/A"; }
		
		switch (true)
		{
			case ((in_array($rows[0]['tdp'],range(0,15))) && ($rows[0]['price'])>=200): { $rows[0]['class']="Ultrabook"; break; }
			case ((in_array($rows[0]['tdp'],range(0,10))) && ($rows[0]['price'])<200):	{ $rows[0]['class']="Netbook/Tablet"; break; }
			case ((in_array($rows[0]['tdp'],range(10,30))) && ($rows[0]['price'])<200):	{ $rows[0]['class']="Value"; break; }
			case ((in_array($rows[0]['tdp'],range(30,40))) && ($rows[0]['price'])<200):	{ $rows[0]['class']="Value"; break; }
			case ((in_array($rows[0]['tdp'],range(40,60))) && ($rows[0]['price'])<200): { $rows[0]['class']="Value"; break; }
			case ((in_array($rows[0]['tdp'],range(15,30))) && ($rows[0]['price'])>=200):{ $rows[0]['class']="Mainstream"; break; }
			case ((in_array($rows[0]['tdp'],range(30,40))) && ($rows[0]['price'])>=200):{ $rows[0]['class']="Mainstream"; break; }
			case ((in_array($rows[0]['tdp'],range(40,60))) && ($rows[0]['price'])>=200):{ $rows[0]['class']="High performance"; break; }
			case (in_array($rows[0]['tdp'],range(60,150))):								{ $rows[0]['class']="Desktop";	break; }
			default: 																	{ $rows[0]['class']="Undefined"; break; }
		}
	}
	
	$rows[0]['rating']=sprintf("%.1f", round($rows[0]['rating'],1));
	print json_encode($rows[0]);
	mysqli_close($con);
}
else
{ header('X-PHP-Response-Code: 204', true, 204); }
?>