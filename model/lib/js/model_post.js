$(document).ready(function() 
{
	$(function()
	{
		$('.pics').on('click', function() 
		{
			$('.enlargeImageModalSource').attr('src', $(this).attr('src'));
			$('#enlargeImageModal').modal('show');
		});		
	});
	
	$(window).on('popstate', function()
	{ $('.modal').modal('hide'); $( ".modal-backdrop" ).remove(); $( ".in" ).remove(); });
	
	lightbox.option({ 'resizeDuration': 200, 'fadeDuration' : 200, 'imageFadeDuration':200 });
    $('meta[name=description]').attr('content', mprod + ' ' + mfamily + ' ' + mmodel);
	gpu_right_align();

	//Affix Bootstrap 4
	if ($(window).width() >= 320)
	{
		var elementHeight = document.querySelector('.ptop').getBoundingClientRect().height;
		var top = $('.ptop').offset().top + elementHeight;
		$(window).scroll(function (event)
		{
			var y = $(this).scrollTop();
			if (y >= top)
			{
				$('.ptop').addClass('affix');
				$('#specificationsAccordion').addClass('bringIntoView');
			}
			else
			{
				$('.ptop').removeClass('affix');
				$('#specificationsAccordion').removeClass('bringIntoView');
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
	setTimeout(() =>
	{
		const ratingElementsList = document.querySelectorAll('.rating-element .progress-container');
		setProgressBarsRating(ratingElementsList);
	}, 250);
	
	//OWL MODAL CAROUSEL
	let owl = $("#model-carousel").owlCarousel({ items: 1, loop: true, responsive: { 0: { dots: true}, 768: { dotsData: true } } });

	$('.owl-dot').click(function() { owl.trigger('to.owl.carousel', [$(this).index(), 1000]); })
	
	$('#galleryModal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Button that triggered the modal
		var recipient = button.data('dot') // Extract info from data-* attributes
		var modal = $(this)
		modal.find('.modal-body').append(recipient);
	})

	$('#galleryModal .modal-body').on('click', function (e) {
		const modal = $(this);
		const isNext = e.target.classList.contains('nextImage');
		const picElement = document.querySelector('#galleryModal .modal-body img');

		picElement.remove();

		if (isNext) { owl.trigger('next.owl.carousel'); }
		else { owl.trigger('prev.owl.carousel'); }

		const activeImage = document.querySelector('.owl-carousel .owl-item.active .firstImageModel').getAttribute('data-dot');

		if (activeImage) { modal.append(activeImage); }
	})

	$('#galleryModal').on('hidden.bs.modal', function (e)
	{
		const picElement = document.querySelector('#galleryModal .modal-body img.pics');
		picElement.remove();
	});

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