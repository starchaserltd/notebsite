<?php
require_once("etc/conf.php"); ?>
<script>$.getScript("search/lib/js/ssearch.js");</script>
<style>
.xxtest + span.select2.select2-container.select2-container--default {font-size:13px;} 	
.xxtest + span.select2.select2-container.select2-container--default span.selection span.select2-selection.select2-selection--multiple{border: solid #d9d9d9 1px;
min-height: 30px;
line-height: 18px;}
.xxtest + span.select2.select2-container.select2-container--default.select2-container--below.select2-container--focus.select2-container--open span.selection span.select2-selection.select2-selection--multiple{border: 1px solid black ;}

</style>
	<div class="col-md-12 col-sm-12 col-xs-12" style="padding:0 5px;">	
		<form style="overflow:hidden" action="javascript:void(0);" method="post" id="s_search">
				<div style="font-size:14px; font-weight:bold;margin-top:5px">Producer</div>			
				<select class="xxtest" id="s_prod_id" name ="s_prod[]" data-placeholder="Ex. Lenovo, Dell, Apple" multiple="multiple" style="width: 100%;"></select>
				<div style="margin-top:10px; font-size:14px;font-weight:bold; margin-bottom:2px;">Laptop type</div>			
				<select name ="type" id="type">
					<option value="99">All</option>
					<option value="1">Mainstream</option>
					<option value="2">Ultraportable</option>
					<option value="3">Business</option>
					<option value="4">Gaming</option>
					<option value="5">CAD/3D modeling</option>	
				</select>

				<div style="margin-top:10px; font-size:14px;font-weight:bold; margin-bottom:2px;">Processor type</div>	
				<select id="cpu_type" name="cpu_type[]" multiple>
					<option value="1" data-name="Intel">Intel any</option>
					<option value="2" data-name="Core i3">Intel Core i3</option>
					<option value="3" data-name="Core i5">Intel Core i5</option>
					<option value="4" data-name="Core i7">Intel Core i7</option>
					<option value="5" data-name="AMD">AMD any</option>
					<option value="6" data-name="Ryzen">AMD Ryzen</option>
					<option value="7" data-name="HT">Hyper-threading</option>
					<option value="8" data-name="4-core">4-core processor</option>
					<option value="9" data-name="6-core">6-core processor</option>
				</select>				
						
				<div style="margin-top:10px;">
					<span style="font-weight: bold;">
					Memory size:</span>		<span id="s_memval">2 - 32</span> GB
				 </div>	
				<div style="padding:0px 15px 0px 10px">					
					<div style="margin-top:3px;" id="s_mem"></div>
					<input type="hidden" name="s_memmin" id="s_memmin" value="1">	
					<input type="hidden" name="s_memmax" id="s_memmax" value="2">
				</div>
				
				<div style="margin-top:10px;">
					<span style="font-weight:bold;">
					Storage size:</span> 						
					<br> 
					<span id="s_hddval">32 - 1000</span> GB
					<div class="checkbox" style="float:right;margin-top:-2px;margin-right:15%;">
						<input type="checkbox" name="ssd" class="css-checkbox sme" id="checkboxpre" style="margin-left:0px;" checked />
						<label for="checkboxpre" class="css-label sme depressed" style="font-weight:normal;min-height:16px;">SSD</label>	
					</div>
				 </div>	
				<div style="padding:0px 15px 0px 10px">					
					<div style="margin-top:3px;" id="s_hdd"></div>
					<input type="hidden" name="s_hddmin" id="s_hddmin" value="1">	
					<input type="hidden" name="s_hddmax" id="s_hddmax" value="2">
				</div>	
				
				<div style="margin-top:10px;"><span style="font-weight:bold;">
					Display size:</span>  <span id="s_dispsizeval">10.1 - 21</span> inch
				 </div>	
				<div style="padding:0px 15px 0px 10px">					
					<div style="margin-top:3px;" id="s_dispsize"></div>
					<input type="hidden" name="s_dispsizemin" id="s_dispsizemin" value="1">	
					<input type="hidden" name="s_dispsizemax" id="s_dispsizemax" value="2">
				</div>
				
								<div style="margin-top:10px; font-size:14px;font-weight:bold; margin-bottom:2px;">Display quality</div>	
				<select id="display_type" name="display_type[]" multiple>
					<option value="1" data-name="IPS" selected="selected">IPS panel</option>
					<option value="2" data-name="120Hz">120Hz panel</option>
					<option value="3" data-name="FHD" selected="selected">FHD resolution</option>
					<option value="4" data-name="2K">2K resolution</option>
					<option value="5" data-name="4K">4K resolution</option>
					<option value="6" data-name="High gamut">High color gamut</option>
					<option value="7" data-name="No touch" selected="selected">No touchscreen</option>
					<option value="8" data-name="Touch">Touchscreen</option>
					<option value="9" data-name="Stylus">Stylus support</option>
				</select>
				
				<div style="margin-top:10px; font-size:14px;font-weight:bold; margin-bottom:2px;">Graphics</div>	
				<select id="graphics" name="graphics[]">
					<option value="1">Basic</option>
					<option value="2">Average</option>
					<option value="3">High-end</option>
				</select>
				
				<div><div class="col-md-6 col-sm-6 col-xs-6" style="margin-top:10px;font-weight:bold;padding:0">Available in</div>	
				<div class="col-md-6 col-sm-6 col-xs-6" style="padding:0; margin-top:15px;"><select id="region_type" name="region_type[]">
					<option value="1">USA</option>
					<option value="2">Europe</option>
				</select></div></div>
					
				<?php include ("lib/php/currency.php");?>
				<script type="text/javascript">
					<?php echo $jscurrency; //these variables come from lib/currency.php ?>
					var basevalueold=currency_val[<?php echo '"'.$basevalue.'"'; ?>];
					var minbudgetnomen=<?php echo $minconfigprice; ?>;
					var maxbudgetnomen=<?php echo $maxconfigprice; ?>;
				</script>
				<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding:0px">	
				<div>
				<span style="margin-top:30px;font-weight:bold; margin-bottom:2px;">
						Budget:<br></span>
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
								<div class="col-md-8 col-xs-6 col-sm-6 col-lg-7" style="padding:0px" >
								<div id="2"><input type="tel" name="bdgmin" id="bdgmin" value="300" size="1" maxlength="5" onchange="checkmin();"  onkeydown="if (event.keyCode == 13) { checkmin(); return false; }" class="budget"> - 
								<input type="tel" name="bdgmax" id="bdgmax" value="2000" size="1" maxlength="5" onchange="checkmax();" onkeydown="if (event.keyCode == 13) { checkmax(); return false; }" class="budget" ></div> 
								</div>
								<div class="col-md-4 col-xs-3 col-sm-2 col-lg-5" style="padding:0px; padding-right:5px;">
									<select name ="exchange" id="currency" onchange="sliderrange(this); this.oldvalue = this.value; console.log(this);">
									<?php echo $var_currency;  //these variables come from lib/currency.php ?>
									</select>	
								</div>
							</div>						
						</div>
				</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" style="margin-top:10px;padding-left:10px">
					<div id="budget"></div>
				</div>
			<input type="submit" id="s_search_btn" class="btn blue bsub" style="margin-top:23px;margin-bottom: 23px; padding:5px 25px 5px 25px; border-radius:1px; color:#fff; width:100%;" value="Apply filters">
	</form>	
</div>
	