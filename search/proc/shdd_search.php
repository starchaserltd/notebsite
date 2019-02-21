<?php
function search_shdd ($nr_hdd)
{
	if ($nr_hdd>1) { /* do nothing */}
}
/*mostly for presearch purposes*/
if ($nr_hdd==2) { $shdd_search_cond="(shdd!='0' AND shdd IS NOT NULL) AND "; }
?>