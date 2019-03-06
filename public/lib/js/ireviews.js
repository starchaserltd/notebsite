$(document).ready(function()
{
	actbtn("USER");
	document.title="Noteb - Add reviews";
    $(".modelsearch").each(function(){
	var query_address=siteroot+"/search/lib/func/m_search.php";
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
			url: query_address,
			type: "POST",
			data: function (params) {
				var queryParameters = {
					list: $this.attr('field'),
					q: "model",
					ex: "USD",
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

//Function for form submissions left menu   
$("#ireviews_form_btn").click(function () {
	model_names=new Array();
	for(var i=0;i<((Object.keys($("#model_id_ireviews :selected")).length)-2);i++)
	{ model_names[i]=$("#model_id_ireviews :selected")[i].text; }
	document.getElementById("model_name_ireviews").value=model_names;
	scrolltoid('content');
	$('#loadingNB').show();
	trigger=0;
	$.post('public/ireviews.php', $("#ireviews_form").serialize(), function(data) {
		url = "public/ireviews.php"; if(url.indexOf("ref=")<0){ if(ref!=null&&ref!="") { url=url+"&ref="+ref; } }
		if($('#content').html(data)){ $('#loadingNB').hide();}
		history.pushState({}, 'NoteBrother', "?" + url);
	});
});