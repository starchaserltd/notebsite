<?php

// col = what to select from table , tab = from what table , id = filter for what id

function show($col, $tab, $id)
{

	$result = mysqli_query($GLOBALS['con'], "SELECT $col FROM $tab WHERE id = '".$id."'"); 
	$item = mysqli_fetch_array($result);
	$item['cap,type,rpm']="";

	if(strcasecmp($item[$col],"Standard")==0)
	{
		$item[$col]="";
	}

	if(!($col<=>"clocks") && substr($item[$col],-1)==='0')
	{ $item[$col]=sprintf('%0.2f',floatval($item[$col])); }

	echo $item[$col];
	if(!($tab<=>"HDD"))
	{
		echo $item['cap']." GB ("; if($item['rpm']>0) echo $item['rpm']."rpm ";
		echo ""; echo $item['type'].")";
	}
}

function showmem($col, $tab, $id)
{
	$result = mysqli_query($GLOBALS['con'], "SELECT $col FROM $tab WHERE id = '".$id."'"); 
	$item = mysqli_fetch_array($result);
	
	echo $item['cap']." GB ";
	echo $item['type']." (";
	echo $item['freq']." MHz)";
}

function showsist($col, $tab, $id)
{
	$result = mysqli_query($GLOBALS['con'], "SELECT $col FROM $tab WHERE id = '".$id."'"); 
	$item = mysqli_fetch_array($result);
	
	echo $item['sist']." ";
	
	if(isset($item['vers']) && $item['vers']!=0 )
	{
		$item['vers']=floatval($item['vers']);
		echo $item['vers']."";
	}

	if($item['type'])
	{
		echo " ";
		echo $item['type']."";
	}
}

function getdetails($id)
{
	$result = mysqli_query($GLOBALS['con'], "SELECT img_1,prod,fam,model FROM notebro_db.MODEL WHERE id = '".$id."'"); 
	$item = mysqli_fetch_array($result);
	
	global $img; global $prod; global $fam; global $model; global $t_img;
	
	$img=$item['img_1'];
	$t_imgpart=explode(".",$img);
	$t_img="t_".$t_imgpart[0].".jpg";
	$prod=$item['prod'];
	$fam=$item['fam'];
	$model=$item['model'];
}



function showprice($tab, $id, $exc)
{ 
	$result = mysqli_query($GLOBALS['cons'], "SELECT price,err FROM ".$tab." WHERE id = '".$id."'"); 
	$item = mysqli_fetch_array($result);
	echo intval(($item['price']-($item['err']/2))*$exc)." - ".intval(($item['price']+($item['err']/2))*$exc); 
}

function showbat($tab, $id, $exc)
{
	$sel="SELECT batlife FROM ".$tab." WHERE id = '".$id."'";
	$result = mysqli_query($GLOBALS['cons'], $sel); 
	$item = mysqli_fetch_array($result);
	// gmdate('H:i', floor(floatval($item['batlife']*0.95) * 3600));
	echo "Estimated battery:";?><br class="sres">  <?php echo round($item['batlife']*0.95,1); echo " - "; echo round($item['batlife']*1.02,1); echo " h";
}
?>