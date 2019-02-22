<?php

/* BIG SELECT FOR SETTING PREDEFINED DATABASE VALUES */

$sel="SELECT";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=17) AS cpu_lmin,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=18) AS cpu_lmax,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=13) AS cpu_coremin,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=15) AS cpu_coremax,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=14) AS cpu_freqmin,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=16) AS cpu_freqmax,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=19) AS cpu_techmin,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=20) AS cpu_techmax,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=21) AS cpu_tdpmin,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=22) AS cpu_tdpmax,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=27) AS gpu_memmin,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=28) AS gpu_memmax,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=29) AS gpu_membusmin,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=30) AS gpu_membusmax,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=31) AS display_sizemin,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=32) AS display_sizemax,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=33) AS hdd_capmin,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=34) AS hdd_capmax,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=35) AS mem_capmin,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=36) AS mem_capmax,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=37) AS mem_freqmin,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=38) AS mem_freqmax,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=39) AS acum_nrcmin,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=40) AS acum_nrcmax,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=41) AS acum_capmin,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=42) AS acum_capmax,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=43) AS chassisthicmin,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=44) AS chassisthicmax,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=45) AS chassiswidthmin,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=46) AS chassiswidthmax,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=47) AS chassisweightmin,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=48) AS chassisweightmax,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=49) AS chassisdepthmin,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=50) AS chassisdepthmax,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=57) AS waryearsmin,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=58) AS waryearsmax,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=59) AS batlifemin,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=60) AS batlifemax,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=61) AS gpu_power_min,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=62) AS gpu_power_max,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=63) AS chassis_web_min,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=64) AS chassis_web_max,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=65) AS display_hres_min,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=66) AS display_hres_max,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=67) AS display_vres_min,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=68) AS display_vres_max,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=72) AS list_cputech,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=73) AS list_gpumem,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=74) AS list_gpumembus,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=75) AS list_displaysize,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=76) AS list_memcap,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=77) AS list_memfreq,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=78) AS list_chassisweb,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=79) AS list_verres,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=80) AS gpu_lmin,";
$sel.=" (SELECT name FROM notebro_site.nomen WHERE type=81) AS gpu_lmax";

//echo $sel;
mysqli_multi_query($con, $sel);
$result=mysqli_use_result($con);
$rand = mysqli_fetch_all($result); 

