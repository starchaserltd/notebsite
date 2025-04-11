$(document).ready(function() {
	firstcompare=0;
  //tooltip
	$('[data-toggle="tooltip"]').tooltip();
	actbtn("SEARCH");	
	//Dropdown add to compare
	$('.addtocpmp').on('click', function() {
		$('.compareDropdown').css('display', 'block');
	    $('.compareDropdown ul li').addClass('open');
	    $('.compareDropdown ul li ul').slideDown();	    
	    $('.navbar-collapse').slideDown("slow");	 
	    $("#howToUse").css('display', 'none');   
	});
	
	document.title = 'Noteb - Search results';
   	$('meta[name=description]').attr('content', "Search results.");
	
	var setparams = {};
	var search_submit_params=[];
	if(last_search===undefined)
	{
		setparams=get_url_params();
		for(var value of setparams.entries()) { search_submit_params.push({"name":value[0], "value":value[1]}); }
		var last_search=compatibility_old_search_var(proc_search_param_to_array(search_submit_params));
		setCookie('last_search',JSON.stringify(last_search),10);
	}
	if(currentPage.indexOf("advsearch=1")>=0 && currentPage.indexOf("?search/search.php")>=0)
	{ searchurl=currentPage.replace(siteroot+"?search/search.php?",""); }
});

//# sourceURL=results.js