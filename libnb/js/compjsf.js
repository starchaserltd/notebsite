nrcheckchange = -1;
if(typeof nrcheck === 'undefined' || nrcheck === null) { nrcheck = 0;}

function addcomplink(idstring)
{
	complinkold = complink;
	var Regexp = /([^?=&]+)\=([^&]+)(\&|$)/g;
	match = Regexp.exec(complinkold);
	complink = "";
	i = 0;
	k = 1;
	if(match != null)
	{
		while(match != null)
		{
			if(match[1].indexOf("conf") !== -1)
			{
				complink = complink + "&" + "conf" + i + "=" + match[2];
				i++;
			}
			else if(match[1] !== "ex")
			{
				if(k)
				{
					complink = complink + "&conf" + i + "=" + idstring;
					k = 0;
					i++;
				}
				complink = complink + "&" + match[1] + "=" + match[2];
			}
			match = Regexp.exec(complinkold);
		}
	}
	else
	{
		if(k)
		{
			complink = complink + "&conf" + i + "=" + idstring;
			k = 0;
		}
	}
	if(k)
	{
		complink = complink + "&conf" + i + "=" + idstring;
		k = 0;
	}
	if(complink[0] === "&")
	{
		complink = complink.substr(1);
	}
}

function removecomplink(idstring)
{
	complinkold = complink;
	var Regexp = /([^?=&]+)\=([^&]+)(\&|$)/g;
	match = Regexp.exec(complinkold);
	complink = "";
	i = 0;
	k = 1;
	while(match != null)
	{
		if(match[1].indexOf("conf") !== -1)
		{
			if(match[2] !== idstring)
			{
				complink = complink + "&" + "conf" + i + "=" + match[2];
				i++;
			}
		}
		else if(match[1] !== "ex")
		{
			complink = complink + "&" + match[1] + "=" + match[2];
		}
		match = Regexp.exec(complinkold);
	}
	if(complink[0] === "&")
	{
		complink = complink.substr(1);
	}
}
// ADD TO COMPARE FUNCTION
function addcompare(idconf)
{
	if(idconf)
	{
		var thedata = {
			sendid: idconf
		};
	}
	else
	{
		var thedata = {
			sendcpu: cpu["id"],
			sendgpu: gpu["id"],
			senddisp: display["id"],
			sendhdd: hdd["id"],
			sendshdd: shdd["id"],
			sendmem: mem["id"],
			sendchassis: chassis["id"],
			sendodd: odd["id"],
			sendwnet: wnet["id"],
			sendwar: war["id"],
			sendsis: sist["id"],
			sendacum: acum["id"],
			sendmdb: mdb["id"],
			sendmid: mid,
			sendcpuname: cpu["model"],
			sendgpuname: gpu["prod"] + " " + gpu["name"],
			senddissize: display["size"],
			senddisres: display["hres"] + "x" + display["vres"],
			sendmeminfo: mem["cap"] + "GB " + mem["type"],
			sendhddinfo: hdd["cap"] + "GB " + hdd["type"],
		};
	}
	$.ajax(
	{
		type: "POST",
		url: "libnb/php/addcomp.php",
		async: true,
		data: thedata,
		success: function (data)
		{
			var compinfo = data.split("++");
			if(compinfo[3] != "0")
			{
				elementtext = '<tr id="comprow' + compinfo[3] + '" class="items" style="background:#fff;"><td class="comparecell1"><div class="checkbox" style="margin:0 0 0 5px; width:0px;height:16px"><input type="checkbox" onclick="cchecks(' + "'" + compinfo[3] + "'" + ')" class="css-checkbox sme" id="checkbox' + compinfo[3] + '" ' + compinfo[1] + ' /><label style="font-weight:normal;min-height:16px;" for="checkbox' + compinfo[3] + '" class="css-label sme depressed"></label></div></td><td class="text-center comparecell3"><a  href="' + siteroot + "?model/model.php?conf=" + compinfo[3] + '"><img class="img-responsive" src="res/img/models/thumb/t_' + compinfo[10] + '" alt="' + compinfo[9] + '"></a></td><td class="comparecell2" ><a  href="' + siteroot + "?model/model.php?conf=" + compinfo[3] + '" class="comparename">' + compinfo[0] + '<div class="menuhidden">' + compinfo[6] + '", ' + compinfo[7] + ", " + compinfo[4] + ", " + compinfo[5] + ", " + compinfo[8] + ", " + compinfo[9] + '</div></a></td><td class="text-center" style="width:16px;padding-bottom:2px; padding-top:2px;"><a  style="color:#49505a;font-size:20px;padding:0px;background-color:#fff;" onclick="removecomp(' + "'" + compinfo[3] + "'" + ',0)"><span class="fas fa-times"></span></a></td></tr>';
				document.querySelector("#comparelist tbody")
					.insertAdjacentHTML("beforeend", elementtext);
				nrcheck = parseInt(compinfo[2]);
				if(firstcompare != 1)
				{
					$($("#cssmenu li.has-sub>a"))
						.parent("li")
						.removeClass("open");
					$($("#cssmenu li.has-sub>a"))
						.parent("li")
						.children("ul")
						.slideUp(200);
					$($("#cssmenu li.has-sub>a")[3])
						.parent("li")
						.addClass("open");
					$($("#cssmenu li.has-sub>a")[3])
						.parent("li")
						.children("ul")
						.slideDown(200);
					$($("#cssmenu li.has-sub>a")[4])
						.parent("li")
						.addClass("open");
					$($("#cssmenu li.has-sub>a")[4])
						.parent("li")
						.children("ul")
						.slideDown(200);
				}
				if(compinfo[1])
				{
					if(idconf)
					{
						addcomplink(idconf);
					}
					else addcomplink(compinfo[3]);
				}
			}
			else
			{
				if(compinfo[4] !== "max")
				{
					if(firstcompare == 0)
					{
						alert("Configuration already added to compare list!");
					}
				}
				else
				{
					alert(compinfo[0]);
				}
			}
		},
	});
}
setInterval(function ()
{
	if(nrcheckchange != nrcheck || nrcheckchange < 0 || excodechange != excode)
	{
		if(nrcheck < 1)
		{
			elementtext = '<tr id="toptrcomp"><td colspan="4" style="text-align:center; background:#fff; font-weight:600; border:0px;">Select at least two models for compare</td></tr>';
			$("table#comparelist tr#toptrcomp")
				.replaceWith(elementtext);
		}
		else
		{
			elementtext = '<tr id="toptrcomp"><td colspan="4" style="text-align:center;"><button onmousedown="firstcompare=0; OpenPage(' + "'model/comp.php?" + complink + "&ex=" + excode + "',event); scrolltoid('content',0);" + '" style="max-width: 150px; width: 100%;" onmouseup="setTimeout((e) => blur(), 1000)" type="button" class="btn btn-primary">Compare laptops</button></td></tr>';
			$("table#comparelist tr#toptrcomp")
				.replaceWith(elementtext);
		}
		nrcheckchange = nrcheck;
		excodechange = excode;
	}
}, 100);

