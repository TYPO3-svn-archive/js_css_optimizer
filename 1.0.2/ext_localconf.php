<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
global $TYPO3_CONF_VARS, $_EXTKEY;
$GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['cssCompressHandler'] = t3lib_extMgm::extPath($_EXTKEY).'classes/hooks/class.tx_js_css_optimizer_hooks_cssCompressHandler.php:&tx_js_css_optimizer_hooks_cssCompressHandler->process';
$GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['jsCompressHandler'] = t3lib_extMgm::extPath($_EXTKEY).'classes/hooks/class.tx_js_css_optimizer_hooks_jsCompressHandler.php:&tx_js_css_optimizer_hooks_jsCompressHandler->process';
$GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['concatenateHandler'] = t3lib_extMgm::extPath($_EXTKEY).'classes/hooks/class.tx_js_css_optimizer_hooks_concatenateHandler.php:&tx_js_css_optimizer_hooks_concatenateHandler->process';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc'][$_EXTKEY] = t3lib_extMgm::extPath($_EXTKEY).'classes/hooks/class.tx_js_css_optimizer_hooks_cacheHandler.php:&tx_js_css_optimizer_hooks_cacheHandler->deleteCache';