$time = strtotime($rand[0][0]); 
$cpumindatei=date('Y', $time);if(!isset($cpumindate)) { $cpumindate=$cpumindatei;}
$time = strtotime($rand[0][1]);
$cpumaxdatei=date('Y', $time); if(!isset($cpumaxdate)) { $cpumaxdate=$cpumaxdatei;}
$cpucoremini=$rand[0][2]; if(!isset($cpucoremin)) { $cpucoremin=$cpucoremini;}
$cpucoremaxi=$rand[0][3]; if(!isset($cpucoremax)) { $cpucoremax=$cpucoremaxi;}
$cpufreqmini=$rand[0][4]; if(!isset($cpufreqmin)) { $cpufreqmin=$cpufreqmini;}
$cpufreqmaxi=$rand[0][5]; if(!isset($cpufreqmax)) { $cpufreqmax=$cpufreqmaxi;}
$cputechmini=$rand[0][6]; if(!isset($cputechmin)) { $cputechmin=$cputechmini;}
$cputechmaxi=$rand[0][7]; if(!isset($cputechmax)) { $cputechmax=$cputechmaxi;}
$cputdpmini=$rand[0][8]; if(!isset($cputdpmin)) { $cputdpmin=$cputdpmini;}
$cputdpmaxi=$rand[0][9]; if(!isset($cputdpmax)) { $cputdpmax=$cputdpmaxi;}
$gpumemmini=$rand[0][10]; if(!isset($gpumemmin)) { $gpumemmin=$gpumemmini;}
$gpumemmaxi=$rand[0][11]; if(!isset($gpumemmax)) { $gpumemmax=$gpumemmaxi;}
$gpumembusmini=$rand[0][12]; if(!isset($gpumembusmin)) { $gpumembusmin=$gpumembusmini;}
$gpumembusmaxi=$rand[0][13]; if(!isset($gpumembusmax)) { $gpumembusmax=$gpumembusmaxi;}
$displaysizemini=$rand[0][14]; if(!isset($displaysizemin)) { $displaysizemin=$displaysizemini;}
$displaysizemaxi=$rand[0][15]; if(!isset($displaysizemax)) { $displaysizemax=$displaysizemaxi;}
$totalcapmini=$rand[0][16]; if(!isset($totalcapmin)) { $totalcapmin=$totalcapmini;}
$totalcapmaxi=$rand[0][17]*2; if(!isset($totalcapmax)) { $totalcapmax=$totalcapmaxi;}
$memcapmini=$rand[0][18]; if(!isset($memcapmin)) { $memcapmin=$memcapmini;}
$memcapmaxi=$rand[0][19]; if(!isset($memcapmax)) { $memcapmax=$memcapmaxi;}
$memfreqmini=$rand[0][20];if(!isset($memfreqmin)) { $memfreqmin=$memfreqmini;}
$memfreqmaxi=$rand[0][21];if(!isset($memfreqmax)) { $memfreqmax=$memfreqmaxi;}
//$acumnrcmini=$rand[0][22];	if(!($acumnrcmin)) { $acumnrcmin=$acumnrcmini;}
//$acumnrcmaxi=$rand[0][23];	if(!($acumnrcmax)) { $acumnrcmax=$acumnrcmaxi;}
$acumcapmini=$rand[0][24];	if(!isset($acumcapmin)) { $acumcapmin=$acumcapmini;}
$acumcapmaxi=$rand[0][25];	if(!isset($acumcapmax)) { $acumcapmax=$acumcapmaxi;}
$chassisthicmini=$rand[0][26];if(!isset($chassisthicmin)) { $chassisthicmin=$chassisthicmini;}
$chassisthicmaxi=$rand[0][27];if(!isset($chassisthicmax)) { $chassisthicmax=$chassisthicmaxi;}
$chassiswidthmini=$rand[0][28];if(!isset($chassiswidthmin)) { $chassiswidthmin=$chassiswidthmini;}
$chassiswidthmaxi=$rand[0][29];if(!isset($chassiswidthmax)) { $chassiswidthmax=$chassiswidthmaxi;}
$chassisweightmini=$rand[0][30];if(!isset($chassisweightmin)) { $chassisweightmin=$chassisweightmini;}
$chassisweightmaxi=$rand[0][31];if(!isset($chassisweightmax)) { $chassisweightmax=$chassisweightmaxi;}
$chassisdepthmini=$rand[0][32];if(!isset($chassisdepthmin)) { $chassisdepthmin=$chassisdepthmini;}
$chassisdepthmaxi=$rand[0][33];if(!isset($chassisdepthmax)) { $chassisdepthmax=$chassisdepthmaxi;}
$waryearsmini=$rand[0][34];if(!isset($waryearsmin)) { $waryearsmin=$waryearsmini;}
$waryearsmaxi=intval($rand[0][35]); if($waryearsmaxi>3){$waryearsmaxi=3;} if(!isset($waryearsmax)) { $waryearsmax=$waryearsmaxi;}
$batlifemini=$rand[0][36]; if(!isset($batlifemin)) { $batlifemin=$batlifemini;}
$batlifemaxi=$rand[0][37]; if(!isset($batlifemax)) { $batlifemax=$batlifemaxi;}
$gpupowermini =$rand[0][38]; if(!isset($gpupowermin)) { $gpupowermin=$gpupowermini;} 
$gpupowermaxi =$rand[0][39]; if(!isset($gpupowermax)) { $gpupowermax=$gpupowermaxi;}
$chassiswebmini =round($rand[0][40],2); if(!isset($chassiswebmin)) { $chassiswebmin=$chassiswebmini;}
$x=$chassiswebmini; while($x<round($rand[0][41],2)){ $x+=0.1; }
$chassiswebmaxi =$x; if(!isset($chassiswebmax)) { $chassiswebmax=$chassiswebmaxi;}
$displayhresmini =$rand[0][42]; if(!isset($displayhresmin)) { $displayhresmin=$displayhresmini;}
$displayhresmaxi =$rand[0][43]; if(!isset($displayhresmax)) { $displayhresmax=$displayhresmaxi;}
$displayvresmini =$rand[0][44]; if(!isset($displayvresmin)) { $displayvresmin=$displayvresmini;}
$displayvresmaxi =$rand[0][45]; if(!isset($displayvresmax)) { $displayvresmax=$displayvresmaxi;}
$list_cputech =$rand[0][46];//if(!($max_cputech)) { $max_cputech=$max_cputechi;}
$list_gpumem = $rand[0][47];
$list_gpumembus = $rand[0][48];
$list_displaysize = $rand[0][49];
$list_memcap = $rand[0][50];
$list_memfreq = $rand[0][51];
$list_chassisweb = $rand[0][52];
$list_verres = $rand[0][53];
$time = strtotime($rand[0][54]); 
$gpumindatei=date('Y', $time);
if(!isset($gpumindate)) { $gpumindate=$gpumindatei;}
$time = strtotime($rand[0][55]);
$gpumaxdatei=date('Y', $time); if(!isset($gpumaxdate)) { $gpumaxdate=$gpumaxdatei;}

