function compatibility_old_search_var(last_search={})
{
	var to_return=last_search;
	if(last_search['cpu']!==undefined)
	{
		if(last_search['cpu']['launchdatemin']!==undefined){ last_search['cpu']['cpu_ldatemin']=last_search['cpu']['launchdatemin']; }
		if(last_search['cpu']['launchdatemax']!==undefined){ last_search['cpu']['cpu_ldatemax']=last_search['cpu']['launchdatemax']; }
		if(last_search['cpu']['nrcoresmin']!==undefined){ last_search['cpu']['cpu_coremin']=last_search['cpu']['nrcoresmin']; }
		if(last_search['cpu']['nrcoresmax']!==undefined){ last_search['cpu']['cpu_coremax']=last_search['cpu']['nrcoresmax']; }
		if(last_search['cpu']['cputdpmin']!==undefined){ last_search['cpu']['cpu_tdpmin']=last_search['cpu']['cputdpmin']; }
		if(last_search['cpu']['cputdpmax']!==undefined){ last_search['cpu']['cpu_tdpmax']=last_search['cpu']['cputdpmax']; }
		if(last_search['cpu']['cpufreqmin']!==undefined){ last_search['cpu']['cpu_freqmin']=last_search['cpu']['cpufreqmin']; }
		if(last_search['cpu']['cpufreqmax']!==undefined){ last_search['cpu']['cpu_freqmax']=last_search['cpu']['cpufreqmax']; }
		if(last_search['cpu']['cputechmin']!==undefined){ last_search['cpu']['cpu_techmin']=last_search['cpu']['cputechmin']; }
		if(last_search['cpu']['cputechmax']!==undefined){ last_search['cpu']['cpu_techmax']=last_search['cpu']['cputechmax']; }
	}
	
	if(last_search['model']!==undefined)
	{
		if(last_search['model']['bdgminadv']!==undefined){ last_search['model']['model_pricemin']=last_search['model']['bdgminadv']; }
		if(last_search['model']['bdgmaxadv']!==undefined){ last_search['model']['model_pricemax']=last_search['model']['bdgmaxadv']; }
		
		
	}
	
	if(last_search['gpu']!==undefined)
	{
		if(last_search['gpu']['gpulaunchdatemin']!==undefined){ last_search['gpu']['gpu_launchdatemin']=last_search['gpu']['gpulaunchdatemin']; }
		if(last_search['gpu']['gpulaunchdatemax']!==undefined){ last_search['gpu']['gpu_launchdatemax']=last_search['gpu']['gpulaunchdatemax']; }
		if(last_search['gpu']['gpubusmin']!==undefined){ last_search['gpu']['gpu_busmin']=last_search['gpu']['gpubusmin']; }
		if(last_search['gpu']['gpubusmax']!==undefined){ last_search['gpu']['gpu_busmax']=last_search['gpu']['gpubusmax']; }
		if(last_search['gpu']['gpupowermin']!==undefined){ last_search['gpu']['gpu_powermin']=last_search['gpu']['gpupowermin']; }
		if(last_search['gpu']['gpupowermax']!==undefined){ last_search['gpu']['gpu_powermax']=last_search['gpu']['gpupowermax']; }
		if(last_search['gpu']['gpumemmin']!==undefined){ last_search['gpu']['gpu_memmin']=last_search['gpu']['gpumemmin']; }
		if(last_search['gpu']['gpumemmax']!==undefined){ last_search['gpu']['gpu_memmax']=last_search['gpu']['gpumemmax']; }
		
	}
	if(last_search['display']!==undefined)
	{
		if(last_search['display']['displaymin']!==undefined){ last_search['display']['display_sizemin']=last_search['display']['displaymin']; }
		if(last_search['display']['displaymax']!==undefined){ last_search['display']['display_sizemax']=last_search['display']['displaymax']; }
		if(last_search['display']['verresmin']!==undefined){ last_search['display']['display_vresmin']=last_search['display']['verresmin']; }
		if(last_search['display']['verresmax']!==undefined){ last_search['display']['display_vresmax']=last_search['display']['verresmax']; }
		
		
	}
	if(last_search['hdd']!==undefined)
	{
		if(last_search['hdd']['capacitymin']!==undefined){ last_search['hdd']['hdd_capmin']=last_search['hdd']['capacitymin']; }
		if(last_search['hdd']['capacitymax']!==undefined){ last_search['hdd']['hdd_capmax']=last_search['hdd']['capacitymax']; }
		
		
		
	}
	
	return to_return;
}

//# sourceURL=old_var_proc.js