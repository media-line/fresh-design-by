<?php
/**
 * @version		4.1
 * @package		AllVideos (plugin)
 * @author    JoomlaWorks - http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.plugin.plugin');

class plgContentJw_allvideos extends JPlugin {

  // JoomlaWorks reference parameters
	var $plg_name								= "jw_allvideos";
	var $plg_copyrights_start		= "\n\n<!-- JoomlaWorks \"AllVideos\" Plugin (v4.1) starts here -->\n";
	var $plg_copyrights_end			= "\n<!-- JoomlaWorks \"AllVideos\" Plugin (v4.1) ends here -->\n\n";

	function plgContentJw_allvideos( &$subject, $params ){
		parent::__construct( $subject, $params );
	}

	// Joomla! 1.5
	function onPrepareContent(&$row, &$params, $page = 0){
		$this->renderAllVideos($row, $params, $page = 0);
	}

	// Joomla! 1.6/1.7
	function onContentPrepare($context, &$row, &$params, $page = 0){
		jimport('joomla.html.parameter');
		$this->renderAllVideos($row, $params, $page = 0);
	}

	// The main function
	function renderAllVideos(&$row, &$params, $page = 0){

		// API
		jimport('joomla.filesystem.file');
    $mainframe= &JFactory::getApplication();
		$document = &JFactory::getDocument();

		// Assign paths
		$sitePath = JPATH_SITE;
		$siteUrl  = JURI::root(true);

		if(version_compare(JVERSION,'1.6.0','ge')) {
			$pluginLivePath = JURI::root(true).'/plugins/content/'.$this->plg_name.'/'.$this->plg_name;
		} else {
			$pluginLivePath = JURI::root(true).'/plugins/content/'.$this->plg_name;
		}

    // Check if plugin is enabled
    if(JPluginHelper::isEnabled('content',$this->plg_name)==false) return;

		// Load the plugin language file the proper way
		JPlugin::loadLanguage('plg_content_'.$this->plg_name, JPATH_ADMINISTRATOR);

		// Includes
		require_once(dirname(__FILE__).DS.$this->plg_name.DS.'includes'.DS.'helper.php');
		require(dirname(__FILE__).DS.$this->plg_name.DS.'includes'.DS.'sources.php');

		// Simple performance check to determine whether plugin should process further
		$grabTags = str_replace("(","",str_replace(")","",implode(array_keys($tagReplace),"|")));
		if(preg_match("#{(".$grabTags.")}#s",$row->text)==false) return;


		// ----------------------------------- Get plugin parameters -----------------------------------

		// Outside Parameters
		if(!$params) $params = new JParameter(null);

		$plugin =& JPluginHelper::getPlugin('content',$this->plg_name);
		$pluginParams = new JParameter( $plugin->params );

		/* Preset Parameters */
		$template						= 'Classic';
		$skin								= 'snel';
		/* Video Parameters */
		$vfolder 						= ($params->get('vfolder')) ? $params->get('vfolder') : $pluginParams->get('vfolder','images/stories/videos');
		$vwidth 						= ($params->get('vwidth')) ? $params->get('vwidth') : $pluginParams->get('vwidth',400);
		$vheight 						= ($params->get('vheight')) ? $params->get('vheight') : $pluginParams->get('vheight',300);
		$transparency 			= $pluginParams->get('transparency','transparent');
		$background 				= $pluginParams->get('background','#010101');
		$backgroundQT				= $pluginParams->get('backgroundQT','black');
		$controlBarLocation = $pluginParams->get('controlBarLocation','bottom');
		/* Audio Parameters */
		$afolder 						= $pluginParams->get('afolder','images/stories/audio');
		$awidth 						= $pluginParams->get('awidth',300);
		$aheight 						= $pluginParams->get('aheight',20);
		/* Global Parameters */
		$autoplay 					= ($params->get('autoplay')) ? $params->get('autoplay') : $pluginParams->get('autoplay',0);
		$autoplay						= ($autoplay) ? 'true' : 'false';
		/* Performance Parameters */
		$gzipScripts				= $pluginParams->get('gzipScripts',0);

		// Variable cleanups for K2
		if(JRequest::getCmd('format')=='raw'){
			$this->plg_copyrights_start = '';
			$this->plg_copyrights_end = '';
		}



		// ----------------------------------- Render the output -----------------------------------

		// Append head includes only when the document is in HTML mode
		if(JRequest::getCmd('format')=='html' || JRequest::getCmd('format')==''){

			// CSS
			$avCSS = AllVideosHelper::getTemplatePath($this->plg_name,'css/template.css',$template);
			$avCSS = $avCSS->http;
			$document->addStyleSheet($avCSS);

			// JS
			if(version_compare(JVERSION,'1.6.0','ge')) {
				JHtml::_('behavior.framework');
			} else {
				JHTML::_('behavior.mootools');
			}

			if($gzipScripts){
				$document->addScript($pluginLivePath.'/includes/js/jw_allvideos.js.php');
			} else {
				$document->addScript($pluginLivePath.'/includes/js/mediaplayer/jwplayer.js');
				$document->addScript($pluginLivePath.'/includes/js/wmvplayer/silverlight.js');
				$document->addScript($pluginLivePath.'/includes/js/wmvplayer/wmvplayer.js');
				$document->addScript($pluginLivePath.'/includes/js/quicktimeplayer/AC_QuickTime.js');
			}
		}

		// Loop throught the found tags
		foreach ($tagReplace as $plg_tag => $value) {

			// expression to search for
			$regex = "#{".$plg_tag."}.*?{/".$plg_tag."}#s";

			// process tags
			if(preg_match_all($regex, $row->text, $matches, PREG_PATTERN_ORDER)) {

				// start the replace loop
				foreach ($matches[0] as $key => $match) {

					$tagcontent 		= preg_replace("/{.+?}/", "", $match);
					$tagparams 			= explode('|',$tagcontent);
					$tagsource 			= trim(strip_tags($tagparams[0]));
					$final_vwidth 	= (@$tagparams[1]) ? $tagparams[1] : $vwidth;
					$final_vheight 	= (@$tagparams[2]) ? $tagparams[2] : $vheight;
					$final_autoplay = (@$tagparams[3]) ? $tagparams[3] : $autoplay;

					// Placeholder elements
					$findAVparams = array(
						"{SOURCE}",
						"{SOURCEID}",
						"{FOLDER}",
						"{WIDTH}",
						"{HEIGHT}",
						"{PLAYER_AUTOPLAY}",
						"{PLAYER_TRANSPARENCY}",
						"{PLAYER_BACKGROUND}",
						"{PLAYER_BACKGROUNDQT}",
						"{PLAYER_CONTROLBAR}",
						"{SITEURL}",
						"{FILE_EXT}",
						"{PLUGIN_PATH}",
						"{PLAYER_POSTER_FRAME}",
						"{PLAYER_SKIN}"
					);

					// Special treatment for specific video providers
					if($plg_tag=="dailymotion"){
						$tagsourceDailymotion = explode('_',$tagsource);
						$tagsource = $tagsourceDailymotion[0];
					}

					if($plg_tag=="ku6"){
						$tagsource = str_replace('.html','',$tagsource);
					}

					if($plg_tag=="metacafe" && substr($tagsource,-1,1)=='/'){
						$tagsource = substr($tagsource,0,-1);
					}

					if($plg_tag=="vidiac"){
						$tagsourceVidiac = explode(';',$tagsource);
						$tagsource = $tagsourceVidiac[0];
					}

					if($plg_tag=="yahoo"){
						$tagsourceYahoo = explode('-',str_replace('.html','',$tagsource));
						$tagsourceYahoo = array_reverse($tagsourceYahoo);
						$tagsource = $tagsourceYahoo[0];
					}

					if($plg_tag=="youmaker"){
						$tagsourceYoumaker = explode('-',str_replace('.html','',$tagsource));
						$tagsource = $tagsourceYoumaker[1];
					}

					if($plg_tag=="youku"){
						$tagsource = str_replace('.html','',$tagsource);
						$tagsource = substr($tagsource,3);
					}

					// Prepare the HTML
					$output = new JObject;

					$output->playerID = 'AVPlayerID_'.substr(md5($tagsource),1,8).'_'.rand();

					// Poster frame
					$posterFramePath = $sitePath.DS.str_replace('/',DS,$vfolder);
					if(JFile::exists($posterFramePath.DS.$tagsource.'.jpg')){
						$output->posterFrame = $siteUrl.'/'.$vfolder.'/'.$tagsource.'.jpg';
					} elseif(JFile::exists($posterFramePath.DS.$tagsource.'.png')){
						$output->posterFrame = $siteUrl.'/'.$vfolder.'/'.$tagsource.'.png';
					} elseif(JFile::exists($posterFramePath.DS.$tagsource.'.gif')){
						$output->posterFrame = $siteUrl.'/'.$vfolder.'/'.$tagsource.'.gif';
					} else {
						$output->posterFrame = '';
					}

					// Width/height/source folder
					if(in_array($plg_tag, array('mp3','mp3remote','aac','aacremote','m4a','m4aremote','ogg','oggremote'))){
						$output->playerWidth = $awidth;
						$output->playerHeight = $aheight;
						$output->folder = $afolder;
					} else {
						$output->playerWidth = $final_vwidth;
						$output->playerHeight = $final_vheight;
						$output->folder = $vfolder;
					}

					// Replacement elements
					$replaceAVparams = array(
						$tagsource,
						$output->playerID,
						$output->folder,
						$output->playerWidth,
						$output->playerHeight,
						$final_autoplay,
						$transparency,
						$background,
						$backgroundQT,
						$controlBarLocation,
						$siteUrl,
						$plg_tag,
						$pluginLivePath,
						$output->posterFrame,
						$skin
					);

					// Do the element replace
					$output->player = JFilterOutput::ampReplace(str_replace($findAVparams, $replaceAVparams, $tagReplace[$plg_tag]));

					// Fetch the template
					ob_start();
					$getTemplatePath = AllVideosHelper::getTemplatePath($this->plg_name,'default.php',$template);
					$getTemplatePath = $getTemplatePath->file;
					include($getTemplatePath);
					$getTemplate = $this->plg_copyrights_start.ob_get_contents().$this->plg_copyrights_end;
					ob_end_clean();

					// Output
					$row->text = preg_replace("#{".$plg_tag."}".preg_quote($tagcontent)."{/".$plg_tag."}#s", $getTemplate , $row->text);

				} // End second foreach

			} // End if

		} // End first foreach

	} // End function

} // End class
