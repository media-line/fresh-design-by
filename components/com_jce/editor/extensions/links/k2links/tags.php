<?php
/**
 * @copyright    Copyright (C) 2009 Nicholas K. Dionysopoulos. All rights reserved.
 * @author		Nicholas K. Dionysopoulos
 * @license      GNU/GPL v.3 or later
 * 
 * K2Links is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 *
 * Based on "joomlalinks" found in JCE's core distribution. Modified by Nicholas
 * K. Dionysopoulos to support JoomlaWorks' K2
 */

defined( '_WF_EXT' ) or die( 'ERROR_403' );

/**
 * This class fetches K2 tags and related items
 */
class K2linksTags extends JObject
{
	var $_option = 'com_k2';
	var $_task = 'tag';
	
	/**
	* Constructor activating the default information of the class
	*
	* @access	protected
	*/
	function __construct($options = array()){
	}

	/**
	 * Returns a reference to a editor object
	 *
	 * This method must be invoked as:
	 * 		<pre>  $browser =JContentEditor::getInstance();</pre>
	 *
	 * @access	public
	 * @return	JCE  The editor object.
	 * @since	1.5
	 */
	function &getInstance()
	{
		static $instance;

		if ( !is_object( $instance ) ){
			$instance = new K2linksTags();
		}
		return $instance;
	}
	
	public function getOption()
	{
		return $this->_option;
	}
	
	public function getTask()
	{
		return $this->_task;
	}
	
	public function getList()
	{
		$advlink = WFEditorPlugin::getInstance();
		$list = '';
		if ($advlink->checkAccess('k2links.tags', '1')) {
			$list = '<li id="index.php?option=com_k2&task=tag"><div class="tree-row"><div class="tree-image"></div><span class="folder content nolink"><a href="javascript:;">' . JText::_('K2 Tags') . '</a></span></div></li>';
		}
		return $list;	
	}
	
	function _getK2Tags()
	{
		$db		=& JFactory::getDBO();
		$user	=& JFactory::getUser();

		$query = 'SELECT id, name'
		. ' FROM #__k2_tags'
		. ' WHERE published = 1'
		. ' ORDER BY name ASC'
		;

		$db->setQuery($query);
		return $db->loadObjectList();
	}
	
	function _getK2Items($tag = '')
	{
		$db		=& JFactory::getDBO();

		$tagEscaped = $db->quote($tag);

		$query = <<<ENDSQL
SELECT `i`.`id`, `i`.`title`, `i`.`alias`
FROM `#__k2_tags_xref` as `x`
INNER JOIN `#__k2_items` as `i` ON(`i`.`id` = `x`.`itemID`)
INNER JOIN `#__k2_tags` as `t` ON (`t`.`id` = `x`.`tagID`)
WHERE
`t`.`name` = $tagEscaped

ENDSQL;

		$user	=& JFactory::getUser();
		if(version_compare(JVERSION,'1.6.0','ge')) {
			$query .= ' AND `i`.`access` IN ('.implode(',', $user->authorisedLevels()).')';
		} else {
			$query .= "\nAND `i`.`access` <=".(int) $user->get('aid');
		}
		
		$query .= "\nORDER BY `i`.`title`, `i`.`created` ASC";

		$db->setQuery($query);
		return $db->loadObjectList();
	}
		
	function getLinks($args)
	{		
		$mainframe = JFactory::getApplication();
		
		$advlink = WFEditorPlugin::getInstance();
		
		require_once(JPATH_SITE .DS. 'components' .DS. 'com_k2' .DS. 'helpers' .DS. 'route.php');

		$items 		= array();
		$view		= isset($args->view) ? $args->view : '';
		
		switch ($view) {
		
		default:
			$tags	= self::_getK2Tags();
			foreach ($tags as $tag) {
				$items[] = array(
					'id'		=>	K2HelperRoute::getTagRoute($tag->name),
					'name'		=>	$tag->name,
					'class'		=>	'folder content'
				);
			}
			break;
			
		case 'itemlist':
			$itemlist = self::_getK2Items($args->tag);
			foreach ($itemlist as $item) {
				$items[] = array(
					'id'		=>	K2HelperRoute::getItemRoute($item->id),
					'name'		=>	$item->title,
					'class'		=>	'file'
				);
			}
			break;
			
		case 'item':
			break;
		}
		return $items;
	}
}
?>