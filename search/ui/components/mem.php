<script>{ const search_form_id='<?php echo $search_form_id; ?>'; const wait_main_search_scripts = setInterval(function () { if (main_search_scripts_loaded === true) { $.getScript("search/ui/components/mem.js").done(function(){init_search_mem(search_form_id);}); clearInterval(wait_main_search_scripts); } }, 20); }</script>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr class="" style="height:5px;"></div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="font-size:16px; font-weight:bold;padding-bottom:5px;">Memory</div>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div style="margin-top:5px;"><span style="margin-top:5px; font-size:13.5px; margin-bottom:2px;">
									Capacity:</span>  <span id="<?php echo $search_form_id;?>_ramval"><?php echo $memcapmin; ?> - <?php echo $memcapmax; ?> GB</span>
								</div>	  
								<div class="advslider" style="margin-top:3px;" id="<?php echo $search_form_id;?>_ram"></div>
								<input type="hidden" name="mem_rammin" id="<?php echo $search_form_id;?>_mem_rammin" value="<?php echo $memcapmin; ?>">	
								<input type="hidden" name="mem_rammax" id="<?php echo $search_form_id;?>_mem_rammax" value="<?php echo $memcapmax; ?>">				
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hiddenOptionsMemory">
								<div style="margin-top:10px;"><span style="margin-top:5px; font-size:13.5px; margin-bottom:2px;">
									Speed:</span>  <span id="<?php echo $search_form_id;?>_freqval"><?php echo $memfreqmin; ?> - <?php echo $memfreqmax; ?> MHz</span>
								</div>	  
								<div class="advslider" style="margin-top:3px;" id="<?php echo $search_form_id;?>_freq"></div>
								<input type="hidden" name="mem_freqmin" id="<?php echo $search_form_id;?>_mem_freqmin" value="<?php echo $memfreqmin; ?>">	
								<input type="hidden" name="mem_freqmax" id="<?php echo $search_form_id;?>_mem_freqmax" value="<?php echo $memfreqmax; ?>">				
							</div>
						</div>
						<div class="col-xs-12 col-md-6 col-md-6 col-lg-6" >
							<div class="col-md-12 col-sm-12 hiddenOptionsMemory">
								<div>Type</div>			
								<select onchange="presearch('#<?php echo $search_form_id;?>');" id="<?php echo $search_form_id;?>_mem_type" name="mem_type[]" multiple>
									<?php if(isset($droplists[53])) { echo $droplists[53]; } ?>
								</select>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 toggleHiddenButtonsMemory toolinfo" data-toolid="101" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 700}' data-placement="top" data-original-title="data-loading..." aria-hidden="true">
							<span class="glyphicon glyphicon-chevron-down fas fa-angle-down"></span>
						</div>		
					</div><!-- Row -->
				</div><!-- Col -->