mysqli_free_result($result);

/* ROUND CHASSIS CHARACTERISTICS TO GET ALL RESULTS */
$chassisthicmax=ceil($chassisthicmax*10)/10; $chassisthicmin=floor($chassisthicmin*10)/10; $chassisthicmaxi=ceil($chassisthicmaxi*10)/10; $chassisthicmini=floor($chassisthicmini*10)/10;
$chassiswidthmax=ceil($chassiswidthmax*10)/10; $chassiswidthmin=floor($chassiswidthmin*10)/10; $chassiswidthmaxi=ceil($chassiswidthmaxi*10)/10; $chassiswidthmini=floor($chassiswidthmini*10)/10;
$chassisdepthmax=ceil($chassisdepthmax*10)/10; $chassisdepthmin=floor($chassisdepthmin*10)/10; $chassisdepthmaxi=ceil($chassisdepthmaxi*10)/10; $chassisdepthmini=floor($chassisdepthmini*10)/10;
$chassisweightmax=ceil($chassisweightmax*10)/10; $chassisweightmin=floor($chassisweightmin*10)/10; $chassisweightmaxi=ceil($chassisweightmaxi*10)/10; $chassisweightmini=floor($chassisweightmini*10)/10;

/* SETTING THE VARIABLES IN JAVASCRIPT */
echo '<script type="text/javascript">';
echo "cpumindate=parseInt('".$cpumindatei."'); ";
echo "cpumaxdate=parseInt('".$cpumaxdatei."'); ";
echo "cpumincore=parseInt('".$cpucoremini."'); ";
echo "cpumaxcore=parseInt('".$cpucoremaxi."'); ";
echo "cpufreqmin=parseFloat('".$cpufreqmini."'); ";
echo "cpufreqmax=parseFloat('".$cpufreqmaxi."'); ";
echo "cputechmax=parseInt('".$cputechmini."'); ";
echo "cputechmin=parseInt('".$cputechmaxi."'); ";
echo "cputdpmin=parseInt('".$cputdpmini."'); ";
echo "cputdpmax=parseInt('".$cputdpmaxi."'); ";
echo "gpumemmin=parseInt('".$gpumemmini."'); ";
echo "gpumemmax=parseInt('".$gpumemmaxi."'); ";
echo "gpumembusmin=parseInt('".$gpumembusmini."'); ";
echo "gpumembusmax=parseInt('".$gpumembusmaxi."'); ";
echo "gpumindate=parseInt('".$gpumindatei."'); ";
echo "gpumaxdate=parseInt('".$gpumaxdatei."'); ";
echo "displaysizemin=parseFloat('".$displaysizemini."'); ";
echo "displaysizemax=parseFloat('".$displaysizemaxi."'); ";
echo "hddcapmin=parseInt('".$totalcapmini."'); ";
echo "hddcapmax=parseInt('".$totalcapmaxi."'); ";
echo "memcapmin=parseInt('".$memcapmini."'); ";
echo "memcapmax=parseInt('".$memcapmaxi."'); ";
echo "memfreqmin=parseInt('".$memfreqmini."'); ";
echo "memfreqmax=parseInt('".$memfreqmaxi."'); ";
//echo "acumnrcmin=parseInt('".$acumnrcmini."'); ";
//echo "acumnrcmax=parseInt('".$acumnrcmaxi."'); ";
echo "acumcapmin=parseInt('".$acumcapmini."'); ";
echo "acumcapmax=parseInt('".$acumcapmaxi."'); ";
echo "chassisthicmin=parseFloat('".$chassisthicmini."'); ";
echo "chassisthicmax=parseFloat('".$chassisthicmaxi."'); ";
echo "chassiswidthmin=parseFloat('".$chassiswidthmini."'); ";
echo "chassiswidthmax=parseFloat('".$chassiswidthmaxi."'); ";
echo "chassisweightmin=parseFloat('".$chassisweightmini."'); ";
echo "chassisweightmax=parseFloat('".$chassisweightmaxi."'); ";
echo "chassisdepthmin=parseFloat('".$chassisdepthmini."'); ";
echo "chassisdepthmax=parseFloat('".$chassisdepthmaxi."'); ";
echo "waryearsmin=parseInt('".$waryearsmini."'); ";
echo "waryearsmax=parseInt('".$waryearsmaxi."'); ";
echo "batlifemin=parseFloat('".$batlifemini."'); ";
echo "batlifemax=parseFloat('".$batlifemaxi."'); ";
echo "gpupowermin=parseFloat('".$gpupowermini."'); ";
echo "gpupowermax=parseFloat('".$gpupowermaxi."'); ";
echo "chassiswebmin=parseFloat('".$chassiswebmini."'); ";
echo "chassiswebmax=parseFloat('".$chassiswebmaxi."'); ";
echo "displayhresmin=parseFloat('".$displayhresmini."'); ";
echo "displayhresmax=parseFloat('".$displayhresmaxi."'); ";
echo "displayvresmin=parseFloat('".$displayvresmini."'); ";
echo "displayvresmax=parseFloat('".$displayvresmaxi."'); ";
echo "list_cputech='".$list_cputech."'.split(','); ";
echo "list_gpumem='".$list_gpumem."'.split(','); ";
echo "list_gpumembus='".$list_gpumembus."'.split(','); ";
echo "list_displaysize='".$list_displaysize."'.split(','); ";
echo "list_memcap='".$list_memcap."'.split(','); ";
echo "list_memfreq='".$list_memfreq."'.split(','); ";
echo "list_chassisweb='".$list_chassisweb."'.split(','); ";
echo "list_verres='".$list_verres."'.split(','); ";
echo "</script>";

