<?php
require_once("../etc/conf.php");
if ((!isset($_SERVER['HTTP_REFERER']) || stripos($_SERVER['HTTP_REFERER'],$site_name) ==FALSE)) 
{	$actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	header("Location: ".$port_type."://".str_replace($site_name."/",$site_name."/?",$actual_link)."");
	die();
}

$rootpath = realpath($_SERVER["DOCUMENT_ROOT"]).$root_mod;
require_once($rootpath.$admin_address.'/wp/wp-blog-header.php');
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
	
	<div class="row headerback" style="margin-left:0px;background-color:white;">
	<article style="display: -webkit-box;    display: -ms-flexbox;    display: flex;    -webkit-box-orient: horizontal;
    -webkit-box-direction: normal;-ms-flex-direction: row; flex-direction: row; -ms-flex-wrap: wrap;
        flex-wrap: wrap;" class="col-xs-12">
        <div class="row displayFlex">

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
		<div class="col-xs-12 col-lg-6 col-sm-6">
			<div class="row">
				<div class="col-lg-5 col-md-4 col-sm-6 col-xs-12 centerImgFlex">	
					<a onmousedown="OpenPage('<?php  echo $ad=str_replace($wpsite."/article.php/article/","content/article.php?/",get_permalink($recent_posts[$x]["ID"])); ?>',event);" style="cursor: pointer;" >
						<img style="display:block; margin:15px auto;" src="<?php $url = str_replace($wp_address.$wp_rmimg,$new_wp_address,wp_get_attachment_url( get_post_thumbnail_id($recent_posts[$x]["ID"]) )); echo $url;?>" class="img-responsive img-fluid" alt="Article featured image">
					</a>
				</div>
				<div class="col-md-8 col-sm-6 col-xs-12 col-lg-7" style="font-size:20px; min-width: 170px;">
					<a onmousedown="OpenPage('<?php  echo $ad=str_replace($wpsite."/article.php/article/","content/article.php?/",get_permalink($recent_posts[$x]["ID"])); ?>',event);" style=" font-weight:bold;color:#000; text-decoration:none; cursor: pointer;">
					<?php echo $recent_posts[$x]["post_title"];?>
					</a>
					<p style="font-style:italic;font-size:14px;"><?php echo "by "; echo get_userdata($recent_posts[$x]["post_author"])->display_name; echo " - "; echo date( 'd M Y', strtotime( $recent_posts[$x]["post_date"]));?></p>	
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 review">
					<p>
					<?php echo nobrackets(wp_trim_words($recent_posts[$x]["post_content"], 35, ' ....')); echo "<br>"; ?> 
					</p>
				<!--sfarsit descriere -->
					<a onmousedown="OpenPage('<?php  echo $ad=str_replace($wpsite."/article.php/article/","content/article.php?/",get_permalink($recent_posts[$x]["ID"])); ?>',event);" style="cursor: pointer;" ><?php echo "Read more"; ?></a>
				</div>		
			</div>				
		 </div>		
	<?php }else {} 
		} 
	}?>		
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
	$count=ceil(get_post_count(2)/8);
	?>
		</article>	
</div>
		<div class="col-md-12">
			<ul class="pagination" style="float:right;">
			<li class="page-item"><a class="page-link" onmousedown="OpenPage('content/articles.php?page=1',event);" style="cursor: pointer; color:#000;" >&lt;&lt;</a></li>
			<li class="page-item"><a class="page-link"  onmousedown="OpenPage('content/articles.php?page=<?php  $newpage=$page-1; if($newpage<1) {$newpage=1; } echo $newpage;?>',event);" style="color:#000; cursor: pointer;">&lt;</a></li>
	<?php		
		if($count<5)
		{  
			for($i=1;$i<=$count;$i++)
			{
				if($i == $page) { echo '<li  class="page-item"><a class="page-link" onmousedown="OpenPage('."'".'content/articles.php?page='.$i."'".',event);" style="color:#000; cursor: pointer;"><b>'.$i.'</b></a></li>'; }
					else 
				{ echo '<li class="page-item"><a class="page-link" onmousedown="OpenPage('."'".'content/articles.php?page='.$i."'".',event);" style="color:#000; cursor: pointer;">'.$i.'</a></li>'; }
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
				if($i == $page) { echo '<li  class="page-item"><a class="page-link" onmousedown="OpenPage('."'".'content/articles.php?page='.$i."'".',event);" style="color:#000; cursor: pointer;"><b>'.$i.'</b></a></li>'; }
				else 
				{ echo '<li  class="page-item"><a class="page-link" onmousedown="OpenPage('."'".'content/articles.php?page='.$i."'".',event);" style="color:#000; cursor: pointer;">'.$i.'</a></li>'; }
			}
	
		}
	?>			
			<li  class="page-item"><a class="page-link" onmousedown="OpenPage('content/articles.php?page=<?php  $newpage=$page+11; if($newpage>$count) {$newpage=$count; } echo $newpage;?>',event);"  style="color:#000; cursor: pointer;">></a></li>
			<li  class="page-item"><a class="page-link" onmousedown="OpenPage('content/articles.php?page=<?php echo $count; ?>',event);" style="color:#000; cursor: pointer;" >>></a></li>
			</ul>
		</div>
	<?php //PAGINATION CODE END ?>

<script type="text/javascript">
	$(document).ready(function(){
		actbtn("ARTICLES"); metakeys("noteb,laptop,articles");
		document.title = "Noteb - Articles";
		$('meta[name=description]').attr('content', "Laptop articles. Video cards: features and gimmicks (2016), System memory: the basics.");
	});
</script>
<link rel="stylesheet" href="content/lib/css/article.css?v=0.5" type="text/css" />
<?php include_once("../etc/scripts_pages.php"); ?>