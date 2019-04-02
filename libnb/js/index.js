//Initialization
var trigger = 1;
var z = 0;
var first = 1; var cleanurl=20;
var firstcompare = 1;
var nocomperrormess = 0;
var previousurl = "";
var disqusloaded = 1;
var urlold = ""; var searchurl="";
var hh = 1;
var ismobile = 0; var global_sort_search="value"; var global_sort_browse="value"; var pause_presearch=1; var nquiz="";
var currentPage = window.location.href; var ref=null; var all_requests=[]; var model_label_animation=function(){}; var model_bat_animation=function(){};

function locationHashChanged(pagetopen) {
    if (trigger){
        var urlParts = pagetopen.split('?');
        var first = 0;
        var currentpage = "";
        if (urlParts[1] == "undefined") {
            var currentpage = "content/home.php";
        } else {
            for (var key in urlParts) {

                value = urlParts[key];
                if (first) {

                    if (first > 1)
                        currentpage = currentpage + "?" + value;
                    else {
                        currentpage = currentpage + value;
                        first++;
                    }
                } else {
                    first++;
                }
            }
        }
        OpenPage(currentpage, 1, 1); //dontpush is set to 1 to prevent pushing states on back and forward buttons, use OpenPage function on all links
    }
    trigger = 1;
}

setInterval(function()
{
	if(cleanurl>19 && window.location.href.indexOf("search")!==-1 && currentPage.indexOf("search")!==-1)
	{
		url_s=window.location.href;
		var urltitle = /([^\/]*).php/g.exec(url_s);
        urltitle = urltitle[1];
		history.replaceState({}, 'NoteBrother' + ' ' + urltitle, url_s.replace("%20%20","%20").replace(")","\%29").replace("(","\%28"));
		currentPage=currentPage.replace("%20%20","%20").replace(")","\%29").replace("(","\%28");
	}
	if(cleanurl>0){cleanurl--;}else{cleanurl=20;}
	
	if (currentPage !== window.location.href)
	{
		currentPage = window.location.href;
        locationHashChanged(set_adv_search(currentPage,siteroot+"?",1));
    }

    if ($(window).width() < 992)
	{
        if (ismobile!=1) { ismobile = 1; state_ssearch(1); }
    }
	else
	{
		if (ismobile!=0) { ismobile=0; state_ssearch(0); }
    }
}, 50);

function urlrequest(url, e, dontpush) {
    trigger = 0;
    $('#loadingNB').show();
    $.get(url, function(response) {
        var urltitle = /([^\/]*).php/g.exec(url);
        urltitle = urltitle[1];
        currentpage = url;        
        if ($('#content').html(response)) { $('#loadingNB').hide(); if(lightbox.$overlay[0].style.display=="block"){ lightbox.end(); } }
        if (!dontpush) {
            dontpush = 0;
            if (first) {
                history.replaceState({}, 'NoteBrother' + ' ' + urltitle, "?" + url);
                first = 0;
            } else { history.pushState({}, 'NoteBrother' + ' ' + urltitle, "?" + url); }
        }
    });
}

//Function for main content area
function OpenPage(url, e, dontpush) {
	for(var i in all_requests){ all_requests[i].abort();} all_requests=[]; clearTimeout(model_label_animation);
	url=set_adv_search(url,"",0);
	if(url.indexOf("search.php")>0&&url.indexOf("sort_by")<0&&url.indexOf("adv_search")<0){if(url.indexOf("browse_by")>0){url=url+"&sort_by="+global_sort_browse;}else{url=url+"&sort_by="+global_sort_search;}}
	if(url.indexOf("ref=")<0){ if(ref!=null&&ref!="") { if(url.indexOf("?")>=0){ url=url+"&ref="+ref;}else { url=url+"?ref="+ref; } } }
	url = decodeURIComponent(decodeURIComponent(url.replace("% ", "%25%20").replace("%%20", "%25%20")).replace("% ", "%25%20").replace("%%20", "%25%20"));
    //DEPENDING ON WHAT BUTTON WAS PRESSED WE DO DIFFERENT THINGS
    var e = e || window.event;
    var btnCode;
    var go = 0;
    if ('object' === typeof e) { btnCode = e.button; }
    adjust_ssearch(url);
    switch (btnCode) {
        case 0:
            go = 1;
            break;
        case 1:
            go = 2;
            break;
        case 2:
            go = 0;
            break;
        default:
            go = 1;
    }

    if (go == 1 || go == 2) {
		//	document.getElementById("sharefb").href="https://www.facebook.com/sharer/sharer.php?u="+siteroot+"/?"+url;
		}
    if (go == 1) { urlrequest(url, e, dontpush); }
    if (go == 2) { wopen =window.open(siteroot + "?" + url, "_blank"); if (wopen==null||typeof(wopen)=='undefined'){alert("Turn off your pop-up blocker!");} }
}

