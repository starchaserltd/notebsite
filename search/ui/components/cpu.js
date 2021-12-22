function init_search_cpu(search_form_id,form_rest=0)
{
	// form_rest=0 - initialise
	// form_rest=1 - reset to defaults
	// form_rest=2 - reset to last_search
	
	//here we get default vars from nomen - nb_search_data
	if(set_search_vars==undefined){ var set_search_vars=Object(); } if(set_search_vars["cpu"]===undefined) { set_search_vars["cpu"]=Object(); }
	set_search_vars["cpu"]=JSON.parse(JSON.stringify(nb_search_data["cpu"]));
	set_search_vars["cpu"]["model"]=[];
	set_search_vars["cpu"]["socket"]=[];
	set_search_vars["cpu"]["msc"]=[];
	set_search_vars["cpu"]["prod"]=[];

	if(form_rest==1 || form_rest==2)
	{
		var select2_cpu_list=["CPU_prod_id","CPU_model_id","CPU_socket_id","CPU_msc_id"];
		for(var key in select2_cpu_list){ $('#'+search_form_id+'_'+select2_cpu_list[key]).val(null).trigger('change'); }
		var select2_cpu_sliders_min_to_max={"launchdate":{"min":"ldatemin","max":"ldatemax"},"nrcores":{"min":"coremin","max":"coremax"},"cputdp":{"min":"tdpmin","max":"tdpmax"},"cpufreq":{"min":"freqmin","max":"freqmax"},"cputech":{"min":"techmax","max":"techmin"}};
		for(var key in select2_cpu_sliders_min_to_max){ $('#'+search_form_id+'_'+key)[0].noUiSlider.set([0,9999999]); }
		var select2_cpu_sliders_max_to_min=[];
		for(var key in select2_cpu_sliders_max_to_min){ $('#'+search_form_id+'_'+key)[0].noUiSlider.set([9999999,0]); }
		var select2_cpu_multiselect=["CPU_prod_id"];
		for(var key in select2_cpu_multiselect){ reset_multiselect(search_form_id+'_'+select2_cpu_multiselect[key]); }
	}
	
	
	if(form_rest==0 || form_rest==2)
	{
		if(is_setparams('CPU_model_id[]')){ set_search_vars["cpu"]["model"]=setparams.getAll("CPU_model_id[]"); }else{set_search_vars["cpu"]["model"]=set_saved_search(set_search_vars["cpu"]["model"],last_search,"cpu","model");}
		if(is_setparams('CPU_socket_id[]')){ set_search_vars["cpu"]["socket"]=setparams.getAll("CPU_socket_id[]"); }else{set_search_vars["cpu"]["socket"]=set_saved_search(set_search_vars["cpu"]["socket"],last_search,"cpu","socket");}
		if(is_setparams('CPU_msc_id[]')){ set_search_vars["cpu"]["msc"]=setparams.getAll("CPU_msc_id[]"); }else{set_search_vars["cpu"]["msc"]=set_saved_search(set_search_vars["cpu"]["msc"],last_search,"cpu","msc");}
		if(is_setparams('CPU_prod_id[]')){ set_search_vars["cpu"]["prod"]=setparams.getAll("CPU_prod_id[]"); }else{set_search_vars["cpu"]["prod"]=set_saved_search(set_search_vars["cpu"]["prod"],last_search,"cpu","prod");}
		if(is_setparams('cpu_ldatemin')){ set_search_vars["cpu"]["ldatemin"]=setparams.get("cpu_ldatemin"); }else{ set_search_vars["cpu"]["ldatemin"]=nb_search_data["cpu"]["ldatemin"]; set_search_vars["cpu"]["ldatemin"]=parseInt(set_saved_search(set_search_vars["cpu"]["ldatemin"],last_search,"cpu","ldatemin")); }
		if(is_setparams('cpu_ldatemax')){ set_search_vars["cpu"]["ldatemax"]=setparams.get("cpu_ldatemax"); }else{ set_search_vars["cpu"]["ldatemax"]=nb_search_data["cpu"]["ldatemax"]; set_search_vars["cpu"]["ldatemax"]=parseInt(set_saved_search(set_search_vars["cpu"]["ldatemax"],last_search,"cpu","ldatemax"));}
		if(is_setparams('cpu_coremin')){ set_search_vars["cpu"]["coremin"]=setparams.get("cpu_coremin"); }else{set_search_vars["cpu"]["coremin"]=2; set_search_vars["cpu"]["coremin"]=parseInt(set_saved_search(set_search_vars["cpu"]["coremin"],last_search,"cpu","coremin")); }
		if(is_setparams('cpu_coremax')){ set_search_vars["cpu"]["coremax"]=setparams.get("cpu_coremax"); }else{ set_search_vars["cpu"]["coremax"]=parseInt(set_saved_search(set_search_vars["cpu"]["coremax"],last_search,"cpu","coremax")); }
		if(is_setparams('cpu_tdpmin')){ set_search_vars["cpu"]["tdpmin"]=setparams.get("cpu_tdpmin"); }else{ set_search_vars["cpu"]["tdpmin"]=parseFloat(set_saved_search(set_search_vars["cpu"]["tdpmin"],last_search,"cpu","tdpmin")); }
		if(is_setparams('cpu_tdpmax')){ set_search_vars["cpu"]["tdpmax"]=setparams.get("cpu_tdpmax"); }else{ set_search_vars["cpu"]["tdpmax"]=parseFloat(set_saved_search(set_search_vars["cpu"]["tdpmax"],last_search,"cpu","tdpmax")); }
		if(is_setparams('cpu_freqmin')){ set_search_vars["cpu"]["freqmin"]=setparams.get("cpu_freqmin"); }else{ set_search_vars["cpu"]["freqmin"]=parseFloat(set_saved_search(set_search_vars["cpu"]["freqmin"],last_search,"cpu","freqmin")); }
		if(is_setparams('cpu_freqmax')){ set_search_vars["cpu"]["freqmax"]=setparams.get("cpu_freqmax"); }else{ set_search_vars["cpu"]["freqmax"]=parseFloat(set_saved_search(set_search_vars["cpu"]["freqmax"],last_search,"cpu","freqmax")); }
		if(is_setparams('cpu_techmax')){ set_search_vars["cpu"]["techmin"]=setparams.get("cpu_techmax"); }else{ set_search_vars["cpu"]["techmax"]=parseFloat(set_saved_search(set_search_vars["cpu"]["techmax"],last_search,"cpu","techmax")); }
		if(is_setparams('cpu_techmin')){ set_search_vars["cpu"]["techmax"]=setparams.get("cpu_techmin"); }else{ set_search_vars["cpu"]["techmin"]=parseFloat(set_saved_search(set_search_vars["cpu"]["techmin"],last_search,"cpu","techmin")); }
	}

	if(form_rest==0)
	{
		$('.toggleHiddenButtons .glyphicon-chevron-down').click(function() { $('.hiddenOptions').toggle('slow'); $(this).toggleClass('arrowUp'); $("#"+search_form_id+'_'+"CPU_socket_id").trigger("change"); });

		create_multiselect(nb_search_data["cpu"]["prod"],search_form_id+'_'+"CPU_prod_id",set_search_vars["cpu"]["prod"]);

		//CREATE CPU DATE SLIDER
		if(document.getElementById(search_form_id+'_'+'launchdate')!=null)
		{
			if(document.getElementById(search_form_id+'_'+'launchdate').noUiSlider===undefined)
			{	
				noUiSlider.create(document.getElementById(search_form_id+'_'+'launchdate'), {
					start: [set_search_vars["cpu"]["ldatemin"], set_search_vars["cpu"]["ldatemax"]],
					connect: true,
					step: 1,
					direction: 'ltr',
					format: { to: function(value){ return parseInt(value); }, from: function(value){ return parseInt(value); } },
					range: {
						'min': [nb_search_data["cpu"]["ldatemin"]],
						'max': [nb_search_data["cpu"]["ldatemax"]]		
					}
				});
			}

			//SET CPU DATE SLIDER TEXT UPDATE FUNCTIONS
			document.getElementById(search_form_id+'_'+'launchdate').noUiSlider.on('update', function( values, handle ) 
			{
				if (typeof values[0] === 'string' || values[0] instanceof String)
				{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

				if (typeof values[1] === 'string' || values[1] instanceof String)
				{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
										
				if(handle==0) {	document.getElementById(search_form_id+'_'+'cpu_ldatemin').value=left; filtersearch(search_form_id+'_'+'cpu_ldatemin',left,0); }
				if(handle==1) {	document.getElementById(search_form_id+'_'+'cpu_ldatemax').value=right; filtersearch(search_form_id+'_'+'cpu_ldatemax',right,0); }
				document.getElementById(search_form_id+'_'+'launchdateval').innerHTML=left+" - "+right;
			});
		}

		//CREATE CPU CORE SLIDER
		if(document.getElementById(search_form_id+'_'+'nrcores')!=null)
		{
			if(document.getElementById(search_form_id+'_'+'nrcores').noUiSlider===undefined)
			{					
				noUiSlider.create(document.getElementById(search_form_id+'_'+'nrcores'), {
					start: [set_search_vars["cpu"]["coremin"], set_search_vars["cpu"]["coremax"]],
					connect: true,
					step: 2,
					direction: 'ltr',
					format: { to: function(value){ return parseInt(value); }, from: function(value){ return parseInt(value); } },
					range: {
						'min': [nb_search_data["cpu"]["coremin"]],
						'max': [nb_search_data["cpu"]["coremax"]]		
					}
				});
			}

			//SET CPU CORE SLIDER TEXT UPDATE FUNCTIONS
			document.getElementById(search_form_id+'_'+'nrcores').noUiSlider.on('update', function( values, handle ) 
			{
				if (typeof values[0] === 'string' || values[0] instanceof String)
				{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

				if (typeof values[1] === 'string' || values[1] instanceof String)
				{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
										
				if(handle==0) {	document.getElementById(search_form_id+'_'+'cpu_coremin').value=left; filtersearch(search_form_id+'_'+'cpu_coremin',left,0); }
				if(handle==1) {	document.getElementById(search_form_id+'_'+'cpu_coremax').value=right; filtersearch(search_form_id+'_'+'cpu_coremax',right,0); }
				document.getElementById(search_form_id+'_'+'nrcoresval').innerHTML=left+" - "+right;
			});
		}

		//CREATE CPU TDP SLIDER
		if(document.getElementById(search_form_id+'_'+'cputdp')!=null)
		{
			if(document.getElementById(search_form_id+'_'+'cputdp').noUiSlider===undefined)
			{										
				noUiSlider.create(document.getElementById(search_form_id+'_'+'cputdp'), {
					start: [set_search_vars["cpu"]["tdpmin"], set_search_vars["cpu"]["tdpmax"]],
					connect: true,
					//step: 1,
					direction: 'ltr',
					format: { to: function(value){ return parseFloat(parseFloat(value).toFixed(1)); }, from: function(value){ return parseFloat(parseFloat(value).toFixed(1)); } },
					range: listrange(nb_search_data["cpu"]["tdps"])
				});
			}

			//SET CPU TDP SLIDER TEXT UPDATE FUNCTIONS
			document.getElementById(search_form_id+'_'+'cputdp').noUiSlider.on('update', function( values, handle )
			{
				
				if (typeof values[0] === 'string' || values[0] instanceof String)
				{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

				if (typeof values[1] === 'string' || values[1] instanceof String)
				{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
										
				if(handle==0) {	document.getElementById(search_form_id+'_'+'cpu_tdpmin').value=left; filtersearch(search_form_id+'_'+'cpu_tdpmin',left,0); }
				if(handle==1) {	document.getElementById(search_form_id+'_'+'cpu_tdpmax').value=right; filtersearch(search_form_id+'_'+'cpu_tdpmax',right,0); }
				document.getElementById(search_form_id+'_'+'cputdpval').innerHTML=left+" - "+right;
			});
		}
		//CREATE CPU FREQ SLIDER
		if(document.getElementById(search_form_id+'_'+'cpufreq')!=null)
		{
			if(document.getElementById(search_form_id+'_'+'cpufreq').noUiSlider===undefined)
			{										
				noUiSlider.create(document.getElementById(search_form_id+'_'+'cpufreq'), {
					start: [set_search_vars["cpu"]["freqmin"], set_search_vars["cpu"]["freqmax"]],
					connect: true,
					step: 0.1,
					direction: 'ltr',
					format: { to: function(value){ return parseFloat(parseFloat(value).toFixed(1)); }, from: function(value){ return parseFloat(parseFloat(value).toFixed(1)); } },
					range: {
						'min': [nb_search_data["cpu"]["freqmin"]],
						'max': [nb_search_data["cpu"]["freqmax"]]		
					}
				});
			}

			//SET CPU FREQ SLIDER TEXT UPDATE FUNCTIONS
			document.getElementById(search_form_id+'_'+'cpufreq').noUiSlider.on('update', function( values, handle )
			{
				if (typeof values[0] === 'string' || values[0] instanceof String)
				{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

				if (typeof values[1] === 'string' || values[1] instanceof String)
				{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
										
				if(handle==0) {	document.getElementById(search_form_id+'_'+'cpu_freqmin').value=left; filtersearch(search_form_id+'_'+'cpu_freqmin',left,0); }
				if(handle==1) {	document.getElementById(search_form_id+'_'+'cpu_freqmax').value=right; filtersearch(search_form_id+'_'+'cpu_freqmax',right,0); }
				document.getElementById(search_form_id+'_'+'cpufreqval').innerHTML=left+" - "+right;
			});
		}
		//CREATE TECH CPU SLIDER
		if(document.getElementById(search_form_id+'_'+'cputech')!=null)
		{
			if(document.getElementById(search_form_id+'_'+'cputech').noUiSlider===undefined)
			{											
				noUiSlider.create(document.getElementById(search_form_id+'_'+'cputech'), {
					start: [set_search_vars["cpu"]["techmax"],set_search_vars["cpu"]["techmin"]],
					connect: true,
					step: 1,
					direction: 'ltr',
					format: { to: function(value){ return parseInt(value); }, from: function(value){ return parseInt(value); } },
					range: listrange(nb_search_data["cpu"]["techlist"])
				});
			}

			//SET CPU TECH SLIDER TEXT UPDATE FUNCTIONS
			document.getElementById(search_form_id+'_'+'cputech').noUiSlider.on('update', function( values, handle )
			{
				if (typeof values[0] === 'string' || values[0] instanceof String)
				{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

				if (typeof values[1] === 'string' || values[1] instanceof String)
				{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
										
				if(handle==0) {	document.getElementById(search_form_id+'_'+'cpu_techmin').value=left; filtersearch(search_form_id+'_'+'cpu_techmin',left,0); }
				if(handle==1) {	document.getElementById(search_form_id+'_'+'cpu_techmax').value=right; filtersearch(search_form_id+'_'+'cpu_techmax',right,0); }
				document.getElementById(search_form_id+'_'+'cputechval').innerHTML=left+" - "+right;
			});
		}

		$('#'+search_form_id+'_'+'CPU_prod_id').multiselect(btnsearch);				
		$('#'+search_form_id+'_'+'CPU_prod_id').change(function()
		{
			var cpup=$(this).attr('id');
			var cpusel = $('#'+search_form_id+'_'+'CPU_prod_id option:selected');
			var selected = [];
			$(cpusel).each(function(index, cpusel){ selected.push([$(this).val()].toString()); });
			filtersearch(cpup,selected,2);
		});
	}
	
	if(form_rest==0 || form_rest==2)
	{
		//SETTING SELECT2
		set_selected_select2('#'+search_form_id+'_'+'CPU_model_id',set_search_vars["cpu"]["model"]);
		set_selected_select2('#'+search_form_id+'_'+'CPU_socket_id',set_search_vars["cpu"]["socket"]);
		set_selected_select2('#'+search_form_id+'_'+'CPU_msc_id',set_search_vars["cpu"]["msc"]);
	}
	
	if(form_rest==2)
	{
		//SETTING SLIDERS IN FORM_REST=2
		for(var key in select2_cpu_sliders_min_to_max){ $('#'+search_form_id+'_'+key)[0].noUiSlider.set([set_search_vars["cpu"][select2_cpu_sliders_min_to_max[key]["min"]],set_search_vars["cpu"][select2_cpu_sliders_min_to_max[key]["max"]]]); }
	}
	
	if(form_rest==2)
	{
		//SETTING MULTISELECT
		set_multiselect(search_form_id+"_CPU_prod_id",set_search_vars["cpu"]["prod"]);
	}
	
	//level enablement
	function determine_enablement_level_cpu()
	{
		var show_level=[];
		var enable_level=1;
		show_level[0]=[];
		show_level[1]=["msc","coremin","coremax","model","tdpmin","tdpmax","ldatemax","ldatemin"];
		show_level[2]=["prod","socket","freqmin","freqmax","techmin","techmax"];

		//console.log(set_search_vars["cpu"]);
		for(var key in set_search_vars["cpu"])
		{
			if(Array.isArray(set_search_vars["cpu"][key]))
			{
				if(set_search_vars["cpu"][key].length>0)
				{ enable_level=test_show_level(show_level,key,enable_level); if(enable_level>1){break; } }
			}
			else
			{
				if(nb_search_data["cpu"][key]===undefined)
				{ enable_level=test_show_level(show_level,key,enable_level); if(enable_level>1){break; } }
				else
				{
					if(nb_search_data["cpu"][key]!=set_search_vars["cpu"][key])
					{ enable_level=test_show_level(show_level,key,enable_level); if(enable_level>1){break; } }
				}
			}
		}
		if(enable_level>1 && !document.getElementById("cpu_toggle").classList.contains('arrowUp'))
		{
			document.getElementById("cpu_toggle").click();
		}
		//console.log(enable_level);
	}
	determine_enablement_level_cpu();
}

function setrecommended_cpu(search_form_id)
{
	document.getElementById(search_form_id+'_'+'nrcores').noUiSlider.set([parseInt(nb_search_data["cpu"]["coremin"]*2),99999]);
	document.getElementById(search_form_id+'_'+'launchdate').noUiSlider.set([parseInt(nb_search_data["cpu"]["ldatemax"]-3),99999]);
	return; 
}

function cpu_submit(submit_param)
{
	submit_param=clean_submit_1(submit_param,nb_search_data,"cpu");
	
	var extra_fields=[];
	extra_fields["cpu_techmax"]=nb_search_data["cpu"]["techmin"];
	extra_fields["cpu_techmin"]=nb_search_data["cpu"]["techmax"];
	
	submit_param=clean_submit_2(submit_param,extra_fields);
	
	submit_param = submit_param.filter(function(n){return n; });
	return submit_param; 
}

//# sourceURL=cpu.js