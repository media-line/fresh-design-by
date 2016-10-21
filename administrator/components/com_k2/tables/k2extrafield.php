<?php
/**
 * @version		$Id: k2extrafield.php 1618 2012-09-21 11:23:08Z lefteris.kavadas $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2012 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;

class TableK2ExtraField extends K2Table
{

    var $id = null;
    var $name = null;
    var $value = null;
    var $type = null;
    var $group = null;
    var $published = null;
    var $ordering = null;

    function __construct(&$db)
    {
        parent::__construct('#__k2_extra_fields', 'id', $db);
    }

}
