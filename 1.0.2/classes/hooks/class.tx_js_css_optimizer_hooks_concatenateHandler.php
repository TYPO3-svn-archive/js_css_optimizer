<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2009 AOE media GmbH <dev@aoemedia.de>
 *  All rights reserved
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
require_once (dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . 'class.tx_js_css_optimizer_hooks.php');
/**
 * Hook to bundle the js and css files
 */
class tx_js_css_optimizer_hooks_concatenateHandler extends tx_js_css_optimizer_hooks {
	/**
	 * @param array $args
	 * @return void
	 */
	public function process(array $args) {
		$conf = unserialize ( $GLOBALS ['TYPO3_CONF_VARS'] ['EXT'] ['extConf'] ['js_css_optimizer'] );
		if($conf ['bundle_js'] ){
			if (count ( $args ['jsLibs'] ) > 0) {
				$this->createNewJsLibBundle ( $args ['jsLibs'], $this->getFileName($args ['jsLibs'],'_bundled_jsLibs.js') );
			}
			if (count ( $args ['jsFiles'] ) > 0) {
				$this->createNewJsBundle ( $args ['jsFiles'], $this->getFileName($args ['jsFiles'],'_bundled_jsFiles.js') );
			}
			if (count ( $args ['jsFooterFiles'] ) > 0) {
				$this->createNewJsBundle ( $args ['jsFooterFiles'], $this->getFileName($args ['jsFooterFiles'],'_bundled_jsFooterFiles.js') );
			}
		}
		if($conf ['bundle_css']){
			if (count ( $args ['cssFiles'] ) > 0) {
				$this->createNewCssBundle ( $args ['cssFiles'], $this->getFileName($args ['cssFiles'],'_bundled_cssFiles.css') );
			}
		}
	}
	/**
	 * @param array $files
	 * @param string $filename
	 * @return string
	 */
	private function getFileName(array &$files, $filename){
		return md5 ( serialize ( $files ) ) . $filename;
	}
	/**
	 * @param array $files
	 * @param string $filename
	 * @return void
	 */
	private function createNewJsLibBundle(array &$files, $filename) {
		$topContent = '';
		$content = '';
		foreach ( $files as $name => $meta ) {
			$filecontent = $this->getFileContent ( $meta ['file'] );
			if($meta['forceOnTop']){
				$topContent .= $filecontent;
			}else{
				$content .= $filecontent;
			}
			unset ( $files [$name] );
			
		}
		$newFile = $this->createCacheFile ( $filename, $topContent.$content );
		$files ['bundledLib'] = array ('file' => $newFile, 'type' => 'text/javascript', 'section' => t3lib_PageRenderer::PART_HEADER, 'compressed' => false, 'forceOnTop' => false, 'allWrap' => '' );
	}
	/**
	 * 
	 * @param array $files
	 * @param string $filename
	 * @return void
	 */
	private function createNewCssBundle(array &$files, $filename) {
		$content = '';
		foreach ( $files as $file => $meta ) {
			$filecontent = $this->getFileContent ( $file );
			$content .= $this->fixRelativeCssPaths(dirname($file),$filecontent);
			unset ( $files [$file] );
		}
		$newFile = $this->createCacheFile ( $filename, $content );
		$files [$newFile] = $meta;
	}
	/**
	 * 
	 * @param array $files
	 * @param string $filename
	 * @return void
	 */
	private function createNewJsBundle(array &$files, $filename) {
		$content = '';
		foreach ( $files as $file => $meta ) {
			$filecontent = $this->getFileContent ( $file );
			$content .= $filecontent;
			unset ( $files [$file] );
		}
		$newFile = $this->createCacheFile ( $filename, $content );
		$files [$newFile] = $meta;
	}
}
