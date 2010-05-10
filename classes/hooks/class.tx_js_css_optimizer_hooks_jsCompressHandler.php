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
require_once(t3lib_extMgm::extPath('js_css_optimizer').'classes'.DIRECTORY_SEPARATOR.'class.tx_js_css_optimizer_jsOptimizer.php');
/**
 * Hook to compress the javascript
 */
class tx_js_css_optimizer_hooks_jsCompressHandler extends tx_js_css_optimizer_hooks {
	/**
	 * @param array $args
	 * @param array $jsFooterInline
	 * @return void
	 */
	public function process(array $args) {
		$jsOptimizer = tx_js_css_optimizer_jsOptimizer::getInstance();
		
		foreach ($args['jsInline'] as $name=>$meta){
			$args['jsInline'][$name]['code'] = $jsOptimizer->compress($meta['code']);
		}
		foreach ($args['jsFooterInline'] as $name=>$meta){
			$args['jsFooterInline'][$name]['code'] = $jsOptimizer->compress($meta['code']);
		}
		$jsFooterFiles = array();
		foreach ($args['jsFooterFiles'] as $file => $meta ) {
			if($meta['compress']){
				$newFile = $this->createCacheFile ( '_compressed_'.sha1($file).'_'.basename($file), $jsOptimizer->compress($this->getFileContent ( $file )) );
				$jsFooterFiles [$newFile]  = $meta;
				unset ( $args['jsFooterFiles'] [$file] );
			}
		}
		foreach ($jsFooterFiles as $file => $meta){
			$args['jsFooterFiles'][$file] = $meta;
		}
		$jsFiles = array();
		foreach ($args['jsFiles'] as $file => $meta ) {
			if($meta['compress'] && ! isset($args['jsFooterFiles'][$file])){
				$newFile = $this->createCacheFile ( '_compressed_'.sha1($file).'_'.basename($file), $jsOptimizer->compress($this->getFileContent ( $file )) );
				$jsFiles [$newFile]  = $meta;
				unset ( $args['jsFiles'] [$file] );
			}
		}
		foreach ($jsFiles as $file => $meta){
			$args['jsFiles'][$file] = $meta;
		}
		foreach ($args['jsLibs'] as $libName => $meta ) {
			if($meta['compress']){
				$file = $meta['file'];
				$newFile = $this->createCacheFile ( '_compressed_'.sha1($file).'_'.basename($file), $jsOptimizer->compress($this->getFileContent ($file )) );
				$args['jsLibs'] [$libName]['file']  = $newFile;
			}
		}
		
	}
}
