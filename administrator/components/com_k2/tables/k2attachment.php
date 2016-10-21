<?php
/**
 * @version		$Id: k2attachment.php 1618 2012-09-21 11:23:08Z lefteris.kavadas $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2012 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;

class TableK2Attachment extends K2Table
{

    var $id = null;
    var $itemID = null;
    var $filename = null;
    var $title = null;
    var $titleAttribute = null;
    var $hits = null;

    function __construct(&$db)
    {
        parent::__construct('#__k2_attachments', 'id', $db);
    }

}
