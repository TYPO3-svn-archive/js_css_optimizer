<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "js_css_optimizer".
 *
 * Auto generated 25-03-2013 16:48
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

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
	'version' => '1.2.9',
	'constraints' => array(
		'depends' => array(
			'php' => '5.1.0-0.0.0',
			'typo3' => '4.3.0-4.7.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:58:{s:9:"ChangeLog";s:4:"09c6";s:21:"ext_conf_template.txt";s:4:"8a36";s:12:"ext_icon.gif";s:4:"71d2";s:17:"ext_localconf.php";s:4:"9f06";s:10:"README.txt";s:4:"7cdc";s:50:"classes/class.tx_js_css_optimizer_cssOptimizer.php";s:4:"19ad";s:49:"classes/class.tx_js_css_optimizer_jsOptimizer.php";s:4:"cc94";s:49:"classes/hooks/class.tx_js_css_optimizer_hooks.php";s:4:"80d7";s:62:"classes/hooks/class.tx_js_css_optimizer_hooks_cacheHandler.php";s:4:"cb1c";s:68:"classes/hooks/class.tx_js_css_optimizer_hooks_concatenateHandler.php";s:4:"4cc8";s:68:"classes/hooks/class.tx_js_css_optimizer_hooks_cssCompressHandler.php";s:4:"74b1";s:67:"classes/hooks/class.tx_js_css_optimizer_hooks_jsCompressHandler.php";s:4:"7fe1";s:48:"contrib/Cerdic-CSSTidy-afda08b/class.csstidy.php";s:4:"b5e8";s:54:"contrib/Cerdic-CSSTidy-afda08b/class.csstidy_ctype.php";s:4:"f779";s:57:"contrib/Cerdic-CSSTidy-afda08b/class.csstidy_optimise.php";s:4:"6615";s:54:"contrib/Cerdic-CSSTidy-afda08b/class.csstidy_print.php";s:4:"242d";s:38:"contrib/Cerdic-CSSTidy-afda08b/COPYING";s:4:"f0c9";s:43:"contrib/Cerdic-CSSTidy-afda08b/cssparse.css";s:4:"43c4";s:44:"contrib/Cerdic-CSSTidy-afda08b/cssparsed.css";s:4:"fa5b";s:43:"contrib/Cerdic-CSSTidy-afda08b/data.inc.php";s:4:"7a29";s:43:"contrib/Cerdic-CSSTidy-afda08b/lang.inc.php";s:4:"78f3";s:35:"contrib/Cerdic-CSSTidy-afda08b/NEWS";s:4:"3510";s:37:"contrib/Cerdic-CSSTidy-afda08b/README";s:4:"279f";s:43:"contrib/Cerdic-CSSTidy-afda08b/template.tpl";s:4:"d6f6";s:44:"contrib/Cerdic-CSSTidy-afda08b/template1.tpl";s:4:"a36d";s:44:"contrib/Cerdic-CSSTidy-afda08b/template2.tpl";s:4:"5904";s:44:"contrib/Cerdic-CSSTidy-afda08b/template3.tpl";s:4:"d8b5";s:14:"doc/manual.sxw";s:4:"df22";s:19:"doc/wizard_form.dat";s:4:"1339";s:20:"doc/wizard_form.html";s:4:"2c1a";s:57:"tests/class.tx_js_css_optimizer_cssOptimizer_testcase.php";s:4:"567e";s:56:"tests/class.tx_js_css_optimizer_jsOptimizer_testcase.php";s:4:"57d9";s:17:"tests/phpunit.xml";s:4:"a8f8";s:23:"tests/fixtures/test.css";s:4:"3580";s:22:"tests/fixtures/test.js";s:4:"3de9";s:69:"tests/hooks/class.tx_js_css_optimizer_hooks_cacheHandler_testcase.php";s:4:"856a";s:75:"tests/hooks/class.tx_js_css_optimizer_hooks_concatenateHandler_testcase.php";s:4:"2e6e";s:75:"tests/hooks/class.tx_js_css_optimizer_hooks_cssCompressHandler_testcase.php";s:4:"907b";s:74:"tests/hooks/class.tx_js_css_optimizer_hooks_jsCompressHandler_testcase.php";s:4:"12b7";s:30:"tests/hooks/fixtures/test1.css";s:4:"af35";s:29:"tests/hooks/fixtures/test1.js";s:4:"a3d3";s:30:"tests/hooks/fixtures/test2.css";s:4:"23f4";s:29:"tests/hooks/fixtures/test2.js";s:4:"a3d3";s:38:"tests/hooks/fixtures/test_charset1.css";s:4:"f8a7";s:38:"tests/hooks/fixtures/test_charset2.css";s:4:"b3bb";s:38:"tests/hooks/fixtures/test_charset3.css";s:4:"b3bb";s:38:"tests/hooks/fixtures/test_charset4.css";s:4:"189a";s:34:"tests/hooks/fixtures/testpath1.css";s:4:"35e5";s:35:"tests/hooks/fixtures/testpath10.css";s:4:"23f6";s:35:"tests/hooks/fixtures/testpath11.css";s:4:"6a44";s:34:"tests/hooks/fixtures/testpath2.css";s:4:"f954";s:34:"tests/hooks/fixtures/testpath3.css";s:4:"3bcf";s:34:"tests/hooks/fixtures/testpath4.css";s:4:"0880";s:34:"tests/hooks/fixtures/testpath5.css";s:4:"651c";s:34:"tests/hooks/fixtures/testpath6.css";s:4:"3a21";s:34:"tests/hooks/fixtures/testpath7.css";s:4:"780a";s:34:"tests/hooks/fixtures/testpath8.css";s:4:"1f2e";s:34:"tests/hooks/fixtures/testpath9.css";s:4:"8529";}',
	'suggests' => array(
	),
);

?>