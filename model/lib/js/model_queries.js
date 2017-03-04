var googlelink={};
var binglink={};
var amazonlink={};
googlelink["first"]="https://www.google.com/search?q=";
binglink["first"]="https://www.bing.com/search?q=";
switch(exchsign)
{ 
	case '$':
	amazonlink["first"]="https://www.amazon.com/s/ref=nb_sb_noss?field-keywords=";
	break;
	case '€':
	amazonlink["first"]="https://www.amazon.de/s/ref=nb_sb_noss?field-keywords=";
	break;
	case '£':
	amazonlink["first"]="https://www.amazon.co.uk/s/ref=nb_sb_noss?field-keywords=";
	break;
}
googlelink["cpu"]=""; googlelink["gpu"]=""; googlelink["mem"]=""; googlelink["resolution"]=""; googlelink["sist"]="";

var cpu = {}; var cpu_price_old=0; var cpu_price_new=0; var cpu_err_new=0; var cpu_err_old=0; var cpu_rate_new=0; var cpu_rate_old=0; var cpu_gpu=0; var cpu_bat_new=0; var cpu_bat_old=0;
function showCPU(str) 
{
	if (str === "") 
	{
		cpu = {};
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
				document.getElementById('cpu_rating').innerHTML = cpu["rating"];
				document.getElementById('cpu_class').innerHTML = cpu["class"];
						
				googlelink["cpu"]=cpu["model"];
				makelinks();
				
				cpu_rate_old = cpu_rate_new;
				cpu_rate_new = cpu["confrate"];
				config_rate = config_rate-cpu_rate_old+cpu_rate_new;
				document.getElementById('notebro_rate').innerHTML=(Math.round(config_rate * 10) / 10).toFixed(1);
				
				cpu_bat_old = cpu_bat_new;
				cpu_bat_new = cpu["bat"];
				config_batlife=config_batlife-cpu_bat_old+cpu_bat_new;
				document.getElementById('bat_life1').innerHTML=hourminutes((parseFloat(acum["cap"])/config_batlife)*0.95);
				document.getElementById('bat_life2').innerHTML=hourminutes((parseFloat(acum["cap"])/config_batlife)*1.02);
				cpu_gpu=parseInt(cpu["gpu"]);
				getconf();				
				if($("#GPU").val()==-1)
				{
					if(cpu_gpu)
					{ showGPU(cpu_gpu); }
					else
					{	document.querySelector('#GPU [value="' + gpudet + '"]').selected = true; showGPU(gpudet); }
				}		
			}
		}
		xmlhttp.open("GET","model/lib/php/query/cpu.php?q="+str,true);
		xmlhttp.send();
	}
}
	
