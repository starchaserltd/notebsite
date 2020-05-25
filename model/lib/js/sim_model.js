function f_sim_cpu()
{
	var component=[]; var range=1;
	component.min_rating=0; component.max_rating=1000;
	if(cpu.rating!=null&&cpu.rating!=undefined){ range=0.15; component.min_rating=noteb_round(cpu.rating*(1-range),4); component.max_rating=noteb_round(cpu.rating*(1+range+0.05),4); }
		
	component.min_tdp=0; component.max_tdp=999;
	if(cpu.tdp!=null&&cpu.tdp!=undefined){ range=0.35; component.min_tdp=noteb_round(cpu.tdp*(1-range),2); component.max_tdp=noteb_round(cpu.tdp*(1+range),2); if(cpu.rating>65&&cpu.tdp>=45){component.max_tdp=component.max_tdp*2;}}

	return component;
}

function f_sim_gpu()
{
	var component=[]; var range=1;
	component.min_rating=0; component.max_rating=1000; component.type=null;
	if(gpu.typegpu!=null&&gpu.typegpu!=undefined)
	{
		component.type=gpu.typegpu;
		if(gpu.rating!=null&&gpu.rating!=undefined){ range=0.15; component.rating=gpu.rating; component.min_rating=noteb_round(gpu.rating*(1-range),4); component.max_rating=noteb_round(gpu.rating*(1+range),4); }
		if(gpu.typegpu>0)
		{  component.max_rating=component.max_rating; }
		else
		{  component.max_rating=100; }
	}
		
	return component;
}

function f_storage()
{
	var component=[]; var range=1;
	component.cap=0; component.mincap=0; component.maxcap=100000; component.type=null;
	
	if(hdd.cap!=null&&hdd.cap!=undefined){component.cap=hdd.cap;}
	if(shdd.cap!=null&&shdd.cap!=undefined){component.cap=component.cap+shdd.cap;}
	if(hdd.type!=null&&hdd.type!=undefined)
	{
		if((hdd.type="SSD")||(hdd.type=="EMMC"))
		component.type="&typehdd[]=SSD&typehdd[]=EMMC";
	}
	if(component.cap>0){ range=0.35; component.mincap=noteb_round(component.cap*(1-range),2); if(component.cap<1100){ component.maxcap=noteb_round(component.cap*(1+1.1),2); } else { component.maxcap=noteb_round(component.cap*(1+range),2); } }
		
	return component;
}

function f_sim_display()
{
	var component=[]; var range=1;
	component.minvres=0; component.minsize=0; component.maxsize=50; component.minsrgb=50; component.type=null; component.minhz=50;
	//DISPLAY_msc_id[]=240Hz
	if(display.vres!=null&&display.vres!=undefined){ range=0; component.minvres=parseInt(display.vres*(1-range)); }
	if(display.sRGB!=null&&display.sRGB!=undefined){ if(parseInt(display.sRGB)>=80){ component.sRGB="&DISPLAY_msc_id[]=80% sRGB or better";}else{component.sRGB="";} }
	if(display.hz!=null&&display.hz!=undefined){ if(parseInt(display.hz)>60){ component.hz="&DISPLAY_msc_id[]="+display.hz+"Hz";}else{component.hz="";} }
	if(display.size!=null&&display.size!=undefined){ range=0.05; component.minsize=noteb_round(display.size*(1-range),1); component.maxsize=noteb_round(display.size*(1+range),1); }
	return component;
}

function f_sim_mem()
{
	var component=[]; var range=1; component.cap=0; component.mincap=0; component.maxcap=100000;
	if(mem.cap!=null&&mem.cap!=undefined){component.cap=mem.cap;}
	if(component.cap>0){ range=0.35; if(component.cap>4){ component.mincap=noteb_round(component.cap*(1-range),2); }else{component.mincap=component.cap;}  component.maxcap=noteb_round(component.cap*(1+range),2); }
		
	return component;
}

function f_sim_chassis()
{
	var component=[]; var range=1; component.minweight=0; component.maxweight=0; component.minthic=0; component.maxthic=0; component.twoinone="";
	if(chassis.weight!=null&&chassis.weight!=undefined){ range=0.25; component.minweight=noteb_round(chassis.weight*(1-range),2); component.maxweight=noteb_round(chassis.weight*(1+range),2); }
	if(chassis.thic!=null&&chassis.thic!=undefined){ range=0.5; component.minthic=noteb_round(chassis.thic*(1-range),2); component.maxthic=noteb_round(chassis.thic*(1+range),2); }
	if(chassis.twoinone!=null&&chassis.twoinone!=undefined){ if(chassis.twoinone==1){component.twoinone="&twoinone-yes=on";} }
	
	return component;
}

function f_sim_os()
{
	var component=[]; var range=1; component.type=0;
	if(sist.sist!=null&&sist.sist!=undefined){if(sist.id!=999){component.getos=1;}else{component.getos=0;}}
	return component;
}