//Function for toolbox area
function OpenPageMenu(url) 
{
    $.get(url, function(response) { $('#leftmenu').html(response); });
}

//Function for toolbox area
function OpenQuiz(url)
{
    $.get(url, function(response) { $('#quiz').html(response); });
}

$(document).ready(function() {
    // Script for left menu  
    $('.cssmenu li.active').addClass('open').children('ul').show();
    $('.cssmenu li.has-sub>a').on('click', function() {
        $(this).removeAttr('href');
        var element = $(this).parent('li');
        if (element.hasClass('open')) {
            element.removeClass('open');
            element.find('li').removeClass('open');
            element.find('ul').slideUp(200);
        } else {
            element.addClass('open');
            element.children('ul').slideDown(200);
            element.siblings('li').children('ul').slideUp(200);
            element.siblings('li').removeClass('open');
            element.siblings('li').find('li').removeClass('open');
            element.siblings('li').find('ul').slideUp(200);
        }
    });

    //Function for form model search left menu   
    $('#model_id').on("select2:select", function(e) {
        scrolltoid('content');
        $('#loadingNB').show();
        trigger = 0;
        url = "model/model.php" + "?model_id=" + $(this).val();
        $("#model_id").val(null).trigger("change");
        OpenPage(url, 1, 0);
    });

    //Function for hidding learning message
     if($(".compareDropdown").css('display') === 'block' ) {$("#howToUse").css('display', 'none');}
	
	$( "#howToUse .glyphicon-remove" ).click(function(event) { remove_popup(); });

	if(history.state!==null && history.state["back"]!==undefined){ window.location.href=history.state["back"]; }
   
   //Load main content area
	if (!(window.location.href.split('?')[1])) 
	{ currentpage = "content/home.php"; }
	else
	{
        var urlParts = window.location.href.split('?');
        var currentpage = urlParts.slice(1).join('?');
    }
	
	var newref=currentpage.match(/(?:[?]|[&]|^)ref=((?:[^&]|$)+)/m);
	if(newref!==null)
	{
		var qmark=newref[0].indexOf("?");
		if(qmark>=0&&qmark<5)
		{ currentpage=currentpage.replace(newref[0],"?"); }
		else
		{ currentpage=currentpage.replace(newref[0],""); }
		
		if(ref!=newref[1])
		{
			if (window.XMLHttpRequest)	{ var	xmlhttp = new XMLHttpRequest(); }
			xmlhttp.onreadystatechange = function() 
			{
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
				{
					if(parseInt(xmlhttp.responseText)==1)
					{ ref=newref[1]; if(qmark>=0&&qmark<5) { currentpage=currentpage+"ref="+ref; }else{ currentpage=currentpage+"&ref="+ref; } }
					else
					{ ref=null; }
					first = 1; OpenPage(currentpage);
				}
				else
				{
					if (xmlhttp.readyState == 4 && xmlhttp.status != 200) 
					{
						first = 1; OpenPage(currentpage);
					}
				}
			}
			xmlhttp.open("GET","libnb/php/checkref.php?ref="+newref[1],true);
			xmlhttp.send();
		}
		else
		{
			first = 1; OpenPage(currentpage);
		}
	}
	else
	{
		first = 1; OpenPage(currentpage);
	}

    /* HERE we have the script for quick model search */

    $(".modelsearch").each(function() {
        var $this = $(this);
        $this.select2({
            tags: false,
            multiple: true,
            maximumSelectionLength: 15,
            minimumInputLength: 2,
            language: {
                noResults: function(term) {
                    return "Type something...";
                }
            },
            ajax: {
                cache: false,
                quietMillis: 100,
                dataType: "json",
                url: "search/lib/func/m_search.php",
                type: "POST",
                data: function(params) {
                    var queryParameters = {
                        list: $this.attr('field'),
                        q: "model",
                        keys: params.term,
						ex: excode
                    }
                    return queryParameters;
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.id,
                                text: item.model
                            };
                        })
                    };
                }
            }
        })
    });

    //Make dropdown for search filters
	$(".navbar-header").click(function() { $('.navbar-collapse').slideToggle("slow"); });
	
	if ($(window).width()<768) //Append Compare to FirstContainer
	{ $(".quickSearchContainer").appendTo($(".firstContainer")); $(".compareDropdown").appendTo($(".firstContainer")); }

    //toggle more options for adv_search
    $('.toggleHiddenButtons').click(function() { $('.hiddenOptions').toggleClass('show'); });
});

