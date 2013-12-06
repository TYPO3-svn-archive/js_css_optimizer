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
	 * @param $url
	 * @return bool
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
		$name = $this->getPrefix($name).$name;
		$path = $this->getCacheFolder().$name;
		if (FALSE === is_dir($this->getCacheFolder())){
			t3lib_div::mkdir ($this->getCacheFolder());
		}
		$temp_file = $path.'.tmp';
		if(FALSE === file_put_contents($temp_file,$content)){
			throw new Exception('could not create the cache file');
		}
		t3lib_div::fixPermissions($temp_file);

		// rename the temp-file (on concurrent file systems (e.g. NFS), this action can possibly fail if another PHP-process has already renamed the temp-file)
		$success = @rename($temp_file,$path);
		if(FALSE === $success && FALSE === file_exists($path)) {
			throw new Exception('could not rename the cache file');
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

		$content =  preg_replace('/url[ ]*\([ ]*[\'"]*[\.\.\/]{3}([\w]+\.[\w]+)/i', 'url('.$baseFolder.'/$1', $content ); // background: url(../test3.gif);
		$content =  preg_replace('/url[ ]*\(([ ]*[\'"]*)(?!data:[a-z]+\/[a-z]+;)([a-z|0-9|_|-]+)/i', 'url($1'.$baseFolder.'/$2', $content ); // background: url(images/test2.gif);
		$content =  preg_replace('/url[ ]*\(([ ]*[\'"]*)([\.\.\/]{3})([\.\.\/]*)/i', 'url($1'.$baseFolder.'/$2$3', $content ); //background: url(../images/test1.gif);  or background: url(../../images/test4.gif);
		return $content;
	}

	/**
	 * @param string $name
	 * @param boolean $contextIsClient
	 * @return string
	 */
	protected function getCacheFilePath($name,$contextIsClient=TRUE) {
		$name = $this->getPrefix($name).$name;
		if($contextIsClient === TRUE) {
			// generate path for client
			$path = 'typo3temp/js_css_optimizer/'.$name;
			if($this->isAbsRefPrefix()){
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
		if($this->isAbsRefPrefix() && substr($file,0,strlen($GLOBALS['TSFE']->absRefPrefix)) == $GLOBALS['TSFE']->absRefPrefix ){
			$file = substr($file,strlen($GLOBALS['TSFE']->absRefPrefix));
		}
		$path = t3lib_div::resolveBackPath(PATH_site.DIRECTORY_SEPARATOR . $file);
		if(!file_exists($path)){
			throw new Exception('tx_js_css_optimizer: file not found: '.$path);
		}
		t3lib_div::fixPermissions($path);
		$content = file_get_contents($path);
		if(FALSE === $content){
			throw new Exception('tx_js_css_optimizer: could not read file: '.$path);
		}
		return $content;
	}

	/**
	 * @param	string	$file
	 * @param	string	$filecontent
	 * @return	string
	 */
	protected function getFileName($file, $filecontent) {
		if ($this->useHashedFilename()) {
			$filename = '_compressed_' . sha1($filecontent) . '_' . basename($file);
		} else {
			$filename = sha1($file) . '_' . basename($file);
		}
		return $filename;
	}

	/**
	 * Get the Prefix of the file names
	 * @param string $name
	 * @return string
	 */
	protected function getPrefix($name='') {
		$prefix = 'js_css_optimizer';
		$result = '';
		if (!$name || !stristr($name, $prefix)) {
			$result = $prefix;
		}
		return $result;
	}

	/**
	 * @return boolean
	 */
	protected function useHashedFilename() {
		// is either "1", "embed" or "querystring" - if nothing isset we've to take care
		$mode = strtolower($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['versionNumberInFilename']);
		return ! ((boolean) $mode);
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
	 * @return boolean
	 */
	private function isAbsRefPrefix(){
		return (isset($GLOBALS['TSFE']) && isset($GLOBALS['TSFE']->absRefPrefix));
	}
}