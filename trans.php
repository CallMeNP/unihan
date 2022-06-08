<?php
$files=[
	"Unihan_DictionaryIndices.txt",
	"Unihan_DictionaryLikeData.txt",
	"Unihan_IRGSources.txt",
	"Unihan_NumericValues.txt",
	"Unihan_OtherMappings.txt",
	"Unihan_RadicalStrokeCounts.txt",
	"Unihan_Readings.txt",
	"Unihan_Variants.txt"
];
$arrLines=[];
foreach($files as $file){
	$content=file_get_contents($file);
	$lines=explode("\n",$content);

	foreach($lines as $line){
		if(strpos($line,'U+')!==0){
			continue;
		}
		$arrLines[]=explode("\t",$line);
	}
}
$code=array_keys(array_flip(array_column($arrLines, 0)));
$prop=array_keys(array_flip(array_column($arrLines,1)));


// tpl row
$tmpRow=[];
$tmpRow['char']='';
$tmpRow['code']='';
foreach ($prop as $key => $value) {
	$tmpRow[$value]="";
}

// apply tpl row
$data=[];
foreach ($code as $key => $value) {
	$data[$value]=$tmpRow;
}

// build data
foreach($arrLines as $arrLine){
	$data[$arrLine[0]][$arrLine[1]]=" ".$arrLine[2];
}

// output
fputcsv(fopen('php://stdout', 'a+'), array_keys($tmpRow));
include('Unicode.php');
$unicode=new Unicode();
foreach ($data as $key => $value) {
	$char=$unicode->unicodeToChar(str_replace('U+', '', $key));
	$value['char']=$char;
	$value['code']=$key;
	fputcsv(fopen('php://stdout', 'a+'), $value);
}

