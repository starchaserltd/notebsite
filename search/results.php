<?php
ini_set('max_execution_time', 5);
require_once("lib/php/resultlib.php");
$temp_table = "all_conf";
/* GETTING EXCHANGE LIST */
$result = mysqli_query($GLOBALS['con'], "SELECT code,sign,ROUND(convr,5) convr FROM notebro_site.exchrate"); 
$exchangelist = mysqli_fetch_all($result);
$result = mysqli_query($GLOBALS['con'], "SELECT id,disp FROM notebro_db.REGIONS"); 
while($row=mysqli_fetch_array($result)){ $regions[$row[0]]=$row[1]; }
?>

<div class="row headerback" style="margin:0;">
	<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" style="background-color:white; font-family:arial;padding:0px">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding:3px 0px 5px 0px"> 
				<div class="row">		
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
					<div class="btn-group" style="display: inline-block; float:right;width:auto!important;">
						<a class="btn" style="text-decoration:none;color:black;font-weight:bold;padding:2px 0px 0px 0px;">Order by:</a>
						<button type="button" class="btn btn-result<?php echo $value_button;?>" style="margin-left:10px;border-radius: 1px 0px 0px 1px;"  onmousedown="OpenPage(sortresults('value'),event)"><a style="color:white;text-decoration:none">value</a></button>	
						<button type="button"  class="btn btn-result<?php echo $price_button; ?>" onmousedown="OpenPage(sortresults('price'),event)"><a style="color:white;text-decoration:none">price</a></button>
						<button type="button" class="btn btn-result<?php echo $performance_button; ?>" onmousedown="OpenPage(sortresults('performance'),event)"><a style="color:white;text-decoration:none">perfomance</a></button>	
						<button type="button" class="btn btn-result<?php echo $name_button;?>" style="border-radius: 0px 1px 1px 0px;" onmousedown="OpenPage(sortresults('name'),event)"><a style="color:white;text-decoration:none">name</a></button>		
						<div class="btn-group" style="width:auto!important;margin-left:3px">
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
					</div>		 
				  </div>	
				</div><!-- row end-->
			</div>
		</div>
		<div class="row">
				<?php
				$cons=dbs_connect();
				$startpos = ($page - 1) * 20; $i=0;
				for ($pos = $startpos; $pos < ($startpos + 20); $pos++)
				{
					if ($pos >= $count) 
					{ break; }
					$rand = $results[$pos];
					getdetails($rand['model']);
					$value=array(); $exchcode_model=$exchcode; $exch_model=$exch; $exchsign_model=$exchsign; if(isset($region_ex[$region_m_id])&&(!in_array($region_m_id,$search_regions_array)||$always_model_region)){ $exchcode_model=$region_ex[$region_m_id]; $value=$exchange_list->{$exchcode_model}; $exch_model=$value["convr"]; $exchsign_model=$value["sign"];} 
				?>
				<div class="col-md-6 col-sm-6 col-lg-3 col-6 col-xs-3" style="" >
					<div class="searchresult">
						<div class="searchresultJPG">
							<a onmousedown="OpenPage('model/model.php?conf=<?php echo $rand['id']."_".$rand['model']."&ex=".$exchcode_model;?>',event); scrolltoid('content');">
								<img src="../res/img/models/thumb/<?php echo $t_img; ?>" class="img-responsive img-fluid" alt="Image for <?php echo $model; ?>">
							</a>
						</div>
						<br>
						<div class="searchresultitlu">
							<a onmousedown="OpenPage('model/model.php?conf=<?php echo $rand['id']."_".$rand['model']."&ex=".$exchcode_model;?>',event);">
								<p>
									<?php
										echo $prod; echo " ";
										echo $fam; echo " ";
										echo $model; echo " ";			
										echo show('submodel','MDB',$rand['mdb'] );
									?>
								</p>
							</a>
						</div>
				        <div class="searchresultdesc">
							<a onmousedown="OpenPage('model/model.php?conf=<?php echo $rand['id']."_".$rand['model']."&ex=".$exchcode_model;?>',event);">
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
						<div class="searchprice"><?php echo ""; echo $exchsign_model; echo " "; $conf_price=showprice(('notebro_temp.'.$temp_table."_".$rand['model']), $rand['id'], $exch_model );?></div>
						<div class="row">
							<div class="buy resultsShopBtn col-lg-6 col-md-5 col-sm-6 col-xs-6 col-xxs-12">
								<div class="dropdown">
										<div id="dLabel" class="btn buyBtn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-ref="<?php if(isset($usertag)&&$usertag!=""){ echo $usertag; } else { echo "";} ?>" data-target="buylist-<?php echo $i;?>" data-price="<?php echo $conf_price; ?>" data-idmodel="<?php echo $rand['model']; ?>" data-buyregions="<?php echo $search_regions; ?>" data-cpu="<?php echo $rand['cpu']; ?>" data-gpu="<?php echo $rand['gpu']; ?>" data-iddisplay="<?php echo $rand['display']; ?>" data-pmodel="<?php echo $p_model; ?>"  data-lang="<?php echo $exch_id; ?>" onclick="get_buy_list(this);">
											<span class="fas fa-shopping-cart"></span><span class="resultsBuyText"> Buy</span>
											<span class="caret"></span>
										</div>
										<ul class="dropdown-menu" aria-labelledby="dLabel" id="buylist-<?php echo $i; $i++;?>">
											<li class="loaderContainer">
												<span class="loader"></span>
											</li>
										</ul>
									</div><!-- Dropdown end div-->
							</div>
							<div class="btn col-xs-6 col-sm-6 col-md-7 addtocpmp col-xxs-12 col-lg-6" onclick="addcompare('<?php echo $rand['id']."_".$rand['model'];?>')">Compare
							</div>				
						</div>						
					</div>
				</div>
				<?php
				}
			?>
		</div>
	<?php 
	
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
			<li class="page-item"><a class="page-link" style="color:#000; cursor:pointer;" <?php echo 'onmousedown="OpenPage('."'".$absolute_url[0]."&page=1".$sortext."',event);".'scrolltoid('."'".'content'."'".');"'; ?> >&lt;&lt;</a></li>
			<li class="page-item"><a class="page-link"<?php  $newpage=$page-1; if($newpage<1) {$newpage=1; } echo 'onmousedown="OpenPage('."'".$absolute_url[0]."&page=".$newpage.$sortext."',event);".'scrolltoid('."'".'content'."'".');"'; ?>  style="color:#000; cursor:pointer;">&lt;</a></li>
			<?php
				$count=ceil($count/20);
				if($count<5)
				{  
					for($i=1;$i<=$count;$i++)
					{
						if($i == $page)
						{ echo '			<li class="page-item"><a  class="page-link" onmousedown="OpenPage('."'".$absolute_url[0]."&page=".$i.$sortext."',event);".'scrolltoid('."'".'content'."'".');" style="color:#000; cursor:pointer;"><b>'.$i.'</b></a></li>'; }
						else 
						{ echo '			<li class="page-item"><a  class="page-link" onmousedown="OpenPage('."'".$absolute_url[0]."&page=".$i.$sortext."',event);".'scrolltoid('."'".'content'."'".');" style="color:#000; cursor:pointer;">'.$i.'</a></li>'; }
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
						{ echo '			<li class="page-item"><a class="page-link" onmousedown="OpenPage('."'".$absolute_url[0]."&page=".$i.$sortext."',event);".'scrolltoid('."'".'content'."'".');" style="color:#000; cursor:pointer;"><b>'.$i.'</b></a></li>'; }
						else
						{ echo '			<li class="page-item"><a class="page-link" onmousedown="OpenPage('."'".$absolute_url[0]."&page=".$i.$sortext."',event);".'scrolltoid('."'".'content'."'".');" style="color:#000; cursor:pointer;">'.$i.'</a></li>'; }
					}
				}
			?>
			<li class="page-item"><a class="page-link" <?php  $newpage=$page+1; if($newpage>$count) {$newpage=$count; } echo 'onmousedown="OpenPage('."'".$absolute_url[0]."&page=".$newpage.$sortext."',event);".'scrolltoid('."'".'content'."'".');"';; ?>  style="color:#000; cursor:pointer;">></a></li>
			<li class="page-item"><a class="page-link" <?php echo 'onmousedown="OpenPage('."'".$absolute_url[0]."&page=".$count.$sortext."',event);".'scrolltoid('."'".'content'."'".');"'; ?> style="color:#000; cursor:pointer;" >>></a></li>
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