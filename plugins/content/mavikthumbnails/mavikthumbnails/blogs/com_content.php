<?php
/**
 * @package Joomla
 * @subpackage mavikThumbnails
 * @copyright 2008 Vitaliy Marenkov
 * @author Vitaliy Marenkov <admin@mavik.com.ua>
 * Плагин заменяет изображения иконками со ссылкой на полную версию.
 */

/**
 * Написание вспомогательных классов блогов подразумевается авторами компонентов
 * поэтому им не передается ссылка на объект плагина. Работа с данными происходит
 * обычным методом - через параметры.
 */

class plgContentMavikThumbnailsCom_content {

	var $plugin;
	
	function __construct(&$plugin) {
		$this->plugin = &$plugin;
	}	


	/**
	 * It is blog?
	 * @return boolean
	 */
	function isBlog() { 
		$option = JRequest::getVar('option');
		$view = JRequest::getVar('view');
		$layout = JRequest::getVar('layout');
		return ($option=='com_content' && ($layout=='blog' || $view=='frontpage' || $view=='featured'));
	}

	/**
	 * ReadMore Link
	 * @param object $article
	 * @return string 
	 */
	function readmoreLink(&$article) {
		// Получить слитые параметры
		jimport( 'joomla.html.parameter' );
		$params = new JParameter($article->attribs, JPATH_ADMINISTRATOR.DS.'components'.DS.'com_content'.DS.'models'.DS.'article.xml');
		$menuitemid = JRequest::getInt( 'Itemid' );
		if ($menuitemid) {
			$menu = JSite::getMenu();
			$menuparams = $menu->getParams($menuitemid);
			$params->merge($menuparams);
		}
		$params->merge($article->params);
		// Если для статьи есть уже ссылка, сделать ссылкой и изобржение
		if (@$article->readmore || $params->get('link_titles')) {
			if ($this->plugin->jVersion == '1.5') {
				$readmore = JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catslug, $article->sectionid));
			} else {
				$readmore = JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid));
			}
		} else {
			$readmore = '';
		}
		return $readmore;
	}
}
?>
