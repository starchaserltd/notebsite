<?php
ini_set('max_execution_time', 5);
require_once("lib/php/resultlib.php");
$temp_table = "all_conf";
/* GETTING EXCHANGE LIST */
$result = mysqli_query($GLOBALS['con'], "SELECT code,sign, ROUND( convr, 5 ) convr FROM notebro_site.exchrate"); 
$exchangelist = mysqli_fetch_all($result);
$result = mysqli_query($GLOBALS['con'], "SELECT id,disp FROM notebro_db.REGIONS"); 
while($row=mysqli_fetch_array($result)){ $regions[$row[0]]=$row[1]; }
?>

<div class="row headerback" style="margin:0;">
	<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" style="background-color:white; font-family:arial;padding:0px">
		<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding:3px 0px 5px 0px"> 
			<div class="col-md-6 col-sm-6 col-xs-12 col-lg-6">
				<button type="button" <?php $nosearch=0; $search_ref=str_replace("/advanced_search","/adv_search",$absolute_url[0],$nosearch); if(!($nosearch)){ $search_ref=str_replace("/search.php?","/adv_search.php?",$absolute_url[0]);} $text='onmousedown="OpenPage('."'".$search_ref; foreach($sortby as $sort) {} $text.="',event)".'"'; echo $text ?> class="btn btn-result" style="margin-right:24px;border-radius:1px !important; height:25px; padding:2px 15px;"> <a style="text-decoration:none;color:white">Refine results</a></button>
			</div>
