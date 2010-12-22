This extension use the hooks of the t3lib_PageRenderer to compress an bundle the JS and CSS Files.

Use this to activate the bundling and compression:

config{
	moveJsFromHeaderToFooter = 1
	minifyCSS = 1
	minifyJs=1
	concatenateJsAndCss = 1
}