var gpu = {}; var gpu_price_old=0; var gpu_price_new=0; var gpu_err_new=0; var gpu_err_old=0; var gpu_rate_new=0; var gpu_rate_old=0; var gpu_bat_old=0; var gpu_bat_new=0;
var gpu_type=4; var gpu_previous=0; 
function showGPU(str) 
{
	if(str == -1)
	{
		if(!cpu_gpu)
		{
			alert("This processor does not have an integrated graphics controller, please choose a different processor first!")
			str=gpu_previous;
			document.querySelector('#GPU [value="' + str + '"]').selected = true;
		}
		else			
		str=cpu_gpu;

	}

	if (str === "") 
	{
		gpu = {};
		return;
	}
	else 
	{
		if (window.XMLHttpRequest) 
		{
			var xmlhttp = new XMLHttpRequest();
		}
		
		xmlhttp.onreadystatechange = function() 
		{
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
			{
				gpu = JSON.parse(xmlhttp.responseText);
				
				document.getElementById('gpu_title').innerHTML = gpu["prod"] + " " + gpu["model"];
				document.getElementById('gpu_arch').innerHTML = gpu["arch"];
				document.getElementById('gpu_tdp').innerHTML = gpu["power"];
				document.getElementById('gpu_tech').innerHTML = gpu["tech"];
				document.getElementById('gpu_speed').innerHTML = gpu["cspeed"] + " to " + gpu["bspeed"];
				document.getElementById('gpu_shaders').innerHTML = gpu["pipe"];
				
				if(gpu["typegpu"]==0)
				document.getElementById('gpu_misc').innerHTML = gpu["prod"]+" "+gpu["model"]+"<br />"+gpumisc(gpu["msc"]);
				else
				document.getElementById('gpu_misc').innerHTML = gpumisc(gpu["msc"]);
				
				document.getElementById('gpu_shadermodel').innerHTML = parseFloat(gpu["shader"]).toFixed(1);
				document.getElementById('gpu_memspeed').innerHTML = gpu["mspeed"];
				document.getElementById('gpu_rating').innerHTML = gpu["rating"];
				document.getElementById('gpu_bus').innerHTML = gpu["mbw"];
				document.getElementById('gpu_mem').innerHTML = gpu["maxmem"]+" MB "+gpu["mtype"];
				document.getElementById('gpu_smem').innerHTML = gpu["sharem"];
				document.getElementById('gpu_class').innerHTML = gpu["class"];
				//document.getElementById('gpu_boost').innerHTML = gpu["bspeed"];
				
				getconf();	

				gpu_rate_old = gpu_rate_new;
				gpu_rate_new = gpu["confrate"];				
				config_rate = config_rate-gpu_rate_old+gpu_rate_new;
				document.getElementById('notebro_rate').innerHTML=(Math.round(config_rate * 10) / 10).toFixed(1);
						
				gpu_bat_old = gpu_bat_new;
				gpu_bat_new = gpu["bat"];
				config_batlife=config_batlife-gpu_bat_old+gpu_bat_new;
				document.getElementById('bat_life1').innerHTML=hourminutes((parseFloat(acum["cap"])/config_batlife)*0.95);
				document.getElementById('bat_life2').innerHTML=hourminutes((parseFloat(acum["cap"])/config_batlife)*1.02);
			
				if(gpu["typegpu"]>0)
				{ googlelink["gpu"]=gpu["model"]; }
				else
				{ googlelink["gpu"]=""; }
					
				makelinks();
			}
		}
		xmlhttp.open("GET","model/lib/php/query/gpu.php?q="+str,true);
		xmlhttp.send();
		gpu_previous=str;
	}
}
	
var display = {}; var display_price_old=0;	var display_price_new=0; var display_err_new=0;	var display_err_old=0; var display_rate_new=0; var display_rate_old=0; var display_bat_old=0; var display_bat_new=0;
function showDISPLAY(str) 
{
	if (str === "") 
	{
		display = {};
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
				display = JSON.parse(xmlhttp.responseText);
				
				document.getElementById('display_size').innerHTML = display["size"];
				document.getElementById('display_title').innerHTML = display["size"];
				document.getElementById('display_format').innerHTML = display["format"];
				document.getElementById('display_hres').innerHTML = display["hres"];
				document.getElementById('display_vres').innerHTML = display["vres"];
				document.getElementById('display_surft').innerHTML = display["surft"];
				document.getElementById('display_backt').innerHTML = display["backt"];
				document.getElementById('display_touch').innerHTML = display["touch"];
				document.getElementById('display_misc').innerHTML = display["msc"];
				document.getElementById('display_rating').innerHTML = display["rating"];
			
				getconf();
			
				display_rate_old = display_rate_new;
				display_rate_new = display["confrate"];		
				config_rate = config_rate-display_rate_old+display_rate_new;
				document.getElementById('notebro_rate').innerHTML=(Math.round(config_rate * 10) / 10).toFixed(1);
				
				display_bat_old = display_bat_new;
				display_bat_new = display["bat"];
				config_batlife=config_batlife-display_bat_old+display_bat_new;
				document.getElementById('bat_life1').innerHTML=hourminutes((parseFloat(acum["cap"])/config_batlife)*0.95);
				document.getElementById('bat_life2').innerHTML=hourminutes((parseFloat(acum["cap"])/config_batlife)*1.02);
				googlelink["resolution"]=display["hres"]+"x"+display["vres"];
				makelinks();
			}
		}
		xmlhttp.open("GET","model/lib/php/query/display.php?q="+str,true);
		xmlhttp.send();
	}
}
	
