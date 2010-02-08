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
/**
 * Hook to clear the js and css cache
 */
class tx_js_css_optimizer_hooks_cacheHandler extends tx_js_css_optimizer_hooks {
	/**
	 * delete TypoScript-Cache if cacheCmd is 'all' or 'pages'
	 *
	 * @param array $params
	 * @param t3lib_tcemain $ref
	 */
	public function deleteCache($params) {
		if(in_array($params['cacheCmd'],array('all','pages'))) {
			foreach (glob($this->getCacheFolder().$this->getPrefix().'*') as $file){
				unlink($file);
			}
		}
	}
}
