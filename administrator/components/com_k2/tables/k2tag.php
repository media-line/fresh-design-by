<?php
/**
 * @version		$Id: k2tag.php 1618 2012-09-21 11:23:08Z lefteris.kavadas $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2012 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;

class TableK2Tag extends K2Table
{

    var $id = null;
    var $name = null;
    var $published = null;

    function __construct(&$db)
    {

        parent::__construct('#__k2_tags', 'id', $db);
    }

    function check()
    {

        if (JString::trim($this->name) == '')
        {
            $this->setError(JText::_('K2_TAG_CANNOT_BE_EMPTY'));
            return false;
        }
        // Check if tag exists already for new tags
        if (!$this->id)
        {
            $this->_db->setQuery("SELECT id FROM #__k2_tags WHERE name = ".$this->_db->Quote($this->name));
            if ($this->_db->loadResult())
            {
                $this->setError(JText::_('K2_THIS_TAG_EXISTS_ALREADY'));
                return false;
            }
        }
        $this->name = JString::trim($this->name);
        $this->name = str_replace('-', '', $this->name);
        $this->name = str_replace('.', '', $this->name);
        return true;
    }

}
