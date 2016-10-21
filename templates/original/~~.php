<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<jdoc:include type="head" />
    <?php 
	$document = & JFactory::getDocument();
	$document->addScript(JURI::base()."templates/original/js/jquery-1.7.2.min.js");
	$document->addStyleSheet(JURI::base()."templates/original/css/style.css");
	$document->addStyleSheet("http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,700,600&subset=latin,cyrillic-ext");
	?>     
    <script type="text/javascript">
	 function automatHeight(){
		 jQuery(".catalog .row").each(function(){
			  var maxH1=maxH2=0;
			  jQuery(this).find(".item").each(function() {
				  jQuery(this).find(".title,.desc").removeAttr("style");
				  maxH1=Math.max(maxH1,jQuery(this).find(".title").height());
                  maxH2=Math.max(maxH2,jQuery(this).find(".desc").height());
              });
			  jQuery(this).find(".title").height(maxH1);
			  jQuery(this).find(".desc").height(maxH2);			  			  
		 });		 
	 }
	 jQuery.noConflict();
	 jQuery(document).ready(function(){
		 jQuery(".basket").hover(
		  function(){jQuery(this).stop(true,true).animate({"height":"90px"},100);},
		  function(){jQuery(this).stop(true,true).animate({"height":"39px"},100);}
		 );
		 jQuery(".main-menu .child").each(function(){
			 var maxL = 0;
			 jQuery(this).find("span").each(function(){
				 maxL = Math.max(maxL,jQuery(this).text().length);
			 });
			 var str = '';
			 for (i=0;i<maxL;i++) str+='a';
			 jQuery(this).find("li:last").after('<li class="last"><a href="#">'+str+'<a/></li>');
		 });
		 jQuery(".main-menu .parent").hover(
		   function(){jQuery(this).find("ul").stop(true,true).slideDown(300); jQuery(this).addClass("hover");},
		   function(){jQuery(this).find("ul").stop(true,true).slideUp(100); jQuery(this).removeClass("hover");}
		   );
		 jQuery(".table tr:even").addClass("even");
		 jQuery(".table tr:odd").addClass("odd");		 				  
	 });
	 jQuery(function(){
		 automatHeight();
		 jQuery(window).bind('resize',automatHeight);
	 });
	</script>    
        <!--[if lte IE 6]>
		<script src="js/DD_belatedPNG.js"></script>
		<script> DD_belatedPNG.fix('div, img, a, span,p, ul, li, *');</script>	
        <script type="text/javascript">
         jQuery.noConflict();
         jQuery(document).ready(function(){
         alert(window.screen.width);
             if (window.screen.width<960) jQuery(".inner").width(960);
             if (window.screen.width>1405) jQuery(".inner").width(1405);
         });
        </script>        
        <link rel="stylesheet" href="css/styleIE6.css" type= "text/css" />
	<![endif]--> 
</head>
<body>
<div id="wrapper">
	<div id="header">
		<div class="inner">
         <div class="time"><jdoc:include type="modules" name="time" style="xhtmlnone"/>  </div>
         <div class="address"><jdoc:include type="modules" name="address" style="xhtmlnone"/>  </div>
         <div class="basket">
          <jdoc:include type="modules" name="basket" style="xhtmlnone"/>  
         </div>
         <div class="clr"></div>
        </div>
	</div>
    <div class="inner">
	<div class="after-header">
       <div class="logo"><jdoc:include type="modules" name="logo" style="xhtmlnone"/>  </div>
       <div class="contacts">
        <jdoc:include type="modules" name="head-contact" style="xhtmlnone"/>  
       </div>
       <div class="clr"></div>
    </div>
    </div>   
    <div class="inner wrap-menu">
    <div class="main-menu">
     <div class="menu-l"></div>
     <div class="menu-r"></div>
        <jdoc:include type="modules" name="main-menu" style="xhtmlnone"/>  
      	<jdoc:include type="modules" name="search" style="xhtmlnone"/>         
    </div>
    <div class="clr"></div>
    </div>   
	<div id="middle">
	 <div class="inner">   
		<div id="container">
			<div id="content" style="padding-left:0px;">                            
                  <jdoc:include type="message" />
            	  <jdoc:include type="component" />   
			</div>
		</div>
        <div class="clr"></div>
		</div>
	</div>
</div>
<div id="footer">
 <div class="inner">
       <div class="copyring"><jdoc:include type="modules" name="copyring" style="xhtmlnone"/></div>
       <div class="contacts">
        <jdoc:include type="modules" name="footer-contacts" style="xhtmlnone"/>
       </div> 
        <jdoc:include type="modules" name="fs" style="xhtmlnone"/>
       <div class="clr"></div>
 </div>
</div>
</body>
</html>