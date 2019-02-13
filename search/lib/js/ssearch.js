var btnsearch={buttonClass:'btn btn-search yellow', templates:{filterClearBtn: '<span class="input-group-btn"><button class="btn btn-search multiselect-clear-filter yellow" type="button"><i class="glyphicon glyphicon-remove-circle"></i></button></span>'}};
var btnsearchval={buttonClass:'btn btn-search btn-searchval yellow', templates:{filterClearBtn: '<span class="input-group-btn"><button class="btn btn-search btn-searchval multiselect-clear-filter yellow" type="button"><i class="glyphicon glyphicon-remove-circle"></i></button></span>'}};

//FIRST, DEPENDING ON THE RANGE WE DECIDE THE NUMER SIZE
function divider()
{
	rangemaxb=maxb;
	i=1;
	while(rangemaxb>1)
	{
		rangemaxb=rangemaxb/10;
		i++;
	}
	
	divide=Math.pow(10,i-4);
	if(i<=0) {divide=1;}
	return divide;
}

//SECONDLY WE ROUND THE BOUNDRIES SO THAT THE NUMBERS LOOK NICE AND ROUND
function roundlimit(val)
{

	divide=divider();
	val=parseInt(val/divide)*divide;
	if(val<=0){val=1;}
	return val;
}

//THIRDLY WE ROUND THE STEPS SO THAT THE STEPPING IS NICE AND ROUND
function roundstep(val)
{
	divide=divider();
	val=parseInt(val/divide)*divide;
	if(val<=0){val=10;}
	return val;
}

//HERE WE SET SLIDER DEPENDING ON WHAT IS IN THE INPUT BOXES
function checkmin()
{ document.getElementById('budget').noUiSlider.set([document.getElementById('bdgmin').value, null]); }

function checkmax()
{ document.getElementById('budget').noUiSlider.set([null,document.getElementById('bdgmax').value]); }

function change_label(elementid) { $(elementid).each(function() { if(this.getAttribute("data-name")!==null) { var e = $("#display_type").next().children(".btn"); e.html(e.html().replace(RegExp(this.text, "g"), this.getAttribute("data-name"))); } }); } 

