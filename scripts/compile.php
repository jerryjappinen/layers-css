<?php
include_once 'include.php';

// Minify CSS string
function minify($string) {
	$string = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $string);
	$string = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '	', '	'), '', $string);
	$string = str_replace(array(" {", "{ ", "; ", ": ", " :", " ,", ", ", ";}"), array("{", "{", ";", ":", ":", ",", ",", "}"), $string);
	return $string;
}



// Choose what to include
$root = '../';
if (isset($_GET['path']) and is_dir($root.$_GET['path'].'/')) {
	$path = $root.$_GET['path'].'/';
} else {
	$path = $root;
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
		$name = 'layers_all';
	}
	file_put_contents($root.$name.'.css', $output);
}

echo $output;
?>