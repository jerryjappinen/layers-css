<?php

/**
* 
*/
class DownloadManager {



	/**
	* Properties
	*/

	// Constants
	private $sourceFormat 		= 'js';
	private $targetContentType 	= 'text/javascript';
	private $name 				= 'package';
	private $mergePrefix 		= '';

	// Paths
	private $tempPath 		= 'temp/';



	/**
	* Contents
	*/
	private $propertyScripts = array();
	public function scripts () {
		return $this->propertyScripts;
	}
	private function setScripts ($scripts = array()) {
		$scripts = func_get_args();
		$scripts = array_flatten($scripts, false, true);
		$this->propertyScripts = to_array($scripts);
		return $this;
	}



	/**
	* Output settings & handlers
	*/

	private $propertyShouldDownload = false;
	private $propertyShouldMerge 	= false;
	private $propertyShouldMinify 	= false;

	public function download 		() { $this->propertyShouldDownload = true;		return $this;}
	public function merge 			() { $this->propertyShouldMerge = true;			return $this;}
	public function minify 			() { $this->propertyShouldMinify = true;		return $this;}

	public function dontDownload 	() { $this->propertyShouldDownload = false;		return $this;}
	public function dontMerge 		() { $this->propertyShouldMerge = false;		return $this;}
	public function dontMinify 		() { $this->propertyShouldMinify = false;		return $this;}

	private function shouldDownload () { return $this->propertyShouldDownload;}
	private function shouldMerge 	() { return $this->propertyShouldMerge;}
	private function shouldMinify 	() { return $this->propertyShouldMinify;}

	// Detect if we're outputting multiple files
	private function singleFile () {
		return $this->shouldMerge() or count($this->scripts()) < 2;
	}



	/**
	* Constructor
	*/
	public function __construct ($format, $contentType, $name = null, $mergePrefix = null) {

		// Format
		if (is_string($format) and !empty($format)) {
			$this->changeFormat($format);
		}

		// Content type
		if (is_string($contentType) and !empty($contentType)) {
			$this->changeContentType($contentType);
		}

		// Name
		if (is_string($name) and !empty($name)) {
			$this->changeName($name);
		}

		// Prefix
		if (is_string($mergePrefix)) {
			$this->changeMergePrefix($mergePrefix);
		}

		return $this;
	}



	/**
	* Set constants
	*/

	public function changeFormat ($string) {
		if (is_string($string)) {
			$string = trim_whitespace($string);
			if ($string) {
				$this->sourceFormat = $string;
			}
		}
		return $this;
	}

	public function changeContentType ($string) {
		if (is_string($string)) {
			$string = trim_whitespace($string);
			if ($string) {
				$this->targetContentType = $string;
			}
		}
		return $this;
	}

	public function changeName ($name) {
		if (is_string($name)) {
			$name = trim_whitespace($name);
			if ($name) {
				$this->name = $name;
			}
		}
		return $this;
	}

	public function changeMergePrefix ($mergePrefix) {
		if (is_string($mergePrefix)) {
			$this->mergePrefix = trim_text($mergePrefix);
		}
		return $this;
	}



	/**
	* Main output creation
	*/

	public function output () {
		$this->outputHeaders();
		return $this->outputBody();
	}

	public function outputHeaders () {
		foreach ($this->headers() as $headerString) {
			header($headerString);
		}
		return $this;
	}

	public function outputBody () {

		// Single file: CSS string
		if ($this->singleFile()) {
			$output = '';
			$scripts = $this->scripts();

			// Iterate through all source files
			foreach ($scripts as $key => $script) {
				if ($this->shouldMinify()) {
					$methodName = 'minify'.ucfirst($this->sourceFormat);
					if (method_exists($this, $methodName)) {
						$scripts[$key] = $this->$methodName($script);
					}
				}
			}

			// Merge all scripts
			echo implode($this->shouldMinify() ? '' : "\n\n", $scripts);

		// Multiple files: package into zip
		} else {
			echo 'Zip ('.count($this->scripts()).' files)';
		}

		return $this;
	}



	/**
	* Functionality
	*/

	// Open files and read their contents into strings
	public function pick ($arguments = array()) {
		$arguments = func_get_args();
		$arguments = array_flatten($arguments);

		// Find all files requested
		$files = array();
		foreach ($arguments as $path) {
			if (is_dir($path)) {
				$files = array_merge($files, rglob_files($path, $this->sourceFormat));
			} else if (is_file($path) and pathinfo($path, PATHINFO_EXTENSION) === $this->sourceFormat) {
				$files[] = $path;
			}
		}
		unset($path);

		// Read files into a string
		$scripts = array();
		foreach ($files as $path) {
			$content = file_get_contents($path);
			$scripts[$path] = trim($content);
		}

		// Save scripts
		$this->setScripts($scripts);

		return $this;
	}



	// Minify (CSS)
	public function minifyCss ($cssString) {
		$cssString = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $cssString);
		$cssString = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '	', '	'), '', $cssString);
		return str_replace(array(' {', '{ ', '; ', ': ', ' :', ' ,', ', ', ';}'), array('{', '{', ';', ':', ':', ',', ',', '}'), $cssString);
	}



	/**
	* Helpers
	*/

	private function timestamp () {
		return date('Y-m-d H:i e');
	}

	private function contentType () {
		return ($this->singleFile() ? $this->targetContentType : 'application/zip');
	}

	private function filename () {
		return $this->name.'.'.($this->singleFile() ? ($this->shouldMinify() ? 'min.'.$this->sourceFormat : $this->sourceFormat) : 'zip');
	}

	public function headers () {
		$headers = array();

		// Content type
		$headers[] = 'Content-type: '.$this->contentType();

		// Download trigger
		if ($this->shouldDownload()) {
			$headers[] = 'Content-Disposition: attachment; filename='.$this->filename();
		}

		// Content length for zip files
		if (!$this->singleFile()) {
			$tempFilePath = $this->tempPath.$this->filename();
			if (is_file($tempFilePath)) {
				$headers[] = 'Content-Length: ' . filesize($tempFilePath);
			}
		}

		return $headers;
	}

}

?>