function init_search_mdb(search_form_id,form_rest=0)
{
	// form_rest=0 - initialise
	// form_rest=1 - reset to defaults
	// form_rest=2 - reset to last_search
	
	//here we get default vars from nomen - nb_search_data
	if(set_search_vars==undefined){ var set_search_vars=Object(); } if(set_search_vars["mdb"]===undefined) { set_search_vars["mdb"]=Object(); }
	set_search_vars["mdb"]=JSON.parse(JSON.stringify(nb_search_data["mdb"]));
	set_search_vars["mdb"]["port"]=[];
	set_search_vars["mdb"]["vport"]=[];
	

	if(form_rest==1 || form_rest==2)
	{
		var select2_mdb_list=["MDB_port_id","MDB_vport_id"];
		for(var key in select2_mdb_list){ $('#'+search_form_id+'_'+select2_mdb_list[key]).val(null).trigger('change'); }
		//var select2_mdb_sliders_min_to_max={"budgetadv":{"min":"pricemin","max":"pricemax"}};             
		//for(var key in select2_mdb_sliders_min_to_max){ $('#'+search_form_id+'_'+key)[0].noUiSlider.set([0,9999999]); }
		//var select2_mdb_sliders_max_to_min=[];
		//for(var key in select2_mdb_sliders_max_to_min){ $('#'+search_form_id+'_'+key)[0].noUiSlider.set([9999999,0]); }
		//var select2_cpu_multiselect=["CPU_prod_id"];
		//for(var key in select2_cpu_multiselect){ reset_multiselect(search_form_id+'_'+select2_cpu_multiselect[key]); }
	}
	
	
	if(form_rest==0 || form_rest==2)
	{
		if(is_setparams('MDB_port_id[]')){ set_search_vars["mdb"]["port"]=setparams.getAll("MDB_port_id[]"); }else{set_search_vars["mdb"]["port"]=set_saved_search(set_search_vars["mdb"]["port"],last_search,"mdb","port");}
		if(is_setparams('MDB_vport_id[]')){ set_search_vars["mdb"]["vport"]=setparams.getAll("MDB_vport_id[]"); }else{set_search_vars["mdb"]["vport"]=set_saved_search(set_search_vars["mdb"]["vport"],last_search,"mdb","vport");}
		//if(is_setparams('mdb_Family_fam[]')){ set_search_vars["mdb"]["idfam"]=setparams.getAll("mdb_Family_fam[]"); }else{set_search_vars["mdb"]["idfam"]=set_saved_search(set_search_vars["mdb"]["idfam"],last_search,"mdb","idfam");}
		//if(is_setparams('mdb_pricemin')){ set_search_vars["mdb"]["pricemin"]=setparams.get("mdb_pricemin"); }else{ set_search_vars["mdb"]["pricemin"]=parseFloat(set_saved_search(set_search_vars["mdb"]["pricemin"],last_search,"mdb","pricemin")); }
		//if(is_setparams('mdb_pricemax')){ set_search_vars["mdb"]["pricemax"]=setparams.get("mdb_pricemax"); }else{ set_search_vars["mdb"]["pricemax"]=parseFloat(set_saved_search(set_search_vars["mdb"]["pricemax"],last_search,"mdb","pricemax")); }
	}

	if(form_rest==0)
	{
		
	}
	
	if(form_rest==0 || form_rest==2)
	{
		//SETTING SELECT2
		set_selected_select2('#'+search_form_id+'_'+'MDB_port_id',set_search_vars["mdb"]["port"]);
		set_selected_select2('#'+search_form_id+'_'+'MDB_vport_id',set_search_vars["mdb"]["vport"]);
		
	}

	if(form_rest==2)
	{
		//SETTING SLIDERS IN FORM_REST=2
		//for(var key in select2_mdb_sliders_min_to_max){ $('#'+search_form_id+'_'+key)[0].noUiSlider.set([set_search_vars["mdb"][select2_mdb_sliders_min_to_max[key]["min"]],set_search_vars["mdb"][select2_mdb_sliders_min_to_max[key]["max"]]]); }
	}
	
	if(form_rest==2)
	{
		//SETTING MULTISELECT
		set_multiselect(search_form_id+"_Regions_name_id",set_search_vars["mdb"]["regions"]);
	}
	
	//level enablement
	function determine_enablement_level_mdb()
	{
		var show_level=[];
		var enable_level=1;
		show_level[0]=[];
		show_level[1]=["port","vport"];
		show_level[2]=["mdb_wwan","mdb_slots"];

		//console.log(set_search_vars["cpu"]);
		for(var key in set_search_vars["mdb"])
		{
			if(Array.isArray(set_search_vars["mdb"][key]))
			{
				if(set_search_vars["mdb"][key].length>0)
				{ enable_level=test_show_level(show_level,key,enable_level); if(enable_level>1){break; } }
			}
			else
			{
				if(nb_search_data["mdb"][key]===undefined)
				{ enable_level=test_show_level(show_level,key,enable_level); if(enable_level>1){break; } }
				else
				{
					if(nb_search_data["mdb"][key]!=set_search_vars["mdb"][key])
					{ enable_level=test_show_level(show_level,key,enable_level); if(enable_level>1){break; } }
				}
			}
		}
		if(enable_level>1 && !document.getElementById("mdb_toggle").classList.contains('arrowUp'))
		{
			document.getElementById("mdb_toggle").click();
		}
		//console.log(enable_level);
	}
	determine_enablement_level_mdb();
}

function setrecommended_mdb(search_form_id)
{
	//document.getElementById(search_form_id+'_'+'budgetadv').noUiSlider.set([parseInt(nb_search_data["mdb"]["pricemin"]*2),99999]);
	//document.getElementById(search_form_id+'_'+'launchdate').noUiSlider.set([parseInt(nb_search_data["cpu"]["ldatemax"]-3),99999]);
	return; 
}

function mdb_submit(submit_param)
{
	submit_param=clean_submit_1(submit_param,nb_search_data,"mdb");

	var extra_fields=[];
	//extra_fields["mdb_pricemin"]=parseInt(nb_search_data["mdb"]["pricemin"]);
	
	submit_param=clean_submit_2(submit_param,extra_fields);
	
	submit_param = submit_param.filter(function(n){return n; });
	return submit_param; 
}

//# sourceURL=mdb.js