
<?php
require_once("../etc/conf.php");
if (!isset($_SERVER['HTTP_REFERER']) || stripos($_SERVER['HTTP_REFERER'],$site_name) ==FALSE) 
{	$actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	header("Location: ".$port_type."://".str_replace($site_name."/",$site_name."/?",$actual_link)."");
	die();
}
$rootpath = realpath($_SERVER["DOCUMENT_ROOT"]).$root_mod;
require_once($rootpath.$admin_address.'/wp/wp-blog-header.php');
require_once("../etc/con_db.php");
require_once("lib/php/func_article.php");

if(isset($_SESSION['lang'])) { $lang=$_SESSION['lang']; } else { $lang=0; }

$absolute_url = full_url( $_SERVER );
$ad=explode("/review.php?", $absolute_url);
$ad[1]=preg_replace("/\/&[azAZ]?.*($)/","/",$wp_address."wp/article.php/review".$ad[1]);
$echoid = url_to_postid($ad[1]); //echo $echoid;
$url = str_replace($wp_address.$wp_rmimg,$new_wp_address,wp_get_attachment_url( get_post_thumbnail_id($echoid) )); //var_dump($url);
$nrtabs=0;
$tabnames=array();

$content=str_replace($wp_address.$wp_rmimg,$new_wp_address,$content);
$content=preg_replace_callback('/\[tooltip (.*)\](.*)\[tooltip\]/U',function ($m) {return maketooltip(gettoolid($m[1]),$m[2]);},apply_filters('the_content',get_post_field('post_content', $echoid, 'display')));
echo preg_replace_callback('/\[ntab (.*)\](.*)(?=\[ntab .*\]|\Z)/Us',function ($m) {return maketab($m[1],$m[2]);},$content);
$display_all_content="";
$conclusion="";
$post_date="1990-01-01";
?>
<script type="text/javascript">
	var lang = <?php echo $lang; ?>;
	var istime=0;	
</script>
<link rel="stylesheet" href="content/lib/css/review_add.css">
<!--******pana aici -->

	<div class="row" style="background-color:white;margin: -15px 0 0 0;">
		<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" style=" font-size:30px; text-align:center;" >
			<a style="text-decoration:none;float:left;color:black;"><?php $content_title=""; $content_title=get_post_field('post_title', $echoid); echo $content_title; ?></a>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<p style="font-style:italic;">
			<?php $user_info = get_userdata(get_post_field('post_author', $echoid));
				echo "by "; echo $user_info->display_name; echo " - "; $post_date=get_the_date('d M Y', $echoid ); echo $post_date; ?>
			</p>
		</div>
		<div class="col-md-8 col-sm-8 col-xs-8">
			<img src="<?php echo $url;?>" class="img-responsive img-fluid" alt="reviewImg">
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 detaliicomp2" style= " font-size:16px; line-height:30px; text-align:justify;">
			<div class="tabs" id="taburi">
				<ul class="tab-links" style="padding-left:0px;">
				<?php	$j=1;
					for($i=0;$i<$nrtabs;$i++)
					{
						if($j)
							{ echo '<li class="active" >'; $j=0;}
						else
							{ echo '<li>'; }
						
						echo '<a href="#tab'.$i.'" id="tab'.$i.'m" >'.$tabnames[$i].'</a></li>';
					}
				?>
				</ul>
				<div class="tab-content">
				<?php	$j=1;
					for($i=0;$i<$nrtabs;$i++)
					{
						if($j)
							{ echo '<div id="tab'.$i.'" class="tab active">'; $j=0;}
						else
							{ echo '<div id="tab'.$i.'" class="tab">'; }
	
						$display_content=str_replace($wp_address.$wp_rmimg,$new_wp_address,$tabcontent[$i]);
						$display_all_content.="<br><br><br>".$display_content;
						$current_tab_name=strtolower($tabnames[$i]);
						if($current_tab_name=="conclusions" || $current_tab_name=="conclusion"){ $conclusion=$display_content;} 
						echo "<p class='contentoftab'>".$display_content."</p>";
						echo "</div>";
					}
				?>
       			</div>
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-test dropdown-toggle reviewGoTo" data-toggle="dropdown" aria-expanded="false" style="border-radius:0px; ">
					Go to:
					<span class="caret"></span>
					</button>	
					<ul class="dropdown-menu tab-links reviewGoToDropdown" style="width:auto;padding:0px" role="menu">
					<?php $j=1;
						for($i=0;$i<$nrtabs;$i++)
						{
							echo '<li  style="float:none;"><a href="#tab'.$i.'" id="tab-'.$i.'" onclick="scrolltoid('."'".'content'."'".',0);">'.$tabnames[$i].'</a></li>';	
						}
					?>
					</ul>	
				</div>
			</div>
		</div>
	</div>
	<?php include_once("../libnb/php/aff_modal.php"); ?>
	<link rel="stylesheet" href="content/lib/css/review.css?v=1.3" type="text/css"/>
	
	<script type="text/javascript">
	$.getScript("content/lib/js/review.js", function()
	{
		jQuery(document).ready(function()
		{	
			if(sessionStorage["reviewtab"]!=undefined&&sessionStorage["reviewtab"]!=""){ change_review_tab(sessionStorage["reviewtab"]); }else{sessionStorage["reviewtab"]="";}
			$('meta[name=description]').attr('content', "Laptop review.");
			actbtn("REVIEWS");
			document.title = "Noteb - <?php echo $content_title; ?> - Review";
			
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
			setTimeout(function()
			{ istime=1; },1000);
		});
	});
	</script>
	<script type="application/ld+json">	
	{
	  "@context": "http://schema.org",
	  "graph": [
		{
			 "@type": "Organization",
			  "url": "https://www.noteb.com",
			  "name": "Noteb.com",
			  "logo": {
				"@type": "ImageObject",
				"url": "https://noteb.com/res/img/logo/noteb-main-logo.svg"
				}
			},
		{
		  "@type": "Review",
		  "itemReviewed": {
			"@type": "Product",
			"image": "<?php echo $url; ?>",
			"name": "<?php $content_title=str_replace('"',' ',$content_title); echo $content_title; ?>"
			},
		  "datePublished": "<?php echo $post_date; ?>",
		  "name": "<?php echo $content_title; ?>",
		  "author": {
			"@type": "Person",
			"name": "<?php echo $user_info->display_name; ?>"
		  },
		  "description": "<?php echo str_replace('"',' ',$conclusion); ?>",
		  "reviewBody": "<?php echo str_replace('"',' ',$content); ?>",
		  "publisher": {
			"@type": "Organization",
			"name": "Noteb.com"
			}
		}		
	  ]
	}
	</script>
<?php include_once("../etc/scripts_pages.php"); ?>