//THE SORT BY RESULTS BUTTONS 

function sortresults(sortby)
{

    var urlParts = window.location.href.split('?');
    var first = 0;
    var currentpage = "";

    if (urlParts[1] == "undefined"){ var currentpage = 'content/home.php'; }
	else
	{
		for (var key in urlParts)
		{
			value = urlParts[key];
            if (first)
			{ 
				if (first > 1) { currentpage = currentpage + "?" + value; }
				else { currentpage = currentpage + value; first++; }
            }
			else { first++; }
        }
    }

    var newcurrentpage = currentpage.split('&sort_by');
    ifexchange = /(exchange=(.*?))($|&)/.exec(newcurrentpage[1]);

    if ((newcurrentpage[0].indexOf("/search.php?") > -1) || (newcurrentpage[0].indexOf("/search.php?") > -1))
	{
		if (ifexchange != null) { newpage = newcurrentpage[0] + "&exchange=" + ifexchange[2] + "&sort_by=" + sortby; }
		else { newpage = newcurrentpage[0] + "&sort_by=" + sortby; }
    } 
	else 
	{
		if (ifexchange != null) { newpage = "search/search.php?exchange=" + ifexchange[2] + "&sort_by=" + sortby; } else { newpage = "search/search.php?exchange=1" + "&sort_by=" + sortby; }
    }
	if (newpage.indexOf("browse_by") > -1){ global_sort_browse=sortby; }else{ if (newpage.indexOf("search") > -1) { global_sort_search=sortby; } }
    
	return newpage;
}


//CHANGE EXCHANGE RATE RESULTS BUTTONS 
function exchangeresults(exchange) {

    var urlParts = window.location.href.split('?');
    var first = 0;
    var currentpage = "";
    excode = exchange;

    if (urlParts[1] == "undefined") {
        var currentpage = 'content/home.php';
    } else {
        for (var key in urlParts) {
            value = urlParts[key];
            if (first) {

                if (first > 1)
                    currentpage = currentpage + "?" + value;
                else {
                    currentpage = currentpage + value;
                    first++;
                }
            } else {
                first++;
            }
        }
    }
    var addadv = "";
    var exadv = "exchange=";
    var urlminbudget = /\/?bdgmin=([0-9]+)/.exec(currentpage);
    if (urlminbudget == null) { urlminbudget = /\/?bdgminadv=([0-9]+)/.exec(currentpage); if (urlminbudget !== null) { addadv = "adv"; } }
    var urlmaxbudget = /\/?bdgmax=([0-9]+)/.exec(currentpage);
    if (urlmaxbudget == null) { urlmaxbudget = /\/?bdgmaxadv=([0-9]+)/.exec(currentpage); if (urlmaxbudget !== null) { addadv = "adv"; } }
    var urlexchange = /(exchange=(.*?))($|&)/.exec(currentpage);
    if (urlexchange == null) { urlexchange = /(exchadv=(.*?))($|&)/.exec(currentpage); if (urlexchange !== null) { exadv = "exchadv="; } }


    if ((urlexchange != null) && (urlminbudget != null) && (urlmaxbudget != null)) {
        urlexchangeval = currency_val[urlexchange[2]];
        exchangeval = currency_val[exchange];
        urlminbudgetval = parseInt(urlminbudget[1]);
        urlmaxbudgetval = parseInt(urlmaxbudget[1]);
        newpage = currentpage.replace((urlexchange[1]), (exadv + exchange));
        newpage = newpage.replace((urlminbudget[0]), ("bdgmin" + addadv + "=" + parseInt((urlminbudgetval / urlexchangeval) * exchangeval)));
        newpage = newpage.replace((urlmaxbudget[0]), ("bdgmax" + addadv + "=" + parseInt((urlmaxbudgetval / urlexchangeval) * exchangeval)));
    } else {
        if (urlexchange != null) { newpage = currentpage.replace((urlexchange[1]), (exadv + exchange)); } else { newpage = currentpage + "&" + exadv + exchange; }
    }
    return newpage;
}


