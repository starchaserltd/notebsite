<?php 
function have_results($result){ $to_return=False;if($result and mysqli_num_rows($result)>0) { $to_return=True; } return $to_return; }
function has_content($string){ $to_return=True; if($string=="" || $string==NULL || $string===FALSE){ $to_return=False; } return $to_return; }
?>