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
	if(currentPage.indexOf("advsearch=1")>=0 && currentPage.indexOf("?search/search.php")>=0){ searchurl=currentPage.replace(siteroot+"?search/search.php?",""); }
});