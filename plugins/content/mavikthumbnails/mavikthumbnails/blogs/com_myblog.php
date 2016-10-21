<?php
/**
 * @package Joomla
 * @subpackage mavikThumbnails
 * @copyright 2008 Vitaliy Marenkov
 * @author Vitaliy Marenkov <admin@mavik.com.ua>
 * Плагин заменяет изображения иконками со ссылкой на полную версию.
 */

class plgContentMavikThumbnailsCom_myblog {

	/**
	 * It is blog?
	 * @return boolean
	 */
	function isBlog() {
		$option = JRequest::getVar('option');
		$show = JRequest::getVar('show');
		return ($option=='com_myblog' && !$show);
	}

	/**
	 * ReadMore Link
	 * @param object $article
	 * @return string 
	 */
	function readmoreLink(&$article) {
		return $article->permalink;
	}
}
?>