//SETTING THE CURRENTLY ACTIVE MENU BUTTON

function actbtn(pagename, mobile) {
	switch (pagename) {
		case "USER":
		{
			if (!mobile) { $('.btn-sus').removeClass('active'); }
			$('#usermenu').addClass('acthelp white');
			break;
		}
		default:
		{
			if (!mobile) {
				$('.btn-sus').removeClass('active');
				$('.addrev').removeClass('selected');
				$('#usermenu').removeClass('acthelp white');
			}

			$('.btn-sus').each(function(index) {
				if (this.innerHTML == pagename && (pagename != "Find the best laptop with Noteb notebook search engine." || pagename != "NOTEBROTHER")) {
					$(this).addClass('active');
				}
			});
		}
	}
}

function occur(string, subString, allowOverlapping) {
    string += "";
    subString += "";
    if (subString.length <= 0) return (string.length + 1);

    var n = 0,
        pos = 0,
        step = allowOverlapping ? 1 : subString.length;

    while (true) {
        pos = string.indexOf(subString, pos);
        if (pos >= 0) {
            ++n;
            pos += step;
        } else break;
    }
    return n;
}

// ADDING METADATA TO A PAGE FOR SEO
function metakeys(metakeys) {
    $('meta[name=keywords]').remove();
    $('head').append('<meta name="keywords" content="' + metakeys + '">');

}

//SCROLLTOFUNCTION
function scrolltoid(id) {
    $('html,body').animate({ scrollTop: $("#" + id).offset().top }, 'slow');
}

//ACTIVE  - DEACTIVE menu buttons
$(".btn-group > .btn-sus").click(function() {
    $(".btn-group > .btn-sus").removeClass("active");
    $(this).addClass("active");
});

//FIELD SEARCH FOR SELECT2	
function triggerchange(el, seltext, match_type) {
    var i = 0;
    var found = 0;
    while (el.select2("val")[i] !== undefined) {
        switch (el.select2("val")[i]) {
            case seltext:
                { found = 1; break; }
        }
        i++;
    }
    if (found && match_type == 0 && i > 1) { found = 0; }
    return found;
}

//CLICK FUNCTION FOR QUICK MENU
$( ".leftMenuFilters" ).click(function()
{
	$( ".SearchParameters" ).toggle("slow"); $( ".leftMenuFilters" ).toggleClass("rotate"); 
	var button_el=document.getElementsByClassName("btn-title")[0];
	if(button_el.getAttribute("aria-expanded") == "true"){button_el.setAttribute("aria-expanded", "false"); }
	else if(button_el.getAttribute("aria-expanded") == "false" || button_el.getAttribute("aria-expanded") == "permanentfalse"){button_el.setAttribute("aria-expanded", "true"); document.querySelector(".SearchParameters").style.display = "block"; }
});

function state_ssearch(type)
{
    var button_el=document.getElementsByClassName("btn-title")[0];
	if (type == 0) { button_el.click(); button_el.setAttribute("aria-expanded", "true"); }
    if (type == 1) { button_el.setAttribute("aria-expanded", "false"); }
}

