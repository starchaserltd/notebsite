<?php
$rootpath = realpath($_SERVER["DOCUMENT_ROOT"]).$root_mod;
require_once($rootpath.'/etc/con_db.php');
mysqli_select_db($con,"notebro_site");
//GET currency rates

$sel2 = "SELECT code,convr,sign FROM exchrate";
$result = mysqli_query($con,$sel2);

if(empty($_SESSION['exchcode'])) { $excode="USD"; } else { $excode=$_SESSION['exchcode']; }
$var_currency="";
$i=0;

while ($row=mysqli_fetch_row($result))
{
	$var_currency.="<option value='$row[0]' "; if($row[0]==$excode){ $var_currency.="selected='selected'"; $basevalue=$row[0];} $var_currency.=">".$row[2]."</option>";
	$i++; 
	$var_jsel[]=$row[0].":".$row[1];
}
   
mysqli_free_result($result);

$jscurrency=" currency_val={".implode(",",$var_jsel)."}; "; 
 
$sel2 = "SELECT type,name FROM notebro_site.nomen WHERE type=70 OR type=71";
$result = mysqli_query($con,$sel2);
 while ($row=mysqli_fetch_row($result))
   {
	   if($row[0]==70)
	   { $minconfigprice=($row[1]-10); }
	   
	   	   if($row[0]==71)
		   {	$maxconfigprice=($row[1]+10); }
	   
   }
   mysqli_free_result($result);
 mysqli_close ($con);
 ?>