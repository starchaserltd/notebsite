function init_search_mem(search_form_id,form_rest=0)
{
	// form_rest=0 - initialise
	// form_rest=1 - reset to defaults
	// form_rest=2 - reset to last_search
	
	//here we get default vars from nomen - nb_search_data
	if(set_search_vars==undefined){ var set_search_vars=Object(); } if(set_search_vars["mem"]===undefined) { set_search_vars["mem"]=Object(); }
	set_search_vars["mem"]=JSON.parse(JSON.stringify(nb_search_data["mem"]));
	set_search_vars["mem"]["type"]=[];
	

	if(form_rest==1 || form_rest==2)
	{
		var select2_mem_list=["mem_type"];
		for(var key in select2_mem_list){ $('#'+search_form_id+'_'+select2_mem_list[key]).val(null).trigger('change'); }
		var select2_mem_sliders_min_to_max={"ram":{"min":"rammin","max":"rammax"},"freq":{"min":"freqmin","max":"freqmax"}};
		for(var key in select2_mem_sliders_min_to_max){ $('#'+search_form_id+'_'+key)[0].noUiSlider.set([0,9999999]); }
		var select2_mem_sliders_max_to_min=[];
		for(var key in select2_mem_sliders_max_to_min){ $('#'+search_form_id+'_'+key)[0].noUiSlider.set([9999999,0]); }
		//var select2_mem_multiselect=["mem_prod_id"];
		//for(var key in select2_mem_multiselect){ reset_multiselect(search_form_id+'_'+select2_mem_multiselect[key]); }
	}
	
	
	if(form_rest==0 || form_rest==2)
	{
		if(is_setparams('mem_type[]')){ set_search_vars["mem"]["type"]=setparams.getAll("mem_type[]"); }else{set_search_vars["mem"]["type"]=set_saved_search(set_search_vars["mem"]["type"],last_search,"mem","type");}
		if(is_setparams('mem_rammin')){ set_search_vars["mem"]["rammin"]=setparams.get("mem_rammin"); }else{ set_search_vars["mem"]["rammin"]=nb_search_data["mem"]["rammin"]; set_search_vars["mem"]["rammin"]=parseInt(set_saved_search(set_search_vars["mem"]["rammin"],last_search,"mem","rammin")); }
		if(is_setparams('mem_rammax')){ set_search_vars["mem"]["rammax"]=setparams.get("mem_rammax"); }else{ set_search_vars["mem"]["rammax"]=nb_search_data["mem"]["rammax"]; set_search_vars["mem"]["rammax"]=parseInt(set_saved_search(set_search_vars["mem"]["rammax"],last_search,"mem","ldatemax"));}
		if(is_setparams('mem_freqmin')){ set_search_vars["mem"]["freqmin"]=setparams.get("mem_freqmin"); }else{set_search_vars["mem"]["freqmin"]=2; set_search_vars["mem"]["freqmin"]=parseInt(set_saved_search(set_search_vars["mem"]["freqmin"],last_search,"mem","freqmin")); }
		if(is_setparams('mem_freqmax')){ set_search_vars["mem"]["freqmax"]=setparams.get("mem_freqmax"); }else{ set_search_vars["mem"]["freqmax"]=parseInt(set_saved_search(set_search_vars["mem"]["freqmax"],last_search,"mem","freqmax")); }
		}

	if(form_rest==0)
	{
		//$('.toggleHiddenButtons .glyphicon-chevron-down').click(function() { $('.hiddenOptions').toggle('slow'); $(this).toggleClass('arrowUp'); $("#"+search_form_id+'_'+"mem_type").trigger("change"); });

		//create_multiselect(nb_search_data["mem"]["prod"],search_form_id+'_'+"mem_prod_id",set_search_vars["mem"]["prod"]);

		//CREATE mem DATE SLIDER
		if(document.getElementById(search_form_id+'_'+'ram')!=null)
		{
			if(document.getElementById(search_form_id+'_'+'ram').noUiSlider===undefined)
			{	
				noUiSlider.create(document.getElementById(search_form_id+'_'+'ram'), {
					start: [set_search_vars["mem"]["rammin"], set_search_vars["mem"]["rammax"]],
					connect: true,
					step: 1,
					direction: 'ltr',
					format: { to: function(value){ return parseInt(value); }, from: function(value){ return parseInt(value); } },
					range: {
						'min': [nb_search_data["mem"]["rammin"]],
						'max': [nb_search_data["mem"]["rammax"]]		
					}
				});
			}

			//SET mem DATE SLIDER TEXT UPDATE FUNCTIONS
			document.getElementById(search_form_id+'_'+'ram').noUiSlider.on('update', function( values, handle ) 
			{
				if (typeof values[0] === 'string' || values[0] instanceof String)
				{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

				if (typeof values[1] === 'string' || values[1] instanceof String)
				{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
										
				if(handle==0) {	document.getElementById(search_form_id+'_'+'mem_rammin').value=left; filtersearch(search_form_id+'_'+'mem_rammin',left,0); }
				if(handle==1) {	document.getElementById(search_form_id+'_'+'mem_rammax').value=right; filtersearch(search_form_id+'_'+'mem_rammax',right,0); }
				document.getElementById(search_form_id+'_'+'ramval').innerHTML=left+" - "+right;
			});
		}

		//CREATE mem freq SLIDER
		if(document.getElementById(search_form_id+'_'+'freq')!=null)
		{
			if(document.getElementById(search_form_id+'_'+'freq').noUiSlider===undefined)
			{					
				noUiSlider.create(document.getElementById(search_form_id+'_'+'freq'), {
					start: [set_search_vars["mem"]["freqmin"], set_search_vars["mem"]["freqmax"]],
					connect: true,
					step: 2,
					direction: 'ltr',
					format: { to: function(value){ return parseInt(value); }, from: function(value){ return parseInt(value); } },
					range: {
						'min': [nb_search_data["mem"]["freqmin"]],
						'max': [nb_search_data["mem"]["freqmax"]]		
					}
				});
			}

			//SET mem freq SLIDER TEXT UPDATE FUNCTIONS
			document.getElementById(search_form_id+'_'+'freq').noUiSlider.on('update', function( values, handle ) 
			{
				if (typeof values[0] === 'string' || values[0] instanceof String)
				{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

				if (typeof values[1] === 'string' || values[1] instanceof String)
				{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
										
				if(handle==0) {	document.getElementById(search_form_id+'_'+'mem_freqmin').value=left; filtersearch(search_form_id+'_'+'mem_freqmin',left,0); }
				if(handle==1) {	document.getElementById(search_form_id+'_'+'mem_freqmax').value=right; filtersearch(search_form_id+'_'+'mem_freqmax',right,0); }
				document.getElementById(search_form_id+'_'+'freqval').innerHTML=left+" - "+right;
			});
		}

	

		$('#'+search_form_id+'_'+'mem_prod_id').multiselect(btnsearch);				
		$('#'+search_form_id+'_'+'mem_prod_id').change(function()
		{
			var memp=$(this).attr('id');
			var memsel = $('#'+search_form_id+'_'+'mem_prod_id option:selected');
			var selected = [];
			$(memsel).each(function(index, memsel){ selected.push([$(this).val()].toString()); });
			filtersearch(memp,selected,2);
		});
	}
	
	if(form_rest==0 || form_rest==2)
	{
		//SETTING SELECT2
		set_selected_select2('#'+search_form_id+'_'+'mem_type',set_search_vars["mem"]["type"]);
		
	}
	
	if(form_rest==2)
	{
		//SETTING SLIDERS IN FORM_REST=2
		for(var key in select2_mem_sliders_min_to_max){ $('#'+search_form_id+'_'+key)[0].noUiSlider.set([set_search_vars["mem"][select2_mem_sliders_min_to_max[key]["min"]],set_search_vars["mem"][select2_mem_sliders_min_to_max[key]["max"]]]); }
	}
	
	if(form_rest==2)
	{
		//SETTING MULTISELECT
		//set_multiselect(search_form_id+"_mem_prod_id",set_search_vars["mem"]["prod"]);
	}
	
	//level enablement
	function determine_enablement_level_mem()
	{
		var show_level=[];
		var enable_level=1;
		show_level[0]=[];
		show_level[1]=["rammin","rammax"];
		show_level[2]=["freqmin","freqmax","type"];

		//console.log(set_search_vars["mem"]);
		for(var key in set_search_vars["mem"])
		{
			if(Array.isArray(set_search_vars["mem"][key]))
			{
				if(set_search_vars["mem"][key].length>0)
				{ enable_level=test_show_level(show_level,key,enable_level); if(enable_level>1){break; } }
			}
			else
			{
				if(nb_search_data["mem"][key]===undefined)
				{ enable_level=test_show_level(show_level,key,enable_level); if(enable_level>1){break; } }
				else
				{
					if(nb_search_data["mem"][key]!=set_search_vars["mem"][key])
					{ enable_level=test_show_level(show_level,key,enable_level); if(enable_level>1){break; } }
				}
			}
		}
		if(enable_level>1 && !document.getElementById("mem_toggle").classList.contains('arrowUp'))
		{
			document.getElementById("mem_toggle").click();
		}
		//console.log(enable_level);
	}
	determine_enablement_level_mem();
}

function setrecommended_mem(search_form_id)
{
	document.getElementById(search_form_id+'_'+'ram').noUiSlider.set([parseInt(nb_search_data["mem"]["rammin"]*2),99999]);
	document.getElementById(search_form_id+'_'+'freq').noUiSlider.set([parseInt(nb_search_data["mem"]["freqmax"]-3),99999]);
	return; 
}

function mem_submit(submit_param)
{
	submit_param=clean_submit_1(submit_param,nb_search_data,"mem");
	
	var extra_fields=[];
	extra_fields["mem_rammax"]=nb_search_data["mem"]["rammin"];
	extra_fields["mem_rammin"]=nb_search_data["mem"]["rammax"];
	
	submit_param=clean_submit_2(submit_param,extra_fields);
	
	submit_param = submit_param.filter(function(n){return n; });
	return submit_param; 
}

//# sourceURL=mem.js