function adjust_ssearch(page) {
    
	var button_el=document.getElementsByClassName("btn-title")[0];
	
	if(button_el.getAttribute("aria-expanded")==null)
	{ if ($(window).width() < 992){ ismobile = 1; state_ssearch(1); } else { ismobile = 0; state_ssearch(0); } }

	if (page.indexOf("adv_search.php") > -1 || page.indexOf("advsearch=1") > -1)
	{
        document.querySelector(".SearchParameters").style.display = "none";
        button_el.setAttribute("aria-expanded", "permanentfalse");
    }
	else
	{ 	if (page.indexOf("home.php") > -1&& button_el.getAttribute("aria-expanded")=="permanentfalse" &&!ismobile)
		{ button_el.setAttribute("aria-expanded", "false"); button_el.click(); }
		else if (button_el.getAttribute("aria-expanded") == "false" && !ismobile) { button_el.click();}
	}

    if (page.indexOf("home.php") > -1)
	{ $('.headerback').addClass('home'); }
	else
	{$('.headerback').removeClass('home'); }
}

//THIS FUNCTION IS FOR GENERATING PROPER MAX MIN FOR SLIDERS
function listrange(list_comp)
{
	values={};
	for(i=0;i<list_comp.length;i++)
	{
		if(i==0)
		{
			values['min']=[parseFloat(list_comp[i]),(list_comp[i+1]-list_comp[i])];
		}
		else
		{
			if(i==(list_comp.length-1))
			{ values['max']=[parseFloat(list_comp[i])]; }
			else
			{ values[parseInt(100/(list_comp.length-1)*i)+'%']=[parseFloat(list_comp[i]),(list_comp[i+1]-list_comp[i])]; }
		}
	}
	return values;
}

// Only enable if the document has a long scroll bar
// Note the window height + offset
// if ( ($(window).height() + 100) < $(document).height() ) { $('#top-link-block').removeClass('hidden').affix({ offset: {top:100} }); }
//Usermenu activate
$('.addrev').click(function() {
	$(this).siblings().removeClass('selected');
	$(this).addClass('selected');
});
//Deactivate api buton when click on other menu buttons

$('.logonb').click(function() {
   $('#usermenu').removeClass('white');
   $('.addrev').removeClass('selected');
});

function mail_to(email){ window.location.href = "mailto:"+email+"@starchaser.ro"; }

function get_buy_list(el)
{
	setTimeout(function()
	{
		if(el.getAttribute("aria-expanded")==="true")
		{		
			if (el.dataset.target === "")	{ return; }
			else 
			{
				if (window.XMLHttpRequest)	{ var	xmlhttp = new XMLHttpRequest(); }
				
				xmlhttp.onreadystatechange = function() 
				{
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
					{
						document.getElementById(el.dataset.target).innerHTML = xmlhttp.responseText;
					}
				}
				xmlhttp.open("POST","model/lib/php/buy_list.php",true);
				xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xmlhttp.send('idmodel='+el.dataset.idmodel+'&buyregions='+el.dataset.buyregions+'&lang='+el.dataset.lang+'&usertag='+el.dataset.ref+'&price='+el.dataset.price+'&cpu='+el.dataset.cpu+'&gpu='+el.dataset.gpu+'&display='+el.dataset.iddisplay+'&pmodel='+el.dataset.pmodel);
			}
		}
	},5);
}

function set_adv_search(pagetoopen,headpart,back)
{ if(pagetoopen.indexOf("adv_search.php")>=0 && searchurl.indexOf("advsearch=1")>=0 && pagetoopen.indexOf("advsearch=1")<0) { if(pagetoopen.indexOf("s_memmin")<0&&pagetoopen.indexOf("quizsearch")<0&&pagetoopen.indexOf("browse_by")<0){ if(pagetoopen.indexOf("reset=1")<0||back){ pagetoopen=headpart+"search/adv_search.php?"+searchurl;}else{pagetoopen=headpart+"search/adv_search.php?reset=1"; searchurl="";}}} return pagetoopen; }

function remove_popup() { $("#howToUse").addClass("howToUseNone"); var timeout=setTimeout(function() { $("#howToUse").css('display', 'none'); }, 1500); }

//back top function
if ($('#back-to-top').length) {
    var scrollTrigger = 100, // px
        backToTop = function () {
            var scrollTop = $(window).scrollTop();
            if (scrollTop > scrollTrigger) {
                $('#back-to-top').addClass('show');
            } else {
                $('#back-to-top').removeClass('show');
            }
        };
    backToTop();
    $(window).on('scroll', function () {
        backToTop();
    });
    $('#back-to-top').on('click', function (e) {
        e.preventDefault();
        $('html,body').animate({
            scrollTop: 0
        }, 700);
    });
}