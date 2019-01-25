<?php
function show_msc($id)
{
	$sel2="SELECT `model`.`msc` as `model_msc`,GROUP_CONCAT(CONCAT(`comments`.`type`,'+-+',`comments`.`comment`) SEPARATOR '+++') as p_model_comment FROM `notebro_db`.`MODEL` model JOIN `notebro_db`.`COMMENTS` comments ON `model`.`p_model`=`comments`.`model` WHERE `model`.`id`=$id LIMIT 1";
	$resu=NULL;
	$rea=mysqli_query($GLOBALS['con'], $sel2);
	if($rea&&mysqli_num_rows($rea)>0)
	{
		$resu=mysqli_fetch_assoc($rea);
		if(isset($resu["p_model_comment"])&&$resu["p_model_comment"]!=NULL&&$resu["p_model_comment"]!=""&&$resu["p_model_comment"]!=" ")
		{
			$p_comments=explode("+++",$resu["p_model_comment"]);
			unset($resu["p_model_comment"]);
			foreach($p_comments as $el)
			{
				$type=explode("+-+",$el);
				$resu["p_model"][$type[0]]=$type[1];
			}
		}
	}
	return $resu;
}
?>