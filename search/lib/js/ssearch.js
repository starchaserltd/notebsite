
var btnsearch={buttonClass:'btn btn-search', templates:{filterClearBtn: '<span class="input-group-btn"><button class="btn btn-search multiselect-clear-filter" type="button"><i class="glyphicon glyphicon-remove-circle"></i></button></span>'}};
var btnsearchval={buttonClass:'btn btn-search btn-searchval', templates:{filterClearBtn: '<span class="input-group-btn"><button class="btn btn-search btn-searchval multiselect-clear-filter" type="button"><i class="glyphicon glyphicon-remove-circle"></i></button></span>'}};

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


/* WHEN DOCUMENT IS READY ! */
$(document).ready(function() 
{
	$('#currency').multiselect(btnsearchval);
	$('#graphics').multiselect(btnsearch);		
	$('#type').multiselect(btnsearch);
	$('#graphics').multiselect(btnsearch);
	$('#performfocus').multiselect(btnsearch);
	$('#storage').multiselect(btnsearch);
	
	//CREATE WARRANTY SLIDER	
	noUiSlider.create(document.getElementById('waranty'), {
	start: [1, 2],
	connect: true,
	step: 1,
	direction: 'ltr',
	format: { to: function(value){ return parseInt(value); }, from: function(value){ return parseInt(value); } },
	range: {
		'min': [1],
		'max': [5]		
		}
	});

	//SET WARRANTY SLIDER TEXT UPDATE FUNCTIONS
	document.getElementById('waranty').noUiSlider.on('update', function( values, handle ) {
	
	if (typeof values[0] === 'string' || values[0] instanceof String)
	{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

	if (typeof values[1] === 'string' || values[1] instanceof String)
	{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
	
	if(handle==0) {	document.getElementById('warmin').value=left; }
	if(handle==1) {	document.getElementById('warmax').value=right; }
	document.getElementById('warval').innerHTML=left+" - "+right;
	});


	//CREATE  BUDGET SLIDER
	

	//HERE WE CALCULATE THE VARIABLES
	var t = parseFloat(currency_val[$('#currency').val()]);
	var x = minbudgetnomen*2; var y = maxbudgetnomen*0.65; y=parseInt(y*t); x=parseInt(x*t); minb=parseInt(minbudgetnomen*t); maxb=parseInt(maxbudgetnomen*t);

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
	
	$('#type').on('change', function() 
	{
		if($(this).val()=="5")
		{ document.getElementById('waranty').noUiSlider.set([1,4]); }
		
		if($(this).val()=="3")
		{ document.getElementById('waranty').noUiSlider.set([1,3]); }
	});
});


/* RECALCULATE SLIDER ON MANUAL INPUT */
	
function sliderrange(old) 
{
					
	var old=currency_val[old.oldvalue];
					
	if(old === undefined)
	{	
		old=basevalueold;
	}
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
