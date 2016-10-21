<?php
/**

 **/
defined('_JEXEC') or die(':)');

 
// Подключение требуемых файлов
jimport('joomla.form.formfield');
/**
 * Создаем класс. Fieldname - имя типа
 */
class JFormFieldSfsimplecode extends JFormField
{
	/**
	 * @var $type	Имя типа
	 */
	protected $type = 'Sfsimplecode';
	/**
	 * Метод, определяющий что будет выводить параметр
	 *
	 * @return	Результат вывода типа
	 */
	protected function getInput()
	{
		$html = '
<div style="margin:10px 0; font-size:16px">Определение координат - <a target="_blank" href="http://dimik.github.io/ymaps/examples/location-tool/" title="(с ноября 2014)" >API Яндекс.Карт</a>
</div>';
 
		// ...
		// Какой-то код, в котором определяется что нужно выводить
		// ...
 
		return $html; 
	}
}
?>
