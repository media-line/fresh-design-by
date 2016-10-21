<?php
/**
 * @package Joomla
 * @subpackage mavikThumbnails
 * @copyright 2008 Vitaliy Marenkov
 * @author Vitaliy Marenkov <admin@mavik.com.ua>
 * Плагин заменяет изображения иконками со ссылкой на полную версию.
 */


/**
 * Декоратор для добавления к изображению всплыющего окна Slimbox
 * 
 */
class plgContentMavikThumbnailsDecoratorSlimbox extends plgContentMavikThumbnailsDecorator
{
	/**
	 * Добавление кода в заголовок страницы 
	 */
	function addHeader()
	{
		// Подключить библиотеку slimbox
		$document = &JFactory::getDocument();
		JHTML::_('behavior.mootools');
		if ($this->plugin->linkScripts) {
			// Определить версию Mootools
			if (JFactory::getApplication()->get('MooToolsVersion', '1.11') != '1.11' || $this->plugin->jVersion != '1.5') $suffix = "-mt1.2";
			else $suffix = "-mt1.1";
			// Подключить библиотеку
			$document->addScript($this->plugin->url."/mavikthumbnails/slimbox{$suffix}/js/slimbox.js");
			$document->addStyleSheet($this->plugin->url."/mavikthumbnails/slimbox{$suffix}/css/slimbox.css");
		}
		
		if ($this->plugin->zoominCur || $this->plugin->zoominImg) {		
			// Подключить стили плагина к странице
			$document->addStyleSheet($this->plugin->url.'/mavikthumbnails/style.php?base='.$this->plugin->url);
		}
	}
	
	/**
	 * Декорирование тега изображения
	 * @return string Декорированый тег изображения
	 */
	function decorate() {
		$img =& $this->plugin->img;
		$title = $img->getAttribute('title');
		if (empty($title) && $img->getAttribute('alt')) {
			$title = $img->getAttribute('alt');
		}
		$title = htmlspecialchars($title); 
		
		$class = 'thumbnail';
		$style = '';
		$zoominImg = '';
		
		if ($this->plugin->zoominImg) {
			$style = $img->getAttribute('style');
			$img->setAttribute('style', '');
			$zoominImg = '<span class="zoomin-img"></span>';
			$class .= ' with-zoomin-img ' . $img->getAttribute('class');
			$align = $img->getAttribute('align');
			if($align == 'left' || $align == 'right') { $style .= '; float:'.$align.';'; }   		 			
		}
		
		if ($this->plugin->zoominCur) {
			$class .= ' zoomin-cur';
		}

		return '<a style="'. $style .'" class="' . $class . '" href="' . $this->plugin->originalSrc . '" rel="lightbox[' . @$this->plugin->article->id. ']" title="' . $title . '" target="_blank">' . $img->toString() . $zoominImg . '</a>';
	}	
	
}
?>