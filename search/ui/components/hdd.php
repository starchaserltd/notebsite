<script>{ const search_form_id='<?php echo $search_form_id; ?>'; const wait_main_search_scripts = setInterval(function () { if (main_search_scripts_loaded === true) { $.getScript("search/ui/components/hdd.js").done(function(){init_search_hdd(search_form_id);}); clearInterval(wait_main_search_scripts); } }, 20); }</script>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr class="" style="height:5px;"></div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="font-size:16px; font-weight:bold;padding-bottom:5px;">Storage</div>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" >
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div style="margin-top:10px"><span style="font-size:13.5px;">Total Capacity:</span>  <span id="<?php echo $search_form_id;?>_hdd_capacityval"><?php echo $totalcapmin; ?> - <?php echo $totalcapmax; ?> GB</span></div>	  
								<div class="advslider" style="margin-top:5px;" id="capacity"></div>
								<input type="hidden" name="hdd_capmin" id="<?php echo $search_form_id;?>_hdd_capmin" value="<?php echo $totalcapmin; ?>">	
								<input type="hidden" name="hdd_capmax" id="<?php echo $search_form_id;?>_hdd_capmax" value="<?php echo $totalcapmax; ?>">	
							</div>					
							<div style="margin-top: 10px;" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hiddenOptionsStorage">		
								<div>Seconday storage</div>
								<select onchange="presearch('#<?php echo $search_form_id;?>_');" id="<?php echo $search_form_id;?>_hdd_nrhdd" name="hdd_nrhdd">
									<option value="1">Optional</option>
									<option value="2" <?php echo $nrhddselect;?> >Mandatory</option>
									<option value="3" <?php echo $nrhddselect2;?> >Ignore</option>
								</select>
							</div>
						</div>	
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hiddenOptionsStorage">
								<div>min RPM (for HDD option)</div>			
								<select onchange="presearch('#<?php echo $search_form_id;?>_');" id="<?php echo $search_form_id;?>_hdd_rpm" name="hdd_rpm">
									<option value="">Any</option>
									<?php if(isset($droplists[55])){ echo $droplists[55]; } ?>
								</select>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:8px;">						
								<div>Type</div>			
								<select onchange="presearch('#<?php echo $search_form_id;?>_');" id="<?php echo $search_form_id;?>_hdd_type" name="hdd_type[]" multiple="multiple">
									<?php if(isset($droplists[54])) { echo $droplists[54]; } ?>
								</select>
							</div>					
						</div>	
						<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 toggleHiddenButtonsStorage toolinfo" data-toolid="101" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 700}' data-placement="top" data-original-title="data-loading..." aria-hidden="true">
							<span class="glyphicon glyphicon-chevron-down fas fa-angle-down"></span>
						</div>		
					</div><!-- Row -->
				</div><!-- Col -->