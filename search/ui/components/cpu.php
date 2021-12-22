<script>{ const search_form_id='<?php echo $search_form_id; ?>'; const wait_main_search_scripts = setInterval(function () { if (main_search_scripts_loaded === true) { $.getScript("search/ui/components/cpu.js").done(function(){init_search_cpu(search_form_id);}); clearInterval(wait_main_search_scripts); } }, 20); }</script>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 cpu_search_ui">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr style="height:10px;"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="font-size:16px; font-weight:bold;padding-bottom:5px;">Processor</div>	
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hiddenOptions">
				<div>Producer</div>
				<select onchange="presearch('#<?php echo $search_form_id;?>');" id="<?php echo $search_form_id;?>_CPU_prod_id" name="CPU_prod_id[]" data-lcom='CPU_model' data-lfield="cpu_prod" data-lcom2='CPU_socket' data-lfield2="prop" multiple="multiple">
				</select>
			</div>
			<div style="margin-top: 10px;" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div>Features</div>
				<select onchange="presearch('#<?php echo $search_form_id;?>')"; class="multisearch js-example-responsive" id="<?php echo $search_form_id;?>_CPU_msc_id" name="CPU_msc_id[]" data-lcom='CPU_model' data-lfield="cpu_misc" data-placeholder="Ex. Intel Core i7, Multithreading " data-ajax--url="search/lib/func/list.php" multiple="multiple" style="width:100%;"></select>
			</div>	
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">		
				<div style="margin-top:5px">
					<span style="font-size:13.5px;">Nr. of cores:</span>
					<span id="<?php echo $search_form_id;?>_nrcoresval"> - </span>
				</div>	  
				<div class="advslider" style="margin-top: 5px;" id="<?php echo $search_form_id;?>_nrcores"></div>
				<input type="hidden" name="cpu_coremin" id="<?php echo $search_form_id;?>_cpu_coremin" value="" data-lcom='CPU_model' data-lfield="cpu_coremin">
				<input type="hidden" name="cpu_coremax" id="<?php echo $search_form_id;?>_cpu_coremax" value="" data-lcom='CPU_model' data-lfield="cpu_coremax">	
			</div>					
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hiddenOptions">
				<div style="margin-top: 12px;">Socket</div>
				<select onchange="presearch('#<?php echo $search_form_id;?>')"; class="multisearch js-example-responsive" id="<?php echo $search_form_id;?>_CPU_socket_id" name="CPU_socket_id[]" data-lcom='CPU_model' data-lfield="cpu_socket" data-placeholder="Processor Sockets" data-ajax--url="search/lib/func/list.php" multiple="multiple" style="width: 100%;"></select>
			</div>							
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div style="margin-top: 5px;">Model</div>
				<select onchange="presearch('#<?php echo $search_form_id;?>')"; class="multisearch js-example-responsive" id="<?php echo $search_form_id;?>_CPU_model_id" name="CPU_model_id[]" data-lcom='none' data-lfield="none" data-placeholder="Processor Models" data-ajax--url="search/lib/func/list.php" multiple="multiple" style="width:100%;"></select>
			</div>										
		</div>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" onchange="presearch('#<?php echo $search_form_id;?>');">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px">
				<div>
					<span style="font-size:13.5px;">Power consumption (TDP):</span>
					<span id="<?php echo $search_form_id;?>_cputdpval"> - </span><span> W</span>
				</div>	  
				<div class="advslider" style="margin-top: 5px;" id="<?php echo $search_form_id;?>_cputdp"></div>
				<input type="hidden" name="cpu_tdpmin" id="<?php echo $search_form_id;?>_cpu_tdpmin" value="" data-lcom='CPU_model' data-lfield="cpu_tdpmin" >	 
				<input type="hidden" name="cpu_tdpmax" id="<?php echo $search_form_id;?>_cpu_tdpmax" value="" data-lcom='CPU_model' data-lfield="cpu_tdpmax" >				
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hiddenOptions">
				<div class="advslider" style="margin-top: 12px;">
					<span style="font-size:13.5px;">Boost speed:</span>
					<span id="<?php echo $search_form_id;?>_cpufreqval"> - </span><span> GHz</span>
				</div>	  
				<div class="advslider" style="margin-top: 5px;" id="<?php echo $search_form_id;?>_cpufreq"></div>
				<input type="hidden" name="cpu_freqmin" id="<?php echo $search_form_id;?>_cpu_freqmin" value="" data-lcom='CPU_model' data-lfield="cpu_turbomin" >	 
				<input type="hidden" name="cpu_freqmax" id="<?php echo $search_form_id;?>_cpu_freqmax" value="" data-lcom='CPU_model' data-lfield="cpu_turbomax" >			
			</div>					
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hiddenOptions">
				<div class="advslider" style="margin-top: 12px;">
					<span style="font-size:13.5px;">Lithography:</span> 
					<span id="<?php echo $search_form_id;?>_cputechval"> - </span><span> nm</span>
				</div>	  
				<div class="advslider" style="margin-top: 5px;" id="<?php echo $search_form_id;?>_cputech"></div>
				<input type="hidden" name="cpu_techmax" id="<?php echo $search_form_id;?>_cpu_techmax" value="" data-lcom='CPU_model' data-lfield="cpu_techmin" data-lcom2='CPU_socket' data-lfield2="socktechmin">	 
				<input type="hidden" name="cpu_techmin" id="<?php echo $search_form_id;?>_cpu_techmin" value="" data-lcom='CPU_model' data-lfield="cpu_techmax" data-lcom2='CPU_socket' data-lfield2="socktechmax">		
			</div>		
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="advslider" style="margin-top: 12px;">
					<span style="font-size:13.5px;">Launch date:</span>
					<span id="<?php echo $search_form_id;?>_launchdateval"> - </span>
				</div>	  
				<div class="advslider" style="margin-top: 5px;" id="<?php echo $search_form_id;?>_launchdate"></div>
				<input type="hidden" name="cpu_ldatemin" id="<?php echo $search_form_id;?>_cpu_ldatemin" value="" data-lcom='CPU_model' data-lfield="cpu_ldmin" data-lcom2='CPU_socket' data-lfield2="sockmin">	
				<input type="hidden" name="cpu_ldatemax" id="<?php echo $search_form_id;?>_cpu_ldatemax" value="" data-lcom='CPU_model' data-lfield="cpu_ldmax" data-lcom2='CPU_socket' data-lfield2="sockmax">
			</div>			
		</div>
		<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 toggleHiddenButtons toolinfo" data-toolid="101" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 700}' data-placement="top" data-original-title="data-loading..." aria-hidden="true">
			<span class="glyphicon glyphicon-chevron-down fas fa-angle-down" id="cpu_toggle"></span> 
		</div>
	</div><!-- End row -->
</div><!-- End Col -->