/* GENERATE SOME JAVASCRIPT */

var disqus_config = function () {
 this.page.url = '<?php if(isset($_GET['conf'])) { echo $web_address."?"."model/model.php?conf=".$conf;} else { echo $web_address."?"."model/model.php?model_id=".$idmodel; } ?>';//PAGE_URL; // Replace PAGE_URL with your page's canonical URL variable
 this.page.identifier = '<?php echo $idmodel;?>';//PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
 this.page.title = '<?php echo "Comment at model nr: ".$idmodel;?>';
};
 
$(document).ready(function(){
$.getScript("model/lib/js/model_queries.js").done(function(){ showCPU(<?php echo $idcpu; ?>); showGPU(<?php echo $idgpu; ?>); showDISPLAY(<?php echo $iddisplay; ?>); showHDD(<?php echo $idhdd; ?>);
 showSHDD(<?php echo $idshdd; ?>); showMDB(<?php echo $idmdb; ?>); showMEM(<?php echo $idmem; ?>); showODD(<?php echo $idodd; ?>); showACUM(<?php echo $idacum; ?>);
 showCHASSIS(<?php echo $idchassis; ?>); showWAR(<?php echo $idwar; ?>); showWNET(<?php echo $idwnet; ?>); showSIST(<?php echo $idsist; ?>); getconf("","0", [ <?php echo $idcpu; ?>,<?php echo $iddisplay; ?>,<?php echo $idmem; ?>,<?php echo $idhdd; ?>,<?php echo $idshdd; ?>,<?php echo $idgpu; ?>,<?php echo $idwnet; ?>,<?php echo $idodd; ?>,<?php echo $idmdb; ?>,<?php echo $idchassis; ?>,<?php echo $idacum; ?>,<?php echo $idwar; ?> ,<?php echo $idsist; ?>]); });
 firstcompare=0;
 
 setTimeout(function()
 {
  istime=1;
 },1500);

});