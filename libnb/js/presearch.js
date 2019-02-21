var pause_presearch=1; var cur_advss="";  var cur_sss=""; var cur_qss=""; setTimeout(function(){ pause_presearch=0; },2000);

function presearch(formname)
{
	var do_presearch=0; var sstring="";
	switch(formname)
	{
		case "#advform": { var sstring=$(formname).serialize(); if(cur_advss!=sstring){cur_advss=sstring; do_presearch=1;} break;}
		case "#s_search": { var sstring=$(formname).serialize(); if(cur_sss!=sstring){cur_sss=sstring; do_presearch=1;} break;}
		case "quiz":
		{ 
			var tosearch="b"; quiz_submit=[]; i=0;
			for (var key1 in quiz)
			{
				var opt=quiz[key1]['options'];
				for (var key2 in opt)
				{ var selected=opt[key2]; if ((typeof selected['chk']) != 'undefined' && selected['chk']['on']==1 && selected['no']>0 && key1!=4 && key1!=5){ quiz_submit[i]=key2+"=1"; i++; } }
			}
			if(i>0)
			{
				var sstring="quizsearch=1&"+quiz_submit.join("&");
				if(cur_qss!=sstring){cur_qss=sstring; do_presearch=1;}
			}
			break;
		}
	}

	if(do_presearch&&!pause_presearch&&sstring!="")
	{
		pause_presearch=1;
		setTimeout(function()
		{
			if (formname === ""){ return; }
			else 
			{
				if (window.XMLHttpRequest)	{ var	xmlhttp = new XMLHttpRequest(); }

				xmlhttp.onreadystatechange = function() 
				{
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
					{
						console.log(xmlhttp.responseText.split("+++++")[1]);
					}
				}
				if(formname!="quiz"){ xmlhttp.open("GET","search/search.php?presearch=1&"+sstring,true); }
				else{ xmlhttp.open("GET",nquiz+"search/qsearch.php?p=1&presearch=1&"+sstring,true); }
				xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xmlhttp.send();
			}
		pause_presearch=0;
		},250);
	}
}
