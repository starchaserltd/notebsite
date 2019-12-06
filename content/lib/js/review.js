var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("demo");
  var captionText = document.getElementById("caption");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  if(slides[slideIndex-1]!==undefined&&slides[slideIndex-1]!==null){ slides[slideIndex-1].style.display = "block"; }
  if(dots[slideIndex-1]!==undefined&&dots[slideIndex-1]!==null)
  {
	dots[slideIndex-1].className += " active";
	captionText.innerHTML = dots[slideIndex-1].alt;
  }
}

jQuery('.tabs .tab-links a').on('click', function(e)
{
	sessionStorage["reviewtab"]=jQuery(this).attr('href');
	change_review_tab(sessionStorage["reviewtab"]);
	e.preventDefault();
});

function change_review_tab(tab)
{
	// Show/Hide Tabs
	jQuery('.tabs '+tab).slideDown(400).siblings().slideUp(400);
	// Change/remove current tab to active
	jQuery(tab+"m").parent('li').addClass('active').siblings().removeClass('active');
}

