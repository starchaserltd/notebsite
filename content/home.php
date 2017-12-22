<?php
require_once("../etc/conf.php");

if (!isset($_SERVER['HTTP_REFERER']) || stripos($_SERVER['HTTP_REFERER'],$site_name) ==FALSE) 
{	$actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	header("Location: ".$port_type."://".str_replace(($site_name."/"),($site_name."/?"),$actual_link)."");
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
<head>
	<!-- Language href link for google -->  
	<link rel="alternate" hreflang="en-US" href="https://noteb.com" />
</head>
<link rel="stylesheet" href="content/lib/css/home.css?v=0.29" type="text/css"/>
<script>$.getScript("content/lib/js/home.js");document.title = "Noteb - Home";$(document).ready(function(){
    $('meta[name=description]').attr('content', "Looking for a laptop? Search, Compare or even take a Quiz with Noteb.com to find the perfect laptop for your work, home or suggest one to your friends from over 1.000.000 models.");
});</script>
	
	<!-- Noteb Quiz -->
	<link rel="stylesheet" href="search/quiz/lib/css/quiz.css" type="text/css"/>
	<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12" style="padding:0px;">
		<div id="quiz" class="col-md-12 col-lg-12 col-xs-12 col-sm-12" style="position:relative;"></div>	
	</div>			

	<!-- Noteb Quiz end -->
	<div class="clearfix"></div>
	
	<!-- Top 10 laptops area -->
	<?php $query=mysqli_query($con,"SELECT * FROM notebro_site.top_laptops where valid=1 order by type,price"); $tops=array(); $topshead=array(); while ($row=mysqli_fetch_assoc($query)) { $tops[$row['type']][$row['id']] = array('id' => $row['c_id'],'img' => $row['img'], 'name' => $row['name'], 'price' => $row['price']); if(isset($topshead[$row['type']]["count"])) { $topshead[$row['type']]["count"]++; } else {$topshead[$row['type']]["count"]=1; } $topdate= strtotime($row["date"]); if(isset($topshead[$row['type']]["maxdate"])){ if($topshead[$row['type']]["maxdate"] < $topdate) { $topshead[$row['type']]["maxdate"]=$topdate; } } else { $topshead[$row['type']]["maxdate"]=$topdate; } } ?>
	<section class="row topLaptops">
		<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 studentTopLaptops">
			<h2 class="h2TopLaptopsStudent">Top <?php echo $topshead["HomeStudent"]["count"]; ?> Home & Student <span class="topLaptopsDate visible-xs hidden-md hidden-sm hidden-lg"><?php echo date('M Y',$topshead["HomeStudent"]["maxdate"]); ?></span></h2>
			<p class="topLaptopsDate hidden-xs visible-md visible-sm visible-lg"><?php echo date('M Y',$topshead["HomeStudent"]["maxdate"]); ?></p>
			<?php foreach ($tops['HomeStudent'] as $el) { ?>			
			<div class="row">
				<a href="javascript:void(0)" onmousedown="OpenPage('<?php echo "model/model.php?conf=".$el["id"]."&ex=USD"; ?>',event)";?>
					<div class="col-xs-12 imgTopLaptop">
						<img  class="img-responsive " src="<?php echo $el["img"]; ?>" alt="imgStudent"/>
						<p class="topLaptopsName"><?php echo $el["name"]; ?> <br/> <span class="pretTopLaptops"><?php echo $el["price"]; ?>$</span></p>
					</div>	
				</a>					
			</div>											
			<?php } ?>
		</div>
		<div class="col-xs-12 mobileShowMoreStudent"><span>Show All</span></div>

		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 gamingTopLaptops">
			<h2 class="h2TopLaptopsGaming">Top <?php echo $topshead["Gaming"]["count"]; ?> Gaming <span class="topLaptopsDate visible-xs hidden-md hidden-sm hidden-lg"><?php echo date('M Y',$topshead["Gaming"]["maxdate"]); ?></span></h2>
			<p class="topLaptopsDate hidden-xs visible-md visible-sm visible-lg"><?php echo date('M Y',$topshead["Gaming"]["maxdate"]); ?></p>
			<?php foreach ($tops['Gaming'] as $el) { ?>				
			<div class="row">
				<a href="javascript:void(0)" onmousedown="OpenPage('<?php echo "model/model.php?conf=".$el["id"]."&ex=USD"; ?>',event)";?>
					<div class="col-xs-12 imgTopLaptop">
						<img  class="img-responsive " src="<?php echo $el["img"]; ?>" alt="imgGaming"/>
						<p class="topLaptopsName"><?php echo $el["name"]; ?> <br/> <span class="pretTopLaptops"><?php echo $el["price"]; ?>$</span></p>							 
					</div>							
				</a>
			</div>											
			<?php } ?>
		</div>	
		<div class="col-xs-12 mobileShowMoreGaming"><span>Show All</span></div>
			
		<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 businessTopLaptops">
			<h2 class="h2TopLaptopsBusiness">Top <?php echo $topshead["Business"]["count"]; ?> Business <span class="topLaptopsDate visible-xs hidden-md hidden-sm hidden-lg"><?php echo date('M Y',$topshead["Business"]["maxdate"]); ?></span></h2>
			<p class="topLaptopsDate hidden-xs visible-md visible-sm visible-lg"><?php echo date('M Y',$topshead["Business"]["maxdate"]); ?></p>
			<?php foreach ($tops['Business'] as $el) { ?>				
			<div class="row">
				<a href="javascript:void(0)" onmousedown="OpenPage('<?php echo "model/model.php?conf=".$el["id"]."&ex=USD"; ?>',event)";?>
					<div class="col-xs-12 imgTopLaptop">
						<img  class="img-responsive " src="<?php echo $el["img"]; ?>" alt="imgBusiness"/>
						<p class="topLaptopsName"><?php echo $el["name"]; ?> <br/> <span class="pretTopLaptops"><?php echo $el["price"]; ?>$</span></p>							 
					</div>
				</a>
			</div>											
			<?php } ?>
		</div>	
		<div class="col-xs-12 mobileShowMoreBusiness"><span>Show All</span></div>
	</section>
	<div class="showMore"><span class="showMoreSpan">Show All</span></div>

	<!-- articles & reviews -->
	<article class="articleMobile row"> 
		<h2 class="h2Articles">Articles</h2>
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
	</article>
	<div class="col-xs-12 mobileShowMoreArticles"><span>Show All Articles</span></div>
	<script type="application/ld+json">	
		{
		  "@context": "http://schema.org",
		  "graph": [
		  	{
		  		 "@type": "Organization",
				  "url": "https://www.noteb.com",
				  "logo": "https://www.noteb.com/res/img/logo/logo_white.png"
				},
			{		 
			  "@type": "WebSite",
			  "url": "https://www.noteb.com",
			  "potentialAction": {
			    "@type": "SearchAction",
			    "target": "https://query.noteb.com/search?q={search_term_string}",
			    "query-input": "required name=search_term_string"
			  }
			}			
		  ]
		}
	</script>