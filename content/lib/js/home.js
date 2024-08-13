 function populate_noteb_data() {
	get_nom_search_data().then(() => {
	if (nb_search_data) {
        if (nb_search_data.site && nb_search_data.site.gentime) {
            $('#latest-update').text(nb_search_data.site.gentime[0]);
        }
        if (nb_search_data.site && nb_search_data.site.info && nb_search_data.site.info.length >= 4) {
            $('#num-retailers').text(nb_search_data.site.info[3]);
            $('#num-configurations').text(nb_search_data.site.info[0]);
            $('#num-models').text(nb_search_data.site.info[1]);
        }
    }
    }).catch((err) => {
        console.error(err);
        // Handle any errors here
    });
}

	//Top sliders area
    // Select sliders and indicators
    let $slider = $('.category');
    let $indicators = $('.category-indicators .indicator');
    let slideWidth = $slider.find('.category-item:first').outerWidth(true);
    let currentIndex = 0;
    let totalItems = $indicators.length;

    //Updates indicators 
    function update_indicators() {
        $indicators.removeClass('active');
        $indicators.eq(currentIndex).addClass('active');
    }

    //Move sliders to the right
    function slideRight() {
        $slider.animate({
            'margin-left': -slideWidth + 'px'
        }, 500, function () {
            $slider.find('.category-item:first').appendTo($slider);
            $slider.css('margin-left', 0);
            currentIndex = (currentIndex + 1) % totalItems;
            update_indicators();
        });
    }

    //Move slider to the left
    function slideLeft() {
        $slider.find('.category-item:last').prependTo($slider);
        $slider.css('margin-left', -slideWidth + 'px');
        $slider.animate({
            'margin-left': 0
        }, 500, function () {
            currentIndex = (currentIndex - 1 + totalItems) % totalItems;
            update_indicators();
        });
    }

    //Jump to next latop in the list
    function jumpToIndex(index) {
        if (index > currentIndex) {
            let steps = index - currentIndex;
            let marginLeft = -slideWidth * steps;
            $slider.animate({
                'margin-left': marginLeft + 'px'
            }, 500, function () {
                for (let i = 0; i < steps; i++) {
                    $slider.find('.category-item:first').appendTo($slider);
                }
                $slider.css('margin-left', 0);
                currentIndex = index;
                update_indicators();
            });
        } else if (index < currentIndex) {
            let steps = currentIndex - index;
            let marginLeft = slideWidth * steps;
            for (let i = 0; i < steps; i++) {
                $slider.find('.category-item:last').prependTo($slider);
            }
            $slider.css('margin-left', -marginLeft + 'px');
            $slider.animate({
                'margin-left': 0
            }, 500, function () {
                currentIndex = index;
                update_indicators();
            });
        }
    }

    // Event listeners
    $('.arrow-swipe.right-arrow').on('click', function () {
        slideRight();
    });

    $('.arrow-swipe.left-arrow').on('click', function () {
        slideLeft();
    });

    $indicators.on('click', function () {
        let index = $(this).data('index');
        jumpToIndex(index);
    });


