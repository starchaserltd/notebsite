<?php
if(!(isset($include_aff_gen)&&$include_aff_gen==true)){$function_replay=false; $include_aff_gen=false; require_once("../../etc/con_db.php");}
//$_POST["usertag"]=$_GET["usertag"];
//$_POST["links"]=$_GET["links"];
//$_POST["sellers"]=$_GET["sellers"];
$usertag=null; $go=0; $function_replay=json_encode([null,"Something went terribly wrong!"]);
if(isset($_POST["usertag"])&&$_POST["usertag"]!=""&&$_POST["usertag"]!=null)
{ $usertag=mysqli_real_escape_string($con,trim(strip_tags($_POST["usertag"]))); if($usertag!="noref"){ $go++; }else{$function_replay=json_encode([null,"Standard link, referral set to none."]);} }

$links_list=null; $sellerid_list=array();
/* --- unchanged seller‐id block --- */

if(isset($_POST["links"])&&$_POST["links"]!=""&&$_POST["links"]!=null)
{ 
	$links_list=array(); $unmatched_links=array();
	if(!is_array($_POST["links"])){$_POST["links"]=[0=>$_POST["links"]];}
	$_POST["links"]=array_map(static fn($v)=>trim(strip_tags($v)),$_POST["links"]);              // ← swap for filter_var_array
	foreach($_POST["links"] as $key=>$val)
	{ 
		$key=intval($key);
		$links_list[$key]=mysqli_real_escape_string($con,trim(strip_tags($val)));                // ← swap inside loop
		if(isset($sellerid_list[0])){ if(stripos($links_list[$key],$sellerid_list[$key]["website"])===FALSE){ $unmatched_links[$key]=$links_list[$key];}}
	}
	if(!isset($sellerid_list[0])){ $sellerid_list=get_link_sellerid($links_list,null,$con); }
	if(isset($unmatched_links[0])){ $rematch_links=get_link_sellerid($unmatched_links,null,$con); $i=0; foreach($unmatched_links as $key=>$val){$sellerid_list[$key]=$rematch_links[$i]; $i++;}}
	$go++;
}

function get_link_sellerid($links,$id_list,$con)
{
	$query="";
	
	if($id_list)
	{
		if(!is_array($id_list)){$newarray=array(); $newarray[0]=$id_list; $id_list=$newarray;}
		foreach($id_list as $id)
		{ $query.="SELECT `id`,`name`,`tag_name`,`first_tag`,`website`,`end_tag`,`encoded` FROM `".$GLOBALS['global_notebro_buy']."`.`SELLERS` WHERE `SELLERS`.`id`=".$id." LIMIT 1; "; }
	}
	elseif($links)
	{
		if(!is_array($links)){$newarray=array(); $newarray[0]=$links; $links=$newlinks;}
		foreach($links as $link)
		{ $query.="SELECT `id`,`name`,`tag_name`,`first_tag`,`website`,`end_tag`,`encoded` FROM `".$GLOBALS['global_notebro_buy']."`.`SELLERS` WHERE '".substr($link,0,50)."' LIKE CONCAT('%',website,'%') LIMIT 1; "; }
	}
	
	if($query!=="")
	{
		$l_count=0; $row=array();
		if(mysqli_multi_query($con,$query))
		{
			do
			{
				if($result=mysqli_store_result($con))
				{ $row[$l_count]=mysqli_fetch_assoc($result); }
				else { $row[$l_count]=null; }
				$l_count++;
				mysqli_free_result($result);
				
			}
			while(mysqli_next_result($con));
		}

		if(count($row)>0){ return $row; }
		else{ return null; }
	}
	else
	{ return null; }
}

if(isset($usertag)&&$usertag!=""&&$usertag!="noref")
{
	$result=mysqli_query($con,"SELECT * FROM `".$GLOBALS['global_notebro_buy']."`.`TAGS` WHERE usertag='".$usertag."' LIMIT 1");
	if(!($result && mysqli_num_rows($result)>0)){ $usertag=""; }
	else
	{ $row=mysqli_fetch_array($result); $tags=json_decode($row[2],true); $ref_only=intval($row[3]); }
}

if($go>1)
{
	if(!(isset($tags)&&count($tags)>0))
	{
		$tags=array(); $query="SELECT * FROM `".$GLOBALS['global_notebro_buy']."`.`TAGS` WHERE usertag='".$usertag."' LIMIT 1";
		$tags=mysqli_query($con,$query);
		if($result&&mysqli_num_rows($result)>0)
		{ $row=mysqli_fetch_assoc($result); $tags=json_decode($row["tags"],true); }
		else
		{ unset($tags); }
	}

	$new_links=array();
	if(isset($tags)&&count($tags)>0)
	{
		foreach($tags as $val_k){ foreach($val_k as $key=>$val){ $tags[$key]=$val; } }
		foreach($links_list as $key=>$link)
		{
			$tag=""; $first_tag=""; $end_tag="";
			if(isset($sellerid_list[$key])&&$sellerid_list[$key]!=null&&isset($tags[$sellerid_list[$key]["name"]]))
			{
				$seller_info=$sellerid_list[$key];
				if(isset($seller_info["name"])&&$seller_info["first_tag"]!=""&&$seller_info["first_tag"]!=NULL){ $first_tag=str_replace("tagname",$tags[$seller_info["name"]],$seller_info["first_tag"]); } 
				if(isset($seller_info["name"])&&$seller_info["tag_name"]!=""&&$seller_info["tag_name"]!=NULL){ $tag=$seller_info["tag_name"].$tags[$seller_info["name"]];}
				if($first_tag!==""){ $link=urldecode($link); if(intval($seller_info["encoded"])==1){ $link=urlencode($link); $tag=urlencode($tag);} }
				if(isset($seller_info["name"])&&$seller_info["end_tag"]!=""&&$seller_info["end_tag"]!=NULL){ $end_tag=$seller_info["end_tag"]; } 
				$new_links[$key]=$first_tag.$link.$tag.$end_tag;
			}
			else
			{ $new_links[$key]=$link; }
		}
		$function_replay=json_encode($new_links);
	}
	else
	{ $function_replay=json_encode([null,"Wrong referal name!"]); }
}
else
{ if($usertag!="noref"){$function_replay=json_encode([null,"Bad supplied parameters!"]); } }

if(!$include_aff_gen){ mysqli_close($con); echo $function_replay; }
?>