//CODE FOR LIST IN SEARCH   

$sel="SELECT name,type FROM notebro_site.nomen WHERE type=8 OR type=11 OR type=12 OR type=25 OR type=26 OR type=51 OR type=52 OR type=53 OR type=54 OR type=55 OR type=56";
$result = mysqli_query($con, $sel);
$droplists=array();

while($rand = mysqli_fetch_assoc($result)) 
{ 
		if(!isset($droplists[$rand["type"]])) { $droplists[$rand["type"]]=""; }
		$droplists[$rand["type"]].='<option value="'.$rand["name"].'"';
		//echo "stativalues"; var_dump($valuetype[$rand["type"]]); var_dump($rand["name"]);
		//echo "<br>";
		if(isset($valuetype[$rand["type"]][0]) && $valuetype[$rand["type"]][0])
		{	if(!is_array($valuetype[$rand["type"]]) && !is_string($valuetype[$rand["type"]])){$valuetype[$rand["type"]]=str_split($valuetype[$rand["type"]]);}
			if(is_array($valuetype[$rand["type"]]) && in_array($rand["name"],$valuetype[$rand["type"]])) { $droplists[$rand["type"]].=" selected "; }
			else
			{
				if($rand["type"]!=25) //25 is Operating System
				{ if(($valuetype[$rand["type"]])==$rand["name"]) { $droplists[$rand["type"]].=" selected "; } }
				else
				{ if(is_array($valuetype[$rand["type"]])){ foreach($valuetype[$rand["type"]] as $val) { if(stripos($rand["name"],$val)!==FALSE) { $droplists[$rand["type"]].=" selected "; } } } }
			}
		}
		$droplists[$rand["type"]].='>'.$rand["name"].'</option>';
}
mysqli_free_result($result);

?>