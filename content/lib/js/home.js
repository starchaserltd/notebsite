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
		
		$(".mobileShowMoreArticles").click(function()
		{
			$(".articleMobile").toggleClass("showAllArticles");
			if($( ".articleMobile" ).hasClass( "showAllArticles" ))
			{ $(".mobileShowMoreArticles span").html("Show Less"); }
			else
			{ $(".mobileShowMoreArticles span").html("Show All Articles"); }
		});
		
		$(".h2Articles").click(function(){ $(".articleMobile ").toggleClass("showMoreArticles"); });
	}

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
});