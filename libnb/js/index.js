//Initialization
var trigger = 1;
var z = 0;
var first = 1; var cleanurl=20;
var firstcompare = 1;
var nocomperrormess = 0;
var previousurl = "";
var urlold = ""; var searchurl="";
var hh = 1;
var show_buy_list=0;
var ismobile = 0; var global_sort_search="value"; var global_sort_browse="value"; var pause_presearch=1; var nquiz="";
var currentPage = window.location.href; var ref=null; var all_requests=[]; var model_label_animation=function(){}; var model_bat_animation=function(){};
const laptop_comp_list=["cpu","display","mem","hdd","shdd","gpu","mdb","wnet","odd","sist","chassis","acum","war"];

$(window).resize(function() {
    if (window.innerWidth > 767) {
        $('.quickSearchContainer').removeAttr('style');
    }
});

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

    if ($(window).width() < 720)
	{ if (ismobile!=1) { ismobile = 1; state_ssearch(1); } }
	else
	{ if (ismobile!=0) { ismobile=0; state_ssearch(0); } }
}, 50);

var content_load_fail=0;
function urlrequest(url,e,dontpush) {
    trigger = 0;
    $('#loadingNB').show();
    $.get(url, function(response) {
		content_load_fail=0;
        var urltitle = /([^\/]*).php/g.exec(url);
        urltitle = urltitle[1];
        currentpage = url;
        if ($('#content').html(response)) { $('#loadingNB').hide(); }
        window.scrollTo(0, 0);
        if (!dontpush) {
            dontpush = 0;
            if (first) {
                history.replaceState({}, 'NoteBrother' + ' ' + urltitle, "?" + url);
                first = 0;
            } else { history.pushState({}, 'NoteBrother' + ' ' + urltitle, "?" + url); }
        }
    }).fail(function (){ if(content_load_fail==0){urlrequest("content/home.php",e,0); content_load_fail=1;}else{ $('#content').html("Unable to load the main content. Sorry for the inconvenience, please try again later."); }});
}

//No Index params
var set_noindex=0;
const nb_metaRobots = document.createElement('meta');
nb_metaRobots.name = 'robots';
nb_metaRobots.content = 'noindex';


//Function for main content area
function OpenPage(url, e, dontpush) {
    if (!window.location.href.includes('search') && $('.searchMenu h3').hasClass('open')) {
        $('.quickSearchContainer').slideToggle();
        $('.searchMenu h3').removeClass('open');
    }
	for(var i in all_requests){ all_requests[i].abort();} all_requests=[]; clearTimeout(model_label_animation);
	url=set_adv_search(url,"",0);
	if(url.indexOf("search.php")>0&&url.indexOf("sort_by")<0&&url.indexOf("adv_search")<0){if(url.indexOf("browse_by")>0){url=url+"&sort_by="+global_sort_browse;}else{url=url+"&sort_by="+global_sort_search;}}
	if(url.indexOf("ref=")<0){ if(ref!=null&&ref!="") { if(url.indexOf("?")>=0){ url=url+"&ref="+ref; }else{ url=url+"?ref="+ref; } } }
	url = decodeURIComponent(decodeURIComponent(url.replace("% ", "%25%20").replace("%%20", "%25%20")).replace("% ", "%25%20").replace("%%20", "%25%20"));
    //DEPENDING ON WHAT BUTTON WAS PRESSED WE DO DIFFERENT THINGS
    var e=e || window.event;
    var btnCode;
    var go=0;
    if ('object'===typeof e) { btnCode=e.button; }
    // adjust_ssearch(url);
    switch (btnCode) {
        case 0:
            go=1;
            break;
        case 1:
            go=2;
            break;
        case 2:
            go=0;
            break;
        default:
            go=1;
    }

    if (go == 1) { urlrequest(url,e,dontpush); }
    if (go == 2)
    {
        document.head.removeChild(nb_metaRobots);
        wopen=window.open(siteroot + "?" + url, "_blank"); if (wopen==null||typeof(wopen)=='undefined'){alert("Turn off your pop-up blocker!");}
    }
    if ( go>0 ) { try { document.head.removeChild(nb_metaRobots); } catch {} if(set_noindex == 1) { console.log("adding noindex"); document.head.appendChild(nb_metaRobots); } }
    set_noindex=0;
}

//Function for toolbox area
function OpenPageMenu(url) { $.get(url, function(response) { $('#leftmenu').html(response); }); }

//Function for toolbox area
function OpenQuiz(url){ $.get(url, function(response) { $('#quiz').html(response); }); }

function delete_ref_url(url)
{
	var newref=url.match(/(?:[?]|[&]|^)ref=((?:[^&]|$)+)/m);
	if(newref!==null)
	{
		var qmark=newref[0].indexOf("?"); var f_newref=null;
		if(qmark>=0&&qmark<5)
		{ url=url.replace(newref[0],"?");}
		else
		{ url=url.replace(newref[0],""); }
	}
	else
	{ newref=Array(null,null); qmark=0; }
	return([url,newref[1],qmark]);
}

