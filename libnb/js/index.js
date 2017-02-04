//Initialization

var trigger=1;
var z=0;
var first=1;
var firstcompare=1;
var nocomperrormess=0;
var previousurl="";
var disqusloaded=1;
var urlold="";
var hh=1;
var currentPage = window.location.href;
function locationHashChanged() {
   if (trigger) {
        var urlParts = window.location.href.split('?');		
        var first = 0;
        var currentpage = "";
        if (urlParts[1] == "undefined") {
            var currentpage="content/home.php";
        } else {
            for (var value of urlParts) {
              
				if(first) {
					
                    if(first>1)
					currentpage = currentpage + "?" + value;
					else
					{
					currentpage = currentpage + value;
					first++;
					}
				}
                else {
                    first++;
                }
            }
    }

    OpenPage(currentpage,1,1); //dontpush is set to 1 to prevent pushing states on back and forward buttons, use OpenPage function on all links
   }
   	trigger=1;
 }



setInterval(function()
{
    if (currentPage !== window.location.href)
    {
		// page has changed, set new page as 'current'
        currentPage = window.location.href;
        //console.log("");
		locationHashChanged();
    }
}, 50);



function urlrequest(url,e,dontpush)
{
	trigger=0;
	
	$('#loadingNB').show();
    $.get(url, function(response) {
	var urltitle=/([^\/]*).php/g.exec(url); urltitle=urltitle[1];
	if(!dontpush)
	{ dontpush=0;  if(first){ history.replaceState({}, 'NoteBrother'+' '+urltitle, "?" + url); first=0;} else {  history.pushState({}, 'NoteBrother'+' '+urltitle, "?" + url); } }
	currentpage=url;
	if($('#content').html(response)){ $('#loadingNB').hide(); }
	});		
}


//Function for main content area
function OpenPage(url,e,dontpush) {
	url=decodeURIComponent(decodeURIComponent(url));
	
	//DEPENDING ON WHAT BUTTON WAS PRESSED WE DO DIFFERENT THINGS
	var e = e || window.event;
	var btnCode;
	var go=0;
	if ('object' === typeof e) { btnCode = e.button; }

	switch (btnCode)
	   {
		   case 0: go=1; break;
		   case 1: go=2; break;
		   case 2: go=0; break;
		   default: go=1; 
	   }  
	
	if(go==1 || go==2)
	{
		
		document.getElementsByClassName("socicon-facebook")[0].href="https://www.facebook.com/sharer/sharer.php?u="+siteroot+"/?"+url;
		document.getElementsByClassName("socicon-facebook")[1].href="https://www.facebook.com/sharer/sharer.php?u="+siteroot+"/?"+url;
		document.getElementsByClassName("socicon-twitter")[0].href="https://twitter.com/home?status=Just%20found%20great%20notebook%20information%20on%20"+siteroot+"/?"+url;
		document.getElementsByClassName("socicon-twitter")[1].href="https://twitter.com/home?status=Just%20found%20great%20notebook%20information%20on%20"+siteroot+"/?"+url;
		document.getElementsByClassName("socicon-google-plus")[0].href="https://plus.google.com/share?url="+siteroot+"/?"+url; 
		document.getElementsByClassName("socicon-google-plus")[1].href="https://plus.google.com/share?url="+siteroot+"/?"+url; 
	}
	
	if(go==1)
	{
		urlrequest(url,e,dontpush);
	}
	
	if(go==2)
	{  window.open(siteroot+"/?"+url,"_blank"); }
}

//Function for toolbox area
function OpenPageMenu(url) {

			//console.log("1"+url);
    $.get(url, function(response) {
        $('#leftmenu').html(response);
    });
}


//Function for toolbox area
function OpenQuiz(url) {

			//console.log("1"+url);
    $.get(url, function(response) {
        $('#quiz').html(response);
    });
}


