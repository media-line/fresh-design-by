<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_contenttitle
 * @autor		Usov Dima (usovdm@gmail.com, http://myext.eu)
 * @copyright	Copyright (C) 2005 - 2012, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
$doc =& JFactory::getDocument();
if(isset($doc->_metaTags['standard']['browser_title'])){
	$browser_title = $doc->_metaTags['standard']['browser_title'];
	$doc->setTitle($browser_title);
	unset($doc->_metaTags['standard']['browser_title']);
}