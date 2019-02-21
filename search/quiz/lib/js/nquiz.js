var ref=null; var nquiz="../../";

if (!(window.location.href.split('quiz')[1])) 
{ var currentpage = "search/quiz/nquiz.php"; }
else
{ var currentpage = window.location.href; }
	
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
			}
		}
		xmlhttp.open("GET","../../libnb/php/checkref.php?ref="+newref[1],true);
		xmlhttp.send();
	}
}