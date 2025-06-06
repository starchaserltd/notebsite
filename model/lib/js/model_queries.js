var gocomp=1; var old_rate=""; var old_price=""; var old_bat=""; var best_low_array=["lowest_price","best_value","best_performance"];
var cpu = {}; var cpu_price_old=0; var cpu_price_new=0; var cpu_err_new=0; var cpu_err_old=0; var cpu_rate_new=0; var cpu_rate_old=0; var cpu_gpu=0; var cpu_bat_new=0; var cpu_bat_old=0; cpu["clocks"]=""; var success=false;

var gpu_pixel_offset=0; var maxwidth=0; var gpu_select_open=1;
function gpu_right_align()
{
	if ($(window).width() >= 425)
	{ var maxtext=22;  maxwidth=170; var borderpx=0; }
	else
	{ var maxtext=16;  maxwidth=128; var borderpx=1; }
	
	var borderpx=1;
	var el=$('#GPU option:selected'); var el_text=el.text();

	if(el_text.length>0)
	{
		if(el_text.indexOf("Integrated")>=0)
		{
			$('#GPU').css({'transform': 'translateX(0)', 'width': maxwidth+'px'}); gpu_pixel_offset=0;
			$('.gpuhddd form').css('border-left', '0');
		}
		else
		{
			gpu_pixel_offset=parseInt(char_indent(el_text,maxtext)); if(gpu_pixel_offset<=0){ borderpx=0; }
			$('#GPU').css({'transform': 'translateX(-'+gpu_pixel_offset+'px)', 'width': (maxwidth+gpu_pixel_offset)+'px'});
			$('.gpuhddd form').css('border-left', borderpx+'px solid');
		}	
	} 
}

function char_indent(str,maxlength)
{
	x=str.split(' '); var short_length=0; var fudge=1.05;
	for(var i=x.length-1;i>=0;i--)
	{
		short_length+=x[i].length+1;
		if(short_length>=maxlength){ short_length-=(x[i].length+1); }
	}

	var el=document.getElementById("hiddenDiv");
	el.style.display="inline"; str="T"+str; el.innerHTML=str.substr(0,str.length-short_length);
	var isSafari=window.safari!==undefined; if(isSafari){ var zoom=(window.outerWidth-8)/window.innerWidth; if(zoom>=0.92&&zoom<=1.1){fudge=0.85;}}
	var pixels=(el.offsetWidth)*fudge; el.style.display="none";
	return pixels;
}

function showCPU(str) 
{
	if (str === "") { cpu = {}; return; }
	else 
	{
		if (window.XMLHttpRequest) 
		{ var	xmlhttp = new XMLHttpRequest(); }
	
		xmlhttp.onreadystatechange = function() 
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200 && document.getElementById('cpu_title')!=null)
			{
				cpu = JSON.parse(xmlhttp.responseText);
				document.getElementById('cpu_title').innerHTML = cpu["prod"]+" "+cpu["model"];
				document.getElementById('cpu_ldate').innerHTML = cpu["ldate"];
				document.getElementById('cpu_tdp').innerHTML = cpu["tdp"];
				document.getElementById('cpu_socket').innerHTML = cpu["socket"];
				document.getElementById('cpu_tech').innerHTML = cpu["tech"];
				document.getElementById('cpu_cache').innerHTML = cpu["cache"];
				document.getElementById('cpu_speed').innerHTML = cpu["clocks"];
				document.getElementById('cpu_turbo').innerHTML = cpu["maxtf"];
				document.getElementById('cpu_cores').innerHTML = cpu["cores"];
				document.getElementById('cpu_misc').innerHTML = cpumisc(cpu["msc"]);
				if (document.getElementById('progress-cpu') != null ){ PROGRESSBAR.update({target:"#progress-cpu",value:cpu["rating"]}); }
				document.getElementById('cpu_class').innerHTML = cpu["class"];
				
				cpu_rate_old = cpu_rate_new;
				cpu_rate_new = cpu["confrate"];
				config_rate = config_rate-cpu_rate_old+cpu_rate_new;
				update_model_rating(config_rate);
				
				cpu_bat_old = cpu_bat_new;
				cpu_bat_new = cpu["bat"];
				config_batlife=config_batlife-cpu_bat_old+cpu_bat_new;

				document.getElementById('bat_life1').innerHTML=hourminutes((parseFloat(acum["cap"])/config_batlife)*0.96);
				document.getElementById('bat_life2').innerHTML=hourminutes((parseFloat(acum["cap"])/config_batlife)*1.03);
				document.getElementById('dLabel').setAttribute("data-idcpu",str);
				cpu_gpu=parseInt(cpu["gpu"]);

				if(((typeof $("#GPU").val()==="string" && $("#GPU").val()==-1)||gpu_noselect===-1)&&prevent_cpu_gpu_load<1)
				{
					if(cpu_gpu)
					{ showGPU(cpu_gpu);}
					else
					{ showGPU(gpudet); }
				}
				else
				{ if(!(prevent_cpu_gpu_load<1)){ prevent_cpu_gpu_load=-1;} }
			}
		}
		xmlhttp.open("GET","model/lib/php/query/cpu.php?q="+str,true);
		xmlhttp.send(); all_requests.push(xmlhttp);
	}
}
	