$(document).ready(function(){
	actbtn("Looking for a laptop? Search, compare or use our quiz to find the laptop for you with Noteb search engine.");
	actbtn("NOTEBROTHER",1);
	OpenQuiz("search/quiz/quiz.php"+"?"+window.location.href);
	
	
	// Code for dropdown top laptops//
	if ($(window).width() < 1600 && $(window).width() > 768) 
	{
		$(".showMoreSpan").click(function()
		{
			$(".topLaptops").toggleClass("showMoreLaptops");
			if($( ".topLaptops" ).hasClass( "showMoreLaptops" ))
			{
				$(".showMoreSpan").html("Show Less"); 
				$( ".topLaptops .gamingTopLaptops .row:nth-child(6), .topLaptops .businessTopLaptops .row:nth-child(6), .topLaptops .ultrabooksTopLaptops .row:nth-child(6), .studentTopLaptops .row:nth-child(6)" ).css("opacity", "1");                        
			}
			else
			{
				$(".showMoreSpan").html("Show All"); 
				$( ".topLaptops .gamingTopLaptops .row:nth-child(6), .topLaptops .businessTopLaptops .row:nth-child(6), .topLaptops .ultrabooksTopLaptops .row:nth-child(6), .studentTopLaptops .row:nth-child(6)" ).css("opacity", "0.3");           
			}
		});  	
    }
	else if($(window).width() > 1600 )
	{
		$(".showMoreSpan").click(function()
		{
			$(".topLaptops").toggleClass("showMoreLaptops");
			if($( ".topLaptops" ).hasClass( "showMoreLaptops" ))
			{
				$(".showMoreSpan").html("Show Less");
				$( ".topLaptops .gamingTopLaptops .row:nth-child(7), .topLaptops .businessTopLaptops .row:nth-child(7), .topLaptops .ultrabooksTopLaptops .row:nth-child(7), .studentTopLaptops .row:nth-child(7)" ).css("opacity", "1");
			} 
			else
			{
				$(".showMoreSpan").html("Show All"); 
				$( ".topLaptops .gamingTopLaptops .row:nth-child(7), .topLaptops .businessTopLaptops .row:nth-child(7), .topLaptops .ultrabooksTopLaptops .row:nth-child(7), .studentTopLaptops .row:nth-child(7)" ).css("opacity", "0.3");           
			}
		});
    }
	else if ($(window).width() < 768)
	{
		$(".h2TopLaptopsGaming").click(function()
		{
			$(".gamingTopLaptops").toggleClass("showMoreTop");
			$(".gamingTopLaptops").siblings().removeClass("showMoreTop");
		});
		
		$(".mobileShowMoreGaming").click(function()
		{
			$(".gamingTopLaptops").toggleClass("showAllLaptops");
			if($( ".gamingTopLaptops" ).hasClass( "showAllLaptops" ))
			{ $(".mobileShowMoreGaming span").html("Show Less"); }
			else
			{ $(".mobileShowMoreGaming span").html("Show All"); }
		});
		
		$(".h2TopLaptopsBusiness").click(function()
		{
			$(".businessTopLaptops").toggleClass("showMoreTop");
			$(".businessTopLaptops").siblings().removeClass("showMoreTop");
		});
		
		$(".mobileShowMoreBusiness").click(function()
		{
			$(".businessTopLaptops").toggleClass("showAllLaptops");
			if($( ".businessTopLaptops" ).hasClass( "showAllLaptops" ))
			{ $(".mobileShowMoreBusiness span").html("Show Less"); }
			else
			{ $(".mobileShowMoreBusiness span").html("Show All"); }
		});
		
		$(".h2TopLaptopsStudent").click(function()
		{
			$(".studentTopLaptops").toggleClass("showMoreTop");
			$(".studentTopLaptops").siblings().removeClass("showMoreTop");
		});
			
		$(".mobileShowMoreStudent").click(function()
		{
			$(".studentTopLaptops").toggleClass("showAllLaptops");
			if($( ".studentTopLaptops" ).hasClass( "showAllLaptops" ))
			{ $(".mobileShowMoreStudent span").html("Show Less"); }
			else
			{ $(".mobileShowMoreStudent span").html("Show All"); }
		});
	}
		
		$(".mobileShowMoreArticles").click(function()
		{
			$(".articleMobile").toggleClass("showAllArticles");
			if($( ".articleMobile" ).hasClass( "showAllArticles" ))
			{ $(".mobileShowMoreArticles span").html("Show Less"); }
			else
			{ $(".mobileShowMoreArticles span").html("Show All Articles"); }
		});
		
		$(".h2Articles").click(function(){ $(".articleMobile ").toggleClass("showMoreArticles"); });
	

	/*slick slider mobile */
	 $('.slickMobile').slick({
		  dots: true,
		  infinite: false,
		  speed: 300,
		  slidesToShow: 4,
		  slidesToScroll: 4,
		  responsive: [		,
		    {
		      breakpoint: 9999,
		      settings: 'unslick'      
		    },
		    {
		      breakpoint: 500,
		      settings: {
		        slidesToShow: 1,
		        slidesToScroll: 1
		      }
		    }
		    // You can unslick at a given breakpoint now by adding:
		    // settings: "unslick"
		    // instead of a settings object
		  ]
		});

    populate_noteb_data() ;
    update_indicators();
});