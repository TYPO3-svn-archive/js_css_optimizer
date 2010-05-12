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
require_once(t3lib_extMgm::extPath('js_css_optimizer').'classes'.DIRECTORY_SEPARATOR.'class.tx_js_css_optimizer_cssOptimizer.php');
/**
 * test class tx_js_css_optimizer_cssOptimizer
 */
class tx_js_css_optimizer_cssOptimizer_testcase extends tx_phpunit_testcase {
	/**
	 * @var tx_js_css_optimizer_cssOptimizer
	 */
	private $cssOptimizer;
	/**
	 * set up
	 * @return void
	 */
	protected function setUp(){
		$this->cssOptimizer = tx_js_css_optimizer_cssOptimizer::getInstance();
	}
	/**
	 * Test method compressCss
	 * @return void
	 */
	public function test_compress(){
		$css = file_get_contents(t3lib_extMgm::extPath('js_css_optimizer').'tests/fixtures/test.css');
		$output = $this->cssOptimizer->compress($css);
		$this->assertNotNull($output);
		$this->assertContains('.selector',$output);
		$this->assertNotContains('/* comment */',$output);
		$this->assertNotContains("\n",$output);
	}
	/**
	 * clean up
	 * @return void
	 */
	protected function tearDown(){
		unset($this->cssOptimizer);
	}
}
