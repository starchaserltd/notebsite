<?php
require_once("../etc/conf.php");

// Uncomment and use the following block if you want to restrict access based on the referer header
/*
if (!isset($_SERVER['HTTP_REFERER']) || stripos($_SERVER['HTTP_REFERER'], $site_name) === FALSE) {
    $actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    header("Location: " . $port_type . "://" . str_replace(($site_name . "/"), ($site_name . "/?"), $actual_link) . "");
    die();
}
*/

$rootpath = realpath($_SERVER["DOCUMENT_ROOT"]) . $root_mod;
require_once($rootpath . $wp_install_address . '/wp/wp-blog-header.php');
require_once("../etc/con_db.php");
require_once("lib/php/functions.php");

$wpsite = site_url();

// Start WordPress loop to get posts
if (have_posts()) :
    while (have_posts()) : the_post();
    endwhile;
endif;

global $post;
$args = array('posts_per_page' => -1);
$myposts = get_posts($args);

echo get_the_title(2); // Display the title of the post with ID 2

$args = array(
    'numberposts' => -1,
    'offset' => 0,
    'category' => 0,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'include' => '',
    'exclude' => '',
    'meta_key' => '',
    'meta_value' => '',
    'post_type' => 'post',
    'post_status' => 'publish',
    'suppress_filters' => true
);

try {
    $recent_posts = wp_get_recent_posts($args, ARRAY_A);
    $category = get_category(2);
    $count_posts = wp_count_posts();
    $published_posts = $count_posts->publish;
} catch (Exception $e) {
    echo 'Could not get articles data from the CMS: ', $e->getMessage(), "\n";
}
?>

<link rel="stylesheet" href="content/lib/css/home.css?v=0.48" type="text/css"/>
<link rel="stylesheet" href="search/quiz/lib/css/quiz.css?v=0.35" type="text/css"/>

<script>
    $.getScript("content/lib/js/home.js?v=0.21", function() { });
    document.title = "Noteb - Search, Compare and Find the Best Laptop for You";
    $(document).ready(function(){
        $('meta[name=description]').attr('content', "Looking for a laptop? Search, Compare or even take a Quiz with Noteb.com to find the perfect laptop for your work, home or suggest one to your friends from over 6.000.000 configurations derived from over 900 models.");
        $('head').append('<link rel="alternate" hreflang="en-US" href="https://noteb.com" />');
    });
</script>

<!-- Noteb Quiz -->
<div class="col-md-12 col-lg-12 col-12 col-sm-12 quizDisplay" style="padding:0px;">
    <div id="quiz" class="col-md-12 col-lg-12 col-12 col-sm-12" style="position:relative; min-height: 365px;"></div>
</div>

<!-- Top 10 laptops area -->
<!-- <link rel="stylesheet" href="content/lib/css/infoarea.css?v=0.02" type="text/css"/> -->
<?php
try {
    $query = mysqli_query($con, "SELECT * FROM `".$GLOBALS['global_notebro_site']."`.top_laptops WHERE valid=1 ORDER BY TYPE, ORD ASC, PRICE");

    $tops = array();
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            // Group laptops by type and store details
            $tops[$row['type']][] = array(
                'id' => $row['c_id'],
                'img' => $row['img'],
                'name' => $row['name'],
                'price' => $row['price'],
                'min_price' => $row['min_price'],
                'max_price' => $row['max_price'],
                'price_range' => intval($row['price_range'])
            );
        }
        mysqli_free_result($query);
    }
} catch (Exception $e) {
    echo 'Could not get information on laptop tops: ', $e->getMessage(), "\n";
}
?>

