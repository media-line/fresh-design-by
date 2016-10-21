<?php
/**
 * @version		$Id: modules.php 14401 2010-01-26 14:10:00Z louis $
 * @package		Joomla
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/*
 * none (output raw module content)
 */
 function modChrome_xhtmlhormenu($module, &$params, &$attribs)
{ ?>
	    <div class="hor-menu">
      <div class="bg-l">
        <div class="bg-r">
		<?
	if (!empty ($module->content)) : echo $module->content;endif;
	    ?>
</div>
</div>
</div><?        
}
 function modChrome_block($module, &$params, &$attribs)
{
	?>
     <? if (!empty ($module->content)) : ?>
    <div class="block <?=$params->get('moduleclass_sfx');?>">
      
            <? if ($module->showtitle != 0) : echo  '<div class="head"><div class="h2">'.$module->title.'</div></div>'; endif ?>
              
              <div class="body">
                  <? if (!empty ($module->content)) : echo $module->content;endif; ?>
                  <div class="clr"></div>
              </div>
            <div class="clr"></div>
    </div>
    <? endif; ?>
    <?
}
function modChrome_block2($module, &$params, &$attribs)
{
	?>
     <? if (!empty ($module->content)) : ?>
    <div class="style-block <?=$params->get('moduleclass_sfx');?>">
     <div class="t"></div>
      <div class="m">
            <? if ($module->showtitle != 0) : echo  '<div class="head">'.$module->title.'</div>'; endif ?>              
              <div class="body">
                  <? if (!empty ($module->content)) : echo $module->content;endif; ?>
              </div>
      </div>
     <div class="b"></div>         
    </div>
    <? endif; ?>
    <?
}
 function modChrome_xhtmlfooter($module, &$params, &$attribs)
{
	?>
    <div id="footer-block">
     <div class="bg-l">
      <div class="bg-r">
      <div>
	  <? if ($module->showtitle != 0) : echo $module->title; endif ?>
        <? if (!empty ($module->content)) : echo $module->content;endif; ?>
        </div>
        </div>
        </div>
        </div>     		  
    <?
}

//******************** end my modules *****************************************

?>