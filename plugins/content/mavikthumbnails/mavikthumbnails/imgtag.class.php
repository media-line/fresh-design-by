<?php
/**
 * @package Joomla
 * @subpackage mavikThumbnails
 * @copyright 2008 Vitaliy Marenkov
 * @author Vitaliy Marenkov <admin@mavik.com.ua>
 * Плагин заменяет изображения иконками со ссылкой на полную версию.
 */

defined( '_JEXEC' ) or die();

/**
 * Класс для работы с тегом img
 *
 */
class plgContentMavikThumbnailsImgTag
{
	
	/**
	 * Аттрибуты тега
	 *
	 * @var array
	 */
	var $_attributes; 

	/**
	 * Высота изображения
	 *
	 * @var int
	 */
	var $_height;
	
	/**
	 * Ширина изображения
	 *
	 * @var int
	 */
	var $_width;
	
	/**
	 * Ширина задана в стиле
	 *
	 * @var boolean
	 */
	var $_widthInStyle = false;
	
	/**
	 * Высота задана в стиле
	 *
	 * @var boolean
	 */
	var $_heightInStyle = false;
	
	/**
	 * Для изображения создана иконка
	 * @var boolean
	 */
	var $isThumb = false;
	
	
	/**
	 * Парсінг тега
	 *
	 * @param string $str Тег в виде строки
	 */
	function parse($str)
	{
		$this->isThumb = false;
		// Распарсить строку - заполнить $_attributes значениями аттрибутов
		preg_match_all('/([\w-_]+)\s*=\s*([\"\']?)(.*?)\2[\s\/>]/s', $str, $matches);
		$attributes = $matches[1];
		$values = $matches[3];
		$this->_attributes = array();
		foreach ($attributes as $attribute) {
			$this->_attributes[$attribute] = array_shift($values); 
		}

		// Определить отображаемый размер
		$this->_width = @$this->_attributes['width'];
		$this->_height = @$this->_attributes['height'];
		if (@$this->_attributes['style']) {
			preg_match('/(?<!\-)\bwidth\s*:\s*(\d+)\s*px/si', $this->_attributes['style'], $matches);
			if (@$matches[1]) {
				$this->_width = $matches[1];
				$this->_widthInStyle = true;
			}
			preg_match('/(?<!\-)\bheight\s*:\s*(\d+)\s*px/si', $this->_attributes['style'], $matches);
			if (@$matches[1]) {
				$this->_height = $matches[1];
				$this->_heightInStyle = true;
			}
		}
	
	}
	
	/**
	 * Установить значение аттрибута
	 *
	 * @param string $name
	 * @param string $value
	 */
	function setAttribute($name, $value)
	{
		$this->_attributes[$name] = $value;
	}
	
	/**
	 * Взять значение аттрибута
	 *
	 * @param string $name
	 * @return string Значение аттрибута
	 */
	function getAttribute($name)
	{
		return @$this->_attributes[$name];
	}
	
	/**
	 * Возвращает отображаемую ширину изображения
	 *
	 * @return int
	 */
	function getWidth()
	{
		return $this->_width;
	}
	
	
	/**
	 * Возвращает отображаему высоту изображения
	 *
	 * @return int
	 */
	function getHeight()
	{
		return $this->_height;
	}
	
	/**
	 * Установить видимую ширину изображения
	 *
	 * @param int $value
	 */
	function setWidth($value)
	{
		$value = round($value);

		// Если аттрибут ширина есть, установить новое значение.
		if ($this->getAttribute('width')) {
			$this->setAttribute('width', $value);
		}
		// Если размеры указаны в стилях, установить в стилях новую ширину, иначе вписать в аттрибуты
		if ($this->_widthInStyle) {
			$this->setAttribute('style', preg_replace('/(?<!\-)\bwidth\s*:\s*\d+\s*px/', 'width: ' . $value . 'px', $this->getAttribute('style')));
		} elseif ($this->_heightInStyle) {				
				$this->setAttribute('style', $this->getAttribute('style') . ' width: ' . $value . 'px;');
		} else {
			$this->setAttribute('width', $value);
		}
		$this->_width = $value;
	}
	
	/**
	 * Установить видимую высоту изображения
	 *
	 * @param int $value
	 */
	function setHeight($value)
	{
		$value = round($value);

		// Если аттрибут высота есть, установить новое значение.
		if ($this->getAttribute('height')) {
			$this->setAttribute('height', $value);
		}
		// Если размеры указаны в стилях, установить в стилях новую высоту, иначе вписать в аттрибуты
		if ($this->_heightInStyle) {
			$this->setAttribute('style', preg_replace('/(?<!\-)\bheight\s*:\s*\d+\s*px/', 'height: ' . $value . 'px', $this->getAttribute('style')));
		} elseif ($this->_widthInStyle) {				
				$this->setAttribute('style', $this->getAttribute('style') . ' height: ' . $value . 'px;');
		} else {
			$this->setAttribute('height', $value);
		}
		$this->_height = $value;
	}
	
	/**
	 * Возвращает тег в виде строки
	 *
	 * @return string
	 */
	function toString()
	{
		$imgTag = '<img ';
		foreach ($this->_attributes as $name=>$value)
		{
			$imgTag .= "$name=\"$value\" ";
		}
		$imgTag .= '/>';
		return $imgTag;
	}
	
}

?>