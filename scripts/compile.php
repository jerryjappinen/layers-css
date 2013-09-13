<?php
include_once 'include.php';

// Minify CSS string
function minify($string) {
	$string = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $string);
	$string = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '	', '	'), '', $string);
	return str_replace(array(" {", "{ ", "; ", ": ", " :", " ,", ", ", ";}"), array("{", "{", ";", ":", ":", ",", ",", "}"), $string);
}



// Choose what to include
$sourcePath = '../source/';
$releasePath = '../release/';
$name = 'layers';
if (isset($_GET['path']) and is_dir($sourcePath.$_GET['path'].'/')) {
	$name = $_GET['path'];
}



// Content type header
header('Content-Type: text/css; charset: UTF-8');

// Include files
$output = '/*
Layers CSS'.($name === 'responsive' ? ' responsive adjustments' : '').' by Jerry Jäppinen
Released under the MIT license
http://eiskis.net/layers
'.date('Y-m-d H:i e') .'
*/
';
foreach (rglob($sourcePath.$name.'/'.'*') as $value) {
	$output .= minify(file_get_contents($value));
}

// Save compilation file
if (isset($_GET['save'])) {
	file_put_contents($releasePath.$name.'.css', $output);
}

echo $output."\n";
?>