<?php
$to_return=false;

$test_gen_time=0;
if(isset($_POST['test_gen_time'])){ $test_gen_time=filter_var($_POST['test_gen_time'], FILTER_VALIDATE_INT); }

if($test_gen_time==1)
{
	$last_gen_date=false;
	if(isset($_POST['last_gen_date'])){ $last_gen_date=(filter_var($_POST['last_gen_date'], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^([1-2][0-9]{3})-([0-1][0-9])-([0-3][0-9])(?:( [0-2][0-9]):([0-5][0-9]):([0-5][0-9]))?$/")))); }
	if($last_gen_date!=false)
	{
		require("../../../etc/con_db.php");
		mysqli_select_db($con,$GLOBALS['global_notebro_site']);
		$sql="SELECT `name` FROM `nomen` WHERE `type`=9998 AND `prop`='gen_time' AND STR_TO_DATE(`name`,'%Y-%m-%d %H:%i:%s')>'".$last_gen_date."' LIMIT 1;";

		$result = mysqli_query($con,$sql);
		if(have_results($result))
		{
			$row=mysqli_fetch_assoc($result);
			$to_return=["new_data"=>$row["name"]];
			mysqli_free_result($result);
		}
		mysqli_close($con);
	}
}

print json_encode($to_return);

?>
