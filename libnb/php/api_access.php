<?php
$url = "https://noteb.com/api/webservice.php";

function httpPost($url, $data)
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:60.0) Gecko/20100101 Firefox/60.0');
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($curl, CURLOPT_POSTFIELDS,utf8_encode($data));
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function directPrice($conf,$cons)
{
	$sql="SELECT model FROM `".$GLOBALS['global_notebro_sdb']."`.all_conf WHERE id=".$conf." LIMIT 1";
	$result=mysqli_query($cons,$sql);
	if(isset($result)&&mysqli_num_rows($result)>0)
	{ 
		$sql="SELECT price FROM `".$GLOBALS['global_notebro_sdb']."`.all_conf_".mysqli_fetch_row($result)[0]." WHERE id=".$conf." LIMIT 1";
		$result=mysqli_query($cons,$sql);
		return (mysqli_fetch_row($result)[0]);
	}
}

function curl_erros($res)
{
	echo "<pre>";
	echo "Curl Info<br>".var_dump(curl_getinfo($res)).'<br>';
	echo "Error no".var_dump(curl_errno($res)).'<br>';
	echo "Error".var_dump(curl_error($res)).'<br>';
	echo "</pre>";
}
?>