var gpu = {}; var gpu_price_old=0; var gpu_price_new=0; var gpu_err_new=0; var gpu_err_old=0; var gpu_rate_new=0; var gpu_rate_old=0; var gpu_bat_old=0; var gpu_bat_new=0;
var gpu_type=4; var gpu_previous=0; 
function showGPU(str) 
{
	if(prevent_cpu_gpu_load==0){ prevent_cpu_gpu_load=1; setTimeout(function(){ prevent_cpu_gpu_load=-1; }, 750); }
	if(str == -1)
	{
		if(!cpu_gpu)
		{
			var message = "This processor does not have an integrated graphics controller, please choose a different processor first!";
			showNotification('warning', message);
			str=gpu_previous;
			if(gpu_noselect>0){ document.querySelector('#GPU [value="' + str + '"]').selected = true; gpu_right_align(); }
		}
		else { str=cpu_gpu; }
	}

	if (str === "") { gpu = {}; return; }
	else 
	{
		if (window.XMLHttpRequest) 
		{ var xmlhttp = new XMLHttpRequest(); }
		
		xmlhttp.onreadystatechange = function() 
		{
			if(xmlhttp.readyState==4 && xmlhttp.status==200 && document.getElementById('cpu_title')!=null)  
			{
				gpu = JSON.parse(xmlhttp.responseText);
				
				document.getElementById('gpu_title').innerHTML = gpu["prod"] + " " + gpu["model"];
				document.getElementById('gpu_arch').innerHTML = gpu["arch"];
				document.getElementById('gpu_tdp').innerHTML = gpu["power"];
				document.getElementById('gpu_tech').innerHTML = gpu["tech"];
				document.getElementById('gpu_speed').innerHTML = gpu["cspeed"] + " to " + gpu["bspeed"];
				document.getElementById('gpu_shaders').innerHTML = gpu["pipe"];
				
				if(gpu["typegpu"]==0)
				{ document.getElementById('gpu_misc').innerHTML = gpu["prod"]+" "+gpu["model"]+"<br/>"+gpumisc(gpu["msc"]); if(gpu_noselect>0) { var selected_gpu=document.querySelector('#GPU [value="-1"]'); if(typeof(selected_gpu)!=="undefined" && selected_gpu!=null) { selected_gpu.selected = true; } } }
				else
				{ document.getElementById('gpu_misc').innerHTML = gpumisc(gpu["msc"]); if(gpu_noselect>0){ var selected_gpu=document.querySelector('#GPU [value="'+str+'"]'); if(typeof(selected_gpu)!=="undefined" && selected_gpu!=null) { selected_gpu.selected = true; } } }
				gpu_right_align();
				document.getElementById('gpu_shadermodel').innerHTML = parseFloat(gpu["shader"]).toFixed(1);
				document.getElementById('gpu_memspeed').innerHTML = gpu["mspeed"];
				if (document.getElementById('progress-gpu') != null ){ PROGRESSBAR.update({target:"#progress-gpu",value:gpu["rating"]}); }
				document.getElementById('gpu_bus').innerHTML = gpu["mbw"];
				document.getElementById('gpu_mem').innerHTML = gpu["maxmem"]+" MB "+gpu["mtype"];
				document.getElementById('gpu_smem').innerHTML = gpu["sharem"];
				document.getElementById('gpu_class').innerHTML = gpu["class"];
				
				gpu_rate_old = gpu_rate_new;
				gpu_rate_new = gpu["confrate"];				
				config_rate = config_rate-gpu_rate_old+gpu_rate_new;
				update_model_rating(config_rate);
				gpu_bat_old = gpu_bat_new;
				gpu_bat_new = gpu["bat"];
				if(mdb["optimus"] && gpu_bat_new>3){ gpu_bat_new=3; }
				config_batlife=config_batlife-gpu_bat_old+gpu_bat_new;

				document.getElementById('bat_life1').innerHTML=hourminutes((parseFloat(acum["cap"])/config_batlife)*0.96);
				document.getElementById('bat_life2').innerHTML=hourminutes((parseFloat(acum["cap"])/config_batlife)*1.03);
				document.getElementById('dLabel').setAttribute("data-idgpu",str); 
			}
		}
		xmlhttp.open("GET","model/lib/php/query/gpu.php?q="+str,true);
		xmlhttp.send(); all_requests.push(xmlhttp);
		gpu_previous=str;
	}
}
	
var display = {}; var display_price_old=0;	var display_price_new=0; var display_err_new=0;	var display_err_old=0; var display_rate_new=0; var display_rate_old=0; var display_bat_old=0; var display_bat_new=0;
function showDISPLAY(str) 
{
	if (str === "")	{ display = {}; return; }
	else 
	{
		if (window.XMLHttpRequest) { var	xmlhttp = new XMLHttpRequest(); }

		xmlhttp.onreadystatechange = function() 
		{
			if(xmlhttp.readyState==4 && xmlhttp.status==200 && document.getElementById('cpu_title')!=null) 
			{
				display = JSON.parse(xmlhttp.responseText);
				document.getElementById('display_title').innerHTML = display["size"];
				var display_elements=['display_size','display_format','display_hres','display_vres','display_surft','display_backt','display_touch','display_msc'];
				for(var x in display_elements)
				{
					var subelement=display_elements[x].split("_");
					var subelements_by_class=document.getElementsByClassName(display_elements[x]);
					for(var nr_el in subelements_by_class)
					{ subelements_by_class[nr_el].innerHTML = display[subelement[1]]; }
				}
				
				var subelements_by_class=document.getElementsByClassName('display_msc');
				for(var nr_el in subelements_by_class)
				{
					if( parseInt(display["sRGB"]) > 0) { subelements_by_class[nr_el].innerHTML=eliminate_first_line_desc(subelements_by_class[nr_el].innerHTML)+' <span class="toolinfo" data-toolid=86 data-load="1" data-html="true" data-toggle="tooltip" data-delay='+"'"+'{"show": 600}'+"'"+' data-placement="left" data-original-title="Loading..."><span>'+ display["sRGB"] + '% sRGB</span> <i class="fa fa-question toolinfo-icon"></i></span>'; }
					if( parseInt(display["lum"]) > 0) { subelements_by_class[nr_el].innerHTML=eliminate_first_line_desc(subelements_by_class[nr_el].innerHTML)+' <span class="toolinfo" data-toolid=87 data-load="1" data-html="true" data-toggle="tooltip" data-delay='+"'"+'{"show": 600}'+"'"+' data-placement="left" data-original-title="Loading..."><span>'+ display["lum"] + ' nits</span> <i class="fa fa-question toolinfo-icon"></i></span>'; }
				}
			
				if (document.getElementById('progress-display-desktop') != null &&  document.getElementById('progress-display-mobile') != null){ PROGRESSBAR.update({target:".progress-display",value:display["rating"]}); }
				display_rate_old = display_rate_new;
				display_rate_new = display["confrate"];
				config_rate = config_rate-display_rate_old+display_rate_new;
				update_model_rating(config_rate);
				display_bat_old = display_bat_new;
				display_bat_new = display["bat"];
				config_batlife=config_batlife-display_bat_old+display_bat_new;

				document.getElementById('bat_life1').innerHTML=hourminutes((parseFloat(acum["cap"])/config_batlife)*0.96);
				document.getElementById('bat_life2').innerHTML=hourminutes((parseFloat(acum["cap"])/config_batlife)*1.03);
				document.getElementById('dLabel').setAttribute("data-iddisplay",str);
			}
		}
		xmlhttp.open("GET","model/lib/php/query/display.php?q="+str,true);
		xmlhttp.send(); all_requests.push(xmlhttp);
	}
}
	
var hdd = {}; var hdd_price_old=0; var hdd_price_new=0; var hdd_err_new=0; var hdd_err_old=0; var hdd_rate_new=0; var hdd_rate_old=0; var hdd_bat_new=0; var hdd_bat_old=0;
function showHDD(str) 
{
	if (str === "")	{ hdd = {}; return; }
	else 
	{
		if (window.XMLHttpRequest) 	{ var	xmlhttp = new XMLHttpRequest(); }


		xmlhttp.onreadystatechange = function() 
		{
			if(xmlhttp.readyState==4 && xmlhttp.status==200 && document.getElementById('cpu_title')!=null) 
			{
				hdd = JSON.parse(xmlhttp.responseText);
				
				document.getElementById('hdd_type').innerHTML = hdd["type"];
				document.getElementById('hdd_readspeed').innerHTML = hdd["readspeed"];
				document.getElementById('hdd_writes').innerHTML = hdd["writes"];
				document.getElementById('hdd_rpm').innerHTML = hdd["rpm"];
				document.getElementById('hdd_misc').innerHTML = hdd["msc"];
				if(hdd["model"].indexOf("RAID")>=0){ hdd["type"]="RAID"; }
				document.getElementById('hdd_title').innerHTML = hdd["cap"]+"GB "+hdd["type"];

				hdd_rate_old = hdd_rate_new;
				hdd_rate_new = hdd["confrate"];				
				config_rate = config_rate-hdd_rate_old+hdd_rate_new;
				update_model_rating(config_rate);
				hdd_bat_old = hdd_bat_new;
				hdd_bat_new = hdd["bat"];
				config_batlife=config_batlife-hdd_bat_old+hdd_bat_new;

				document.getElementById('bat_life1').innerHTML=hourminutes((parseFloat(acum["cap"])/config_batlife)*0.96);
				document.getElementById('bat_life2').innerHTML=hourminutes((parseFloat(acum["cap"])/config_batlife)*1.03);
				document.getElementById('dLabel').setAttribute("data-idhdd",str);
				
				var mdb_hdd=0
				if( document.getElementById("mdb_hdd").innerText.toLowerCase().indexOf("2 x sata") >= 0) { mdb_hdd=1; } 
				if(shdd["id"]!=0) { if  ((( mdb_hdd==0 && hdd["model"].toLowerCase().indexOf("m.2")<0)||( mdb_hdd==1 && hdd["model"].toLowerCase().indexOf("ssd")<0))&& document.getElementsByName("SHDD")[0]!==undefined ) { showSHDD(0); setselectedcomp("SHDD", 0) } }
			}
		}
		xmlhttp.open("GET","model/lib/php/query/hdd.php?q="+str,true);
		xmlhttp.send(); all_requests.push(xmlhttp);
	}
}
	
