<?php
/**
 * @package Joomla
 * @subpackage mavikThumbnails
 * @copyright 2008 Vitaliy Marenkov
 * @author Vitaliy Marenkov <admin@mavik.com.ua>
 * Плагин заменяет изображения иконками со ссылкой на полную версию.
 */


/**
 * Декоратор для добавления к изображению стандартного модального окна
 * 
 */
class plgContentMavikThumbnailsDecoratorModal extends plgContentMavikThumbnailsDecorator
{
	/**
	 * Добавление кода в заголовок страницы 
	 */
	function addHeader()
	{
		// Подключить библиотеку модальных окон
		JHTML::_('behavior.modal');
		
		if ($this->plugin->zoominCur || $this->plugin->zoominImg) {		
			// Подключить стили плагина к странице
			$document =& JFactory::getDocument();
			$document->addStyleSheet(JURI::base() . 'plugins/content/mavikthumbnails/style.php?base='.JURI::base());
		}
	}
	
	/**
	 * Декорирование тега изображения
	 * @param $img string Тег изображения 
	 * @return string Декорированый тег изображения
	 */
	function decorate() {
		$img =& $this->plugin->img;
		
		$class = 'modal thumbnail';
		$style = '';
		$zoominImg = '';
		$title = htmlspecialchars($title);
		
		if ($this->plugin->zoominImg) {
			$style = $img->getAttribute('style');
			$img->setAttribute('style', '');
			$zoominImg = '<span class="zoomin-img"></span>';
			$class .= ' with-zoomin-img';
			$align = $img->getAttribute('align');
			if($align == 'left' || $align == 'right') { $style .= '; float:'.$align.';'; } 						 			
		}
		
		if ($this->plugin->zoominCur) {
			$class .= ' zoomin-cur';
		}
		
		return '<a class="'.$class.'" style="'.$style.'" href="'. $this->plugin->originalSrc .'" rel="{handler: \'image\', marginImage: {x: 50, y: 50}}" title="'.$title.'">' . $img->toString() . $zoominImg . '</a>';
	}	
	
}
?>