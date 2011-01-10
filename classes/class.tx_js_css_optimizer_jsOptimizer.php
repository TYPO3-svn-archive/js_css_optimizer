<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2009 AOE media GmbH <dev@aoemedia.de>
 *  All rights reserved
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
require_once PATH_site.TYPO3_mainDir.'contrib'.DIRECTORY_SEPARATOR .'jsmin'.DIRECTORY_SEPARATOR.'jsmin.php';
/**
 *	js compressor
 */
class tx_js_css_optimizer_jsOptimizer {
	/**
	 * 
	 * @var tx_js_css_optimizer_jsOptimizer
	 */
	private static $instance = null;
	/**
	 * contructor
	 */
	private function __construct() {}
	/**
	 * @return tx_js_css_optimizer_jsOptimizer
	 */
	static public function getInstance() {
		if (null === self::$instance) {
			self::$instance = new self ( );
		}
		return self::$instance;
	}
	/**
	 * @param string $content
	 * @return string
	 */
	public function compress($content) {
		$errorMessage = null;
		return JSMin::minify ($content,$errorMessage);
	}
}