<?php		
		include_once("proc/confsearch.php"); /* WHERE THE REAL SEARCH IS DONE! */
		if($count > 0)
		{
			$usertag=""; if(isset($_GET["ref"])&&$_GET["ref"]!=""){ $usertag=mysqli_real_escape_string($con,filter_var($_GET["ref"], FILTER_SANITIZE_STRING)); }
			?>
			<div class="col-md-6 col-sm-6 col-xs-12 col-lg-6" style="padding:0px">
				<div class="btn-group">		
					<div class="btn-group" style="float:right;width:auto!important;margin-left:3px">
						<button type="button" data-toggle="dropdown" class="btn btn-result dropdown-toggle" style="width:35px;border-radius:1px;"><?php echo '<a style="text-decoration:none; color:white">'.$exchsign.'</a>'; ?>
						<span class="caret"></span></button>
						<ul class="dropdown-menu" style="margin-top:0px;margin-bottom:0px;padding:0px;border-radius: 3px;min-width:35px!important;border-top-width: 0px;">
						<?php
						foreach ($exchangelist as $exchc)
						{
							if($exchc[0]!=$exchcode)
							{ 
								echo '							<li class="exchangeres" style="width:35px;text-align:center"><a onmousedown="OpenPage(exchangeresults('."'".$exchc[0]."'".'),event)">'.$exchc[1].'</a></li>';
							}
						}
						?>
						</ul>
					</div>
					<button type="button" class="btn btn-result<?php echo $name_button;?>" style="float:right;border-radius: 0px 1px 1px 0px;" onmousedown="OpenPage(sortresults('name'),event)"><a style="color:white;text-decoration:none">name</a></button>
					<button type="button" style="float:right;" class="btn btn-result<?php echo $performance_button; ?>" onmousedown="OpenPage(sortresults('performance'),event)"><a style="color:white;text-decoration:none">perfomance</a></button>							
					<button type="button" style="float:right;" class="btn btn-result<?php echo $price_button; ?>" onmousedown="OpenPage(sortresults('price'),event)"><a style="color:white;text-decoration:none">price</a></button>
					<button type="button" class="btn btn-result<?php echo $value_button;?>" style="float:right;;margin-left:10px;border-radius: 1px 0px 0px 1px;"  onmousedown="OpenPage(sortresults('value'),event)"><a style="color:white;text-decoration:none">value</a></button>			
					<a class="btn" style="float:right;text-decoration:none;color:black;font-weight:bold;padding:2px 0px 0px 0px;">Order by:</a>
				</div>		 
			</div>	
		</div>
		
		<?php
		$cons=dbs_connect();
		$startpos = ($page - 1) * 20; $i=0;
		for ($pos = $startpos; $pos < ($startpos + 20); $pos++)
		{
			if ($pos >= $count) 
			{ break; }
			$rand = $results[$pos];
			getdetails($rand['model']);
		?>
		<div class="col-md-3 col-sm-4 col-xs-6 col-lg-3" style="padding-left:7px !important;padding-right:7px !important" >
			<div class="col-md-12 searchresult">
				<div class="searchresultJPG">
					<a onmousedown="OpenPage('model/model.php?conf=<?php echo $rand['id']."_".$rand['model'];?>',event);">
						<img src="../res/img/models/thumb/<?php echo $t_img; ?>" class="img-responsive" alt="Image for <?php echo $model; ?>">
					</a>
				</div>
				<br>
				<div class="searchresultitlu">
					<a onmousedown="OpenPage('model/model.php?conf=<?php echo $rand['id']."_".$rand['model'];?>',event);">
						<p>
							<?php
								echo $prod; echo " ";
								echo $fam; echo " ";
								echo $model; echo " ";			
								echo show('submodel','MDB',$rand['mdb'] );
								$sspace=1; if(isset($submodel) && strlen($submodel)>0){ echo " ".$submodel; $sspace=0; }
								if(($region_m_id==0 || $dispregion==1)&&($region_m_id!=1)) {  if($sspace){ echo " "; } echo "(".$regions[$region_m_id].")"; }else { $buy_regions=0; }
							?>
						</p>
					</a>
				</div>
		        <div class="searchresultdesc">
					<a onmousedown="OpenPage('model/model.php?conf=<?php echo $rand['id']."_".$rand['model'];?>',event);">
						<ul>
							<li class="resulspace"><?php echo show('size','DISPLAY',$rand['display'] ).'" ('.show('hres','DISPLAY',$rand['display'])."x".show('vres','DISPLAY',$rand['display']).")";?></li>
							<li class="resulspace"><?php echo show('prod', 'CPU',$rand['cpu'] )." ".show('model', 'CPU',$rand['cpu'] )." (".show('clocks', 'CPU',$rand['cpu'] )." GHz)"?></li>
							<li class="resulspace"><?php echo show('prod', 'GPU',$rand['gpu'] )." ".show('model', 'GPU',$rand['gpu'] );?></li>
							<li class="resulspace"><?php echo showmem('cap, type, freq', 'MEM',$rand['mem'] );echo " ";?></li>
							<li class="resulspace"><?php echo showhdd('cap,type,rpm','HDD',$rand['hdd'],$rand['shdd']);echo "";?></li>
							<li class="resulspace"><?php $kgw=show('weight','CHASSIS',$rand['chassis']); echo round(floatval($kgw),2)." Kg / ".round(floatval($kgw*2.20462262),2)." lb";?></li>
							<li class="resulspace"><?php showsist('sist,vers,type', 'SIST',$rand['sist']);echo " ";?></li>
							<li class="resulspace"><?php showbat('notebro_temp.all_conf_'.$rand['model'],$rand['id'],0);echo " ";?></li>
						</ul>
					</a>
				</div>
				<div class="searchprice"><?php echo ""; echo $exchsign; echo " "; echo showprice(('notebro_temp.'.$temp_table."_".$rand['model']), $rand['id'], $exch );?></div>
				<div class="buy resultsShopBtn col-lg-6 col-md-5 col-sm-6 col-xs-6 col-xxs-12">
					<div class="dropdown">
						<div id="dLabel" class="btn buyBtn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-ref="<?php if(isset($usertag)&&$usertag!=""){ echo $usertag; } else { echo "";} ?>" data-target="buylist-<?php echo $i;?>" data-idmodel="<?php echo $rand['model']; ?>" data-buyregions="<?php ?>" data-lang="<?php echo $value["id"]; ?>" onclick="get_buy_list(this);">
							<span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span><span class="resultsBuyText"> Buy</span>
							<span class="caret"></span>
						</div>
						<ul class="dropdown-menu" aria-labelledby="dLabel" id="buylist-<?php echo $i; $i++;?>">
							<li class="loaderContainer">
								<span class="loader"></span>
							</li>
						</ul>
					</div><!-- Dropdown end div-->
				</div>
				<div class="btn col-xs-6 col-sm-6 col-md-7 addtocpmp col-xxs-12 col-lg-6" onclick="addcompare('<?php echo $rand['id']."_".$rand['model'];?>')">Compare</div>				
			</div>
		</div>
		<?php
		}
	
		$j=0;
		foreach($absolute_url as $urlpart)
		{
			$sortby=explode("sort_by",$urlpart);
			$sortext="";
			
			for($i=1;$i<count($sortby);$i++)
			{
				$absolute_url[$j]=str_replace("&sort_by".$sortby[$i],"",$urlpart);
				$sortext.="&sort_by".$sortby[$i];
			}
			$j++;
		}
		?>
	</div>
</div>
<div class="row" style="margin:0;">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<ul class="pagination" style="margin:0px;padding-top:10px; float:right">
			<li><a style="color:#000; cursor:pointer;" <?php echo 'onmousedown="OpenPage('."'".$absolute_url[0]."&page=1".$sortext."',event);".'scrolltoid('."'".'content'."'".');"'; ?> >&lt;&lt;</a></li>
			<li><a <?php  $newpage=$page-1; if($newpage<1) {$newpage=1; } echo 'onmousedown="OpenPage('."'".$absolute_url[0]."&page=".$newpage.$sortext."',event);".'scrolltoid('."'".'content'."'".');"'; ?>  style="color:#000; cursor:pointer;">&lt;</a></li>
			<?php
				$count=ceil($count/20);
				if($count<5)
				{  
					for($i=1;$i<=$count;$i++)
					{
						if($i == $page)
						{ echo '			<li><a onmousedown="OpenPage('."'".$absolute_url[0]."&page=".$i.$sortext."',event);".'scrolltoid('."'".'content'."'".');" style="color:#000; cursor:pointer;"><b>'.$i.'</b></a></li>'; }
						else 
						{ echo '			<li><a onmousedown="OpenPage('."'".$absolute_url[0]."&page=".$i.$sortext."',event);".'scrolltoid('."'".'content'."'".');" style="color:#000; cursor:pointer;">'.$i.'</a></li>'; }
					}
				}
				else
				{
					$limit=$page+2;
					$min=$page-2;
					
					if($limit>$count) { $limit=$count; }
					if($min<1) {$min=1; }
	
					for($i=$min;$i<=$limit;$i++)
					{ 
						if($i==$page)
						{ echo '			<li><a onmousedown="OpenPage('."'".$absolute_url[0]."&page=".$i.$sortext."',event);".'scrolltoid('."'".'content'."'".');" style="color:#000; cursor:pointer;"><b>'.$i.'</b></a></li>'; }
						else
						{ echo '			<li><a onmousedown="OpenPage('."'".$absolute_url[0]."&page=".$i.$sortext."',event);".'scrolltoid('."'".'content'."'".');" style="color:#000; cursor:pointer;">'.$i.'</a></li>'; }
					}
				}
			?>
			<li><a <?php  $newpage=$page+1; if($newpage>$count) {$newpage=$count; } echo 'onmousedown="OpenPage('."'".$absolute_url[0]."&page=".$newpage.$sortext."',event);".'scrolltoid('."'".'content'."'".');"';; ?>  style="color:#000; cursor:pointer;">></a></li>
			<li><a <?php echo 'onmousedown="OpenPage('."'".$absolute_url[0]."&page=".$count.$sortext."',event);".'scrolltoid('."'".'content'."'".');"'; ?> style="color:#000; cursor:pointer;" >>></a></li>
		</ul>
		<button type="button" id="refinesearch" <?php $nosearch=0; $search_ref=str_replace("/advanced_search","/adv_search",$absolute_url[0],$nosearch); if(!($nosearch)){ $search_ref=str_replace("/search.php?","/adv_search.php?",$absolute_url[0]);} $text='onmousedown="OpenPage('."'".$search_ref; foreach($sortby as $sort) {} $text.="',event);".'scrolltoid('."'".'content'."'".');"'; echo $text ?> class="btn-result" style="float:right;margin-right:25px;border-radius:2px !important; height:30px; padding:2px 40px;margin-top:10px"><a style="color:white;text-decoration:none"> Refine results</a></button>
	</div>	
</div>
	
<?php
			mysqli_close($cons);
		}
		else
		{  echo "</div></div>";
	?>
<div class="col-md-8 col-md-offset-2 " style="border:1px solid #ddd; background-color:#f6f6f6; border-radius:5px;margin-top:20px; text-align:center; font-weight:bold;padding:10px;">
	<span style="margin-top:2px;"> No results found for your parameters and budget <?php echo "(".$exchsign."".round($budgetmin*$exch)." - ".$exchsign."".round($budgetmax*$exch).")"; ?>.<br> Try different search options. <br></span>
</div>
<?php
		}
?>
<script type="text/javascript"> excode='<?php echo $_SESSION['exchcode']; ?>';
$.getScript("../lib/js/jquery.matchHeight-min.js").done(function(){ $.getScript("search/lib/js/results.js"); });
<?php
if (isset($browse_by)&&$browse_by!==0)
{ ?>
	var el=document.getElementById("SearchParameters");
	 if ($(window).width() > 768) {
	 	if(el.style.display == "none"){ $( ".SearchParameters" ).toggle("slow");  document.getElementsByClassName("leftMenuFilters")[0].classList.add("rotate"); }
	  }
	
<?php echo $set_j_ssearch; } ?>
</script>