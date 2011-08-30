<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2009 AOE media GmbH <dev@aoemedia.de>
 *  All rights reserved
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'class.tx_js_css_optimizer_hooks.php');
require_once(t3lib_extMgm::extPath('js_css_optimizer').'classes'.DIRECTORY_SEPARATOR.'class.tx_js_css_optimizer_cssOptimizer.php');

/**
 * Hook to compress the css
 */
class tx_js_css_optimizer_hooks_cssCompressHandler  extends tx_js_css_optimizer_hooks{
	/**
	 * @param array $args
	 * @return void
	 */
	public function process(array $args) {
		$cssOptimizer = new tx_js_css_optimizer_cssOptimizer();
		foreach ($args['cssInline'] as $name=>$meta){
			$args['cssInline'][$name]['code'] = $cssOptimizer->compress($meta['code']);
		}
		$cssFiles = array();
		foreach ($args['cssFiles'] as $file => $meta) {
			if ($meta['compress'] && !$this->isExternalResource($file)) {
				$filecontent = $this->getFileContent($file);
				$filecontent = $this->fixRelativeCssPaths(dirname($file), $filecontent);
				$fileName = $this->getFileName($file, $filecontent);
				if($this->hasCacheFile($fileName) === FALSE) {
					$this->createCacheFile( $fileName, $cssOptimizer->compress($filecontent) );
				}
				$newFile = $this->getCacheFilePath( $fileName );
				$meta['file'] = $newFile;
				$cssFiles[$newFile] = $meta;
				
			} else {
				$cssFiles[$file] = $meta;
			}
		}
		$args['cssFiles'] = $cssFiles;
	}
}