<!-- Info area start -->
<div class="main-info-container">
    <div class="card1">
        <h2 class="card1-title">Noteb stats</h2>

        <div class="row">
            <div class="icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="main-info">Last Updated: <span class="highlight" id="latest-update">0</span> (UTC)</div>
        </div>

        <div class="row">
            <div class="icon">
                <i class="fas fa-store-alt"></i>
            </div>
            <div class="main-info">Online Shops: <span class="highlight" id="num-retailers">0</span></div>
        </div>

        <div class="row">
            <div class="icon">
                <i class="fas fa-laptop"></i>
            </div>
            <div class="main-info">Laptop Models: <span class="highlight" id="num-models">0</span></div>
        </div>

        <div class="row">
            <div class="icon">
                <i class="fas fa-cogs"></i>
            </div>
            <div class="main-info">Laptop Configurations: <span class="highlight" id="num-configurations">0</span></div>
        </div>
    </div>

    <!-- Carousel -->
    <div class="carousel">
        <div class="carousel-title">
            <h2>RECOMMENDED</h2>
        </div>
        <div class="carousel-container">
            <?php $index = 1; foreach ($tops as $category_label => $laptops): ?>
                <?php foreach ($laptops as $laptop): ?>
                    <input type="radio" name="carousel" id="slide<?php echo $index; ?>" <?php if($index === 1) echo 'checked'; ?>>
                    <div class="carousel-slide" id="carousel-slide<?php echo $index; ?>">
                        <h3><?php echo (stripos($category_label, "home") !== FALSE) ? "Home & Student" : $category_label; ?></h3>
                        <a class="" href="javascript:void(0)" onmousedown="OpenPage('<?php echo "model/model.php?conf=" . $laptop["id"] . "&ex=USD"; ?>',event)">
                            <div class="image-container">
                                <img src="<?php echo $laptop['img']; ?>" alt="<?php echo $laptop['name']; ?>">
                            </div>
                            <div class="product-info">
                                <h3><?php echo $laptop['name']; ?></h3>
                                <p>$<?php echo number_format($laptop['min_price']); ?> - $<?php echo number_format($laptop['max_price']); ?></p>
                            </div>
                        </a>
                    </div>
                    <?php $index++; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>

            <!-- Controls -->
            <div class="carousel-controls">
                <label for="prevSlide" class="prev">&#10094;</label>
                <label for="nextSlide" class="next">&#10095;</label>
            </div>

            <!-- Navigation Dots -->
            <div class="carousel-dots">
                <?php $index = 1; foreach ($tops as $category_label => $laptops): ?>
                    <label for="slide<?php echo $index; ?>" class="dot"></label>
                    <?php $index++; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<!-- Info area end -->

<!-- Articles & reviews -->
<article class="articleMobile row">
    <h2 class="h2Articles col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">Articles</h2>
    <?php
    for ($y = 0; $y < 10; $y++) {
        if(isset($recent_posts[$y]["ID"])) {
            $category = get_the_category($recent_posts[$y]["ID"]);
            $categorie = $category[0]->cat_name;
            if ($categorie == "Article") {
                $linkart = str_replace($wpsite."/article.php/article/", "content/article.php?/", get_permalink($recent_posts[$y]["ID"]));
            } else {
                $linkart = str_replace($wpsite."/article.php/review/", "content/review.php?/", get_permalink($recent_posts[$y]["ID"]));
            }

            if (!empty($recent_posts[$y]["post_content"])) {
    ?>
    <div class="col-md-12 col-lg-12 col-sm-12 col-12 latest2">
        <div class="row">
            <div class="col-md-4 col-lg-3 col-sm-4 col-xs-4 latest3">
			<?php
					/*
					var_dump($wp_url.$wp_rmimg);
					var_dump($new_wp_address);
					var_dump(wp_get_attachment_url(get_post_thumbnail_id($recent_posts[$y]["ID"])));
					*/
				?>
					<a onmousedown="OpenPage('<?php echo $linkart; ?>',event);">
                    <img style="display:block; margin:0 auto;" src="<?php
                    $url = str_replace(array_map(fn($u) => $u . $wp_rmimg, $wp_urls), $new_wp_address, wp_get_attachment_url(get_post_thumbnail_id($recent_posts[$y]["ID"])));
                    echo $url;?>" class="img-responsive img-fluid" alt="Image">
                </a>
            </div>
            <div class="col-md-8 col-lg-9 col-sm-8 col-xs-9 latest4">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-12 col-lg-9">
                        <span class="categoryName"><?php echo $categorie;?></span>
                        <span class="categoryAuthor"><?php echo "by " . get_userdata($recent_posts[$y]["post_author"])->display_name . " - " . date('d M Y', strtotime($recent_posts[$y]["post_date"]));?></span><br/>
                        <a onmousedown="OpenPage('<?php echo $linkart; ?>',event);"><?php echo $recent_posts[$y]["post_title"]; ?></a>
                        <br>
                        <?php
                        $review = nobrackets($recent_posts[$y]["post_content"]);
                        echo wp_trim_words($review, 35, ' ....');
                        ?>
                    </div>
                    <div class="col-md-12 col-sm-12 col-12 col-lg-3 readMoreArticlesContainer">
                        <a class="rmore" onmousedown="OpenPage('<?php echo $linkart; ?>',event);">Read more</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
            }
        }
    }
    ?>
    <div class="readMoreArticles col-lg-12 col-sm-12 col-xs-12 col-lg-offset-12">
        <a onmousedown="OpenPage('content/articles.php');">View more articles</a>
    </div>
</article>
<?php include_once("../etc/scripts_pages.php"); ?>
