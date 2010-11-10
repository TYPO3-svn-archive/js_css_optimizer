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
require_once(t3lib_extMgm::extPath('js_css_optimizer').'classes'.DIRECTORY_SEPARATOR.'class.tx_js_css_optimizer_jsOptimizer.php');
/**
 * test class tx_js_css_optimizer_jsOptimizer
 */
class tx_js_css_optimizer_jsOptimizer_testcase extends tx_phpunit_testcase {
	/**
	 * @var tx_js_css_optimizer_jsOptimizer
	 */
	private $jsOptimizer;
	/**
	 * set up
	 * @return void
	 */
	protected function setUp(){
		$this->jsOptimizer = tx_js_css_optimizer_jsOptimizer::getInstance();
	}
	/**
	 * Test method compress
	 * @return void
	 */
	public function test_compress(){
		$js = file_get_contents(t3lib_extMgm::extPath('js_css_optimizer').'tests/fixtures/test.js');
		$output = $this->jsOptimizer->compress($js);
		$this->assertNotNull($output);
		$this->assertContains('alert',$output);
		$this->assertNotContains('// comment/',$output);
	}
	/**
	 * clean up
	 * @return void
	 */
	protected function tearDown(){
		unset($this->jsOptimizer);
	}
}
