<?php
require_once("etc/conf.php");
$nrcheck=-1; $j=0; $t=0; $complink=''; $nrconf=0;
	for ($i=0;$i<9;$i++)
	{
		if(isset($_SESSION['conf'.$i]['id']))
		{
			if($_SESSION['conf'.$i]["checked"] && $nrcheck<4)
			{
				$nrcheck++;
				$checked="checked='checked'";
			}
			else
			{
				$checked="";
			}
			$nrconf++;
			echo '<tbody><tr id="comprow'.$_SESSION['conf'.$i]['id'].'"class="items" style="background:#fff;"><td class="comparecell1"><div class="checkbox" style="margin:0px; width:0px;"><input type="checkbox" onclick="cchecks('.$_SESSION['conf'.$i]['id'].')" class="css-checkbox sme" id="checkbox'.$_SESSION['conf'.$i]['id'].'" '.$checked.' /><label style="font-weight:normal;min-height:16px;" for="checkbox'.$_SESSION['conf'.$i]['id'].'" class="css-label sme depressed"></label></div></td><td class="text-center comparecell2" ><a  href="'.$web_address.'?model/model.php?conf='.$_SESSION['conf'.$i]['id'].'" class="comparename">'.$_SESSION['conf'.$i]['name'];
			echo '<div class="menuhidden">'.$_SESSION['conf'.$i]['disp_size'].'", '.$_SESSION['conf'.$i]['disp_res'].', '.$_SESSION['conf'.$i]['cpu_info'].', '.$_SESSION['conf'.$i]['gpu_info'].', '.$_SESSION['conf'.$i]['mem_info'].', '.$_SESSION['conf'.$i]['hdd_info'].'</div></a></td><td class="text-center" style="width:16px;padding-bottom:2px; padding-top:2px;"><a  style="color:#49505a;font-size:16px;padding:0px;background-color:#fff;" onclick="removecomp('.$_SESSION['conf'.$i]['id'].',0)"><span class="glyphicon glyphicon-remove"></span></a></td></tr></tbody>';		
		}
		else
		{
			if(isset($_SESSION['conf'.$i]['name']))
			{
				//ON SOME STRANGE OCASSION THE PROGRAM DOESN'T DELETE DE CONFIG, THIS IS DESIGN TO CLEANUP THE LIST
				unset($_SESSION['conf'.$i]);
				$j=0;
				for($i=0;$i<=9;$i++)
				{
					if(!(isset($_SESSION['conf'.$i])) || $_SESSION['conf'.$i]["id"]==0 || ($_SESSION['conf'.$i]==NULL))
					{
						if(!$j)
						$j=$i;
					}
					else
					{
						if($j)
						{
							$_SESSION['conf'.$j]=$_SESSION['conf'.$i];
							unset($_SESSION['conf'.$i]);
							$i=$j;
							$j=0;
						}
					}
				}
			}
		}
		
		if(isset($_SESSION['conf'.$i]["checked"]) && $_SESSION['conf'.$i]["checked"])
		{ $complink=$complink."conf".($nrcheck)."=".$_SESSION['conf'.$i]['id']."&"; }
	}
	
	if($nrcheck==3 && $nrconf>4) { $nrcheck=4; }

	$complink=substr($complink, 0, -1);
	echo "<script> var nrcheck=".$nrcheck."; var complink='".$complink."';"; if($nrcheck>0){ echo "var firstcompare=0;";} 
	if($nrcheck>-1)
	{
		echo "$($('#cssmenu li.has-sub>a')).parent('li').removeClass('open'); $($('#cssmenu li.has-sub>a')).parent('li').children('ul').slideUp(200); $($('#cssmenu li.has-sub>a')[3]).parent('li').addClass('open'); $($('#cssmenu li.has-sub>a')[3]).parent('li').children('ul').slideDown(200); $($('#cssmenu li.has-sub>a')[4]).parent('li').addClass('open'); $($('#cssmenu li.has-sub>a')[4]).parent('li').children('ul').slideDown(200);";
	}
	echo " </script>";
?>