<?php
/**
 * Определяет выбор размеров при ресайзинге с сохранением занимаемой плащади
 */
class plgContentMavikThumbnailsProportionsArea extends plgContentMavikThumbnailsProportions
{
	function  setDefaultSize()
	{
		$plugin = &$this->plugin;
		if ($plugin->defaultHeight && $plugin->defaultWidth ) {
			$thumbArea = $plugin->defaultHeight * $plugin->defaultWidth;
			$originArea = $plugin->origImgSize[0] * $plugin->origImgSize[1];
			$ratio = sqrt($originArea/$thumbArea);
			$plugin->img->setWidth($plugin->origImgSize[0]/$ratio);
			$plugin->img->setHeight($plugin->origImgSize[1]/$ratio);
		} else {
			parent::setDefaultSize();
		}
	}
}
?>
