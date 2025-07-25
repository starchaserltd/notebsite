<?php
require_once("../etc/conf.php");
if (!isset($_SERVER['HTTP_REFERER']) || stripos($_SERVER['HTTP_REFERER'],$site_name) ==FALSE) 
{	$actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	header("Location: ".$port_type."://".str_replace($site_name."/",$site_name."/?",$actual_link)."");
	die();
}
$rootpath = realpath($_SERVER["DOCUMENT_ROOT"]).$root_mod;
require_once($rootpath.$wp_install_address.'/wp/wp-blog-header.php');
require_once("../etc/con_db.php");
require_once("lib/php/functions.php");

$wpsite=site_url();

if (have_posts()) :
   while (have_posts()) :
      the_post(); 
   endwhile;
endif;

if(isset($_GET['page'])) { $page=intval($_GET['page']); } else { $page=1; }
$page--;
$page*=8;

$args = array(
    'offset' => $page,
    'category' => 1,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'include' => '',
    'exclude' => '',
	'post_excerpt' => 5,
    'meta_key' => '',
    'meta_value' => '',
    'post_type' => 'post',
    'post_status' => 'publish',
    'suppress_filters' => true );
	
$recent_posts = wp_get_recent_posts( $args, ARRAY_A );
$x = 0; $javavar=1;
$category = get_category(2);
$published_posts = $category->category_count;
?>
<script type="text/javascript">var review_metatitle_part="";</script>
<div class="container-fluid headerback" style="margin-right:0px;padding-right: 0px;">
  <div class="row">
	<div class="col-md-12 col-sm-12" style="background-color:white; font-family:arial">
<?php
	for ($x = 0; $x <= 7; $x++)
	{
		if(isset($recent_posts[$x]["ID"]))
		{
			$category = get_the_category( $recent_posts[$x]["ID"] );
			$categorie = $category[0]->cat_name; 

			// ************Get the category*********

			if ($categorie == "Review" && $recent_posts[$x]["ID"]){

?>
		<!--Review Title -->
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12" style="font-size:20px; padding-top:20px;">
				<a onmousedown="OpenPage('<?php  echo $ad=str_replace($wpsite."/article.php/review/","content/review.php?/",get_permalink($recent_posts[$x]["ID"])); ?>',event);" style="font-weight:bold;color:#000; text-decoration:none; cursor: pointer;">
				<?php echo $recent_posts[$x]["post_title"];?>
				</a>
			</div>
		</div>
		<div class="row" style="padding-bottom:5px;">	
			<!--Review Picture -->
			<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
				<a onmousedown="OpenPage('<?php  echo $ad=str_replace($wpsite."/article.php/review/","content/review.php?/",get_permalink($recent_posts[$x]["ID"])); ?>',event);" style="cursor: pointer;">
					
						<img src="<?php $url = str_replace(array_map(fn($u) => $u . $wp_rmimg, $wp_urls), $new_wp_address,wp_get_attachment_url( get_post_thumbnail_id($recent_posts[$x]["ID"]) )); echo $url;?>" class="img-responsive img-fluid" alt="Review featured image">
					
				</a>
			</div>
			
			<!--Review Description -->
			<div class="col-lg-7 col-md-9 col-sm-8 col-xs-12 review">
				<p style="font-style:italic;"><?php echo "by "; echo get_userdata($recent_posts[$x]["post_author"])->display_name; echo " - "; echo date( 'd M Y', strtotime( $recent_posts[$x]["post_date"]));?></p>
				<p>	<?php 	
				$test_review = nobrackets($recent_posts[$x]["post_content"]);
				echo wp_trim_words($test_review, 40, ' ...');	?>
				</p>
				<a onmousedown="OpenPage('<?php  echo $ad=str_replace($wpsite."/article.php/review/","content/review.php?/",get_permalink($recent_posts[$x]["ID"])); ?>',event);" style="cursor: pointer;"><?php echo "Read more"; ?></a>   
			</div>	
		</div>	
		<hr style="height:2px; color:#ededed;">
	<?php }	else {} 
		if($javavar){echo '<script type="text/javascript">review_metatitle_part="'.$recent_posts[$x]["post_title"].'";</script>'; $javava=0; }
		}
	} ?>		
	</div>
  </div>