var shdd = {}; var shdd_price_old=0; var shdd_price_new=0; var shdd_err_new=0; var shdd_err_old=0; var shdd_rate_new=0; var shdd_rate_old=0; var shdd_bat_new=0; var shdd_bat_old=0;

function showSHDD(str) 
{
	if (str === "")	{ shdd = {}; return; }
	else 
	{
		if (window.XMLHttpRequest) { var	xmlhttp = new XMLHttpRequest(); }

		xmlhttp.onreadystatechange = function() 
		{
			if(xmlhttp.readyState==4 && xmlhttp.status==200 && document.getElementById('cpu_title')!=null) 
			{
				var prev_el=shdd;
				shdd = JSON.parse(xmlhttp.responseText);
				if(shdd===null){ shdd={}; }				
				if(document.getElementById('shdd_type'))
				{
					if (str == 0 )
					{
						document.getElementById('shdd_type').innerHTML = "N/A";
						document.getElementById('shdd_readspeed').innerHTML = "N/A";
						document.getElementById('shdd_writes').innerHTML = "N/A";
						document.getElementById('shdd_rpm').innerHTML = "N/A";
						shdd["bat"]=0;
						shdd["confrate"]=0;
					}
					else
					{
						document.getElementById('shdd_type').innerHTML = shdd["type"];
						document.getElementById('shdd_readspeed').innerHTML = shdd["readspeed"];
						document.getElementById('shdd_writes').innerHTML = shdd["writes"];
						document.getElementById('shdd_rpm').innerHTML = shdd["rpm"];
					}
					
					shdd_rate_old = shdd_rate_new;
					shdd_rate_new = shdd["confrate"];					
					config_rate = config_rate-shdd_rate_old+shdd_rate_new;
					update_model_rating(config_rate);
					shdd_bat_old = shdd_bat_new;
					shdd_bat_new = shdd["bat"];
					config_batlife=config_batlife-shdd_bat_old+shdd_bat_new;

					document.getElementById('bat_life1').innerHTML=hourminutes((parseFloat(acum["cap"])/config_batlife)*0.96);
					document.getElementById('bat_life2').innerHTML=hourminutes((parseFloat(acum["cap"])/config_batlife)*1.03);
					document.getElementById('dLabel').setAttribute("data-idshdd",str);					
				}
			}
		}
		xmlhttp.open("GET","model/lib/php/query/shdd.php?q="+str,true);
		xmlhttp.send(); all_requests.push(xmlhttp);
	}
}

var mdb = {}; var mdb_price_old=0; var mdb_price_new=0; var mdb_err_new=0; var mdb_err_old=0; var mdb_rate_new=0; var mdb_rate_old=0;
function showMDB(str) 
{
	if (str === "")	{ mdb = {}; return; }
	else 
	{
		if (window.XMLHttpRequest) 	{ var	xmlhttp = new XMLHttpRequest(); }
		
		xmlhttp.onreadystatechange = function() 
		{
			if(xmlhttp.readyState==4 && xmlhttp.status==200 && document.getElementById('cpu_title')!=null) 
			{
				mdb = JSON.parse(xmlhttp.responseText);
				document.getElementById('mdb_ram').innerHTML = mdb["ram"];
				document.getElementById('mdb_gpu').innerHTML = mdb["gpu"];
				document.getElementById('mdb_chipset').innerHTML = mdb["chipset"];
				document.getElementById('mdb_interface').innerHTML = mdbmisc(mdb["interface"]);
				document.getElementById('mdb_netw').innerHTML = mdb["netw"];
				document.getElementById('mdb_hdd').innerHTML = mdb["hdd"];
				document.getElementById('mdb_misc').innerHTML = mdbmisc(mdb["msc"]);
				
				if(mdb["optimus"]&&gpu_bat_new>3)
				{
					gpu_bat_old = gpu_bat_new;	gpu_bat_new = 3; config_batlife=config_batlife-gpu_bat_old+gpu_bat_new;

					document.getElementById('bat_life1').innerHTML=hourminutes((parseFloat(acum["cap"])/config_batlife)*0.96);
					document.getElementById('bat_life2').innerHTML=hourminutes((parseFloat(acum["cap"])/config_batlife)*1.03);
				}
				document.getElementById('dLabel').setAttribute("data-idmdb",str);
				mdb_rate_old = mdb_rate_new;
				mdb_rate_new = mdb["confrate"];
				
				config_rate = config_rate-mdb_rate_old+mdb_rate_new;
				update_model_rating(config_rate);
			}
		}
		xmlhttp.open("GET","model/lib/php/query/mdb.php?q="+str,true);
		xmlhttp.send(); all_requests.push(xmlhttp);
	}
}

var mem = {}; var mem_price_old=0; var mem_price_new=0; var mem_err_new=0; var mem_err_old=0; var mem_rate_new=0; var mem_rate_old=0;
function showMEM(str) 
{
	if (str === "")	{ mem = {}; return; }
	else 
	{
		if (window.XMLHttpRequest) { var	xmlhttp = new XMLHttpRequest(); }

		xmlhttp.onreadystatechange = function() 
		{
			if(xmlhttp.readyState==4 && xmlhttp.status==200 && document.getElementById('cpu_title')!=null) 
			{
				mem = JSON.parse(xmlhttp.responseText);
				document.getElementById('mem_title').innerHTML = mem["cap"]+"GB "+mem["type"];
				document.getElementById('mem_stan').innerHTML = mem["stan"];
				document.getElementById('mem_type').innerHTML = mem["type"];
				document.getElementById('mem_lat').innerHTML = mem["lat"];
				document.getElementById('mem_freq').innerHTML = mem["freq"];
				document.getElementById('mem_misc').innerHTML = mem["msc"];

				mem_rate_old = mem_rate_new;
				mem_rate_new = mem["confrate"];
				document.getElementById('dLabel').setAttribute("data-idmem",str);
				config_rate = config_rate-mem_rate_old+mem_rate_new;
				update_model_rating(config_rate);
			}
		}
		xmlhttp.open("GET","model/lib/php/query/mem.php?q="+str,true);
		xmlhttp.send(); all_requests.push(xmlhttp);
	}
}

