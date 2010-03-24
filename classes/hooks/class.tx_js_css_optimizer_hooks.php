<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2009 AOE media GmbH <dev@aoemedia.de>
 *  All rights reserved
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
/**
 * Main class for all hooks
 */
abstract class tx_js_css_optimizer_hooks {
	/**
	 * @var csstidy
	 */
	private $csstidy;
	/**
	 * get the folder to cache the files
	 * @return string
	 */
	protected function getCacheFolder(){
		return PATH_site . 'typo3temp'.DIRECTORY_SEPARATOR.'js_css_optimizer'.DIRECTORY_SEPARATOR;
	}
	/**
	 * Get the Prefix of the file names
	 * @return string
	 */
	protected function getPrefix(){
		return 'js_css_optimizer';
	}
	/**
	 * @param string $name
	 * @param string $content
	 * @return string
	 * @throws Exception
	 */
	protected function createCacheFile($name,$content){
		$name = $this->getPrefix().$name;
		$path = $this->getCacheFolder().$name;
		if (!is_dir($this->getCacheFolder())){ 
      		t3lib_div::mkdir ($this->getCacheFolder());
     	}
		if(false === file_exists($path)){
			if(false === file_put_contents($path,$content)){
				throw new Exception('clould not create the cache file');
			}
		}
		return 'typo3temp/js_css_optimizer/'.$name;
	}
	/**
	 * 
	 * @param string $file
	 * @return string
	 * @throws Exception
	 */
	protected function getFileContent($file){
		if (substr($file, 0, 4) == 'EXT:') { // extension
			list($extKey, $local) = explode('/', substr($file, 4), 2);
			if (strcmp($extKey, '') && t3lib_extMgm::isLoaded($extKey) && strcmp($local, '')) {
				$file = t3lib_extMgm::siteRelPath($extKey) . $local;
			}
		}
		$path = PATH_site.DIRECTORY_SEPARATOR.$file;
		
		if(!file_exists($path)){
			throw new Exception('file not found: '.$path);	
		}
		return file_get_contents($path);
		
	}
	/**
	 * Get the path of an recource
	 * @param string $path
	 * @return string
	 */
	private function getRecourcePath($path){
		
		return $path;
	}
	/**
	 * @param string $baseFolder
	 * @param string $content
	 * @return string
	 */
	protected function fixRelativeCssPaths($baseFolder, $content){
		$root = t3lib_div::getIndpEnv('TYPO3_SITE_PATH');

		if(empty($root)){
			throw new Exception('Could not find TYPO3 root path.');
		}

		$baseFolder = t3lib_div::resolveBackPath($root . $baseFolder);

		$content =  preg_replace('/url[ ]*\([ ]*[\']*[\.\.\/]{3}([\w]+\.[\w]+)[\']*/i', 'url('.$baseFolder.'/$1', $content ); // background: url(../test3.gif);
		$content =  preg_replace('/url[ ]*\([ ]*[\']*([a-z|0-9|_|-]+)[\']*/i', 'url('.$baseFolder.'/$1', $content ); // background: url(images/test2.gif); 
		$content =  preg_replace('/url[ ]*\([ ]*[\']*([\.\.\/]{3})([\.\.\/]*)[\']*/i', 'url('.$baseFolder.'/$1$2', $content ); //background: url(../images/test1.gif);  or background: url(../../images/test4.gif);

		return $content;
	}
}
