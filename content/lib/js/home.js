$(document).ready(function(){
	actbtn("Find the best laptop with Noteb notebook search engine.");
	actbtn("NOTEBROTHER",1);
	OpenQuiz("search/quiz/quiz.php");
});


// Code for dropdown top laptops//
$(document).ready(function(){
if ($(window).width() < 1600 && $(window).width() > 768) {
   $(".showMoreSpan").click(function(){
        $(".topLaptops").toggleClass("showMoreLaptops");        
        if($( ".topLaptops" ).hasClass( "showMoreLaptops" )) {
            $(".showMoreSpan").html("Show Less"); 
            $( ".topLaptops .gamingTopLaptops .row:nth-child(6), .topLaptops .businessTopLaptops .row:nth-child(6), .topLaptops .ultrabooksTopLaptops .row:nth-child(6), .studentTopLaptops .row:nth-child(6)" ).css("opacity", "1");                        
        } else {
            $(".showMoreSpan").html("Show All"); 
            $( ".topLaptops .gamingTopLaptops .row:nth-child(6), .topLaptops .businessTopLaptops .row:nth-child(6), .topLaptops .ultrabooksTopLaptops .row:nth-child(6), .studentTopLaptops .row:nth-child(6)" ).css("opacity", "0.3");           
        }
     });  
    }   
});


$(document).ready(function(){
if ($(window).width() > 1600 ) {
   $(".showMoreSpan").click(function(){
        $(".topLaptops").toggleClass("showMoreLaptops");        
        if($( ".topLaptops" ).hasClass( "showMoreLaptops" )) {
            $(".showMoreSpan").html("Show Less"); 
            $( ".topLaptops .gamingTopLaptops .row:nth-child(7), .topLaptops .businessTopLaptops .row:nth-child(7), .topLaptops .ultrabooksTopLaptops .row:nth-child(7), .studentTopLaptops .row:nth-child(7)" ).css("opacity", "1");                        
        } else {
            $(".showMoreSpan").html("Show All"); 
            $( ".topLaptops .gamingTopLaptops .row:nth-child(7), .topLaptops .businessTopLaptops .row:nth-child(7), .topLaptops .ultrabooksTopLaptops .row:nth-child(7), .studentTopLaptops .row:nth-child(7)" ).css("opacity", "0.3");           
        }
     });  
    }   
});

$(document).ready(function(){   
        if ($(window).width() < 768) { 
            $(".h2TopLaptopsGaming").click(function(){               
                $(".gamingTopLaptops").toggleClass("showMoreTop");       
                $(".gamingTopLaptops").siblings().removeClass("showMoreTop");         
            });
        }      
});

$(document).ready(function(){   
         if ($(window).width() < 768) { 
            $(".h2TopLaptopsBusiness").click(function(){               
                $(".businessTopLaptops").toggleClass("showMoreTop");  
                $(".businessTopLaptops").siblings().removeClass("showMoreTop");              
            });
        }   
});

$(document).ready(function(){  
        if ($(window).width() < 768) { 
            $(".h2TopLaptopsUltrabooks").click(function(){               
                $(".ultrabooksTopLaptops").toggleClass("showMoreTop"); 
                $(".ultrabooksTopLaptops").siblings().removeClass("showMoreTop");               
            });
        }   
});

$(document).ready(function(){  
        if ($(window).width() < 768) { 
            $(".h2TopLaptopsStudent").click(function(){               
                $(".studentTopLaptops").toggleClass("showMoreTop"); 
                $(".studentTopLaptops").siblings().removeClass("showMoreTop");               
            });
        }   
});


$(document).ready(function(){   
        if ($(window).width() < 768) { 
            $(".mobileShowMoreGaming").click(function(){                
                $(".gamingTopLaptops").toggleClass("showAllLaptops");    
                 if($( ".gamingTopLaptops" ).hasClass( "showAllLaptops" )) {
                    $(".mobileShowMoreGaming").css("display", "none"); 
                } else {
                    $(".mobileShowMoreGaming span").html("Show All"); 
                }            
            });
        }      
});