var hdd = {}; var hdd_price_old=0; var hdd_price_new=0; var hdd_err_new=0; var hdd_err_old=0; var hdd_rate_new=0; var hdd_rate_old=0; var hdd_bat_new=0; var hdd_bat_old=0;
function showHDD(str) 
{
	if (str === "") 
	{
		hdd = {};
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
				hdd = JSON.parse(xmlhttp.responseText);
				
				document.getElementById('hdd_type').innerHTML = hdd["type"];
				document.getElementById('hdd_readspeed').innerHTML = hdd["readspeed"];
				document.getElementById('hdd_writes').innerHTML = hdd["writes"];
				document.getElementById('hdd_rpm').innerHTML = hdd["rpm"];
				document.getElementById('hdd_misc').innerHTML = hdd["msc"];
				document.getElementById('hdd_title').innerHTML = hdd["cap"]+"GB "+hdd["type"];

				getconf();
				
				hdd_rate_old = hdd_rate_new;
				hdd_rate_new = hdd["confrate"];				
				config_rate = config_rate-hdd_rate_old+hdd_rate_new;
				document.getElementById('notebro_rate').innerHTML=(Math.round(config_rate * 10) / 10).toFixed(1);
		
				hdd_bat_old = hdd_bat_new;
				hdd_bat_new = hdd["bat"];
				config_batlife=config_batlife-hdd_bat_old+hdd_bat_new;
				document.getElementById('bat_life1').innerHTML=hourminutes((parseFloat(acum["cap"])/config_batlife)*0.95);
				document.getElementById('bat_life2').innerHTML=hourminutes((parseFloat(acum["cap"])/config_batlife)*1.02);				
			}
		}
		xmlhttp.open("GET","model/lib/php/query/hdd.php?q="+str,true);
		xmlhttp.send();
	}
}
	
var shdd = {}; var shdd_price_old=0; var shdd_price_new=0; var shdd_err_new=0; var shdd_err_old=0; var shdd_rate_new=0; var shdd_rate_old=0; var shdd_bat_new=0; var shdd_bat_old=0;
function showSHDD(str) 
{
	if (str === "") 
	{	
		shdd = {};
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
					}
					else
					{
						document.getElementById('shdd_type').innerHTML = shdd["type"];
						document.getElementById('shdd_readspeed').innerHTML = shdd["readspeed"];
						document.getElementById('shdd_writes').innerHTML = shdd["writes"];
						document.getElementById('shdd_rpm').innerHTML = shdd["rpm"];

						getconf();
						
						shdd_rate_old = shdd_rate_new;
						shdd_rate_new = shdd["confrate"];					
						config_rate = config_rate-shdd_rate_old+shdd_rate_new;
						document.getElementById('notebro_rate').innerHTML=(Math.round(config_rate * 10) / 10).toFixed(1);
						
						shdd_bat_old = shdd_bat_new;
						shdd_bat_new = shdd["bat"];
						config_batlife=config_batlife-shdd_bat_old+shdd_bat_new;
						document.getElementById('bat_life1').innerHTML=hourminutes((parseFloat(acum["cap"])/config_batlife)*0.95);
						document.getElementById('bat_life2').innerHTML=hourminutes((parseFloat(acum["cap"])/config_batlife)*1.02);						
					}
				}
			}
		}
		xmlhttp.open("GET","model/lib/php/query/shdd.php?q="+str,true);
		xmlhttp.send();
	}
}

var mdb = {}; var mdb_price_old=0; var mdb_price_new=0; var mdb_err_new=0; var mdb_err_old=0; var mdb_rate_new=0; var mdb_rate_old=0;
function showMDB(str) 
{
	if (str === "") 
	{
		mdb = {};
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
				mdb = JSON.parse(xmlhttp.responseText);
				
				document.getElementById('mdb_ram').innerHTML = mdb["ram"];
				document.getElementById('mdb_gpu').innerHTML = mdb["gpu"];
				document.getElementById('mdb_chipset').innerHTML = mdb["chipset"];
				document.getElementById('mdb_interface').innerHTML = mdb["interface"];
				document.getElementById('mdb_netw').innerHTML = mdb["netw"];
				document.getElementById('mdb_hdd').innerHTML = mdb["hdd"];
				document.getElementById('mdb_misc').innerHTML = mdb["msc"];
				
				mdb_rate_old = mdb_rate_new;
				mdb_rate_new = mdb["confrate"];

				getconf();
				
				config_rate = config_rate-mdb_rate_old+mdb_rate_new;
				document.getElementById('notebro_rate').innerHTML=(Math.round(config_rate * 10) / 10).toFixed(1);
			}
		}
		xmlhttp.open("GET","model/lib/php/query/mdb.php?q="+str,true);
		xmlhttp.send();
	}
}

