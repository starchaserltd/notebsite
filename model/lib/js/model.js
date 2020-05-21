var cleantips = 1;
var allshow = 0; var gpu_pixel_offset=0; var maxwidth=0; var gpu_select_open=1;

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

var comp_open=false; var d_comp_open=false; var mousedown=false; var org_display=[];
function isOpen()
{
	if(comp_open){ $('#GPU').css({'transform': 'translateX(0px)', 'width': maxwidth+'px'}); }
	else{ setTimeout(function(){ $('#GPU').css({'transform': 'translateX(-'+gpu_pixel_offset+'px)', 'width': (maxwidth+gpu_pixel_offset)+'px'}); }, 100); }
}

$('select[id$="GPU"]')
	.mousedown( function(){ mousedown=true; comp_open=!comp_open; isOpen(); })
	.click( function(){ if(!mousedown) { comp_open=!comp_open; isOpen(); } else{ mousedown=false; }})
	.blur(function() { if(comp_open){ comp_open=!comp_open; isOpen(); }})
$(document).keyup(function(e){ if (e.keyCode == 27) { if(comp_open){ comp_open=!comp_open; isOpen(); }}});

//Open add to compare when you add a laptop
$('#addcompare').on('click', function()
{
	$('.compareDropdown').css('display', 'block');
	$('.compareDropdown ul li').addClass('open');
	$('.compareDropdown ul li ul').slideDown();
});

//Add text indent on GPU select
$('#addcompare').click(function(e)
{
	if(gocomp)
	{		
		e.preventDefault();
		e.stopPropagation();
		addcompare();
	}
	else
	{ window.setTimeout($('#addcompare').click(), 100); }	
	$("#howToUse").css('display', 'none');
});
 
const togglerInfoButtons = $('.toggler.toolinfo .toolinfo-text');
$(".toggler").click(function(e){
	e.preventDefault();
	
	if($(this).attr('data-hide')=="all")
	{
		if(allshow)
		{
			$('.hide'+$(this).attr('data-hide')).slideUp(200);
			$this=$('.toggler');
			allshow=0;
			$('.expandContainer .detailsArrow').removeClass('resize');
			togglerInfoButtons.text('More Specs')

		}
		else {
			$('.hide'+$(this).attr('data-hide')).slideDown(200);	
			$this=$('.toggler');
			allshow=1;
			$('.expandContainer .detailsArrow').addClass('resize');
			togglerInfoButtons.text('Show less specs')
		}	
	}
	else
	{
		$('.hide'+$(this).attr('data-hide')).slideToggle(200);
		$this=$(this);
		const togglerInfoText = $this.children('.toolinfo-text');
		if($this.text().toLowerCase().indexOf("more") > -1)
		{ $this.children('.expandContainer .detailsArrow').addClass('resize'); togglerInfoText.text("Show less specs");  }
		else
		{ 
			if($this.text().toLowerCase().indexOf("less") > -1)
			{ $this.children('.expandContainer .detailsArrow').removeClass('resize'); togglerInfoText.text("More Specs"); }
		}
	}
});

// Function toggles bootstrap collapse based on window width.
function toggleCollapse($win)
{
	if ($win.width() < 768)
	{
		$('.hide-spec-in-mobile').removeClass('show'); // some spect need to be uncollapsed in mobile
	}
	else if ($win.width() >= 768)
	{  $('.collapse').addClass('show'); }
}

// Set progress bars size (to be called on document ready & resize)
function setProgressBarsSize()
{
	const svgElementsList = [...document.querySelectorAll('.rating-element .progress-container svg')];
	for (svgElement of svgElementsList)
	{
		const bars = [...svgElement.children];
		if (window.innerWidth < 767)
		{
			svgElement.setAttribute('viewBox', '0, 0, 190, 12'); svgElement.style.height = '12px';
			bars.forEach((bar, i) => { bar.setAttribute('height', '12'); bar.setAttribute('x', `${i * 16}`); });
		}
		else
		{
			svgElement.setAttribute('viewBox', '0, 0, 190, 20');
			svgElement.style.height = '20px';
			bars.forEach((bar, i) => { bar.setAttribute('height', '20'); bar.setAttribute('x', `${i * 19}`); });
		}
	}
}

// Color rating bars
function setProgressBarsRating(ratingElementsList)
{
	for (ratingElement of ratingElementsList)
	{
		const ratingElementValue = Number(ratingElement.querySelector('.progress-value').innerHTML);
		// dividing by 10 in order to transform the value to the same unit we use for the bars
		const ratingElementTransformedValue = ratingElementValue > 10 ? Math.round(ratingElementValue / 10) : Math.round(ratingElementValue);
		// should always have 10 bars since the rating system is 0-10
		const progressBarsList = ratingElement.querySelectorAll('svg rect');
		// get the number of currently colored bars
		const currentlyColoredBars = document.querySelectorAll('.colored-bar');
		// get the number of bars to color
		const barsToColor = [...progressBarsList].slice(0, ratingElementTransformedValue);

		if (currentlyColoredBars.length > barsToColor.length) {
			const barsToRemoveColoring = [...currentlyColoredBars].filter((bar) => !barsToColor.includes(bar));
			for (bar of barsToRemoveColoring) {
				bar.classList.remove('colored-bar');
			}
		} else {
			for (bar of barsToColor) {
				bar.classList.add('colored-bar') 
			}
		}
	}
};

//change icon for resize information model
$('.glyphicon-chevron-down').on('click', function() { $(this).toggleClass('resize'); });	
$('.showDetailsButton').on('click', function() { $(this).toggleClass('show'); });
$('#GPU').change(function() { gpu_right_align(); });