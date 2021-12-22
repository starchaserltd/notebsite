function init_search_hdd(search_form_id,form_rest=0)
{
	// form_rest=0 - initialise
	// form_rest=1 - reset to defaults
	// form_rest=2 - reset to last_search
	
	//here we get default vars from nomen - nb_search_data
	if(set_search_vars==undefined){ var set_search_vars=Object(); } if(set_search_vars["hdd"]===undefined) { set_search_vars["hdd"]=Object(); }
	set_search_vars["hdd"]=JSON.parse(JSON.stringify(nb_search_data["hdd"]));
	set_search_vars["hdd"]["type"]=[];
	

	if(form_rest==1 || form_rest==2)
	{
		var select2_hdd_list=["hdd_type"];
		for(var key in select2_hdd_list){ $('#'+search_form_id+'_'+select2_hdd_list[key]).val(null).trigger('change'); }
		var select2_hdd_sliders_min_to_max={"capacity":{"min":"capmin","max":"capmax"}};             
		for(var key in select2_hdd_sliders_min_to_max){ $('#'+search_form_id+'_'+key)[0].noUiSlider.set([0,9999999]); }
		var select2_hdd_sliders_max_to_min=[];
		for(var key in select2_hdd_sliders_max_to_min){ $('#'+search_form_id+'_'+key)[0].noUiSlider.set([9999999,0]); }
		//var select2_cpu_multiselect=["CPU_prod_id"];
		//for(var key in select2_cpu_multiselect){ reset_multiselect(search_form_id+'_'+select2_cpu_multiselect[key]); }
	}
	
	
	if(form_rest==0 || form_rest==2)
	{
		if(is_setparams('hdd_type[]')){ set_search_vars["hdd"]["type"]=setparams.getAll("hdd_type[]"); }else{set_search_vars["hdd"]["type"]=set_saved_search(set_search_vars["hdd"]["type"],last_search,"hdd","type");}
		//if(is_setparams('hdd_Producer_prod[]')){ set_search_vars["hdd"]["prod"]=setparams.getAll("hdd_Producer_prod[]"); }else{set_search_vars["hdd"]["prod"]=set_saved_search(set_search_vars["hdd"]["prod"],last_search,"hdd","prod");}
		//if(is_setparams('hdd_Family_fam[]')){ set_search_vars["hdd"]["idfam"]=setparams.getAll("hdd_Family_fam[]"); }else{set_search_vars["hdd"]["idfam"]=set_saved_search(set_search_vars["hdd"]["idfam"],last_search,"hdd","idfam");}
		//if(is_setparams('hdd_pricemin')){ set_search_vars["hdd"]["pricemin"]=setparams.get("hdd_pricemin"); }else{ set_search_vars["hdd"]["pricemin"]=parseFloat(set_saved_search(set_search_vars["hdd"]["pricemin"],last_search,"hdd","pricemin")); }
		//if(is_setparams('hdd_pricemax')){ set_search_vars["hdd"]["pricemax"]=setparams.get("hdd_pricemax"); }else{ set_search_vars["hdd"]["pricemax"]=parseFloat(set_saved_search(set_search_vars["hdd"]["pricemax"],last_search,"hdd","pricemax")); }
	}

	if(form_rest==0)
	{
	
		//CREATE CAPACITY SLIDER
		if(document.getElementById('capacity')!=null)
		{
			if(document.getElementById('capacity').noUiSlider===undefined)
			{					
				noUiSlider.create(document.getElementById('capacity'), {
					start: [totalcapminset, totalcapmaxset],
						connect: true,
					step: 1,
					direction: 'ltr',
					format: { to: function(value){ return parseInt(value); }, from: function(value){ return parseInt(value); } },
					range: 
						'min': [nb_search_data["display"]["capmin"]],
						'max': [nb_search_data["display"]["capmax"]]
					
			});
		}

		//SET CAPACITY SLIDER TEXT UPDATE FUNCTIONS
		document.getElementById('capacity').noUiSlider.on('update', function( values, handle )
		{
			if (typeof values[0] === 'string' || values[0] instanceof String)
			{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

			if (typeof values[1] === 'string' || values[1] instanceof String)
			{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
		
			if(handle==0) {	document.getElementById('capmin').value=left; }
			if(handle==1) {	document.getElementById('capmax').value=right;  }
			document.getElementById('hdd_capacityval').innerHTML=left+" - "+right+" GB";
		});
		}
	}
	
	if(form_rest==0 || form_rest==2)
	{
		//SETTING SELECT2
		set_selected_select2('#'+search_form_id+'_'+'hdd_type',set_search_vars["hdd"]["type"]);
		//set_selected_select2('#'+search_form_id+'_'+'hdd_Producer_prod',set_search_vars["hdd"]["prod"]);
		//set_selected_select2('#'+search_form_id+'_'+'hdd_Family_fam',set_search_vars["hdd"]["idfam"]);
	}

	if(form_rest==2)
	{
		//SETTING SLIDERS IN FORM_REST=2
		for(var key in select2_hdd_sliders_min_to_max){ $('#'+search_form_id+'_'+key)[0].noUiSlider.set([set_search_vars["hdd"][select2_hdd_sliders_min_to_max[key]["min"]],set_search_vars["hdd"][select2_hdd_sliders_min_to_max[key]["max"]]]); }
	}
	
	if(form_rest==2)
	{
		//SETTING MULTISELECT
		//set_multiselect(search_form_id+"_Regions_name_id",set_search_vars["hdd"]["regions"]);
	}
	
	//level enablement
	function determine_enablement_level_hdd()
	{
		var show_level=[];
		var enable_level=1;
		show_level[0]=[];
		show_level[1]=["type","capmin","capmax"];
		show_level[2]=[];

		//console.log(set_search_vars["cpu"]);
		for(var key in set_search_vars["hdd"])
		{
			if(Array.isArray(set_search_vars["hdd"][key]))
			{
				if(set_search_vars["hdd"][key].length>0)
				{ enable_level=test_show_level(show_level,key,enable_level); if(enable_level>1){break; } }
			}
			else
			{
				if(nb_search_data["hdd"][key]===undefined)
				{ enable_level=test_show_level(show_level,key,enable_level); if(enable_level>1){break; } }
				else
				{
					if(nb_search_data["hdd"][key]!=set_search_vars["hdd"][key])
					{ enable_level=test_show_level(show_level,key,enable_level); if(enable_level>1){break; } }
				}
			}
		}
		if(enable_level>1 && !document.getElementById("hdd_toggle").classList.contains('arrowUp'))
		{
			document.getElementById("hdd_toggle").click();
		}
		//console.log(enable_level);
	}
	determine_enablement_level_hdd();
}

/*function setrecommended_hdd(search_form_id)
{
	document.getElementById(search_form_id+'_'+'budgetadv').noUiSlider.set([parseInt(nb_search_data["hdd"]["pricemin"]*2),99999]);
	//document.getElementById(search_form_id+'_'+'launchdate').noUiSlider.set([parseInt(nb_search_data["cpu"]["ldatemax"]-3),99999]);
	return; 
}*/

function hdd_submit(submit_param)
{
	submit_param=clean_submit_1(submit_param,nb_search_data,"hdd");

	var extra_fields=[];
	//extra_fields["hdd_pricemin"]=parseInt(nb_search_data["hdd"]["pricemin"]);
	
	submit_param=clean_submit_2(submit_param,extra_fields);
	
	submit_param = submit_param.filter(function(n){return n; });
	return submit_param; 
}

//# sourceURL=hdd.js