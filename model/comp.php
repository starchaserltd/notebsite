<?php
require_once("../etc/conf.php");
if (!isset($_SERVER['HTTP_REFERER']) || stripos($_SERVER['HTTP_REFERER'],$site_name) ==FALSE) 
{	$actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	header("Location: ".$port_type."://".str_replace($site_name."/",$site_name."/?",$actual_link)."");
	die();
}
require_once("lib/php/headercomp.php");

if($nrconf < 1 && $nrgetconfs <1) //nrconf is from headercomp.php
{
?>
<div class="col-md-8 col-md-offset-2" style="border:1px solid #ddd; background-color:#f6f6f6; border-radius:15px; margin-top:20px;">
<?php
	echo "	<br><b>Here you can compare two or more laptop configurations.</b><br><br> In order to do this, search for the desired model/configuration using this website's search functionalities and then add it to the compare list. <br> You can view your current list of saved configurations in the left menu, under «My toolbox».";
	echo '	<br><br><span style="color:#BF1A1A;text-align:center; font-weight:bold;">Currently you have '.($nrconf+1).' configuration'; if(($nrconf+1)!=1) echo "s"; echo ' in your list.<br>Or maybe the laptop configurations you are trying to compare no longer exist.</span><br><br>';
?>
</div>
<?php
}
else
{
?>
<link rel="stylesheet" href="model/lib/css/compare.css?v=30" type="text/css" />
<?php include_once("../libnb/php/aff_modal.php"); ?>
	<!-- TABLE HEADER -->
	<div class="compContainer linked">
		<table id="title_MODEL" style="border: 0; width:100%;" class="titleModel linked">
			<tbody>
				<tr class="row"><td></td></tr>
			</tbody>
		</table>	
		<table id="HEADER_table" class="table-xtra-condensed table borderless" style="padding:0px 0px 0px 15px;">
			<tbody>
				<tr class="row" style="min-height:70px;"></tr>
				<tr class="modelName row" style="min-height:20px;"></tr>
				<tr class="row" style=""></tr>
				<tr class="row" style=""></tr>
				<tr class="row" style=""></tr>
				<tr class="row" style=""></tr>
			</tbody>
		</table>
		<!-- CPU -->
		<div>
				<span class="showDetailsButton"  style="color:black;padding:2px 20px;font-weight:normal" onclick="showall_comp();"><span class="zIndex glyphicon glyphicon-chevron-down fas fa-angle-down" aria-hidden="true"></span><span class="showDetails"> Show all</span><span class="showLessDetails"> Show less</span></span>					
		</div>
		<div class="col-sm-12 col-md-12 titlucomp">Processor</div>			
		<table id="CPU_table" class="table-xtra-condensed table tble ">
			<tbody>
				<tr class="row"></tr>
				<tr class="row"></tr>
				<tr class="hideCPU row" style="display: none;"></tr>
				<tr class="hideCPU row" style="display: none;"></tr>
				<tr class="hideCPU row" style="display: none;"></tr>
				<tr class="hideCPU row" style="display: none;"></tr>
				<tr class="row"></tr>
				<tr class="row"></tr>
				<tr class="row"></tr>
				<tr class="hideCPU row" style="display: none;"></tr>
				<tr class="row"></tr>
				<tr class="row"></tr>
				<tr class="arrowShowMore row">
					<td>
						<div class="col-sm-12 col-md-12 col-xs-12 shcomp"><a class="toggler toolinfo" data-toolid="100" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 700}' data-placement="top" data-original-title="data-loading..." data-hide="CPU" style="text-decoration:none; color:black; cursor:pointer;"><span class="glyphicon glyphicon-chevron-down fas fa-angle-down" aria-hidden="true"></span></a></div>		
					</td>
				</tr>
			</tbody>
		</table>
		<!-- GPU -->
		<div class="col-sm-12 col-md-12 titlucomp">Video Card</div>				
		<table id="GPU_table" class="table-xtra-condensed table tble">
			<tbody>
				<tr class="row"></tr>
				<tr class="hideGPU row" style="display: none;"></tr>
				<tr class="hideGPU row" style="display: none;"></tr>
				<tr class="hideGPU row" style="display: none;"></tr>
				<tr class="row"></tr>
				<tr class="hideGPU row" style="display: none;"></tr>
				<tr class="row"></tr>
				<tr class="hideGPU row" style="display: none;"></tr>
				<tr class="row"></tr>
				<tr class="hideGPU row" style="display: none;"></tr>
				<tr class="row"></tr>
				<tr class="hideGPU row" style="display: none;"></tr>
				<tr class="row"></tr>
				<tr class="row"></tr>
				<tr class="arrowShowMore row">
					<td>
						<div class="col-sm-12 col-md-12 col-xs-12 shcomp"><a class="toggler toolinfo" data-toolid="100" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 700}' data-placement="top" data-original-title="data-loading..." data-hide="GPU" style="text-decoration:none; color:black; cursor:pointer;"><span class="glyphicon glyphicon-chevron-down fas fa-angle-down" aria-hidden="true"></span></a></div>	
					</td>
				</tr>
			</tbody>
		</table>
		<!-- Display  -->
		<div class="col-sm-12 col-md-12 titlucomp ">Display</div>				
		<table id="DISPLAY_table" class="table-xtra-condensed table tble">
			<tbody>
				<tr class="row"></tr>
				<tr class="hideDISPLAY row" style="display: none;"></tr>
				<tr class="row"></tr>
				<tr class="hideDISPLAY row" style="display: none;"></tr>
				<tr class="row"></tr>
				<tr class="row"></tr>				
				<tr class="row"></tr>				
				<tr class="arrowShowMore row">
					<td>
						<div class="col-sm-12 col-md-12 col-xs-12 shcomp"><a class="toggler toolinfo" data-toolid="100" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 700}' data-placement="top" data-original-title="data-loading..." data-hide="DISPLAY" style="text-decoration:none; color:black; cursor:pointer;"><span class="glyphicon glyphicon-chevron-down fas fa-angle-down" aria-hidden="true"></span></a></div>	
					</td>
				</tr>
			</tbody>
		</table>
		<!-- Storage -->	
		<div class="col-sm-12 col-md-12 titlucomp ">Storage</div>				
		<table id="STORAGE_table" class="table-xtra-condensed table tble">
			<tbody>
				<tr class="row"></tr>
				<tr class="hideSTORAGE row" style="display: none;"></tr>
				<tr class="row"></tr>
				<tr class="row"></tr>
				<tr class="hideSTORAGE row" style="display: none;"></tr>
				<tr class="hideSTORAGE row" style="display: none;"></tr>
				<tr class="arrowShowMore row">
					<td>
						<div class="col-sm-12 col-md-12 col-xs-12 shcomp"><a class="toggler toolinfo" data-toolid="100" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 700}' data-placement="top" data-original-title="data-loading..." data-hide="STORAGE" style="text-decoration:none; color:black; cursor:pointer;"><span class="glyphicon glyphicon-chevron-down fas fa-angle-down" aria-hidden="true"></span></a></div>	
					</td>
				</tr>
			</tbody>
		</table>
		<!-- Secondary Storage -->
		<div class="col-sm-12 col-md-12 titlucomp" id="title_SS">Secondary Storage</div>				
		<table id="SSTORAGE_table" class="table-xtra-condensed table tble">
			<tbody>
				<tr class="row"></tr>
				<tr class="hideSSTORAGE row" style="display: none;"></tr>
				<tr class="row"></tr>
				<tr class="hideSSTORAGE row" style="display: none;"></tr>
				<tr class="hideSSTORAGE row" style="display: none;"></tr>
				<tr class="arrowShowMore row">
					<td>
						<div class="col-sm-12 col-md-12 col-xs-12 shcomp"><a class="toggler toolinfo" data-toolid="100" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 700}' data-placement="top" data-original-title="data-loading..." data-hide="SSTORAGE" style="text-decoration:none; color:black; cursor:pointer;"><span class="glyphicon glyphicon-chevron-down fas fa-angle-down" aria-hidden="true"></span></a></div>	
					</td>
				</tr>
			</tbody>
		</table>
		<!-- Motherboard -->
		<div class="col-sm-12 col-md-12 titlucomp">Motherboard</div>				
		<table id="MDB_table" class="table-xtra-condensed table tble">
			<tbody>
				<tr class="hideMDB row" style="display: none;"></tr>
				<tr class="row"></tr>
				<tr class="hideMDB row" style="display: none;"> </tr>
				<tr class="row"></tr>
				<tr class="hideMDB row" style="display: none;"></tr>
				<tr class="row"></tr>
				<tr class="arrowShowMore row">
					<td>
						<div class="col-sm-12 col-md-12 col-xs-12 shcomp"><a class="toggler toolinfo" data-toolid="100" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 700}' data-placement="top" data-original-title="data-loading..." data-hide="MDB" style="text-decoration:none; color:black; cursor:pointer;"><span class="glyphicon glyphicon-chevron-down fas fa-angle-down" aria-hidden="true"></span></a></div>	
					</td>
				</tr>
			</tbody>
		</table>
		<!-- Memory -->
		<div class="col-sm-12 col-md-12 titlucomp">Memory</div>				
		<table id="MEM_table" class="table-xtra-condensed table tble">
			<tbody>
				<tr class="row"></tr>
				<tr class="hideMEM row" style="display: none;"></tr>
				<tr class="row"></tr>
				<tr class="hideMEM row" style="display: none;"></tr>
				<tr class="hideMEM row" style="display: none;"></tr>
				<tr class="arrowShowMore row">
					<td>
						<div class="col-sm-12 col-md-12 col-xs-12 shcomp"><a class="toggler toolinfo" data-toolid="100" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 700}' data-placement="top" data-original-title="data-loading..." data-hide="MEM" style="text-decoration:none; color:black; cursor:pointer;"><span class="glyphicon glyphicon-chevron-down fas fa-angle-down" aria-hidden="true"></span></a></div>	
					</td>
				</tr>
			</tbody>
		</table>
		<!-- ODD -->
		<div class="col-sm-12 col-md-12 titlucomp" id="title_ODD">Optical drive</div>			
		<table id="ODD_table" class="table-xtra-condensed table tble">
			<tbody>
				<tr class="row"></tr>
				<tr class="hideODD row" style="display: none;"></tr>
				<tr class="hideODD row" style="display: none;"></tr>
				<tr class="arrowShowMore row">
					<td>
						<div class="col-sm-12 col-md-12 col-xs-12 shcomp"><a class="toggler toolinfo" data-toolid="100" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 700}' data-placement="top" data-original-title="data-loading..." data-hide="ODD" style="text-decoration:none; color:black; cursor:pointer;"><span class="glyphicon glyphicon-chevron-down fas fa-angle-down" aria-hidden="true"></span></a></div>	
					</td>
				</tr>
			</tbody>
		</table>
		<!-- Battery -->
		<div class="col-sm-12 col-md-12 titlucomp" id="title_BAT">Battery</div>				
		<table id="ACUM_table" class="table-xtra-condensed table tble">
			<tbody>
				<tr class="row"></tr>
				<tr class="row"></tr>
				<tr class="hideACUM row" style="display: none;"></tr>
				<tr class="hideACUM row" style="display: none;"></tr>
				<tr class="arrowShowMore row">
					<td>
						<div class="col-sm-12 col-md-12 col-xs-12 shcomp"><a class="toggler toolinfo" data-toolid="100" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 700}' data-placement="top" data-original-title="data-loading..." data-hide="ACUM" style="text-decoration:none; color:black; cursor:pointer;"><span class="glyphicon glyphicon-chevron-down fas fa-angle-down" aria-hidden="true"></span></a></div>	
					</td>
				</tr>
			</tbody>
		</table>
		<!-- CHASSIS -->
		<div class="col-sm-12 col-md-12 titlucomp">Chassis</div>				
		<table id="CHASSIS_table" class="table-xtra-condensed table tble">
			<tbody>
				<tr class="row"></tr>
				<tr class="row"></tr>
				<tr class="hideCHASSIS row" style="display: none;"></tr>
				<tr class="hideCHASSIS row" style="display: none;"></tr>
				<tr class="hideCHASSIS row" style="display: none;"></tr>
				<tr class="hideCHASSIS row" style="display: none;"></tr>
				<tr class="row"></tr>
				<tr class="hideCHASSIS row" style="display: none;"></tr>
				<tr class="hideCHASSIS row" style="display: none;"></tr>
				<tr class="hideCHASSIS row" style="display: none;"></tr>
				<tr class="hideCHASSIS row" style="display: none;"></tr>
				<tr class="row"></tr>
				<tr class="hideCHASSIS row" style="display: none;"></tr>		
				<tr class="arrowShowMore row">
					<td>
						<div class="col-sm-12 col-md-12 col-xs-12 shcomp"><a class="toggler toolinfo" data-toolid="100" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 700}' data-placement="top" data-original-title="data-loading..." data-hide="CHASSIS" style="text-decoration:none; color:black; cursor:pointer;"><span class="glyphicon glyphicon-chevron-down fas fa-angle-down" aria-hidden="true"></span></a></div>	
					</td>
				</tr>
			</tbody>
		</table>
		<!-- WNET  -->
		<div class="col-sm-12 col-md-12 titlucomp">Wireless</div>			
		<table id="WNET_table" class="table-xtra-condensed table tble">
			<tbody>
				<tr class="row"></tr>
				<tr class="hideWNET row" style="display: none;"></tr>
				<tr class="row"></tr>
				<tr class="hideWNET row" style="display: none;"></tr>
				<tr class="hideWNET row" style="display: none;"></tr>	
				<tr class="arrowShowMore row">
					<td>
						<div class="col-sm-12 col-md-12 col-xs-12 shcomp"><a class="toggler toolinfo" data-toolid="100" data-load="1" data-html="true" data-toggle="tooltip" data-delay='{"show": 700}' data-placement="top" data-original-title="data-loading..." data-hide="WNET" style="text-decoration:none; color:black; cursor:pointer;"><span class="glyphicon glyphicon-chevron-down fas fa-angle-down" aria-hidden="true"></span></a></div>	
					</td>
				</tr>
			</tbody>
		</table>
		<!-- Waranty -->
		<div class="col-sm-12 col-md-12 titlucomp">Warranty</div>
		<table id="WARA_table" class="table-xtra-condensed table tble">
			<tbody>
				<tr class="row"></tr>
				<tr class="row"></tr>
			</tbody>
		</table>
		<!-- Operating System -->
		<div class="col-sm-12 col-md-12 titlucomp">Operating System</div>
		<table id="OS_table" class="table-xtra-condensed table tble">
			<tbody>
				<tr class="row"></tr>
			</tbody>
		</table>
		<!-- Model Miscellaneous -->
		<div class="col-sm-12 col-md-12 titlucomp" id="title_MSC">Other</div>
		<table id="MSC_table" class="table-xtra-condensed table tble">
			<tbody>
				<tr class="colored row"></tr>
			</tbody>
		</table>
	</div>
	<script>$.getScript("model/lib/js/comp.js").done(function(){$.getScript("model/lib/js/gencomp.php")});</script>
	<?php } ?>
	<?php include_once("../etc/scripts_pages.php"); ?>