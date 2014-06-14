<?php
date_default_timezone_set('UTC');
include_once 'baseline.php';
include_once 'include.php';


header('Content-Type: text/css; charset=utf-8');

// Locate files
$readmePath = '../readme.md';
$templatesPath = '../templates/';

// Find title with version info (first line in readme)
$title = 'Layers CSS';
$readme = trim(file_get_contents($readmePath));
$readme = trim(str_replace('# ', '', substr($readme, 0, strpos($readme, "\n"))));
if (strpos($readme, $title) !== false) {
	$title = $readme;
}
unset($readme);

// Read source file
$template .= $templatesPath.'responsive.tmpl.css';
$templateConsecutive .= $templatesPath.'responsive-consecutive.tmpl.css';
if (!is_file($template) or !is_file($templateConsecutive)) {
	throw new Exception('Missing template files.', 500);

} else {
	$template = file_get_contents($template);
	$templateConsecutive = file_get_contents($templateConsecutive);
}



// Take input
$input = array('tiny' => '30em', 'small' => 60);



// Validate input
$i = 0;
$breakpoints = array();
foreach ($input as $key => $value) {

	if (is_numeric($value)) {
		$value = ''.$value.'em';
	}

	// Basic input type validation
	if (!is_string($key) or !is_string($value)) {
		throw new Exception('Invalid name or value given for breakpoint number '.$i, 400);

	} else {
		$key = unsuffix(unsuffix(unprefix(unprefix(trim_whitespace($key), '.'), '-'), '.'), '-');
		if (is_string($value)) {
			$value = unsuffix(unsuffix(unprefix(unprefix(trim_whitespace($value), '.'), '-'), '.'), '-');
		}

		// Empty after formatting
		if (empty($key) or empty($value)) {
			throw new Exception('Please provide proper name and value for breakpoint number '.$i, 400);
		} else {
			$breakpoints[$key] = $value;
		}

	}

	$i++;
}
unset($i);



// Output
if (!count($breakpoints)) {
	throw new Exception('No valid breakpoints given.', 400);
} else {
}



// Author info
$prefix = '/*
'.$title.'
Released by Jerry Jäppinen under the MIT license
http://eiskis.net/layers
'.date('Y-m-d H:i e') .'
*/
';



// Print report
$output = array();
$previousName = '';
foreach ($breakpoints as $name => $value) {

	// String replacement in template
	$keys = array('{{name}}', '{{width}}');
	$values = array($name, $value);

	// Raw template
	$temp = '';
	if ($previousName) {
		$temp = $templateConsecutive;
		$keys[] = 'previousName';
		$values[] = $previousName;
	} else {
		$temp = $template;
	}

	$output[] = str_replace($keys, $values, $temp);
	$previousName = $name;
}

// Output string
$output = implode("\n\n", $output);
// echo $prefix.$output;
echo $prefix.minify($output);

die();

?>