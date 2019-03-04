$(document).ready(function()
{
	//actbtn("USER");
	//document.title="Noteb - Add reviews";
    $(".modelsearch").each(function(){
	var query_address=siteroot+"/search/lib/func/m_search.php";
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
			url: query_address,
			type: "POST",
			data: function (params) {
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
								text: item.model,
							};
						})
					};
				}
			}
		})
	});
});


 $(".modelsearch").on("select2:select", function(e) { var $this = $(this); complete_text_info($this.select2('val')); });

function complete_text_info(model_id)
{
	setTimeout(function()
	{
		document.getElementById("info_com").value="";
		document.getElementById("source_com").value="";
		if (model_id==null && model_id==""){ return; }
		else 
		{
			if (window.XMLHttpRequest)	{ var	xmlhttp = new XMLHttpRequest(); }
			
			xmlhttp.onreadystatechange = function() 
			{
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
				{
					result_json=JSON.parse(xmlhttp.responseText);
					if(result_json[0]!=undefined&&result_json[0]!=null&&result_json[0]!="")
					{
						if(result_json[0]["comment"]!=undefined&&result_json[0]["comment"]!=null&&result_json[0]["comment"]!="")
						{ document.getElementById("info_com").value=result_json[0]["comment"]; }
						
						if (window.XMLHttpRequest)	{ var	xmlhttp_2 = new XMLHttpRequest(); }
						xmlhttp_2.onreadystatechange = function() 
						{
							if (xmlhttp_2.readyState == 4 && xmlhttp_2.status == 200) 
							{
								result_json=JSON.parse(xmlhttp_2.responseText);
								if(result_json[0]!=undefined&&result_json[0]!=null&&result_json[0]!="")
								{
									if(result_json[0]["source"]!=undefined&&result_json[0]["source"]!=null&&result_json[0]["source"]!="")
									{ document.getElementById("source_com").value=result_json[0]["source"]; }
								}
							}
						}
						xmlhttp_2.open("POST","../public/lib/php/queries.php",true);
						xmlhttp_2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						xmlhttp_2.send('list=source_info&keys='+model_id);
					}
				}
			}
			xmlhttp.open("POST","../public/lib/php/queries.php",true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send('list=com_info&keys='+model_id);
		}
	},10);
	models_msc_info(model_id);
	return model_id;
}


function models_msc_info(model_id)
{
	setTimeout(function()
	{
		document.getElementById("models_msc").innerHTML="";
		if (model_id==null && model_id==""){ return; }
		else 
		{
			if (window.XMLHttpRequest)	{ var	xmlhttp = new XMLHttpRequest(); }
			
			xmlhttp.onreadystatechange = function() 
			{
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
				{
					result_json=JSON.parse(xmlhttp.responseText);
					if(result_json[0]!=undefined&&result_json[0]!=null&&result_json[0]!="")
					{
						if(result_json[0]["models_msc"]!=undefined&&result_json[0]["models_msc"]!=null&&result_json[0]["models_msc"]!="")
						{ document.getElementById("models_msc").innerHTML=result_json[0]["models_msc"]; }
					}
				}
			}
			xmlhttp.open("POST","../public/lib/php/queries.php",true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send('list=models_msc&keys='+model_id);
		}
	},10);
	return model_id;
}

/*
$(".predbvalues").each(function()
{
	var $this = $(this);
	$this.select2({
    tags: true,
    multiple: false,
    tokenSeparators: [','],
    minimumInputLength: 1,
	//maximumResultsForSearch: 20,
	searchType: "contains",
	language: {
	noResults: function(term) {
		return "Type website name...";
		}
	},
    ajax: { 
		quietMillis: 100,
		cache: false,
		dataType: "json",
        type: "POST",
		url:  siteroot+$($this[0]).attr('data-url'),
        data: function (params) {
			type=$($this[0]).attr('data-type');
            var queryParameters = {
				list: type,
				keys: params.term
			}
			return queryParameters;
        },
        processResults: function (data) {
            return {
                results: $.map(data, function (item) { item.id=item.name;
					return {
						id: item.name,
                        text: item.name
                    }
				})
            };
        }
    }
})
});
*/

//Function for form submissions left menu   
$("#coms_form_btn").click(function () {
	model_names=new Array();
	for(var i=0;i<((Object.keys($("#model_ids :selected")).length)-2);i++)
	{ model_names[i]=$("#model_ids :selected")[i].text; }
	document.getElementById("model_names").value=model_names;
	//scrolltoid('content');
	//$('#loadingNB').show();
	//trigger=0;
	//$.post('private/cominfo.php', $("#com_info_form").serialize(), function(data) {
		//url = "private/cominfo.php"; if(url.indexOf("ref=")<0){ if(ref!=null&&ref!="") { url=url+"&ref="+ref; } }
	//	if($('#result').html(data)); /*{ $('#loadingNB').hide();}
	//	history.pushState({}, 'NoteBrother', "?" + url);*/
	//});
});