</div>		
	<?php
		//PAGINATION CODE START
		function get_post_count($cat) {
			global $wpdb;
			$post_count = 0;
			$querystr = "
				SELECT count
				FROM $wpdb->term_taxonomy, $wpdb->posts, $wpdb->term_relationships
				WHERE $wpdb->posts.ID = $wpdb->term_relationships.object_id
				AND $wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id
				AND $wpdb->term_taxonomy.term_id = $cat
				AND $wpdb->posts.post_status = 'publish'
			";
			$result = $wpdb->get_var($querystr);
			$post_count += $result;
		return $post_count;  
		}
	$absolute_url="";
	$page/=8;
	$page++;
	$count=ceil(get_post_count(1)/8);
	?>

	<div class="col-md-12">
		<ul class="pagination" style="float:right;">
		<li class="page-item"><a class="page-link" onmousedown="OpenPage('content/reviews.php?page=1',event);" style="color:#000; cursor: pointer;" >&lt;&lt;</a></li>
		<li class="page-item"><a class="page-link" onmousedown="OpenPage('content/reviews.php?page=<?php  $newpage=$page-1; if($newpage<1) {$newpage=1; } echo $newpage;?>',event);"  style="color:#000; cursor: pointer;">&lt;</a></li>
  
	<?php		
		if($count<5)
		{
			for($i=1;$i<=$count;$i++)
			{
				if($i == $page) { echo '<li class="page-item"><a class="page-link" onmousedown="OpenPage('."'".'content/reviews.php?page='.$i."'".',event);" style="color:#000; cursor: pointer;"><b>'.$i.'</b></a></li>'; } 
				else 
				{ echo '<li class="page-item"><a class="page-link" onmousedown="OpenPage('."'".'content/reviews.php?page='.$i."'".',event);" style="color:#000; cursor: pointer;">'.$i.'</a></li>'; }
			}
		}
		else
		{
			$limit=$page+2;
			$min=$page-2;
			
			if($limit>$count)
			{ $limit=$count; }

			if($min<1)
			{$min=1; }
			
			for($i=$min;$i<=$limit;$i++)
			{ 
				if($i == $page) { echo '<li class="page-item"><a class="page-link" onmousedown="OpenPage('."'".'content/reviews.php?page='.$i."'".',event);" style="color:#000; cursor: pointer;"><b>'.$i.'</b></a></li>'; }
				else 
				{ echo '<li class="page-item"><a class="page-link" onmousedown="OpenPage('."'".'content/reviews.php?page='.$i."'".',event);" style="color:#000; cursor: pointer;">'.$i.'</a></li>'; }
			}
	
		}
	?>			
		<li class="page-item"><a class="page-link"onmousedown="OpenPage('content/reviews.php?page=<?php  $newpage=$page+11; if($newpage>$count) {$newpage=$count; } echo $newpage;?>',event);"  style="color:#000; cursor: pointer;">></a></li>
		<li class="page-item"><a class="page-link" onmousedown="OpenPage('content/reviews.php?page=<?php echo $count; ?>',event);" style="color:#000; cursor: pointer;" >>></a></li>
		</ul>
	</div>
	<?php //PAGINATION CODE END ?>
	
		
	

<script type="text/javascript">
	$(document).ready(function(){
		actbtn("REVIEWS");
		document.title = "Noteb - Reviews";
		$('meta[name=description]').attr('content', "Laptop reviews. "+review_metatitle_part+" ");
	});
	
	// Only enable if the document has a long scroll bar
	// Note the window height + offset
	// if ( ($(window).height() + 100) < $(document).height() ) { $('#top-link-block').removeClass('hidden').affix({ offset: {top:100} }); }
</script>
<link rel="stylesheet" href="content/lib/css/article.css" type="text/css"/>
<?php include_once("../etc/scripts_pages.php"); ?>