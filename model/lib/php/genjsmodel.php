/* GENERATE SOME JAVASCRIPT */
var disqus_config = function () {
 this.page.url = '<?php echo $web_address."?"."model/model.php?model_id=".$idmodel; ?>';//PAGE_URL;
 this.page.identifier = '<?php echo $p_model;?>';//PAGE_IDENTIFIER;
 this.page.title = mprod+' '+mmodel;
};

function set_model_info()
{ var key; for(key in veto_mname) {mmodel=mmodel.replace(' '+veto_mname[key],'');} metakeys(mprod.replace(' ',',')+','+mfamily.replace(' ',',')+','+mmodel.replace(' ',',')+',notebook,laptop'); document.title = mprod+' '+mfamily+' '+mmodel;}

function update_model_price(cprice,cperr)
{ if(document.getElementById('config_price1')!=null){document.getElementById('config_price1').innerHTML=parseInt((cprice-cperr/2)*exch); document.getElementById('config_price2').innerHTML=parseInt((cprice+cperr/2)*exch); document.getElementById('dLabel').setAttribute('data-price',parseInt(cprice)); } }
var best_low = {lowest_price:"<?php echo $best_low["lowest_price"]; ?>", best_performance:"<?php echo $best_low["best_performance"]; ?>", best_value:"<?php echo $best_low["best_value"]; ?>"};

var gpu_pixel_offset=0; var maxwidth=0; var gpu_select_open=1;
function gpu_right_align()
{
	if ($(window).width() >= 425)
	{ var maxtext=22;  maxwidth=170; var borderpx=0; }
	else
	{ var maxtext=16;  maxwidth=128; var borderpx=1; }
	
	var borderpx=1;
	var el=$('#GPU option:selected'); var el_text=el.text();

	if(el_text.length>0)
	{
		if(el_text.indexOf("Integrated")>=0)
		{
			$('#GPU').css({'transform': 'translateX(0)', 'width': maxwidth+'px'}); gpu_pixel_offset=0;
			$('.gpuhddd form').css('border-left', '0');
		}
		else
		{
			gpu_pixel_offset=parseInt(char_indent(el_text,maxtext)); if(gpu_pixel_offset<=0){ borderpx=0; }
			$('#GPU').css({'transform': 'translateX(-'+gpu_pixel_offset+'px)', 'width': (maxwidth+gpu_pixel_offset)+'px'});
			$('.gpuhddd form').css('border-left', borderpx+'px solid');
		}	
	} 
}

function char_indent(str,maxlength)
{
	x=str.split(' '); var short_length=0; var fudge=1.05;
	for(var i=x.length-1;i>=0;i--)
	{
		short_length+=x[i].length+1;
		if(short_length>=maxlength){ short_length-=(x[i].length+1); }
	}

	var el=document.getElementById("hiddenDiv");
	el.style.display="inline"; str="T"+str; el.innerHTML=str.substr(0,str.length-short_length);
	var isSafari=window.safari!==undefined; if(isSafari){ var zoom=(window.outerWidth-8)/window.innerWidth; if(zoom>=0.92&&zoom<=1.1){fudge=0.85;}}
	var pixels=(el.offsetWidth)*fudge; el.style.display="none";
	return pixels;
}

$(document).ready(function()
{
	set_model_info();
	$.getScript("model/lib/js/model_queries.js").done(function(){ showCPU(<?php echo $idcpu; ?>); showGPU(<?php echo $idgpu; ?>); showDISPLAY(<?php echo $iddisplay; ?>); showHDD(<?php echo $idhdd; ?>);
	 showSHDD(<?php echo $idshdd; ?>); showMDB(<?php echo $idmdb; ?>); showMEM(<?php echo $idmem; ?>); showODD(<?php echo $idodd; ?>); showACUM(<?php echo $idacum; ?>);
	 showCHASSIS(<?php echo $idchassis; ?>); showWAR(<?php echo $idwar; ?>); showWNET(<?php echo $idwnet; ?>); showSIST(<?php echo $idsist; ?>);
	 <?php if($cprice){ ?> update_model_price(<?php echo $cprice;?>,<?php echo $cperr;?>); set_best_low('<?php echo $conf; ?>',best_low); <?php }else{ ?>getconf("","0", [ <?php echo $idcpu; ?>,<?php echo $iddisplay; ?>,<?php echo $idmem; ?>,<?php echo $idhdd; ?>,<?php echo $idshdd; ?>,<?php echo $idgpu; ?>,<?php echo $idwnet; ?>,<?php echo $idodd; ?>,<?php echo $idmdb; ?>,<?php echo $idchassis; ?>,<?php echo $idacum; ?>,<?php echo $idwar; ?> ,<?php echo $idsist; ?>]);<?php } if($init_conf!=$conf){ echo "update_url('".explode("_",$conf)[0]."','".$idmodel."',excode);"; }?> });
	 firstcompare=0;
	 setTimeout(function(){ istime=1; },1200);
});