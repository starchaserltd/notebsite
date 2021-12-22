<script>{ const search_form_id='<?php echo $search_form_id; ?>'; const wait_main_search_scripts = setInterval(function () { if (main_search_scripts_loaded === true) { $.getScript("search/ui/components/display.js").done(function(){init_search_display(search_form_id);}); clearInterval(wait_main_search_scripts); } }, 20); }</script>
<!-- DISPLAY -->
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr style="height:5px; "></div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="font-size:16px; font-weight:bold;padding-bottom:5px;">Display</div>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" >
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div style="margin-top:10px"><span style="font-size:13.5px;">Size:</span>  <span id="<?php echo $search_form_id;?>_displayval"><?php echo $displaysizemin; ?> - <?php echo $displaysizemax; ?> inch</span></div>	  
								<div class="advslider" style="margin-top:5px;" id="display"></div>
								<input type="hidden" name="display_sizemin" id="<?php echo $search_form_id;?>_display_sizemin" value="<?php echo $displaysizemin; ?>">	
								<input type="hidden" name="display_sizemax" id="<?php echo $search_form_id;?>_display_sizemax" value="<?php echo $displaysizemax; ?>">				
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div style="margin-top:10px;"><span style="font-size:13.5px;">Vertical resolution:</span>  <span id="<?php echo $search_form_id;?>_verresval"><?php echo $displayvresmin; ?> - <?php echo $displayvresmax; ?> pixels</span></div>	  
								<div class="advslider" style="margin-top:5px;" id="verres"></div>
								<input type="hidden" name="display_vresmin" id="<?php echo $search_form_id;?>_display_vresmin" value="<?php echo $displayvresmin; ?>" data-lcom='DISPLAY_resol' data-lfield="vresmin">	
								<input type="hidden" name="display_vresmax" id="<?php echo $search_form_id;?>_display_vresmax" value="<?php echo $displayvresmax; ?>" data-lcom='DISPLAY_resol' data-lfield="vresmax">				
							</div>					
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div onchange="presearch('#advform');" class="checkbox" style="text-align: right;">
									<input type="checkbox" name="display_touchscreen"  id="<?php echo $search_form_id;?>_display_touchscreen" class="css-checkbox sme" style="margin-left:0px;" <?php echo $tcheck; ?>/>
									<label for="touchscreen" class="css-label sme depressed" style="font-weight:normal;min-height:16px;">Touchscreen</label>
									&nbsp;
									<input type="checkbox" name="display_nontouchscreen"  id="<?php echo $search_form_id;?>_display_nontouchscreen" class="css-checkbox sme" style="margin-left:0px;" <?php echo $ntcheck; ?>/>
									<label for="nontouchscreen" class="css-label sme depressed" style="font-weight:normal;min-height:16px;">No Touchscreen</label>
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hiddenOptionsDisplay">
								<div>Surface type</div>			
								<select onchange="presearch('#advform');" id="<?php echo $search_form_id;?>_surface" name="Display_surface_id[]" multiple="multiple">
									<?php if(isset($droplists[56])) { echo $droplists[56]; } ?>
								</select>
							</div>	
						</div>	
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
								<div style="margin-top:12px;">Other features</div>
								<select onchange="presearch('#advform');" class="multisearch js-example-responsive" name="DISPLAY_msc_id[]" id="<?php echo $search_form_id;?>_DISPLAY_msc_id" data-lcom="none" data-lfield="none" data-placeholder="Ex. LED TN, 120Hz, G-Sync, 80% sRGB" data-ajax--url="search/lib/func/list.php" multiple="multiple" style="width:100%;"></select>
							</div>							
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hiddenOptionsDisplay">
								<div>Ratio</div>			
								<select onchange="presearch('#advform');" id="<?php echo $search_form_id;?>_DISPLAY_ratio_id" name="DISPLAY_ratio_id[]" data-lcom='DISPLAY_resol' data-lfield="prop" multiple="multiple">
									<?php if(isset($droplists[8])){ echo $droplists[8]; } ?>
								</select>
							</div>					
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hiddenOptionsDisplay">
								<div>Resolutions</div>
								<select onchange="presearch('#advform');" class="multisearch js-example-responsive" name="DISPLAY_resol_id[]" id="<?php echo $search_form_id;?>_DISPLAY_resol_id" data-lcom="none" data-lfield="none" data-placeholder="Ex. 3200x1800" data-ajax--url="search/lib/func/list.php" multiple="multiple" style="width:100%;"></select>
							</div>					
						</div>
						<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 toggleHiddenButtonsDisplay toolinfo" data-toolid="101" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 700}' data-placement="top" data-original-title="data-loading..." aria-hidden="true">
							<span class="glyphicon glyphicon-chevron-down fas fa-angle-down"></span>
						</div>		
					</div><!-- Row -->
				</div><!-- Col -->