var odd = {}; var odd_price_old=0; var odd_price_new=0; var odd_err_new=0; var odd_err_old=0; var odd_rate_new=0; var odd_rate_old=0; var odd_gpu=0;
function showODD(str) 
{
	if (str === "")	{ odd = {}; return; }
	else 
	{
		if (window.XMLHttpRequest) { var	xmlhttp = new XMLHttpRequest(); }

		xmlhttp.onreadystatechange = function() 
		{
			if(xmlhttp.readyState==4 && xmlhttp.status==200 && document.getElementById('cpu_title')!=null)
			{
				odd = JSON.parse(xmlhttp.responseText);
				if((odd["type"]).toUpperCase()!="NONE") { document.getElementById('odd_title').innerHTML = ", "+odd["type"]; } else { document.getElementById('odd_title').innerHTML = ""; }
				var odd_elements=['odd_speed','odd_msc'];
				for(var x in odd_elements)
				{
					var subelement=odd_elements[x].split("_");
					var subelements_by_class=document.getElementsByClassName(odd_elements[x]);
					for(var nr_el in subelements_by_class)
					{
						subelements_by_class[nr_el].innerHTML = odd[subelement[1]];
					}
				}
				
				odd_rate_old = odd_rate_new;
				odd_rate_new = odd["confrate"];
				document.getElementById('dLabel').setAttribute("data-idodd",str);
				config_rate = config_rate-odd_rate_old+odd_rate_new;
				update_model_rating(config_rate);
			}
		}
		xmlhttp.open("GET","model/lib/php/query/odd.php?q="+str,true);
		xmlhttp.send(); all_requests.push(xmlhttp);
	}
}

var acum = {}; var acum_price_old=0; var acum_price_new=0; var acum_err_new=0; var acum_err_old=0; var acum_rate_new=0; var acum_rate_old=0; var acum_gpu=0;
function showACUM(str) 
{
	if (str === "")	{ acum = {}; return; }
	else 
	{
		if (window.XMLHttpRequest)	{ var	xmlhttp = new XMLHttpRequest(); }

		xmlhttp.onreadystatechange = function() 
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200 && document.getElementById('cpu_title')!=null)  
			{
				acum = JSON.parse(xmlhttp.responseText);
				voltage=parseFloat(acum["volt"]); weight=parseFloat(acum["weight"]);
				
				var subelements_by_class=document.getElementsByClassName('acum_cell');
				for(var nr_el in subelements_by_class){ subelements_by_class[nr_el].innerHTML=acum["nrc"]; }
				var subelements_by_class=document.getElementsByClassName('acum_tipc');
				for(var nr_el in subelements_by_class){ subelements_by_class[nr_el].innerHTML=acum["tipc"]; }
				var subelements_by_class=document.getElementsByClassName('acum_volt');
				for(var nr_el in subelements_by_class){ if(!isNaN(voltage) && voltage>0) { subelements_by_class[nr_el].innerHTML=voltage+" V"; } else { subelements_by_class[nr_el].innerHTML="-"; } }
				var subelements_by_class=document.getElementsByClassName('acum_weight');
				for(var nr_el in subelements_by_class){ if(!isNaN(weight) && weight>0) { subelements_by_class[nr_el].innerHTML=weight+" Kg ("; }else{ subelements_by_class[nr_el]="-"; } }
				var subelements_by_class=document.getElementsByClassName('acum_weight_i');
				for(var nr_el in subelements_by_class){ if(!isNaN(weight) && weight>0) { subelements_by_class[nr_el].innerHTML = (weight*2.20462262).toFixed(2)+" lb)"; }else{ subelements_by_class[nr_el]=""; } }
				var subelements_by_class=document.getElementsByClassName('acum_msc');
				for(var nr_el in subelements_by_class){ subelements_by_class[nr_el].innerHTML=acum["msc"]; }

				acum_rate_old = acum_rate_new;
				acum_rate_new = acum["confrate"];
				config_rate = config_rate-acum_rate_old+acum_rate_new;
				update_model_rating(config_rate);
				document.getElementById('bat_life1').innerHTML=hourminutes((parseFloat(acum["cap"])/config_batlife)*0.96);
				document.getElementById('bat_life2').innerHTML=hourminutes((parseFloat(acum["cap"])/config_batlife)*1.03);
				document.getElementById('dLabel').setAttribute("data-idacum",str);
			}
		}
		xmlhttp.open("GET","model/lib/php/query/acum.php?q="+str,true);
		xmlhttp.send(); all_requests.push(xmlhttp);
	}
}

var chassis = {}; var chassis_price_old=0; var chassis_price_new=0; var chassis_err_new=0; var chassis_err_old=0; var chassis_rate_new=0; var chassis_rate_old=0; var chassis_gpu=0;
function showCHASSIS(str) 
{
	if (str === "")	{ chassis= {}; return; }
	else 
	{
		if (window.XMLHttpRequest)	{ var	xmlhttp = new XMLHttpRequest(); }

		xmlhttp.onreadystatechange = function() 
		{
			if(xmlhttp.readyState==4 && xmlhttp.status==200 && document.getElementById('cpu_title')!=null)
			{
				chassis = JSON.parse(xmlhttp.responseText);
				
				if(chassis["pi"]!=="") { document.getElementById('chassis_pi').innerHTML = chassis["pi"]; }
				else { document.getElementById('chassis_pi').innerHTML = "-"; }
				if(chassis["vi"]!=="") { document.getElementById('chassis_vi').innerHTML = chassis["vi"]; }
				else { document.getElementById('chassis_vi').innerHTML = "-"; }
			
				if(chassis["web"]!="None"){document.getElementById('chassis_web').innerHTML = chassis["web"]+" MP";}else{document.getElementById('chassis_web').innerHTML = chassis["web"];}
				document.getElementById('chassis_touch').innerHTML = chassis["touch"];
				document.getElementById('chassis_charger').innerHTML = chassis["charger"];
				document.getElementById('chassis_weight').innerHTML = chassis["weight"].toFixed(2);
				document.getElementById('chassis_thic').innerHTML = (chassis["thic"]/10).toFixed(1);
				document.getElementById('chassis_depth').innerHTML = (chassis["depth"]/10).toFixed(1);
				document.getElementById('chassis_width').innerHTML = (chassis["width"]/10).toFixed(1);
				
				if(chassis["color"]!=="") { document.getElementById('chassis_color').innerHTML = chassis["color"]; }
				else { document.getElementById('chassis_color').innerHTML = "-"; }
			
				document.getElementById('chassis_material').innerHTML = chassis["made"];
				document.getElementById('chassis_misc').innerHTML = chassis["msc"];
				document.getElementById('chassis_keyboard').innerHTML = chassis["keyboard"];

				document.getElementById('chassis_weight_i').innerHTML = (chassis["weight"]*2.20462262).toFixed(2);
				document.getElementById('chassis_thic_i').innerHTML = (chassis["thic"]*0.0393700787).toFixed(2);
				document.getElementById('chassis_depth_i').innerHTML = (chassis["depth"]*0.0393700787).toFixed(2);
				document.getElementById('chassis_width_i').innerHTML = (chassis["width"]*0.0393700787).toFixed(2);
				document.getElementById('dLabel').setAttribute("data-idchassis",str);

				chassis_rate_old = chassis_rate_new;
				chassis_rate_new = chassis["confrate"];
				
				config_rate = config_rate-chassis_rate_old+chassis_rate_new;
				update_model_rating(config_rate);
			}
		}
		xmlhttp.open("GET","model/lib/php/query/chassis.php?q="+str,true);
		xmlhttp.send(); all_requests.push(xmlhttp);
	}
}

