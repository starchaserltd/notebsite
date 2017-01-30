<?php
$nr = 1;
$nrlinks = 0;
$notereviews=array();
$nrnreviews=0;

show_vars('review_1,review_2,link_1,titlelink_1,link_2,titlelink_2,link_3,titlelink_3,link_4,titlelink_4','MODEL',$idmodel );

$i=0; $j=0; $k=1;
//HERE WE SEARCH FOR REVIEWS ATTACHED TO THE MODEL FROM THE MODEL TABLE
foreach($show_vars as $el)
{
	if($el && $el!="")
	{ 
		if(!($i%2))
		{
			if ($i<4)
			{
				$category = get_the_category( $recent_posts[$el]["ID"] );
				$categorie = $category[0]->cat_name;
				if ($categorie == "Review")
				{
					$url = wp_get_attachment_url( get_post_thumbnail_id($id) ); 				
					$ad=str_replace("admin/wp/article.php","?review/review.php?",get_permalink($id));
					$title = get_the_title($id);
					$notereviews[$nrnreviews] = array($url,$ad,$title,$id);
					$nrnreviews++;
				}
			}
			else
			{
				if($k)
				{ $extreviews[$j]["link"]=$el; $k=0;}
				else
				{ $extreviews[$j]["title"]=$el; $j++; $k=1;}

			}
		}
	}
	$i++;
}
//HERE WE SEARCH THE CMS FOR REVIEWS BASED ON TAGS
$args = array(
	'posts_per_page'   => 5,
	'offset'           => 0,
	'category'         => '1',
	'category_name'    => '',
	'tag_slug__and'    => array($mprod,$mfam,$mmodel),
	'orderby'          => 'date',
	'order'            => 'DESC',
	'include'          => '',
	'exclude'          => '',
	'meta_key'         => '',
	'meta_value'       => '',
	'post_type'        => 'post',
	'post_mime_type'   => '',
	'post_parent'      => '',
	'author'	   => '',
	'author_name'	   => '',
	'post_status'      => 'publish',
	'suppress_filters' => true 
);
$posts_array = get_posts( $args );

foreach($posts_array as $post)
{
	$nogo=0;
	foreach($notereviews as $test)
	{ if(($post->ID)==$test[3]) {$nogo=1;} }
	
	if(!$nogo)
	{
		$id=$post->ID;
		$url = wp_get_attachment_url( get_post_thumbnail_id($id) ); 				
		$ad=str_replace("admin/wp/article.php","?review/review.php?",get_permalink($id));
		$title = get_the_title($id);
		$notereviews[$nrnreviews] = array($url,$ad,$title,$id);
		$nrnreviews++;
	}
}

?>