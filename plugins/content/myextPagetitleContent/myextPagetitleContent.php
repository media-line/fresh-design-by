<?php
/**
 * @package		Joomla.Site
 * @subpackage	plg_contenttitle
 * @autor		Usov Dima (usovdm@gmail.com, http://myext.eu)
 * @copyright	Copyright (C) 2005 - 2012, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');
class plgContentMyextPagetitleContent extends JPlugin
{
	function plgContentMyextPagetitleContent(&$subject, $config)
	{
		parent::__construct($subject, $config);
	}

	function onContentBeforeSave($context, $article, $isNew){
		$form_names = array('com_content.article','com_categories.category');
		if(in_array($context,$form_names)){
			$metadata = json_decode($article->metadata);
			$metadata->browser_title = $_REQUEST['jform']['browser_title'];
			$metadata = json_encode($metadata);
			$article->metadata = $metadata;
		}
	}
	
	public function onContentPrepareForm($form, $data)
	{
		$form_names = array('com_content.article','com_categories.categorycom_content');
		if(in_array($form->getName(),$form_names)){
			$title = $this->params->get('title') ? $this->params->get('title') : 'Page title';
			if(!is_object($data)){ $data = (object)$data; } // FIX plugin: system - languagefilter - item_association
			$browser_title = isset($data->metadata['browser_title']) ? $data->metadata['browser_title'] : '';
			if((float)(JVERSION) >= 3 && (float)(JVERSION) < 3.5){
				$js = "
					window.addEvent('domready', function() {
						var jform_title = $('jform_title').getParent();
						var browser_title_div = new Element('div', {class:'control-group form-inline'}).inject(jform_title, 'after');
						new Element('label', {id: 'browser_title-lbl',for:'jform[browser_title]',type:'text',class:'control-label',html:'".$title."'}).inject(browser_title_div);
						new Element('input', {id: 'browser_title',name:'jform[browser_title]',type:'text',class:'input-xlarge',value:'".$browser_title."',size:55}).inject(browser_title_div);
					});
				";
			}elseif((float)(JVERSION) >= 1.6 && (float)(JVERSION) < 3){
				$js = "
				window.addEvent('domready', function() {
					var jform_title = $('jform_title').getParent();
					var browser_title_li = new Element('li', {}).inject(jform_title, 'after');
					new Element('label', {id: 'browser_title-lbl',for:'jform[browser_title]',type:'text',class:'inputbox',html:'".$title."'}).inject(browser_title_li);
					new Element('input', {id: 'browser_title',name:'jform[browser_title]',type:'text',class:'inputbox',value:'".$browser_title."',size:55}).inject(browser_title_li);
				});
				";
			}else{
				$js = "";
			}
			$doc = JFactory::getDocument();
			$doc->addScriptDeclaration($js);
		}
	}
	public function onBeforeCompileHead(){
		$doc =& JFactory::getDocument();
		if(isset($doc->_metaTags['standard']['browser_title'])){
			$browser_title = $doc->_metaTags['standard']['browser_title'];
			$doc->setTitle($browser_title);
			unset($doc->_metaTags['standard']['browser_title']);
		}
	}
}

?>