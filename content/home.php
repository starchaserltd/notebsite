
<?php
require_once("../etc/conf.php");

if (!isset($_SERVER['HTTP_REFERER']) || stripos($_SERVER['HTTP_REFERER'],$site_name) ==FALSE) 
{	$actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	header("Location: http://".str_replace(($site_name."/"),($site_name."/?"),$actual_link)."");
	die();
}
$rootpath = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once($rootpath.$admin_address.'/wp/wp-blog-header.php');
require_once("../etc/con_db.php");
require_once("lib/php/functions.php");

$wpsite=site_url();

if (have_posts()) :
   while (have_posts()) : 
      the_post();
	 	 
   endwhile;
endif;

global $post;
$args = array( 'posts_per_page' => -1 );
$myposts = get_posts( $args );
echo get_the_title(2); 

$args = array(
    'numberposts' => -1,
    'offset' => 0,
    'category' => 0,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'include' => '',
    'exclude' => '',
	'post_excerpt' => 10,
    'meta_key' => '',
    'meta_value' => '',
    'post_type' => 'post',
    'post_status' => 'publish',
    'suppress_filters' => true );
	
$recent_posts = wp_get_recent_posts( $args, ARRAY_A );
$category = get_category(2);
$count_posts = wp_count_posts();//echo $count_posts;
$published_posts = $count_posts->publish;	

?>	

