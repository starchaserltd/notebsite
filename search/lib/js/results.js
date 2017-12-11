$(document).ready(function() {
	$('.sameheight').matchHeight();
	firstcompare=0;
  //tooltip
	$('[data-toggle="tooltip"]').tooltip();
	actbtn("SEARCH");	
	//Dropdown add to compare
	$('.addtocpmp').on('click', function() {
	    $('.compareDropdown ul li').addClass('open');
	    $('.compareDropdown ul li ul').slideDown();
	    console.log('pressed');
	});
});