$(document).ready(function(){ 

 //console.log("ready");
 
    // Start tooltips
    $('[data-toggle="tooltip"]').tooltip(); 

    // Script pentru meniul din stanga   
    $('#cssmenu li.active').addClass('open').children('ul').show();
    $('#cssmenu li.has-sub>a').on('click', function(){
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

    //Function for form submissions left menu   
    $("#s_search_btn").click(function () {
			scrolltoid('content');
			$('#loadingNB').show();
            trigger=0;
            $.get('search/search.php', $("#s_search").serialize(), function(data) {
                url = "search/search.php" + "?" + $("#s_search").serialize();
                history.pushState({}, 'NoteBrother', "?" + url);
                currentpage = url;
                if($('#content').html(data)){ $('#loadingNB').hide();}
            });
    });
	
    //Function for form model search left menu   
    $("#modelfind_btn").click(function () {
			scrolltoid('content');
			$('#loadingNB').show();
            trigger=0;
            $.get('model/model.php', $("#modelfind").serialize(), function(data) {
                url = "model/model.php" + "?" + $("#modelfind").serialize();
                history.pushState({}, 'NoteBrother', "?" + url);
                currentpage = url;
                if($('#content').html(data)){ $('#loadingNB').hide();}
            });
        
    });
	
	
	 //Function for advanced search form  
	    $(".advsearch").click(function () {
		scrolltoid('content');
		var urlParts = window.location.href.split('?');		
        var first = 0;
        var currentpage = "";
		
        if (urlParts[1] == "undefined") {
            var currentpage="search/adv_search.php";
        } else {
            for (var value of urlParts) {
              
				if(first) {
					
                    if(first>1)
					currentpage = currentpage + "?" + value;
					else
					{
					currentpage = currentpage + value;
					first++;
					}
				}
                else {
                    first++;
                }
            }
		}
        
		remnant=currentpage.split("search.php?");
		
		if(remnant[1])
		{		
		d = "search/adv_search.php?" + remnant[1];
		}
		else
		{
		d = "search/adv_search.php?";
		}
		//trigger=0;
		//console.log("2"+d);
		OpenPage(d);
    });
	
    //Load main content area
    if(!(window.location.href.split('?')[1])) {
        currentpage="content/home.php"
    } else {
        var urlParts = window.location.href.split('?');
        var currentpage = urlParts.slice(1).join('?');
    }
	first=1;
    OpenPage(currentpage);
	
	
	/* HERE we have the script for quick model search */

    $(".modelsearch").each(function(){
	var $this = $(this);
	$this.select2({
			tags: false,
			multiple: false,
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
			data: function (params) {
			//	console.log($idtype);
				var queryParameters = {
					list: $this.attr('field'),
					q: "model",
					keys: params.term,
				}
				return queryParameters;
			},
			processResults: function(data) {
				return {
					results: $.map(data, function (item) {
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
});

//THE SORT BY RESULTS BUTTONS 

	function sortresults(sortby)
	{
		
		var urlParts = window.location.href.split('?');		
        var first = 0;
        var currentpage = "";
		
        if (urlParts[1] == "undefined") {
            var currentpage='content/home.php';
        } else {
            for (var value of urlParts) {
              
				if(first) {
					
                    if(first>1)
					currentpage = currentpage + "?" + value;
					else
					{
					currentpage = currentpage + value;
					first++;
					}
				}
                else {
                    first++;
                }
            }
		}
        
		var newcurrentpage = currentpage.split('&sort_by');
		ifexchange = /(exchange=(.*?))($|&)/.exec(newcurrentpage[1]);

		if((newcurrentpage[0].indexOf("/search.php?") > -1) || (newcurrentpage[0].indexOf("/search.php?") > -1 ))
		{		
		
		if(ifexchange!=null)
		{ 	
			newpage = newcurrentpage[0] +"&exchange=" + ifexchange[2] +"&sort_by=" + sortby; 
		} else { newpage = newcurrentpage[0] + "&sort_by=" + sortby; }
		
		}
		else
		{
		if(ifexchange!=null){ newpage = "search/search.php?exchange="+ifexchange[2]+"&sort_by=" + sortby; } else { newpage = "search/search.php?exchange=1"+"&sort_by=" + sortby; }
		}
		
		return newpage;
	}
	
	
	//CHANGE EXCHANGE RATE RESULTS BUTTONS 
	function exchangeresults(exchange)
	{
		
		var urlParts = window.location.href.split('?');		
        var first = 0;
        var currentpage = "";
		
        if (urlParts[1] == "undefined") {
            var currentpage='content/home.php';
        } else {
            for (var value of urlParts) {
              
				if(first) {
					
                    if(first>1)
					currentpage = currentpage + "?" + value;
					else
					{
					currentpage = currentpage + value;
					first++;
					}
				}
                else {
                    first++;
                }
            }
		}
		var addadv=""; var exadv="exchange=";
        var urlminbudget = /\/?bdgmin=([0-9]+)/.exec(currentpage);
		if(urlminbudget==null){ urlminbudget = /\/?bdgminadv=([0-9]+)/.exec(currentpage); if(urlminbudget!==null){ addadv="adv"; } }
		var urlmaxbudget = /\/?bdgmax=([0-9]+)/.exec(currentpage);
		if(urlmaxbudget==null){ urlmaxbudget = /\/?bdgmaxadv=([0-9]+)/.exec(currentpage); if(urlmaxbudget!==null){ addadv="adv"; } }
		var urlexchange = /(exchange=(.*?))($|&)/.exec(currentpage);
		if(urlexchange==null){ urlexchange = /(exchadv=(.*?))($|&)/.exec(currentpage); if(urlexchange!==null){ exadv="exchadv="; } }


		if((urlexchange!=null)&&(urlminbudget!=null)&&(urlmaxbudget!=null))
		{
		urlexchangeval=currency_val[urlexchange[2]];
		exchangeval=currency_val[exchange];
		urlminbudgetval=parseInt(urlminbudget[1]);
		urlmaxbudgetval=parseInt(urlmaxbudget[1]);
		newpage=currentpage.replace((urlexchange[1]),(exadv+exchange));
		newpage=newpage.replace((urlminbudget[0]),("bdgmin"+addadv+"="+parseInt((urlminbudgetval/urlexchangeval)*exchangeval)));
		newpage=newpage.replace((urlmaxbudget[0]),("bdgmax"+addadv+"="+parseInt((urlmaxbudgetval/urlexchangeval)*exchangeval)));
		}
		else
		{
			if(urlexchange!=null)
			{ 
			newpage=currentpage.replace((urlexchange[1]),(exadv+exchange));
				
			}
			else
			{
				newpage=currentpage+"&"+exadv+exchange;	
			}
		}
		return newpage;
	}


//SETTING THE CURRENTLY ACTIVE MENU BUTTON

function actbtn(pagename,mobile)
{
	if(!mobile)
	{ $( ".btn-sus" ).removeClass( "active" ); }
	
	$( ".btn-sus" ).each(function(index) {
	if(this.innerHTML==pagename){
		$(this).addClass("active");
		}
	});
}

function occur(string, subString, allowOverlapping)
{
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
function metakeys(metakeys)
{
    $('meta[name=keywords]').remove();
    $('head').append( '<meta name="keywords" content="'+metakeys+'">' );
	
}
 
 //SCROLLTOFUNCTION
 function scrolltoid(id){
$('html,body').animate({scrollTop: $("#"+id).offset().top},'slow');
}

//ACTIVE  - DEACTIVE menu buttons
$(".btn-group > .btn-sus").click(function(){
    $(".btn-group > .btn-sus").removeClass("active");
    $(this).addClass("active");
	});	