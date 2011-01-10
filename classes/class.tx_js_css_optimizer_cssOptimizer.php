<?php
/***************************************************************
 * Copyright notice
 *
 * (c) 2009 AOE media GmbH <dev@aoemedia.de>
 * All rights reserved
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
require_once (t3lib_extMgm::extPath ( 'js_css_optimizer' ) . 'contrib' . DIRECTORY_SEPARATOR . 'csstidy-1.3' . DIRECTORY_SEPARATOR . 'class.csstidy.php');
/**
 * css compressor
 */
class tx_js_css_optimizer_cssOptimizer {
	/**
	 * @param string $content
	 * @return string
	 */
	public function compress($content) {
		$conf = unserialize ( $GLOBALS ['TYPO3_CONF_VARS'] ['EXT'] ['extConf'] ['js_css_optimizer'] );
		$csstidy = new csstidy ();
		$csstidy->set_cfg ( 'remove_bslash', ( boolean ) $conf ['remove_bslash'] );
		$csstidy->set_cfg ( 'compress_colors', ( boolean ) $conf ['compress_colors'] );
		$csstidy->set_cfg ( 'compress_font-weight', ( boolean ) $conf ['compress_font-weight'] );
		$csstidy->set_cfg ( 'lowercase_s', ( boolean ) $conf ['lowercase_s'] );
		$csstidy->set_cfg ( 'optimise_shorthands', intval ( $conf ['optimise_shorthands'] ) );
		$csstidy->set_cfg ( 'remove_last_;', ( boolean ) $$conf ['remove_last'] );
		$csstidy->set_cfg ( 'case_properties', intval ( $conf ['case_properties'] ) );
		$csstidy->set_cfg ( 'sort_properties', ( boolean ) $conf ['sort_properties'] );
		$csstidy->set_cfg ( 'sort_selectors', ( boolean ) $conf ['sort_selectors'] );
		$csstidy->set_cfg ( 'merge_selectors', intval ( $conf ['merge_selectors'] ) );
		$csstidy->set_cfg ( 'discard_invalid_properties', ( boolean ) $conf ['discard_invalid_properties'] );
		$csstidy->set_cfg ( 'css_level', $conf ['css_level'] );
		$csstidy->set_cfg ( 'preserve_css', ( boolean ) $conf ['preserve_css'] );
		$csstidy->set_cfg ( 'timestamp', ( boolean ) $conf ['timestamp'] );
		if (true !== $csstidy->parse ( $content )) {
			throw new Exception ( 'could not parse css' );
		}
		$css = $csstidy->print->plain ();
		return str_replace ( "\n", '', $css );
	}
}