$(document).ready(function(){   
        if ($(window).width() < 768) { 
            $(".mobileShowMoreBusiness").click(function(){                
                $(".businessTopLaptops").toggleClass("showAllLaptops");    
                 if($( ".businessTopLaptops" ).hasClass( "showAllLaptops" )) {
                    $(".mobileShowMoreBusiness").css("display", "none"); 
                } else {
                    $(".mobileShowMoreBusiness span").html("Show All"); 
                }            
            });
        }      
});

$(document).ready(function(){   
        if ($(window).width() < 768) { 
            $(".mobileShowMoreUltrabooks").click(function(){                
                $(".ultrabooksTopLaptops").toggleClass("showAllLaptops");    
                 if($( ".ultrabooksTopLaptops" ).hasClass( "showAllLaptops" )) {
                    $(".mobileShowMoreUltrabooks").css("display", "none"); 
                } else {
                    $(".mobileShowMoreUltrabooks span").html("Show All"); 
                }            
            });
        }      
});

$(document).ready(function(){   
        if ($(window).width() < 768) { 
            $(".mobileShowMoreStudent").click(function(){                
                $(".studentTopLaptops").toggleClass("showAllLaptops");    
                 if($( ".studentTopLaptops" ).hasClass( "showAllLaptops" )) {
                    $(".mobileShowMoreStudent").css("display", "none"); 
                } else {
                    $(".mobileShowMoreStudent span").html("Show All"); 
                }            
            });
        }      
});


$(document).ready(function(){   
        if ($(window).width() < 768) { 
            $(".h2Articles").click(function(){                
                $(".articleMobile ").toggleClass("showMoreArticles");                     
            });
        }      
});




$(document).ready(function(){   
        if ($(window).width() > 1600) { 
           $( ".topLaptops" ).scroll(function() {
           $( ".topLaptops .gamingTopLaptops .row:nth-child(7), .topLaptops .businessTopLaptops .row:nth-child(7), .topLaptops .ultrabooksTopLaptops .row:nth-child(7), .topLaptops .studentTopLaptops .row:nth-child(7) " ).css("opacity", "1");
            });
        }      
});


$(document).ready(function(){   
        if ($(window).width() < 1600 && $(window).width() > 768) { 
                $( ".topLaptops" ).scroll(function(e) {
                 if ($('.topLaptops').scrollTop() == 0 && e < 0 ) {
                      $( ".topLaptops .gamingTopLaptops .row:nth-child(6), .topLaptops .businessTopLaptops .row:nth-child(6), .topLaptops .ultrabooksTopLaptops .row:nth-child(6), .studentTopLaptops .row:nth-child(6)" ).css("opacity", "0.3");                
                    } 
                      else {
                         $( ".topLaptops .gamingTopLaptops .row:nth-child(6), .topLaptops .businessTopLaptops .row:nth-child(6), .topLaptops .ultrabooksTopLaptops .row:nth-child(6), .studentTopLaptops .row:nth-child(6)" ).css("opacity", "1");
                     }                                     
                });
        }      
});

$(document).ready(function(){   
        if ($(window).width() > 1600) { 
                $( ".topLaptops" ).scroll(function(e) {
                 if ($('.topLaptops').scrollTop() == 0 && e < 0 ) {
                      $( ".topLaptops .gamingTopLaptops .row:nth-child(7), .topLaptops .businessTopLaptops .row:nth-child(7), .topLaptops .ultrabooksTopLaptops .row:nth-child(7), .studentTopLaptops .row:nth-child(7)" ).css("opacity", "0.3");                
                    } 
                      else {
                         $( ".topLaptops .gamingTopLaptops .row:nth-child(7), .topLaptops .businessTopLaptops .row:nth-child(7), .topLaptops .ultrabooksTopLaptops .row:nth-child(7), .studentTopLaptops .row:nth-child(7)" ).css("opacity", "1");
                     }                                     
                });
        }      
});