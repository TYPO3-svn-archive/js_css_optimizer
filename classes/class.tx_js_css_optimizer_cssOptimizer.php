<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2009 AOE media GmbH <dev@aoemedia.de>
 *  All rights reserved
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
require_once (t3lib_extMgm::extPath ( 'js_css_optimizer' ) . 'contrib'.DIRECTORY_SEPARATOR.'csstidy-1.3'.DIRECTORY_SEPARATOR.'class.csstidy.php');
/**
 *	css compressor
 */
class tx_js_css_optimizer_cssOptimizer {
	/**
	 * @var csstidy
	 */
	private $csstidy;
	/**
	 * contructor
	 */
	public function __construct() {
		$conf = unserialize ( $GLOBALS ['TYPO3_CONF_VARS'] ['EXT'] ['extConf'] ['js_css_optimizer'] );
		$this->csstidy = new csstidy ( );
		$this->csstidy->set_cfg ( 'remove_bslash', ( boolean ) $conf ['remove_bslash'] );
		$this->csstidy->set_cfg ( 'compress_colors', ( boolean ) $conf ['compress_colors'] );
		$this->csstidy->set_cfg ( 'compress_font-weight', ( boolean ) $conf ['compress_font-weight'] );
		$this->csstidy->set_cfg ( 'lowercase_s', ( boolean ) $conf ['lowercase_s'] );
		$this->csstidy->set_cfg ( 'optimise_shorthands', intval ( $conf ['optimise_shorthands'] ) );
		$this->csstidy->set_cfg ( 'remove_last_;', ( boolean ) $$conf ['remove_last'] );
		$this->csstidy->set_cfg ( 'case_properties', intval( $conf ['case_properties'] ));
		$this->csstidy->set_cfg ( 'sort_properties', ( boolean )$conf ['sort_properties'] );
		$this->csstidy->set_cfg ( 'sort_selectors',( boolean ) $conf ['sort_selectors'] );
		$this->csstidy->set_cfg ( 'merge_selectors',  intval ($conf ['merge_selectors']) );
		$this->csstidy->set_cfg ( 'discard_invalid_properties', ( boolean )$conf ['discard_invalid_properties'] );
		$this->csstidy->set_cfg ( 'css_level', $conf ['css_level'] );
		$this->csstidy->set_cfg ( 'preserve_css', ( boolean )$conf ['preserve_css'] );
		$this->csstidy->set_cfg ( 'timestamp',( boolean ) $conf ['timestamp'] );
	
	}
	/**
	 * @param string $content
	 * @return string
	 */
	public function compress($content) {
		if(true !== $this->csstidy->parse ( $content )){
			throw new Exception('could not parse css');
		}
		$css = $this->csstidy->print->plain();
		return str_replace("\n",'',$css);
	}
}