$(document).ready(function() {

    var flg=0;
    $('#model_id').on("select2:open", function (){ flg++; if(flg==1){ $(".select2-results").append('<div class=""><a class="btn  blue advanceBtnSelect" onmousedown="OpenPage('+"'"+'search/adv_search.php'+"'"+',event);">Advanced Search</a></div>'); } });

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
        scrolltoid('content',1);
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

	var ref_info=new Array(); var f_newref=null; var qmark=-1; var first_ref_run=true;
	do
	{
		ref_info=delete_ref_url(currentpage);
		if(ref_info[1]!==null)
		{
			currentpage=ref_info[0];
			if(first_ref_run)
			{ var f_newref=ref_info[1]; first_ref_run=false; }
		}
	}
	while(ref_info[1]!==null);

	qmark=currentpage.indexOf("?")+1;
	if(currentpage[qmark]!==null&&currentpage[qmark+1]!=undefined){qmark=-1;}else{qmark=1}

	if(f_newref!==null)
	{
		if(ref!=f_newref)
		{
			if (window.XMLHttpRequest)	{ var	xmlhttp = new XMLHttpRequest(); }
			xmlhttp.onreadystatechange = function()
			{
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
				{
					if(parseInt(xmlhttp.responseText)==1)
					{ ref=f_newref; if(qmark>=0&&qmark<5) { currentpage=currentpage+"ref="+ref; }else{ currentpage=currentpage+"&ref="+ref; } }
					else
					{ ref=null; }
					first = 1; OpenPage(currentpage);
				}
				else
				{
					if (xmlhttp.readyState == 4 && xmlhttp.status != 200)
					{
						if(qmark>=0&&qmark<5) { currentpage=currentpage+"ref="+"starchaser"; }else{ currentpage=currentpage+"&ref="+"starchaser"; }
						first = 1; OpenPage(currentpage);
					}
				}
			}
			xmlhttp.open("GET","libnb/php/checkref.php?ref="+f_newref,true);
			xmlhttp.send();
		}
		else
		{ first = 1; OpenPage(currentpage); }
	}
	else
	{ first = 1; OpenPage(currentpage); }

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

function await_until_function_1(conditionFunction)
{
	const poll_1 = resolve =>
	{
		if(conditionFunction()) {  resolve(); }
		else { setTimeout(_ => poll_1(resolve), 300); }
	}
	return new Promise(poll_1);
}

// ADDING METADATA TO A PAGE FOR SEO
function metakeys(metakeys) {
    $('meta[name=keywords]').remove();
    $('head').append('<meta name="keywords" content="' + metakeys + '">');
}

//SCROLLTOFUNCTION
function scrolltoid(id,mobile) { var go=1; if(mobile && (!ismobile)){go=0;} if(go){ $('html,body').animate({ scrollTop: $("#" + id).offset().top }, 'slow'); } }
function go_to_top(){ $('html,body').animate({scrollTop:0},'slow'); }

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
	else if(button_el.getAttribute("aria-expanded") == "false" || button_el.getAttribute("aria-expanded") == "permanentfalse"){button_el.setAttribute("aria-expanded", "true");
     // document.querySelector(".SearchParameters").style.display = "block";
 }
});

function state_ssearch(type)
{
    var button_el=document.getElementsByClassName("cssmenu")[0];
	if (type == 0) { button_el.click(); button_el.setAttribute("aria-expanded", "true"); }
    if (type == 1) { button_el.setAttribute("aria-expanded", "false"); }
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

function getScripts(scripts, callback)
{
	var progress = 0;
	scripts.forEach(function(script) { $.getScript(script, function () { if (++progress == scripts.length) callback(); }); });
}

/*make vissible search modbile */
$('.searcButtonMobile').click(function() { $('#modelfind').toggleClass('vissible'); });

$('.searchMenu').click(function() {
   $('.quickSearchContainer').slideToggle();
   $('.searchMenu h3').toggleClass('open');

});

const sync_sleep = ms => { const end = Date.now() + ms; while (Date.now() < end) { continue; } }
function async_sleep(ms){ return new Promise(resolve => setTimeout(resolve, ms)); }
function noteb_round(value, precision) { var multiplier = Math.pow(10, precision || 0); return Math.round(value * multiplier) / multiplier; }
function hourminutes(str)
{
	str=parseFloat(str); hours=parseInt(str); minutes=Math.round((((str-hours)*60)/5),0)*5;
	if(minutes==60){hours++; minutes=0;}
	if(minutes<10){zero="0";}else{zero="";}
	return hours+":"+zero+minutes;
}

function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
  var expires = "expires=" + d.toUTCString();
  document.cookie =
    cname + "=" + cvalue + ";" + expires + "; samesite=lax; path=/";
}

