<?php
require_once("etc/conf.php"); ?>
<script>
	$.getScript("search/lib/js/ssearch.js");
</script>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<form action="javascript:void(0);" method="post" id="s_search">
			<div style="font-size:14px; margin-top:5px">Producer</div>
			<select onchange="presearch('#s_search');" class="smallselect2" id="s_prod_id" name="s_prod[]" data-placeholder="Ex. Apple, Dell" multiple="multiple" style="width: 100%;"></select>
			<div style="margin-top:10px; font-size:14px; margin-bottom:2px;">Laptop type</div>
			<select onchange="presearch('#s_search');" name="type" id="type">
				<option value="99">All</option>
				<option value="1">Mainstream</option>
				<option value="2">Ultraportable</option>
				<option value="3">Business</option>
				<option value="4">Gaming</option>
				<option value="5">CAD/3D modeling</option>
			</select>

			<div style="margin-top:10px; font-size:14px; margin-bottom:2px;">Processor type</div>
			<select onchange="presearch('#s_search');" id="cpu_type" name="cpu_type[]" multiple>
				<option value="1" data-name="Intel">Intel any</option>
				<option value="2" data-name="Intel 3">Intel 3</option>
				<option value="3" data-name="Intel 5">Intel 5</option>
				<option value="4" data-name="Intel 7/9">Intel 7/9</option>
				<option value="5" data-name="AMD">AMD any</option>
				<option value="6" data-name="Ryzen">AMD Ryzen</option>
				<option value="7" data-name="HT/SMT">Multithreading</option>
				<option value="8" data-name="4-core">4 core processor</option>
				<option value="9" data-name="6-core">6 core processor</option>
				<option value="10" data-name="8-core">8+ core processor</option>
			</select>

			<div style="margin-top:10px;">
				<span style="">Memory size:</span> <span id="s_memval">2 - 32</span> GB
			</div>
			<div style="padding:0px 15px 0px 10px">
				<div class="ssearchslider" style="margin-top:3px;" id="s_mem"></div>
				<input type="hidden" name="s_memmin" id="s_memmin" value="1">
				<input type="hidden" name="s_memmax" id="s_memmax" value="2">
			</div>

			<div style="margin-top:10px;">
				<span style="">Storage size:</span> <span id="s_hddval">32 - 1000</span> GB
				<div onchange="presearch('#s_search');" class="checkbox ssdHome" style="float:right;margin-top:-2px;">
					<input type="hidden" name="ssd" class="css-checkbox sme" id="checkboxpre" style="margin-left:0px;" checked />
					<!-- <label for="checkboxpre" class="css-label sme depressed" style="font-weight:normal;min-height:16px;">SSD</label> -->
				</div>
			</div>
			<div style="padding:0px 15px 0px 10px">
				<div class="ssearchslider" style="margin-top:8px;" id="s_hdd"></div>
				<input type="hidden" name="s_hddmin" id="s_hddmin" value="1">
				<input type="hidden" name="s_hddmax" id="s_hddmax" value="2">
			</div>

			<div style="margin-top:10px;"><span style="">
					Display size:</span> <span id="s_dispsizeval">10.1 - 21</span> inch
			</div>
			<div style="padding:0px 15px 0px 10px">
				<div class="ssearchslider" style="margin-top:3px;" id="s_dispsize"></div>
				<input type="hidden" name="s_dispsizemin" id="s_dispsizemin" value="1">
				<input type="hidden" name="s_dispsizemax" id="s_dispsizemax" value="2">
			</div>

			<div style="margin-top:10px; font-size:14px;margin-bottom:2px;">Display quality</div>
			<select onchange="presearch('#s_search');" id="display_type" name="display_type[]" multiple>
				<option value="1" data-name="IPS" selected="selected">IPS/OLED/mLED panel</option>
				<option value="2" data-name="120Hz+">120Hz+ panel</option>
				<option value="3" data-name="FHD" selected="selected">FHD resolution</option>
				<option value="4" data-name="2K">2K resolution</option>
				<option value="5" data-name="4K">4K resolution</option>
				<option value="6" data-name="High gamut">High color gamut</option>
				<option value="7" data-name="No touch">No touchscreen</option>
				<option value="8" data-name="Touch">Touchscreen</option>
				<option value="9" data-name="Stylus">Stylus support</option>
			</select>

			<div style="margin-top:10px; font-size:14px; margin-bottom:2px;">Graphics</div>
			<select onchange="presearch('#s_search');" id="graphics" name="graphics[]">
				<option value="1">Basic</option>
				<option value="2">Average</option>
				<option value="3">High-end</option>
			</select>

			<!--
			<div class="row margin">
				<div class="col-md-6 col-sm-6 col-xs-6 col-xl-8 col-lg-7" style="margin-top:10px;padding:0;">Available in</div>	
				<div class="col-md-6 col-sm-6 col-xs-6 col-xl-4 col-lg-5" style="margin-top:15px;padding: 0;">
					<select onchange="presearch('#s_search');" id="region_type" name="region_type[]">
						<option value="1">USA</option>
						<option value="2">Europe</option>
					</select>
				</div>
			</div>
			-->

			<?php $reset = 0;
			include("lib/php/currency.php"); ?>
			<script>
				<?php echo $jscurrency; //these variables come from lib/currency.php 
				?>
				var basevalueold = currency_val[<?php echo '"' . $basevalue . '"'; ?>];
				var minbudgetnomen = <?php echo $minconfigprice; ?>;
				var maxbudgetnomen = <?php echo $maxconfigprice; ?>;
			</script>
			<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding:0px">
				<div>
					<span style="margin-top:30px; margin-bottom:2px;">Budget:<br></span>
					<div class="row margin">
						<div class="col col-md-8 col-xs-6 col-sm-6 col-lg-7 col-xl-8" style="padding:0px!important;">
							<div id="2"><input type="tel" name="bdgmin" id="bdgmin" value="300" size="1" maxlength="5" onchange="checkmin();" onkeydown="if (event.keyCode == 13) { checkmin(); return false; }" class="budget"> -
								<input type="tel" name="bdgmax" id="bdgmax" value="2000" size="1" maxlength="5" onchange="checkmax();" onkeydown="if (event.keyCode == 13) { checkmax(); return false; }" class="budget">
							</div>
						</div>
						<div class="col col-md-4 col-xs-3 col-sm-2 col-lg-5 col-xl-4" style="padding: 0;">
							<select name="exchange" id="currency" onchange="sliderrange(this); this.oldvalue = this.value; console.log(this);">
								<?php echo $var_currency;  //these variables come from lib/currency.php 
								?>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" style="margin-top:10px;padding-left:10px">
				<div id="budget"></div>
			</div>
			<input type="submit" id="s_search_btn" class="btn blue bsub" style="" value="Search">
		</form>
	</div>
</div><!-- Row end -->

<div id="presearch-modal">
	<div id="presearch-modal__wrapper">
		<span id="presearch-modal-counter"></span>
		laptops match your search
	</div>
	<div id="presearch-modal-close">&#10060;</div>
</div>