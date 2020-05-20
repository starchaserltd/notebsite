<?php
if(!isset($nb_reviews)) { $nb_reviews=array(); } if(!isset($int_reviews)) { $int_reviews=array(); } if(!isset($nr_nb_reviews)) { $nr_nb_reviews=0; } if(!isset($nr_int_reviews)) { $nr_int_reviews=0; } 

$query=mysqli_query($con,"SELECT * FROM `notebro_db`.`REVIEWS` WHERE valid=1 AND (model_id IN (SELECT `id` FROM `notebro_db`.`MODEL` WHERE `notebro_db`.`MODEL`.`p_model`=".$p_model.") OR `model_id`=".$p_model.")");
while($review=mysqli_fetch_array($query))
{
	$review["notebreview"]=intval($review["notebreview"]);
	if($review["notebreview"]>0)
	{
		$nb_reviews[$nr_nb_reviews]["site"]=$review["site"];
		if(strlen($review["title"])<1){ $review["title"]="Go to review"; } 
		$nb_reviews[$nr_nb_reviews]["title"]=$review["title"];
		$review["link"]=str_replace($web_address."?","",$review["link"]);
		$review["link"]=str_replace("https://noteb.com/?","",$review["link"]);
		$nb_reviews[$nr_nb_reviews]["link"]=$review["link"];
		$nb_reviews[$nr_nb_reviews]["video"]=intval($review["video"]);
		$nb_reviews[$nr_nb_reviews]["notebreview"]=1;
		$nr_nb_reviews++;
	}
	else
	{
		$int_reviews[$nr_int_reviews]["site"]=$review["site"];
		$int_reviews[$nr_int_reviews]["title"]=$review["title"];
		$int_reviews[$nr_int_reviews]["link"]=$review["link"];
		$int_reviews[$nr_int_reviews]["video"]=intval($review["video"]);
		$int_reviews[$nr_int_reviews]["notebreview"]=0;
		$nr_int_reviews++;
	}
}
