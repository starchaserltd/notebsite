$(".multisearch").each(function()
{
	var $this = $(this);
	$this.select2({
    tags: false,
    multiple: true,
    tokenSeparators: [',', ' '],
    minimumInputLength: 0,
	//maximumResultsForSearch: 20,
	searchType: "contains",
	language: {
		noResults: function() {	 names=$this[0].id.split('_'); return 'No matches found, please select different '+names[0]+' characteristics.'; },
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
                q: names[0],
				list: names[1],
				keys: params.term,
			}
			
			if(window[names[0]+"_"+names[1]])
			queryParameters=$.extend(queryParameters, window[names[0]+"_"+names[1]])
			return queryParameters;
        },
        processResults: function (data) {
            return { 
                results: $.map(data, function (item) {
					return {
						id: properid(item, $idtype),
                        text: item.model ,
						prop: extrainfo(item,names[0]+"_"+names[1]),
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
		case "GPU_model":
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
	//console.log(id);
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