var wnet = {}; var wnet_price_old=0; var wnet_price_new=0; var wnet_err_new=0; var wnet_err_old=0; var wnet_rate_new=0; var wnet_rate_old=0; var wnet_gpu=0;
function showWNET(str) 
{
	if (str === "")	{ wnet = {}; return; }
	else 
	{
		if (window.XMLHttpRequest)	{ var	xmlhttp = new XMLHttpRequest(); }
		
		xmlhttp.onreadystatechange = function() 
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200 && document.getElementById('cpu_title')!=null)  
			{
				wnet = JSON.parse(xmlhttp.responseText);
				if(parseInt(wnet["speed"])!=0){document.getElementById('wnet_speed').innerHTML = wnet["speed"]+" Mbps";} else {document.getElementById('wnet_speed').innerHTML = "-";} 
				document.getElementById('wnet_stand').innerHTML = wnet["stand"];
				document.getElementById('wnet_slot').innerHTML = wnet["slot"];
				document.getElementById('wnet_misc').innerHTML = wnetmisc(wnet["msc"]);

				wnet_rate_old = wnet_rate_new;
				wnet_rate_new = wnet["confrate"];
				document.getElementById('dLabel').setAttribute("data-idwnet",str);
				config_rate = config_rate-wnet_rate_old+wnet_rate_new;
				update_model_rating(config_rate);
			}
		}
		xmlhttp.open("GET","model/lib/php/query/wnet.php?q="+str,true);
		xmlhttp.send(); all_requests.push(xmlhttp);
	}
}
	
var war = {}; var war_price_old=0; var war_price_new=0; var war_err_new=0; var war_err_old=0; var war_rate_new=0; var war_rate_old=0; var war_gpu=0;
function showWAR(str) 
{
	if (str === "")	{ war = {}; return; }
	else 
	{
		if (window.XMLHttpRequest)	{ var	xmlhttp = new XMLHttpRequest(); }
		
		xmlhttp.onreadystatechange = function() 
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200 && document.getElementById('cpu_title')!=null)  
			{
				war = JSON.parse(xmlhttp.responseText);
				document.getElementById('war_misc').innerHTML = war["msc"];

				war_rate_old = war_rate_new;
				war_rate_new = war["confrate"];
				document.getElementById('dLabel').setAttribute("data-idwar",str);

				config_rate = config_rate-war_rate_old+war_rate_new;
				update_model_rating(config_rate);
			}
		}
		xmlhttp.open("GET","model/lib/php/query/war.php?q="+str,true);
		xmlhttp.send(); all_requests.push(xmlhttp);
	}
}

var sist = {}; var sist_price_old=0; var sist_price_new=0; var sist_err_new=0; var sist_err_old=0; var sist_rate_new=0; var sist_rate_old=0; var sist_gpu=0;
function showSIST(str) 
{
	if (str === "")	{ sist= {}; return; }
	else 
	{
		if (window.XMLHttpRequest)	{ var	xmlhttp = new XMLHttpRequest(); }
		
		xmlhttp.onreadystatechange = function() 
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200 && document.getElementById('cpu_title')!=null) 
			{
				sist = JSON.parse(xmlhttp.responseText);
				if(sist["vers"]==0){sist["vers"]="";}
				if(sist["sist"].localeCompare("No OS")!=0)
				{ document.getElementById('sist_title').innerHTML = ", "+sist["sist"]+" "+sist["vers"]+" "+sist["type"]; }
				document.getElementById('dLabel').setAttribute("data-idsist",str);
				sist_rate_old = sist_rate_new;
				sist_rate_new = sist["confrate"];

				config_rate = config_rate-sist_rate_old+sist_rate_new;
				update_model_rating(config_rate);
			}
		}
		xmlhttp.open("GET","model/lib/php/query/sist.php?q="+str,true);
		xmlhttp.send(); all_requests.push(xmlhttp);
	}
}

