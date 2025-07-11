<?php
$rootpath = realpath($_SERVER["DOCUMENT_ROOT"]).$root_mod;
require_once($rootpath.'/etc/con_db.php');
mysqli_select_db($con,$global_notebro_site);
//GET currency rates
$sel2 = "SELECT `code`,`convr`,`sign` FROM `".$global_notebro_site."`.`exchrate` WHERE `valid`=1";
$result = mysqli_query($con,$sel2);
if(empty($_SESSION['exchcode'])||$reset){ $excode="USD"; } else { $excode=$_SESSION['exchcode']; }
$var_currency=""; $i=0;

while ($row=mysqli_fetch_assoc($result))
{
	$var_currency.='<option value="'.$row["code"].'" '; if($row["code"]==$excode){ $var_currency.="selected "; $basevalue=$row["code"];} $var_currency.=">".$row["sign"]."</option>";
	$i++; 
	$var_jsel[]=$row["code"].":".$row["convr"];
}

mysqli_free_result($result);
$jscurrency=" currency_val={".implode(",",$var_jsel)."}; "; 

$sel2 = "SELECT type,name FROM `".$global_notebro_site."`.nomen WHERE type=70 OR type=71";
$result = mysqli_query($con,$sel2);
while ($row=mysqli_fetch_row($result))
{
	if($row[0]==70)
	{ $minconfigprice=($row[1]-10); }

	if($row[0]==71)
	{ $maxconfigprice=($row[1]+10); }
}
mysqli_free_result($result);
mysqli_close ($con);
?>