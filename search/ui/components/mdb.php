<script>{ const search_form_id='<?php echo $search_form_id; ?>'; const wait_main_search_scripts = setInterval(function () { if (main_search_scripts_loaded === true) { $.getScript("search/ui/components/mdb.js").done(function(){init_search_mdb(search_form_id);}); clearInterval(wait_main_search_scripts); } }, 20); }</script>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr class="" style="height:5px;"></div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="font-size:16px; font-weight:bold;padding-bottom:5px;">Motherboard</div>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">									
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div>Ports</div>
								<select onchange="presearch('#<?php echo $search_form_id;?>');" class="multisearch js-example-responsive" id="<?php echo $search_form_id;?>_MDB_port_id" name ="MDB_port_id[]" data-lcom='none' data-lfield="none" data-placeholder="Ex. 2 X USB 3.0, Thunderbolt" data-ajax--url="search/lib/func/list.php" multiple="multiple" style="width:100%;"></select>
							</div>	
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hiddenOptionsMdb">
								<div>Minimum number of memory slots:</div>			
								<select onchange="presearch('#<?php echo $search_form_id;?>');" id="<?php echo $search_form_id;?>_mdb_slots" name="mdb_slots">
									<option value="4" <?php echo $mdbslotsel4;?>>4</option>
									<option value="3" <?php echo $mdbslotsel3;?>>3</option>
									<option value="2" <?php echo $mdbslotsel2;?>>2</option>
									<option value="1" <?php echo $mdbslotsel1;?>>1</option>
									<option value="0" <?php echo $mdbslotsel0;?>>Soldered</option>
								</select>
							</div>					
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div>Video ports</div>
								<select onchange="presearch('#<?php echo $search_form_id;?>');" class="multisearch js-example-responsive" id="<?php echo $search_form_id;?>_MDB_vport_id" name="MDB_vport_id[]" data-lcom='none' data-lfield="none" data-placeholder="Ex. 1 X HDMI, 1 X VGA" data-ajax--url="search/lib/func/list.php" multiple="multiple" style="width:100%;"></select>
							</div>					
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hiddenOptionsMdb">			
								<div>WWAN</div>			
								<select onchange="presearch('#<?php echo $search_form_id;?>');" id="<?php echo $search_form_id;?>_mdb_wwan" name="mdb_wwan">
									<option value="1"<?php echo $mdbwwansel1;?> >None</option>
									<option value="0"<?php echo $mdbwwansel0;?> >Optional</option>
									<option value="2" <?php echo $mdbwwansel2;?> >Required</option>
								</select>
							</div>
						</div>
						<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 toggleHiddenButtonsMdb toolinfo" data-toolid="101" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 700}' data-placement="top" data-original-title="data-loading..." aria-hidden="true">
							<span class="glyphicon glyphicon-chevron-down fas fa-angle-down"></span>
						</div>		
					</div><!-- Row -->	
				</div><!-- Col -->