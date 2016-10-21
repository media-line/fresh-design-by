<?php
/**
 * @version     $Id: k2tags.php 1595 2012-06-07 11:57:51Z lefteris.kavadas $
 * @package     K2
 * @author      JoomlaWorks http://www.joomlaworks.net
 * @copyright   Copyright (c) 2006 - 2012 JoomlaWorks Ltd. All rights reserved.
 * @license     GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

defined('JPATH_PLATFORM') or die ;

class JFormFieldK2Tags extends JFormField
{

    protected $type = 'K2Tags';

    protected function getInput()
    {
        $document = JFactory::getDocument();
        $document->addStyleSheet(JURI::root(true).'/plugins/josetta_ext/k2item/fields/k2tags.css');
        $document->addScript('//ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js');
        $document->addScript(JURI::root(true).'/plugins/josetta_ext/k2item/fields/k2tags.js');

        $html = '<ul class="tags">';
        $tags = explode(',', $this->value);
        if (count($tags))
        {
            foreach ($tags as $tag)
            {
                $tag = JString::trim($tag);
                $html .= '<li class="tagAdded">'.$tag.'<span title="'.JText::_('K2_CLICK_TO_REMOVE_TAG').'" class="tagRemove">x</span><input type="hidden" name="tags[]" value="'.$tag.'" /></li>';
            }

        }
        $html .= '<li class="tagAdd"><input type="text" id="search-field" /></li>
        <li class="clr"></li>
        </ul>
        <span class="k2Note"> '.JText::_('K2_WRITE_A_TAG_AND_PRESS_RETURN_OR_COMMA_TO_ADD_IT').' </span>';
        return $html;
    }

}
