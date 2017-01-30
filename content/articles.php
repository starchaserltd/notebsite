<?php
require_once("../etc/conf.php");
$rootpath = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once($rootpath.$admin_address.'/admin/wp/wp-blog-header.php');
require_once("../etc/session.php");
require_once("../etc/con_db.php");
require_once("lib/php/functions.php");

$wpsite=site_url();

if (have_posts()) :
   while (have_posts()) :
      the_post(); 
   endwhile;
endif;

if(isset($_GET['page'])) { $page=$_GET['page']; } else { $page=1; }

$page--;
$page*=8;

$args = array(
    'offset' => $page,
    'category' => 2,
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
$x = 0;
$category = get_category(2);
$published_posts = $category->category_count;

?>
	
	<div class="row headerback" style="margin-top:5px;margin-right:0px; margin-left:0px;padding-right:0px; background-color:white; font-family:arial">
	
<?php
	
	for ($x = 0; $x <= 7; $x++) 
	{
		if(isset($recent_posts[$x]["ID"]))
		{
			$category = get_the_category( $recent_posts[$x]["ID"] );
			$categorie = $category[0]->cat_name; 

		// ************Get the category*********

			if ($categorie == "Article" && $recent_posts[$x]["ID"]){
?>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="min-height:260px ;display: flex;flex-wrap: wrap;">
			<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5" style="display: flex; align-self: center; justify-content: center;">	
				<a onmousedown="OpenPage('<?php  echo $ad=str_replace($wpsite."/article.php","content/article.php?",get_permalink($recent_posts[$x]["ID"])); ?>',event);" style="cursor: pointer;" >
					<img style="display:block; margin:0 auto; max-width:120px" src="<?php $url = wp_get_attachment_url( get_post_thumbnail_id($recent_posts[$x]["ID"]) ); echo $url;?>" class="img-responsive" alt="Article featured image">
				</a>
			</div>
			<div class="col-md-6 col-sm-7 col-xs-7 col-lg-6" style="font-size:20px; min-width: 170px;">
				<a onmousedown="OpenPage('<?php  echo $ad=str_replace($wpsite."/article.php","content/article.php?",get_permalink($recent_posts[$x]["ID"])); ?>',event);" style=" font-weight:bold;color:#000; text-decoration:none; cursor: pointer;">
				<?php echo $recent_posts[$x]["post_title"];?>
				</a>
				<p style="font-style:italic;font-size:14px;"><?php echo "by "; echo get_userdata($recent_posts[$x]["post_author"])->display_name; echo " - "; echo date( 'd M Y', strtotime( $recent_posts[$x]["post_date"]));?></p>	
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12 review">
				<p>
				<?php echo nobrackets(wp_trim_words($recent_posts[$x]["post_content"], 35, ' ....')); echo "<br>"; ?> 
				</p>
			<!--sfarsit descriere -->
				<a onmousedown="OpenPage('<?php  echo $ad=str_replace($wpsite."/article.php","content/article.php?",get_permalink($recent_posts[$x]["ID"])); ?>',event);" style="cursor: pointer;" ><?php echo "Read more"; ?></a>
			</div>						
		</div>		
	<?php }else {} 
		} 
	}?>		
	<!-- *********************************************************************** -->		
	<!-- Back to Top Button -->
		<span id="top-link-block" class="hidden">
			<a href="#top" style="color:black !important;" class="well well-sm" onclick="$('html,body').animate({scrollTop:0},'slow');return false;">
				<i class="glyphicon glyphicon-chevron-up"></i> Back to Top
			</a>
		</span><!-- /top-link-block -->
			
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
	$count=ceil(get_post_count(2)/8);
	?>
		<div class="col-md-12">
			<ul class="pagination" style="float:right;">
			<li><a onmousedown="OpenPage('content/articles.php?page=1',event);" style="cursor: pointer; color:#000;" >&lt;&lt;</a></li>
			<li><a onmousedown="OpenPage('content/articles.php?page=<?php  $newpage=$page-1; if($newpage<1) {$newpage=1; } echo $newpage;?>',event);" style="color:#000; cursor: pointer;">&lt;</a></li>
	<?php		
		if($count<5)
		{  
			for($i=1;$i<=$count;$i++)
			{
				if($i == $page) { echo '<li><a onmousedown="OpenPage('."'".'content/articles.php?page='.$i."'".',event);" style="color:#000; cursor: pointer;"><b>'.$i.'</b></a></li>'; }
					else 
				{ echo '<li><a onmousedown="OpenPage('."'".'content/articles.php?page='.$i."'".',event);" style="color:#000; cursor: pointer;">'.$i.'</a></li>'; }
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
				if($i == $page) { echo '<li><a onmousedown="OpenPage('."'".'content/articles.php?page='.$i."'".',event);" style="color:#000; cursor: pointer;"><b>'.$i.'</b></a></li>'; }
				else 
				{ echo '<li><a onmousedown="OpenPage('."'".'content/articles.php?page='.$i."'".',event);" style="color:#000; cursor: pointer;">'.$i.'</a></li>'; }
			}
	
		}
	?>			
			<li><a onmousedown="OpenPage('content/articles.php?page=<?php  $newpage=$page+11; if($newpage>$count) {$newpage=$count; } echo $newpage;?>',event);"  style="color:#000; cursor: pointer;">></a></li>
			<li><a onmousedown="OpenPage('content/articles.php?page=<?php echo $count; ?>',event);" style="color:#000; cursor: pointer;" >>></a></li>
			</ul>
		</div>
	<?php //PAGINATION CODE END ?>
	</div>
<script type="text/javascript">
	$(document).ready(function(){
		actbtn("ARTICLES");
	});
	
	// Only enable if the document has a long scroll bar
	// Note the window height + offset
	if ( ($(window).height() + 100) < $(document).height() ) { $('#top-link-block').removeClass('hidden').affix({
        // how far to scroll down before link "slides" into view
        offset: {top:100}
		}); }
</script>
<link rel="stylesheet" href="content/lib/css/article.css" type="text/css"/>