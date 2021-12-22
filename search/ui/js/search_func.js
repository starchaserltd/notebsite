/** CROSS SELECT 2 FILTERS **/
if(last_search === undefined){ var last_search=[]; if(getCookie('last_search') && getCookie('last_search').length>0) {var last_search = JSON.parse(getCookie('last_search')); } }

$(".multisearch").each(function()
{
	var $this = $(this);
	$this.select2({
    tags: false,
    multiple: true,
    tokenSeparators: [',',';'],
    minimumInputLength: 0,
	//maximumResultsForSearch: 20,
	searchType: "contains",
	language: {
		noResults: function() {	 names=$this[0].id.split('_'); return 'No matches found, please select different '+names[1]+' characteristics.'; },
			},
    ajax: { 
		quietMillis: 100,
		cache: false,
		dataType: "json",
        type: "POST",
        data: function (params) {
			names=$this[0].id.split('_');
			$idtype=$($this[0]).attr('data-idtype');
            var queryParameters = {
                q: names[1],
				list: names[2],
				keys: params.term,
			}
			if(window[names[1]+"_"+names[2]])
			queryParameters=$.extend(queryParameters, window[names[1]+"_"+names[2]])
			return queryParameters;
        },
        processResults: function (data) {
            return { 
                results: $.map(data, function (item) {
					return {
						id: properid(item, $idtype),
                        text: item.model ,
						prop: extrainfo(item,names[1]+"_"+names[2]),
						disabled: more(item.id)
                    }
				})
            };
        }
    }
})
.on("select2:select", function (e) {  filtersearch($this[0].id,e.params.data.text,1); })
.on("select2:unselect", function (e) {  filtersearch($this[0].id,e.params.data.text,10); })
});

function properid(item, idmodel)
{
	if(idmodel==1)
	{ return item.id; }
	else
	{ return item.model;}
}

function extrainfo(data, item)
{
	switch(item)
	{
		case "GPU_name":
		{ return data.typegpu; break; }
		default:
		{ return false; }	
	}
}

function more(id)
{
	if(id<0)
	{ return (true); }
	else
	{ return (false); }
}

function filtersearch(id,filter,type)
{
	$element=$('#'+id);
	el_id=$element.attr('data-lcom');
	field=$element.attr('data-lfield');

	if(!(el_id in window))
	{ window[el_id]={}; }

	//Do this if is option list
	if(!window[el_id][field])
		window[el_id][field]=[];

	switch (type) {
		case 1:
			if(window[el_id][field].indexOf(filter)<0)
			{ window[el_id][field].push(filter); }
			break;
		case 10:
			if(window[el_id][field].indexOf(filter)>=0)
			{ window[el_id][field].splice(window[el_id][field].indexOf(filter), 1);	}
			break;
		case 2:
			window[el_id][field]=filter;
			break;
		case 0:
			window[el_id][field]=filter;
			break;
		default:
		console.log("Something went terribly wrong!");
	}
	/// selected content from a field
	/// data-lcom = what other element from the page is influenced (without_id)
	/// data-lfield = what search field it influences from that element
	if($element.attr('data-lcom2'))
	{
		el_id2=$element.attr('data-lcom2');
		field2=$element.attr('data-lfield2');

		if(!(el_id2 in window))
		{ window[el_id2]={}; }

		if(!window[el_id2][field2])
		{ window[el_id2][field2]=[]; }
		
		switch (type) {
			case 1:
				if(window[el_id2][field2].indexOf(filter)<0)
				{ window[el_id2][field2].push(filter); }
				break;
			case 10:
				if(window[el_id2][field2].indexOf(filter)>=0)
				{ window[el_id2][field2].splice(window[el_id2][field2].indexOf(filter), 1);	}
				break;
			case 2:
				window[el_id2][field2]=filter;
				break;
			case 0:
				window[el_id2][field2]=filter;
				break;
			default:
			console.log("Something went terribly wrong!");
		}
	}	
}

function reset_search(search_form_id)
{
	init_search_cpu(search_form_id,1);
	$("#"+search_form_id+">.multisearch").each( function () { var data=$(this).data(); if(window[data["lcom"]]!==undefined && window[data["lcom"]][data["lfield"]]!==undefined){ window[data["lcom"]][data["lfield"]]=[]; } if(window[data["lcom2"]]!==undefined && window[data["lcom2"]][data["lfield2"]]!==undefined){ window[data["lcom2"]][data["lfield2"]]=[]; } });
}

/** END CROSS SELECT 2 FILTERS **/


// Function for advanced search
$('#submitformid').click(function(e)
{
	e.preventDefault();
	$('#loadingNB').show();
	trigger=0; var addref=""; if(ref!=null&&ref!="") { addref="?ref="+ref; }
	$.get('search/search.php'+addref, $("#advform").serialize(), function(data) {
		url = "search/search.php" + "?" + $("#advform").serialize();
		if(url.indexOf("ref=")<0){ if(ref!=null&&ref!="") { url=url+"&ref="+ref; } }
		currentpage = url;
		history.pushState(null, "NoteBrother", "?" + url);
		if($('#content').html(data)){ $('#loadingNB').hide(); }
	});
});
			
