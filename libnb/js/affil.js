function setCookie(cname,cvalue,exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
	var expires = "expires=" + d.toUTCString();
	document.cookie = cname + "=" + cvalue + ";" + expires + "; samesite=lax; path=/";
}

function getCookie(cname) {
	var name = cname + "="; var ca = document.cookie.split(';');
	for (var i = 0; i < ca.length; i++)
	{
		var c = ca[i];
		while (c.charAt(0) == ' ') { c = c.substring(1); }
		if (c.indexOf(name) == 0) { return c.substring(name.length, c.length); }
	}
	return "";
}

function deleteCookie(cname) { document.cookie = `${cname}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`; }

var learnMoreEl = `
    <p>
	For sales originating from noteb.com, some stores may give to noteb 0 to 3% commission from the value of those sales.<br><br>This system is called affiliate marketing, and for the buyer, it has <b>zero impact on the price</b>.
<br><br>Also, while noteb.com employes no tracking cookies, some of these programs may employ cookies for tracking purchase referral and how you interact with the offers presented. These tracking cookies can last between 1 to 30 days, depending on the retailer.<br><br>As an Amazon Associate and member of other affiliate programs, noteb.com earns from qualifying purchases.
<br><br>Noteb.com keeps for ten days your option of following store links with or without affiliation.</p>
`
var org_learnMoreEl=`<a href=\"#\" style="color: #000000;">Learn more</a>`;
var listeners_set = false;

function create_affil_modal(set_link) {
	var affil_popup = $('#affil-popup');

	affil_popup.addClass('visible');
	$(document).keydown(function (e) { if (e.keyCode == 27) { close_popup_extra(affil_popup); } }); // escape

	if (listeners_set) return;

	$('#learn-more-affil-btn').click(function (e) { e.preventDefault(); $('#learn-more-affil-btn').html(learnMoreEl); affil_popup.addClass('width'); });
	$(document).click(function (event) { if (!$(event.target).closest("#modal-affil-content,a").length) { close_popup_extra(affil_popup); } });
	$(document).on('keypress', function (e) { if (e.keyCode == 13) { $('#yes-affil-btn').click(); $(document).off('keypress'); close_popup_extra(affil_popup); } }); //enter
	$('#close-affil-btn').click(function () { $(document).off('keypress'); close_popup_extra(affil_popup); });

	$('#yes-affil-btn').click(function () {
		$(document).off('keypress');
		setCookie('ref','starchaser',10);
		get_aff_link(set_link);
		record_choice(1);
		close_popup_extra(affil_popup);
	});

	$('#no-affil-btn').click(function () { $(document).off('keypress'); setCookie('ref','noref',10); close_popup_extra(affil_popup); store_window=window.open('','_blank'); record_choice(0); store_window.location=set_link; });

	listeners_set = true;
}

function get_aff_link(set_link)
{
	set_link=escape(set_link);
	var ref=''; var storedRef = getCookie('ref'); var unique_nr=make_r_int(); var store_window=window.open('','_blank');
	if (storedRef) { ref = storedRef; }else{ if(window.ref!=null){ref=window.ref;} }
	if (window.XMLHttpRequest) { var xmlhttp = new XMLHttpRequest(); }
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4) {
			if (xmlhttp.status == 200) {
				var res=xmlhttp.responseText; res=JSON.parse(res);
				if (res[0] == null) { console.log(res[1]); store_window.location=set_link; }
				else { store_window.location=res[0]; }
			}
			else { console.log(xmlhttp.statusText); store_window.location=set_link; }
		}
	}
	xmlhttp.onerror=function (e){ console.log(xmlhttp.statusText); store_window.location=set_link; };
	
	xmlhttp.open("POST", "libnb/php/aff_gen.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send(`usertag=${ref}&links=${set_link}`);
}

function make_r_int(){ return Math.floor((Math.random()*100)+1); }

function close_popup_extra(affil_popup){ if(document.getElementById('affil-popup')!==null&&document.getElementById('affil-popup').classList.contains('width')){$('#learn-more-affil-btn').html(org_learnMoreEl); affil_popup.removeClass('width');} affil_popup.removeClass("visible"); }

function show_buy_dropdown(el)
{
	if (window.XMLHttpRequest) { var xmlhttp = new XMLHttpRequest(); }
	var ref = ''; var storedRef = getCookie('ref');

	if (storedRef) { ref = storedRef; }
	else { ref = el.dataset.ref; }

	if(show_buy_list == 0)
	{ window.setTimeout(get_buy_list(document.getElementById(el.id)), 100); }
	else
	{
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				if(document.getElementById(el.dataset.target)!==null)
				{
					document.getElementById(el.dataset.target).innerHTML = xmlhttp.responseText;

					// set click listener for links to modify when its done
					if (!ref && !getCookie('ref')) {
						$('#' + el.dataset.target).on('click', 'a', function (event) {
							if (!ref && !getCookie('ref')) { event.preventDefault(); var set_link = $(this).attr('href'); create_affil_modal(set_link) }
						});
					}
				}
			}
		}
	}
	xmlhttp.open("POST", "model/lib/php/buy_list.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	var conf_info=""; for(var key in laptop_comp_list){ if(typeof(el.dataset["id"+laptop_comp_list[key]])!=="undefined"){ conf_info=conf_info+"&"+laptop_comp_list[key]+"="+el.dataset["id"+laptop_comp_list[key]]; } }
	if(typeof(el.dataset.conf)!=="undefined"){ conf_info=conf_info+"&conf="+el.dataset.conf; }
	xmlhttp.send('idmodel=' + el.dataset.idmodel + '&mprod=' + el.dataset.mprod + '&buyregions=' + el.dataset.buyregions + '&lang=' + el.dataset.lang + '&usertag=' + ref + '&price=' + el.dataset.price + '&pmodel=' + el.dataset.pmodel + conf_info);
}


function affil_q(el)
{ var set_link = $(el).attr('href'); if(!ref && !getCookie('ref')){ create_affil_modal(set_link); return false; }else{ get_aff_link(set_link); return false;} }

function record_choice(choice_val)
{
	if (window.XMLHttpRequest) { var xmlhttp = new XMLHttpRequest(); }
	xmlhttp.open("POST", "libnb/php/aff_choice.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send('choice=' + choice_val);
}

function get_buy_list(el) {
	setTimeout(function () {
		if (el.getAttribute("aria-expanded") === "true") {
			if (el.dataset.target === "") { return; }
			else { show_buy_dropdown(el); }
		}
	}, 5);
}