if (typeof populate_noteb_data !== 'function') {
    function populate_noteb_data() {
        get_nom_search_data().then(() => {
            if (nb_search_data && nb_search_data.site) {
                if (nb_search_data.site.gentime) {
                    $('#latest-update').text(nb_search_data.site.gentime[0]);
                }
                if (nb_search_data.site.info && nb_search_data.site.info.length >= 4) {
                    $('#num-retailers').text(nb_search_data.site.info[3]);
                    $('#num-configurations').text(nb_search_data.site.info[0]);
                    $('#num-models').text(nb_search_data.site.info[1]);
                }
            }
        }).catch((err) => {
            console.error(err);
        });
    }
}

// Top sliders area
if (typeof slides === 'undefined') { 
    var slides = document.querySelectorAll('input[name="carousel"]'); 
}
if (typeof nextSlideBtn === 'undefined') { 
    var nextSlideBtn = document.querySelector('.next'); 
}
if (typeof prevSlideBtn === 'undefined') { 
    var prevSlideBtn = document.querySelector('.prev'); 
}
if (typeof currentSlide === 'undefined') { 
    var currentSlide = 0; 
}

if (nextSlideBtn && prevSlideBtn) {
    nextSlideBtn.addEventListener('click', () => {
        currentSlide = (currentSlide + 1) % slides.length;
        slides[currentSlide].checked = true;
    });

    prevSlideBtn.addEventListener('click', () => {
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        slides[currentSlide].checked = true;
    });
}

$(document).ready(function() {

    actbtn("Looking for a laptop? Search, compare or use our quiz to find the laptop for you with Noteb search engine.");
    actbtn("NOTEBROTHER", 1);
    OpenQuiz("search/quiz/quiz.php" + "?" + window.location.href);

    // Code for dropdown top laptops
    $(".showMoreSpan").click(function() {
        $(".topLaptops").toggleClass("showMoreLaptops");
        let text = $(".topLaptops").hasClass("showMoreLaptops") ? "Show Less" : "Show All";
        $(".showMoreSpan").html(text); 
        let opacityValue = $(".topLaptops").hasClass("showMoreLaptops") ? "1" : "0.3";

        if ($(window).width() < 1600 && $(window).width() > 768) {
            $(".topLaptops .row:nth-child(6)").css("opacity", opacityValue);
        } else if ($(window).width() > 1600) {
            $(".topLaptops .row:nth-child(7)").css("opacity", opacityValue);
        }
    });

    if ($(window).width() < 768) {
        const toggleClassAndText = (selector, toggleClass, buttonSelector) => {
            $(selector).toggleClass(toggleClass);
            let text = $(selector).hasClass(toggleClass) ? "Show Less" : "Show All";
            $(buttonSelector).find("span").html(text); 
        };

        $(".h2TopLaptopsGaming").click(() => toggleClassAndText(".gamingTopLaptops", "showMoreTop", ""));
        $(".mobileShowMoreGaming").click(() => toggleClassAndText(".gamingTopLaptops", "showAllLaptops", ".mobileShowMoreGaming"));
        $(".h2TopLaptopsBusiness").click(() => toggleClassAndText(".businessTopLaptops", "showMoreTop", ""));
        $(".mobileShowMoreBusiness").click(() => toggleClassAndText(".businessTopLaptops", "showAllLaptops", ".mobileShowMoreBusiness"));
        $(".h2TopLaptopsStudent").click(() => toggleClassAndText(".studentTopLaptops", "showMoreTop", ""));
        $(".mobileShowMoreStudent").click(() => toggleClassAndText(".studentTopLaptops", "showAllLaptops", ".mobileShowMoreStudent"));
    }

    $(".mobileShowMoreArticles").click(function() {
        $(".articleMobile").toggleClass("showAllArticles");
        let text = $(".articleMobile").hasClass("showAllArticles") ? "Show Less" : "Show All Articles";
        $(".mobileShowMoreArticles span").html(text); 
    });

    $(".h2Articles").click(function() { 
        $(".articleMobile").toggleClass("showMoreArticles"); 
    });

    // slick slider mobile 
    $('.slickMobile').slick({
        dots: true,
        infinite: false,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 4,
        responsive: [
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
        ]
    });

    populate_noteb_data();
});