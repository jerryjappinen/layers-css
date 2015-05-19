<?php

// Helpers

// Minify CSS string
function minify($string) {
	$string = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $string);
	$string = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '	', '	'), '', $string);
	return str_replace(array(" {", "{ ", "; ", ": ", " :", " ,", ", ", ";}"), array("{", "{", ";", ":", ":", ",", ",", "}"), $string);
}

?>