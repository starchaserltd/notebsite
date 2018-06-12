// Function for advanced search
$('#submitformid').click(function(e)
{
	e.preventDefault();
	$('#loadingNB').show();
	trigger=0; var addref=""; if(ref!=null&&ref!="") { addref="?ref="+ref; }
	$.get('search/search.php'+addref, $("#advform").serialize(), function(data) {
		url = "search/search.php" + "?" + $("#advform").serialize();
		if(url.indexOf("ref=")<0){ if(ref!=null&&ref!="") { url=url+"&ref="+ref; } }
		currentpage = url;
		history.pushState(null, "NoteBrother", "?" + url);
		if($('#content').html(data)){ $('#loadingNB').hide(); }
	});
});
			
//FIRST, DEPENDING ON THE RANGE WE DECIDE THE NUMER SIZE
var rangemaxbadv=0;
function divideradv()
{
	var rangemaxbadv_temp=rangemaxbadv;
	i=1;
	while(rangemaxbadv_temp>1)
	{
		rangemaxbadv_temp=rangemaxbadv_temp/10;
		i++;
	}

	divide=Math.pow(10,i-4);
	if(i<=0) {divide=1;}
	return divide;
}

//SECONDLY WE ROUND THE BOUNDRIES SO THAT THE NUMBERS LOOK NICE AND ROUND
function roundlimitadv(val)
{
	divide=divideradv();
	val=parseInt(val/divide)*divide;
	if(val<=0){val=1;}
	return val;
}

//THIRDLY WE ROUND THE STEPS SO THAT THE STEPPING IS NICE AND ROUND
function roundstepadv(val)
{
	divide=divideradv();
	val=parseInt(val/divide)*divide;
	if(val<=0){val=10;}
	return val;
}

//HERE WE SET SLIDER DEPENDING ON WHAT IS IN THE INPUT BOXES
function checkminadv()
{ document.getElementById('budgetadv').noUiSlider.set([document.getElementById('bdgminadv').value, null]); }

function checkmaxadv()
{ document.getElementById('budgetadv').noUiSlider.set([null,document.getElementById('bdgmaxadv').value]); }

setTimeout(function(){ istime=1; },1200);