<?php
/***************************************************************
 * Copyright notice
 *
 * (c) 2009 AOE media GmbH <dev@aoemedia.de>
 * All rights reserved
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
require_once (dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . 'class.tx_js_css_optimizer_hooks.php');
/**
 * Hook to bundle the js and css files
 * @package js_css_optimizer
 */
class tx_js_css_optimizer_hooks_concatenateHandler extends tx_js_css_optimizer_hooks {
	/**
	 * @param array $args
	 * @return void
	 */
	public function process(array $args) {
		$conf = unserialize ( $GLOBALS ['TYPO3_CONF_VARS'] ['EXT'] ['extConf'] ['js_css_optimizer'] );
		if ($conf ['bundle_js']) {
			if (count ( $args ['jsLibs'] ) > 0) {
				$this->createNewJsLibBundle ( $args ['jsLibs'], sha1 ( var_export ( $args ['jsLibs'], TRUE ) ) . '_bundled_jsLibs.js' );
			}
			if (count ( $args ['jsFiles'] ) > 0) {
				$this->createNewJsBundle ( $args ['jsFiles'], sha1 ( var_export ( $args ['jsFiles'], TRUE ) ) . '_bundled_jsFiles.js' );
			}
			if (count ( $args ['jsFooterFiles'] ) > 0) {
				$this->createNewJsBundle ( $args ['jsFooterFiles'], sha1 ( var_export ( $args ['jsFooterFiles'], TRUE ) ) . '_bundled_jsFooterFiles.js' );
			}
		}
		if ($conf ['bundle_css']) {
			if (count ( $args ['cssFiles'] ) > 0) {
				$charsetCSS = null;
				if (isset ( $conf ['charsetCSS'] ) && ! empty ( $conf ['charsetCSS'] )) {
					$charsetCSS = $conf ['charsetCSS'];
				}
				foreach ( $this->splitCssFilesMediaTypes ( $args ['cssFiles'] ) as $mediaType => $files ) {
					$this->createNewCssBundle ( $files, '_' . $mediaType . '_bundled_cssFiles.css', $charsetCSS, $args ['cssFiles'] );
				}
			}
		}
	}
	
	/**
	 * @param	string	$file
	 * @param	string	$filecontent
	 * @return	string
	 */
	protected function getFileName($file, $filecontent) {
		if ($this->useHashedFilename ()) {
			$filename = sha1 ( $filecontent. $file ). substr($file, strrpos($file, '.'));
		} else {
			$filename = $file;
		}
		return $filename;
	}
	
	/**
	 * @param array &$files
	 * @param string $filename
	 * @param string $charsetCSS
	 * @param string &$cssfiles
	 * @return void
	 */
	private function createNewCssBundle(array $files, $filename, $charsetCSS = null, array &$cssfiles) {
		$content = '';
		foreach ( $files as $file => $meta ) {
			if (! $this->isExternalResource ( $file )) {
				$filecontent = $this->getFileContent ( $file );
				$content .= $this->fixRelativeCssPaths ( dirname ( $file ), $filecontent );
			}
		}
		$matches = array ();
		if (preg_match_all ( '/@charset.*?;/i', $content, $matches )) {
			if (count ( $matches [0] ) > 1 || FALSE === is_null ( $charsetCSS )) {
				foreach ( $matches [0] as $match ) {
					$content = str_replace ( $match, '', $content );
				}
			}
		}
		if (! preg_match ( '/@charset.*;/i', $content ) && FALSE === is_null ( $charsetCSS )) {
			$content = '@charset "' . $charsetCSS . '";' . PHP_EOL . $content;
		}
		
		if (trim ( $content ) != '') {
			$newFileName = $this->getFileName ( $filename, $content );
			if ($this->hasCacheFile ( $newFileName ) === FALSE) {
				$this->createCacheFile ( $newFileName, $content );
			}
			$newFile = $this->getCacheFilePath ( $newFileName );
			$cssfiles [$newFile] = $meta;
		}
	}
	/**
	 * @param array &$files
	 * @param string $filename
	 * @return void
	 */
	private function createNewJsBundle(array &$files, $filename) {
		$content = '';
		$sortedFiles = array ();
		$bundleKey = uniqid ();
		foreach ( $files as $file => $meta ) {
			if (! $this->isExternalResource ( $file ) && empty ( $meta ['allWrap'] )) {
				$filecontent = $this->getFileContent ( $file );
				$content .= trim ( $filecontent );
				if (! empty ( $content )) {
					$sortedFiles [$bundleKey] = $meta;
				}
			}else{
				$sortedFiles[$file] = $meta;
			}
		}
		if (! empty ( $content )) {
			$newFiles = array();
			foreach ( $sortedFiles as $file => $meta ) {
				if ($file === $bundleKey) {
					$newFileName = $this->getFileName ( $filename, $content );
					if ($this->hasCacheFile ( $newFileName ) === FALSE) {
						$this->createCacheFile ( $newFileName, $content );
					}
					$newFile = $this->getCacheFilePath ( $newFileName );
					$newFiles [$newFile] = $meta;
				} else {
					$newFiles [$file] = $meta;
				}
			}
			
		}else{
			$newFiles = $sortedFiles;
		}
		$files = $newFiles;
	}
	/**
	 * @param array &$files
	 * @param string $filename
	 * @return void
	 */
	private function createNewJsLibBundle(array &$files, $filename) {
		$topContent = '';
		$content = '';
		$compressBundle = FALSE;
		$jsFilesOnBottom = array ();
		$sortedFiles = array();
		foreach ( $files as $name => $meta ) {
			if (! $this->isExternalResource ( $meta ['file'] )) {
				if (isset ( $meta ['compress'] ) && $meta ['compress']) {
					$compressBundle = TRUE;
				}
				if (empty ( $meta ['allWrap'] )) {
					$filecontent = $this->getFileContent ( $meta ['file'] );
					if ($meta ['forceOnTop']) {
						$topContent .= $filecontent;
					} else {
						$content .= $filecontent;
					}
					unset ( $files [$name] );
				} else {
					if (! $meta ['forceOnTop']) {
						$jsFilesOnBottom [$name] = $files [$name];
						unset ( $files [$name] );
					}
				}
			}
		}
		$content = $topContent . $content;
		if (trim ( $content ) != '') {
			$newFileName = $this->getFileName ( $filename, $content );
			if ($this->hasCacheFile ( $newFileName ) === FALSE) {
				$this->createCacheFile ( $newFileName, $content );
			}
			$newFile = $this->getCacheFilePath ( $newFileName );
			$files ['bundledLib'] = array ('file' => $newFile, 'type' => 'text/javascript', 'section' => t3lib_PageRenderer::PART_HEADER, 'compress' => $compressBundle, 'forceOnTop' => false, 'allWrap' => '' );
			foreach ( $jsFilesOnBottom as $name => $meta ) {
				$files [$name] = $meta;
			}
		}
	}
	
	/**
	 * @param array &$cssFiles
	 * @return array
	 */
	private function splitCssFilesMediaTypes(array &$cssFiles) {
		$cssFilesSplitted = array ();
		foreach ( $cssFiles as $file => $meta ) {
			if (! $this->isExternalResource ( $file )) {
				$index = md5 ( $meta ['media'] . $meta ['allWrap'] . $meta ['rel'] );
				if (! isset ( $cssFilesSplitted [$index] )) {
					$cssFilesSplitted [$index] = array ();
				}
				$cssFilesSplitted [$index] [$file] = $meta;
				unset ( $cssFiles [$file] );
			}
		}
		return $cssFilesSplitted;
	}
}