<script>$.getScript("search/lib/js/ssearch.js");</script>

	<div class="col-md-12 col-sm-12 col-xs-12" style="padding-right:0px; padding-left:5px; padding-top:20px">	
		<div style="text-align:center; font-size:17px; font-weight:bold;">Quick laptop search</div>
		
		<form action="javascript:void(0);" method="post" id="s_search">
				<div style="margin-top:5px; font-size:14px;font-weight:bold; margin-bottom:2px;">Laptop type</div>			
				<select name ="type" id="type">
					<option value="1">Normal</option>
					<option value="2">Ultraportable</option>
					<option value="3">Business</option>
					<option value="4">Gaming</option>
					<option value="5">CAD/3D Design</option>	
				</select>

				<div style="margin-top:5px; font-size:14px;font-weight:bold; margin-bottom:2px;">Focus on</div>			
				<select name ="performfocus" id="performfocus">
					<option value="1">Balanced features</option>
					<option value="2">Long battery life</option>
					<option value="3">High performance</option>
					
				</select>
					
				<div style="margin-top:5px; font-size:14px;font-weight:bold; margin-bottom:2px;">Graphic needs</div>			
				<select name ="graphics" id="graphics">
					<option value="1">Essential</option>
					<option value="2">Casual gaming</option>
					<option value="3">High performance</option>
				</select>		
				
				
				<div style="font-size:14px;font-weight:bold; margin-bottom:2px; margin-top:5px">Display</div>			
				
					<input type="radio" name="display" value="1" id="disp_normal" class="css-radiobox">
					<label for="disp_normal" class="css-labelr" style="font-weight:normal">Normal</label>
						<br>
					<input type="radio" name="display" value="2" id="disp_hq" class="css-radiobox" checked="checked">
					<label for="disp_hq" class="css-labelr" style="font-weight:normal">High quality</label>
					<div class="checkbox" style="margin:0px;">
								<input type="checkbox" name="touchscreen_s" class="css-checkbox sme" id="touchscreen_s" style="margin-left:0px;" />
					<label for="touchscreen_s" class="css-label sme depressed" style="font-weight:normal;min-height:16px;">Touchscreen only</label>
				</div>
			
			<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" >
				
			</div>
			
												
				<div style="margin-top:10px; font-size:14px;font-weight:bold; margin-bottom:2px;">Storage</div>	
				<select id="storage" name="storage[]" multiple>
					<option value="1" selected="selected">Normal</option>
					<option value="2">High capacity</option>
					<option value="3">Very fast</option>
				</select>
					
				
				<div style="margin-top:10px;"><span style="margin-top:10px; font-size:14px;font-weight:bold; margin-bottom:2px;">
					Warranty:</span>  <span id="warval">1 - 2</span> years
				 			</div>	
				<div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">					
				  <div style="margin-top:3px;" id="waranty"></div>
				<!-- Vedeti ca trebuie adaugate campuri hidden pentru a transmite variabilele din slidere, atentie la variabilele default care acum se iau din form -->
				<input type="hidden" name="warmin" id="warmin" value="1">	
				<input type="hidden" name="warmax" id="warmax" value="2">
				</div>	

				
				<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
				<div class="checkbox" style="float:right;">
					<input type="checkbox" name="premium" class="css-checkbox sme" id="checkboxpre" style="margin-left:0px;" />
					<label for="checkboxpre" class="css-label sme depressed" style="font-weight:normal;min-height:16px;">On-site repair
					</label>	
				</div>
				</div>
					
				<?php include ("lib/php/currency.php");?>
				<script type="text/javascript">
					<?php echo $jscurrency; //these variables come from lib/currency.php ?>
					var basevalueold=currency_val[<?php echo '"'.$basevalue.'"'; ?>];
					var minbudgetnomen=<?php echo $minconfigprice; ?>;
					var maxbudgetnomen=<?php echo $maxconfigprice; ?>;
				</script>
				<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding:0px">	
				<div style="font-size:14px; margin-top:-5px;">
				<span style="margin-top:30px;font-weight:bold; margin-bottom:2px;">
						Budget:<br></span>
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
								<div class="col-md-8 col-xs-4 col-sm-2 col-lg-7" style="padding:0px" >
								<div id="2"><input type="tel" name="bdgmin" id="bdgmin" value="300" size="1" maxlength="5" onchange="checkmin();"  onkeydown="if (event.keyCode == 13) { checkmin(); return false; }" class="budget"> - 
								<input type="tel" name="bdgmax" id="bdgmax" value="2000" size="1" maxlength="5" onchange="checkmax();" onkeydown="if (event.keyCode == 13) { checkmax(); return false; }" class="budget" ></div> 
								</div>
								<div class="col-md-4 col-xs-3 col-sm-2 col-lg-5" style="padding:0px; padding-right:5px;">
									<select name ="exchange" id="currency" onchange="sliderrange(this); this.oldvalue = this.value;">
									<?php echo $var_currency;  //these variables come from lib/currency.php ?>
									</select>	
								</div>
							</div>						
						</div>
				</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" style="margin-top:10px;">
					<div id="budget"></div>
				</div>
			  
			<input type="submit" id="s_search_btn" class="btn blue" style="margin-top:20px; padding:5px 25px 5px 25px; border-radius:1px; color:#fff; width:100%;" value="Submit">
	</form>
   
   <div style="text-align:center;">
      <button  id="sadvsearch" onmousedown="OpenPage('search/adv_search.php',event);" style="padding:5px 25px 5px 25px; border-radius:1px; color:#fff;margin-top:5px; width:100%;" type="button" class="btn blue">Advanced search</button>
   </div>	
</div>
	