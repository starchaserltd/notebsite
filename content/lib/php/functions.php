<?php
function nobrackets($text)
{
	preg_match_all('/\[/',$text,$startmatches, PREG_OFFSET_CAPTURE);
	preg_match_all('/\]/',$text,$endmatches, PREG_OFFSET_CAPTURE);

	$nrbrackets=count($startmatches[0]);
	$newtext="";
	$offset=0;

	for($i=0;$i<$nrbrackets;$i++)
	{
		if(!isset($startmatches[0][$i][1]))
		{  $startmatches[0][$i][1]=0; }
	
		if(!isset($endmatches[0][$i][1]))
		{  $endmatches[0][$i][1]=0; }
	
		$text=substr_replace($text,'',($startmatches[0][$i][1]-$offset),$endmatches[0][$i][1]-$startmatches[0][$i][1]+1);
		$offset+=($endmatches[0][$i][1]-$startmatches[0][$i][1]+1);
		
		if($startmatches[0][$i][1] && !($endmatches[0][$i][1]))
		{ 	
			$offset-=($endmatches[0][$i][1]-$startmatches[0][$i][1]+1);	
			$text=substr_replace($text,'',($startmatches[0][$i][1]-$offset),$startmatches[0][$i][1]-strlen($text));  }
		}
	return $text;	
}
?>