<?php
require_once("../etc/conf.php");

if (!isset($_SERVER['HTTP_REFERER']) || stripos($_SERVER['HTTP_REFERER'],$site_name) ==FALSE) 
{	$actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	header("Location: http://".str_replace($site_name."/",$site_name."/?",$actual_link)."");
	die();
}
require_once("../etc/session.php");
require_once("../etc/con_db.php");
require_once("preproc/adv_setvar.php");
include ("lib/php/currency.php");
?>
<script>
$.getScript("search/lib/js/tokenlist.js").done(function(){ $.getScript("search/lib/js/adv_search_post.js"); });
$.getScript("search/lib/js/adv_search_pre.js");
var basevalueoldadv=currency_val[<?php echo '"'.$basevalue.'"'; ?>];
var minbudgetnomenadv=<?php echo $minconfigprice; ?>;
var maxbudgetnomenadv=<?php echo $maxconfigprice; ?>;
var minbudgetset=<?php if(!isset($bdgmin)){ $bdgmin=$minconfigprice*4; } echo $bdgmin; ?>;
var maxbudgetset=<?php if(!isset($bdgmax)){ $bdgmax=$minconfigprice*6; } echo $bdgmax; ?>;
</script>
<form  method="post" id="advform" name="advform">
<input type="hidden" name="advsearch" value="1">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="background-color:white; font-family:arial; padding:0px;">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><a  onclick="OpenPage('search/adv_search.php',event);" style="cursor:pointer; padding-top:20px; font-weight:bold; font-size:16px; float:right; color:#000" id="gototop">Reset</a></div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><a onclick="scrolltoid('submitformid');" style="cursor:pointer; padding-top:20px; font-weight:bold; font-size:16px; float:right; color:#000">Go to bottom<i class="glyphicon glyphicon-arrow-down" style="font-size:12px"></i></a></div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div style="font-size:16px; font-weight:bold;">Producer</div>			
					<select class="multisearch js-example-responsive" id="Producer_prod_id" name ="Producer_prod[]" data-idtype=2 data-lcom='Family_fam' data-lfield="prod" data-placeholder="Select Brands" data-initvalue="All" multiple="multiple" data-ajax--url="search/lib/func/list.php" style="width: 100%;"></select>
					<div style="font-size:16px; font-weight:bold;">Family</div>
					<select class="multisearch js-example-responsive" id="Family_fam_id" name = "Family_fam[]" data-lcom='model' data-lfield="fam" data-placeholder="Select Family" data-initvalue="All" multiple="multiple" data-ajax--url="search/lib/func/list.php" style="width:100%;"></select>
				</div>
			</div>	
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div style="font-size:15px;">
					<span style="font-size:16px; font-weight:bold;">Budget:<br></span>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">							
								<span id="2"><input type="tel" name="bdgminadv" id="bdgminadv" value="<?php echo round(floatval($bdgmin)*floatval($basevalue)); ?>" size="1" maxlength="5" onchange="checkminadv()" class="budget">  -
								<input type="tel" name="bdgmaxadv" id="bdgmaxadv" value="<?php echo round(floatval($bdgmax)*floatval($basevalue)); ?>" size="1" maxlength="5" onchange="checkmaxadv()"class="budget" ></span>						
								<select name ="exchadv" id="currencyadv" onchange="sliderrangeadv(this); this.oldvalue = this.value;">
								<?php echo $var_currency; //this variable comes from lib/currency.php ?>
								</select>
							
						</div>
					</div>
				</div>
				<br>
				<div class="col-xs-12 col-md-12 col-xs-12">
					<div style="margin-top:10px;" id="budgetadv"></div>	
				</div> 
			</div>	
		</div>
		
		<!-- CPU -->
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding:10px 0px 0px 0px;">
			<hr style="height:10px; width=:5px;">
			<div style="font-size:16px; font-weight:bold;padding-bottom:5px;">Processor</div>	
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div>Producer</div>
					<select id="CPU_prod_id" name="CPU_prod_id[]" data-lcom='CPU_model' data-lfield="cpu_prod" data-lcom2='CPU_socket' data-lfield2="prop" multiple="multiple">
					<?php if(isset($droplists[11])) { echo $droplists[11]; } ?>
					</select>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div>Model</div>
					<select class="multisearch js-example-responsive" id="CPU_model_id" name="CPU_model_id[]" data-lcom='none' data-lfield="none" data-placeholder="Processor Models" data-ajax--url="search/lib/func/list.php" multiple="multiple" style="width:100%;"></select>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div>Socket</div>
					<select class="multisearch js-example-responsive" id="CPU_socket_id" name="CPU_socket_id[]" data-lcom='CPU_model' data-lfield="cpu_socket" data-placeholder="Processor Sockets" data-ajax--url="search/lib/func/list.php" multiple="multiple" style="width: 100%;"></select>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div style="margin-top:10px;"><span style="margin-top:5px; font-size:13.5px; margin-bottom:2px;">
						Launch date:</span>  <span id="launchdateval"><?php echo $cpumindate; ?> - <?php echo $cpumaxdate; ?></span>
					</div>	  
					<div style="margin-top:3px;" id="launchdate"></div>
					<input type="hidden" name="launchdatemin" id="launchdatemin" value="<?php echo $cpumindate; ?>" data-lcom='CPU_model' data-lfield="cpu_ldmin" data-lcom2='CPU_socket' data-lfield2="sockmin">	
					<input type="hidden" name="launchdatemax" id="launchdatemax" value="<?php echo $cpumaxdate; ?>" data-lcom='CPU_model' data-lfield="cpu_ldmax" data-lcom2='CPU_socket' data-lfield2="sockmax">			
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">		
					<div style="margin-top:10px;"><span style="margin-top:5px; font-size:13.5px; margin-bottom:2px;">
						Nr of cores:</span>  <span id="nrcoresval"><?php echo $cpucoremin;?> - <?php echo $cpucoremax; ?></span>
				 	</div>	  
					<div style="margin-top:3px;" id="nrcores"></div>
					<input type="hidden" name="nrcoresmin" id="nrcoresmin" value="<?php echo $cpucoremin; ?>" data-lcom='CPU_model' data-lfield="cpu_coremin">
					<input type="hidden" name="nrcoresmax" id="nrcoresmax" value="<?php echo $cpucoremax; ?>" data-lcom='CPU_model' data-lfield="cpu_coremax">	
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div><span style="margin-top:5px; font-size:13.5px; margin-bottom:2px;">
						Power Consumption (TDP):</span>  <span id="cputdpval"><?php echo $cputdpmin; ?> - <?php echo $cputdpmax; ?></span><span> W</span>
				 	</div>	  
					<div style="margin-top:3px;" id="cputdp"></div>
					<input type="hidden" name="cputdpmin" id="cputdpmin" value="<?php echo $cputdpmin; ?>" data-lcom='CPU_model' data-lfield="cpu_tdpmin" >	 
					<input type="hidden" name="cputdpmax" id="cputdpmax" value="<?php echo $cputdpmax; ?>" data-lcom='CPU_model' data-lfield="cpu_tdpmax" >				
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div style="margin-top:10px;"><span style="margin-top:5px; font-size:13.5px; margin-bottom:2px;">
						Base Frequency:</span>  <span id="cpufreqval"><?php echo $cpufreqmin; ?> - <?php echo $cpufreqmax; ?></span><span> GHz</span>
					</div>	  
					<div style="margin-top:3px;" id="cpufreq"></div>
					<input type="hidden" name="cpufreqmin" id="cpufreqmin" value="<?php echo $cpufreqmin; ?>" data-lcom='CPU_model' data-lfield="cpu_clockmin" >	 
					<input type="hidden" name="cpufreqmax" id="cpufreqmax" value="<?php echo $cpufreqmax; ?>" data-lcom='CPU_model' data-lfield="cpu_clockmax" >			
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div style="margin-top:10px;"><span style="margin-top:5px; font-size:13.5px; margin-bottom:2px;">
						Lithography:</span>  <span id="cputechval"><?php echo $cputechmax; ?> - <?php echo $cputechmin; ?></span><span> nm</span>
					</div>	  
					<div style="margin-top:3px;" id="cputech"></div>
					<input type="hidden" name="cputechmin" id="cputechmin" value="<?php echo $cputechmax; ?>" data-lcom='CPU_model' data-lfield="cpu_techmax" data-lcom2='CPU_socket' data-lfield2="socktechmax">	 
					<input type="hidden" name="cputechmax" id="cputechmax" value="<?php echo $cputechmin; ?>" data-lcom='CPU_model' data-lfield="cpu_techmin" data-lcom2='CPU_socket' data-lfield2="socktechmin">			
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px">
					<div>Miscellaneous</div>
					<select class="multisearch js-example-responsive" id="CPU_msc_id" name = "CPU_msc_id[]" data-lcom='CPU_model' data-lfield="cpu_misc" data-placeholder="Processor Miscellaneous" data-ajax--url="search/lib/func/list.php" multiple="multiple" style="width:100%;"></select>
				</div>
			</div>
		</div>
		
		<!-- GPU -->
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding:10px 0px 0px 0px;">
			<hr style="height:5px; width=:50px;">
			<div style="font-size:16px; font-weight:bold;padding-bottom:5px;">Video Card</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<input type="radio" name="gputype" value="0" id="r-yes" class="css-radiobox" <?php if($gputype==0){ echo 'checked="checked"';} ?>>
				<label for="r-yes" class="css-labelr" style="font-weight:normal">Integrated</label>
				&nbsp;
				<input type="radio" name="gputype" value="1" id="r-no" class="css-radiobox" <?php if($gputype==1){ echo 'checked="checked"';} ?>>
				<label for="r-no" class="css-labelr" style="font-weight:normal">Dedicated</label>
				&nbsp;
				<input type="radio" name="gputype" value="2" id="r-any" class="css-radiobox" <?php if($gputype==2){ echo 'checked="checked"';} ?>>
				<label for="r-any" class="css-labelr" style="font-weight:normal">Any</label>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div>Type</div>			
					<select id="gputype2" name="gputype2[]" multiple="multiple">
					<option value="0" <?php echo $gputypesel[0] ?>>Integrated + Budget</option>
					<option value="1" <?php echo $gputypesel[1] ?>>Budget</option>
					<option value="2" <?php echo $gputypesel[2] ?>>Gaming</option>
					<option value="3" <?php echo $gputypesel[3] ?>>Professional</option>
					<option value="4" <?php echo $gputypesel[4] ?>>High-end</option>
					</select>	
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div>Producer</div>
					<select id="GPU_prod_id" name="GPU_prod_id[]" data-lcom='GPU_model' data-lfield="gpu_prod" data-lcom2='GPU_arch' data-lfield2="prop" multiple="multiple">
					<?php if(isset($droplists[12])) { echo $droplists[12]; } ?>
					</select>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">	
					<div>Graphics Card Model</div>
					<select class="multisearch js-example-responsive" id="GPU_model_id" name="GPU_model_id[]"  data-lcom='none' data-lfield="gpu_prod" data-placeholder="Graphics Card Model" data-initvalue="GPU Integrated" multiple="multiple" data-ajax--url="search/lib/func/list.php" style="width:100%;"></select>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div style="margin-top:10px;"><span style="margin-top:5px; font-size:13.5px; margin-bottom:2px;">
						Video Memory:</span>  <span id="gpumemval"><?php echo $gpumemmin; ?> - <?php echo $gpumemmax; ?> MB</span>
				 	</div>	  
					<div style="margin-top:3px;" id="gpumem"></div>
					<input type="hidden" name="gpumemmin" id="gpumemmin" value="<?php echo $gpumemmin; ?>">
					<input type="hidden" name="gpumemmax" id="gpumemmax" value="<?php echo $gpumemmax; ?>">		
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div style="margin-top:10px;"><span style="margin-top:5px; font-size:13.5px; margin-bottom:2px;">
						Memory bus width:</span>  <span id="gpubusval"><?php echo $gpumembusmin; ?> - <?php echo $gpumembusmax; ?> bit</span>
				 	</div>	  
					<div style="margin-top:3px;" id="gpubus"></div>
					<input type="hidden" name="gpubusmin" id="gpubusmin" value="<?php echo $gpumembusmin; ?>">
					<input type="hidden" name="gpubusmax" id="gpubusmax" value="<?php echo $gpumembusmax; ?>">		
				</div>
			</div>	
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">	
					<div>Architecture</div>
					<select class="multisearch js-example-responsive" name="GPU_arch_id[]" id="GPU_arch_id" data-lcom='GPU_model' data-lfield="gpu_arch" data-placeholder="Graphics Card Architecture" data-initvalue="GPU Integrated" multiple="multiple" data-ajax--url="search/lib/func/list.php" style="width:100%;"></select>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">		
					<div>Miscellaneous</div>
					<select class="multisearch js-example-responsive" id="GPU_msc_id" name="GPU_msc_id[]" data-lcom='none' data-lfield="gpu_misc" data-placeholder="Graphic Card Miscellaneous" data-ajax--url="search/lib/func/list.php" multiple="multiple" style="width:100%;"></select>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div style="margin-top:10px;"><span style="margin-top:5px; font-size:13.5px; margin-bottom:2px;">
						Power Consumption (TDP):</span>  <span id="gpupowerval"><?php echo $gpupowermin; ?> - <?php echo $gpupowermax; ?> W</span>
				 	</div>	  
					<div style="margin-top:3px;" id="gpupower"></div>
					<input type="hidden" name="gpupowermin" id="gpupowermin" value="<?php echo $gpupowermin; ?>">
					<input type="hidden" name="gpupowermax" id="gpupowermax" value="<?php echo $gpupowermax; ?>">
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div style="margin-top:10px;"><span style="margin-top:5px; font-size:13.5px; margin-bottom:2px;">
						Launch date:</span>  <span id="gpulaunchdateval"><?php echo $gpumindate; ?> - <?php echo $gpumaxdate; ?></span>
				 	</div>	  
					<div style="margin-top:3px;" id="gpulaunchdate"></div>
					<input type="hidden" name="gpulaunchdatemin" id="gpulaunchdatemin" value="<?php echo $gpumindate; ?>" data-lcom='GPU_model' data-lfield="gpu_ldmin" >
					<input type="hidden" name="gpulaunchdatemax" id="gpulaunchdatemax" value="<?php echo $gpumaxdate; ?>" data-lcom='GPU_model' data-lfield="gpu_ldmax" >
				</div>
			</div>				
		</div>
	
		<!-- DISPLAY -->
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding:10px 0px 0px 0px;">
			<hr style="height:5px; width=:50px;">
			<div style="font-size:16px; font-weight:bold;padding-bottom:5px;">Display</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" >
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div><span style="margin-top:5px; font-size:13.5px; margin-bottom:2px;">
						Size:</span>  <span id="displayval"><?php echo $displaysizemin; ?> - <?php echo $displaysizemax; ?> inch</span>
					</div>	  
					<div style="margin-top:3px;" id="display"></div>
					<input type="hidden" name="displaymin" id="displaymin" value="<?php echo $displaysizemin; ?>">	
					<input type="hidden" name="displaymax" id="displaymax" value="<?php echo $displaysizemax; ?>">				
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">
					<div>Ratio</div>			
					<select id="DISPLAY_ratio_id" name="DISPLAY_ratio[]" data-lcom='DISPLAY_resol' data-lfield="prop" multiple="multiple">
						<?php if(isset($droplists[8])){ echo $droplists[8]; } ?>
					</select>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div>Surface type</div>			
					<select id="surface" name="surface[]" multiple="multiple">
						<?php if(isset($droplists[56])) { echo $droplists[56]; } ?>
					</select>
				</div>
			</div>	
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
					<div>Resolution</div>
					<select class="multisearch js-example-responsive" name="DISPLAY_resol_id[]" id="DISPLAY_resol_id" data-lcom="none" data-lfield="none" data-placeholder="Display Resolution" data-ajax--url="search/lib/func/list.php" multiple="multiple" style="width:100%;"></select>
				</div>	
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top:5px;">
					<div class="checkbox" style="float:right;">
						<input type="checkbox" name="touchscreen"  id="touchscreen" class="css-checkbox sme" style="margin-left:0px;" <?php echo $tcheck; ?>/>
						<label for="touchscreen" class="css-label sme depressed" style="font-weight:normal;min-height:16px;">Touchscreen</label>
						&nbsp;
						<input type="checkbox" name="nontouchscreen"  id="nontouchscreen" class="css-checkbox sme" style="margin-left:0px;" <?php echo $ntcheck; ?>/>
						<label for="nontouchscreen" class="css-label sme depressed" style="font-weight:normal;min-height:16px;">No Touchscreen</label>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div><span style="margin-top:5px; font-size:13.5px; margin-bottom:2px;">
						Vertical Resolution:</span>  <span id="verresval"><?php echo $displayvresmin; ?> - <?php echo $displayvresmax; ?> pixels</span>
					</div>	  
					<div style="margin-top:3px;" id="verres"></div>
					<input type="hidden" name="verresmin" id="verresmin" value="<?php echo $displayvresmin; ?>" data-lcom='DISPLAY_resol' data-lfield="vresmin">	
					<input type="hidden" name="verresmax" id="verresmax" value="<?php echo $displayvresmax; ?>" data-lcom='DISPLAY_resol' data-lfield="vresmax">				
				</div>
			</div>
		</div>	
		
		<!-- STORAGE -->
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding:10px 0px 0px 0px;">
			<hr style="height:5px; width=:50px;">
			<div style="font-size:16px; font-weight:bold;padding-bottom:5px;">Storage</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" >
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div><span style="margin-top:5px; font-size:13.5px; margin-bottom:2px;">
						Capacity:</span>  <span id="capacityval"><?php echo $totalcapmin; ?> - <?php echo $totalcapmax; ?> GB</span>
				 	</div>	  
					<div style="margin-top:3px;" id="capacity"></div>
					<input type="hidden" name="capacitymin" id="capacitymin" value="<?php echo $totalcapmin; ?>">	
					<input type="hidden" name="capacitymax" id="capacitymax" value="<?php echo $totalcapmax; ?>">				
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">						
					<div>Type</div>			
					<select id="typehdd" name="typehdd[]" multiple="multiple">
						<?php if(isset($droplists[54])) { echo $droplists[54]; } ?>
					</select>
				</div>
			</div>	
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div>min RPM (for HDD option)</div>			
					<select id="rpm" name="rpm">
						<option value="">Any</option>
						<?php if(isset($droplists[55])){ echo $droplists[55]; } ?>
					</select>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">		
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">			
					<div>Seconday Storage</div>
					<select id="nrhdd" name="nrhdd">
						<option value="1">Optional</option>
						<option value="2" <?php echo $nrhddselect;?> >Mandatory</option>
					</select>
				</div>
			</div>
		</div>
			
		<!-- MDB -->
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding:10px 0px 0px 0px;">
			<hr style="height:5px; width=:50px;">
			<div style="font-size:16px; font-weight:bold;padding-bottom:5px;">Motherboard</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div>Minimum number of memory slots:</div>			
					<select id="mdbslots" name="mdbslots">
						<option value="4" <?php echo $mdbslotsel4;?>>4</option>
						<option value="3" <?php echo $mdbslotsel3;?>>3</option>
						<option value="2" <?php echo $mdbslotsel2;?>>2</option>
						<option value="1" <?php echo $mdbslotsel1;?>>1</option>
						<option value="0" <?php echo $mdbslotsel0;?>>Soldered</option>
					</select>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div>Ports</div>
					<select class="multisearch js-example-responsive" id="MDB_port_id" name ="MDB_port_id[]" data-lcom='none' data-lfield="none" data-placeholder="Motherboard Generic Ports" data-ajax--url="search/lib/func/list.php" multiple="multiple" style="width:100%;"></select>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div>Video Ports</div>
					<select class="multisearch js-example-responsive" id="MDB_vport_id" name="MDB_vport_id[]" data-lcom='none' data-lfield="none" data-placeholder="Motherboard Video Ports" data-ajax--url="search/lib/func/list.php" multiple="multiple" style="width:100%;"></select>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">			
					<div>WWAN</div>			
					<select id="mdbwwan" name="mdbwwan">
						<option value="1"<?php echo $mdbwwansel1;?> >None</option>
						<option value="0"<?php echo $mdbwwansel0;?> >Optional</option>
						<option value="2" <?php echo $mdbwwansel2;?> >Required</option>
					</select>
				</div>
			</div>	
		</div>

		<!-- MEMORY -->
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding:10px 0px 0px 0px;">
			<hr style="height:5px; width=:50px;">
			<div style="font-size:16px; font-weight:bold;padding-bottom:5px;">Memory</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div style="margin-top:5px;"><span style="margin-top:5px; font-size:13.5px; margin-bottom:2px;">
						Capacity:</span>  <span id="ramval"><?php echo $memcapmin; ?> - <?php echo $memcapmax; ?> GB</span>
				 	</div>	  
					<div style="margin-top:3px;" id="ram"></div>
					<input type="hidden" name="rammin" id="rammin" value="<?php echo $memcapmin; ?>">	
					<input type="hidden" name="rammax" id="rammax" value="<?php echo $memcapmax; ?>">				
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div style="margin-top:10px;"><span style="margin-top:5px; font-size:13.5px; margin-bottom:2px;">
						Speed:</span>  <span id="freqval"><?php echo $memfreqmin; ?> - <?php echo $memfreqmax; ?> MHz</span>
				 	</div>	  
					<div style="margin-top:3px;" id="freq"></div>
					<input type="hidden" name="freqmin" id="freqmin" value="<?php echo $memfreqmin; ?>">	
					<input type="hidden" name="freqmax" id="freqmax" value="<?php echo $memfreqmax; ?>">				
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-md-6 col-lg-6" >
				<div class="col-md-12 col-sm-12">
					<div>Type</div>			
					<select id="memtype" name="memtype[]" multiple>
						<?php if(isset($droplists[53])) { echo $droplists[53]; } ?>
					</select>
				</div>
			</div>
		</div>
			
		<!-- BATTERY -->
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding:10px 0px 0px 0px;">
			<hr style="height:5px; width=:50px;">
			<div style="font-size:16px; font-weight:bold;padding-bottom:5px;">Battery</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" >
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div style="margin-top:5px;"><span style="margin-top:5px; font-size:13.5px; margin-bottom:2px;">
						Estimated battery life:</span>  <span id="batlifeval"><?php echo $batlifemin; ?> - <?php echo $batlifemax; ?> h</span>
				 	</div>	  
					<div style="margin-top:3px;" id="batlife"></div>
					<input type="hidden" name="batlifemin" id="batlifemin" value="<?php echo $batlifemin; ?>">	
					<input type="hidden" name="batlifemax" id="batlifemax" value="<?php echo $batlifemax; ?>">				
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div style="margin-top:5px;"><span style="margin-top:5px; font-size:13.5px; margin-bottom:2px;">
						Capacity:</span>  <span id="acumcapval"><?php echo $acumcapmin; ?> - <?php echo $acumcapmax; ?> WHr</span>
					</div>	  
					<div style="margin-top:3px;" id="acumcap"></div>
					<input type="hidden" name="acumcapmin" id="acumcapmin" value="<?php echo $acumcapmin; ?>">	
					<input type="hidden" name="acumcapmax" id="acumcapmax" value="<?php echo $acumcapmax; ?>">				
				</div>
			</div>
		</div>
		
		<!-- CHASSIS -->
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding:10px 0px 0px 0px;">
			<hr style="height:5px; width=:50px;">
			<div style="font-size:16px; font-weight:bold;padding-bottom:5px;">Chassis</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" >
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div style="margin-top:5px;"><span style="margin-top:5px; font-size:13.5px; margin-bottom:2px;">
						Weight:</span>  <span id="weightval"><?php $poundsweightmin =$chassisweightmin*2.2046226218;  echo number_format($chassisweightmin,2); echo " - "; echo number_format($chassisweightmax,2); echo " kg / "; echo number_format($poundsweightmin,2);?> - <?php $poundsweightmax =$chassisweightmax*2.2046226218;  echo number_format($poundsweightmax,2);?> lb</span>
				 	</div>							
					<div style="margin-top:3px;" id="weight"></div>
					<input type="hidden" name="weightmin" id="weightmin" value="<?php echo $chassisweightmin; ?>">	
					<input type="hidden" name="weightmax" id="weightmax" value="<?php echo $chassisweightmax; ?>">				
				</div>	
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div style="margin-top:10px;"><span style="margin-top:5px; font-size:13.5px; margin-bottom:2px;">
						Thickness:</span>  <span id="thicval">
						<?php $feetthicmin = $chassisthicmin*0.393701; echo number_format($chassisthicmin/10,1); ?> - <?php echo number_format($chassisthicmax/10,1)." cm / ";  $feetthicmax = $chassisthicmax*0.393701; echo number_format($feetthicmin/10,2)." - ".number_format($feetthicmax/10,2)." inch"; ?></span>
				 	</div>	  
					<div style="margin-top:3px; margin-bottom:5px;" id="thickness"></div>
					<input type="hidden" name="thicmin" id="thicmin" value="<?php echo $chassisthicmin; ?>">
					<input type="hidden" name="thicmax" id="thicmax" value="<?php echo $chassisthicmax; ?>">	
				</div>	
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div>Made of</div>			
					<select id="material" name="material[]" multiple>
						<option value="0">Any</option>
						<?php if(isset($droplists[26])) { echo $droplists[26]; } ?>
					</select>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">	
					<div class="checkbox" style="float:right;">
						<input type="checkbox" name="twoinone-yes"  id="twoinone-yes" class="css-checkbox sme" style="margin-left:0px;" <?php echo $twoinone_check; ?>/>
						<label for="twoinone-yes" class="css-label sme depressed" style="font-weight:normal;min-height:16px;">Convertible (2-in-1)</label>
						&nbsp; <input type="checkbox" name="twoinone-no"  id="twoinone-no" class="css-checkbox sme" style="margin-left:0px;" <?php echo $classiclap_check; ?>/>
						<label for="twoinone-no" class="css-label sme depressed" style="font-weight:normal;min-height:16px;">Classic Laptop</label>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div style="margin-top:5px;"><span style="margin-top:0px; font-size:13.5px; margin-bottom:2px;">
						Width:</span>  <span id="widthval">
						<?php $feetwidthmin = $chassiswidthmin*0.393701; echo number_format($chassiswidthmin/10,1); ?> - <?php echo number_format($chassiswidthmax/10,1)." cm / ";  $feetwidthmax = $chassiswidthmax*0.393701; echo number_format($feetwidthmin/10,2)." - ".number_format($feetwidthmax/10,2)." inch"; ?></span>
				 	</div>	  
					<div style="margin-top:3px;" id="width"></div>
					<input type="hidden" name="widthmin" id="widthmin" value="<?php echo $chassiswidthmin; ?>">	
					<input type="hidden" name="widthmax" id="widthmax" value="<?php echo $chassiswidthmax; ?>">				
				</div>	
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				 	<div style="margin-top:10px;"><span style="margin-top:5px; font-size:13.5px; margin-bottom:2px;">
						Depth:</span>  <span id="depthval">
						<?php $feetdepthmin = $chassisdepthmin*0.393701; echo number_format($chassisdepthmin/10,1); ?> - <?php echo number_format($chassisdepthmax/10,1)." cm / ";  $feetdepthmax = $chassisdepthmax*0.393701; echo number_format($feetdepthmin/10,2)." - ".number_format($feetdepthmax/10,2)." inch"; ?></span>
				 	</div>	  
					<div style="margin-top:3px;" id="depth"></div>
					<input type="hidden" name="depthmin" id="depthmin" value="<?php echo $chassisdepthmin; ?>">	
					<input type="hidden" name="depthmax" id="depthmax" value="<?php echo $chassisdepthmax; ?>">				
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">	
					<div style="margin-top:10px;"><span style="margin-top:5px; font-size:13.5px; margin-bottom:2px;">
						Webcam:</span>  <span id="webval">
						<?php echo $chassiswebmin; ?> - <?php echo $chassiswebmax." MP";?></span>
					</div>	  
				</div>	
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">	
					<div style="margin-top:3px;" id="web"></div>
					<input type="hidden" name="webmin" id="webmin" value="<?php echo $chassiswebmin; ?>">	
					<input type="hidden" name="webmax" id="webmax" value="<?php echo $chassiswebmax; ?>">				
					<div  style="margin-top:10px;">
						<div>Other Features</div>
						<select class="multisearch js-example-responsive" id="CHASSIS_stuff_id" name="CHASSIS_stuff_id[]" data-lcom='none' data-lfield="none" data-placeholder="Touchpad / Keyboard / Speakers" data-ajax--url="search/lib/func/list.php" multiple="multiple" style="width:100%;"></select>
					</div>
				</div>
			</div>
		</div>
		
		<!-- WIRELESS -->
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding:10px 0px 0px 0px;">	
			<hr style="height:5px; width=:50px;">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="padding:10px 0px 0px 0px;">
				<div style="font-size:16px; font-weight:bold;padding-bottom:5px;">Wireless card</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div>Minimum transfer speed (Mbps)</div>			
						<select id="wnetspeed" name="wnetspeed">
							<?php if(isset($droplists[51])){ echo $droplists[51]; } ?>
						</select>
						<div class="checkbox" style="float:right;">
							<input type="checkbox" name="bluetooth" class="css-checkbox sme" id="bluetoothadv" style="margin-left:0px;" <?php echo $btcheck; ?> />
							<label for="bluetoothadv" class="css-label sme depressed" style="font-weight:normal;min-height:16px;">Bluetooth</label>
						</div>			
					</div>
				</div>
			</div>
			
			<!-- Optical Drive -->
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="padding:10px 0px 0px 0px;">		
				<div style="font-size:16px; font-weight:bold;padding-bottom:5px;">Optical drive</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="col-md-12 col-sm-12">	
						<div>Type</div>			
						<select id="oddtype" name="oddtype">
							<?php if(isset($droplists[52])){ echo $droplists[52]; } ?>
						</select>
					</div>
				</div>
			</div>
		</div>
		
		<!-- OS -->
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"  style="padding:0px 0px 0px 0px;">
			<hr style="height:5px; width=:50px;">
			<div style="font-size:16px; font-weight:bold;padding-bottom:5px;">Operating System</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div>System</div>			
					<select id="opsist" name="opsist[]" multiple>
						<?php if(isset($droplists[25])){ echo $droplists[25]; } ?>
					</select>
				</div>
			</div>
		</div>
		
		<!-- WARRANTY -->
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"  style="padding:0px 0px 0px 0px;">
			<hr style="height:5px; width=:50px;">
			<div style="font-size:16px; font-weight:bold;padding-bottom:5px;">Warranty</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div style="margin-top:5px;"><span style="margin-top:5px; font-size:13.5px; margin-bottom:2px;">
					Nr of years:</span>  <span id="yearsval"><?php echo $waryearsmin; ?> - <?php echo $waryearsmax; ?></span>
				</div>	  
				<div style="margin-top:3px;" id="years"></div>
				<input type="hidden" name="yearsmin" id="yearsmin" value="<?php echo $waryearsmin; ?>">	
				<input type="hidden" name="yearsmax" id="yearsmax" value="<?php echo $waryearsmax; ?>">				
				<div class="checkbox" style="float:right;">
					<input type="checkbox" name="premiumadvadp" class="css-checkbox sme" id="checkboxadvadp" style="margin-left:0px;" <?php echo $nbdcheckadp; ?> />
					<label for="checkboxadvadp" class="css-label sme depressed" style="font-weight:normal;min-height:16px;">Accidental Damage</label>			
					<input type="checkbox" name="premiumadv" class="css-checkbox sme" id="checkboxadv" style="margin-left:0px;" <?php echo $nbdcheck; ?> />
					<label for="checkboxadv" class="css-label sme depressed" style="font-weight:normal;min-height:16px;">On-Site</label>
				</div>	
			</div>
		</div>	
				
	<!-- SUBMIT BUTTON -->		
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top: 20px;">		
			<nav style="margin-bottom:20px!important">		
				<a id="submit"></a>	
				<input type="submit" id="submitformid" class="btn submitbutton" value="Submit" onclick="scrolltoid('gototop');">
			</nav>
		</div>

	</div>
</form>
<?php if($gputype==1){ echo '<script>$(document).ready(function() { $("#r-no").click();  });</script>'; }?>