var cleantips = 1;
var allshow = 0;
$(document).ready(function () {  
//Add text indent on GPU select
function gpu_right_align()
{
	var el=$('#GPU option:selected');
	var el_text=$('#GPU option:selected').text();
	var nrchar=char_indent(el_text,15);
	if(el_text.length>0)
	{
		if(el_text.indexOf("Integrated")>=0)
		{
			$('#GPU').css({'transform': 'translateX(0)', 'min-width': '135px'});
			$('.gpuhddd form').css('border-left', '0');
		}
		else
		{
			$('#GPU').css({'transform': 'translateX(-'+parseInt(nrchar)+'px)', 'min-width': '235px'});
			$('.gpuhddd form').css('border-left', '1px solid');
		}
	}
}

function char_indent(str,maxlength)
{
	x=str.split(' '); var short_length=0;
	for(var i=x.length-1;i>=0;i--)
	{
		short_length+=x[i].length+1;
		if(short_length>=maxlength){ short_length-=(x[i].length+1); }
	}
	var el=document.getElementById("hiddenDiv");
	el.style.display="inline"; str="T"+str; el.innerHTML=str.substr(0,str.length-short_length);
	var pixels=el.offsetWidth*1; el.style.display="none";
	return pixels;
}

$(document).ready(function()
{
	$('#addcompare').click(function(e)
	{
		if(gocomp)
		{		
			e.preventDefault();
			e.stopPropagation();
			addcompare();
		}
		else
		{
			window.setTimeout($('#addcompare').click(), 100);
		}	
		$("#howToUse").css('display', 'none');
	});
	 
	$(".toggler").click(function(e){
		e.preventDefault();
		if($(this).attr('data-hide')=="all")
		{
			if(allshow)
			{
				$('.hide'+$(this).attr('data-hide')).slideUp(500);
				$this=$('.toggler');
				allshow=0; $('.glyphicon-chevron-down').removeClass('resize');
			}
			else
			{  $('.hide'+$(this).attr('data-hide')).slideDown(500);	$this=$('.toggler'); allshow=1; $('.glyphicon-chevron-down').addClass('resize'); }	
		}
		else
		{
			$('.hide'+$(this).attr('data-hide')).slideToggle(500);
			$this=$(this);
			if($this.text().toLowerCase().indexOf("more") > -1)
			{ $this.text("Show less details"); }
			else
			{ 
				if($this.text().toLowerCase().indexOf("less") > -1)
				{ $this.text("Show more details"); }
			}
		}
	});
	
	$(function()
	{
		$('.pics').on('click', function() 
		{
			$('.enlargeImageModalSource').attr('src', $(this).attr('src'));
			$('#enlargeImageModal').modal('show');
		});		
	});
	
	$(window).on('popstate', function()
	{
		$('.modal').modal('hide');
		$( ".modal-backdrop" ).remove();
		$( ".in" ).remove();
	});	

	gpu_right_align();
	/*DISQUE CODE*/
	/**
	* RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
	* LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables
	*/

	(function() { // DON'T EDIT BELOW THIS LINE
		if(window.disqusloaded)
		{
			var d = document; var s = d.createElement('script');
			disqusloaded=0;
			s.src = '//notebrointexim.disqus.com/embed.js';

			s.setAttribute('data-timestamp', +new Date());
			(d.head || d.body).appendChild(s);
		}
		else
		{
			DISQUS.reset({
				reload: true,
				config: window.disqus_config  
			});
		}
	})();
});


//Open add to compare when you add a laptop
$('#addcompare').on('click', function()
{
	$('.compareDropdown').css('display', 'block');
	$('.compareDropdown ul li').addClass('open');
	$('.compareDropdown ul li ul').slideDown();
});

//Laptop rating, price range, battery life affix
// if ($(window).width() >= 375) { $(".ptop").affix({ offset: { top: $(".modelImageContainer").outerHeight(true) + $(".modelHeader").outerHeight(true) + 170 }});}

//change icon for resize information model
$('.glyphicon-chevron-down').on('click', function() { $(this).toggleClass('resize'); });	
$('.showDetailsButton').on('click', function() { $(this).toggleClass('show'); });
$('#GPU').change(function() { gpu_right_align(); });

//Affix Bootstrap 4
	if ($(window).width() >= 375)
	{
		var top = $('.ptop').offset().top;
		$(window).scroll(function (event)
		{
			var y = $(this).scrollTop();
			if (y >= top) { $('.ptop').addClass('affix'); }
			else { $('.ptop').removeClass('affix'); }
		});
	}
 
});