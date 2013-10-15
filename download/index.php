<?php
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', '1');
ini_set('log_errors', '1');
mb_internal_encoding('UTF-8');
date_default_timezone_set('UTC');

// header('Location: https://bitbucket.org/Eiskis/layers-css/raw/tip/release/layers.min.css');



// Dependencies
$root = substr($_SERVER['SCRIPT_NAME'], 0, -strlen('index.php'));
require_once 'baseline.php';
require_once 'DownloadManager.php';



// Handle input
$keywords = array(
	'download' => false,
	'merge' => false,
	'minify' => false,
	'responsive' => false,
);
if (isset($_GET) and is_array($_GET) and isset($_GET['keywords'])) {
	$temp = explode(',', $_GET['keywords']);
	foreach ($keywords as $keyword => $value) {
		if (in_array($keyword, $temp)) {
			$keywords[$keyword] = true;
		}
	}
}
unset($_GET, $_POST);



// Settings
$name = 'layers';
$prefix = 'Layers CSS by Jerry Jäppinen
Released under the MIT license
http://eiskis.net/layers';

// Initiate download manager
$release = create_object(new DownloadManager('css', 'text/css', $name, $prefix));
foreach (array('download', 'merge', 'minify') as $keyword) {
	if ($keywords[$keyword]) {
		$release->$keyword();
	}
}

// Pick source files
$releases = array('../source/layers/');
if ($keywords['responsive']) {
	$releases[] = '../source/responsive/';
}
$release->pick($releases);

// $release->output();
// die();

// Test output
header('Content-Type: text/html; charset=utf-8');
echo '<html>
	<head>
		<title>Layers download manager</title>
		<link rel="stylesheet" href="'.$root.'prism.css" media="screen">
		<style type="text/css">

			body {
				background-color: #f2f2f2;
				color: #373f45;
				font-family: sans-serif;
				padding: 5% 5% 8em 5%;
				max-width: 65em;
				margin: 0 auto;
				font-weight: 200;
				line-height: 1.6;
			}

			pre {
				background-color: #fff;
				box-shadow: 0 1px 1px 1px #ddd;
				padding: 4em;
				white-space: pre-wrap;
				word-wrap: break-word;
			}

			h1 {
				font-weight: 100;
			}

		</style>
	</head>
	<body>
		';

			echo html_dump($release->headers());
			echo html_dump(array_keys($release->scripts()));
			echo html_dump($keywords);

			echo '<pre class="language-css"><code class="language-css">';
			$release->outputBody();
			echo '</pre></code>';

		echo '
		<script src="'.$root.'prism.js" type="application/javascript"></script>
	</body>
</html>';
die();
?>