var mem = {}; var mem_price_old=0; var mem_price_new=0; var mem_err_new=0; var mem_err_old=0; var mem_rate_new=0; var mem_rate_old=0;
function showMEM(str) 
{
	if (str === "") 
	{
		mem = {};
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
				mem = JSON.parse(xmlhttp.responseText);
				document.getElementById('mem_title').innerHTML = mem["cap"]+"GB "+mem["type"];
				document.getElementById('mem_stan').innerHTML = mem["stan"];
				document.getElementById('mem_type').innerHTML = mem["type"];
				document.getElementById('mem_lat').innerHTML = mem["lat"];
				document.getElementById('mem_freq').innerHTML = mem["freq"];
				document.getElementById('mem_misc').innerHTML = mem["msc"];

				mem_rate_old = mem_rate_new;
				mem_rate_new = mem["confrate"];

				getconf();
				
				config_rate = config_rate-mem_rate_old+mem_rate_new;
				document.getElementById('notebro_rate').innerHTML=(Math.round(config_rate * 10) / 10).toFixed(1);
				
				googlelink["mem"]=mem["cap"]+"GB";
				makelinks();
			}
		}
		xmlhttp.open("GET","model/lib/php/query/mem.php?q="+str,true);
		xmlhttp.send();
	}
}

var odd = {}; var odd_price_old=0; var odd_price_new=0; var odd_err_new=0; var odd_err_old=0; var odd_rate_new=0; var odd_rate_old=0; var odd_gpu=0;
function showODD(str) 
{
	if (str === "") 
	{
		odd = {};
		return;
	}
	else 
	{
		if (window.XMLHttpRequest) 
		{
			var	xmlhttp = new XMLHttpRequest();

			xmlhttp.onreadystatechange = function() 
			{
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
				{
					odd = JSON.parse(xmlhttp.responseText);
					if((odd["type"]).toUpperCase()!="NONE") { document.getElementById('odd_title').innerHTML = ", "+odd["type"]; } else { document.getElementById('odd_title').innerHTML = ""; }
					if(odd["speed"] && odd["speed"]!=0){document.getElementById('odd_speed').innerHTML = odd["speed"]};
					if(odd["msc"] && odd["msc"]!="-"){document.getElementById('odd_misc').innerHTML = odd["msc"];}

					odd_rate_old = odd_rate_new;
					odd_rate_new = odd["confrate"];

					getconf();
					
					config_rate = config_rate-odd_rate_old+odd_rate_new;
					document.getElementById('notebro_rate').innerHTML=(Math.round(config_rate * 10) / 10).toFixed(1);
				}
			}
			xmlhttp.open("GET","model/lib/php/query/odd.php?q="+str,true);
			xmlhttp.send();
		}
	}
}

var acum = {}; var acum_price_old=0; var acum_price_new=0; var acum_err_new=0; var acum_err_old=0; var acum_rate_new=0; var acum_rate_old=0; var acum_gpu=0;
function showACUM(str) 
{
	if (str === "") 
	{
		acum = {};
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
				acum = JSON.parse(xmlhttp.responseText);
				
				document.getElementById('acum_cell').innerHTML = acum["nrc"];
				document.getElementById('acum_tipc').innerHTML = acum["tipc"];
				voltage=parseFloat(acum["volt"]); weight=parseFloat(acum["weight"]);
				if(!isNaN(voltage) && voltage>0) { document.getElementById('acum_volt').innerHTML=voltage+" V"; } else { document.getElementById('acum_volt').innerHTML="-"; }
				if(!isNaN(weight)&& weight>0) { document.getElementById('acum_weight').innerHTML = weight+"Kg ("; document.getElementById('acum_weight_i').innerHTML = (weight*2.20462262).toFixed(2)+" lb)"; }
				else{ document.getElementById('acum_weight').innerHTML = "-";}
				
				document.getElementById('acum_misc').innerHTML = acum["msc"];

				getconf();
				
				acum_rate_old = acum_rate_new;
				acum_rate_new = acum["confrate"];
				config_rate = config_rate-acum_rate_old+acum_rate_new;
				document.getElementById('notebro_rate').innerHTML=(Math.round(config_rate * 10) / 10).toFixed(1);
				
				document.getElementById('bat_life1').innerHTML=hourminutes((parseFloat(acum["cap"])/config_batlife)*0.95);
				document.getElementById('bat_life2').innerHTML=hourminutes((parseFloat(acum["cap"])/config_batlife)*1.02);	
			}
		}
		xmlhttp.open("GET","model/lib/php/query/acum.php?q="+str,true);
		xmlhttp.send();
	}
}

