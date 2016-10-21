<?php
/**
 * @package Joomla
 * @subpackage mavikThumbnails
 * @copyright 2008 Vitaliy Marenkov
 * @author Vitaliy Marenkov <admin@mavik.com.ua>
 * Плагин заменяет изображения иконками со ссылкой на полную версию.
 */

class plgContentMavikThumbnailsCom_idoblog {

	/**
	 * It is blog?
	 * @return boolean
	 */
	function isBlog() {
		$option = JRequest::getVar('option');
		$task = JRequest::getVar('task');
		return ($option=='com_idoblog' && $task != 'viewpost');
	}

	/**
	 * ReadMore Link
	 * @param object $article
	 * @return string 
	 */
	function readmoreLink(&$article) {
		return $article->readmore;
	}
}
?>
