<?php
date_default_timezone_set('UTC');
include_once 'baseline.php';
include_once 'minify.php';



// Locate files
$readmePath = '../readme.md';
$templatesPath = '../source/templates/';

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
$input = array();
if (isset($_GET)) {
	for ($i = 0; $i < 9; $i++) { 
		$temp = array();
		if (isset($_GET['breakpoint'.$i])) {
			$temp = explode(',', $_GET['breakpoint'.$i]);
			if (isset($temp[0]) and isset($temp[1])) {
				$input[$temp[0]] = $temp[1];
			}
		}
	}
}



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

	header('HTTP/1.1 400 Bad Request');
	echo '
		<html>
			<head>
				<title>Compile your layers.css breakpoints</title>
				<style type="text/css">

					body {
						background-color: #fafafa;
						color: #373f45;
						font-family: sans-serif;
						font-weight: 200;
						line-height: 1.6;
					}
					.body-container {
						margin: 0 auto;
						padding: 5% 5% 8em 5%;
						max-width: 40em;
					}

					a, a:visited {
						color: #0080bf;
					}

					ul {
						list-style: none;
						padding-left: 0;
					}

					.clear {
						clear: both;
					}

					h1 {
						margin-top: 0;
						font-weight: 100;
					}

				</style>
			</head>
			<body>
				<div class="body-container">
					<h1>Missing breakpoints</h1>
					<p>Head over to <a href="../">Layers CSS\'s docs</a> and set your own custom breakpoints or <a href="?breakpoint1=small,40em&breakpoint2=medium,70em">Try the defaults</a>.</p>
				</div>
			</body>
		</html>
	';

} else {

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

		// Breakpoint offset
		$barelyValue = intval(substr($value, 0, -2));
		if (suffixed($value, 'em')) {
			$barelyValue = ($barelyValue - 0.0625).'em';
		} else {
			$barelyValue = ($barelyValue - 1).'px';
		}

		// String replacement in template
		$keys = array('{{name}}', '{{barelyWidth}}', '{{width}}');
		$values = array($name, $barelyValue, $value);

		// Raw template
		$temp = '';
		if ($previousName) {
			$temp = $templateConsecutive;
			$keys[] = '{{previousName}}';
			$values[] = $previousName;
		} else {
			$temp = $template;
		}

		$output[] = str_replace($keys, $values, $temp);
		$previousName = $name;
	}

	// Output string
	header('Content-Type: text/css; charset=utf-8');
	header('HTTP/1.1 200 OK');
	$output = implode("\n\n", $output);
	echo $prefix.$output;
	// echo $prefix.minify($output);

}



die();

?>