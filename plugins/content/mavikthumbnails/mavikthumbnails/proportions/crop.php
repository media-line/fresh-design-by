<?php
/**
 * Определяет выбор размеров при ресайзинге с обрезкой под размер
 */
class plgContentMavikThumbnailsProportionsCrop extends plgContentMavikThumbnailsProportions
{
	function getArea()
	{
		// Размеры превьющки и изображения
		$thumbWidht = $this->plugin->img->getWidth();
		$thumbHeight = $this->plugin->img->getHeight();
		$origWidth = $this->plugin->origImgSize[0];
		$origHeight = $this->plugin->origImgSize[1];
		if ($origWidth/$origHeight < $thumbWidht/$thumbHeight) {
			$x = 0; $widht = $origWidth;
			$height = $origWidth *  $thumbHeight/$thumbWidht;
			$y = ($origHeight - $height)/2;
		} else {
			$y = 0; $height = $origHeight;
			$widht = $origHeight *  $thumbWidht/$thumbHeight;
			$x = ($origWidth - $widht)/2;
		}
		return array($x, $y, $widht, $height);
	}
}
?>