var elementsWithFadeAnimation = document.querySelectorAll('.labelblue');
var model_ratingElementsList = document.querySelectorAll('.rating-element .progress-container');
var fade_timeout=500;
function getconf(comp,id,exactconf,new_page=false) 
{
	gocomp=0;
	var cpu_id=cpu["id"]; var display_id=display["id"]; var mem_id=mem["id"]; var hdd_id=hdd["id"];  var shdd_id=shdd["id"]; var gpu_id=gpu["id"]; var wnet_id=wnet["id"]; var odd_id=odd["id"]; var mdb_id=mdb["id"]; var chassis_id=chassis["id"]; var acum_id=acum["id"]; var war_id=war["id"]; var sist_id=sist["id"]; var confdata = {}; var success=false; var go=false; var mdb_hdd=0; var new_excode=excode; new_exch_rate=exch; var force_new_ex="";
	
	switch(comp)
	{
		case "CPU":
		{ prev_id=cpu_id; cpu_id=id; if(cpu["id"]===undefined) { go=true; } if(gpu["typegpu"]<1){ cpu_el=document.getElementsByName("CPU")[0]; for ( var i = 0; i < cpu_el.options.length; i++ ) { if ( cpu_el.options[i].value == cpu_id) { gpu_id=cpu_el.options[i].getAttribute("data-gpu"); } } }  break; }
		case "DISPLAY":
		{ prev_id=display_id; display_id=id; setselectedcomp("DISPLAY",display_id); if(display["id"]===undefined) { go=true; } break; }
		case "MEM":
		{ prev_id=mem_id; mem_id=id; if(mem["id"]===undefined) { go=true; }  break; }
		case "HDD":
		{ prev_id=hdd_id; hdd_id=id; if(hdd["id"]===undefined) { go=true; } hdd_el=document.getElementsByName("HDD")[0]; if( document.getElementById("mdb_hdd").innerText.toLowerCase().indexOf("2 x sata") >= 0) { mdb_hdd=1; } for ( var i = 0; i < hdd_el.options.length; i++ ) { if ( hdd_el.options[i].value == hdd_id && ((mdb_hdd==0 && hdd_el.options[i].text.toLowerCase().indexOf("m.2") < 0) || (mdb_hdd && hdd_el.options[i].text.toLowerCase().indexOf("SSD") < 0 ) ) ) { shdd_id=0; } } break; } 
		case "SHDD":
		{ prev_id=shdd_id; shdd_id=id; if(shdd["id"]===undefined) { go=true; }  break; }
		case "GPU":
		{ prev_id=gpu_id; if(id == -1){ id=cpu_gpu; } gpu_id=id; if(gpu["id"]===undefined) { go=true; } break; }
		case "WNET":
		{ prev_id=wnet_id; wnet_id=id; if(wnet["id"]===undefined) { go=true; }  break; }
		case "ODD":
		{ prev_id=odd_id; odd_id=id; if(odd["id"]===undefined) { go=true; }  break; }
		case "MDB":
		{ prev_id=mdb_id; mdb_id=id; if(mdb["id"]===undefined) { go=true; }  break; }
		case "CHASSIS":
		{ prev_id=chassis_id; chassis_id=id; if(chassis["id"]===undefined) { go=true; }  break; }
		case "ACUM":
		{ prev_id=acum_id; acum_id=id; if(acum["id"]===undefined) { go=true; }  break; }
		case "WAR":
		{ prev_id=war_id; war_id=id; if(war["id"]===undefined) { go=true; }  break; }
		case "SIST":
		{ prev_id=sist_id; sist_id=id; if(sist["id"]===undefined) { go=true; }  break; }
		case "EXCH":
		{ new_excode=id[0]; force_new_ex="&force_new_ex=1"; new_exch_rate=id[1]; go=true; break; }
	}
	
	if(exactconf!==undefined) { cpu_id=exactconf[0]; display_id=exactconf[1]; mem_id=exactconf[2]; hdd_id=exactconf[3]; shdd_id=exactconf[4]; gpu_id=exactconf[5]; wnet_id=exactconf[6]; odd_id=exactconf[7]; mdb_id=exactconf[8]; chassis_id=exactconf[9]; acum_id=exactconf[10]; war_id=exactconf[11]; sist_id=exactconf[12]; go=true; }
	
	if (!go && (mid===undefined || cpu["id"]===undefined || display["id"]===undefined || mem["id"]===undefined || hdd["id"]===undefined || shdd["id"]===undefined || gpu["id"]===undefined || wnet["id"]===undefined || odd["id"]===undefined || mdb["id"]===undefined || chassis["id"]===undefined || acum["id"]===undefined || war["id"]===undefined || sist["id"]===undefined ))
	{
		confdata = {};
		return;
	}
	else 
	{ 
		if (window.XMLHttpRequest) 
		{
			var	xmlhttp = new XMLHttpRequest();
		}
		xmlhttp.onreadystatechange = function() 
		{
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
			{
				confdata = JSON.parse(xmlhttp.responseText);
				confdata["cprice"]=parseInt(confdata["cprice"]); if(confdata["cprice"]>0){ success=true; }
				if(success || go)
				{
					if(parseInt(mid)!=parseInt(confdata["cmodel"]))
					{
						update_model_info(confdata["cmodel"]);
						if(confdata["newregion"]!==undefined&&confdata["newregion"])
						{	
							if(confdata["mregion_id"].indexOf("1")<0&&confdata["mregion_id"].indexOf("0")<0)
							{ change_exch(confdata["exch"]);}
							else
							{ change_exch(excode); }
						}
						else
						{ if(confdata["exch"]!=excode){if(confdata["mregion_id"].indexOf("1")<0&&confdata["mregion_id"].indexOf("0")<0){change_exch(confdata["exch"]);}else{change_exch(excode);}}else{ change_exch(excode);} }
					}
					
					mid=confdata["cmodel"];
					confdata["cerr"]=parseInt(confdata["cerr"]);
					if(new_excode!=excode)
					{
						change_exch(new_excode); currentPage=currentPage.replace("ex="+excode,"ex="+new_excode); excode=new_excode; var sel_ex_model=document.getElementById("m_currency"); exch=new_exch_rate; document.getElementById('dLabel').setAttribute("data-lang",sel_ex_model.options[sel_ex_model.selectedIndex].getAttribute("data-id")); 
						
						for(var key in best_low_array){ var el=document.getElementById(best_low_array[key]+'_id'); if(confdata["best_low"][best_low_array[key]]!==null && confdata["best_low"][best_low_array[key]]!==undefined && confdata["best_low"][best_low_array[key]]!=""){ el.setAttribute('onmousedown','OpenPage('+"'"+'model/model.php?conf='+confdata["best_low"][best_low_array[key]]+'&ex='+excode+"',event);"+''); el.style.display="block";} else { el.style.display="none"; } } best_low=confdata["best_low"]; 
					}
					for(var key in best_low_array){ var el=document.getElementById(best_low_array[key]+'_id'); el.setAttribute('onmousedown',el.getAttribute('onmousedown').replace(/(.*)\&ex=([a-z0-9\-]+)(\&?.*)/i,"$1"+"&ex="+excode+"$3"));}
					update_model_price(confdata["cprice"],confdata["cerr"]);
					
					if(confdata["changes"]!==undefined) 
					{
						for (var key in confdata["changes"])
						{
							if(key!=="txt") { window['show'+key](confdata["changes"][key]); setselectedcomp(key,confdata["changes"][key]); if(key=="GPU"){ gpu_right_align();} }
							else
							{ 
								if(show_comp_message)
								{
									var componentsList = confdata["changes"][key].split(',');
									var message = "This component is only available in combination with a different:";
									showNotification('info', message, componentsList);
								}
								else{show_comp_message=1;}
							}
						}
					}

					update_url(confdata["cid"],mid,excode);
					set_best_low(confdata["cid"],best_low);
					switch(comp)
					{
						case "CPU":
						{ showCPU(id); break; } 
						case "DISPLAY":
						{ showDISPLAY(id); break; } 
						case "MEM":
						{ showMEM(id); break; } 
						case "HDD":
						{ showHDD(id); break; } 
						case "SHDD":
						{ showSHDD(id); break; } 
						case "GPU":
						{ showGPU(id); break; } 
						case "WNET":
						{ showWNET(id); break; } 
						case "ODD":
						{ showODD(id); break; } 
						case "MDB":
						{ showMDB(id); break; } 
						case "CHASSIS":
						{ showCHASSIS(id); break; } 
						case "ACUM":
						{ showACUM(id); break; } 
						case "WAR":
						{ showWAR(id); break; } 
						case "SIST":
						{ showSIST(id); break; }
						case "EXCH":
						{ confdata["changes"]=undefined; OpenPage("model/model.php?conf="+confdata["cid"]+"_"+mid+"&ex="+excode); break; } 
					}
					
					for (element of [...elementsWithFadeAnimation]) { element.classList.add('blueAnimation'); }
					model_label_animation=setTimeout(function ()
					{
						setProgressBarsRating(model_ratingElementsList);
						setTimeout(function()
						{	
							for (element of [...elementsWithFadeAnimation]) { element.classList.remove('blueAnimation'); }
						},fade_timeout/2);
					}, fade_timeout/2);
				}
				else
				{
					if(document.getElementsByName(comp)[0]!==undefined&&comp!==undefined)
					{
						switch(comp)
						{
							case "CPU":
							{ setselectedcomp("CPU",prev_id); break; }  
							case "DISPLAY":
							{ setselectedcomp("DISPLAY",prev_id); break; } 
							case "MEM":
							{ setselectedcomp("MEM",prev_id); break; } 
							case "HDD":
							{ setselectedcomp("HDD",prev_id); break; } 
							case "SHDD":
							{ setselectedcomp("SHDD",prev_id); break; } 
							case "GPU":
							{ setselectedcomp("GPU",prev_id); gpu_right_align(); break; } 
							case "WNET":
							{ setselectedcomp("WNET",prev_id); break; } 
							case "ODD":
							{ setselectedcomp("ODD",prev_id); break; } 
							case "MDB":
							{ setselectedcomp("MDB",prev_id); break; } 
							case "CHASSIS":
							{ setselectedcomp("CHASSIS",prev_id); break; } 
							case "ACUM":
							{ setselectedcomp("ACUM",prev_id); break; } 
							case "WAR":
							{ setselectedcomp("WAR",prev_id); break; }  
							case "SIST":
							{ setselectedcomp("SIST",prev_id); break; } 
						}
						var message = "We are sorry, but this configuration is not available on this regional market.";
						showNotification('warning', message);
					}
				}
			}			
		}
	}
	xmlhttp.open("GET","model/lib/php/query/getconf.php?c="+mid+"-"+cpu_id+"-"+display_id+"-"+mem_id+"-"+hdd_id+"-"+shdd_id+"-"+gpu_id+"-"+wnet_id+"-"+odd_id+"-"+mdb_id+"-"+chassis_id+"-"+acum_id+"-"+war_id+"-"+sist_id+"&cf="+config_rate+"&comp="+comp+"&ex="+new_excode+force_new_ex,true);
	xmlhttp.send(); all_requests.push(xmlhttp);
}

