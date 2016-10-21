<?php
/**
 * $ModDesc
 * Алексей Дементьев
 */
 
// no direct access
defined('_JEXEC') or die;




$cache = $params->get('cache',0);
$centermap = $params->get('centermap');

$scrope_bool = $params->get('scrope_bool');
$bottom_bool = $params->get('bottom_bool');
$temp = $params->get('template');
$scope = $params->get('scope');
$typemap_bool = $params->get('typemap_bool');
$iconmap = $params->get('iconmap');
$trafficControl = $params->get('trafficControl');
$wi = $params->get('wi');
$he = $params->get('he');
 


$icon_wi = $params->get('icon_wi');
$icon_he = $params->get('icon_he');

$zn1 = $params->get('zn1');
$zn2 = $params->get('zn2');

$detailsmap = $params->get('detailsmap');

$contentmap = $params->get('contentmap');


$customSliderClass = $params->get('custom_slider_class','');
$customSliderClass = is_array($customSliderClass)?$customSliderClass:array($customSliderClass);
// подключаем шаблон для отображения
require JModuleHelper::getLayoutPath('mod_yandexmap', $params->get('layout', $temp));
?>