var chassis = {}; var chassis_price_old=0; var chassis_price_new=0; var chassis_err_new=0; var chassis_err_old=0; var chassis_rate_new=0; var chassis_rate_old=0; var chassis_gpu=0;
function showCHASSIS(str) 
{
	if (str === "") 
	{
		chassis = {};
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
				chassis = JSON.parse(xmlhttp.responseText);
				
				if(chassis["pi"]!=="") { document.getElementById('chassis_pi').innerHTML = chassis["pi"]; }
				else { document.getElementById('chassis_pi').innerHTML = "-"; }
				if(chassis["vi"]!=="") { document.getElementById('chassis_vi').innerHTML = chassis["vi"]; }
				else { document.getElementById('chassis_vi').innerHTML = "-"; }
			
				if(chassis["web"]!="None"){document.getElementById('chassis_web').innerHTML = chassis["web"]+" MP";}else{document.getElementById('chassis_web').innerHTML = chassis["web"];}
				document.getElementById('chassis_touch').innerHTML = chassis["touch"];
				document.getElementById('chassis_charger').innerHTML = chassis["charger"];
				document.getElementById('chassis_weight').innerHTML = chassis["weight"];
				document.getElementById('chassis_thic').innerHTML = (chassis["thic"]/10).toFixed(1);;
				document.getElementById('chassis_depth').innerHTML = (chassis["depth"]/10).toFixed(1);;
				document.getElementById('chassis_width').innerHTML = (chassis["width"]/10).toFixed(1);;
				
				if(chassis["color"]!=="") { document.getElementById('chassis_color').innerHTML = chassis["color"]; }
				else { document.getElementById('chassis_color').innerHTML = "-"; }
			
				document.getElementById('chassis_material').innerHTML = chassis["made"];
				document.getElementById('chassis_misc').innerHTML = chassis["msc"];
				document.getElementById('chassis_keyboard').innerHTML = chassis["keyboard"];

				document.getElementById('chassis_weight_i').innerHTML = (chassis["weight"]*2.20462262).toFixed(2);
				document.getElementById('chassis_thic_i').innerHTML = (chassis["thic"]*0.0393700787).toFixed(2);
				document.getElementById('chassis_depth_i').innerHTML = (chassis["depth"]*0.0393700787).toFixed(2);
				document.getElementById('chassis_width_i').innerHTML = (chassis["width"]*0.0393700787).toFixed(2);

				chassis_rate_old = chassis_rate_new;
				chassis_rate_new = chassis["confrate"];
				
				getconf();
				
				config_rate = config_rate-chassis_rate_old+chassis_rate_new;
				document.getElementById('notebro_rate').innerHTML=(Math.round(config_rate * 10) / 10).toFixed(1);
			}
		}
		xmlhttp.open("GET","model/lib/php/query/chassis.php?q="+str,true);
		xmlhttp.send();
	}
}

var wnet = {}; var wnet_price_old=0; var wnet_price_new=0; var wnet_err_new=0; var wnet_err_old=0; var wnet_rate_new=0; var wnet_rate_old=0; var wnet_gpu=0;
function showWNET(str) 
{
	if (str === "") 
	{
		wnet = {};
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
				wnet = JSON.parse(xmlhttp.responseText);
				if(parseInt(wnet["speed"])!=0){document.getElementById('wnet_speed').innerHTML = wnet["speed"]+" Mbps";} else {document.getElementById('wnet_speed').innerHTML = "-";} 
				document.getElementById('wnet_stand').innerHTML = wnet["stand"];
				document.getElementById('wnet_slot').innerHTML = wnet["slot"];
				document.getElementById('wnet_misc').innerHTML = wnetmisc(wnet["msc"]);

				getconf();
				
				wnet_rate_old = wnet_rate_new;
				wnet_rate_new = wnet["confrate"];
			
				config_rate = config_rate-wnet_rate_old+wnet_rate_new;
				document.getElementById('notebro_rate').innerHTML=(Math.round(config_rate * 10) / 10).toFixed(1);
			}
		}
		xmlhttp.open("GET","model/lib/php/query/wnet.php?q="+str,true);
		xmlhttp.send();
	}
}
	