<link rel="stylesheet" href="content/lib/css/home.css" type="text/css"/>	
    <script>$.getScript("content/lib/js/home.js");</script>
		<!-- featured area -->
		<div class="col-md-8 col-sm-12 col-xs-12" style="position:relative; float: left; padding:0px;">
			<!-- featured element 1 -->
			<div class="col-md-12 col-sm-12 col-xs-12" style="padding:0px;">
				<a onmousedown="OpenPage('<?php
				$category = get_the_category( $recent_posts[0]["ID"] );
				$categorie = $category[0]->cat_name; 				
				if ($categorie == "Article"){echo $ad=str_replace($wpsite."/article.php/article/","content/article.php?/",str_replace("","",get_permalink($recent_posts[0]["ID"])));}
				else 
					if ($categorie == "Review") {echo $ad=str_replace($wpsite."/article.php/review/","content/review.php?/",get_permalink($recent_posts[0]["ID"]));}
					else {echo "Not Article or Review";} 
					?>',event);" style="cursor: pointer;">
					<?php $url = str_replace($wp_address.$wp_rmimg,$new_wp_address,wp_get_attachment_url( get_post_thumbnail_id($recent_posts[0]["ID"]) )); ?> 
				<div class="imgcrop" style="float:left; position:relative; height:130px; width:100%;">
					<img src="<?php echo $url;?>" class="portrait crop1" alt="Image">
					<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" style="bottom:2px; position:absolute;padding:0px">
						<div class="col-md-12 col-sm-12 col-xs-12 widget1-title2"><?php echo $recent_posts[0]["post_title"]; ?></div>
						<div class="col-md-12 col-sm-12 col-xs-12 widget1-title1">
						<?php 
						$review = nobrackets($recent_posts[0]["post_excerpt"]);
						echo wp_trim_words($review, 5, '');
					?></div>	
					</div>
				</div>
				</a>			
			</div>
			<!-- featured element 2 -->
			<div class="col-md-4 col-sm-12 col-xs-12" style="padding:5px 3px 0px 0px;">
				<a onmousedown="OpenPage('<?php 
				$category = get_the_category( $recent_posts[1]["ID"] );
				$categorie = $category[0]->cat_name; 
				if ($categorie == "Article"){echo $ad=str_replace($wpsite."/article.php/article/","content/article.php?/",get_permalink($recent_posts[1]["ID"]));}
				else 
					if ($categorie == "Review") {echo $ad=str_replace($wpsite."/article.php/review/","content/review.php?/",get_permalink($recent_posts[1]["ID"]));}
					else {echo "Not Article or Review";}
					?>',event);" style="cursor: pointer;">
					<?php $url = str_replace($wp_address.$wp_rmimg,$new_wp_address,wp_get_attachment_url( get_post_thumbnail_id($recent_posts[1]["ID"]) )); ?>
				<div class="imgcrop" style="height:250px; float: left; width:100%;">
					<img src="<?php echo $url;?>" class="portrait crop2" alt="Image">
					<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12" style="bottom:2px; position:absolute;padding:0px">
						<div class="col-md-12 col-sm-12 col-xs-12 widget2-title2"><?php echo $recent_posts[1]["post_title"]; ?></div>
						<div class="col-md-12 col-sm-12 col-xs-12 widget2-title1">
						<?php 
						$review = nobrackets($recent_posts[1]["post_excerpt"]);
						echo wp_trim_words($review, 5, '');
						?></div>
					</div>
				</div>
				</a>			
			</div>	
			<!-- featured element 3 -->
			<div class="col-md-8 col-sm-12 col-xs-12 " style="padding:5px 0px 3px 3px;">
				<a onmousedown="OpenPage('<?php   
				$category = get_the_category( $recent_posts[2]["ID"] );
				$categorie = $category[0]->cat_name; 
				if ($categorie == "Article"){echo $ad=str_replace($wpsite."/article.php/article/","content/article.php?/",get_permalink($recent_posts[2]["ID"]));}
				else 
					if ($categorie == "Review") {echo $ad=str_replace($wpsite."/article.php/review/","content/review.php?/",get_permalink($recent_posts[2]["ID"]));}
					else {echo "Not Article or Review";}
					?>',event);" style="cursor: pointer;">
					<?php $url = str_replace($wp_address.$wp_rmimg,$new_wp_address,wp_get_attachment_url( get_post_thumbnail_id($recent_posts[2]["ID"]) )); ?>
				<div class="imgcrop" style="height:120px; position:relative; float: left; width:100%;">
					<img src="<?php echo $url;?>" class="portrait crop3" alt="Image">
					<div class="col-md-12" style="bottom:2px; position:absolute;padding:0px;">
						<div class="col-md-12 col-sm-12 col-xs-12 widget3-title2"><?php echo $recent_posts[2]["post_title"]; ?></div>
						<div class="col-md-12 col-sm-12 col-xs-12 widget3-title1">
						<?php 
						$review = nobrackets($recent_posts[2]["post_excerpt"]);
						echo wp_trim_words($review, 5, '');
						?></div>
					</div>
				</div>
				</a>			
			</div>
			<!-- featured element 4 -->
			<div class="col-md-4 col-sm-6 col-xs-6" style="padding:3px 3px 6px 3px;">
				<a onmousedown="OpenPage('<?php    
				$category = get_the_category( $recent_posts[3]["ID"] );
				$categorie = $category[0]->cat_name; 
				if ($categorie == "Article"){echo $ad=str_replace($wpsite."/article.php/article/","content/article.php?/",get_permalink($recent_posts[3]["ID"]));}
				else 
					if ($categorie == "Review") {echo $ad=str_replace($wpsite."/article.php/review/","content/review.php?/",get_permalink($recent_posts[3]["ID"]));}
					else {echo "Not Article or Review";}
					?>',event);" style="cursor: pointer;">
					<?php $url = str_replace($wp_address.$wp_rmimg,$new_wp_address,wp_get_attachment_url( get_post_thumbnail_id($recent_posts[3]["ID"]) )); ?>
				<div class="imgcrop" style="height:126px; position:relative; float: left; width:100%;">
					<img src="<?php echo $url;?>" class="portrait crop4" alt="Image">
					<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" style="bottom:2px; position:absolute;padding:0px;">
						<div class="col-md-12 col-sm-12 col-xs-12 widget4-title1" ><?php echo $recent_posts[3]["post_title"]; ?></div>
						<div class="col-md-12 col-sm-12 col-xs-12 widget6-title2">
						<?php 
						$review = nobrackets($recent_posts[3]["post_excerpt"]);
						echo wp_trim_words($review, 5, '');
						?></div>
					</div>
				</div>	
				</a>
			</div>
			<!-- featured element 5 -->
			<div class="col-md-4 col-sm-6 col-xs-6" style="padding:3px 0px 6px 3px">
				<a onmousedown="OpenPage('<?php  
				$category = get_the_category( $recent_posts[4]["ID"] );
				$categorie = $category[0]->cat_name; 
				if ($categorie == "Article"){echo $ad=str_replace($wpsite."/article.php/article/","content/article.php?/",get_permalink($recent_posts[4]["ID"]));}
				else 
					if ($categorie == "Review") {echo $ad=str_replace($wpsite."/article.php/review/","content/review.php?/",get_permalink($recent_posts[4]["ID"]));}
					else {echo "Not Article or Review";}				
					?>',event);" style="cursor: pointer;"> 
					<?php $url = str_replace($wp_address.$wp_rmimg,$new_wp_address,wp_get_attachment_url( get_post_thumbnail_id($recent_posts[4]["ID"]) )); ?>
				<div class="imgcrop" style="height:126px; position:relative; float: left; width:100%;">
					<img src="<?php echo $url; ?>" class="portrait crop5" alt="Image">
					<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="bottom:2px; position:absolute;padding:0px;">
						<div class="col-md-12 col-sm-12 col-xs-12 widget5-title1"><?php echo $recent_posts[4]["post_title"]; ?></div>
						<div class="col-md-12 col-sm-12 col-xs-12 widget7-title2">
						<?php 
						$review = nobrackets($recent_posts[4]["post_excerpt"]);
						echo wp_trim_words($review, 5, ''); 
						?></div>
					</div>
				</div>
				</a>
			</div>		
		
		</div>
		
		<!-- Noteb Quiz -->
		<div id="quiz" class="col-md-4 col-sm-12 col-xs-12 col-sm-12" style="float:right; position:relative; padding:0px 0px 0px 5px !important; min-height:248px;"></div>
		
	<?php 	
	$y = 5;
	for ($y = 5; $y < 16; $y++) { 
		if(isset($recent_posts[$y]["ID"]))
		{
			$category = get_the_category( $recent_posts[$y]["ID"] ); 
			$categorie = $category[0]->cat_name; 
			if ($categorie == "Article") {$linkart=str_replace($wpsite."/article.php/article/","content/article.php?/",get_permalink($recent_posts[$y]["ID"]));}
			else {$linkart=str_replace($wpsite."/article.php/review/","content/review.php?/",get_permalink($recent_posts[$y]["ID"]));}
			
			if  (empty($recent_posts[$y]["post_content"])){}
			else 
			{
	?>
	
	<!-- articles & reviews -->

		<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 latest2">
			<div class="col-md-4 col-lg-3 col-sm-4 col-xs-4 latest3">
				<a onmousedown="OpenPage('<?php echo $linkart;?>',event);" >	
				<img style="display:block; margin:0 auto;" src="<?php $url = str_replace($wp_address.$wp_rmimg,$new_wp_address,wp_get_attachment_url( get_post_thumbnail_id($recent_posts[$y]["ID"]) )); echo $url;?>" class="img-responsive" alt="Image">
				</a>
			</div>
			
			
			<div class="col-md-8 col-lg-9 col-sm-8 col-xs-9 latest4">
				<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
					<?php echo $categorie;?>
					<br>
					<a onmousedown="OpenPage('<?php echo $linkart;?>',event);"><?php echo $recent_posts[$y]["post_title"];  ?></a>
					<br><br>
					<?php 
						$review = nobrackets($recent_posts[$y]["post_content"]);
						echo wp_trim_words($review, 35, ' ....');
					?>
					<a class="rmore" onmousedown="OpenPage('<?php echo $linkart;?>',event);"><br><?php echo "Read more";?> </a>
				</div>
				
				<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
					<?php  echo "<br>"; echo "by "; echo get_userdata($recent_posts[$y]["post_author"])->display_name; echo " - "; echo date( 'd M Y', strtotime( $recent_posts[$y]["post_date"]));?>
				</div>
			</div>
		</div>
		
	<?php 	} 
		} 
	} ?>