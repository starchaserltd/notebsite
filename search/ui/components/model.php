<script>{ const search_form_id='<?php echo $search_form_id; ?>'; const wait_main_search_scripts = setInterval(function () { if (main_search_scripts_loaded === true) { $.getScript("search/ui/components/model.js").done(function(){init_search_model(search_form_id);}); clearInterval(wait_main_search_scripts); } }, 20); }</script>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 model_search_ui">
	<div class="row">						
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<div style="font-size:16px; font-weight:bold;">Availability:</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:5px">								
				<select onchange="presearch('#<?php echo $search_form_id;?>');" class="multisearch js-example-responsive" id="<?php echo $search_form_id;?>_MODEL_Regions_id" name ="MODEL_Regions_id[]" data-lcom='regions' data-lfield="name" data-placeholder="Ex. USA, Europe" data-initvalue="All" multiple="multiple" data-ajax--url="search/lib/func/list.php" style="width:100%;"></select>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:15px; font-size:15px;">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">							
					<span style="font-size:16px; font-weight:bold;">Budget:</span>
					<span style="margin-left: 3px;" id="2">
					<input type="tel" name="model_pricemin" id="<?php echo $search_form_id;?>_model_pricemin" value="" size="1" maxlength="5" onchange="checkminadv();" class="budget">  -
					<input type="tel" name="model_pricemax" id="<?php echo $search_form_id;?>_model_pricemax" value="" size="1" maxlength="5" onchange="checkmaxadv();"class="budget" ></span>						
					<select name ="exchadv" id="<?php echo $search_form_id;?>_currencyadv" onchange="sliderrangeadv(this); this.oldvalue = this.value; change_region(this.value);">
						<option value="USD" selected="">$</option>
					</select>
				</div>
				
			</div>
			<br>
			<div class="col-xs-12 col-md-12 col-xs-12">
				<div id="<?php echo $search_form_id;?>_budgetadv"></div>	
			</div>	
		</div>	
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" onchange="presearch('#advform');">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:5px">
				<div style="font-size:16px; font-weight:bold;">Producer</div>			
				<select class="multisearch js-example-responsive" id="<?php echo $search_form_id;?>_MODEL_Producer_id" name="MODEL_Producer_id[]" data-idtype=2 data-lcom='Family_fam' data-lfield="prod" data-placeholder="Ex. Lenovo, Dell, Apple" data-initvalue="All" multiple="multiple" data-ajax--url="search/lib/func/list.php" style="width: 100%;"></select>
				<div style="font-size:16px; font-weight:bold; margin-top:5px">Family</div>
				<select class="multisearch js-example-responsive" id="<?php echo $search_form_id;?>_MODEL_Family_id" name="MODEL_Family_id[]" data-lcom='model' data-lfield="fam" data-placeholder="Ex. Thinkpad, EliteBook, Latitude" data-initvalue="All" multiple="multiple" data-ajax--url="search/lib/func/list.php" style="width:100%;"></select>
			</div>	
		</div>	
	</div><!-- End Row -->					
</div><!-- End Col -->