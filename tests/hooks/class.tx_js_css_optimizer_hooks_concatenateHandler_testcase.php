<?php
/***************************************************************
 * Copyright notice
 *
 * (c) 2009 AOE media GmbH <dev@aoemedia.de>
 * All rights reserved
 *
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
require_once (t3lib_extMgm::extPath ( 'js_css_optimizer' ) . 'classes' . DIRECTORY_SEPARATOR . 'hooks' . DIRECTORY_SEPARATOR . 'class.tx_js_css_optimizer_hooks_concatenateHandler.php');
require_once (t3lib_extMgm::extPath ( 'js_css_optimizer' ) . 'classes' . DIRECTORY_SEPARATOR . 'hooks' . DIRECTORY_SEPARATOR . 'class.tx_js_css_optimizer_hooks_cacheHandler.php');
/**
 * test class tx_js_css_optimizer_hooks_concatenateHandler
 * @package js_css_optimizer
 */
class tx_js_css_optimizer_hooks_concatenateHandler_testcase extends tx_phpunit_testcase {
	/**
	 * @var tx_js_css_optimizer_hooks_concatenateHandler
	 */
	private $concatenateHandler;
	/**
	 * @var array
	 */
	private $conf;
	/**
	 * set up
	 * @return void
	 */
	protected function setUp() {
		$this->concatenateHandler = new tx_js_css_optimizer_hooks_concatenateHandler ();
		$conf = unserialize ( $GLOBALS ['TYPO3_CONF_VARS'] ['EXT'] ['extConf'] ['js_css_optimizer'] );
		$this->conf = $conf;
		$conf ['bundle_js'] = 1;
		$conf ['bundle_css'] = 1;
		$GLOBALS ['TYPO3_CONF_VARS'] ['EXT'] ['extConf'] ['js_css_optimizer'] = serialize ( $conf );
	}
	/**
	 * Test method process
	 * @return void
	 */
	public function test_process() {
		
		$folder = t3lib_extMgm::siteRelPath ( 'js_css_optimizer' ) . 'tests/hooks/fixtures/';
		$jsLibs = array ('extjs' => array ('file' => $folder . 'test1.js' ), 'jquery' => array ('file' => $folder . 'test2.js' ) );
		$jsFiles = array ($folder . 'test1.js' => array (), $folder . 'test2.js' => array () );
		$jsFooterFiles = array ();
		$cssFiles = array ($folder . 'test1.css' => array (), $folder . 'test2.css' => array () );
		$args = array ('jsLibs' => &$jsLibs, 'jsFiles' => &$jsFiles, 'jsFooterFiles' => &$jsFooterFiles, 'cssFiles' => &$cssFiles );
		$this->concatenateHandler->process ( $args );
		$this->assertEquals ( 0, count ( $jsFooterFiles ) );
		$this->assertEquals ( 1, count ( $jsLibs ) );
		$this->assertEquals ( 1, count ( $jsFiles ) );
		$this->assertEquals ( 1, count ( $cssFiles ) );
		foreach ( $jsLibs as $lib ) {
			$jsFile = $lib ['file'];
			$path = PATH_site . $jsFile;
			$this->assertTrue ( file_exists ( $path ), 'file not found: ' . $path );
			$content = file_get_contents ( $path );
			$this->assertContains ( file_get_contents ( t3lib_extMgm::extPath ( 'js_css_optimizer' ) . 'tests/hooks/fixtures/test1.js' ), $content );
			$this->assertContains ( file_get_contents ( t3lib_extMgm::extPath ( 'js_css_optimizer' ) . 'tests/hooks/fixtures/test2.js' ), $content );
		}
		foreach ( array_keys ( $jsFiles ) as $jsFile ) {
			$path = PATH_site . $jsFile;
			$this->assertTrue ( file_exists ( $path ) );
			$content = file_get_contents ( $path );
			$this->assertContains ( file_get_contents ( t3lib_extMgm::extPath ( 'js_css_optimizer' ) . 'tests/hooks/fixtures/test1.js' ), $content );
			$this->assertContains ( file_get_contents ( t3lib_extMgm::extPath ( 'js_css_optimizer' ) . 'tests/hooks/fixtures/test2.js' ), $content );
		}
		foreach ( array_keys ( $cssFiles ) as $cssFile ) {
			$path = PATH_site . $cssFile;
			$this->assertTrue ( file_exists ( $path ) );
			$content = file_get_contents ( $path );
			$this->assertContains ('test1.css' , $content ,$content);
			$this->assertContains ( 'test2.css' , $content ,$content);
		}
	}
	/**
	 * test the Relative Css Paths
	 */
	public function test_fixRelativeCssPaths() {
		$folder = t3lib_extMgm::siteRelPath ( 'js_css_optimizer' ) . 'tests/hooks/fixtures/';
		$jsLibs = array ();
		$jsFiles = array ();
		$jsFooterFiles = array ();
		$cssFiles = array ($folder . 'testpath1.css' => array (), $folder . 'testpath2.css' => array (), $folder . 'testpath3.css' => array (), $folder . 'testpath4.css' => array (), $folder . 'testpath5.css' => array (), $folder . 'testpath6.css' => array (), $folder . 'testpath7.css' => array () );
		$args = array ('jsLibs' => &$jsLibs, 'jsFiles' => &$jsFiles, 'jsFooterFiles' => &$jsFooterFiles, 'cssFiles' => &$cssFiles );
		$this->concatenateHandler->process ( $args );
		$this->assertEquals ( 1, count ( $cssFiles ) );
		foreach ( array_keys ( $cssFiles ) as $cssFile ) {
			$path = PATH_site . $cssFile;
			$this->assertTrue ( file_exists ( $path ) );
			$content = file_get_contents ( $path );
			$this->assertContains ( '/fixtures/../images/test1.gif', $content );
			$this->assertContains ( '/fixtures/images/test2.gif', $content );
			$this->assertContains ( '/fixtures/test3.gif', $content );
			$this->assertContains ( '/fixtures/test5.gif', $content );
			$this->assertContains ( '/fixtures/../../images/test4.gif', $content );
			$this->assertContains ( "'/typo3conf/ext/js_css_optimizer/tests/hooks/fixtures/../img/indicator.gif'", $content, $content );
			$this->assertContains ( "/typo3conf/ext/js_css_optimizer/tests/hooks/fixtures/../img/indicator7.gif", $content, $content );
		}
	}
	/**
	 * test the EXT Path
	 */
	public function test_EXT_paths() {
		$folder = 'EXT:js_css_optimizer/tests/hooks/fixtures/';
		$jsLibs = array ();
		$jsFiles = array ();
		$jsFooterFiles = array ();
		$cssFiles = array ($folder . 'testpath1.css' => array (), $folder . 'testpath2.css' => array (), $folder . 'testpath3.css' => array (), $folder . 'testpath4.css' => array () );
		$args = array ('jsLibs' => &$jsLibs, 'jsFiles' => &$jsFiles, 'jsFooterFiles' => &$jsFooterFiles, 'cssFiles' => &$cssFiles );
		$this->concatenateHandler->process ( $args );
		$this->assertEquals ( 1, count ( $cssFiles ) );
		foreach ( array_keys ( $cssFiles ) as $cssFile ) {
			$path = PATH_site . $cssFile;
			$this->assertTrue ( file_exists ( $path ) );
			$content = file_get_contents ( $path );
			$this->assertContains ( '/fixtures/../images/test1.gif', $content );
			$this->assertContains ( '/fixtures/images/test2.gif', $content );
			$this->assertContains ( '/fixtures/test3.gif', $content );
			$this->assertContains ( '/fixtures/../../images/test4.gif', $content );
		}
	}
	/**
	 * test the removes of mutiples charsets
	 */
	public function test_charsetRemoves() {
		$folder = 'EXT:js_css_optimizer/tests/hooks/fixtures/';
		$jsLibs = array ();
		$jsFiles = array ();
		$jsFooterFiles = array ();
		$cssFiles = array ($folder . 'test_charset1.css' => array (), $folder . 'test_charset2.css' => array (), $folder . 'test_charset3.css' => array () );
		$args = array ('jsLibs' => &$jsLibs, 'jsFiles' => &$jsFiles, 'jsFooterFiles' => &$jsFooterFiles, 'cssFiles' => &$cssFiles );
		$this->concatenateHandler->process ( $args );
		$this->assertEquals ( 1, count ( $cssFiles ) );
		foreach ( array_keys ( $cssFiles ) as $cssFile ) {
			$path = PATH_site . $cssFile;
			$this->assertTrue ( file_exists ( $path ) );
			$content = file_get_contents ( $path );
			$this->assertNotContains ( '@charset', $content );
		}
		$cssFiles = array ($folder . 'test_charset1.css' => array () );
		$args = array ('jsLibs' => &$jsLibs, 'jsFiles' => &$jsFiles, 'jsFooterFiles' => &$jsFooterFiles, 'cssFiles' => &$cssFiles );
		$this->concatenateHandler->process ( $args );
		$this->assertEquals ( 1, count ( $cssFiles ) );
		foreach ( array_keys ( $cssFiles ) as $cssFile ) {
			$path = PATH_site . $cssFile;
			$this->assertTrue ( file_exists ( $path ) );
			$content = file_get_contents ( $path );
			$this->assertContains ( '@charset', $content ,$path);
		}
	}
	/**
	 * test the charset comming fom config
	 */
	public function test_configCharset() {
		$conf = unserialize ( $GLOBALS ['TYPO3_CONF_VARS'] ['EXT'] ['extConf'] ['js_css_optimizer'] );
		$this->conf = $conf;
		$conf ['charsetCSS'] = 'UTF-8';
		$GLOBALS ['TYPO3_CONF_VARS'] ['EXT'] ['extConf'] ['js_css_optimizer'] = serialize ( $conf );
		$folder = 'EXT:js_css_optimizer/tests/hooks/fixtures/';
		$jsLibs = array ();
		$jsFiles = array ();
		$jsFooterFiles = array ();
		$cssFiles = array ($folder . 'test_charset1.css' => array (), $folder . 'test_charset2.css' => array (), $folder . 'test_charset3.css' => array () );
		$args = array ('jsLibs' => &$jsLibs, 'jsFiles' => &$jsFiles, 'jsFooterFiles' => &$jsFooterFiles, 'cssFiles' => &$cssFiles );
		$this->concatenateHandler->process ( $args );
		$this->assertEquals ( 1, count ( $cssFiles ) );
		foreach ( array_keys ( $cssFiles ) as $cssFile ) {
			$path = PATH_site . $cssFile;
			$this->assertTrue ( file_exists ( $path ) );
			$content = file_get_contents ( $path );
			$this->assertContains ( '@charset', $content );
		}
		$cssFiles = array ($folder . 'test_charset4.css' => array () );
		$args = array ('jsLibs' => &$jsLibs, 'jsFiles' => &$jsFiles, 'jsFooterFiles' => &$jsFooterFiles, 'cssFiles' => &$cssFiles );
		$this->concatenateHandler->process ( $args );
		$this->assertEquals ( 1, count ( $cssFiles ) );
		foreach ( array_keys ( $cssFiles ) as $cssFile ) {
			$path = PATH_site . $cssFile;
			$this->assertTrue ( file_exists ( $path ) );
			$content = file_get_contents ( $path );
			$this->assertContains ( '@charset', $content );
		}
	
	}
	/**
	 * clean up
	 * @return void
	 */
	protected function tearDown() {
		$GLOBALS ['TYPO3_CONF_VARS'] ['EXT'] ['extConf'] ['js_css_optimizer'] = serialize ( $this->conf );
		unset ( $this->concatenateHandler );
		$cachehandler = new tx_js_css_optimizer_hooks_cacheHandler ();
		$cachehandler->deleteCache ( array ('cacheCmd' => 'all' ) );
	
	}
}