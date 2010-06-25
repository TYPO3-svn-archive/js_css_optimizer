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
require_once(t3lib_extMgm::extPath('js_css_optimizer').'classes'.DIRECTORY_SEPARATOR.'hooks'.DIRECTORY_SEPARATOR.'class.tx_js_css_optimizer_hooks_cssCompressHandler.php');
/**
 * test class tx_js_css_optimizer_hooks_cssCompressHandler
 */
class tx_js_css_optimizer_hooks_cssCompressHandler_testcase extends tx_phpunit_testcase {
	/**
	 * @var tx_js_css_optimizer_hooks_cssCompressHandler
	 */
	private $cssCompressHandler;
	/**
	 * set up
	 * @return void
	 */
	protected function setUp(){
		$this->cssCompressHandler = new tx_js_css_optimizer_hooks_cssCompressHandler();
	}
	/**
	 * Test method process
	 * @return void
	 */
	public function test_process(){
		$folder = t3lib_extMgm::siteRelPath('js_css_optimizer').'tests/hooks/fixtures/';
		$cssInline = array(
			'test1'=>array(
				'code'=>file_get_contents(t3lib_extMgm::extPath('js_css_optimizer').'tests/hooks/fixtures/test1.css')
			),
			'test2'=>array(
				'code'=>file_get_contents(t3lib_extMgm::extPath('js_css_optimizer').'tests/hooks/fixtures/test2.css')
			),
		);
		$cssFiles = array(
			$folder.'test1.css'=>array('compress'=>true),
			$folder.'test2.css'=>array('compress'=>true),
		);
		$this->cssCompressHandler->process(array('cssInline'=>&$cssInline,'cssFiles'=>&$cssFiles));
		foreach($cssFiles as $file =>$meta){
			$this->assertFileExists(PATH_site.'/'.$file);
		}
	}
	
	/**
	 * clean up
	 * @return void
	 */
	protected function tearDown(){
		unset($this->cssCompressHandler);
	}
}
