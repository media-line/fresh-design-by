<?php header('Content-Type: text/css'); ?>
<?php header('Expires: '.gmdate("D, d M Y H:i:s", time() + 60*60*24*30).' GMT'); ?>
<?php header('Last-Modified: '.gmdate("D, d M Y H:i:s").' GMT'); ?>
<?php header('Cache-Control: public, max-age=' . 60*60*24*30); ?>
@charset "utf-8";

/* Zoomin image at thumbnails */
a.with-zoomin-img {
	position: relative;
	display: inline-block;
}

.zoomin-img {
	display: block;
	width: 24px;
	height: 24px;
	position: absolute;
	bottom: 3px;
	right: 3px;
	background-image: url(images/zoomin.gif);
	background-position: right bottom;
	background-repeat: no-repeat;
}

/* Zoomin cursor at thumbnails */
a.zoomin-cur {
	cursor: url(<?php echo $_GET['base']; ?>/mavikthumbnails/images/zoomin.cur), pointer;
}
