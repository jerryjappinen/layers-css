<?php

// Helpers

// Minify CSS string
function minify($string) {
	$string = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $string);
	$string = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '	', '	'), '', $string);
	return str_replace(array(" {", "{ ", "; ", ": ", " :", " ,", ", ", ";}"), array("{", "{", ";", ":", ":", ",", ",", "}"), $string);
}

// Search for directories in a standardized way
function glob_dir ($path = '') {
	$temp = glob($path.'*', GLOB_MARK | GLOB_ONLYDIR);
	foreach ($temp as $key => $value) {
		$temp[$key] = str_replace('\\', '/', $value);
	}
	return $temp;
}

// Search for files in a standardized way
function glob_files ($path = '', $types = array()) {
	return glob($path.'*.'.(empty($types) ? '*' : '{'.implode(',', $types).'}'), GLOB_BRACE);
}

// Search for stuff recursively
function rglob ($pattern = '*', $path = '', $flags = 0) {
	$paths = glob_dir($path);
	$files = glob($path.$pattern, $flags);
	
	foreach ($paths as $path) {
		$files = array_merge($files, rglob($pattern, $path, $flags));
	}

	return $files;
}

// Search for stuff recursively
function rglob_dir ($path = '') {
	$directories = glob_dir($path);
	foreach ($directories as $path) {
		$directories = array_merge($directories, rglob_dir($path));
	}
	return $directories;
}

?>