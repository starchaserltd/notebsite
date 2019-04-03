<?php
if(isset($_GET['id'])){ $id=filter_var($_GET['id'], FILTER_VALIDATE_INT); if($id===FALSE){ $id=-1; } } else { $id=-1;}

if($id>=0)
{
	require("../../../../etc/con_db.php");
	mysqli_select_db($con,"notebro_db");
	
	function show_vars($col, $tab, $id)
	{
		if(stripos($tab,"JOIN")!==FALSE)
		{ $sel2="SELECT $col FROM $tab WHERE model.id = $id LIMIT 1"; }
		else
		{ $sel2="SELECT $col FROM $tab WHERE id = $id LIMIT 1"; }

		$rea=mysqli_query($GLOBALS['con'], $sel2);
		if($rea&&mysqli_num_rows($rea)>0)
		{
			$resu=mysqli_fetch_assoc($rea);
			
			global $show_vars;
			$show_vars=$resu;
			$col=explode(",",$col); $nrcol=count($col);
			if($nrcol>1)
			{ return $resu; }
			else
			{ return $resu[$col[0]]; }
		}
		else { return false; }
	}

	$_SESSION['model']=$id; $model_data=show_vars('model.prod, families.fam, families.subfam, families.showsubfam, model.model, model.submodel, model.regions, model.keywords, model.msc', 'notebro_db.MODEL model JOIN notebro_db.FAMILIES families ON model.idfam=families.id',$id);
	if($model_data)
	{
		if(isset($model_data["submodel"])&&($model_data["submodel"]=="NULL"||$model_data["submodel"]==NULL)){$model_data["submodel"]="";}
		if(isset($model_data["subfam"])&&$model_data["showsubfam"]!=0){ $model_data["subfam"]=" ".$model_data["subfam"]; } else { $model_data["subfam"]=""; } unset($model_data["showsubfam"]);
		$model_data['regionsid']=explode(",",$model_data['regions']); if(array_search("1",$model_data['regionsid'])===FALSE){ $model_data['region']=" (".show_vars("disp","REGIONS",intval($model_data['regions'][0])).")"; } else { $model_data['region']=""; $model_data['regions']=0; }
	}
	print json_encode($model_data);
	mysqli_close($con);
}
else
{ header('X-PHP-Response-Code: 204', true, 204); }
?>