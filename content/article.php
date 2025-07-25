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
require_once("lib/php/func_article.php");

$absolute_url = full_url( $_SERVER );   // e.g. https://noteb.eu/review.php?/2022/04/26/asus-tuf-f15-2022-review/
$parts = explode( '/article.php?', $absolute_url, 2 );
if ( empty( $parts[1] ) ) {     wp_die( 'No review slug found in the URL.' );   }
$slug = trim( $parts[1], '/' );   // strip any leading / or trailing /
$slug = trailingslashit( $slug ); // add exactly one trailing slash
$permalink = trailingslashit( home_url() ) . 'article.php/article/' . $slug;
$echoid = url_to_postid( $permalink );
//echo 'Permalink tested: ' . esc_html( $permalink ) . '<br>';
//echo 'Post-ID: ' . intval( $echoid );
$post_date="1990-01-01";
?>
<script type="text/javascript">
var lang = <?php echo $lang; ?>;
var istime=0;
</script>
<?php
	if($echoid)
	{
?>
		<div class="col-md-12 col-sm-12" style="background-color:white;">
			<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" style="font-size:30px; padding-left:0px;" >
				<a  style="text-decoration:none;color:black;"><?php $content_title=""; $content_title=get_post_field('post_title', $echoid); echo $content_title;?></a>
				<div class="col-md-12 col-sm-12 col-xs-12" style="padding:0px;">
					<p style="font-style:italic;font-size:14px;">
					<?php echo "by "; $user_info = get_userdata(get_post_field('post_author', $echoid)); echo $user_info->display_name;?>
					<?php echo " - "; $post_date=get_post_field('post_date', $echoid); echo $post_date; ?>
					</p>
				</div>
		
			</div>
			<!--
			<div class="col-md-8 col-sm-8 col-xs-8 col-lg-8" style="padding-left:0px">
				<img src="<?php $url = str_replace(array_map(fn($u) => $u . $wp_rmimg, $wp_urls), $new_wp_address,wp_get_attachment_url( get_post_thumbnail_id($echoid) )); echo $url;?>" class="img-responsive img-fluid" alt="articleImg">
			</div>
			-->
			<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 detaliicomp2" style= "font-size:16px; line-height:30px; padding:0px; text-align:justify;">
				<div>
					<div><?php  $content=preg_replace_callback('/\[tooltip (.*)\](.*)\[tooltip\]/U',function ($m) {return maketooltip(gettoolid($m[1]),$m[2]);},str_replace(array_map(fn($u) => $u . $wp_rmimg, $wp_urls), $new_wp_address,apply_filters('the_content',get_post_field('post_content', $echoid, 'display')))); echo $content;
					echo "<br>"; ?> </div>
				</div>
			</div>
			<?php include_once("../libnb/php/aff_modal.php"); ?>
		</div>	 
<?php
	}
	else
	{
		echo "<b>The article you are looking for doesn't exist.</b><br>";
		echo "<a href='../index.php' target='_self'> Let's go back to the home page, shall we?</a>";
	}
?>
<link rel="stylesheet" href="content/lib/css/article.css?v=0.3" type="text/css"/>
<script type="text/javascript">
$(document).ready(function()
{
	actbtn("ARTICLES");
	 <?php 
		$posttags = wp_get_post_tags($echoid);
		if ($posttags) 
		{ 
			$i=0; $keywords="";
			foreach($posttags as $tag) 
			{
				if($i) { $keywords.=", ";}
				$keywords.=$tag->name; $i=1;
			}
		} 
		echo 'metakeys("'.$keywords.'");';
	?>
	
	setTimeout(function(){ istime=1; },1000);
	document.title = "Noteb - <?php echo $content_title; ?> - Article";
	$('meta[name=description]').attr('content', "Laptop article.");
});
</script>
<?php function clean_text($text){return(str_replace('"',' ',strip_tags($text)));}
$content_title=clean_text($content_title); $conclusion=clean_text($conclusion); $content=clean_text($content); ?>
<script type="application/ld+json">
{
"@context": "http://schema.org",
"@type": "BlogPosting",
"mainEntityOfPage":{
"@type":"WebPage",
"@id":"https://www.noteb.com"
},
"headline": "<?php echo $content_title; ?>",
"image": {
"@type": "ImageObject",
"url": "<?php echo $url; ?>"
},
"datePublished": "<?php echo $post_date; ?>",
"author": {
"@type": "Person",
"name": "<?php echo $user_info->display_name; ?>"
},
"inLanguage": "en",
"publisher": {
"@type": "Organization",
"name": "Noteb.com",
"logo": {
"@type": "ImageObject",
"url": "https://noteb.com/res/img/logo/noteb-main-logo.svg"
}
},
"description": "<?php echo $content_title; ?>",
"articleBody": "<?php echo $content; ?>"
}
</script>
<?php include_once("../etc/scripts_pages.php"); ?>