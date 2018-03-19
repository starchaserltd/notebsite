<?php/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
echo getcwd() . "\n";
*/
?>

<?php 

$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
$method =""; $api_key =""; $param =""; $response=new stdClass(); $response->code=999; $response->message="Unknown error."; $response->result=new stdClass(); $response->daily_hits_left=null; $single_result=0;

if(isset($_POST['method'])) { $method=filter_var($_POST['method'], FILTER_SANITIZE_STRING); } 
if(isset($_POST['apikey'])) { $api_key = filter_var($_POST['apikey'], FILTER_SANITIZE_STRING);}
if(isset($_POST['param'])) { $param = $_POST['param'];}
if($api_key!==""&&$api_key!==NULL)
{
	require_once("../etc/con_db.php");
	$result = mysqli_query($con,"SELECT daily_hits FROM notebro_site.api_keys WHERE api_key = '".$api_key."'");
	if($result&&mysqli_num_rows($result)>0)
	{
		$hits_left=mysqli_fetch_row($result)[0];
		if(intval($hits_left)>0)
		{
			$sql = 'UPDATE `notebro_site`.`api_keys` SET `notebro_site`.`api_keys`.`daily_hits` = `notebro_site`.`api_keys`.`daily_hits`-1 WHERE `notebro_site`.`api_keys`.`api_key` = "'.$api_key.'"';  mysqli_query($con, $sql);
			if($method!==NULL && $method!=="")
			{
				switch($method)
				{
					case "get_model_info":
					{
						$response->code=26; $response->message="Valid method.";$response->daily_hits_left=$hits_left;
						$single_result=1;
						require_once("lib/api_search.php");
						break;
					}
					default:
					{
						$response->code=12; $response->message="Unknown method provided."; $response->daily_hits_left=$hits_left;
						break;
					}
				}
			}
			else
			{ $response->code=11; $response->message="No method provided, nothing to do."; $response->daily_hits_left=$hits_left; }
		}
		else
		{ $response->code=10; $response->message="Maximum daily queries has been exceeded. Contact site admin."; $response->daily_hits_left=$hits_left; }
	}
	else
	{ $response->code=0; $response->message="Unknown API key."; }
}
else
{ $response->code=0; $response->message="No valid API key provided."; }

echo json_encode($response);		
?>
