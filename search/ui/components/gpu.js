function init_search_gpu(search_form_id,form_rest=0)
{
	// form_rest=0 - initialise
	// form_rest=1 - reset to defaults
	// form_rest=2 - reset to last_search
	
	//here we get default vars from nomen - nb_search_data
	if(set_search_vars==undefined){ var set_search_vars=Object(); } if(set_search_vars["gpu"]===undefined) { set_search_vars["gpu"]=Object(); }
	set_search_vars["gpu"]=JSON.parse(JSON.stringify(nb_search_data["gpu"]));
	set_search_vars["gpu"]["model"]=[];
	set_search_vars["gpu"]["arch"]=[];
	set_search_vars["gpu"]["msc"]=[];
	set_search_vars["gpu"]["prod"]=[];

	if(form_rest==1 || form_rest==2)
	{
		var select2_gpu_list=["gpu_prod_id","gpu_model_id","gpu_arch_id","gpu_msc_id"];
		for(var key in select2_gpu_list){ $('#'+search_form_id+'_'+select2_gpu_list[key]).val(null).trigger('change'); }
		var select2_gpu_sliders_min_to_max={"launchdate":{"min":"launchdatemin","max":"launchdatemin"},"gpumem":{"min":"memmin","max":"memmin"},
		"gpubus":{"min":"busmin","max":"busmax"},"gpupower":{"min":"powermin","max":"powermax"}};
		for(var key in select2_gpu_sliders_min_to_max){ $('#'+search_form_id+'_'+key)[0].noUiSlider.set([0,9999999]); }
		var select2_gpu_sliders_max_to_min=[];
		for(var key in select2_gpu_sliders_max_to_min){ $('#'+search_form_id+'_'+key)[0].noUiSlider.set([9999999,0]); }
		var select2_gpu_multiselect=["gpu_prod_id"];
		for(var key in select2_gpu_multiselect){ reset_multiselect(search_form_id+'_'+select2_gpu_multiselect[key]); }
	}
	
	
	if(form_rest==0 || form_rest==2)
	{
		if(is_setparams('gpu_model_id[]')){ set_search_vars["gpu"]["model"]=setparams.getAll("gpu_model_id[]"); }else{set_search_vars["gpu"]["model"]=set_saved_search(set_search_vars["gpu"]["model"],last_search,"gpu","model");}
		if(is_setparams('gpu_arch_id[]')){ set_search_vars["gpu"]["arch"]=setparams.getAll("gpu_arch_id[]"); }else{set_search_vars["gpu"]["arch"]=set_saved_search(set_search_vars["gpu"]["arch"],last_search,"gpu","arch");}
		if(is_setparams('gpu_msc_id[]')){ set_search_vars["gpu"]["msc"]=setparams.getAll("gpu_msc_id[]"); }else{set_search_vars["gpu"]["msc"]=set_saved_search(set_search_vars["gpu"]["msc"],last_search,"gpu","msc");}
		if(is_setparams('gpu_prod_id[]')){ set_search_vars["gpu"]["prod"]=setparams.getAll("gpu_prod_id[]"); }else{set_search_vars["gpu"]["prod"]=set_saved_search(set_search_vars["gpu"]["prod"],last_search,"gpu","prod");}
		if(is_setparams('gpu_launchdatemin')){ set_search_vars["gpu"]["launchdatemin"]=setparams.get("gpu_launchdatemin"); }else{ set_search_vars["gpu"]["launchdatemin"]=nb_search_data["gpu"]["launchdatemin"]; set_search_vars["gpu"]["launchdatemin"]=parseInt(set_saved_search(set_search_vars["gpu"]["launchdatemin"],last_search,"gpu","launchdatemin")); }
		if(is_setparams('gpu_launchdatemax')){ set_search_vars["gpu"]["launchdatemax"]=setparams.get("gpu_launchdatemax"); }else{ set_search_vars["gpu"]["launchdatemax"]=nb_search_data["gpu"]["launchdatemax"]; set_search_vars["gpu"]["launchdatemax"]=parseInt(set_saved_search(set_search_vars["gpu"]["launchdatemax"],last_search,"gpu","launchdatemax"));}
		if(is_setparams('gpu_memmin')){ set_search_vars["gpu"]["memmin"]=setparams.get("gpu_memmin"); }else{ set_search_vars["gpu"]["memmin"]=parseFloat(set_saved_search(set_search_vars["gpu"]["memmin"],last_search,"gpu","memmin")); }
		if(is_setparams('gpu_memmax')){ set_search_vars["gpu"]["memmax"]=setparams.get("gpu_memmax"); }else{ set_search_vars["gpu"]["memmax"]=parseInt(set_saved_search(set_search_vars["gpu"]["memmax"],last_search,"gpu","memmax")); }
		if(is_setparams('gpu_powermin')){ set_search_vars["gpu"]["powermin"]=setparams.get("gpu_powermin"); }else{ set_search_vars["gpu"]["powermin"]=parseFloat(set_saved_search(set_search_vars["gpu"]["powermin"],last_search,"gpu","powermin")); }
		if(is_setparams('gpu_powermax')){ set_search_vars["gpu"]["powermax"]=setparams.get("gpu_powermax"); }else{ set_search_vars["gpu"]["powermax"]=parseFloat(set_saved_search(set_search_vars["gpu"]["powermax"],last_search,"gpu","powermax")); }
		if(is_setparams('gpu_busmin')){ set_search_vars["gpu"]["busmin"]=setparams.get("gpu_busmin"); }else{ set_search_vars["gpu"]["busmin"]=parseFloat(set_saved_search(set_search_vars["gpu"]["busmin"],last_search,"gpu","busmin")); }
		if(is_setparams('gpu_busmax')){ set_search_vars["gpu"]["busmax"]=setparams.get("gpu_busmax"); }else{ set_search_vars["gpu"]["busmax"]=parseFloat(set_saved_search(set_search_vars["gpu"]["busmax"],last_search,"gpu","busmax")); }
	}

	if(form_rest==0)
	{
		$('.toggleHiddenButtons .glyphicon-chevron-down').click(function() { $('.hiddenOptions').toggle('slow'); $(this).toggleClass('arrowUp'); $("#"+search_form_id+'_'+"gpu_arch_id").trigger("change"); });

		create_multiselect(nb_search_data["gpu"]["prod"],search_form_id+'_'+"gpu_prod_id",set_search_vars["gpu"]["prod"]);

		//CREATE gpu DATE SLIDER
		if(document.getElementById(search_form_id+'_'+'gpulaunchdate')!=null)
		{
			if(document.getElementById(search_form_id+'_'+'gpulaunchdate').noUiSlider===undefined)
			{	
				noUiSlider.create(document.getElementById(search_form_id+'_'+'gpulaunchdate'), {
					start: [set_search_vars["gpu"]["launchdatemin"], set_search_vars["gpu"]["launchdatemax"]],
					connect: true,
					step: 1,
					direction: 'ltr',
					format: { to: function(value){ return parseInt(value); }, from: function(value){ return parseInt(value); } },
					range: {
						'min': [nb_search_data["gpu"]["launchdatemin"]],
						'max': [nb_search_data["gpu"]["launchdatemax"]]		
					}
				});
			}

			//SET gpu DATE SLIDER TEXT UPDATE FUNCTIONS
			document.getElementById(search_form_id+'_'+'gpulaunchdate').noUiSlider.on('update', function( values, handle ) 
			{
				if (typeof values[0] === 'string' || values[0] instanceof String)
				{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

				if (typeof values[1] === 'string' || values[1] instanceof String)
				{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
										
				if(handle==0) {	document.getElementById(search_form_id+'_'+'gpu_launchdatemin').value=left; filtersearch(search_form_id+'_'+'gpu_launchdatemin',left,0); }
				if(handle==1) {	document.getElementById(search_form_id+'_'+'gpu_launchdatemax').value=right; filtersearch(search_form_id+'_'+'gpu_launchdatemax',right,0); }
				document.getElementById(search_form_id+'_'+'gpu_launchdateval').innerHTML=left+" - "+right;
			});
		}

		//CREATE gpu memory SLIDER
		if(document.getElementById(search_form_id+'_'+'gpumem')!=null)
		{
			if(document.getElementById(search_form_id+'_'+'gpumem').noUiSlider===undefined)
			{					
				noUiSlider.create(document.getElementById(search_form_id+'_'+'gpumem'), {
					start: [set_search_vars["gpu"]["memmin"], set_search_vars["gpu"]["memmax"]],
					connect: true,
					step: 1,
					direction: 'ltr',
					format: { to: function(value){ return parseInt(value); }, from: function(value){ return parseInt(value); } },
					range: {
						'min': [nb_search_data["gpu"]["memmin"]],
						'max': [nb_search_data["gpu"]["memmax"]]		
					}
				});
			}

			//SET gpu memory SLIDER TEXT UPDATE FUNCTIONS
			document.getElementById(search_form_id+'_'+'gpumem').noUiSlider.on('update', function( values, handle ) 
			{
				if (typeof values[0] === 'string' || values[0] instanceof String)
				{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

				if (typeof values[1] === 'string' || values[1] instanceof String)
				{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
										
				if(handle==0) {	document.getElementById(search_form_id+'_'+'gpu_memmin').value=left; filtersearch(search_form_id+'_'+'gpu_memmin',left,0); }
				if(handle==1) {	document.getElementById(search_form_id+'_'+'gpu_memmax').value=right; filtersearch(search_form_id+'_'+'gpu_memmax',right,0); }
				document.getElementById(search_form_id+'_'+'gpu_memval').innerHTML=left+" - "+right;
			});
		}

		//CREATE gpu bus SLIDER
		if(document.getElementById(search_form_id+'_'+'gpubus')!=null)
		{
			if(document.getElementById(search_form_id+'_'+'gpubus').noUiSlider===undefined)
			{										
				noUiSlider.create(document.getElementById(search_form_id+'_'+'gpubus'), {
					start: [set_search_vars["gpu"]["busmin"], set_search_vars["gpu"]["busmax"]],
					connect: true,
					//step: 1,
					direction: 'ltr',
					format: { to: function(value){ return parseFloat(parseFloat(value).toFixed(1)); }, from: function(value){ return parseFloat(parseFloat(value).toFixed(1)); } },
					range: listrange(nb_search_data["gpu"]["gpu_busval"])
				});
			}

			//SET gpu bus SLIDER TEXT UPDATE FUNCTIONS
			document.getElementById(search_form_id+'_'+'gpubus').noUiSlider.on('update', function( values, handle )
			{
				
				if (typeof values[0] === 'string' || values[0] instanceof String)
				{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

				if (typeof values[1] === 'string' || values[1] instanceof String)
				{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
										
				if(handle==0) {	document.getElementById(search_form_id+'_'+'gpu_busmin').value=left; filtersearch(search_form_id+'_'+'gpu_busmin',left,0); }
				if(handle==1) {	document.getElementById(search_form_id+'_'+'gpu_busmax').value=right; filtersearch(search_form_id+'_'+'gpu_busmax',right,0); }
				document.getElementById(search_form_id+'_'+'gputdpval').innerHTML=left+" - "+right;
			});
		}
		//CREATE gpu power SLIDER
		if(document.getElementById(search_form_id+'_'+'gpupower')!=null)
		{
			if(document.getElementById(search_form_id+'_'+'gpupower').noUiSlider===undefined)
			{										
				noUiSlider.create(document.getElementById(search_form_id+'_'+'gpupower'), {
					start: [set_search_vars["gpu"]["powermin"], set_search_vars["gpu"]["powermax"]],
					connect: true,
					step: 0.1,
					direction: 'ltr',
					format: { to: function(value){ return parseFloat(parseFloat(value).toFixed(1)); }, from: function(value){ return parseFloat(parseFloat(value).toFixed(1)); } },
					range: {
						'min': [nb_search_data["gpu"]["powermin"]],
						'max': [nb_search_data["gpu"]["powermax"]]		
					}
				});
			}

			//SET gpu power SLIDER TEXT UPDATE FUNCTIONS
			document.getElementById(search_form_id+'_'+'gpupower').noUiSlider.on('update', function( values, handle )
			{
				if (typeof values[0] === 'string' || values[0] instanceof String)
				{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

				if (typeof values[1] === 'string' || values[1] instanceof String)
				{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
										
				if(handle==0) {	document.getElementById(search_form_id+'_'+'gpu_powermin').value=left; filtersearch(search_form_id+'_'+'gpu_powermin',left,0); }
				if(handle==1) {	document.getElementById(search_form_id+'_'+'gpu_powermax').value=right; filtersearch(search_form_id+'_'+'gpu_powermax',right,0); }
				document.getElementById(search_form_id+'_'+'gpu_powerval').innerHTML=left+" - "+right;
			});
		}
		

		$('#'+search_form_id+'_'+'gpu_prod_id').multiselect(btnsearch);				
		$('#'+search_form_id+'_'+'gpu_prod_id').change(function()
		{
			var gpup=$(this).attr('id');
			var gpusel = $('#'+search_form_id+'_'+'gpu_prod_id option:selected');
			var selected = [];
			$(gpusel).each(function(index, gpusel){ selected.push([$(this).val()].toString()); });
			filtersearch(gpup,selected,2);
		});
	}
	
	if(form_rest==0 || form_rest==2)
	{
		//SETTING SELECT2
		set_selected_select2('#'+search_form_id+'_'+'gpu_model_id',set_search_vars["gpu"]["model"]);
		set_selected_select2('#'+search_form_id+'_'+'gpu_prod_id',set_search_vars["gpu"]["prod"]);
		set_selected_select2('#'+search_form_id+'_'+'gpu_arch_id',set_search_vars["gpu"]["arch"]);
		set_selected_select2('#'+search_form_id+'_'+'gpu_msc_id',set_search_vars["gpu"]["msc"]);
	}
	
	if(form_rest==2)
	{
		//SETTING SLIDERS IN FORM_REST=2
		for(var key in select2_gpu_sliders_min_to_max){ $('#'+search_form_id+'_'+key)[0].noUiSlider.set([set_search_vars["gpu"][select2_gpu_sliders_min_to_max[key]["min"]],set_search_vars["gpu"][select2_gpu_sliders_min_to_max[key]["max"]]]); }
	}
	
	if(form_rest==2)
	{
		//SETTING MULTISELECT
		set_multiselect(search_form_id+"_gpu_prod_id",set_search_vars["gpu"]["prod"]);
	}
	
	//level enablement
	function determine_enablement_level_gpu()
	{
		var show_level=[];
		var enable_level=1;
		show_level[0]=[];
		show_level[1]=["memmin","memmax","model","powermin","powermax","launchdatemax","launchdatemin"];
		show_level[2]=["prod","msc","busmin","busmax","techmin","techmax"];

		//console.log(set_search_vars["gpu"]);
		for(var key in set_search_vars["gpu"])
		{
			if(Array.isArray(set_search_vars["gpu"][key]))
			{
				if(set_search_vars["gpu"][key].length>0)
				{ enable_level=test_show_level(show_level,key,enable_level); if(enable_level>1){break; } }
			}
			else
			{
				if(nb_search_data["gpu"][key]===undefined)
				{ enable_level=test_show_level(show_level,key,enable_level); if(enable_level>1){break; } }
				else
				{
					if(nb_search_data["gpu"][key]!=set_search_vars["gpu"][key])
					{ enable_level=test_show_level(show_level,key,enable_level); if(enable_level>1){break; } }
				}
			}
		}
		if(enable_level>1 && !document.getElementById("gpu_toggle").classList.contains('arrowUp'))
		{
			document.getElementById("gpu_toggle").click();
		}
		//console.log(enable_level);
	}
	determine_enablement_level_gpu();
}

function setrecommended_gpu(search_form_id)
{
	//document.getElementById(search_form_id+'_'+'nrcores').noUiSlider.set([parseInt(nb_search_data["gpu"]["coremin"]*2),99999]);
	document.getElementById(search_form_id+'_'+'gpulaunchdate').noUiSlider.set([parseInt(nb_search_data["gpu"]["launchdatemax"]-3),99999]);
	return; 
}

function gpu_submit(submit_param)
{
	submit_param=clean_submit_1(submit_param,nb_search_data,"gpu");
	
	var extra_fields=[];
	extra_fields["gpu_powermax"]=nb_search_data["gpu"]["powermin"];
	extra_fields["gpu_powermin"]=nb_search_data["gpu"]["powermax"];
	
	submit_param=clean_submit_2(submit_param,extra_fields);
	
	submit_param = submit_param.filter(function(n){return n; });
	return submit_param; 
}

//# sourceURL=gpu.js