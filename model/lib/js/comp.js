function addcolumn(data,tableid,valign) {
 $("#"+tableid).find('tr').each(function(index){
 	if(data[index] != null ) { $(this).append('<td ' + valign + ' class="col-md-2 col-xs-2 col-sm-2 rows compare1">'+data[index]+'</td>') }	
 	});	
}

function stripeme(tableid)
{ $("#"+tableid+" tr:visible").each(function(index){$(this).toggleClass("colored",!(index&1))}); }

//FUNCTION FOR SHOW/HIDE ROWS
$(".toggler").click(function(e){
	e.preventDefault();
	var data_hide = $(this).attr('data-hide');
	$('.hide'+data_hide).fadeToggle(500,function () { stripeme(data_hide+"_table"); });
});

var set_showall="hide";
function showall_comp()
{
	var el = document.querySelectorAll(".toggler");
	for (var i = 0; i < el.length; i++)
	{
		if (el[i].childNodes[0].classList.contains('resize')&&set_showall=="show")
		{ el[i].childNodes[0].click(); }
		
		if (!el[i].childNodes[0].classList.contains('resize')&&set_showall=="hide")
		{ el[i].childNodes[0].click(); }
	}
	if(set_showall=="hide"){ set_showall="show";}else{if(set_showall=="show"){ set_showall="hide";}}
}

setTimeout(function(){ istime=1; },1500);

//Function for show more arrows
$('.glyphicon-chevron-down').on('click', function() { $(this).toggleClass('resize'); });	
//Function for show LessDetails button
$('.showDetailsButton').on('click', function() {
		$(this).toggleClass('show');
		$('.glyphicon-chevron-down').toggleClass('switchButton');
});
	
/* HEADER */
var array_var=["","","","","",""];
addcolumn(array_var,"HEADER_table",'style="vertical-align:middle"');
/* CPU */
var array_var=["Model","Launch Date","Socket","Technology","Cache","Base Speed","Max. Speed","Nr. of cores","TDP","Miscellaneous","Performance class","Rating"];
addcolumn(array_var,"CPU_table",'style="vertical-align:middle"');
/* GPU */
var array_var=["Model","Architecture","Technology","Pipelines","Core Speed","Shader model","Memory speed","Memory BUS","Memory","Shared memory","TDP","Miscellaneous","Performance class","Rating"];
addcolumn(array_var,"GPU_table",'style="vertical-align:middle"');
/* Display */
var array_var=["Size","Format","Resolution","Surface type","Technology","Touchscreen","Miscellaneous"];
addcolumn(array_var,"DISPLAY_table",'style="vertical-align:middle"');
/* Storage */
addcolumn(['<div class="col-sm-12 col-md-12 titlucomp">Storage</div>'],"title_STORAGE",'style="border-top: 0px;"');
var array_var=["Capacity","RPM","Type","Read speed","Write speed","Miscellaneous"];
addcolumn(array_var,"STORAGE_table",'style="vertical-align:middle"');
/* Secondary Storage */
var array_var=["Capacity","RPM","Type","Read speed","Write speed"];
addcolumn(array_var,"SSTORAGE_table",'style="vertical-align:middle"');
/* Motherboard */
var array_var=["Memory Slots","Chipset","Internal Ports","LAN Network","Storage Interfaces","Miscellaneous"];
addcolumn(array_var,"MDB_table",'style="vertical-align:middle"');
/* Memory */
var array_var=["Capacity","Standard","Type","CAS Latency","Miscellaneous"];
addcolumn(array_var,"MEM_table",'style="vertical-align:middle"');
/* Optical Drive */
addcolumn(['<div class="col-sm-12 col-md-12 titlucomp" id="title_ODAC">Optical Drive</div>'],"title_ODD",'style="border-top: 0px;"');
var array_var=["Type","Speed","Miscellaneous"];
addcolumn(array_var,"ODD_table",'style="vertical-align:middle"');
/* Battery */
var array_var=["Capacity","Cells type","Weight","Miscellaneous"];
addcolumn(array_var,"ACUM_table",'style="vertical-align:middle"');
/* Chassis */
var array_var=["Peripheral Ports","Video Ports","WebCam","Touchpad","Keyboard","Charger","Weight","Thickness","Depth","Width","Color","Material","Miscellaneous"];
addcolumn(array_var,"CHASSIS_table",'style="vertical-align:middle"');		
/* Wireless Card */
addcolumn(['<div class="col-sm-12 col-md-12 titlucomp">Wireless card</div>'],"title_WNET",'style="border-top: 0px;"');
var array_var=["Model","Slot","Speed","Standard","Miscellaneous"];
addcolumn(array_var,"WNET_table",'style="vertical-align:middle"');
/* Waranty */
var array_var=["Years","Miscellaneous"];
addcolumn(array_var,"WARA_table",'style="vertical-align:middle"'); 
/* Operating System */
var array_var=["Software"];
addcolumn(array_var,"OS_table",'style="vertical-align:middle"');

$(document).ready(function(){ actbtn(""); });