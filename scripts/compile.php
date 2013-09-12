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
if (isset($_GET['path']) and is_dir($sourcePath.$_GET['path'].'/')) {
	$path = $sourcePath.$_GET['path'].'/';
} else {
	$path = $sourcePath;
}



// Content type header
header('Content-Type: text/css; charset: UTF-8');

// Include all files
$output = '';
foreach (rglob($path.'*') as $value) {
	$output .= minify(file_get_contents($value));
}

// Save compilation file
if (isset($_GET['save'])) {
	$name = basename($path);
	if (empty($name)) {
		$name = 'all';
	}
	file_put_contents($releasePath.$name.'.css', $output);
}

echo $output."\n";
?>