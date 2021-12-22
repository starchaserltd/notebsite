<script>{ const search_form_id='<?php echo $search_form_id; ?>'; const wait_main_search_scripts = setInterval(function () { if (main_search_scripts_loaded === true) { $.getScript("search/ui/components/gpu.js").done(function(){init_search_gpu(search_form_id);}); clearInterval(wait_main_search_scripts); } }, 20); }</script>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr style="height:5px;"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="font-size:16px; font-weight:bold;padding-bottom:5px;">Video card</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" onchange="presearch('#advform');">
			<input type="radio" name="gpu_type" value="0" id="r-yes" class="css-radiobox" <?php if($gputype==0){ echo 'checked="checked"';} ?>>
			<label for="r-yes" class="css-labelr" style="font-weight:normal">Integrated</label>
							&nbsp;
			<input type="radio" name="gpu_type" value="1" id="r-no" class="css-radiobox" <?php if($gputype==1){ echo 'checked="checked"';} ?>>
			<label for="r-no" class="css-labelr" style="font-weight:normal">Dedicated</label>
							&nbsp;
			<input type="radio" name="gpu_type" value="2" id="r-any" class="css-radiobox" <?php if($gputype==2){ echo 'checked="checked"';} ?>>
			<label for="r-any" class="css-labelr" style="font-weight:normal">Any</label>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div>Type</div>			
				<select onchange="presearch('#advform');" id="<?php echo $search_form_id;?>_gpu_type2" name="gpu_type2[]" data-lcom='GPU_name' data-lfield="gpu_type" multiple="multiple">
				<option value="10" <?php echo $gputypesel[10] ?>>Integrated Pro</option>
				<option value="0" <?php echo $gputypesel[0] ?>>Integrated + Basic</option>
				<option value="1" <?php echo $gputypesel[1] ?>>Basic</option>
				<option value="2" <?php echo $gputypesel[2] ?>>Gaming</option>
				<option value="3" <?php echo $gputypesel[3] ?>>CAD/3D Modeling</option>
				<option value="4" <?php echo $gputypesel[4] ?>>High-end</option>
				</select>	
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hiddenOptionsGpu">
				<div>Producer</div>
				<select onchange="presearch('#advform');" id="<?php echo $search_form_id;?>_GPU_prod_id" name="GPU_prod_id[]" data-lcom='GPU_name' data-lfield="gpu_prod" data-lcom2='GPU_arch' data-lfield2="prop" multiple="multiple">
				<?php if(isset($droplists[12])) { echo $droplists[12]; } ?>
				</select>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">	
				<div>Graphics card model</div>
					<select onchange="presearch('#advform');" class="multisearch js-example-responsive" name="GPU_model_id[]" id="<?php echo $search_form_id;?>_GPU_model_id" name="GPU_name_id[]"  data-lcom='none' data-lfield="gpu_prod" data-placeholder="Graphics Card Models" data-initvalue="GPU Integrated" multiple="multiple" data-ajax--url="search/lib/func/list.php" style="width:100%;"></select>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div style="margin-top:5px;"><span style="font-size:13.5px; margin-bottom:2px;">
					Video memory:</span>  <span id="<?php echo $search_form_id;?>_gpu_memval"><?php echo $gpumemmin; ?> - <?php echo $gpumemmax; ?> MB</span>
				</div>	  
				<div class="advslider" style="margin-top:5px;" id="<?php echo $search_form_id;?>_gpumem"></div>
				<input type="hidden" name="gpu_memmin" id="<?php echo $search_form_id;?>_gpu_memmin" value="<?php echo $gpumemmin; ?>">
				<input type="hidden" name="gpu_memmax" id="<?php echo $search_form_id;?>_gpu_memmax" value="<?php echo $gpumemmax; ?>">		
			</div>	
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hiddenOptionsGpu">	
				<div style="margin-top:5px;">Architecture</div>
					<select onchange="presearch('#advform');" class="multisearch js-example-responsive" name="GPU_arch_id[]" id="<?php echo $search_form_id;?>_GPU_arch_id" data-lcom='GPU_name' data-lfield="gpu_arch" data-placeholder="Ex. GCN 1.3, Turing" data-initvalue="GPU Integrated" multiple="multiple" data-ajax--url="search/lib/func/list.php" style="width:100%;"></select>
			</div>
		</div>	
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">		

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hiddenOptionsGpu">
				<div style="margin-top:10px;"><span style="margin-top:11px; font-size:13.5px; margin-bottom:2px;">
									Memory bus width:</span>  <span id="<?php echo $search_form_id;?>_gpu_busval"><?php echo $gpumembusmin; ?> - <?php echo $gpumembusmax; ?> bit</span>
				</div>	  
				<div class="advslider" style="margin-top:5px;" id="<?php echo $search_form_id;?>_gpubus"></div>
				<input type="hidden" name="gpu_busmin" id="<?php echo $search_form_id;?>_gpu_busmin" value="<?php echo $gpumembusmin; ?>">
				<input type="hidden" name="gpu_busmax" id="<?php echo $search_form_id;?>_gpu_busmax" value="<?php echo $gpumembusmax; ?>">		
			</div>												
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div style="margin-top:10px;"><span style="margin-top:5px; font-size:13.5px; margin-bottom:2px;">
					Launch date:</span>  <span id="<?php echo $search_form_id;?>_gpu_launchdateval"><?php echo $gpumindate; ?> - <?php echo $gpumaxdate; ?></span>
				</div>	  
				<div class="advslider" style="margin-top:5px;" id="<?php echo $search_form_id;?>_gpulaunchdate"></div>
				<input type="hidden" name="gpu_launchdatemin" id="<?php echo $search_form_id;?>_gpu_launchdatemin" value="<?php echo $gpumindate; ?>" data-lcom='GPU_name' data-lfield="gpu_ldmin" >
				<input type="hidden" name="gpu_launchdatemax" id="<?php echo $search_form_id;?>_gpu_launchdatemax" value="<?php echo $gpumaxdate; ?>" data-lcom='GPU_name' data-lfield="gpu_ldmax" >
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div style="margin-top:10px;"><span style="font-size:13.5px;">
					Power consumption (TDP):</span>  <span id="<?php echo $search_form_id;?>_gpu_powerval"><?php echo $gpupowermin; ?> - <?php echo $gpupowermax; ?> W</span>
				</div>	  
				<div class="advslider" style="margin-top:5px;" id="<?php echo $search_form_id;?>_gpupower"></div>
				<input type="hidden" name="gpu_powermin" id="<?php echo $search_form_id;?>_gpu_powermin" value="<?php echo $gpupowermin; ?>">
				<input type="hidden" name="gpu_powermax" id="<?php echo $search_form_id;?>_gpu_powermax" value="<?php echo $gpupowermax; ?>">
			</div>					
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hiddenOptionsGpu" style="margin-top:12px">		
				<div>Other features</div>
					<select onchange="presearch('#advform');" class="multisearch js-example-responsive" id="<?php echo $search_form_id;?>_GPU_msc_id" name="GPU_msc_id[]" data-lcom='none' data-lfield="gpu_misc" data-placeholder="Ex. Optimus, Crossfire" data-ajax--url="search/lib/func/list.php" multiple="multiple" style="width:100%;"></select>
			</div>
		</div>		
		<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 toggleHiddenButtonsGpu toolinfo" data-toolid="101" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 700}' data-placement="top" data-original-title="data-loading..." aria-hidden="true">
			<span class="glyphicon glyphicon-chevron-down fas fa-angle-down"></span>
		</div>		
	</div><!-- End col -->
</div>