//FIRST, DEPENDING ON THE RANGE WE DECIDE THE NUMER SIZE
var rangemaxbadv=0;
function divideradv()
{
	var rangemaxbadv_temp=rangemaxbadv;
	i=1;
	while(rangemaxbadv_temp>1)
	{
		rangemaxbadv_temp=rangemaxbadv_temp/10;
		i++;
	}

	divide=Math.pow(10,i-4);
	if(i<=0) {divide=1;}
	return divide;
}

//SECONDLY WE ROUND THE BOUNDRIES SO THAT THE NUMBERS LOOK NICE AND ROUND
function roundlimitadv(val)
{
	divide=divideradv();
	val=parseInt(val/divide)*divide;
	if(val<=0){val=1;}
	return val;
}

//THIRDLY WE ROUND THE STEPS SO THAT THE STEPPING IS NICE AND ROUND
function roundstepadv(val)
{
	divide=divideradv();
	val=parseInt(val/divide)*divide;
	if(val<=0){val=10;}
	return val;
}

//HERE WE SET SLIDER DEPENDING ON WHAT IS IN THE INPUT BOXES
function checkminadv()
{ document.getElementById('budgetadv').noUiSlider.set([document.getElementById('bdgminadv').value, null]); }

function checkmaxadv()
{ document.getElementById('budgetadv').noUiSlider.set([null,document.getElementById('bdgmaxadv').value]); }

function create_multiselect(multiselect_options,multiselect_el,selected_options)
{
	let selection = document.getElementById(multiselect_el);
	//CREATING OPTIONS
	for(var opt_key in multiselect_options)
	{
		selection.append(new Option(multiselect_options[opt_key], multiselect_options[opt_key]))
		if(selected_options.includes(multiselect_options[opt_key]))
		{
			selection.options[opt_key].selected=true;
		}
		else
		{
			selection.options[opt_key].selected=false;
		}
	}
}

function set_multiselect(multiselect_el_name,selected_options)
{
	let multiselect_el=$('#'+multiselect_el_name);
	for(var key in selected_options)
	{
		multiselect_el.multiselect('select',selected_options);
	}
}

function reset_multiselect(multiselect_el)
{
	$("#"+multiselect_el).multiselect('deselectAll', false);
}

function set_selected_select2(element_name,options)
{
	for(var sel_opt_key in options){ $(element_name).append('<option value="'+options[sel_opt_key]+'" selected>'+options[sel_opt_key]+'</option>'); }
	delete sel_opt_key;
}

var setparams = {};

function is_setparams(var_name){ var to_return=false; if(setparams.getAll(var_name).length>0){ to_return=true;} return to_return; }

function setrecommended(search_form_id)
{
	setrecommended_model(search_form_id);
	setrecommended_cpu(search_form_id);
	return;
}

function submit_search(search_form_id)
{
	var submit_array=$(search_form_id).serializeArray();
	submit_array=model_submit(submit_array);
	submit_array=cpu_submit(submit_array);
	//console.log($.param(submit_array));
	last_search=proc_search_param_to_array(submit_array);
	setCookie('last_search',JSON.stringify(last_search),10);
	OpenPage("search/search.php?"+$.param(submit_array));
}

function clean_submit_1(submit_param,nb_search_data,comp)
{
	for(var key in nb_search_data[comp])
	{
		for(var submit_key in submit_param)
		{
			if(submit_param[submit_key]["name"]==(comp+"_"+key) && submit_param[submit_key]["value"]==nb_search_data[comp][key])
			{
				delete submit_param[submit_key];
			}
		}
	}
	return submit_param;
}

function clean_submit_2(submit_param,extra_fields)
{
	for(var key in extra_fields)
	{
		for(var submit_key in submit_param)
		{
			if(submit_param[submit_key]["name"]==key && submit_param[submit_key]["value"]==extra_fields[key])
			{
				delete submit_param[submit_key];
			}
		}
	}
	return submit_param;
}

function set_saved_search(current_val,saved_search,comp,param)
{
	var to_return=current_val;
	if(saved_search[comp]!==undefined)
	{
		if(saved_search[comp][param]!==undefined)
		{
			to_return=saved_search[comp][param];
		}
	}
	return to_return;
}

function test_show_level(show_level,key,enable_level)
{
	to_return=enable_level;
	if(show_level[2].includes(key))
	{ to_return=2; }
	else
	{
		if(to_return<1)
		{
			if(show_level[1].includes(key))
			{ to_return=1; }
		}
	}
	return to_return;
}
	
setTimeout(function(){ istime=1; },1200);

//# sourceURL=search_func.js