<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

// Подключаем локальный helper
require_once(dirname(__FILE__).DS.'helper.php');
 
// Вызываем метод
$data = modMlCopyringHelper::getList($params);
 
// подключаем файл шаблона с помощью класса JModuleHelper
require(JModuleHelper::getLayoutPath('mod_mlcopyring'));
?>