/* GENERATE SOME JAVASCRIPT */
var disqus_config = function () {
 this.page.url = '<?php if(isset($_GET['conf'])) { echo $web_address."?"."model/model.php?conf=".$conf."_".$idmodel;} else { echo $web_address."?"."model/model.php?model_id=".$idmodel; } ?>';//PAGE_URL; // Replace PAGE_URL with your page's canonical URL variable
 this.page.identifier = '<?php echo $pmodel;?>';//PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
 this.page.title = mprod+' '+mmodel;
};

function set_model_info()
{ var key; for(key in veto_mname) {mmodel=mmodel.replace(' '+veto_mname[key],'');} metakeys(mprod.replace(' ',',')+','+mfamily.replace(' ',',')+','+mmodel.replace(' ',',')+',notebook,laptop'); document.title = mprod+' '+mfamily+' '+mmodel; }
function update_model_price(cprice,cperr){ document.getElementById('config_price1').innerHTML=parseInt((cprice-cperr/2)*exch); document.getElementById('config_price2').innerHTML=parseInt((cprice+cperr/2)*exch); document.getElementById('dLabel').setAttribute('data-price',parseInt(cprice)); }
var best_low = {lowest_price:"<?php echo $best_low["lowest_price"]; ?>", best_performance:"<?php echo $best_low["best_performance"]; ?>", best_value:"<?php echo $best_low["best_value"]; ?>"};
 
$(document).ready(function(){ set_model_info();
$.getScript("model/lib/js/model_queries.js").done(function(){ showCPU(<?php echo $idcpu; ?>); showGPU(<?php echo $idgpu; ?>); showDISPLAY(<?php echo $iddisplay; ?>); showHDD(<?php echo $idhdd; ?>);
 showSHDD(<?php echo $idshdd; ?>); showMDB(<?php echo $idmdb; ?>); showMEM(<?php echo $idmem; ?>); showODD(<?php echo $idodd; ?>); showACUM(<?php echo $idacum; ?>);
 showCHASSIS(<?php echo $idchassis; ?>); showWAR(<?php echo $idwar; ?>); showWNET(<?php echo $idwnet; ?>); showSIST(<?php echo $idsist; ?>); <?php if($cprice){ ?> update_model_price(<?php echo $cprice;?>,<?php echo $cperr;?>); set_best_low('<?php echo $conf; ?>',best_low); <?php }else{ ?>getconf("","0", [ <?php echo $idcpu; ?>,<?php echo $iddisplay; ?>,<?php echo $idmem; ?>,<?php echo $idhdd; ?>,<?php echo $idshdd; ?>,<?php echo $idgpu; ?>,<?php echo $idwnet; ?>,<?php echo $idodd; ?>,<?php echo $idmdb; ?>,<?php echo $idchassis; ?>,<?php echo $idacum; ?>,<?php echo $idwar; ?> ,<?php echo $idsist; ?>]);<?php } ?> });
 firstcompare=0;
 setTimeout(function(){ istime=1; },1200);
});