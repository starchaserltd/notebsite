function init_search_display(search_form_id,form_rest=0)
{
	// form_rest=0 - initialise
	// form_rest=1 - reset to defaults
	// form_rest=2 - reset to last_search
	
	//here we get default vars from nomen - nb_search_data
	if(set_search_vars==undefined){ var set_search_vars=Object(); } if(set_search_vars["display"]===undefined) { set_search_vars["display"]=Object(); }
	set_search_vars["display"]=JSON.parse(JSON.stringify(nb_search_data["display"]));
	set_search_vars["display"]["surface"]=[];
	set_search_vars["display"]["ratio"]=[];
	set_search_vars["display"]["resol"]=[];
	set_search_vars["display"]["msc"]=[];

	if(form_rest==1 || form_rest==2)
	{
		var select2_display_list=["display_surface_id","display_ratio_id","display_resol_id","display_msc_id"];
		for(var key in select2_display_list){ $('#'+search_form_id+'_'+select2_display_list[key]).val(null).trigger('change'); }
		var select2_display_sliders_min_to_max={"display":{"min":"displaymin","max":"displaymax"},"verresval":{"min":"verresmin","max":"verresmax"}};             
		for(var key in select2_display_sliders_min_to_max){ $('#'+search_form_id+'_'+key)[0].noUiSlider.set([0,9999999]); }
		var select2_display_sliders_max_to_min=[];
		for(var key in select2_display_sliders_max_to_min){ $('#'+search_form_id+'_'+key)[0].noUiSlider.set([9999999,0]); }
		//var select2_cpu_multiselect=["CPU_prod_id"];
		//for(var key in select2_cpu_multiselect){ reset_multiselect(search_form_id+'_'+select2_cpu_multiselect[key]); }
	}
	
	
	if(form_rest==0 || form_rest==2)
	{
		if(is_setparams('display_suface_id[]')){ set_search_vars["display"]["surface"]=setparams.getAll("display_suface_id[]"); }else{set_search_vars["display"]["surface"]=set_saved_search(set_search_vars["display"]["surface"],last_search,"display","surface");}
		if(is_setparams('display_ratio_id[]')){ set_search_vars["display"]["ratio"]=setparams.getAll("display_ratio_id[]"); }else{set_search_vars["display"]["ratio"]=set_saved_search(set_search_vars["display"]["ratio"],last_search,"display","ratio");}
		if(is_setparams('display_resol_id[]')){ set_search_vars["display"]["resol"]=setparams.getAll("display_resol_id[]"); }else{set_search_vars["display"]["resol"]=set_saved_search(set_search_vars["display"]["resol"],last_search,"display","resol");}
		if(is_setparams('display_msc_id[]')){ set_search_vars["display"]["msc"]=setparams.getAll("display_msc_id[]"); }else{set_search_vars["display"]["msc"]=set_saved_search(set_search_vars["display"]["msc"],last_search,"display","msc");}
		if(is_setparams('display_displaymin')){ set_search_vars["display"]["displaymin"]=setparams.get("display_displaymin"); }else{ set_search_vars["display"]["displaymin"]=parseFloat(set_saved_search(set_search_vars["display"]["displaymin"],last_search,"display","displaymin")); }
		if(is_setparams('display_displaymax')){ set_search_vars["display"]["displaymax"]=setparams.get("display_displaymax"); }else{ set_search_vars["display"]["displaymax"]=parseFloat(set_saved_search(set_search_vars["display"]["displaymax"],last_search,"display","displaymax")); }
		if(is_setparams('display_verresmin')){ set_search_vars["display"]["verresmin"]=setparams.get("display_verresmin"); }else{ set_search_vars["display"]["verresmin"]=parseFloat(set_saved_search(set_search_vars["display"]["verresmin"],last_search,"display","verresmin")); }
		if(is_setparams('display_verresmax')){ set_search_vars["display"]["verresmax"]=setparams.get("display_verresmax"); }else{ set_search_vars["display"]["verresmax"]=parseFloat(set_saved_search(set_search_vars["display"]["verresmax"],last_search,"display","verresmax")); }
	
	}

	if(form_rest==0)
	{
		
		//var t = parseFloat(currency_val[$('#currencyadv').val()]);
		var t = 1;
		var x = set_search_vars["display"]["displaymin"]; var y = set_search_vars["display"]["displaymax"]; y=parseInt(y*t); x=parseInt(x*t); var minbadv=parseInt(nb_search_data["display"]["displaymin"]*t); var maxbadv=parseInt(nb_search_data["display"]["displaymax"]*t);	var rangemaxbadv=y;
;
		if(document.getElementById('display')!=null)
		{
			if(document.getElementById('display').noUiSlider===undefined)
			{					
				noUiSlider.create(document.getElementById('display'), {
				start: [displaysizeminset, displaysizemaxset],
				connect: true,
				step: 0.1,
				direction: 'ltr',
				format: { to: function(value){ return parseFloat(parseFloat(value).toFixed(1)); }, from: function(value){ return parseFloat(parseFloat(value).toFixed(1)); } },
				range: 
						'min': [nb_search_data["display"]["displaymin"]],
						'max': [nb_search_data["display"]["displaymax"]]	
				});
			}

			//SET DISPLAY SLIDER TEXT UPDATE FUNCTIONS
			document.getElementById('display').noUiSlider.on('update', function( values, handle )
			{			
			if (typeof values[0] === 'string' || values[0] instanceof String)
			{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

			if (typeof values[1] === 'string' || values[1] instanceof String)
			{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
								
			if(handle==0) {	document.getElementById('displaymin').value=left;  }
			if(handle==1) {	document.getElementById('displaymax').value=right; }
							
			document.getElementById('displayval').innerHTML=left+" - "+right+ " inch";  
			});
		}

		//CREATE VERTICAL RES DISPLAY SLIDER
		if(document.getElementById('verres')!=null)
		{
			if(document.getElementById('verres').noUiSlider===undefined)
			{				
				noUiSlider.create(document.getElementById('verres'), {
					start: [displayvresminset, displayvresmaxset],
					connect: true,
					step: 10,
					direction: 'ltr',
					format: { to: function(value){ return parseFloat(parseFloat(value).toFixed(1)); }, from: function(value){ return parseFloat(parseFloat(value).toFixed(1)); } },
					range: 
						'min': [nb_search_data["display"]["verresmin"]],
						'max': [nb_search_data["display"]["verresmax"]]
				});
			}

		//SET VERTICAL RES DISPLAY SLIDER TEXT UPDATE FUNCTIONS
			document.getElementById('verres').noUiSlider.on('update', function( values, handle )
			{			
				if (typeof values[0] === 'string' || values[0] instanceof String)
				{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

				if (typeof values[1] === 'string' || values[1] instanceof String)
				{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
								
				if(handle==0) {	document.getElementById('verresmin').value=left; filtersearch('verresmin',left,0); }
				if(handle==1) {	document.getElementById('verresmax').value=right; filtersearch('verresmax',right,0); }

				document.getElementById('verresval').innerHTML=left+" - "+right+ " pixels";  
			});
		}		
	
		
	}
	
	if(form_rest==0 || form_rest==2)
	{
		//SETTING SELECT2 
		set_selected_select2('#'+search_form_id+'_'+'display_surface_id',set_search_vars["display"]["surface"]);
		set_selected_select2('#'+search_form_id+'_'+'display_ratio_id',set_search_vars["display"]["ratio"]);
		set_selected_select2('#'+search_form_id+'_'+'display_resol_id',set_search_vars["display"]["resol"]);
		set_selected_select2('#'+search_form_id+'_'+'display_msc_id',set_search_vars["display"]["msc"]);
	}

	if(form_rest==2)
	{
		//SETTING SLIDERS IN FORM_REST=2
		for(var key in select2_display_sliders_min_to_max){ $('#'+search_form_id+'_'+key)[0].noUiSlider.set([set_search_vars["display"][select2_display_sliders_min_to_max[key]["min"]],set_search_vars["display"][select2_display_sliders_min_to_max[key]["max"]]]); }
	}
	
	if(form_rest==2)
	{
		//SETTING MULTISELECT
		//set_multiselect(search_form_id+"_Regions_name_id",set_search_vars["display"]["regions"]);
	}
	
	//level enablement
	function determine_enablement_level_display()
	{
		var show_level=[];
		var enable_level=1;
		show_level[0]=[];
		show_level[1]=["displaymin","displaymax","verresmin","verresmax","msc"];
		show_level[2]=[];

		//console.log(set_search_vars["cpu"]);
		for(var key in set_search_vars["display"])
		{
			if(Array.isArray(set_search_vars["display"][key]))
			{
				if(set_search_vars["display"][key].length>0)
				{ enable_level=test_show_level(show_level,key,enable_level); if(enable_level>1){break; } }
			}
			else
			{
				if(nb_search_data["display"][key]===undefined)
				{ enable_level=test_show_level(show_level,key,enable_level); if(enable_level>1){break; } }
				else
				{
					if(nb_search_data["display"][key]!=set_search_vars["display"][key])
					{ enable_level=test_show_level(show_level,key,enable_level); if(enable_level>1){break; } }
				}
			}
		}
		if(enable_level>1 && !document.getElementById("display_toggle").classList.contains('arrowUp'))
		{
			document.getElementById("display_toggle").click();
		}
		//console.log(enable_level);
	}
	determine_enablement_level_display();
}

function setrecommended_display(search_form_id)
{
	//document.getElementById(search_form_id+'_'+'budgetadv').noUiSlider.set([parseInt(nb_search_data["display"]["pricemin"]*2),99999]);
	//document.getElementById(search_form_id+'_'+'launchdate').noUiSlider.set([parseInt(nb_search_data["cpu"]["ldatemax"]-3),99999]);
	return; 
}

function display_submit(submit_param)
{
	submit_param=clean_submit_1(submit_param,nb_search_data,"display");

	var extra_fields=[];
	//extra_fields["display_pricemin"]=parseInt(nb_search_data["display"]["pricemin"]);
	
	submit_param=clean_submit_2(submit_param,extra_fields);
	
	submit_param = submit_param.filter(function(n){return n; });
	return submit_param; 
}

//# sourceURL=display.js