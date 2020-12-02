$(document).ready(function() 
{
	const topContainerElement = document.querySelector('.top-container');
	$(function()
	{
		$('.pics').on('click', function() 
		{
			$('.enlargeImageModalSource').attr('src', $(this).attr('src'));
			$('#enlargeImageModal').modal('show');
		});		
	});
	
	$(window).on('popstate', function()	{ $('.modal').modal('hide'); $( ".modal-backdrop" ).remove(); $(".in").remove(); });
	
	lightbox.option({ 'resizeDuration': 200, 'fadeDuration' : 200, 'imageFadeDuration':200 });
    $('meta[name=description]').attr('content', mprod + ' ' + mfamily + ' ' + mmodel);
	async function model_execut_when_istime_2()
	{
		await await_until_function_1(_ => istime == 1);
		gpu_right_align();
	}
	model_execut_when_istime_2();

	//Affix Bootstrap 4
	if ($(window).width() >= 320)
	{
		var elementHeight = document.querySelector('.ptop').offsetHeight;
		var top = $('.ptop').offset().top + elementHeight;


		$(window).scroll(function (event)
		{
			var y = $(this).scrollTop() - (elementHeight / 2);
			if (y >= top)
			{
				$('.ptop').addClass('affix');
				topContainerElement.style.height = `${607}px`;
			}
			else
			{
				$('.ptop').removeClass('affix');
				topContainerElement.style.height = 'auto';
			}
		});
	}

    // Set collapsible appearance on window load;
    toggleCollapse($(window));

    // Toggle collapsibles on resize. Optional if you want 
    // to be able to show/hide on window resize.
    $(window).on('resize', function() {	
		var $win = $(this); 
		toggleCollapse($win); 
		setProgressBarsSize(); 
	});
	
	// need the timeout in order to wait for the rating values to be set
	setProgressBarsSize();
	const ratingElementsList = document.querySelectorAll('.rating-element .progress-container');

	var old_rating=-100;
	var set_rating_timer = setInterval(function(){if(old_rating!=config_rate){old_rating=config_rate;}else{setProgressBarsRating(ratingElementsList); clearInterval(set_rating_timer); set_rating_timer = false;}}, 350);
	
	//OWL MODAL CAROUSEL
	let owl = $("#model-carousel").owlCarousel({ items: 1, loop: true, responsive: { 0: { dots: true}, 768: { dotsData: true } } });
	
	$('.owl-dot').click(function() { owl.trigger('to.owl.carousel', [$(this).index(), 1000]); })
	
	$('.firstImageModel').on('click', function () {
		showNotification('model-gallery', null,  null, $(this));
	});

	$('#notificationsModal').on('click', function (e) {
		if ($(this).hasClass('galleryModal')) {
			var modal = $(this).find('.modal-body');
			var isNext = e.target.classList.contains('nextImage');
			var isPrev = e.target.classList.contains('prevImage');
			var picElement = document.querySelector('#notificationsModal .modal-content img');
	
			picElement.remove();
	
			if (isNext) { owl.trigger('next.owl.carousel'); }
			else if (isPrev) { owl.trigger('prev.owl.carousel'); }
	
			var activeImage = document.querySelector('.owl-carousel .owl-item.active .firstImageModel').getAttribute('data-dot');
	
			if (activeImage) { modal.append(activeImage); }
		}
	})

	// Remove specifications collapse functionality in desktop
	const accordionHeaderElement = document.getElementsByClassName('header-collapse');
	[...accordionHeaderElement].forEach((element) =>
	{
		element.onclick = (e) =>
		{
			var vw = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);			
			if (vw >= 768 && e.target.classList.contains('header-collapse')) {
				e.preventDefault();  e.stopImmediatePropagation();
			}
		}
	});
	
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
	setTimeout(function(){ show_comp_message=1; }, 3000);
});