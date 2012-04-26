<?php

########################################################################
# Extension Manager/Repository config file for ext "js_css_optimizer".
#
# Auto generated 26-04-2012 11:55
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Javascript and Css Optimizer',
	'description' => 'Implements Hooks for the PageRenderer to Compress Javascript and CSS and bundle these files to one single file.',
	'category' => 'fe',
	'author' => 'Axel Jung',
	'author_email' => 'axel.jung@aoemedia.de',
	'shy' => '',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => 'typo3temp/js_css_optimizer',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => 'AOE Media',
	'version' => '1.1.15',
	'constraints' => array(
		'depends' => array(
			'php' => '5.1.0-0.0.0',
			'typo3' => '4.3.0-4.5.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:53:{s:9:"ChangeLog";s:4:"09c6";s:10:"README.txt";s:4:"7cdc";s:21:"ext_conf_template.txt";s:4:"d41d";s:12:"ext_icon.gif";s:4:"71d2";s:17:"ext_localconf.php";s:4:"9f06";s:50:"classes/class.tx_js_css_optimizer_cssOptimizer.php";s:4:"6717";s:49:"classes/class.tx_js_css_optimizer_jsOptimizer.php";s:4:"e81a";s:49:"classes/hooks/class.tx_js_css_optimizer_hooks.php";s:4:"3f91";s:62:"classes/hooks/class.tx_js_css_optimizer_hooks_cacheHandler.php";s:4:"cb1c";s:68:"classes/hooks/class.tx_js_css_optimizer_hooks_concatenateHandler.php";s:4:"6094";s:68:"classes/hooks/class.tx_js_css_optimizer_hooks_cssCompressHandler.php";s:4:"74b1";s:67:"classes/hooks/class.tx_js_css_optimizer_hooks_jsCompressHandler.php";s:4:"7692";s:27:"contrib/csstidy-1.3/COPYING";s:4:"eb72";s:26:"contrib/csstidy-1.3/README";s:4:"3a3e";s:37:"contrib/csstidy-1.3/class.csstidy.php";s:4:"d421";s:46:"contrib/csstidy-1.3/class.csstidy_optimise.php";s:4:"5013";s:43:"contrib/csstidy-1.3/class.csstidy_print.php";s:4:"e029";s:32:"contrib/csstidy-1.3/cssparse.css";s:4:"2357";s:32:"contrib/csstidy-1.3/data.inc.php";s:4:"5164";s:32:"contrib/csstidy-1.3/lang.inc.php";s:4:"0ac3";s:32:"contrib/csstidy-1.3/template.tpl";s:4:"d6f6";s:33:"contrib/csstidy-1.3/template1.tpl";s:4:"a36d";s:33:"contrib/csstidy-1.3/template2.tpl";s:4:"5904";s:33:"contrib/csstidy-1.3/template3.tpl";s:4:"d8b5";s:14:"doc/manual.sxw";s:4:"df22";s:19:"doc/wizard_form.dat";s:4:"1339";s:20:"doc/wizard_form.html";s:4:"2c1a";s:57:"tests/class.tx_js_css_optimizer_cssOptimizer_testcase.php";s:4:"567e";s:56:"tests/class.tx_js_css_optimizer_jsOptimizer_testcase.php";s:4:"57d9";s:17:"tests/phpunit.xml";s:4:"a8f8";s:23:"tests/fixtures/test.css";s:4:"3580";s:22:"tests/fixtures/test.js";s:4:"3de9";s:69:"tests/hooks/class.tx_js_css_optimizer_hooks_cacheHandler_testcase.php";s:4:"856a";s:75:"tests/hooks/class.tx_js_css_optimizer_hooks_concatenateHandler_testcase.php";s:4:"836f";s:75:"tests/hooks/class.tx_js_css_optimizer_hooks_cssCompressHandler_testcase.php";s:4:"907b";s:74:"tests/hooks/class.tx_js_css_optimizer_hooks_jsCompressHandler_testcase.php";s:4:"12b7";s:30:"tests/hooks/fixtures/test1.css";s:4:"af35";s:29:"tests/hooks/fixtures/test1.js";s:4:"a3d3";s:30:"tests/hooks/fixtures/test2.css";s:4:"23f4";s:29:"tests/hooks/fixtures/test2.js";s:4:"a3d3";s:38:"tests/hooks/fixtures/test_charset1.css";s:4:"f8a7";s:38:"tests/hooks/fixtures/test_charset2.css";s:4:"b3bb";s:38:"tests/hooks/fixtures/test_charset3.css";s:4:"b3bb";s:38:"tests/hooks/fixtures/test_charset4.css";s:4:"189a";s:34:"tests/hooks/fixtures/testpath1.css";s:4:"35e5";s:34:"tests/hooks/fixtures/testpath2.css";s:4:"f954";s:34:"tests/hooks/fixtures/testpath3.css";s:4:"3bcf";s:34:"tests/hooks/fixtures/testpath4.css";s:4:"0880";s:34:"tests/hooks/fixtures/testpath5.css";s:4:"651c";s:34:"tests/hooks/fixtures/testpath6.css";s:4:"3a21";s:34:"tests/hooks/fixtures/testpath7.css";s:4:"780a";s:34:"tests/hooks/fixtures/testpath8.css";s:4:"1f2e";s:34:"tests/hooks/fixtures/testpath9.css";s:4:"8529";}',
	'suggests' => array(
	),
);

?>