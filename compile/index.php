<?php
date_default_timezone_set('UTC');
include_once 'baseline.php';
include_once 'include.php';



// Choose what to include
$releases = array('layers', 'responsive');
$readmePath = '../readme.md';
$sourcePath = '../source/';
$releasePath = '../release/';
$title = 'Layers CSS';
$save = false;
if (in_array($_SERVER['SERVER_ADDR'], array('127.0.0.1', '::1')) and !isset($_GET['dontsave'])) {
	$save = true;
}

// Find title with version info (first line in readme)
$readme = trim(file_get_contents($readmePath));
$readme = str_replace('# ', '', substr($readme, 0, strpos($readme, "\n")));
if (strpos($readme, $title) !== false) {
	$title = $readme;
}

// Release each script
foreach ($releases as $name) {

	// Read source files
	$source = '';
	foreach (rglob_files($sourcePath.$name.'/') as $value) {
		$source .= file_get_contents($value);
	}

	// Author info
	$prefix = '/*
'.$title.' '.($name === 'responsive' ? ' responsive adjustments' : '').'
Released by Jerry Jäppinen under the MIT license
http://eiskis.net/layers
'.date('Y-m-d H:i e') .'
*/
';
	$minRelease = $prefix.minify($source);
	$release = $prefix.$source;

	// Save compilation file on localhost
	if ($save) {
		file_put_contents($releasePath.$name.'.css', $release);
		file_put_contents($releasePath.$name.'.min.css', $minRelease);
	}

}
unset($name);



// Print report
header('Content-Type: text/html; charset=utf-8');
echo '
<html>
	<head>
		<title>Compiled layers.css</title>
		<style type="text/css">

			body {
				background-color: #fafafa;
				color: #373f45;
				font-family: sans-serif;
				padding: 5% 5% 8em 5%;
				max-width: 65em;
				margin: 0 auto;
				font-weight: 200;
				line-height: 1.6;
			}

			p {
				max-width: 50em;
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
				font-weight: 100;
			}

			h2 {
				font-weight: 200;
				margin-top: 2em;
			}

			h2 a, h2 a:visited {
				color: inherit;
				text-decoration: none;
			}

			h2 small {
				font-size: 0.8em;
				color: #999;
			}

			code {
				font-size: 1.1em;
			}

			iframe {
				padding: 0;
				border: 0;
				background-color: #fff;
				width: 100%;
				height: 22em;
			}

		</style>
	</head>
	<body>

		<h1>Layers.css released</h1>

		<p>The following files were generated:</p>

		'.($save ? '' : '<p>(These files were not saved, this is only a preview.)</p>').'
		';

		// Previews files
		foreach ($releases as $name) {
			foreach (array('', '.min') as $prefix) {
				$path = $releasePath.$name.$prefix.'.css';
				echo '
				<h2><a href="'.$path.'">'.$name.$prefix.'.css <small>'.(filesize($path)/1000).' kb</small></a></h2>
				<iframe src="'.$path.'"></iframe>
				';
			}
		}

		echo '
		<div class="clear"></div>
	</body>
</html>
';

die();

?>