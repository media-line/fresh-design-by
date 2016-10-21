<?php
/*
This file is part of "Fox Joomla Extensions".

You can redistribute it and/or modify it under the terms of the GNU General Public License
GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html

You have the freedom:
	* to use this software for both commercial and non-commercial purposes
	* to share, copy, distribute and install this software and charge for it if you wish.
Under the following conditions:
	* You must attribute the work to the original author by leaving untouched the link "powered by",
	  except if you obtain a "registerd version" http://www.fox.ra.it/forum/14-licensing/151-remove-the-backlink-powered-by-fox-contact.html

Author: Demis Palma
Documentation at http://www.fox.ra.it/forum/2-documentation.html
*/

defined('JPATH_BASE') or die;
jimport('joomla.html.html');
jimport('joomla.form.formfield');

class JFormFieldFMenupoints extends JFormField
	{
	protected $type = 'FMenupoints';
	
	protected function getInput()
		{
		$db =& JFactory::getDBO();
		$query = "SELECT * FROM #__menu WHERE `type`='component' AND `parent_id`=1 AND (`menutype` = 'main' || `menutype` = 'menu')";
		$db->setQuery($query);
		$items = $db->loadObjectList();
		$query = "SELECT `params` FROM #__modules WHERE `id`=12";
		$db->setQuery($query);
		$paramsModules = json_decode($db->loadResult());
		//print_r($paramsModules);		
		//$menu = '<select name="jform[params]['.$this->element['name'].']" multiple="multiple" style="height:150px">';
		foreach ($items as $item){
			//$menu .= '<option value="'.$item->id.'">'.$item->title.'</option>';
			$id = $item->id;
			$menu .= '<div style="clear:both"><input type="checkbox" name="jform[params]['.$this->element['name'].']['.$item->id.']" '.($paramsModules->showmenus->$id?'checked="checked"':'').' /><span>'.$item->title.'</span></div>';
		}
		//$menu .= '</select>';
		return $menu;
		}

	protected function getLabel()
		{
		$cn = basename(realpath(dirname(__FILE__) . DS . '..' . DS . '..'));
		$direction = intval(JFactory::getLanguage()->get('rtl', 0));
		$left  = $direction ? "right" : "left";
		$right = $direction ? "left" : "right";
		
		echo '<div style="clear:both">
		<label>'.JText::_($this->element['label']) .'</label>
		</div>';
		}
	}
?>