/* WHEN DOCUMENT IS READY ! */
$(document).ready(function() 
{
	$('#currency').multiselect(btnsearchval);
	$('#graphics').multiselect(btnsearch);		
	$('#type').multiselect(btnsearch);
	btnsearch["buttonText"]=function(options, select) { if (options.length === 0) { return 'None selected'; } else if (options.length > 3) { return '4 selected'; } else { var labels = []; options.each(function() { if ($(this).attr('data-name') !== undefined) { labels.push($(this).attr('data-name')) } else { labels.push($(this).html()); } }); return labels.join(', ') + ''; } }
	$('#cpu_type').multiselect(btnsearch);
	$('#display_type').multiselect(btnsearch); delete btnsearch["buttonText"];
	$('#region_type').multiselect(btnsearchval);
	$('#graphics').multiselect('disable');
	
	//CREATE MEMORY SLIDER	
	noUiSlider.create(document.getElementById('s_mem'), {
		start: [8, 16],
		connect: true,
		step: 4,
		direction: 'ltr',
		format: { to: function(value){ return parseInt(value); }, from: function(value){ return parseInt(value); } },
		range: listrange([2,4,8,16,24,32])
	});

	//SET MEMORY SLIDER TEXT UPDATE FUNCTIONS
	document.getElementById('s_mem').noUiSlider.on('update', function( values, handle ) {
		if (typeof values[0] === 'string' || values[0] instanceof String)
		{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

		if (typeof values[1] === 'string' || values[1] instanceof String)
		{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
		
		if(handle==0) {	document.getElementById('s_memmin').value=left; }
		if(handle==1) {	document.getElementById('s_memmax').value=right; }
		document.getElementById('s_memval').innerHTML=left+" - "+right;
	});

	//CREATE STORAGE SLIDER	
	noUiSlider.create(document.getElementById('s_hdd'), {
		start: [180, 2048],
		connect: true,
		step: 4,
		direction: 'ltr',
		format: { to: function(value){ return parseInt(value); }, from: function(value){ return parseInt(value); } },
		range: listrange([32,64,128,180,256,512,768,1024,2048])
	});

	//SET STORAGE SLIDER TEXT UPDATE FUNCTIONS
	document.getElementById('s_hdd').noUiSlider.on('update', function( values, handle ) {
		if (typeof values[0] === 'string' || values[0] instanceof String)
		{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

		if (typeof values[1] === 'string' || values[1] instanceof String)
		{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
		
		if(handle==0) {	document.getElementById('s_hddmin').value=left; }
		if(handle==1) {	document.getElementById('s_hddmax').value=right; }
		document.getElementById('s_hddval').innerHTML=left+" - "+right;
	});
	
	//CREATE DISPLAY SLIDER	
	noUiSlider.create(document.getElementById('s_dispsize'), {
		start: [14, 16.1],
		connect: true,
		step: 4,
		direction: 'ltr',
		format: { to: function(value){ return parseFloat(value); }, from: function(value){ return parseFloat(value); } },
		range: listrange([10.1,12,13.3,13.9,14,15,15.4,15.6,16.1,17,18.1])
	});

	//SET SDISPLAY SLIDER TEXT UPDATE FUNCTIONS
	document.getElementById('s_dispsize').noUiSlider.on('update', function( values, handle ) {	
		if (typeof values[0] === 'string' || values[0] instanceof String)
		{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

		if (typeof values[1] === 'string' || values[1] instanceof String)
		{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
		
		if(handle==0) {	document.getElementById('s_dispsizemin').value=left; }
		if(handle==1) {	document.getElementById('s_dispsizemax').value=right; }
		document.getElementById('s_dispsizeval').innerHTML=left+" - "+right;
	});

	//CREATE  BUDGET SLIDER
	//HERE WE CALCULATE THE VARIABLES
	var t = parseFloat(currency_val[$('#currency').val()]);
	var x = minbudgetnomen*4; var y = minbudgetnomen*6; y=parseInt(y*t); x=parseInt(x*t); minb=parseInt(minbudgetnomen*t); maxb=parseInt(maxbudgetnomen*t);

	noUiSlider.create(document.getElementById('budget'), {
	start: [roundlimit(x), roundlimit(y)],
	connect: true,
	direction: 'ltr',
	format: { to: function(value){ return parseInt(value); }, from: function(value){ return parseInt(value); } },
	range: {
		'min': [ roundlimit(minb),roundstep((maxb-minb)*0.0015)],
		'25%': [ roundlimit(minb+(maxb-minb)*0.145),  roundstep((maxb-minb)*0.0071)],
		'50%': [ roundlimit(minb+(maxb-minb)*0.285),  roundstep((maxb-minb)*0.01425) ],
		'70%': [ roundlimit(minb+(maxb-minb)*0.571),  roundstep((maxb-minb)*0.0285) ],
		'80%': [ roundlimit(minb+(maxb-minb)*0.8),  roundstep((maxb-minb)*0.04) ],
		'90%': [ roundlimit(minb+(maxb-minb)*0.9), roundstep((maxb-minb)*0.045) ],		
		'max': [ roundlimit(maxb),roundstep((maxb-minb)*0.055)]
		}
	});


	// HERE WE SET VALUES FOR INPUT BOX WHENT SLIDER IS MOVED
	document.getElementById('budget').noUiSlider.on('update', function( values, handle ) {
		if (typeof values[0] === 'string' || values[0] instanceof String)
		{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

		if (typeof values[1] === 'string' || values[1] instanceof String)
		{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
		
		if(handle==0) {	document.getElementById('bdgmin').value=left; }
		if(handle==1) {	document.getElementById('bdgmax').value=right; }
	});
	
	if($('#type').val()=="99"){ $('#graphics').multiselect('enable'); }
	else { $('#graphics').multiselect('disable'); }
	
	$('#type').on('change', function() 
	{
		if($(this).val()=="99" || $(this).val()=="4" || $(this).val()=="5")
		{ $('#graphics').multiselect('enable'); }
		else
		{ $('#graphics').multiselect('disable'); }
	});
	
	var USloc = [ {label: "$", value: "USD"} ];
    var EUloc = [ {label: "€", value: "EUR"}, {label: "£", value: "GBP"} ];
	var thislist=$("#currency"); var thislist2=document.getElementById("currency");
	switch($('#region_type').val())
	{
		case "1": { $("#currency").multiselect('dataprovider',USloc); sliderrange(thislist2); thislist2.oldvalue=thislist2.value; break; }
		case "2": { $("#currency").multiselect('dataprovider',EUloc); sliderrange(thislist2); thislist2.oldvalue=thislist2.value; break; }
		default: { $("#currency").multiselect('dataprovider',USloc); sliderrange(thislist2); thislist2.oldvalue=thislist2.value; break; }
	}
	
	$('#region_type').on('change', function() 
	{
		switch($(this).val())
		{
			case "1": { thislist.multiselect('dataprovider',USloc); sliderrange(thislist2); thislist2.oldvalue=thislist2.value; break; }
			case "2": { thislist.multiselect('dataprovider',EUloc); sliderrange(thislist2); thislist2.oldvalue=thislist2.value; break; }
			default: { thislist.multiselect('dataprovider',USloc); sliderrange(thislist2); thislist2.oldvalue=thislist2.value; break; }
		}
	});
});

/* RECALCULATE SLIDER ON MANUAL INPUT */
function sliderrange(old) 
{		
	var old=currency_val[old.oldvalue];					
	if(old === undefined)
	{ old=basevalueold; }
	var t = parseFloat(currency_val[$('#currency').val()]);
	var x = Math.round($('#bdgmin').val());
	var y = Math.round($('#bdgmax').val());
	y=Math.round(y/old*t);
	x=Math.round(x/old*t);

	minb=Math.round(minbudgetnomen*t); maxb=Math.round(maxbudgetnomen*t);
	document.getElementById('budget').noUiSlider.updateOptions({
	range: {
		'min': [ roundlimit(minb),roundstep((maxb-minb)*0.0015)],
		'25%': [ roundlimit(minb+(maxb-minb)*0.145),  roundstep((maxb-minb)*0.0071)],
		'50%': [ roundlimit(minb+(maxb-minb)*0.285),  roundstep((maxb-minb)*0.01425) ],
		'70%': [ roundlimit(minb+(maxb-minb)*0.571),  roundstep((maxb-minb)*0.0285) ],
		'80%': [ roundlimit(minb+(maxb-minb)*0.8),  roundstep((maxb-minb)*0.04) ],
		'90%': [ roundlimit(minb+(maxb-minb)*0.9), roundstep((maxb-minb)*0.045) ],		
		'max': [ roundlimit(maxb),roundstep((maxb-minb)*0.055)]
		}
		
	});
	
	document.getElementById('budget').noUiSlider.set([roundlimit(x), roundlimit(y)]);
	$('#bdgmin').val(roundlimit(x));
	$('#bdgmax').val(roundlimit(y));
}

$('#s_prod_id').select2({
	tags: false, multiple: true, maximumSelectionLength: 8, minimumInputLength: 1,
	language: {
		noResults: function(term) {
			return "Type something...";
				}
            },
		ajax: { quietMillis: 100, cache: false, dataType: "json", type: "POST", url: "search/lib/func/list.php",
		data: function (params) {
			$idtype=2;
            var queryParameters = {
                q: "Producer",
				list: "prod",
				keys: params.term,
			}
			queryParameters=$.extend(queryParameters, "Producer_prod")
			return queryParameters;
        },
        processResults: function (data) {
            return { 
                results: $.map(data, function (item) {
					return {
						id: item.model,
                        text: item.model,
                    }
				})
            };
        }
    }
 })
 
//Function for form submissions left menu   
$("#s_search_btn").on("mousedown",function(e) {
	scrolltoid('content');
	$("#howToUse").css('display', 'none');
	$('#loadingNB').show();
	trigger = 0; var addref="?sort_by="+global_sort_search; if(ref!=null&&ref!="") { addref=addref+"&ref="+ref; }
	$.get('search/search.php'+addref, $("#s_search").serialize(), function(data) {
		url = "search/search.php" + "?" + $("#s_search").serialize();
		if(url.indexOf("sort_by=")<0){ url=url+"&sort_by="+global_sort_search; }
		if(url.indexOf("ref=")<0){ if(ref!=null&&ref!="") { url=url+"&ref="+ref; } } currentpage = url;
		if ($('#content').html(data)) { $('#loadingNB').hide(); }
		history.pushState({}, 'NoteBrother', "?" + url);
	});
});