var war = {}; var war_price_old=0; var war_price_new=0; var war_err_new=0; var war_err_old=0; var war_rate_new=0; var war_rate_old=0; var war_gpu=0;
function showWAR(str) 
{
	if (str === "") 
	{
		war = {};
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
				war = JSON.parse(xmlhttp.responseText);
				document.getElementById('war_misc').innerHTML = war["msc"];

				war_rate_old = war_rate_new;
				war_rate_new = war["confrate"];

				getconf();
				config_rate = config_rate-war_rate_old+war_rate_new;
				document.getElementById('notebro_rate').innerHTML=(Math.round(config_rate * 10) / 10).toFixed(1);
			}
		}
		xmlhttp.open("GET","model/lib/php/query/war.php?q="+str,true);
		xmlhttp.send();
	}
}
	
var sist = {}; var sist_price_old=0; var sist_price_new=0; var sist_err_new=0; var sist_err_old=0; var sist_rate_new=0; var sist_rate_old=0; var sist_gpu=0;
function showSIST(str) 
{
	if (str === "") 
	{
		sist = {};
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
				sist = JSON.parse(xmlhttp.responseText);
				if(sist["vers"]==0){sist["vers"]="";}
				if(sist["sist"].localeCompare("No OS")!=0)
				{ document.getElementById('sist_title').innerHTML = ", "+sist["sist"]+" "+sist["vers"]+" "+sist["type"]; googlelink["sist"]=sist["sist"]; }
				else
				{ googlelink["sist"]=""; }

				sist_rate_old = sist_rate_new;
				sist_rate_new = sist["confrate"];

				getconf();
				
				config_rate = config_rate-sist_rate_old+sist_rate_new;
				document.getElementById('notebro_rate').innerHTML=(Math.round(config_rate * 10) / 10).toFixed(1);
				makelinks();
			}
		}
		xmlhttp.open("GET","model/lib/php/query/sist.php?q="+str,true);
		xmlhttp.send();
	}
}

function getconf(str) 
{
	if (mid===undefined || cpu["id"]===undefined || display["id"]===undefined || mem["id"]===undefined || hdd["id"]===undefined || shdd["id"]===undefined || gpu["id"]===undefined || wnet["id"]===undefined || odd["id"]===undefined || mdb["id"]===undefined || chassis["id"]===undefined || acum["id"]===undefined || war["id"]===undefined || sist["id"]===undefined)
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
				confdata["cprice"]=parseInt(confdata["cprice"]);
				confdata["cerr"]=parseInt(confdata["cerr"]);
				document.getElementById('config_price1').innerHTML=parseInt((confdata["cprice"]-confdata["cerr"]/2)*exch);
				document.getElementById('config_price2').innerHTML=parseInt((confdata["cprice"]+confdata["cerr"]/2)*exch);
				var stateObj = { no: "empty" };
				history.replaceState(stateObj, confdata["cid"], "?model/model.php?conf="+confdata["cid"]);
				currentPage = window.location.href;
			}		
		}
	}
		xmlhttp.open("GET","model/lib/php/query/getconf.php?c="+mid+"-"+cpu["id"]+"-"+display["id"]+"-"+mem["id"]+"-"+hdd["id"]+"-"+shdd["id"]+"-"+gpu["id"]+"-"+wnet["id"]+"-"+odd["id"]+"-"+mdb["id"]+"-"+chassis["id"]+"-"+acum["id"]+"-"+war["id"]+"-"+sist["id"],true);
		xmlhttp.send();
}

