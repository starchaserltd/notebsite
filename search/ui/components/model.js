function init_search_model(search_form_id,form_rest=0)
{
	// form_rest=0 - initialise
	// form_rest=1 - reset to defaults
	// form_rest=2 - reset to last_search
	
	//here we get default vars from nomen - nb_search_data
	if(set_search_vars==undefined){ var set_search_vars=Object(); } if(set_search_vars["model"]===undefined) { set_search_vars["model"]=Object(); }
	set_search_vars["model"]=JSON.parse(JSON.stringify(nb_search_data["model"]));
	set_search_vars["model"]["regions"]=[];
	set_search_vars["model"]["producer"]=[];
	set_search_vars["model"]["family"]=[];

	if(form_rest==1 || form_rest==2)
	{
		var select2_model_list=["MODEL_Regions","MODEL_Producer_id","MODEL_Family_id"];
		for(var key in select2_model_list){ $('#'+search_form_id+'_'+select2_model_list[key]).val(null).trigger('change'); }
		var select2_model_sliders_min_to_max={"budgetadv":{"min":"pricemin","max":"pricemax"}};             
		for(var key in select2_model_sliders_min_to_max){ $('#'+search_form_id+'_'+key)[0].noUiSlider.set([0,9999999]); }
		var select2_model_sliders_max_to_min=[];
		for(var key in select2_model_sliders_max_to_min){ $('#'+search_form_id+'_'+key)[0].noUiSlider.set([9999999,0]); }
		//var select2_cpu_multiselect=["CPU_prod_id"];
		//for(var key in select2_cpu_multiselect){ reset_multiselect(search_form_id+'_'+select2_cpu_multiselect[key]); }
	}
	
	if(form_rest==0 || form_rest==2)
	{
		if(is_setparams('MODEL_Regions_id[]')){ set_search_vars["model"]["regions"]=setparams.getAll("MODEL_Regions_id[]"); }else{set_search_vars["model"]["regions"]=set_saved_search(set_search_vars["model"]["regions"],last_search,"model","regions");}
		if(is_setparams('MODEL_Producer_id[]')){ set_search_vars["model"]["producer"]=setparams.getAll("MODEL_Producer_id[]"); }else{set_search_vars["model"]["producer"]=set_saved_search(set_search_vars["model"]["producer"],last_search,"model","producer");}
		if(is_setparams('MODEL_Family_id[]')){ set_search_vars["model"]["family"]=setparams.getAll("MODEL_Family_id[]"); }else{set_search_vars["model"]["family"]=set_saved_search(set_search_vars["model"]["family"],last_search,"model","family");}
		if(is_setparams('model_pricemin')){ set_search_vars["model"]["pricemin"]=setparams.get("model_pricemin"); }else{ set_search_vars["model"]["pricemin"]=parseFloat(set_saved_search(set_search_vars["model"]["pricemin"],last_search,"model","pricemin")); }
		if(is_setparams('model_pricemax')){ set_search_vars["model"]["pricemax"]=setparams.get("model_pricemax"); }else{ set_search_vars["model"]["pricemax"]=parseFloat(set_saved_search(set_search_vars["model"]["pricemax"],last_search,"model","pricemax")); }
	}

	if(form_rest==0)
	{
		
		//var t = parseFloat(currency_val[$('#currencyadv').val()]);
		var t = 1;
		var x = set_search_vars["model"]["pricemin"]; var y = set_search_vars["model"]["pricemax"]; y=parseInt(y*t); x=parseInt(x*t); var minbadv=parseInt(nb_search_data["model"]["pricemin"]*t); var maxbadv=parseInt(nb_search_data["model"]["pricemax"]*t);	var rangemaxbadv=y;
;
		if(document.getElementById(search_form_id+'_budgetadv')!=null)
		{
			if(document.getElementById(search_form_id+'_budgetadv').noUiSlider===undefined)
			{
				noUiSlider.create(document.getElementById(search_form_id+'_budgetadv'), {
					start: [roundlimitadv(x), roundlimitadv(y)],
					connect: true,
					direction: 'ltr',
					format: { to: function(value){ return parseInt(value); }, from: function(value){ return parseInt(value); } },
					range: {
						'min': [ roundlimitadv(minbadv),roundstepadv((maxbadv-minbadv)*0.00065)],
						'10%': [ roundlimitadv(minbadv+(maxbadv-minbadv)*0.025),  roundstepadv((maxbadv-minbadv)*0.0015) ],
						'20%': [ roundlimitadv(minbadv+(maxbadv-minbadv)*0.035),  roundstepadv((maxbadv-minbadv)*0.0015)],
						'30%': [ roundlimitadv(minbadv+(maxbadv-minbadv)*0.055),  roundstepadv((maxbadv-minbadv)*0.0013)],
						'40%': [ roundlimitadv(minbadv+(maxbadv-minbadv)*0.075),  roundstepadv((maxbadv-minbadv)*0.0013) ],
						'50%': [ roundlimitadv(minbadv+(maxbadv-minbadv)*0.1),  roundstepadv((maxbadv-minbadv)*0.002) ],
						'60%': [ roundlimitadv(minbadv+(maxbadv-minbadv)*0.15),  roundstepadv((maxbadv-minbadv)*0.0033) ],
						'70%': [ roundlimitadv(minbadv+(maxbadv-minbadv)*0.20),  roundstepadv((maxbadv-minbadv)*0.0066) ],
						'80%': [ roundlimitadv(minbadv+(maxbadv-minbadv)*0.30),  roundstepadv((maxbadv-minbadv)*0.013) ],
						'90%': [ roundlimitadv(minbadv+(maxbadv-minbadv)*0.45), roundstepadv((maxbadv-minbadv)*0.033) ],		
						'max': [ roundlimitadv(maxbadv),roundstepadv((maxbadv-minbadv)*0.055)]
					}
				});
			}
			
			// HERE WE SET VALUES FOR INPUT BOX WHENT SLIDER IS MOVED
			document.getElementById(search_form_id+'_budgetadv').noUiSlider.on('update', function( values, handle ) {
				if (typeof values[0] === 'string' || values[0] instanceof String)
				{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

				if (typeof values[1] === 'string' || values[1] instanceof String)
				{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
				
				if(handle==0) {	document.getElementById(search_form_id+'_model_pricemin').value=left; }
				if(handle==1) {	document.getElementById(search_form_id+'_model_pricemax').value=right; }
			});
		}

		function sliderrangeadv(old) 
		{
			old=currency_val[old.oldvalue];
	
			if(old === undefined)
			{	
				old=basevalueoldadv;
			}
			//var t = parseFloat(currency_val[$('#'+search_form_id+'currencyadv').val()]);
			var t = 1;
			var x = Math.round($('#'+search_form_id+"_model_pricemin").val());
			var y = Math.round($('#'+search_form_id+"_model_pricemax").val());
			y=Math.round(y/old*t);
			x=Math.round(x/old*t);

			minbadv=Math.round(nb_search_data["model"]["pricemin"]*t); maxbadv=Math.round(nb_search_data["model"]["pricemax"]*t);
			document.getElementById(search_form_id+'_budgetadv').noUiSlider.updateOptions({
			range: {
				'min': [ roundlimitadv(minbadv),roundstepadv((maxbadv-minbadv)*0.0015)],
			//	'5%': [ roundlimitadv(minbadv+(maxbadv-minbadv)*0.03),  roundstepadv((maxbadv-minbadv)*0.0015) ],
			//	'10%': [ roundlimitadv(minbadv+(maxbadv-minbadv)*0.058),  roundstepadv((maxbadv-minbadv)*0.00284) ],
				'25%': [ roundlimitadv(minbadv+(maxbadv-minbadv)*0.145),  roundstepadv((maxbadv-minbadv)*0.0071)],
			//	'40%': [ roundlimitadv(minbadv+(maxbadv-minbadv)*0.2),  roundstepadv((maxbadv-minbadv)*0.015) ],
				'50%': [ roundlimitadv(minbadv+(maxbadv-minbadv)*0.285),  roundstepadv((maxbadv-minbadv)*0.01425) ],
			//	'60%': [ roundlimitadv(minbadv+(maxbadv-minbadv)*0.428),  roundstepadv((maxbadv-minbadv)*0.02) ],
				'70%': [ roundlimitadv(minbadv+(maxbadv-minbadv)*0.571),  roundstepadv((maxbadv-minbadv)*0.0285) ],
				'80%': [ roundlimitadv(minbadv+(maxbadv-minbadv)*0.8),  roundstepadv((maxbadv-minbadv)*0.04) ],
				'90%': [ roundlimitadv(minbadv+(maxbadv-minbadv)*0.9), roundstepadv((maxbadv-minbadv)*0.045) ],		
				'max': [ roundlimitadv(maxbadv),roundstepadv((maxbadv-minbadv)*0.055)]
				}
	
			});

			document.getElementById(search_form_id+'_budgetadv').noUiSlider.set([roundlimitadv(x), roundlimitadv(y)]);
			$('#'+search_form_id+"_model_pricemin").val(roundlimitadv(x));
			$('#'+search_form_id+"_model_pricemax").val(roundlimitadv(y));
		}			
	
		//HERE WE SET SLIDER DEPENDING ON WHAT IS IN THE INPUT BOXES
		function checkminadv()
		{ document.getElementById(search_form_id+'_budgetadv').noUiSlider.set([document.getElementById(search_form_id+"_model_pricemin").value, null]); }
		  
		function checkmaxadv()
		{ document.getElementById(search_form_id+'_budgetadv').noUiSlider.set([null,document.getElementById(search_form_id+"_model_pricemax").value]); }

		setTimeout(function(){ istime=1; },1200);
	}
	
	if(form_rest==0 || form_rest==2)
	{
		//SETTING SELECT2
		set_selected_select2('#'+search_form_id+'_'+'MODEL_Regions_id',set_search_vars["model"]["regions"]);
		set_selected_select2('#'+search_form_id+'_'+'MODEL_Producer_id',set_search_vars["model"]["producer"]);
		set_selected_select2('#'+search_form_id+'_'+'MODEL_Family_id',set_search_vars["model"]["family"]);
	}

	if(form_rest==2)
	{
		//SETTING SLIDERS IN FORM_REST=2
		for(var key in select2_model_sliders_min_to_max){ $('#'+search_form_id+'_'+key)[0].noUiSlider.set([set_search_vars["model"][select2_model_sliders_min_to_max[key]["min"]],set_search_vars["model"][select2_model_sliders_min_to_max[key]["max"]]]); }
	}
	
	if(form_rest==2)
	{
		//SETTING MULTISELECT
		//set_multiselect(search_form_id+"MODEL_Regions_id",set_search_vars["model"]["regions"]);
	}
	
	//level enablement
	function determine_enablement_level_model()
	{
		var show_level=[];
		var enable_level=1;
		show_level[0]=[];
		show_level[1]=["regions","pricemin","pricemax","producer","family"];
		show_level[2]=[];

		//console.log(set_search_vars["cpu"]);
		for(var key in set_search_vars["model"])
		{
			if(Array.isArray(set_search_vars["model"][key]))
			{
				if(set_search_vars["model"][key].length>0)
				{ enable_level=test_show_level(show_level,key,enable_level); if(enable_level>1){break; } }
			}
			else
			{
				if(nb_search_data["model"][key]===undefined)
				{ enable_level=test_show_level(show_level,key,enable_level); if(enable_level>1){break; } }
				else
				{
					if(nb_search_data["model"][key]!=set_search_vars["model"][key])
					{ enable_level=test_show_level(show_level,key,enable_level); if(enable_level>1){break; } }
				}
			}
		}
		if(enable_level>1 && !document.getElementById("model_toggle").classList.contains('arrowUp'))
		{
			document.getElementById("model_toggle").click();
		}
		//console.log(enable_level);
	}
	determine_enablement_level_model();
}

function setrecommended_model(search_form_id)
{
	document.getElementById(search_form_id+'_'+'budgetadv').noUiSlider.set([parseInt(nb_search_data["model"]["pricemin"]*2),99999]);
	//document.getElementById(search_form_id+'_'+'launchdate').noUiSlider.set([parseInt(nb_search_data["cpu"]["ldatemax"]-3),99999]);
	return; 
}

function model_submit(submit_param)
{
	submit_param=clean_submit_1(submit_param,nb_search_data,"model");

	var extra_fields=[];
	//extra_fields["model_pricemin"]=parseInt(nb_search_data["model"]["pricemin"]);
	
	submit_param=clean_submit_2(submit_param,extra_fields);
	
	submit_param = submit_param.filter(function(n){return n; });
	return submit_param; 
}

//# sourceURL=model.js