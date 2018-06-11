<script>
<?php if(isset($producer)){ ?>$('#Producer_prod_id').append('<?php echo $producer; ?>'); <?php } ?>
<?php if(isset($family)){ ?>$('#Family_fam_id').append('<?php echo $family; ?>'); <?php } ?>
<?php if(isset($regions)){ ?>$('#Regions_name_id').append('<?php echo $regions; ?>'); <?php } ?> // new line REGIONS
<?php if(isset($cpumodel)){ ?>$('#CPU_model_id').append('<?php echo $cpumodel; ?>'); <?php } ?>
<?php if(isset($cpusocket)){ ?>$('#CPU_socket_id').append('<?php echo $cpusocket; ?>'); <?php } ?>
<?php if(isset($cpumindate)){ echo "cpumindateset=".$cpumindate.";"; } if(isset($cpumaxdate)){  echo "cpumaxdateset=".$cpumaxdate.";"; } ?>
<?php if(isset($cpucoremin)){ echo "cpucoreminset=".$cpucoremin.";"; } if(isset($cpucoremax)){  echo "cpucoremaxset=".$cpucoremax.";"; } ?>
<?php if(isset($cputdpmin)){ echo "cputdpminset=".$cputdpmin.";"; } if(isset($cputdpmax)){ echo "cputdpmaxset=".$cputdpmax.";"; } ?>
<?php echo "cpufreqminset=".$cpufreqmin.";"; echo "cpufreqmaxset=".$cpufreqmax.";"; ?>
<?php echo "cputechminset=".$cputechmax.";"; echo "cputechmaxset=".$cputechmin.";"; ?>
<?php if(isset($cpumsc)){ ?>$('#CPU_msc_id').append('<?php echo $cpumsc; ?>'); <?php } ?>
<?php if(isset($gpumodel)){ ?>$('#GPU_model_id').append('<?php echo $gpumodel; ?>'); <?php } ?>
<?php echo "gpumemminset=".$gpumemmin.";"; echo "gpumemmaxset=".$gpumemmax.";";   ?>
<?php echo "gpumembusminset=".$gpumembusmin.";"; echo "gpumembusmaxset=".$gpumembusmax.";"; ?> 
<?php if(isset($gpuarch)){ ?>$('#GPU_arch_id').append('<?php echo $gpuarch; ?>'); <?php } ?>
<?php if(isset($gpumsc)){ ?>$('#GPU_msc_id').append('<?php echo $gpumsc; ?>'); <?php } ?>
<?php echo "gpupowerminset=".$gpupowermin.";"; echo "gpupowermaxset=".$gpupowermax.";"; ?>
<?php if(isset($gpumindate)){ echo "gpumindateset=".$gpumindate.";"; } if(isset($gpumaxdate)){  echo "gpumaxdateset=".$gpumaxdate.";"; } ?>
<?php echo "displaysizeminset=".$displaysizemin.";"; echo "displaysizemaxset=".$displaysizemax.";"; ?>
displaysizeminset=setminuplimit(displaysizeminset,list_displaysize);
<?php if(isset($displayres)){ ?> $('#DISPLAY_resol_id').append('<?php echo $displayres; ?>'); <?php } ?>
<?php if(isset($displaymsc)){ ?> $('#DISPLAY_msc_id').append('<?php echo $displaymsc; ?>'); <?php } ?>
<?php echo "totalcapminset=".$totalcapmin.";"; echo "totalcapmaxset=".$totalcapmax.";"; ?>
<?php if(isset($mdbport)){ ?>$('#MDB_port_id').append('<?php echo $mdbport; ?>'); <?php } ?>
<?php if(isset($mdbvport)){ ?>$('#MDB_vport_id').append('<?php echo $mdbvport; ?>'); <?php } ?>
<?php echo "memcapminset=".$memcapmin.";"; echo "memcapmaxset=".$memcapmax.";"; ?>
<?php echo "memfreqminset=".$memfreqmin.";"; echo "memfreqmaxset=".$memfreqmax.";"; ?>
<?php echo "batlifeminset=".$batlifemin.";"; echo "batlifemaxset=".$batlifemax.";"; ?>
<?php echo "acumcapminset=".$acumcapmin.";"; echo "acumcapmaxset=".$acumcapmax.";"; ?>
<?php echo "chassisweightminset=".$chassisweightmin.";"; echo "chassisweightmaxset=".$chassisweightmax.";"; ?>
<?php echo "chassisthicminset=".$chassisthicmin.";"; echo "chassisthicmaxset=".$chassisthicmax.";"; ?>
<?php echo "chassiswidthminset=".$chassiswidthmin.";"; echo "chassiswidthmaxset=".$chassiswidthmax.";"; ?>
<?php echo "chassisdepthminset=".$chassisdepthmin.";"; echo "chassisdepthmaxset=".$chassisdepthmax.";"; ?>
<?php echo "chassiswebminset=".$chassiswebmin.";"; echo "chassiswebmaxset=".$chassiswebmax.";"; ?>
<?php if(isset($chassisstuff)){ ?>$('#CHASSIS_stuff_id').append('<?php echo $chassisstuff; ?>'); <?php } ?>
<?php echo "waryearsminset=".$waryearsmin.";"; echo "waryearsmaxset=".$waryearsmax.";"; ?>
<?php echo "displayvresminset=".$displayvresmin.";"; echo "displayvresmaxset=".$displayvresmax.";"; ?>
<?php echo "lang=".$lang.";"; ?>
displayvresminset=setminuplimit(displayvresminset,list_verres);
function setminuplimit(minval,val_list){for (var val in val_list){ var val2=parseFloat(val_list[val]); if(val2>=minval){ return val2; break;} } }
</script>