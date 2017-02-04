<?php
require_once("../etc/conf.php");
if (!isset($_SERVER['HTTP_REFERER']) || stripos($_SERVER['HTTP_REFERER'],$site_name) ==FALSE) 
{	$actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	header("Location: http://".str_replace($site_name."/",$site_name."/?",$actual_link)."");
	die();
}
$rootpath = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once($rootpath.$admin_address.'/wp/wp-blog-header.php');
require_once("../etc/con_db.php");
require_once("lib/php/func_article.php");

if(isset($_SESSION['lang'])) { $lang=$_SESSION['lang']; } else { $lang=0; }

$absolute_url = full_url( $_SERVER );
$ad=explode("/review.php?", $absolute_url); //var_dump($ad);
$ad[1]=$wp_address."wp/article.php".$ad[1];
$echoid = url_to_postid($ad[1]); //echo $echoid;
$url = str_replace($wp_address.$wp_rmimg,$new_wp_address,wp_get_attachment_url( get_post_thumbnail_id($echoid) )); //var_dump($url);
$nrtabs=0;
$tabnames=array();

$content=str_replace($wp_address.$wp_rmimg,$new_wp_address,$content);
$content=preg_replace_callback('/\[tooltip (.*)\](.*)\[tooltip\]/U',function ($m) {return maketooltip(gettoolid($m[1]),$m[2]);},apply_filters('the_content',get_post_field('post_content', $echoid, 'display')));
echo preg_replace_callback('/\[ntab (.*)\](.*)(?=\[ntab .*\]|\Z)/Us',function ($m) {return maketab($m[1],$m[2]);},$content);
?>
<script type="text/javascript">
	var lang = <?php echo $lang; ?>;
	var istime=0;
</script>

	<div class="col-md-12 col-sm-12" style="background-color:white; font-family:arial">
		<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" style="font-family:'robotomedium'; font-size:30px; text-align:center; margin-top:30px;" >
			<a style="text-decoration:none;float:left;color:black;"><?php echo get_post_field('post_title', $echoid);?></a>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<p style="font-family:robotolight,sans-serif; font-style:italic;">
			<?php $user_info = get_userdata(get_post_field('post_author', $echoid));
				echo "by "; echo $user_info->display_name;; echo " - "; echo get_the_date(  'd M Y', $echoid ); ?>
			</p>
		</div>
		<div class="col-md-8 col-sm-8 col-xs-8">
			<img src="<?php echo $url;?>" class="img-responsive">
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" style= "font-family:'robotolight'; font-size:18px; line-height:30px; text-align:justify;">
			<div class="tabs" id="taburi">
				<ul class="tab-links" style="padding-left:0px;">
				<?php	$j=1;
					for($i=0;$i<$nrtabs;$i++)
					{
						if($j)
							{ echo '<li class="active" >'; $j=0;}
						else
							{ echo '<li>'; }
						
						echo '<a href="#tab'.$i.'" id="ta'.$i.'" >'.$tabnames[$i].'</a></li>';
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
	
						echo "<p id='contentoftab'>".$tabcontent[$i]."</p>";
						echo "</div>";
					}
				?>
       			</div>
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-test dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="border-radius:0px; ">
					Go to:
					<span class="caret"></span>
					</button>	
					<ul class="dropdown-menu tab-links" style="width:auto;padding:0px" role="menu">
					<?php $j=1;
						for($i=0;$i<$nrtabs;$i++)
						{
							echo '<li  style="float:none;"><a href="#tab'.$i.'" id="tab-'.$i.'">'.$tabnames[$i].'</a></li>';	
						}
					?>
					</ul>	
				</div>
			</div>
		</div>
	</div>
	
	<script type="text/javascript">
	jQuery(document).ready(function() {	jQuery('.tabs .tab-links a').on('click', function(e)  {
        var currentAttrValue = jQuery(this).attr('href');
         // Show/Hide Tabs
        jQuery('.tabs ' + currentAttrValue).slideDown(400).siblings().slideUp(400);
         // Change/remove current tab to active
        jQuery(this).parent('li').addClass('active').siblings().removeClass('active');
        e.preventDefault();
		});
		
		actbtn("REVIEWS");
		
		<?php 
		$posttags = get_the_tags();
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
	<?php
	for($i=0;$i<$nrtabs;$i++)
	{
		echo "$('#taburi').on( ".'"click"'.", '#tab-".$i."', function(e){ $('#ta".$i."').trigger('click'); }); ";
	}
	?>
</script>