function getCookie(cname) {
  var name = cname + "=";
  var ca = document.cookie.split(";");
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == " ") {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function deleteCookie(cname) {
  document.cookie = `${cname}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;
}

function get_url_params(url = window.location.toString()) {
  let params = {};
  url = url.replace(siteroot + "?", siteroot);
  params = new URL(url).searchParams;
  return params;
}

function proc_search_param_to_array(param_array) {
  var saved_array = {};
  for (var key in param_array) {
    var new_key_parts = param_array[key]["name"].toLowerCase().split("_");
    if (new_key_parts[0] !== undefined && new_key_parts[1] !== undefined) {
      if (saved_array[new_key_parts[0]] === undefined) {
        saved_array[new_key_parts[0]] = {};
      }
      if (param_array[key]["name"].indexOf("[]") >= 0) {
        if (saved_array[new_key_parts[0]][new_key_parts[1]] == undefined) {
          saved_array[new_key_parts[0]][new_key_parts[1]] = [];
        }
        saved_array[new_key_parts[0]][new_key_parts[1]].push(
          param_array[key]["value"]
        );
      } else {
        saved_array[new_key_parts[0]][new_key_parts[1]] =
          param_array[key]["value"];
      }
    }
  }
  return saved_array;
}

// PROGRESS BAR

var PROGRESSBAR = (function () {
  var DEFAULT_MIN = 0;
  var DEFAULT_MAX = 100;

  function getPercentage(value, min, max)
  {
    if (min === undefined){ min = DEFAULT_MIN; }
    if (max === undefined){ max = DEFAULT_MAX; }
    return Math.round(((value - min) / (max - min)) * 100);
  }

  function mock_error(content) { return `<div class="progressBar__error">${content}</div>`; }
  function mock_bar(blocks, percent)
  {
    return `
      <div class="progressBar__bar">${blocks}</div>
      <div class="progressBar__percent">${percent}%</div>
    `;
  }

  // Create blocks in bar
  function createRatingBlocks(percentage)
  {
    var BLOCK_COUNT = 10;
	var coloredCount = Math.round(percentage / BLOCK_COUNT);

    var result = new Array(BLOCK_COUNT)
      .fill(undefined)
      .map(function (_, index) {
        return `<div class="progressBar__block ${
          index < coloredCount ? "colored" : ""
        }"></div>`;
      });
    return result.join("");
  }

  function create({ target, value, min, max, maxWidth, align })
  {
    var result = "";

    if (min === undefined) { min = DEFAULT_MIN; }
    if (max === undefined) { max = DEFAULT_MAX; }

    if (value === undefined || value < min || value > max)
	{ result = mock_error("Not available."); }
	else
	{
      var percent = getPercentage(value, min, max);
      result = mock_bar(createRatingBlocks(percent), percent);
    }

    function alignIsValid(type) { return ["left", "center", "right"].includes(type); }

    // Handle if target exists
    if (target)
	{
      var element = document.querySelector(target);

      if (!element.classList.contains("progressBar")) { element.classList.add("progressBar"); }

      if (alignIsValid(align)) { element.classList.add(`progressBar--${align}`); }

      if (maxWidth) { element.style.maxWidth = maxWidth; }

      element.innerHTML = result;
      return;
    }

    // Handle string output
    var maxWidthStyle = `${maxWidth ? `max-width: ${maxWidth}` : ""}`;
    var alignClass = alignIsValid(align) ? `progressBar--${align}` : "";

    return `<div class="progressBar ${alignClass}" style="${maxWidthStyle}">${result}</div>`;
  }

  function update({ target, value, min, max })
  {
    if (target == null || value == null)
	{
		throw new Error(`Target or value cannot be null`);
    }

    var elements = document.querySelectorAll(target);
	if(elements)
	{
		for( var key in elements)
		{
			if (!elements[key])
			{
			  throw new Error(`Progress bar ${target} not found.`);
			}

			var percent = getPercentage(value, min, max);
			var result = mock_bar(createRatingBlocks(percent), percent);

			elements[key].innerHTML = result;
		}
	}
	else
	{ throw new Error(`Progress bar ${target} not found.`); }

    return;
  }

  return { create, update };
})();

// Update this time to decide the hidden time for the snackbar
// Currently the time is 8 days
const timeToStayHidden = 8;

var hideSnackbarCookie = getCookie("hideSnackbar");

// Function to show the snackbar
function showSnackbar() {
    let element = document.getElementById('snackbar');
    if (element) { element.classList.add('show'); element.style.visibility = 'visible'; }
}

// Function to dismiss the snackbar
function dismissSnackbar() {
    let element = document.getElementById('snackbar');
    if (element) { element.classList.remove('show');  if (element) element.style.visibility = 'hidden'; }
    setCookie("hideSnackbar", "true", timeToStayHidden);
}

//# sourceURL=index.js