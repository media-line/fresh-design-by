<?php
/**
 * @package Joomla
 * @subpackage mavikThumbnails
 * @copyright 2008 Vitaliy Marenkov
 * @author Vitaliy Marenkov <admin@mavik.com.ua>
 * Плагин заменяет изображения иконками со ссылкой на полную версию.
 */

/**
 * Декоратор для добавления к изображению ссылки на полный текст статьи
 * 
 */
class plgContentMavikThumbnailsDecoratorBlogLink extends plgContentMavikThumbnailsDecorator
{
	/**
	 * Декорирование тега изображения
	 * @param $img string Тег изображения 
	 * @return string Декорированый тег изображения
	 */
	function decorate() {
		$article =& $this->plugin->article;
		$img =& $this->plugin->img;
		$readmoreLink = $this->plugin->blogHelper->readmoreLink($article);

		// Если для статьи есть ссылка, сделать ссылкой изобржение
		if ($readmoreLink) {
			$class = $img->getAttribute('class');
			$class = $class ? $class.' thumbnail':'thumbnail';
			return '<a href="'. $readmoreLink .'" class="'.$class.'">' . $img->toString() . '</a>';
		} else {
			return $img->toString();
		}
	}

}
?>