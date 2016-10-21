<?php
/**
 * @version		$Id: item.php 1618 2012-09-21 11:23:08Z lefteris.kavadas $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2012 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

class K2ControllerItem extends K2Controller
{

    public function display($cachable = false, $urlparams = array())
    {
        JRequest::setVar('view', 'item');
        parent::display();
    }

    function save()
    {
        JRequest::checkToken() or jexit('Invalid Token');
        $model = $this->getModel('item');
        $model->save();
    }

    function apply()
    {
        $this->save();
    }

    function cancel()
    {
        JRequest::checkToken() or jexit('Invalid Token');
        $model = $this->getModel('item');
        $model->cancel();
    }

    function deleteAttachment()
    {
        $model = $this->getModel('item');
        $model->deleteAttachment();
    }

    function tag()
    {
        $model = $this->getModel('tag');
        $model->addTag();
    }

    function download()
    {
        $model = $this->getModel('item');
        $model->download();
    }

    function extraFields()
    {
        $mainframe = JFactory::getApplication();
        $itemID = JRequest::getInt('id', NULL);
        $categoryModel = $this->getModel('category');
        $category = $categoryModel->getData();
        $extraFieldModel = $this->getModel('extraField');
        $extraFields = $extraFieldModel->getExtraFieldsByGroup($category->extraFieldsGroup);

        $output = '<table class="admintable" id="extraFields">';
        $counter = 0;
        if (count($extraFields))
        {
            foreach ($extraFields as $extraField)
            {
                $output .= '<tr><td align="right" class="key">'.$extraField->name.'</td>';
                $output .= '<td>'.$extraFieldModel->renderExtraField($extraField, $itemID).'</td></tr>';
                $counter++;
            }
        }
        $output .= '</table>';

        if ($counter == 0)
            $output = JText::_('K2_THIS_CATEGORY_DOESNT_HAVE_ASSIGNED_EXTRA_FIELDS');

        echo $output;

        $mainframe->close();
    }

    function resetHits()
    {
        JRequest::checkToken() or jexit('Invalid Token');
        $model = $this->getModel('item');
        $model->resetHits();

    }

    function resetRating()
    {
        JRequest::checkToken() or jexit('Invalid Token');
        $model = $this->getModel('item');
        $model->resetRating();

    }

}
