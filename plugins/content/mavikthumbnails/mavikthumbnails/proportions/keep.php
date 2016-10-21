<?php
/**
 * Определяет выбор размеров при ресайзинге с сохранением пропорций
 */
class plgContentMavikThumbnailsProportionsKeep extends plgContentMavikThumbnailsProportions
{
	function getDefaultDimension()
	{
		if ($this->plugin->origImgSize[0]/$this->plugin->defaultWidth > $this->plugin->origImgSize[1]/$this->plugin->defaultHeight) {
			$defoultSize = 'w';
		} else {
			$defoultSize = 'h';
		}
		return $defoultSize;
	}
}

?>
