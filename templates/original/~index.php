<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$zu = Jrequest::getVar('view') ;
if ( $zu !='frontpage') {
код не для главной
}
$m=Jrequest::getVar('Itemid');//id menu 
if (isset($m)){
if (!($_SESSION['menuId'])):{session_set_cookie_params(10800);session_start();}endif;
	$_SESSION['menuId']=$m;
}
else{
	$m=$_SESSION['menuId'];
}
$dusar=(($m==2)||($m==11)||($m==12)||($m==13)||($m==16)||($m==17)||($m==18));//id menu on page DUSAR catalog
$saniku=(($m==1)||($m==6)||($m==7)||($m==8)||($m==20)||($m==21)||($m==22)||($m==23)||($m==24));//id menu on page SANIKU catalog
if ($dusar):$sufix='D'; endif;
if ($saniku):$sufix='S'; endif;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php 
	$document = & JFactory::getDocument();
	$document->addScript(JURI::base()."templates/original/js/jquery-1.7.2.min.js");
	$document->addStyleSheet(JURI::base()."templates/original/css/style.css");
	$document->addStyleSheet("http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,700,600&subset=latin,cyrillic-ext");
	?> 
	<jdoc:include type="head" />    
    <? if  (($m==3)||($m==4)) {?>
	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?= $this->template ?>/css/style.css" type="text/css" media="screen, projection" /> 
    <!--[if lte IE 6]>
        <link type="text/css" rel="stylesheet" href="templates/rav/css/styleIE6.css" />   		
    <![endif]-->
<? } else
	{ ?>
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?= $this->template ?>/css/second-page.css" type="text/css" media="screen, projection" />
    <!--[if lte IE 6]>
        <link type="text/css" rel="stylesheet" href="templates/rav/css/second-pageIE6.css" />   		
    <![endif]-->
    <? if ($saniku){?> 
        <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?= $this->template ?>/css/saniku.css" type="text/css" media="screen, projection" />
	<? } else {?>
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?= $this->template ?>/css/dusar.css" type="text/css" media="screen, projection" />
    <? } ?>
    <? } ?>
    <!--[if lte IE 6]>
        <script src="templates/rav/js/DD_belatedPNG.js"></script>
        <script> DD_belatedPNG.fix('div, img, .msg_head, .block, .content, a, span,.addtocart_button');</script>		
    <![endif]-->


</head>

<body>
<? $menu = & JSite::getMenu();
if ( $menu->getActive()==$menu->getDefault()): ?>

<? //echo $m ?>
<? if  ((Jrequest::getVar('Itemid')==3)||(Jrequest::getVar('Itemid')==4)){ ?>
<!-- ******************************* Начало главной страницы сайта ********************************** -->
                    <?php if($this->countModules('klients')) : ?>
					<div id="customers">
                       <jdoc:include type="modules" name="klients" />
					</div>
                    <?php endif; ?>
<div id="wrapper">
	<div id="header">
     <div class="hor_line">
       <div class="hor_menu">
         <jdoc:include type="modules" name="menu-mp" style="xhtmlnone"/>   
       </div>
     </div>
	 <div class="msg_head">
              <jdoc:include type="modules" name="head-mp" style="xhtmlnone"/>   
     </div>
	</div><!-- #header-->

	<div id="middle">

		<div id="container">
			<div id="content">
              <div class="content">
                  <jdoc:include type="message" />
            	  <jdoc:include type="component" />
                 <div class="text">  
	              <jdoc:include type="modules" name="content-mp" style="xhtmlnone"/>   
                 </div>  
              </div>
	
			</div><!-- #content-->
		</div><!-- #container-->

		<div class="sidebar" id="sideRight">
          <div class="block">
              <jdoc:include type="modules" name="right-mp" style="xhtmlnone"/>              
          </div>
		</div><!-- .sidebar#sideRight -->

	</div><!-- #middle-->

<div id="footer">
     <div class="hor_line">
      <table class="footer-table">
       <tr>
         <td>  <jdoc:include type="modules" name="footer1-mp" style="xhtmlnone"/>   </td>
         <td>  <jdoc:include type="modules" name="footer2-mp" style="xhtmlnone"/>   </td>
         <td>  <jdoc:include type="modules" name="footer3-mp" style="xhtmlnone"/>   </td>
         <td>  <span class="ml"><jdoc:include type="modules" name="footer4-mp" style="xhtmlnone"/></span>   </td>                                  
       </tr>
      </table>
     </div>
</div><!-- #footer -->
</div><!-- #wrapper -->
<!-- ******************************* Конец главной страницы сайта ********************************** -->
<? } else { ?>
<!-- ******************************* Начало внутренней страницы ************************************ -->
<!-- head  -->
<div id="head">
	<div class="logo">
        <jdoc:include type="modules" name="leftlogo-<? echo $sufix?>" style="xhtmlnone"/>
    </div>
	<div class="header">
		<div class="topr">
			<div>
		        <jdoc:include type="modules" name="rightlogo-<? echo $sufix?>" style="xhtmlnone" />            
            </div>
			<div class="cart">            
                <jdoc:include type="modules" name="cart-sp" style="xhtmlnone"/>
            </div>
            
		</div>
        
		 <div class="fl">
	        <jdoc:include type="modules" name="hormenu-<? echo $sufix?>" style="xhtmlnone"/>
			<div class="clear"></div>
	        <div class="phones">
            	<div class="phone">
			        <jdoc:include type="modules" name="telhead-sp" style="xhtmlnone"/>                
            	</div>
	        </div>            
            <div><jdoc:include type="modules" name="search-sp" style="xhtmlnone"/></div>
	     </div>
	</div>
</div>
<!-- head end-->

<div id="main">
	<!-- content -->
	<div class="container">
		<div class="left">
           <jdoc:include type="modules" name="left-<? echo $sufix?>" style="xhtmlwithhead"/>
		</div>
		<div class="content">
			<div class="flash-block">
				<div class="flash-tr">
					<div class="flash-bl">
						<div class="flash-br">
                             <jdoc:include type="modules" name="flash-<? echo $sufix?>" style="xhtmlnone"/>
						</div>
					</div>
				</div>
			</div>
            
			<div class="cont-text">
                  <jdoc:include type="message" />
            	  <jdoc:include type="component" />
	           
            </div>
            <div class="clear"></div>
		</div>
	</div>
	<!-- footer -->
	<div class="footer">
        <jdoc:include type="modules" name="footermenu-<? echo $sufix?>" style="xhtmlnone"/>
		<div class="bottom">
              <table class="footer-table">
       <tr>
         <td>  <jdoc:include type="modules" name="footer1-sp" style="xhtmlnone"/>   </td>
         <td>  <jdoc:include type="modules" name="footer2-sp" style="xhtmlnone"/>   </td>
         <td>  <jdoc:include type="modules" name="footer3-sp" style="xhtmlnone"/>   </td>
         <td>  <span class="ml"><jdoc:include type="modules" name="footer4-sp" style="xhtmlnone"/></span>   </td>                                  
       </tr>
      </table>


		</div>
	</div>
</div>
<!-- ******************************* Конец внутренней страницы ************************************* -->
<? } ?>
</body>
</html>