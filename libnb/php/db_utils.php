<?php
function have_results($result){ $to_return=False; if($result){ $num_row=mysqli_num_rows($result); if($num_row!=NULL && $num_row>0){ $to_return=True; } }return $to_return; } 

function nb_multiquery($con,$sql_query)
{
	$to_return=False;
	if (mysqli_multi_query($con, $sql_query))
	{
		$to_return=array();
		$query_nr=0;
		do
		{
			if ($result = mysqli_store_result($con))
			{
				$to_return[$query_nr]=array();
				while ($row = mysqli_fetch_assoc($result)) { $to_return[$query_nr][]=$row; }
				mysqli_free_result($result);
			}
			if (mysqli_more_results($con)) { $query_nr++; }
		}
		while (mysqli_next_result($con));
	}
	return $to_return;
}
?>