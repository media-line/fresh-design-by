<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php 
	$document = & JFactory::getDocument();
	$document->addScript(JURI::base()."templates/original/js/jquery-1.7.2.min.js");
	$document->addScript(JURI::base()."templates/original/js/jquery.bxslider.min.js");
	$document->addScript(JURI::base()."templates/original/js/script.js");
	$document->addScript("//yandex.st/share/share.js");	
	$document->addStyleSheet(JURI::base()."templates/original/css/jquery.bxslider.css");
	$document->addStyleSheet(JURI::base()."templates/original/css/style.css");	
	if (JRequest::getVar('Itemid')==101)
	$document->addStyleSheet(JURI::base()."templates/original/css/style-main.css");	
	?> 
    <jdoc:include type="head" />
    <!--[if lte IE 6]>
		<script src="<?php echo $this->baseurl ?>/templates/<?= $this->template ?>/js/DD_belatedPNG.js"></script>
		<script> DD_belatedPNG.fix('div, img, a, span,p, ul, li, *');</script>	
        <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?= $this->template ?>/css/styleIE6.css" type= "text/css" />
	<![endif]--> 
  <meta name='yandex-verification' content='67632196df786a66' />
  <script src="//web.it-center.by/nw" async></script>
</head>

<body>

<div id="wrapper">
  <div id="wrapper-inner">
	<div id="header" class="header">
     <div class="inner">
 <div class="logo">
              			<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=12,1,2,152" width="251px" height="144px">
					   	<param name="movie" value="templates/original/images/fresh-logo.swf" />
						<param name="quality" value="high" /><param name="wmode" value="transparent" />
						<param name="bgcolor" value="#d4f1b7" />
						<embed src="templates/original/images/fresh-logo.swf" quality="high" wmode="transparent" bgcolor="#d4f1b7" width="251px" height="144px" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
						</object>
        <jdoc:include type="modules" name="logo" style="xhtmlnone"/>
      </div>
     <!-- <div style="margin-left: 337px;margin-top: 5px;"><p style="font-size: 14px;font-weight: bold;"><span style="color: #3A6891">ВИДЕО РАБОТ, НОВОСТИ В СОЦ.СЕТЯХ!</span></p></div>
	  <div class="header_social">
	      <a href="https://www.youtube.com/channel/UCykucX7VLS8mEccmmFJMO9Q"><img class="header_social_img" src="images/youtube.png"></a>
		  <a href="https://www.facebook.com/freshartdesign/"><img class="header_social_img" src="images/facebook.png"></a>
		  <a href="https://instagram.com/fresh_art_design/"><img class="header_social_img" src="images/instagram.png"></a>
		  <a href="https://vk.com/freshart_design"><img class="header_social_img" src="images/vk.png"></a>
		  <a href="https://twitter.com/FreshArt_Design"><img class="header_social_img" src="images/twitter.png"></a>
	  </div>-->
      <!--<div style="margin-left: 398px; margin-top: 65px;position: relative; z-index: 5000;"><img src="templates/original/images/fresh1.png" width="149" height="25" alt="" /></div>   -->
      <div class="phone">
       <jdoc:include type="modules" name="phone" style="xhtmlnone"/>
      </div>
      <div class="main-menu">
        <jdoc:include type="modules" name="main-menu" style="xhtmlnone"/>
      </div>      
     </div>
	</div><!-- #header-->
	<?php if($this->countModules('slider')) : ?>
     <div id="slider" class="big-slider">
      <jdoc:include type="modules" name="slider" style="xhtmlnone"/>
     </div>
    <?php endif; ?>
	<div id="middle">
     <div class="inner">
     <?php if($this->countModules('left')) : ?>
		<div class="sidebar" id="sideLeft">
         <jdoc:include type="modules" name="left" style="block"/>
		</div><!-- .sidebar#sideRight -->     
     <?php endif; ?>
		<div id="container">
			<div id="content" class="content" <?php echo $this->countModules('left')?'style="padding-left:200px;"':'';?>> 
				<jdoc:include type="modules" name="content-top" style="block"/>
                  <jdoc:include type="message" />
            	  <jdoc:include type="component" />                
                <jdoc:include type="modules" name="content-bottom" style="block"/>
                <script type="text/javascript" src="//vk.com/js/api/openapi.js?116"></script>

<!-- VK Widget -->
<div id="vk_groups"></div>
<script type="text/javascript">
VK.Widgets.Group("vk_groups", {mode: 2, width: "950", height: "600"}, 15022106);
</script>
			</div><!-- #content-->
		</div><!-- #container-->
	  </div>
	</div><!-- #middle-->
 </div>
</div><!-- #wrapper -->

<div id="footer" class="footer">
 <div class="inner">
  <div class="copyring">
  <jdoc:include type="modules" name="copyring" style="xhtmlnone"/><noindex><!--LiveInternet counter--><script type="text/javascript"><!--
document.write("<a href='http://www.liveinternet.ru/click' "+
"target=_blank><img src='//counter.yadro.ru/hit?t26.2;r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";"+Math.random()+
"' alt='' title='LiveInternet: показано число посетителей за"+
" сегодня' "+
"border='0' width='88' height='15'><\/a>")
//--></script><!--/LiveInternet--></noindex>


<!-- Yandex.Metrika informer -->
<a href="https://metrika.yandex.ru/stat/?id=28781501&amp;from=informer"
target="_blank" rel="nofollow"><img src="//bs.yandex.ru/informer/28781501/2_1_FFFFFFFF_FFFFFFFF_0_uniques"
style="width:80px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (уникальные посетители)" /></a>
<!-- /Yandex.Metrika informer -->

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter28781501 = new Ya.Metrika({id:28781501,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/28781501" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->


  </div>
  <jdoc:include type="modules" name="ml" style="xhtmlnone"/>
  <div class="clr"></div>
 </div>
</div><!-- #footer -->

</body>
</html>