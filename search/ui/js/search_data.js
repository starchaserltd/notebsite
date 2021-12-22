var nb_search_data={};

function get_nom_search_data()
{
	var get_nom_data=false;
	if(Object.keys(nb_search_data).length === 0)
	{ get_nom_data=true; }
	else
	{
		if(nb_search_data.site.gen_time)
		{
			if (window.XMLHttpRequest){ var	xmlhttp = new XMLHttpRequest(); }
			xmlhttp.onreadystatechange = function() 
			{
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
				{
					//console.log(xmlhttp.responseText);
					reply = JSON.parse(xmlhttp.responseText);
					if(reply!=false && reply["new_data"].length>0){ get_nom_data=true; }
				}
			}
			xmlhttp.open("POST","search/ui/php/nom_data.php",true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send("last_gen_date="+nb_search_data.site.gen_time+"&test_gen_time=1");
		}
		else
		{ get_nom_data=true; }
	}

	if(get_nom_data)
	{
		if (window.XMLHttpRequest){ var	nomen_xmlhttp = new XMLHttpRequest(); }
		nomen_xmlhttp.onreadystatechange = function() 
		{
			if (nomen_xmlhttp.readyState == 4 && nomen_xmlhttp.status == 200) 
			{
				//console.log(nomen_xmlhttp.responseText);
				nb_search_data = JSON.parse(nomen_xmlhttp.responseText);
			}
		}
		nomen_xmlhttp.open("POST","search/ui/php/search_defaults.php",true);
		nomen_xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		nomen_xmlhttp.send("get_new_search_data=1");
	}
}
