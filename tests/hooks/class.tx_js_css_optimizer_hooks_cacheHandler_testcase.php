<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 AOE media GmbH <dev@aoemedia.de>
*  All rights reserved
*
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
require_once(t3lib_extMgm::extPath('js_css_optimizer').'classes'.DIRECTORY_SEPARATOR.'hooks'.DIRECTORY_SEPARATOR.'class.tx_js_css_optimizer_hooks_cacheHandler.php');
/**
 * test class tx_js_css_optimizer_hooks_cacheHandler
 */
class tx_js_css_optimizer_hooks_cacheHandler_testcase extends tx_phpunit_testcase {
	/**
	 * @var tx_js_css_optimizer_hooks_cacheHandler
	 */
	private $cacheHandler;
	/**
	 * set up
	 * @return void
	 */
	protected function setUp(){
		$this->cacheHandler = new tx_js_css_optimizer_hooks_cacheHandler();
	}
	/**
	 * Test method deleteCache
	 * @return void
	 */
	public function test_deleteCache(){
		$file = PATH_site . 'typo3temp'.DIRECTORY_SEPARATOR.'js_css_optimizer'.DIRECTORY_SEPARATOR.'js_css_optimizersdsdsdsd.js';
		file_put_contents($file,'');
		$this->cacheHandler->deleteCache(array('cacheCmd'=>'all'));
		$this->assertFalse(file_exists($file));
	}
	/**
	 * clean up
	 * @return void
	 */
	protected function tearDown(){
		unset($this->cacheHandler);
	}
}
