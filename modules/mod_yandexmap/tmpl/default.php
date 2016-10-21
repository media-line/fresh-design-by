<?
/**
 * API Яндекс карт
 */
defined('_JEXEC') or die; 
$ja_00 = 0;
$ja_01 = 1;
$i = 0;
foreach ($customSliderClass as  $value)
   {
	   $value = trim($value);
	   if($ja_00==$i) {$point[$i]=$value; $ja_00 = $ja_00+2; } else {$description[$i]=$value;}
	   $i++;   
   }
	
$i=0;		

//point / чтобы массив был [0] [1] [2] ...
foreach ($point as $val) {
$point2[$i]=$val;
$i++;	
	}
	
//description / чтобы массив был [0] [1] [2] ...
$i=0;		
if ($description) { 
foreach ($description as $val) {
$description2[$i]=$val;
$i++;	
	}
}
//$js = JURI::base().'//api-maps.yandex.ru/2.0-stable/?load=package.standard,package.geoObjects&lang=ru-RU';

/*$js = '//api-maps.yandex.ru/2.0-stable/?load=package.standard,package.geoObjects&lang=ru-RU';
$document = JFactory::getDocument();
$document->addScript($js);
*/ // для отбражения модуля через модуль(модуль внутри материалов где не действует $document->addScript($js); подключим api-maps на прямую)
echo '<script src="http://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>';
$rand = rand(1,1000);
?>
<div class="yandex_map" id="yandex_map<?php echo $rand;?>"><script type="text/javascript">

var myMap;
// Дождёмся загрузки API и готовности DOM.
ymaps.ready(init);

function init () {
    var myMap = new ymaps.Map("map2<?php echo $rand;?>", {
            center: [<?php echo $centermap;?>],
            zoom: <?php echo $scope;?>,
			controls: [<? if($scrope_bool==1) {?>'zoomControl',<? } ?><? if($bottom_bool==1) {?>'searchControl',<? } ?><? if($typemap_bool==1) {?>'typeSelector',<? } ?>'fullscreenControl']
			//,type: "yandex#satellite" // загрузка спутник
			   }),
<? 
for($i=0;$i<count($point2);$i++)
{
?>
 // Создаем геообъект с типом геометрии "Точка".
   myPlacemark<?php echo $i?> = new ymaps.Placemark([<? echo $point2[$i];?>], {
            // Свойства.
  balloonContent: '<?php  
	if($arraystoplist = explode("\n", $description2[$i])) {
	for($y=0;$y<count($arraystoplist);$y++) {$newtext.= '<div class="myclass2014'.$rand.$y.'">'.trim($arraystoplist[$y])."</div>";}
	echo $newtext;
	unset ($newtext); // удаляем для того чтобы следующих цикл не множился
	}
	else  {echo trim($description2[$i]);}?>'				
            }, {
					
            // Опции.
			    // Необходимо указать данный тип макета.
            iconLayout: 'default#image',
            // Своё изображение иконки метки.
			
            iconImageHref: '<?php echo $iconmap;?>',
            // Размеры метки.
            iconImageSize: [<?php echo $icon_wi;?>, <?php echo $icon_he;?>],
            // Смещение левого верхнего угла иконки относительно
            // её "ножки" (точки привязки).
           iconImageOffset: [<?php echo $zn1;?>, <?php echo $zn2;?>]
        });		
		
<?
} // конец for

 if($trafficControl==1) {?>
   // Создадим элемент управления "Пробки".
    var trafficControl = new ymaps.control.TrafficControl({ state: {
            // Отображаются пробки "Сейчас".
            providerKey: 'traffic#actual',
            // Начинаем сразу показывать пробки на карте.
            trafficShown: true
        }});
    // Добавим контрол на карту.
    myMap.controls.add(trafficControl);
    // Получим ссылку на провайдер пробок "Сейчас" и включим показ инфоточек.
    trafficControl.getProvider('traffic#actual').state.set('infoLayerShown', true);  
 // Добавляем все метки на карту.


<?php  } ?>


myMap.geoObjects<?php 
for($i=0;$i<count($point2);$i++)
{ ?>	
.add(myPlacemark<?php echo $i;?>)
<?php } ?>
    
}

</script>
<div id="map2<?php echo $rand;?>" style="width:<?php echo $wi;?>px; height:<?php echo $he;?>px"></div>
</div>
<div class="clear" style="clear:both"></div>