function removecomp(nr, uncheck)
{
	if($("#checkbox" + nr)
		.prop("checked") === true)
	{
		if(nrcheck == 4)
		{
			nrcheck--;
		}
		nrcheck--;
		removecomplink(nr);
	}
	if(uncheck == 0)
	{
		// delete entry
		$("table#comparelist tr#comprow" + nr)
			.remove();
		$.ajax(
		{
			type: "POST",
			url: "libnb/php/delcomp.php",
			data:
			{
				conf: nr
			},
			dataType: "text",
		});
	}
	if(uncheck == 1)
	{
		//uncheck entry
		$("#checkbox" + nr)
			.prop("checked", false);
		$.ajax(
		{
			type: "POST",
			url: "libnb/php/checkcomp.php",
			data:
			{
				conf: nr
			},
			dataType: "text",
		});
		OpenPage("model/comp.php?" + complink);
	}
}

function cchecks(a)
{
	//alert(nrcheck);
	if($("#checkbox" + a)
		.prop("checked") === true)
	{
		if(nrcheck < 3)
		{
			nrcheck++;
			addcomplink(a);
		}
		else
		{
			$("#checkbox" + a)
				.prop("checked", false);
			alert("Maximum 4 configurations can be selected.");
			nrcheck = 4;
		}
	}
	else
	{
		if(nrcheck == 4)
		{
			nrcheck--;
		}
		nrcheck--;
		removecomplink(a);
	}
	$.ajax(
	{
		type: "POST",
		url: "libnb/php/checkcomp.php",
		data:
		{
			conf: a
		},
		dataType: "text",
	});
}