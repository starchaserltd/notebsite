//FUNCTION TO SYNC INPUT BUDGET BOX WITH SLIDER 
function sliderrangeadv(old) 
{
	var old=currency_val[old.oldvalue];
		
	if(old === undefined)
	{	
		old=basevalueoldadv;
	}
	var t = parseFloat(currency_val[$('#currencyadv').val()]);
	var x = Math.round($('#bdgminadv').val());
	var y = Math.round($('#bdgmaxadv').val());
	y=Math.round(y/old*t);
	x=Math.round(x/old*t);

	minbadv=Math.round(minbudgetnomenadv*t); maxbadv=Math.round(maxbudgetnomenadv*t);
	document.getElementById('budgetadv').noUiSlider.updateOptions({
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
	
	document.getElementById('budgetadv').noUiSlider.set([roundlimitadv(x), roundlimitadv(y)]);
	$('#bdgminadv').val(roundlimitadv(x));
	$('#bdgmaxadv').val(roundlimitadv(y));
}			

//CREATE CPU DATE SLIDER
if(document.getElementById('launchdate').noUiSlider===undefined||document.getElementById('launchdate').noUiSlider===null)
{	
	noUiSlider.create(document.getElementById('launchdate'), {
		start: [cpumindateset, cpumaxdateset],
		connect: true,
		step: 1,
		direction: 'ltr',
		format: { to: function(value){ return parseInt(value); }, from: function(value){ return parseInt(value); } },
		range: {
			'min': [cpumindate],
			'max': [cpumaxdate]		
		}
	});
}

//SET CPU DATE SLIDER TEXT UPDATE FUNCTIONS
document.getElementById('launchdate').noUiSlider.on('update', function( values, handle ) 
{
	if (typeof values[0] === 'string' || values[0] instanceof String)
	{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

	if (typeof values[1] === 'string' || values[1] instanceof String)
	{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
							
	if(handle==0) {	document.getElementById('launchdatemin').value=left; filtersearch('launchdatemin',left,0); }
	if(handle==1) {	document.getElementById('launchdatemax').value=right; filtersearch('launchdatemax',right,0); }
	document.getElementById('launchdateval').innerHTML=left+" - "+right;
});

//CREATE CPU CORE SLIDER
if(document.getElementById('nrcores').noUiSlider===undefined)
{					
	noUiSlider.create(document.getElementById('nrcores'), {
		start: [cpucoreminset, cpucoremaxset],
		connect: true,
		step: 2,
		direction: 'ltr',
		format: { to: function(value){ return parseInt(value); }, from: function(value){ return parseInt(value); } },
		range: {
			'min': [cpumincore],
			'max': [cpumaxcore]		
		}
	});
}

//SET CPU CORE SLIDER TEXT UPDATE FUNCTIONS
document.getElementById('nrcores').noUiSlider.on('update', function( values, handle ) 
{
	if (typeof values[0] === 'string' || values[0] instanceof String)
	{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

	if (typeof values[1] === 'string' || values[1] instanceof String)
	{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
							
	if(handle==0) {	document.getElementById('nrcoresmin').value=left; filtersearch('nrcoresmin',left,0); }
	if(handle==1) {	document.getElementById('nrcoresmax').value=right; filtersearch('nrcoresmax',right,0); }
	document.getElementById('nrcoresval').innerHTML=left+" - "+right;
});

//CREATE CPU TDP SLIDER	
if(document.getElementById('cputdp').noUiSlider===undefined)
{										
	noUiSlider.create(document.getElementById('cputdp'), {
		start: [cputdpminset, cputdpmaxset],
		connect: true,
		//step: 1,
		direction: 'ltr',
		format: { to: function(value){ return parseFloat(parseFloat(value).toFixed(1)); }, from: function(value){ return parseFloat(parseFloat(value).toFixed(1)); } },
		range: {
			'min': [cputdpmin,0.5],
			'25%': [10,1],
			'50%': [35,2],
			'70%': [60,5],
			'max': [cputdpmax,5]		
		}
	});
}

//SET CPU TDP SLIDER TEXT UPDATE FUNCTIONS
document.getElementById('cputdp').noUiSlider.on('update', function( values, handle )
{
	
	if (typeof values[0] === 'string' || values[0] instanceof String)
	{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

	if (typeof values[1] === 'string' || values[1] instanceof String)
	{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
							
	if(handle==0) {	document.getElementById('cputdpmin').value=left; filtersearch('cputdpmin',left,0); }
	if(handle==1) {	document.getElementById('cputdpmax').value=right; filtersearch('cputdpmax',right,0); }
	document.getElementById('cputdpval').innerHTML=left+" - "+right;
});

//CREATE CPU FREQ SLIDER
if(document.getElementById('cpufreq').noUiSlider===undefined)
{										
	noUiSlider.create(document.getElementById('cpufreq'), {
		start: [cpufreqminset, cpufreqmaxset],
		connect: true,
		step: 0.1,
		direction: 'ltr',
		format: { to: function(value){ return parseFloat(parseFloat(value).toFixed(1)); }, from: function(value){ return parseFloat(parseFloat(value).toFixed(1)); } },
		range: {
			'min': [cpufreqmin],
			'max': [cpufreqmax]		
		}
	});
}

//SET CPU FREQ SLIDER TEXT UPDATE FUNCTIONS
document.getElementById('cpufreq').noUiSlider.on('update', function( values, handle )
{
	if (typeof values[0] === 'string' || values[0] instanceof String)
	{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

	if (typeof values[1] === 'string' || values[1] instanceof String)
	{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
							
	if(handle==0) {	document.getElementById('cpufreqmin').value=left; filtersearch('cpufreqmin',left,0); }
	if(handle==1) {	document.getElementById('cpufreqmax').value=right; filtersearch('cpufreqmax',right,0); }
	document.getElementById('cpufreqval').innerHTML=left+" - "+right;
});

//CREATE TECH CPU SLIDER	
if(document.getElementById('cputech').noUiSlider===undefined)
{											
	noUiSlider.create(document.getElementById('cputech'), {
		start: [cputechminset, cputechmaxset],
		connect: true,
		step: 1,
		direction: 'ltr',
		format: { to: function(value){ return parseInt(value); }, from: function(value){ return parseInt(value); } },
		range: listrange(list_cputech)
	});
}

//SET CPU TECH SLIDER TEXT UPDATE FUNCTIONS
document.getElementById('cputech').noUiSlider.on('update', function( values, handle )
{
	if (typeof values[0] === 'string' || values[0] instanceof String)
	{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

	if (typeof values[1] === 'string' || values[1] instanceof String)
	{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
							
	if(handle==0) {	document.getElementById('cputechmin').value=left; filtersearch('cputechmin',left,0); }
	if(handle==1) {	document.getElementById('cputechmax').value=right; filtersearch('cputechmax',right,0); }
	document.getElementById('cputechval').innerHTML=left+" - "+right;
});

//CREATE GPU MEM SLIDER
if(document.getElementById('gpumem').noUiSlider===undefined)
{				
	noUiSlider.create(document.getElementById('gpumem'), {
		start: [gpumemminset, gpumemmaxset],
		connect: true,
		step: 1,
		direction: 'ltr',
		format: { to: function(value){ return parseInt(value); }, from: function(value){ return parseInt(value); } },
		range: listrange(list_gpumem)
	});
}

//SET GPU MEM SLIDER TEXT UPDATE FUNCTIONS
document.getElementById('gpumem').noUiSlider.on('update', function( values, handle )
{
	if (typeof values[0] === 'string' || values[0] instanceof String)
	{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

	if (typeof values[1] === 'string' || values[1] instanceof String)
	{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
							
	if(handle==0) {	document.getElementById('gpumemmin').value=left;  }
	if(handle==1) {	document.getElementById('gpumemmax').value=right; }
	document.getElementById('gpumemval').innerHTML=left+" - "+right+" MB";
});				

document.getElementById('gpumem').setAttribute('disabled', true);

//CREATE GPU BUS SLIDER
if(document.getElementById('gpubus').noUiSlider===undefined)
{			
	noUiSlider.create(document.getElementById('gpubus'), {
		start: [gpumembusminset, gpumembusmaxset],
		connect: true,
		step: gpumembusmin,
		direction: 'ltr',
		format: { to: function(value){ return parseInt(value); }, from: function(value){ return parseInt(value); } },
		range: listrange(list_gpumembus)
	});
}

//SET GPU BUS SLIDER TEXT UPDATE FUNCTIONS
document.getElementById('gpubus').noUiSlider.on('update', function( values, handle )
{
	if (typeof values[0] === 'string' || values[0] instanceof String)
	{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

	if (typeof values[1] === 'string' || values[1] instanceof String)
	{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
							
	if(handle==0) {	document.getElementById('gpubusmin').value=left;  }
	if(handle==1) {	document.getElementById('gpubusmax').value=right; }
	document.getElementById('gpubusval').innerHTML=left+" - "+right+" bit";
});				

document.getElementById('gpubus').setAttribute('disabled', true);

//CREATE GPU BUS SLIDER
if(document.getElementById('gpupower').noUiSlider===undefined)
{				
	noUiSlider.create(document.getElementById('gpupower'), {
		start: [gpupowerminset, gpupowermaxset],
		connect: true,
		step: 2,
		direction: 'ltr',
		format: { to: function(value){ return parseInt(value); }, from: function(value){ return parseInt(value); } },
		range: {
			'min': [gpupowermin,1],
			'30%': [30,2],
			'60%': [55,5],
			'max': [gpupowermax]		
			}
	});
}

//SET GPU BUS SLIDER TEXT UPDATE FUNCTIONS
document.getElementById('gpupower').noUiSlider.on('update', function( values, handle )
{
	if (typeof values[0] === 'string' || values[0] instanceof String)
	{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

	if (typeof values[1] === 'string' || values[1] instanceof String)
	{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
							
	if(handle==0) {	document.getElementById('gpupowermin').value=left;  }
	if(handle==1) {	document.getElementById('gpupowermax').value=right; }
	document.getElementById('gpupowerval').innerHTML=left+" - "+right+" W";
});				

document.getElementById('gpupower').setAttribute('disabled', true);	

//CREATE GPU DATE SLIDER	
if(document.getElementById('gpulaunchdate').noUiSlider===undefined)
{						
	noUiSlider.create(document.getElementById('gpulaunchdate'), {
		start: [gpumindateset, gpumaxdateset],
		connect: true,
		step: 1,
		direction: 'ltr',
		format: { to: function(value){ return parseInt(value); }, from: function(value){ return parseInt(value); } },
		range: {
			'min': [gpumindate],
			'max': [gpumaxdate]		
		}
	});
}

//SET GPU DATE SLIDER TEXT UPDATE FUNCTIONS
document.getElementById('gpulaunchdate').noUiSlider.on('update', function( values, handle ) 
{
	if (typeof values[0] === 'string' || values[0] instanceof String)
	{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

	if (typeof values[1] === 'string' || values[1] instanceof String)
	{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }

	if(handle==0) {	document.getElementById('gpulaunchdatemin').value=left; filtersearch('gpulaunchdatemin',left,0); } 
	if(handle==1) {	document.getElementById('gpulaunchdatemax').value=right; filtersearch('gpulaunchdatemax',right,0); }
	document.getElementById('gpulaunchdateval').innerHTML=left+" - "+right;
});		

document.getElementById('gpulaunchdate').setAttribute('disabled', true);	


//CREATE DISPLAY SLIDER	
if(document.getElementById('display').noUiSlider===undefined)
{					
	noUiSlider.create(document.getElementById('display'), {
		start: [displaysizeminset, displaysizemaxset],
		connect: true,
		step: 0.1,
		direction: 'ltr',
		format: { to: function(value){ return parseFloat(parseFloat(value).toFixed(1)); }, from: function(value){ return parseFloat(parseFloat(value).toFixed(1)); } },
		range: listrange(list_displaysize)
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

//CREATE VERTICAL RES DISPLAY SLIDER
if(document.getElementById('verres').noUiSlider===undefined)
{				
	noUiSlider.create(document.getElementById('verres'), {
		start: [displayvresminset, displayvresmaxset],
		connect: true,
		step: 10,
		direction: 'ltr',
		format: { to: function(value){ return parseFloat(parseFloat(value).toFixed(1)); }, from: function(value){ return parseFloat(parseFloat(value).toFixed(1)); } },
		range: listrange(list_verres)
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


//CREATE CAPACITY SLIDER
if(document.getElementById('capacity').noUiSlider===undefined)
{					
	noUiSlider.create(document.getElementById('capacity'), {
		start: [totalcapminset, totalcapmaxset],
		connect: true,
		step: 1,
		direction: 'ltr',
		format: { to: function(value){ return parseInt(value); }, from: function(value){ return parseInt(value); } },
		range: listrange(list_hddsize)
	});
}

//SET CAPACITY SLIDER TEXT UPDATE FUNCTIONS
document.getElementById('capacity').noUiSlider.on('update', function( values, handle )
{
	if (typeof values[0] === 'string' || values[0] instanceof String)
	{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

	if (typeof values[1] === 'string' || values[1] instanceof String)
	{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
	
	if(handle==0) {	document.getElementById('capacitymin').value=left; }
	if(handle==1) {	document.getElementById('capacitymax').value=right;  }
	document.getElementById('capacityval').innerHTML=left+" - "+right+" GB";
});

//CREATE MEM CAP SLIDER
if(document.getElementById('ram').noUiSlider===undefined)
{				
	noUiSlider.create(document.getElementById('ram'), {
		start: [memcapminset, memcapmaxset],
		connect: true,
		step: 1,
		direction: 'ltr',
		format: { to: function(value){ return parseInt(value); }, from: function(value){ return parseInt(value); } },
		range: listrange(list_memcap)
	});
}

//SET MEM CAP SLIDER TEXT UPDATE FUNCTIONS
document.getElementById('ram').noUiSlider.on('update', function( values, handle )
{
	if (typeof values[0] === 'string' || values[0] instanceof String)
	{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

	if (typeof values[1] === 'string' || values[1] instanceof String)
	{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
							
	if(handle==0) {	document.getElementById('rammin').value=left;  }
	if(handle==1) {	document.getElementById('rammax').value=right;  }
	document.getElementById('ramval').innerHTML=left+" - "+right+ " GB";
});
						
//CREATE MEM SPEED SLIDER
if(document.getElementById('freq').noUiSlider===undefined)
{					
	noUiSlider.create(document.getElementById('freq'), {
		start: [memfreqminset, memfreqmaxset],
		connect: true,
		step: 1,
		direction: 'ltr',
		format: { to: function(value){ return parseInt(value); }, from: function(value){ return parseInt(value); } },
		range: listrange(list_memfreq)
	});
}

//SET MEM SPEED SLIDER TEXT UPDATE FUNCTIONS
document.getElementById('freq').noUiSlider.on('update', function( values, handle )
{
	if (typeof values[0] === 'string' || values[0] instanceof String)
	{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

	if (typeof values[1] === 'string' || values[1] instanceof String)
	{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
							
	if(handle==0) {	document.getElementById('freqmin').value=left;  }
	if(handle==1) {	document.getElementById('freqmax').value=right; }
	document.getElementById('freqval').innerHTML=left+" - "+right+" Mhz";
});

//CREATE BATTERY SLIDER
if(document.getElementById('batlife').noUiSlider===undefined)
{				
	noUiSlider.create(document.getElementById('batlife'), {
		start: [batlifeminset, batlifemaxset],
		connect: true,
		step: 0.1,
		direction: 'ltr',
		format: { to: function(value){ return parseFloat(parseFloat(value).toFixed(1)); }, from: function(value){ return parseFloat(parseFloat(value).toFixed(1)); } },
		range: {
			'min': [batlifemin],
			'max': [batlifemax]		
			}
	});
}

//SET BATTERY SLIDER TEXT UPDATE FUNCTIONS
document.getElementById('batlife').noUiSlider.on('update', function( values, handle )
{
	if (typeof values[0] === 'string' || values[0] instanceof String)
	{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }
	
	if (typeof values[1] === 'string' || values[1] instanceof String)
	{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
							
	if(handle==0) {	document.getElementById('batlifemin').value=left;  }
	if(handle==1) {	document.getElementById('batlifemax').value=right; }
	document.getElementById('batlifeval').innerHTML=left+" - "+right+" h";
});

//CREATE ACUM CAP SLIDER
if(document.getElementById('acumcap').noUiSlider===undefined)
{					
	noUiSlider.create(document.getElementById('acumcap'), {
		start: [acumcapminset, acumcapmaxset],
		connect: true,
		step: 1,
		direction: 'ltr',
		format: { to: function(value){ return parseInt(value); }, from: function(value){ return parseInt(value); } },
		range: {
				'min': [acumcapmin],
				'max': [acumcapmax]		
			}
	});
}

//SET ACUM CAP SLIDER TEXT UPDATE FUNCTIONS
document.getElementById('acumcap').noUiSlider.on('update', function( values, handle )
{
	if (typeof values[0] === 'string' || values[0] instanceof String)
	{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

	if (typeof values[1] === 'string' || values[1] instanceof String)
	{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
							
	if(handle==0) {	document.getElementById('acumcapmin').value=left;  }
	if(handle==1) {	document.getElementById('acumcapmax').value=right; }
	document.getElementById('acumcapval').innerHTML=left+" - "+right+" Whr";
});

//CREATE WEIGHT SLIDER
if(document.getElementById('weight').noUiSlider===undefined)
{			
	noUiSlider.create(document.getElementById('weight'), {
		start: [chassisweightminset, chassisweightmaxset],
		connect: true,
		step: 0.1,
		direction: 'ltr',
		format: { to: function(value){ return parseFloat(parseFloat(value).toFixed(1)); }, from: function(value){ return parseFloat(parseFloat(value).toFixed(1)); } },
		range: {
				'min': [chassisweightmin],
				'max': [chassisweightmax]		
			}
	});
}

//SET WEIGHT SLIDER TEXT UPDATE FUNCTIONS
document.getElementById('weight').noUiSlider.on('update', function( values, handle )
{
	if (typeof values[0] === 'string' || values[0] instanceof String)
	{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

	if (typeof values[1] === 'string' || values[1] instanceof String)
	{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
							
	if(handle==0) {	document.getElementById('weightmin').value=left;  }
	if(handle==1) {	document.getElementById('weightmax').value=right; }
	document.getElementById('weightval').innerHTML=(left.toFixed(2)+" - "+right.toFixed(2)+ " (kg) / "+(left*2.2046226218).toFixed(2)+ " - "+ (right*2.2046226218).toFixed(2)+ " (lb)");
});				 

//CREATE THICKNESS SLIDER
if(document.getElementById('thickness').noUiSlider===undefined)
{				
	noUiSlider.create(document.getElementById('thickness'), {
		start: [chassisthicminset, chassisthicmaxset],
		connect: true,
		step: 0.1,
		direction: 'ltr',
		format: { to: function(value){ return parseFloat(parseFloat(value).toFixed(1)); }, from: function(value){ return parseFloat(parseFloat(value).toFixed(1)); } },							
		range: {
				'min': [chassisthicmin],
				'max': [chassisthicmax]		
			}
	});
}

//SET THICKNESS SLIDER TEXT UPDATE FUNCTIONS
document.getElementById('thickness').noUiSlider.on('update', function( values, handle )
{
	if (typeof values[0] === 'string' || values[0] instanceof String)
	{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

	if (typeof values[1] === 'string' || values[1] instanceof String)
	{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
							
	if(handle==0) {	document.getElementById('thicmin').value=left;  }
	if(handle==1) {	document.getElementById('thicmax').value=right; }
	document.getElementById('thicval').innerHTML=(left/10).toFixed(2)+" - "+(right/10).toFixed(2)+" (cm) / "+(left/10*0.393701).toFixed(2)+" - "+(right/10*0.393701).toFixed(2)+" (inch)";
});				 

//CREATE WIDTH SLIDER
if(document.getElementById('width').noUiSlider===undefined)
{					
	noUiSlider.create(document.getElementById('width'), {
		start: [chassiswidthminset, chassiswidthmaxset],
		connect: true,
		step: 0.1,
		direction: 'ltr',
		format: { to: function(value){ return parseFloat(parseFloat(value).toFixed(1)); }, from: function(value){ return parseFloat(parseFloat(value).toFixed(1)); } },
		range: {
				'min': [chassiswidthmin],
				'max': [chassiswidthmax]		
			}
	});
}

//SET WIDTH SLIDER TEXT UPDATE FUNCTIONS
document.getElementById('width').noUiSlider.on('update', function( values, handle )
{
	if (typeof values[0] === 'string' || values[0] instanceof String)
	{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

	if (typeof values[1] === 'string' || values[1] instanceof String)
	{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
							
	if(handle==0) {	document.getElementById('widthmin').value=left;  }
	if(handle==1) {	document.getElementById('widthmax').value=right; }
	document.getElementById('widthval').innerHTML=(left/10).toFixed(2)+" - "+(right/10).toFixed(2)+" (cm) / "+(left/10*0.393701).toFixed(2)+" - "+(right/10*0.393701).toFixed(2)+" (inch)";
});				 

//CREATE DEPTH SLIDER
if(document.getElementById('depth').noUiSlider===undefined)
{					
	noUiSlider.create(document.getElementById('depth'), {
		start: [chassisdepthminset, chassisdepthmaxset],
		connect: true,
		step: 0.1,
		direction: 'ltr',
		format: { to: function(value){ return parseFloat(parseFloat(value).toFixed(1)); }, from: function(value){ return parseFloat(parseFloat(value).toFixed(1)); } },
		range: {
			'min': [chassisdepthmin],
			'max': [chassisdepthmax]
		}		
	});
}

//SET DEPTH SLIDER TEXT UPDATE FUNCTIONS
document.getElementById('depth').noUiSlider.on('update', function( values, handle )
{
	if (typeof values[0] === 'string' || values[0] instanceof String)
	{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

	if (typeof values[1] === 'string' || values[1] instanceof String)
	{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
							
	if(handle==0) {	document.getElementById('depthmin').value=left;  }
	if(handle==1) {	document.getElementById('depthmax').value=right; }
	document.getElementById('depthval').innerHTML=(left/10).toFixed(2)+" - "+(right/10).toFixed(2)+" (cm) / "+(left/10*0.393701).toFixed(2)+" - "+(right/10*0.393701).toFixed(2)+" (inch)";
});				 

//CREATE WEBCAM SLIDER
if(document.getElementById('web').noUiSlider===undefined)
{
	noUiSlider.create(document.getElementById('web'), {
		start: [chassiswebminset, chassiswebmaxset],
		connect: true,
		step: 0.1,
		direction: 'ltr',
		format: { to: function(value){ return parseFloat(value); }, from: function(value){ return parseFloat(value); } },
		range: listrange(list_chassisweb)
	});
}

//SET WEBCAM SPEED TEXT UPDATE FUNCTIONS
document.getElementById('web').noUiSlider.on('update', function( values, handle )
{
	if (typeof values[0] === 'string' || values[0] instanceof String)
	{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

	if (typeof values[1] === 'string' || values[1] instanceof String)
	{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
							
	if(handle==0) {	document.getElementById('webmin').value=left;  }
	if(handle==1) {	document.getElementById('webmax').value=right; }
	document.getElementById('webval').innerHTML=left+" - "+right+" MP";
});	
				
//CREATE WARRANTY SLIDER
if(document.getElementById('years').noUiSlider===undefined)
{
	noUiSlider.create(document.getElementById('years'), {
		start: [waryearsminset, waryearsmaxset],
		connect: true,
		step: 1,
		direction: 'ltr',
		format: { to: function(value){ return parseFloat(value); }, from: function(value){ return parseFloat(value); } },
		range: {
				'min': [waryearsmin],
				'max': [waryearsmax]		
			}
	});
}

//SET WARRANTY SLIDER TEXT UPDATE FUNCTIONS
document.getElementById('years').noUiSlider.on('update', function( values, handle )
{
	if (typeof values[0] === 'string' || values[0] instanceof String)
	{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

	if (typeof values[1] === 'string' || values[1] instanceof String)
	{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
							
	if(handle==0) {	document.getElementById('yearsmin').value=left;  }
	if(handle==1) {	document.getElementById('yearsmax').value=right; }
	document.getElementById('yearsval').innerHTML=left+" - "+right;
});				 
				

/* ************************ */
/* DOCUMENT READY FUNCTIONS */
/* ************************ */

$(document).ready(function()
{
	var t = parseFloat(currency_val[$('#currencyadv').val()]);
	var x = minbudgetset; var y = maxbudgetset; y=parseInt(y*t); x=parseInt(x*t); minbadv=parseInt(minbudgetnomenadv*t); maxbadv=parseInt(maxbudgetnomenadv*t);	rangemaxbadv=y;

	if(document.getElementById('budgetadv').noUiSlider===undefined)
	{
		noUiSlider.create(document.getElementById('budgetadv'), {
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
	document.getElementById('budgetadv').noUiSlider.on('update', function( values, handle ) {
		if (typeof values[0] === 'string' || values[0] instanceof String)
		{ var left = values[0].match(/\d+/g)[0]; } else { var left = values[0]; }

		if (typeof values[1] === 'string' || values[1] instanceof String)
		{ var right = values[0].match(/\d+/g)[0]; } else { var right = values[1]; }
		
		if(handle==0) {	document.getElementById('bdgminadv').value=left; }
		if(handle==1) {	document.getElementById('bdgmaxadv').value=right; }
	});

	$('#CPU_prod_id').multiselect(btnsearch);
							
	$('#CPU_prod_id').change(function()
	{
		var cpup=$(this).attr('id');
		var cpusel = $('#CPU_prod_id option:selected');
		var selected = [];
		$(cpusel).each(function(index, cpusel){ selected.push([$(this).val()].toString()); });
		filtersearch(cpup,selected,2);
	});

	//SETTING GPU VARIABLES
	$('#gputype2').multiselect(btnsearch);
	$('#gputype2').multiselect('disable');		
	$("#GPU_prod_id").prop("disabled", true);
	$("#GPU_model_id").prop("disabled", true);
	$("#GPU_arch_id").prop("disabled", true);
	$("#GPU_msc_id").prop("disabled", true);
	
	$("input[name=gputype]:radio").change(function(){
		var dedic=0;
		var idfiledgpu=$(this).attr('id');
		if($("input[name=gputype]:radio")[1].checked)
		{
			dedic=1;
		}
						
		if(dedic==0)
		{
			$('#gputype2').multiselect('disable');
			$('#GPU_prod_id').multiselect('disable');
			$("#GPU_model_id").prop("disabled", true);
			$("#GPU_arch_id").prop("disabled", true);
			$("#GPU_msc_id").prop("disabled", true);
			document.getElementById('gpumem').setAttribute('disabled', true);
			document.getElementById('gpubus').setAttribute('disabled', true);
			document.getElementById('gpupower').setAttribute('disabled', true);
			document.getElementById('gpulaunchdate').setAttribute('disabled', true);
		}
		else
		{
			$('#gputype2').multiselect('enable');
			$('#GPU_prod_id').multiselect('enable');
			$("#GPU_model_id").prop("disabled", false);
			$("#GPU_arch_id").prop("disabled", false);
			$("#GPU_msc_id").prop("disabled", false);
			document.getElementById('gpumem').removeAttribute('disabled', true);
			document.getElementById('gpubus').removeAttribute('disabled', true);
			document.getElementById('gpupower').removeAttribute('disabled', true);
			document.getElementById('gpulaunchdate').removeAttribute('disabled', true);
			if(jQuery.isEmptyObject($('#gputype2').val())) { $('#gputype2').val(["1","2","4"]); $('#gputype2').multiselect("refresh"); };
			
			var gpusel = $('#gputype2 option:selected'); var selected = [];
			$(gpusel).each(function(index, gpusel){ selected.push([$(this).val()].toString()); });
			filtersearch("gputype2",selected,2);
		}	
	});
	
	$('#GPU_prod_id').multiselect(btnsearch);
	
	$('#GPU_prod_id').change(function(){
		var gpup=$(this).attr('id');
		var gpusel = $('#GPU_prod_id option:selected');
		var selected = [];
		$(gpusel).each(function(index, gpusel){ selected.push([$(this).val()].toString()); });
		filtersearch(gpup,selected,2);
	});
	
	$('#gputype2').change(function(){
		var idgpu=$(this).attr('id');
		var gpusel = $('#gputype2 option:selected');
		var selected = [];
		$(gpusel).each(function(index, gpusel){ selected.push(parseInt([$(this).val()].toString())); });
		filtersearch(idgpu,selected,2);
		
		gpu_model_selected=$('#GPU_model_id').select2('data');
		for (var key in gpu_model_selected)
		{
			var obj=gpu_model_selected[key];
			if(selected.indexOf(obj["prop"])<0)
			{
				$('#GPU_model_id [value='+'"'+obj["text"]+'"'+']')[0].remove();
			}
		}
	});
	
	$("input[name=gputype]:radio").change();
	$('#DISPLAY_ratio_id').multiselect(btnsearch);
							
	$('#DISPLAY_ratio_id').change(function(){
		var iddisp=$(this).attr('id');
		var dispsel = $('#DISPLAY_ratio_id option:selected');
		var selected = [];
		$(dispsel).each(function(index, dispsel){ selected.push([$(this).val()].toString()); });
		filtersearch(iddisp,selected,2);
	});
		
	$('#surface').multiselect(btnsearch);
	$('#rpm').multiselect(btnsearch);
	if(rpm_enable){ $('#rpm').multiselect('enable'); }else{$('#rpm').multiselect('disable'); }
	$('#typehdd').multiselect(btnsearch);
	
	$('#typehdd').change(function(){
		var hdd=0;
		var iddisp=$(this).attr('id');
		var dispsel = $('#typehdd option:selected');
		$(dispsel).each(function(index, dispsel){
			if("HDD"==[$(this).val()].toString())
				{
					hdd=1;
				}
			});
		
		if(hdd==0)
		{
			$('#rpm').multiselect('select',"Any");
			$('#rpm').multiselect('disable');
		}
		else
		{
			$('#rpm').multiselect('enable');
		}
	});
	
	$('#nrhdd').multiselect(btnsearch);
	$('#mdbslots').multiselect(btnsearch);
	$('#mdbwwan').multiselect(btnsearch);
	$('#memtype').multiselect(btnsearch);
	$('#material').multiselect(btnsearch);
	$('#wnetspeed').multiselect(btnsearch);
	$('#oddtype').multiselect(btnsearch);
	$('#opsist').multiselect(btnsearch);
	
	actbtn("SEARCH");
	document.title = 'Noteb - Search';
	$('meta[name=description]').attr('content', "Custom laptop search.");
});

function setrecommended()
{
	var t = parseFloat(currency_val[$('#currencyadv').val()]);
	var x = Math.round(495*t);	var y = Math.round(1200*t);
	document.getElementById('budgetadv').noUiSlider.set([x,y]); $('#bdgminadv').val(roundlimitadv(x)); $('#bdgmaxadv').val(roundlimitadv(y));	
	document.getElementById('display').noUiSlider.set([13.1,16.1]);  document.getElementById('verres').noUiSlider.set([1080,99999]);
	var i=0; el=$('#DISPLAY_msc_id'); texttoapp='<option selected="selected">LED IPS</option><option selected="selected">LED IPS PenTile</option><option selected="selected">LED TN WVA</option><option selected="selected">OLED</option>';
	while( el.select2("val")[i]!==undefined)
	{
		switch(el.select2("val")[i])
		{
			case "LED IPS":
			{	texttoapp = texttoapp.replace('<option selected="selected">LED IPS</option>', ""); break; }
			case "LED IPS PenTile":
			{	texttoapp = texttoapp.replace('<option selected="selected">LED IPS PenTile</option>', ""); break; }
			case "LED TN WVA":
			{	texttoapp = texttoapp.replace('<option selected="selected">LED TN WVA</option>', ""); break; }
			case "OLED":
			{	texttoapp = texttoapp.replace('<option selected="selected">OLED</option>', ""); break; }
		}
		i++;
	}
	$('#DISPLAY_msc_id').append(texttoapp);
	document.getElementById('capacity').noUiSlider.set([179,99999]); $('#typehdd').multiselect('select',"SSD"); $('#nrhdd').val(1); $("#nrhdd").multiselect("refresh");
	document.getElementById('ram').noUiSlider.set([8,99999]);
	var opsist_multiselect=$('#opsist option'); var opsist_list_select=["Windows 10","macOS","Chrome OS"];
	for(var key in opsist_multiselect)
	{
		if(opsist_multiselect[key].value!=undefined&&opsist_multiselect[key].value!=""&&opsist_multiselect[key].value!=null)
		{
			for(var key_s in opsist_list_select)
			{
				if(opsist_multiselect[key].value.indexOf(opsist_list_select[key_s])>-1)
				{
					$('#opsist').multiselect('select',opsist_multiselect[key].value);
				}
			}
		}
	}
	return;
}

function warranty_2year() { if(document.getElementById('years').noUiSlider.get()[0]<2) { document.getElementById('years').noUiSlider.set([2,]); } }
function warranty_1year() { if(document.getElementById('years').noUiSlider.get()[0]==2) { document.getElementById('years').noUiSlider.set([1,]); } }

$('#Regions_name_id').on("select2:select", function(e){ 
   if(triggerchange($('#Regions_name_id'),"Europe",0))
   { warranty_2year(); }
});

$('#Regions_name_id').on("select2:unselect", function(e){ 
   if(triggerchange($('#Regions_name_id'),"Europe",0))
   {  warranty_2year(); }
   else
   {  warranty_1year(); }
});

function change_region(currency)
{
	switch(currency)
	{		
		case "EUR": { $("#Regions_name_id").empty().append('<option value="Europe">Europe</option>').val('Europe').trigger('change'); warranty_2year();  break; }
		case "GBP": { $("#Regions_name_id").empty().append('<option value="Europe">Europe</option>').val('Europe').trigger('change'); warranty_2year(); break; }
		case "USD": { $("#Regions_name_id").empty().append('<option value="United States">United States</option>').val('United States').trigger('change'); warranty_1year(); break; }
		default: { break; }
	}
}

//toggle more options for adv_search
$('.toggleHiddenButtons .glyphicon-chevron-down').click(function() { $('.hiddenOptions').toggle('slow'); $(this).toggleClass('arrowUp'); $("#CPU_socket_id").trigger("change"); });
$('.toggleHiddenButtonsGpu .glyphicon-chevron-down').click(function() { $('.hiddenOptionsGpu').toggle('slow'); $(this).toggleClass('arrowUp'); $("#GPU_arch_id,#GPU_msc_id").trigger("change"); });
$('.toggleHiddenButtonsDisplay .glyphicon-chevron-down').click(function() { $('.hiddenOptionsDisplay').toggle('slow'); $(this).toggleClass('arrowUp'); $("#DISPLAY_resol_id").trigger("change"); });
$('.toggleHiddenButtonsChassis .glyphicon-chevron-down').click(function() { $('.hiddenOptionsChassis').toggle('slow'); $(this).toggleClass('arrowUp'); });
$('.toggleHiddenButtonsStorage .glyphicon-chevron-down').click(function() { $('.hiddenOptionsStorage').toggle('slow'); $(this).toggleClass('arrowUp'); });
$('.toggleHiddenButtonsMdb .glyphicon-chevron-down').click(function() { $('.hiddenOptionsMdb').toggle('slow'); $(this).toggleClass('arrowUp'); });
$('.toggleHiddenButtonsMemory .glyphicon-chevron-down').click(function() { $('.hiddenOptionsMemory').toggle('slow'); $(this).toggleClass('arrowUp'); });
$('.toggleHiddenButtonsWirrOpt .glyphicon-chevron-down').click(function() { $('.hiddenOptionWirrOpt').toggle('slow'); $(this).toggleClass('arrowUp'); });

var nouisliders=document.getElementsByClassName('advslider');
for(var key in nouisliders){ if(nouisliders[key].noUiSlider!==undefined){ nouisliders[key].noUiSlider.on('update', function( values, handle ){presearch("#advform");});} }
pause_presearch=1; setTimeout(function(){ pause_presearch=0; },2500);

var prev_arrSelected=[];
$('#material').on('change', function(){
	var selected = $(this).find("option:selected"); var arrSelected = []; var metal_was_added=false;
	selected.each((idx, val) => { var new_el=true; for( var key in prev_arrSelected) { if(val.value==prev_arrSelected[key]){new_el=false;}} if(new_el&&val.value=="Metal"){ metal_was_added=true; } arrSelected.push(val.value); }); if(metal_was_added){ arrSelected.push("Aluminium"); arrSelected.push("Magnesium"); $('#material').val(arrSelected); $('#material').multiselect("refresh"); } prev_arrSelected=arrSelected;
});