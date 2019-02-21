<script>
<?php if(isset($producer)){ ?>$('#Producer_prod_id').append('<?php echo $producer; ?>'); <?php } ?>
<?php if(isset($family)){ ?>$('#Family_fam_id').append('<?php echo $family; ?>'); <?php } ?>
<?php if(isset($regions)){ ?>$('#Regions_name_id').append('<?php echo $regions; ?>'); <?php } ?>
<?php if(isset($cpumodel)){ ?>$('#CPU_model_id').append('<?php echo $cpumodel; ?>'); <?php } ?>
<?php if(isset($cpusocket)){ ?>$('#CPU_socket_id').append('<?php echo $cpusocket; ?>'); <?php } ?>
<?php if(isset($cpumindate)){ echo "var cpumindateset=".$cpumindate.";"; } if(isset($cpumaxdate)){  echo "var cpumaxdateset=".$cpumaxdate.";"; } ?>
<?php if(isset($cpucoremin)){ echo "var cpucoreminset=".$cpucoremin.";"; } if(isset($cpucoremax)){  echo "var cpucoremaxset=".$cpucoremax.";"; } ?>
<?php if(isset($cputdpmin)){ echo "var cputdpminset=".$cputdpmin.";"; } if(isset($cputdpmax)){ echo "var cputdpmaxset=".$cputdpmax.";"; } ?>
<?php echo "var cpufreqminset=".$cpufreqmin.";"; echo "var cpufreqmaxset=".$cpufreqmax.";"; ?>
<?php echo "var cputechminset=".$cputechmax.";"; echo "var cputechmaxset=".$cputechmin.";"; ?>
<?php if(isset($cpumsc)){ ?>$('#CPU_msc_id').append('<?php echo $cpumsc; ?>'); <?php } ?>
<?php if(isset($gpumodel)){ ?>$('#GPU_model_id').append('<?php echo $gpumodel; ?>'); <?php } ?>
<?php echo "var gpumemminset=".$gpumemmin.";"; echo "var gpumemmaxset=".$gpumemmax.";";   ?>
<?php echo "var gpumembusminset=".$gpumembusmin.";"; echo "var gpumembusmaxset=".$gpumembusmax.";"; ?> 
<?php if(isset($gpuarch)){ ?>$('#GPU_arch_id').append('<?php echo $gpuarch; ?>'); <?php } ?>
<?php if(isset($gpumsc)){ ?>$('#GPU_msc_id').append('<?php echo $gpumsc; ?>'); <?php } ?>
<?php echo "var gpupowerminset=".$gpupowermin.";"; echo "var gpupowermaxset=".$gpupowermax.";"; ?>
<?php if(isset($gpumindate)){ echo "var gpumindateset=".$gpumindate.";"; } if(isset($gpumaxdate)){  echo "var gpumaxdateset=".$gpumaxdate.";"; } ?>
<?php echo "var displaysizeminset=".$displaysizemin.";"; echo "var displaysizemaxset=".$displaysizemax.";"; ?>
var displaysizeminset=setminuplimit(displaysizeminset,list_displaysize);
<?php if(isset($displayres)){ ?> $('#DISPLAY_resol_id').append('<?php echo $displayres; ?>'); <?php } ?>
<?php if(isset($displaymsc)){ ?> $('#DISPLAY_msc_id').append('<?php echo $displaymsc; ?>'); <?php } ?>
<?php echo "var totalcapminset=".$totalcapmin.";"; echo "var totalcapmaxset=".$totalcapmax.";"; ?>
<?php if(isset($mdbport)){ ?>$('#MDB_port_id').append('<?php echo $mdbport; ?>'); <?php } ?>
<?php if(isset($mdbvport)){ ?>$('#MDB_vport_id').append('<?php echo $mdbvport; ?>'); <?php } ?>
<?php echo "var memcapminset=".$memcapmin.";"; echo "var memcapmaxset=".$memcapmax.";"; ?>
<?php echo "var memfreqminset=".$memfreqmin.";"; echo "var memfreqmaxset=".$memfreqmax.";"; ?>
<?php echo "var batlifeminset=".$batlifemin.";"; echo "var batlifemaxset=".$batlifemax.";"; ?>
<?php echo "var acumcapminset=".$acumcapmin.";"; echo "var acumcapmaxset=".$acumcapmax.";"; ?>
<?php echo "chassisweightminset=".$chassisweightmin.";"; echo "chassisweightmaxset=".$chassisweightmax.";"; ?>
<?php echo "var chassisthicminset=".$chassisthicmin.";"; echo "var chassisthicmaxset=".$chassisthicmax.";"; ?>
<?php echo "var chassiswidthminset=".$chassiswidthmin.";"; echo "var chassiswidthmaxset=".$chassiswidthmax.";"; ?>
<?php echo "var chassisdepthminset=".$chassisdepthmin.";"; echo "var chassisdepthmaxset=".$chassisdepthmax.";"; ?>
<?php echo "var chassiswebminset=".$chassiswebmin.";"; echo "var chassiswebmaxset=".$chassiswebmax.";"; ?>
<?php if(isset($chassisstuff)){ ?>$('#CHASSIS_stuff_id').append('<?php echo $chassisstuff; ?>'); <?php } ?>
<?php echo "var waryearsminset=".$waryearsmin.";"; echo "var waryearsmaxset=".$waryearsmax.";"; ?>
<?php echo "var displayvresminset=".$displayvresmin.";"; echo "var displayvresmaxset=".$displayvresmax.";"; ?>
<?php echo "var lang=".$lang.";"; ?>
<?php if($show_rpm){ echo "var rpm_enable=1;"; }else{ echo "var rpm_enable=0;"; } ?>
var displayvresminset=setminuplimit(displayvresminset,list_verres);
function setminuplimit(minval,val_list){for (var val in val_list){ var val2=parseFloat(val_list[val]); if(val2>=minval){ return val2; break;} } }
pause_presearch=1;
</script>