function update_url(confid,mid,excode)
{
	var stateObj = { no: "empty" }; setTimeout(function(){ gocomp=1;}, 10);
	var addref=""; if(ref!=null&&ref!="") { addref="&ref="+ref; }
	if(currentPage.match(/(conf=)(\d+)(.*)/i)!==null)
	{ 
		history.replaceState(stateObj, confid, currentPage.replace(/(conf=)(\d+)(\_\d+)(.*)/i,"$1"+confid+"_"+mid+"$4"));
		if(currentPage.indexOf("ref=")<0){ if(ref!=null&&ref!="") { currentPage=currentPage+"&ref="+ref; } }
		if(currentPage.match(/(ex=)(.*)/i)===null)
		{ history.replaceState(stateObj, confid+" "+excode, currentPage+"&ex="+excode); }
	}
	else
	{ history.replaceState(stateObj, confid, "?model/model.php?conf="+confid+"_"+mid+"&ex="+excode+addref); }	
	currentPage = window.location.href;
}

function update_model_info(model_id) 
{
	if (model_id === ""){ return; }
	else 
	{
		if (window.XMLHttpRequest)	{ var xmlhttp = new XMLHttpRequest(); }
		
		xmlhttp.onreadystatechange = function() 
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200 && document.getElementById('cpu_title')!=null)
			{
				new_model_data=JSON.parse(xmlhttp.responseText);
				mprod=new_model_data["prod"]; mfamily=new_model_data["fam"]+new_model_data["subfam"]; msubmodel=new_model_data["submodel"];
				keywords=new_model_data["keywords"]; mmodel=new_model_data["model"];
				exchsign=new_model_data["region"];
				document.getElementById('model_title').innerHTML=mprod+" "+mfamily+" "+mmodel+""+msubmodel+new_model_data["region"];
				update_schema_rating_info("name",null,null,(mprod+" "+mfamily+" "+mmodel+""+msubmodel));
				update_schema_rating_info("aggregateRating","itemReviewed","name",(mprod+" "+mfamily+" "+mmodel+""+msubmodel));
				if(new_model_data["msc"]!=null && new_model_data["msc"].length>0)
				{ 
					document.getElementById('model_msc').innerHTML=new_model_data["msc"];
					document.getElementById('model_msc_card').style.display='block';
				}
				else
				{
					document.getElementById('model_msc').innerHTML="";
					document.getElementById('model_msc_card').style.display='none';
				}
				document.getElementById('dLabel').setAttribute("data-buyregions",new_model_data["regions"]);
				document.getElementById('dLabel').setAttribute("data-idmodel",model_id); 
				document.getElementById('dLabel').setAttribute("data-mprod",mprod); 
				set_model_info();
			}
		}
		xmlhttp.open("GET","model/lib/php/query/model.php?id="+model_id,true);
		xmlhttp.send(); all_requests.push(xmlhttp);
	}
}

function setselectedcomp(comp,value)
{
	var local_comp_list=document.getElementsByName(comp);
	for(var x in local_comp_list)
	{
		var comp=local_comp_list[x];
		if(comp!==undefined&&comp.options!==undefined)
		{
			for ( var i = 0; i < comp.options.length; i++ )
			{ if ( comp.options[i].value == value ) { comp.options[i].selected = true; break; } }
		}
	}
}

function cpumisc(str) 
{
	var msc_el = str.split(","); var msc="";
	var text1 = '<span class="toolinfo" data-toolid="';
	var text2 = '"  data-load="1" data-html="true" data-toggle="tooltip" data-delay='+"'"+'{"show": 600}'+"'"+' data-placement="left" data-original-title="Loading..."><span>';
	var text3 = '</span> <i class="fa fa-question toolinfo-icon"></i></span>';

	var i, value;
	for (i = 0; i < msc_el.length; ++i)
	{
		value = msc_el[i];
		value = $.trim(value);

		if(value.match("SSE")){ msc=msc+text1+"10"+text2+value+text3+', '; }
		else if(value.match("64")) { msc=msc+text1+"11"+text2+value+text3+', '; }
		else if(value.match("AVX")) { if(value.match("AVX 2.0")) { msc=msc+text1+"13"+text2+value+text3+', '; } else { msc=msc+text1+"12"+text2+value+text3+', '; }}
		else if(value.match("HT") || value.match("SMT")) {	msc=msc+text1+"15"+text2+value+text3+', '; }
		else if(value.match("VT-d") || value.match("AMD-Vi")) { msc=msc+text1+"17"+text2+value+text3+', '; }
		else if(value.match("VT-x") || value.match("AMD-V") || value.match("ARM-V") ) { msc=msc+text1+"16"+text2+value+text3+', '; }
		else if(value.match("VT-c")) { msc=msc+text1+"18"+text2+value+text3+', '; }
		else if(value.match("TBT") || value.match("AMD XFR") || value.match("Turbo Boost") || value.match("TC") || value.match("BPT")) { msc=msc+text1+"19"+text2+value+text3+', '; }
		else if(value.match("GNA")) { msc=msc+text1+"103"+text2+value+text3+', '; }
	}
	msc=msc.trim();
	if(msc[msc.length-1]==","){ msc=msc.slice(0,-1) }
	
	return msc;
}

function mdbmisc(str) 
{
	var msc_el = str.split(",");
	var msc="";

	var text1 = '<span class="toolinfo" data-toolid="';
	var text2 = '"  data-load="1" data-html="true" data-toggle="tooltip" data-delay='+"'"+'{"show": 600}'+"'"+' data-placement="left" data-original-title="Loading..."><span>';
	var text3 = '</span> <i class="fa fa-question toolinfo-icon"></i></span>';

	var i, value;
	for (i = 0; i < msc_el.length; ++i)
	{
		value = msc_el[i];
		value = $.trim(value);
		if(value.indexOf("MXM")>=0){ msc=msc+text1+"104"+text2+value+text3+", "; } else
		if((value.indexOf("DGFF")>=0)||(value.indexOf("PGFF")>=0)){ msc=msc+text1+"105"+text2+value+text3+", "; } else
		{ msc=msc+"<span>"+value+"</span>"+", "; }
	}
	msc=msc.trim();
	if(msc[msc.length-1]==","){ msc=msc.slice(0,-1) }

	return msc;
}
	
