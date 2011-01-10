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
require_once(t3lib_extMgm::extPath('js_css_optimizer').'classes'.DIRECTORY_SEPARATOR.'hooks'.DIRECTORY_SEPARATOR.'class.tx_js_css_optimizer_hooks_jsCompressHandler.php');
/**
 * test class tx_js_css_optimizer_hooks_jsCompressHandler
 */
class tx_js_css_optimizer_hooks_jsCompressHandler_testcase extends tx_phpunit_testcase {
	/**
	 * @var tx_js_css_optimizer_hooks_jsCompressHandler
	 */
	private $jsCompressHandler;
	/**
	 * set up
	 * @return void
	 */
	protected function setUp(){
		$this->jsCompressHandler = new tx_js_css_optimizer_hooks_jsCompressHandler();
	}
	/**
	 * Test method process
	 * @return void
	 */
	public function test_process(){
		$folder = t3lib_extMgm::siteRelPath('js_css_optimizer').'tests/hooks/fixtures/';
		$jsInline = array(
			'test1'=>array(
				'code'=>file_get_contents(t3lib_extMgm::extPath('js_css_optimizer').'tests/hooks/fixtures/test1.js')
			),
			'test2'=>array(
				'code'=>file_get_contents(t3lib_extMgm::extPath('js_css_optimizer').'tests/hooks/fixtures/test2.js')
			),
		);
		$jsFiles = array(
			$folder.'test1.js'=>array(),
			$folder.'test2.js'=>array(),
		);
		$jsFooterFiles = array(
			$folder.'test1.js'=>array(),
			$folder.'test2.js'=>array(),
		);
		$jsLibs = array(
			'test'=>array('file'=>$folder.'test1.css')
		);
		$args = array('jsInline'=>&$jsInline,'jsFooterInline'=>array(),'jsFiles'=>&$jsFiles,'jsFooterFiles'=>&$jsFooterFiles,'jsLibs'=>&$jsLibs);
		$this->jsCompressHandler->process($args);
	}
	/**
	 * clean up
	 * @return void
	 */
	protected function tearDown(){
		unset($this->jsCompressHandler);
	}
}
