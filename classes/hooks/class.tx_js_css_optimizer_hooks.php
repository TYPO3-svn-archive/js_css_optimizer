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
 * @package js_css_optimize
 */
abstract class tx_js_css_optimizer_hooks {
	
	/**
	 * This method check if a resource is an external resource.
	 * 
	 * @param string $url
	 */
	protected function isExternalResource($url) {
		return substr(strtolower($url), 0, 4) == 'http' || substr(strtolower($url), 0, 2) == '//' ;
	}
	
	/**
	 * @param string $name
	 * @param string $content
	 * @throws Exception
	 */
	protected function createCacheFile($name,$content){
		$name = $this->getPrefix().$name;
		$path = $this->getCacheFolder().$name;
		if (!is_dir($this->getCacheFolder())){ 
			t3lib_div::mkdir ($this->getCacheFolder());
		}
		$temp_file = $path.'.tmp';
		if(false === file_put_contents($temp_file,$content)){ 
			throw new Exception('clould not create the cache file');
		}
		t3lib_div::fixPermissions($temp_file);
		if(false === rename($temp_file,$path)){
			throw new Exception('clould not rename the cache file');
		}
	}

	/**
	 * @param string $baseFolder
	 * @param string $content
	 * @return string
	 */
	protected function fixRelativeCssPaths($baseFolder, $content){
		$root = t3lib_div::getIndpEnv('TYPO3_SITE_PATH');
		if(empty($root)){
			$root = '/';
		}
		$baseFolder = t3lib_div::resolveBackPath($root . $baseFolder);

		$content =  preg_replace('/url[ ]*\([ ]*[\']*[\.\.\/]{3}([\w]+\.[\w]+)/i', 'url('.$baseFolder.'/$1', $content ); // background: url(../test3.gif);
		$content =  preg_replace('/url[ ]*\([ ]*[\']*([a-z|0-9|_|-]+)/i', 'url('.$baseFolder.'/$1', $content ); // background: url(images/test2.gif); 
		$content =  preg_replace('/url[ ]*\(([ ]*[\']*)([\.\.\/]{3})([\.\.\/]*)/i', 'url($1'.$baseFolder.'/$2$3', $content ); //background: url(../images/test1.gif);  or background: url(../../images/test4.gif);

		return $content;
	}

	/**
	 * @param string $name
	 * @param boolean $contextIsClient
	 * @return string
	 */
	protected function getCacheFilePath($name,$contextIsClient=TRUE) {
		$name = $this->getPrefix().$name;
		if($contextIsClient === TRUE) {
			// generate path for client
			$path = 'typo3temp/js_css_optimizer/'.$name;
			if(isset($GLOBALS['TSFE']) && isset($GLOBALS['TSFE']->absRefPrefix)){
				$path = $GLOBALS['TSFE']->absRefPrefix .$path;
			}
		} else {
			// generate path for webserver
			$path = $this->getCacheFolder().$name;
		}
		return $path;
	}
	/**
	 * get the folder to cache the files
	 * @return string
	 */
	protected function getCacheFolder(){
		return PATH_site . 'typo3temp'.DIRECTORY_SEPARATOR.'js_css_optimizer'.DIRECTORY_SEPARATOR;
	}
	/**
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
		$path = t3lib_div::resolveBackPath(PATH_site.DIRECTORY_SEPARATOR . $file);

		if(!file_exists($path)){
			throw new Exception('file not found: '.$path);	
		}
		t3lib_div::fixPermissions($path);
		$content = file_get_contents($path);
		if(FALSE === $content){
			throw new Exception('could not read file: '.$path);	
		}
		return $content;
	}
	/**
	 * @param	string	$file
	 * @param	string	$filecontent
	 * @return	string
	 */
	protected function getFileName($file, $filecontent) {
		return '_compressed_' . sha1($filecontent) . '_' . basename($file);
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
	 * @return boolean
	 */
	protected function hasCacheFile($name) {
		$path = $this->getCacheFilePath($name, FALSE);
		return file_exists($path);
	}

	/**
	 * Get the path of an recource
	 * @param string $path
	 * @return string
	 */
	private function getRecourcePath($path){
		return $path;
	}
}