function gpumisc(str) 
{
	var msc_el = str.split(",");
	var msc="";

	var text1 = '<span class="toolinfo" data-toolid="';
	var text2 = '"  data-load="1" data-html="true" data-toggle="tooltip" data-delay='+"'"+'{"show": 600}'+"'"+' data-placement="left" data-original-title="Loading..."><span>';
	var text3 = '</span> <i class="fa fa-question toolinfo-icon"></i></span>';

	var i, value;
	for (i = 0; i < msc_el.length; ++i)
	{
		value = msc_el[i];
		value = $.trim(value);
		
		if(value.indexOf("Boost Frequency")>=0){ msc=msc+text1+"31"+text2+value+text3+", "; } else 
		if((value.indexOf("G-Sync")>=0)||(value.indexOf("FreeSync")>=0)){ msc=msc+text1+"33"+text2+value+text3+", "; } else
		if(value.indexOf("Eyefinity")>=0){ msc=msc+text1+"34"+text2+value+text3+", "; } else
		if(value.indexOf("PhysX")>=0){ msc=msc+text1+"35"+text2+value+text3+", "; } else
		if(value.indexOf("CUDA")>=0){ msc=msc+text1+"36"+text2+value+text3+", "; } else
		if((value.indexOf("Crossfire")>=0)||(value.indexOf("SLI")>=0)){ msc=msc+text1+"37"+text2+value+text3+", "; } else	
		if(value.indexOf("APP Acceleration")>=0){ msc=msc+text1+"38"+text2+value+text3+", "; } else
		if((value.indexOf("Optimus")>=0)||(value.indexOf("Enduro")>=0)){ msc=msc+text1+"39"+text2+value+text3+", "; } else
		if(value.indexOf("BatteryBoost")>=0){ msc=msc+text1+"40"+text2+value+text3+", "; } else
		if(value.indexOf("ZeroCore")>=0){ msc=msc+text1+"41"+text2+value+text3+", "; } else
		if(value.indexOf("Ray tracing")>=0){ msc=msc+text1+"88"+text2+value+text3+", "; } else
		if(value.indexOf("DLSS")>=0){ msc=msc+text1+"89"+text2+value+text3+", "; } else
		{ msc=msc+"<span>"+value+"</span>"+", "; }
	}
	msc=msc.trim();
	if(msc[msc.length-1]==","){ msc=msc.slice(0,-1) }

	return msc;
}

function wnetmisc(str) 
{
	var msc_el = str.split(",");
	var msc="";
	
	var text1 = '<span class="toolinfo" data-toolid="';
	var text2 = '"  data-load="1" data-html="true" data-toggle="tooltip" data-delay='+"'"+'{"show": 600}'+"'"+' data-placement="left" data-original-title="Loading..."><span>';
	var text3 = '</span> <i class="fa fa-question toolinfo-icon"></i></span>';

	var i, value;

	for (i = 0; i < msc_el.length; ++i)
	{
		value = msc_el[i];
		value = $.trim(value);
		if(value.indexOf("Bluetooth")>=0){ msc=msc+text1+"78"+text2+value+text3+", "; } else 
		if((value.indexOf("Wireless Display")>=0)||(value.indexOf("Wireless Display")>=0)){ msc=msc+text1+"79"+text2+value+text3+", "; } else
		{ msc=msc+"<span>"+value+"</span>"+", "; }
	}
	msc=msc.trim();
	if(msc[msc.length-1]==","){ msc=msc.slice(0,-1) }

	return msc;
}

function set_best_low(confid,array_values)
{
	function set_active_confopt(key)
	{
		var confopts=document.getElementsByClassName("configOptions");
		for(var key2=0;key2<3;key2++)
		{
			if(key==key2)
			{ document.getElementsByClassName("configOptions")[key2].classList.add("selectedOption"); }
			else
			{ document.getElementsByClassName("configOptions")[key2].classList.remove("selectedOption"); }
		}
	}
	
	var i=1;
	for (var key in array_values)
	{
		if(confid===array_values[key].split("_")[0])
		{
			switch(key)
			{
				case "lowest_price":
				{ set_active_confopt(2); break;	}
				case "best_performance":
				{ set_active_confopt(1); break;	}
				case "best_value":
				{ set_active_confopt(0); break;	}
				default:
				{ break; }
			}
			i=0;
		}
	}
	if(i) { set_active_confopt(-1); }
}

function update_schema_rating_info(field_1,field_2,field_3,value)
{
	if(field_1!=null && typeof(model_page_schema_data[field_1])!=="undefined")
	{ 
		if(field_2!=null)
		{ 
			if(field_3!=null)
			{ 
				if(typeof(model_page_schema_data[field_1][field_2][field_3])!=="undefined")
				{ model_page_schema_data[field_1][field_2][field_3]=value; }
			}
			else
			{
				if(typeof(model_page_schema_data[field_1][field_2])!=="undefined")
				{ model_page_schema_data[field_1][field_2]=value; }
			}
		}
		else { model_page_schema_data[field_1]=value; }
	}

	var script="";
	script = '<script type="application/ld+json">'+JSON.stringify(model_page_schema_data)+"</script>";
	document.querySelector('#model_page_schema').innerHTML=script;
}
update_schema_rating_info("aggregateRating","itemReviewed","name",(mprod+" "+mfamily+" "+mmodel+""+msubmodel));
update_schema_rating_info("aggregateRating","itemReviewed","image",ref_model_image);
update_schema_rating_info("name",null,null,(mprod+" "+mfamily+" "+mmodel+""+msubmodel));
update_schema_rating_info("name",null,null,(mprod+" "+mfamily+" "+mmodel+""+msubmodel));
update_schema_rating_info("image",null,null,ref_model_image);
update_schema_rating_info("brand",null,null,mprod);

function update_model_rating(value){ var new_rating=normal_rating(config_rate); if (document.getElementById('progress-overall') != null ){ PROGRESSBAR.update({target:"#progress-overall",value:new_rating}); update_schema_rating_info("aggregateRating","ratingValue",null,new_rating); } }
function eliminate_first_line_desc(el){ var temp_el=el; if(temp_el==="-"){temp_el="";}else{temp_el=temp_el+",";} return temp_el;}
function normal_rating(x){ x=x*1000; x=(((1.25/1000000*Math.pow(x,2))+1.305*x+(-4.3/100000000000*Math.pow(x,3)))/1000); x=((Math.round(x)*10)/10).toFixed(1); return x; }
function change_exch(new_exchcode){ for(var key in document.getElementById("m_currency").options){ if(document.getElementById("m_currency").options[key].value==new_exchcode){document.getElementById("m_currency").selectedIndex=key;}}}
function change_m_currency(el){ var selected=(el||el.options[el.selectedIndex]); getconf('EXCH',[selected.value,parseFloat(el.options[el.selectedIndex].getAttribute("data-exch"))],undefined); }

//# sourceURL=model_queries.js