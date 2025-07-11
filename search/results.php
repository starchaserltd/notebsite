<?php
ini_set('max_execution_time', 8);
require_once("lib/php/resultlib.php");
$temp_table = "all_conf";
/* GETTING EXCHANGE LIST */
$result = mysqli_query($GLOBALS['con'], "SELECT `code`,`sign`,ROUND(`convr`,5) AS `convr` FROM `".$GLOBALS['global_notebro_site']."`.`exchrate` WHERE `valid`=1");
$exchangelist = mysqli_fetch_all($result);
$result = mysqli_query($GLOBALS['con'], "SELECT id,disp FROM `".$GLOBALS['global_notebro_db']."`.REGIONS");
while ($row = mysqli_fetch_array($result)) {
	$regions[$row[0]] = $row[1];
}
?>
<script>
	var show_buy_list = 1;
</script>
<div class="row headerback">
	<div class="col-12" style="background-color:white; padding:0;">

		<!-- Results bar -->
		<div class="resultsBar">

			<!-- Refine results button -->
			<div class="refineResultsContainer">
				<button type="button" <?php $nosearch = 0;
					$search_ref = str_replace("/advanced_search", "/adv_search", $absolute_url[0], $nosearch);
					if (!($nosearch)) {
						$search_ref = str_replace("/search.php?", "/adv_search.php?", $absolute_url[0]);
					}
					$text = 'onmousedown="OpenPage(' . "'" . $search_ref;
					foreach ($sortby as $sort) {
					}
					$text .= "',event)" . '"';
					echo $text ?> class="btn btn-primary btn-md">Refine results</button>
			</div>
			<!-- END Refine results button -->

			<?php
			include_once("proc/confsearch.php"); /* WHERE THE REAL SEARCH IS DONE! */
			if ($count > 0) {
				$usertag = "";
				if (isset($_GET["ref"]) && $_GET["ref"] != "") {
					$usertag = mysqli_real_escape_string($con, filter_var($_GET["ref"], FILTER_SANITIZE_STRING));
				}
			?>

				<!-- Order by filters -->
				<div class="orderByContainer">
					<span>Order by:</span>
					<button type="button" class="btn btn-outline-primary<?php echo $value_button; ?>" onmousedown="OpenPage(sortresults('value'),event)"><a>value</a></button>
					<button type="button" class="btn btn-outline-primary<?php echo $price_button; ?>" onmousedown="OpenPage(sortresults('price'),event)"><a>price</a></button>
					<button type="button" class="btn btn-outline-primary<?php echo $name_button; ?>" onmousedown="OpenPage(sortresults('name'),event)"><a>name</a></button>
					<button type="button" class="btn btn-outline-primary<?php echo $performance_button; ?>" onmousedown="OpenPage(sortresults('performance'),event)"><a>performance</a></button>
					<div class="btn-group" style="width:auto!important;margin-left:3px">
						<button type="button" data-toggle="dropdown" class="btn btn-outline-primary dropdown-toggle"><?php echo '<a>' . $exchsign . '</a>'; ?>
							<span class="caret"></span></button>
						<ul class="dropdown-menu" style="margin-top:0px;margin-bottom:0px;padding:0px;border-radius: 3px;min-width:35px!important;border-top-width: 0px;">
							<?php
							foreach ($exchangelist as $exchc) {
								if ($exchc[0] != $exchcode) {
									echo '							<li class="exchangeres" style="width:35px;text-align:center"><a onmousedown="OpenPage(exchangeresults(' . "'" . $exchc[0] . "'" . '),event)">' . $exchc[1] . '</a></li>';
								}
							}
							?>
						</ul>
					</div>
				</div>
				<!-- END Order by filters -->

		</div>
		<!-- END Refine results bar -->

		<?php include_once("../libnb/php/aff_modal.php"); ?>
		<div class="row" style="margin: 0;">
			<?php
				$cons = dbs_connect();
				$startpos = ($page - 1) * 20;
				$i = 0;
				for ($pos = $startpos; $pos < ($startpos + 20); $pos++) {
					if ($pos >= $count) {
						break;
					}
					$rand = $results[$pos];
					getdetails($rand['model']);
					$value = array();
					$m_region = "";
					$exchcode_model = $exchcode;
					$exch_model = $exch;
					$exchsign_model = $exchsign;
					if (isset($region_ex[$region_m_id]) && (!in_array($region_m_id, $search_regions_array) || ($always_model_region && $region_m_id != 1 && $region_m_id != 0))) {
						$exchcode_model = $region_ex[$region_m_id];
						$value = $exchange_list->{"code"}->{$exchcode_model};
						$exch_model = $value["convr"];
						$exchsign_model = $value["sign"];
						if (!isset($regions_name[$region_m_id])) {
							$regions_name[$region_m_id] = show('disp', 'REGIONS', $region_m_id);
						}
						$m_region = "(" . $regions_name[$region_m_id] . ")";
					} else {
						if ($region_m_id == 0) {
							$m_region = "(NoAvb)";
						}
					}

			?>
				<!-- Result item -->
				<div class="searchresult-spacing col-md-6 col-sm-6 col-lg-4 col-xs-12 col-xl-3">
					<div class="searchresult">
						<div class="searchresult-content" onmousedown="OpenPage('model/model.php?conf=<?php echo $rand['id'] . "_" . $rand['model'] . "&ex=" . $exchcode_model; ?>',event); scrolltoid('content',0);">
							<div class="searchresultJPG">
								<a>
									<img src="../res/img/models/thumb/<?php echo $t_img; ?>" class="img-responsive img-fluid" alt="Image for <?php echo $model; ?>">
								</a>
							</div>
							<div class="searchresultitlu">
								<a>
									<p>
										<?php
										echo $prod . " ";
										echo $fam . " ";
										echo $model;
										if ($m_region !== "") {
											echo " " . $m_region . " ";
										}
										//echo show('submodel','MDB',$rand['mdb'] );
										?>
									</p>
								</a>
							</div>
							<div class="searchresultdesc">
								<a>
									<ul>
										<li class="resulspace"><?php echo show('size', 'DISPLAY', $rand['display']) . '" - ' . show('hres', 'DISPLAY', $rand['display']) . "x" . show('vres', 'DISPLAY', $rand['display']) . ""; ?></li>
										<li class="resulspace"><?php echo show('prod', 'CPU', $rand['cpu']) . " " . show('model', 'CPU', $rand['cpu']) . ""; ?></li>
										<li class="resulspace"><?php echo show('prod', 'GPU', $rand['gpu']) . " " . show('name', 'GPU', $rand['gpu']); ?></li>
										<li class="resulspace"><?php echo showmem('cap, type, freq', 'MEM', $rand['mem']);
																						echo " "; ?></li>
										<li class="resulspace"><?php echo showhdd('cap,type,rpm', 'HDD', $rand['hdd'], $rand['shdd']);
																						echo ""; ?></li>
										<li class="resulspace"><?php $kgw = show('weight', 'CHASSIS', $rand['chassis']);
																						echo round(floatval($kgw), 2) . " Kg / " . round(floatval($kgw * 2.20462262), 2) . " lb"; ?></li>
										<li class="resulspace"><?php showsist('sist,vers,type', 'SIST', $rand['sist']);
																						echo " "; ?></li>
										<li class="resulspace"><?php $conf_price = showpricebat('`'.$GLOBALS['global_notebro_sdb'].'`.all_conf_' . $rand['model'], $rand['id'], $exch_model);
																						echo " "; ?></li>
									</ul>
								</a>
							</div>
						</div>

						<!-- Result price -->
						<div class="btn btn-outline-secondary searchprice fakeBtn"><?php echo "";
																																				echo $exchsign_model . " " . $conf_price_text; ?>
						</div>

						<!-- Result actions -->
						<div class="buttons-area row justify-content-between">
							<div class="buy btn btn-primary buyBtn col-lg-6 col-md-5 col-sm-6 col-xs-6 col-xxs-12">
								<div class="dropdown">
									<div id="dLabel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-ref="<?php if (isset($usertag) && $usertag != "")
									{
										echo $usertag;
									} else {
										echo "";
									} ?>" data-target="buylist-<?php echo $i; ?>" data-price="<?php echo $conf_price; ?>" data-mprod="<?php echo $prod; ?>" data-idmodel="<?php echo $rand['model']; ?>" data-buyregions="<?php echo $region_m_id; ?>" data-pmodel="<?php echo $p_model; ?>" data-lang="<?php echo $exch_id; ?>" <?php foreach ($laptop_comp_list as $comp)
									{
										echo " data-id" . $comp . "=" . '"' . $rand[$comp] . '"';
									} ?> onclick="get_buy_list(this);">
										<span class="resultsBuyText">Buy</span>
										<span class="caret"></span>
									</div>
									<ul class="dropdown-menu" aria-labelledby="dLabel" id="buylist-<?php echo $i;
																																									$i++; ?>">
										<li class="loaderContainer">
											<span class="loader"></span>
										</li>
									</ul>
								</div>
							</div>
							<div class="btn btn-outline-primary col-xs-6 col-sm-6 col-md-7 addtocpmp col-xxs-12 col-lg-6" onclick="addcompare('<?php echo $rand['id'] . "_" . $rand['model']; ?>')">Compare</div>
						</div>
						<!-- END Result actions -->

					</div>
				</div>
				<!-- END Result item -->
			<?php
				} // End for
			?>
		</div>
		<?php

				$j = 0;
				foreach ($absolute_url as $urlpart) {
					$sortby = explode("sort_by", $urlpart);
					$sortext = "";

					for ($i = 1; $i < count($sortby); $i++) {
						$absolute_url[$j] = str_replace("&sort_by" . $sortby[$i], "", $urlpart);
						$sortext .= "&sort_by" . $sortby[$i];
					}
					$j++;
				}
		?>
	</div>
</div>
<div class="row bg-white" style="margin:0;">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<ul class="pagination" style="padding-top:20px;justify-content:center">
			<li class="page-item"><a class="page-link" style="color:#000; cursor:pointer;" <?php echo 'onmousedown="OpenPage(' . "'" . $absolute_url[0] . "&page=1" . $sortext . "',event);" . 'scrolltoid(' . "'" . 'content' . "'" . ',0);"'; ?>>&lt;&lt;</a></li>
			<li class="page-item"><a class="page-link" <?php $newpage = $page - 1;
			if ($newpage < 1) {
				$newpage = 1;
			}
			echo 'onmousedown="OpenPage(' . "'" . $absolute_url[0] . "&page=" . $newpage . $sortext . "',event);" . 'scrolltoid(' . "'" . 'content' . "'" . ',0);"'; ?> style="color:#000; cursor:pointer;">&lt;</a></li>
			<?php
				$count = ceil($count / 20);
				if ($count < 5) {
					for ($i = 1; $i <= $count; $i++) {
						if ($i == $page) {
							echo '			<li class="page-item"><a  class="page-link" onmousedown="OpenPage(' . "'" . $absolute_url[0] . "&page=" . $i . $sortext . "',event);" . 'scrolltoid(' . "'" . 'content' . "'" . ',0);" style="color:#000; cursor:pointer;"><b>' . $i . '</b></a></li>';
						} else {
							echo '			<li class="page-item"><a  class="page-link" onmousedown="OpenPage(' . "'" . $absolute_url[0] . "&page=" . $i . $sortext . "',event);" . 'scrolltoid(' . "'" . 'content' . "'" . ',0);" style="color:#000; cursor:pointer;">' . $i . '</a></li>';
						}
					}
				} else {
					$limit = $page + 2;
					$min = $page - 2;

					if ($limit > $count) {
						$limit = $count;
					}
					if ($min < 1) {
						$min = 1;
					}

					for ($i = $min; $i <= $limit; $i++) {
						if ($i == $page) {
							echo '			<li class="page-item"><a class="page-link" onmousedown="OpenPage(' . "'" . $absolute_url[0] . "&page=" . $i . $sortext . "',event);" . 'scrolltoid(' . "'" . 'content' . "'" . ',0);" style="color:#000; cursor:pointer;"><b>' . $i . '</b></a></li>';
						} else {
							echo '			<li class="page-item"><a class="page-link" onmousedown="OpenPage(' . "'" . $absolute_url[0] . "&page=" . $i . $sortext . "',event);" . 'scrolltoid(' . "'" . 'content' . "'" . ',0);" style="color:#000; cursor:pointer;">' . $i . '</a></li>';
						}
					}
				}
			?>
			<li class="page-item"><a class="page-link" <?php $newpage = $page + 1;
			if ($newpage > $count) {
				$newpage = $count;
			}
			echo 'onmousedown="OpenPage(' . "'" . $absolute_url[0] . "&page=" . $newpage . $sortext . "',event);" . 'scrolltoid(' . "'" . 'content' . "'" . ',0);"';; ?> style="color:#000; cursor:pointer;">></a></li>
			<li class="page-item"><a class="page-link" <?php echo 'onmousedown="OpenPage(' . "'" . $absolute_url[0] . "&page=" . $count . $sortext . "',event);" . 'scrolltoid(' . "'" . 'content' . "'" . ',0);"'; ?> style="color:#000; cursor:pointer;">>></a></li>
		</ul>

	</div>
</div>

<?php
				mysqli_close($cons);
			} else {
				echo "</div>";
?>
	<div class="match-info">
		<div class="match-info__container">
		<?php
				if ($presearch_models_nr > 0) {

					$presearch_text = array();
					$presearch_text["laptop"] = "laptops";
					$presearch_text["match"] = "match";
					$presearch_text["they"] = "they are all";
					if ($presearch_models_nr == 1) {
						$presearch_text["laptop"] = "laptop";
						$presearch_text["match"] = "matches";
						$presearch_text["they"] = "it is";
					}
					preg_match("/(.search\.php)(.+)/", $_SERVER["REQUEST_URI"], $search_matches);
					if (isset($search_matches[2])) {
						$search_string = $search_matches[2];
					} else {
						$search_string = "";
					}
					$pre_minbat_text = "with lower battery life.";
					if ($issimple) {
						$search_string = preg_replace("/.bdgmin=\d+/", "", preg_replace("/.bdgmax=\d+/", "", $search_string));
					} else if (isset($_GET['advsearch']) && $_GET['advsearch']) {
						if ($presearch_min_batlife < ($batlife_min / 2)) {
							$presearch_min_batlife = $batlife_min / 2;
						}
						$search_string = preg_replace("/.batlifemin=[0-9]*\.?[0-9]/", "&batlifemin=" . $presearch_min_batlife, preg_replace("/.bdgminadv=\d+/", "", preg_replace("/.bdgmaxadv=\d+/", "", $search_string)));
					} else if (isset($_GET['quizsearch']) && $_GET['quizsearch']) {
						if ($presearch_min_batlife < 7.5) {
							$search_string = preg_replace("/12hour=1/", "12hour=0", $search_string);
							if (stripos($search_string, "10hour") === FALSE) {
								$search_string .= "&10hour=1";
							}
						}
						if ($presearch_min_batlife < 4.9) {
							$search_string = preg_replace("/10hour=1/", "10hour=0", $search_string);
							if (stripos($search_string, "6hour") === FALSE) {
								$search_string .= "&6hour=1";
							}
						}
						if ($presearch_min_batlife < 2.7) {
							$search_string = preg_replace("/6hour=1/", "6hour=0", $search_string);
							if (stripos($search_string, "2hour") === FALSE) {
								$search_string .= "&2hour=1";
							}
						}
						if ($presearch_min_batlife < 0.9) {
							$search_string = preg_replace("/2hour=1/", "2hour=0", $search_string);
						}
						$search_string = preg_replace("/.b\d+=1/", "", $search_string);
					} else {
						$search_string = "";
					}
					if ($search_string != "") {
						$search_string = "search/search.php" . $search_string;
					}
					echo '<div style="margin-top:2px;">We found at least <span style="font-size: 12pt;"><a href="javascript:void(0);" onmousedown="OpenPage(' . "'" . $search_string . "'" . ')"><b>' . $presearch_models_nr . ' ' . $presearch_text["laptop"] . '</b></a></span> that ' . $presearch_text["match"] . ' your search criteria, but ' . $presearch_text["they"] . ' outside your budget range (' . $exchsign . "" . round($budgetmin * $exch) . " - " . $exchsign . "" . round($budgetmax * $exch) . ') and ' . $pre_minbat_text . '<br><br><a href="javascript:void(0);" onmousedown="OpenPage(' . "'" . $search_string . "'" . ')">You can see here the matches outside your budget.<br></a></div>';
				} else {
					echo '<span style="margin-top:2px;">We are sorry we could not find any laptops that match your search criteria.<br>';
					$comp_mess = array();
					foreach ($no_comp_search as $val) {
						switch ($val) {
							case "model": {
									echo "<span style='font-size: 12pt'>We could not find any <b>laptop models</b> that match your family and producer specifications.</span>";
									break;
								}
							case "cpu": {
									$comp_mess[] = "processors";
									break;
								}
							case "display": {
									$comp_mess[] = "displays";
									break;
								}
							case "mem": {
									$comp_mess[] = "laptop memories";
									break;
								}
							case "hdd": {
									$comp_mess[] = "hard drives";
									break;
								}
							case "shdd": {
									$comp_mess[] = "secondary storages";
									break;
								}
							case "gpu": {
									$comp_mess[] = "video cards";
									break;
								}
							case "wnet": {
									$comp_mess[] = "wireless cards";
									break;
								}
							case "odd": {
									$comp_mess[] = "optical drives";
									break;
								}
							case "mdb": {
									$comp_mess[] = "laptop motherboards";
									break;
								}
							case "chassis": {
									$comp_mess[] = "laptop chassis";
									break;
								}
							case "acum": {
									$comp_mess[] = "batteries";
									break;
								}
							case "war": {
									$comp_mess[] = "warranties";
									break;
								}
							case "sist": {
									$comp_mess[] = "operating systems";
									break;
								}
							default: {
									break;
								}
						}
					}
					if (isset($comp_mess[0])) {
						foreach ($comp_mess as $val) {
							echo "<br><span style='font-size: 12pt'>It seems there are no <b>" . $val . "</b> that match your search options.</span>";
						}
					}
					echo '<br><br>Regardless of budget, there are simply no laptops in our database with your technical requirements.<br>Try different search options.</span>';
				}

		?>
		</div>
	</div>
<?php
			}
?>
<script type="text/javascript">
	excode = '<?php echo $_SESSION['exchcode']; ?>';
	$.getScript("search/lib/js/old_var_proc.js").done(function(){$.getScript("search/lib/js/results.js");});
	var show_buy_list = 1;
	<?php
	if (isset($browse_by) && $browse_by !== 0) { ?>
		var el = document.getElementById("SearchParameters");
		if ($(window).width() > 768) {
			if (el.style.display == "none") {
				$(".SearchParameters").toggle("slow");
				document.getElementsByClassName("leftMenuFilters")[0].classList.add("rotate");
			}
		}

	<?php echo $set_j_ssearch;
	} ?>
</script>