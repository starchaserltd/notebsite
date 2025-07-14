<?php
if(isset($_GET['gpu_name_id'])){$_GET['gpu_model_id']=$_GET['gpu_name_id'];}
if(isset($_GET['gpulaunchdatemin'])){$_GET['gpu_launchdatemin']=$_GET['gpulaunchdatemin'];}
if(isset($_GET['gpulaunchdatemax'])){$_GET['gpu_launchdatemax']=$_GET['gpulaunchdatemax'];}
if(isset($_GET['gpubusmin'])){$_GET['gpu_membusmin']=$_GET['gpubusmin'];}
if(isset($_GET['gpubusmax'])){$_GET['gpu_membusmax']=$_GET['gpubusmax'];}
if(isset($_GET['gpupowermin'])){$_GET['gpu_powermin']=$_GET['gpupowermin'];}
if(isset($_GET['gputype2'])){$_GET['gpu_type2']=$_GET['gputype2'];}else{ $_GET['gpu_type2']=array(); }
$new_gpu_type=array();
foreach($_GET['gpu_type2'] as $key=>$val)
{
	if(strlen(strval($val))<3)
	{
		//Means it is a string, not an integer
		switch(intval($val))
		{
			case 10:
			{
				$_GET['gpu_type2'][$key]="integrated pro";
				break;
			}
			case 0:
			{
				$_GET['gpu_type2'][$key]="integrated + basic";
				break;
			}
			case 1:
			{
				$_GET['gpu_type2'][$key]="basic";
				break;
			}
			case 2:
			{
				$_GET['gpu_type2'][$key]="gaming";
				break;
			}
			case 3:
			{
				$_GET['gpu_type2'][$key]="cad/3d modeling";
				break;
			}
			case 4:
			{
				$_GET['gpu_type2'][$key]="high-end";
				break;
			}
			default:
			{ break; }
		}
	}
	else
	{
		if($val==0 || $val==0){ $key_to_delete[]=$key; }
	}
}
if(isset($_GET['gputype'])){$_GET['gpu_type']=$_GET['gputype'];}
if(isset($_GET['gpupowermax'])){$_GET['gpu_powermax']=$_GET['gpupowermax'];}
if(isset($_GET['gpumemmin'])){$_GET['gpu_memmin']=$_GET['gpumemmin'];}
if(isset($_GET['gpu_memmin'])){if(intval($_GET['gpu_memmin'])>500){ $_GET['gpu_memmin']=floatval($_GET['gpu_memmin']/1024); }}
if(isset($_GET['gpumemmax'])){$_GET['gpu_memmax']=$_GET['gpumemmax'];}
if(isset($_GET['gpu_memmax']))f(intval($_GET['gpu_memmax'])>500){ $_GET['gpu_memmax']=floatval($_GET['gpu_memmax']/1024); }}

?>