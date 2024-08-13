<?php
require_once("../etc/conf.php");
/*
if (!isset($_SERVER['HTTP_REFERER']) || stripos($_SERVER['HTTP_REFERER'],$site_name) ==FALSE) 
{	$actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	header("Location: ".$port_type."://".str_replace(($site_name."/"),($site_name."/?"),$actual_link)."");
	die();
}*/
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
try {	
$recent_posts = wp_get_recent_posts( $args, ARRAY_A );
$category = get_category(2);
$count_posts = wp_count_posts();//echo $count_posts;
$published_posts = $count_posts->publish;	
} catch (Exception $e) {
    echo 'Could not get articles data from the CMS: ',  $e->getMessage(), "\n";
}
?>
<link rel="stylesheet" href="content/lib/css/home.css?v=0.48" type="text/css"/>
<script>$.getScript("content/lib/js/home.js?v=0.21", function() {  }); document.title = "Noteb - Search, Compare and Find the Best Laptop for You";$(document).ready(function(){
    $('meta[name=description]').attr('content', "Looking for a laptop? Search, Compare or even take a Quiz with Noteb.com to find the perfect laptop for your work, home or suggest one to your friends from over 6.000.000 configurations derived from over 900 models.");
    $('head').append('<link rel="alternate" hreflang="en-US" href="https://noteb.com" />');
});</script>
	
	<!-- Noteb Quiz -->
	<link rel="stylesheet" href="search/quiz/lib/css/quiz.css?v=0.34" type="text/css"/>
	<div class="col-md-12 col-lg-12 col-12 col-sm-12 quizDisplay" style="padding:0px;">
		<div id="quiz" class="col-md-12 col-lg-12 col-12 col-sm-12" style="position:relative;"></div>	
	</div>			

	<!-- Noteb Quiz end -->
	<div class="clearfix"></div>
	
	<!-- Top 10 laptops area -->
	<link rel="stylesheet" href="content/lib/css/infoarea.css?v=0.01" type="text/css"/>
	<?php
	try {
    $query = mysqli_query($con, "SELECT * FROM notebro_site.top_laptops WHERE valid=1 ORDER BY TYPE,ORD ASC,PRICE");
    // Initialising arrays for the laptop tops
    $tops = array();
    $topshead = array();
    //Populating the tops array with query data
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            if (!isset($tops[$row['type']])) {
                // Adauga datele laptopului in array-ul corespunzator tipului
                $tops[$row['type']] = array(
                    'id' => $row['c_id'],
                    'img' => $row['img'],
                    'name' => $row['name'],
                    'price' => $row['price'],
                    'min_price' => $row['min_price'],
                    'max_price' => $row['max_price'],
                    'price_range' => intval($row['price_range'])
                );
            }
        }
        mysqli_free_result($query);
    }
} catch (Exception $e) {
    echo 'Could not get information on laptop tops ',  $e->getMessage(), "\n";
}
	?>
	<!-- Info area start --!>
	<div class="main-container">
		<div class="info-container">
			<h1>Noteb data</h1>
			<div class="info-item">
				<i class="fas fa-calendar-alt"></i>
				<p><span>Last updated:</span> <span class="value" id="latest-update"></span></p>
			</div>
			<div class="info-item">
				<i class="fas fa-store"></i>
				<p><span>On-line shops:</span> <span class="value" id="num-retailers"></span></p>
			</div>
			<div class="info-item">
				<i class="fas fa-laptop"></i>
				<p><span>Unique laptop configurations:</span> <span class="value" id="num-configurations"></span></p>
			</div>
			<div class="info-item">
				<i class="fas fa-list-alt"></i>
				<p><span>Laptop models:</span> <span class="value" id="num-models"></span></p>
			</div>
		</div>
		<div class="category-container">
			<h2>Recommended</h2>
			<div class="arrow-swipe left-arrow">
				<i class="fas fa-chevron-left arrow left"></i>
			</div>
			<div class="category">
				<?php foreach ($tops as $category_label => $laptop): ?>
					<div class="category-item" data-category="<?php echo strtolower(str_replace(' & ', '-', $category_label)); ?>">
						<h3><?php echo $category_label; ?></h3>
						<div class="items">
							<div class="item" onmousedown="OpenPage('<?php echo "model/model.php?conf=" . $laptop['id'] . "&ex=USD"; ?>', event)">
								<img src="<?php echo $laptop['img']; ?>" alt="<?php echo $laptop['name']; ?>">
								<div class="info">
									<p><?php echo $laptop['name']; ?></p>
									<span>$<?php echo number_format($laptop['min_price']); ?> - $<?php echo number_format($laptop['max_price']); ?></span>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="arrow-swipe right-arrow">
				<i class="fas fa-chevron-right arrow right"></i>
			</div>
			<div class="category-indicators">
				<?php $index = 0; foreach ($tops as $category_label => $laptop): ?>
					<div class="indicator" data-index="<?php echo $index; ?>" data-category="<?php echo strtolower(str_replace(' & ', '-', $category_label)); ?>"></div>
				<?php $index++; endforeach; ?>
			</div>
		</div>
	</div>
	<!-- Info area end --!>
	
	<!-- articles & reviews -->
	<article class="articleMobile row"> 
		<h2 class="h2Articles col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">Articles</h2>
	<?php 	
	$y = 0;
	for ($y = 0; $y < 10; $y++) { 
		if(isset($recent_posts[$y]["ID"]))
		{
			$category = get_the_category( $recent_posts[$y]["ID"] ); 
			$categorie = $category[0]->cat_name; 
			if ($categorie == "Article") {$linkart=str_replace($wpsite."/article.php/article/","content/article.php?/",get_permalink($recent_posts[$y]["ID"]));}
			else {$linkart=str_replace($wpsite."/article.php/review/","content/review.php?/",get_permalink($recent_posts[$y]["ID"]));}
			
			if (empty($recent_posts[$y]["post_content"])){}
			else 
			{
	?>
				
		<div class="col-md-12 col-lg-12 col-sm-12 col-12 latest2">
			<div class="row">
				<div class="col-md-4 col-lg-3 col-sm-4 col-xs-4 latest3">
					<a onmousedown="OpenPage('<?php echo $linkart;?>',event);" >	
						<img style="display:block; margin:0 auto;" src="<?php $url = str_replace($wp_address.$wp_rmimg,$new_wp_address,wp_get_attachment_url( get_post_thumbnail_id($recent_posts[$y]["ID"]) )); echo $url;?>" class="img-responsive img-fluid" alt="Image">
					</a>
				</div>
				<div class="col-md-8 col-lg-9 col-sm-8 col-xs-9 latest4">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-12 col-lg-9">
							<span class="categoryName"><?php echo $categorie;?></span>					
							<span class="categoryAuthor"><?php   echo "by "; echo get_userdata($recent_posts[$y]["post_author"])->display_name; echo " - "; echo date( 'd M Y', strtotime( $recent_posts[$y]["post_date"]));?></span><br/>
							<a onmousedown="OpenPage('<?php echo $linkart;?>',event);"><?php echo $recent_posts[$y]["post_title"];  ?></a>
							<br>
							<?php 
								$review = nobrackets($recent_posts[$y]["post_content"]);
								echo wp_trim_words($review, 35, ' ....');
							?>
							
						</div>
						<div class="col-md-12 col-sm-12 col-12 col-lg-3 readMoreArticlesContainer">
							
							<a class="rmore" onmousedown="OpenPage('<?php echo $linkart;?>',event);"><?php echo "Read more";?> </a>
						</div>
					</div>					
				</div>
			</div>			
		</div>	

	<?php 	} 
		} 
	} ?>	
	<div class="readMoreArticles col-lg-12 col-sm-12 col-xs-12 col-lg-offset-12"><a onmousedown="OpenPage('content/articles.php');">View more articles</a></div>
	</article>
	<?php include_once("../etc/scripts_pages.php"); ?>