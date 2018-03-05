<?php/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
echo getcwd() . "\n";
*/
?>

<?php 

//de facut o formatare a valorilor .  (de facut o tabela cu blocks_ips) pt eventualitate.    sanitizarea campurilor nume si api keys

// cand acceseaza api keys sil gaseste sa scada din dayli_hits
/*
formular 1

api_key,    metoda,   parametrii   
formular 2

api_key     si  aici sa afiseze cate daily hituri mai are 

{
    "status": "ok",
    "code": 200,
    "messages": [],
    "result": {
        "user": {
            "id": 123,
            "name": "shazow"
        }
    }
}


*/

$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
$method =""; $api_key =""; $param =""; $response=new stdClass(); $response->code=999; $response->message="Unknown error."; $response->result=new stdClass(); $response->daily_hits_left=null;

/** SANITIZARe AICI !!!***/
if(isset($_POST['method'])) { $method=filter_var($_POST['method'], FILTER_SANITIZE_STRING); } 
if(isset($_POST['apikey'])) { $api_key = filter_var($_POST['apikey'], FILTER_SANITIZE_STRING);}
if(isset($_POST['param'])) { $param = $_POST['param'];}


var_dump($param);


/*
$param['cpu_name'] = 'i7-8709G'; $sql = "SELECT id FROM notebro_db.CPU WHERE model like '%".$param['cpu_name']."%'"; 

$param['gpu_name'] = 'Quadro P500'; $sql = "SELECT id FROM notebro_db.GPU WHERE model like '%".$param['gpu_name']."%'"; 

$param['display_res'] = "1920x1080"; 
$param['display_type'] = " ";    						// la ce ne referim aici
$param['display_srgb']= "60";
$res = explode("x",$param['display_res']); $sql = "SELECT id FROM notebro_db.DISPLAY WHERE hres='".$res[0]."' AND vres='".$res[1]."' AND sRGB = '".$param['display_srgb']."'";

$param['maxmem'] = "64"; $sql = "SELECT id FROM notebro_db.MEM WHERE cap <= '".$param['maxmem']."'"; 

$param['firsthddcap']= "256"; $sql = "SELECT id FROM notebro_db.HDD WHERE cap = '".$param['firsthddcap']."'"; 
$param['secondhddcap']= "2000";$sql = "SELECT id FROM notebro_db.HDD WHERE cap = '".$param['secondhddcap']."'"; 


$param['model_name']; **
$param['cpu_name']; **
$param['gpu_name']; **
$param['display_res']; **
$param['display_type']; **
$param['display_srgb']; **
$param['maxmem'];        **					// de la ce
$param['firsthddcap'];
$param['secondhddcap'];
$param['mdb_wan'];
$param['mdb_gsync'];
$param['mdb_optimus'];
$param['wireless_type'];
$param['odd_type'];
$param['battery_size'];
$param['warranty_years'];
$param['warranty_type'];
$param['opsist'];

*/





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
						$query_search="";
						$orderby = "ORDER BY rating ASC";
						$orderby_index = "USE INDEX FOR ORDER BY (rating)";
						$sort_func = "sort_func_by_rating";
	
						$relativepath="";
						require_once("../etc/con_sdb.php");
						require_once("preproc/api_varproc.php");
	
						ob_start();
						require("../search/proc/search_filters.php");
						ob_get_clean();
	
						$conds = array();
						foreach (array("cpu", "display", "gpu", "acum", "war", "hdd", "wnet", "sist", "odd", "mem", "mdb", "chassis") as $v) 
						{
							if (!$to_search[$v]) { continue; }
							$conds[$v] = $v . " IN (" . implode(",", array_keys($comp_lists[$v])) . ")";
						}

						if ($nr_hdd > 1) { $conds["shdd"]="shdd > 0"; }
						$conds["capacity"] = "(capacity BETWEEN " . $totalcapmin . " AND " . $totalcapmax . " )";
						$results = array(); $queries = array();

						/* DEBUGGING CODE */
						# $time_start = microtime(true);
						# echo "<pre>" . var_dump($comp_lists) . "</pre>";
						if(!isset($comp_lists["model"])){ $comp_lists["model"]=$comp_lists_api["model"]; }
						foreach($comp_lists["model"] as $m)
						{
							$model = $m["id"];
							$conds_model = $conds;
							
							if($conds_model)
							{ $query_search = "SELECT id FROM notebro_temp.all_conf_".$model." WHERE " . implode(" AND ", $conds_model) . " AND price>0 LIMIT 1"; }


							/* DEBUGGING CODE */
							# echo "<pre>" . var_dump($query_search) . "</pre>";
							# $time_start_query = microtime(true);
							# echo "<pre>"; var_dump($query_search); var_dump( $presearch_batlifemin); echo "<br>"; echo "</pre>";
							$result=mysqli_query($cons, $query_search);
							#echo $query_search; echo "<br>";
							if($result)
							{ 
								$result = mysqli_fetch_assoc($result); 

								# $time_end_query = microtime(true);
								# array_push($queries, array(
								#	"query" => $query_search,
								#	"time" => $time_end_query - $time_start_query));
								if (!is_null($result)) { if(($result["id"]!=NULL)){ var_dump($result); } }
							
							}
						}
						$response->code=26; $response->message="Valid method.";$response->daily_hits_left=$hits_left;
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