function similar_model_search() 
{
	var sim_exch="USD"; var sim_failer=0; var price=0; var range=0; var key=null;
	if(model_ex!=null&&model_ex!=undefined){sim_exch=model_ex;}
	if(document.getElementById("config_price1")!=null){price=(parseInt(document.getElementById("config_price1").innerText)+parseInt(document.getElementById("config_price2").innerText))/2;}else{sim_failer=1;}
	if(config_batlife!=null&&config_batlife!=undefined){ var batlife=acum.cap/config_batlife; range=0.25; sim_minbat=noteb_round(batlife*(1-range),2); sim_maxbat=noteb_round(batlife*(1+range),2);}
	if(document.getElementById('dLabel').dataset.buyregions!=null&&document.getElementById('dLabel').dataset.buyregions!=undefined&&document.getElementById('dLabel').dataset.buyregions!="")
	{ var sim_regions=document.getElementById('dLabel').dataset.buyregions.split(","); }
	else
	{ var sim_regions=[1];}
	var sim_display=f_sim_display(); if(sim_display.minvres<1){sim_failer=1;}
	var sim_cpu=f_sim_cpu(); if(sim_cpu.max_tdp>900){sim_failer=1;}
	var sim_gpu=f_sim_gpu(); if(sim_gpu.max_rating>900){sim_failer=1;}
	var sim_stor=f_storage(); if(sim_stor.cap<1){sim_failer=1;}
	var sim_mem=f_sim_mem(); if(sim_mem.cap<1){sim_failer=1;}
	var sim_chassis=f_sim_chassis(); if(sim_chassis.maxweight<1){sim_failer=1;}
	var sim_os=f_sim_os();
	
	if(!sim_failer)
	{
		if (window.XMLHttpRequest) 
		{ var	xmlhttp = new XMLHttpRequest(); }
	
		xmlhttp.onreadystatechange = function() 
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200 )
			{
				var query_data=JSON.parse(xmlhttp.responseText);
				//console.log(query_data);
				var family_search_string="";
				if(query_data.family_type!=null&&query_data.family_type!=undefined)
				{ family_search_string="Family_fam[]="+query_data.family_type+"&"; }
				var regions_search_string="";
				if(query_data.regions!=null&&query_data.regions!=undefined)
				{
					for (key in query_data.regions)
					{ regions_search_string=regions_search_string+"Regions[]="+query_data.regions[key]["region_name"]+"&"; }
				}
				var cpu_search_string="";
				for (key in query_data.cpu)
				{ cpu_search_string=cpu_search_string+"CPU_model_id[]="+query_data.cpu[key]["cpu_model"]+"&"; }
				var gpu_search_string="";
				for (key in query_data.gpu)
				{ gpu_search_string=gpu_search_string+"GPU_model_id[]="+query_data.gpu[key]["gpu_model"]+"&"; }
				for (key in query_data.gputype2)
				{ gpu_search_string=gpu_search_string+"gputype2[]="+query_data.gputype2[key]+"&"; }
				gpu_search_string=gpu_search_string+"gputype="+query_data.gputype+"&";
				range=0.35; var price_min=parseInt(price*(1-range)); var price_max=parseInt(price*(1+range));
				var search_string="search/search.php?advsearch=1&"+family_search_string+regions_search_string+cpu_search_string+gpu_search_string+"verresmin="+sim_display.minvres+"&displaymin="+sim_display.minsize+"&displaymax="+sim_display.maxsize+sim_display.sRGB+sim_display.hz;
				search_string=search_string+"&capacitymax="+sim_stor.maxcap+"&capacitymin="+sim_stor.mincap+sim_stor.type+"&rammin="+sim_mem.mincap+"&rammax="+sim_mem.maxcap+"&batlifemin="+sim_minbat+"&batlifemax="+sim_maxbat;
				search_string=search_string+"&weightmin="+sim_chassis.minweight+"&weightmax="+sim_chassis.maxweight+"&thicmin="+sim_chassis.minthic+"&thicmax="+sim_chassis.maxthic;
				
				var os_search_string="";
				if(query_data.os!=null&&query_data.os!=undefined)
				{
					for (key in query_data.os)
					{ os_search_string=os_search_string+"&opsist[]="+query_data.os[key]["os_model"]; }
				}
				search_string=search_string+os_search_string+"&bdgminadv="+price_min+"&bdgmaxadv="+price_max+"&exchadv="+sim_exch+"&sort_by=value";
				OpenPage(search_string,event);
			}
		}
		var cpu_string_q="";
		for (key in sim_cpu)
		{ cpu_string_q=cpu_string_q+"&cpu_"+key+"="+sim_cpu[key];}
	
		var gpu_string_q="";
		for (key in sim_gpu)
		{ gpu_string_q=gpu_string_q+"&gpu_"+key+"="+sim_gpu[key]; }
	
		var os_string_q=""; os_string_q="&get_os_list="+sim_os.getos;
		var m_family_q=""; m_family_q="&m_family="+mid;
		var regions_q=""; for(key in sim_regions){ regions_q=regions_q+"&regions_id[]="+sim_regions[key]; }
		
		xmlhttp.open("GET","model/lib/php/query/similar.php?q=1"+cpu_string_q+gpu_string_q+os_string_q+m_family_q+regions_q,true);
		xmlhttp.send(); all_requests.push(xmlhttp);
	}
	else
	{ console.log("Missing critical parameters for similar search.");}
}