function cpumisc(str) 
{
	var msc_el = str.split(","); var msc="";
	var text1='<span class="toolinfo" toolid="';
	var text2='" load="1" data-html="true" data-toggle="tooltip" data-delay='+"'"+'{"show": 600}'+"'"+' data-placement="top" data-original-title="Loading..."><span class="toolinfo1">';
	var text3='</span></span>';

	var i, value;
	for (i = 0; i < msc_el.length; ++i)
	{
		value = msc_el[i];
		value = $.trim(value);

		if(value.match("SSE")){ msc=msc+text1+"10"+text2+value+", "+text3; }
		if(value.match("64")) { msc=msc+text1+"11"+text2+value+", "+text3; }
		if(value.match("AVX")) { if(value.match("AVX 2.0")) { msc=msc+text1+"13"+text2+value+", "+text3; } else { msc=msc+text1+"12"+text2+value+", "+text3; }}
		if(value.match("HT") || value.match("Hyper-threading")) {	msc=msc+text1+"15"+text2+value+", "+text3; }
		if(value.match("VT-x") || value.match("AMD-V")) { msc=msc+text1+"16"+text2+value+", "+text3; }
		if(value.match("VT-d") || value.match("AMD-Vi")) { msc=msc+text1+"17"+text2+value+", "+text3; }
		if(value.match("VT-c")) { msc=msc+text1+"18"+text2+value+", "+text3; }
		if(value.match("TBT") || value.match("Turbo Boost") || value.match("TC") || value.match("BPT")) { msc=msc+text1+"19"+text2+value+", "+text3; }
	}
	msc  = msc.substr(0, (msc.length - 9)) + msc.substr((msc.length - 8) + 1);	
	return msc;
}
	
function gpumisc(str) 
{
	var msc_el = str.split(",");
	var msc="";

	var text1='<span class="toolinfo" toolid="';
	var text2='" load="1" data-html="true" data-toggle="tooltip" data-delay='+"'"+'{"show": 600}'+"'"+' data-placement="top" data-original-title="Loading..."><span class="toolinfo1">';
	var text3='</span></span>';

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
		{ msc=msc+"<span>"+value+"</span>"+", "; }
	}
	msc  = msc.substr(0, (msc.length -2));	
	return msc;
}

function wnetmisc(str) 
{
	var msc_el = str.split(",");
	var msc="";
	var text1='<span class="toolinfo" toolid="';
	var text2='" load="1" data-html="true" data-toggle="tooltip" data-delay='+"'"+'{"show": 600}'+"'"+' data-placement="top" data-original-title="Loading..."><span class="toolinfo1">';
	var text3='</span></span>';
	var i, value;

	for (i = 0; i < msc_el.length; ++i)
	{
		value = msc_el[i];
		value = $.trim(value);
		if(value.indexOf("Bluetooth")>=0){ msc=msc+text1+"78"+text2+value+text3+", "; } else 
		if((value.indexOf("Wireless Display")>=0)||(value.indexOf("Wireless Display")>=0)){ msc=msc+text1+"79"+text2+value+text3+", "; } else
		{ msc=msc+"<span>"+value+"</span>"+", "; }
	}

	msc  = msc.substr(0, (msc.length -2));	
	return msc;
}

function hourminutes(str)
{
	str=parseFloat(str);
	hours=parseInt(str);
	minutes=Math.round((((str-hours)*60)/5),0)*5;
	if(minutes<10){zero="0";}else{zero="";}
	return hours+":"+zero+minutes;
}

function makelinks()
{
	hotlinkpart1=mfamily+"+"+mmodel+"+"+googlelink["cpu"]+"+"+googlelink["mem"]+"+"+googlelink["gpu"].replace(" ","+");
	if(mprod.localeCompare("Apple")==0)	{ hotlinkpart1=mprod+"+"+mfamily+"+"+googlelink["cpu"]+"+"+googlelink["mem"]+"+"+googlelink["gpu"].replace(" ","+"); }
	if(mprod.localeCompare("Clevo")==0) { hotlinkpart1=mprod+"+"+mmodel+"+"+googlelink["cpu"]+"+"+googlelink["mem"]+"+"+googlelink["gpu"].replace(" ","+"); }
	hotlinkpart1=hotlinkpart1.replace("++","+");
	hotlink=countrybuy+"+"+hotlinkpart1+'+'+googlelink["resolution"]+'+'+googlelink["sist"];
	hotlink=hotlink.replace("++","+"); hotlink=hotlink.replace('+""+','+');
	document.getElementById('google_link').href=googlelink["first"]+"+"+hotlink;
	document.getElementById('bing_link').href=binglink["first"]+"+"+hotlink;
	document.getElementById('amazon_link').href=amazonlink["first"]+hotlinkpart1;
}