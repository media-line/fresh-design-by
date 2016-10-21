<?php
/**
* @package Joomla! 2.5
* @version 3.1
* @author 2008-2012 (c)  Denys Nosov (aka Dutch)
* @author web-site: www.joomla-ua.org
* @copyright This module is licensed under a Creative Commons Attribution-Noncommercial-No Derivative Works 3.0 License.
**/

// no direct access
defined('_JEXEC') or die;

require_once JPATH_SITE.'/components/com_content/helpers/route.php';

jimport('joomla.application.component.model');

JModel::addIncludePath(JPATH_SITE.'/components/com_content/models', 'ContentModel');

abstract class modJUNewsUltraHelper {

	public static function getList(&$params) {

        $app = JFactory::getApplication();
		$db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $model = JModel::getInstance('Articles', 'ContentModel', array('ignore_request' => true));

		$appParams = $app->getParams();
		$model->setState('params', $appParams);

        // Introtext
		$show_intro         = $params->get( 'show_intro');
		$introtext_limit	= intval( $params->get( 'introtext_limit') );
		$li                 = $params->get('li');
		$lmttext            = $params->get('lmttext');
		$clear_tag          = $params->get('clear_tag');

		// Date
		$data_format	    = $params->get('data_format');
		$df_d			    = $params->get('df_d');
		$df_m			    = $params->get('df_m');
		$df_y			    = $params->get('df_y');

        // Image
		$imageWidth         = intval($params->get('imageWidth'));
		$imageHeight        = intval($params->get('imageHeight'));
		$thumb_width        = intval($params->get('thumb_width'));
		$thumb_filtercolor  = intval($params->get('thumb_filtercolor', 0));
		$Zoom_Crop          = intval($params->get('Zoom_Crop', 1));
		$pik                = $params->def('pik');
		$noimage            = $params->def('noimage');
		$imglink            = $params->def('imglink');
   		$youtube_img_show   = $params->def('youtube_img_show', 1);
   		$thumb_unsharp      = $params->def('thumb_unsharp', 1);
   		$gallery            = $params->def('gallery', 1);

		// Set the filters based on the module params
		$model->setState('list.start', 0);
		$model->setState('list.limit', (int) $params->get('count', 5));
		$model->setState('filter.published', 1);

		$model->setState('list.select', 'a.fulltext, a.id, a.title, a.alias, a.title_alias, a.introtext, a.state, a.catid, a.created, a.created_by, a.created_by_alias,' .
			' a.images, a.urls, a.attribs, a.access,' .
			' a.hits, a.featured,' .
			' LENGTH(a.fulltext) AS readmore');

		// Access filter
		$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
		$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
		$model->setState('filter.access', $access);

        // User filter
		$userId = JFactory::getUser()->get('id');
		switch ($params->get('user_id')) {
			case 'by_me':
				$model->setState('filter.author_id', (int) $userId);
			break;
			case 'not_me':
				$model->setState('filter.author_id', $userId);
				$model->setState('filter.author_id.include', false);
			break;
			case '0':
			break;
			default:
				$model->setState('filter.author_id', (int) $params->get('user_id'));
			break;
		}

		// Filter by language
		$model->setState('filter.language',$app->getLanguageFilter());

		//  Featured switch
		switch ($params->get('show_featured')) {
			case '1':
				$model->setState('filter.featured', 'only');
			break;
			case '0':
				$model->setState('filter.featured', 'hide');
			break;
			default:
				$model->setState('filter.featured', 'show');
			break;
		}

		// Set ordering
	    $order_map = array(
			'title_asc'             => 'a.title ASC',
			'title_desc'            => 'a.title DESC',
			'id_asc'                => 'a.id',
			'id_desc'               => 'a.id DESC',
            'hits_desc'             => 'a.hits DESC',
            'created_asc'           => 'a.created',
            'created_desc'          => 'a.created DESC',
            'modified_desc'         => 'a.modified DESC',
            'modified_created_dsc'  => 'a.modified DESC, a.created',
			'modified_touch_dsc'    => 'CASE WHEN (a.modified = '.$db->quote($db->getNullDate()).') THEN a.created ELSE a.modified END',
			'ordering_asc'          => 'a.ordering ASC',
			'ordering_desc'         => 'a.ordering DESC',
			'rand'                  => 'rand()',
			'publish_dsc'           => 'a.publish_up',
			'rating_dsc'            => 'v.rating_count',
		);

		$ordering = JArrayHelper::getValue($order_map, $params->get('ordering'), 'a.publish_up');
		$dir = '';

		$model->setState('list.ordering', $ordering);
	   	$model->setState('list.direction', $dir);

		// Select article or categories
        if($params->def('display_article') == 1) {
    		// Article filter
    		$model->setState('filter.article_id', $params->def('articleid', array()));
        } else {
    		// Category filter
    		$model->setState('filter.category_id', $params->get('catid', array()));
        }

        $items = $model->getItems();

        // JComments integration
        if ($params->def('JC') == 1 && count($items)) {

            $comments = JPATH_SITE . '/components/com_jcomments/jcomments.php';
            if (file_exists($comments))
            {
                $ids = array();

                foreach($items as $item) {
                    $ids[] = $item->id;
                }

                $db = JFactory::getDBO();
                $db->setQuery('SELECT object_id, count(*) AS cnt FROM #__jcomments WHERE object_group="com_content" AND object_id IN ('.implode(',', $ids).')');
                $commentsCount = $db->loadObjectList('object_id');

                foreach($items as &$item) {

                    $item->comments     = isset($commentsCount[$item->id]) ? $commentsCount[$item->id]->cnt : 0;
                    $item->commentslink = '#comments';
                    $item->commentstext = JText::plural('LINK_READ_COMMENTS', $item->comments);

                    if ($item->comments == 0) {
                        $item->comments     = '';
                        $item->commentslink = '#addcomments';
                        $item->commentstext = JText::_('LINK_ADD_COMMENT');
                    }
                }
            } else {
                echo '<strong style="color: green;">JComments not installed!</strong>';
            }
        }
        // JComments integration

		foreach ($items as &$item) {

			$item->slug = $item->id.':'.$item->alias;
			$item->catslug = $item->catid.':'.$item->category_alias;

			if ($access || in_array($item->access, $authorised)) {
				$item->link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug));
                $catlink = JRoute::_(ContentHelperRoute::getCategoryRoute($item->catslug));
			} else {
				$item->link = JRoute::_('index.php?option=com_users&view=login');
                $catlink = $item->link;
			}

            // article title
            $item->title = preg_replace('#"(.*?)"#is', '«\\1»', strip_tags( $item->title ));

            // category title
            if($params->get('showcat') == 1) {
                $cattitle = strip_tags( $item->category_title );
                if($params->get('showcatlink') == 1) {
                    $item->cattitle = '<a href="'. $catlink .'">'. $cattitle .'</a>';
                } else {
                    $item->cattitle = $cattitle;
                }
            }

            // images
            if ($pik==1) {

                $iW = $imageWidth;
                $iH = $imageHeight;

                if ($imglink == 1) {
                    $imlink  = '<a href="'. $item->link .'"'. ($params->get('tips') == 1 ? ' title="'. strip_tags( $item->title ) .'"' : '') .'>';
                    $imlink2 = '</a>';
                }

                $junuimgresmatche = $item->introtext . $item->fulltext;

                if (preg_match('/{gallery\s+(.*?)}/i', $junuimgresmatche, $junuimgsource) && $gallery == '1') {

                    $junuimgsource  = $junuimgsource[1];

                    $imglist = explode("|", $junuimgsource);
                    $junuimgsource  = $imglist[0];

                    $imglist        = '';
                    $root           = JPATH_BASE .'/';
                    $folder         = 'images/'. $junuimgsource;
                    $img_folder     = $root . $folder;
                    $files          = array();
                    $dir            = opendir($img_folder);

                    while(($file = readdir($dir)) !== false) {
                        if($file !== '.' && $file !== '..' && (strtolower(substr($file, -3)) === 'jpg' || strtolower(substr($file, -3)) === 'png' || strtolower(substr($file, -3)) === 'gif')) {
                            $files[] = $file;
                            break;
                        }
                    }

                    closedir($dir);
                    sort($files);

                    $junuimgsource  = $folder .'/'. $files[0];

                } elseif (preg_match('/<img(.*?)src="(.*?)"(.*?)>\s*(<\/img>)?/', $junuimgresmatche, $junuimgsource)) {
                    $junuimgsource  = $junuimgsource[2];
                }

                if( $junuimgsource ) {
                    $junuimgsource  = str_replace(JURI::base(), '', $junuimgsource);
                    // raw image source
                    $item->imagesource = $junuimgsource;
                }

                if ($thumb_width==1) {

                    $imgthr    = JURI::base() .'modules/mod_junewsultra/img/'. (($params->get('secimg', 1) == '1') ? '' : 'img.php?src=');

                    $imgthr2   = '&w='. $iW .
                                 '&h='. $iH .
                                 '&q=99' .
                                 ($Zoom_Crop == '1' ? '&zc=1' : '')
                                 ;
                    if($thumb_filtercolor == '1') {
                        $imgthr2 .= '&fltr[]=gray';
                    }
                    if($thumb_filtercolor == '2') {
                        $imgthr2 .= '&fltr[]=sep';
                    }

                    if($thumb_unsharp == '1') {
                        $imgthr2 .= '&fltr[]=usm|80|0.5|3';
                    }

                    $junuimg         = base64_encode(  '../../../' . $junuimgsource . $imgthr2 );
                    $jununoimg       = base64_encode(  '../../../media/mod_junewsultra/' . $noimage . $imgthr2 );

                    $contentimage = $imlink .'<img src="'. $imgthr . $junuimg .'_junus.jpg"'. ($Zoom_Crop == '1' ? ' width="'. $iW .'" height="'. $iH .'"' : '') .' alt="'. strip_tags( $item->title ) .'" />'. $imlink2;

                    $blankimage = $imlink .'<img src="'. $imgthr . $jununoimg .'_junus.jpg"'. ($Zoom_Crop == '1' ? ' width="'. $iW .'" height="'. $iH .'"' : '') .' alt="'. strip_tags( $item->title ) .'" />'. $imlink2;

                    if($youtube_img_show == 1) {

                        $regex1 = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^>"&?/ ]{11})%i';
                        $regex2 = '#(player.vimeo.com)/video/([0-9]+)#i';

                        if (preg_match($regex1, $junuimgresmatche, $match)) {
                            $item->image = $imlink .'<img src="'. $imgthr . base64_encode( modJUNewsUltraHelper::video('http://www.youtube.com/watch?v='. $match[1],'hqthumb') . $imgthr2 ) .'_junus.jpg"'. ($Zoom_Crop == '1' ? ' width="'. $iW .'" height="'. $iH .'"' : '') .' alt="'. strip_tags( $item->title ) .'" />'. $imlink2;
                        } elseif (preg_match($regex2, $junuimgresmatche, $match)) {
                            $item->image = $imlink .'<img src="'. $imgthr . base64_encode( modJUNewsUltraHelper::video('http://vimeo.com/'. $match[2],'hqthumb') . $imgthr2 ) .'_junus.jpg"'. ($Zoom_Crop == '1' ? ' width="'. $iW .'" height="'. $iH .'"' : '') .' alt="'. strip_tags( $item->title ) .'" />'. $imlink2;
                        } elseif( $junuimgsource ) {
                            $item->image = $contentimage;
                        } elseif($params->def('defaultimg', 1) == 1) {
                            $item->image = $blankimage;
                        }
                    } elseif( $junuimgsource ) {
                        $item->image = $contentimage;
                    } elseif($params->def('defaultimg', 1) == 1) {
                        $item->image = $blankimage;
                    }

                } else {
                    $contentimage = $imlink .'<img src="'. $junuimgsource .'" width="'. $imageWidth .'" alt="'. strip_tags( $item->title ) .'" />'. $imlink2;
                    $blankimage = $imlink .'<img src="'. JURI::base().'/media/mod_junewsultra/' . $noimage .'" width="'. $imageWidth .'" alt="'. strip_tags( $item->title ) .'" />'. $imlink2;

                    if($youtube_img_show == 1) {
                        $regex1 = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^>"&?/ ]{11})%i';
                        $regex2 = '#(player.vimeo.com)/video/([0-9]+)#i';

                        if (preg_match($regex1, $junuimgresmatche, $match)) {
                            $yimg = modJUNewsUltraHelper::video('http://youtu.be/'. $match[1],'hqthumb');
                            $item->image = $imlink .'<img src="'. $yimg .'" width="'. $imageWidth .'" alt="'. strip_tags( $item->title ) .'" />'. $imlink2;
                        } elseif (preg_match($regex2, $junuimgresmatche, $match)) {
                            $yimg = modJUNewsUltraHelper::video('http://vimeo.com/'. $match[2],'hqthumb');
                            $item->image = $imlink .'<img src="'. $yimg .'" width="'. $imageWidth .'" alt="'. strip_tags( $item->title ) .'" />'. $imlink2;
                        } elseif( $junuimgsource ) {
                            $item->image = $contentimage;
                        } elseif($params->def('defaultimg', 1) == 1) {
                            $item->image = $blankimage;
                        }
                    } elseif( $junuimgsource ) {
                        $item->image = $contentimage;
                    } elseif($params->def('defaultimg', 1) == 1) {
                        $item->image = $blankimage;
                    }
                }
            }

            // introtext
            if ($clear_tag == 1) {
                $item->introtext = preg_replace('/{([a-zA-Z0-9\-_]*)\s*(.*?)}/i', '', $item->introtext);
                $item->introtext = str_replace( '&nbsp;', ' ', $item->introtext );
                $item->introtext = strip_tags( $item->introtext );
            } else {
                $item->introtext = preg_replace('/{([a-zA-Z0-9\-_]*)\s*(.*?)}/i', '', $item->introtext);
                $item->introtext = preg_replace('/<img(.*?)>/i', '', $item->introtext);
            }

            if ($li==1) {

                if ($lmttext==1) {
                    $item->introtext = trim(implode(" ", array_slice(explode(" ", $item->introtext), 0, $introtext_limit)));
                } else {
                    $item->introtext = trim(JString::substr($item->introtext, 0, $introtext_limit));
                }

                if (!preg_match('#(\.|\?|\!)$#ismu', $item->introtext)) {
                    $item->introtext = preg_replace('#^\s?(\,|\;|\:|\-)#ismu', '', $item->introtext);
                    $item->introtext = $item->introtext . '...';
                }

            } else {
                $item->introtext = $item->introtext;
            }

            // author
            if ($params->def('juauthor') == 1) {
                if ( $item->created_by_alias )
                {
				    $item->author = $item->created_by_alias;
			    } else {
				    $item->author = $item->author;
			    }
            }

            // date
            if ($params->get('show_date') == 1) {
                //$item->date   = JHTML::_('date', $item->created, $data_format );
                $item->date   = JHtml::date($item->created, $data_format);
                $item->df_d   = JHtml::date($item->created, $df_d);
                $item->df_m   = JHtml::date($item->created, $df_m);
                $item->df_y   = JHtml::date($item->created, $df_y);
            }

            // hits
            if ($params->get('showHits') == 1) {
                $item->hits   = $item->hits;
            }

            // hits
            if ($params->get('showRating') == 1) {
                $template     = str_replace('_:', '', $params->def('template'));

    			$img = '';
    			$starImageOn  = JHTML::_('image.site', 'modules/mod_junewsultra/tmpl/'.$template.'/images/rating_star.png', null);;
    			$starImageOff = JHtml::_('image.site','modules/mod_junewsultra/tmpl/'.$template.'/images/rating_star_blank.png', NULL, NULL, true);

    			for ($i=0; $i < $item->rating; $i++) {
    				$img .= $starImageOn;
    			}
    			for ($i=$item->rating; $i < 5; $i++) {
    				$img .= $starImageOff;
    			}

    			$item->rating  = $img;

            }
		}

		return $items;
	}

    /*
    * parse_video() PHP function
    * Author: takien
    * URL: http://takien.com
    *
    * Author: takien, slaffko
    * URL: http://takien.com, http://slaffko.name
    */

    function video($url,$return='embed',$width='',$height='',$rel=0){
        $urls = parse_url($url);

        //url is http://vimeo.com/xxxx
        if($urls['host'] == 'vimeo.com'){
            $vid = ltrim($urls['path'],'/');
        }
        //url is http://youtu.be/xxxx
        else if($urls['host'] == 'youtu.be'){
            $yid = ltrim($urls['path'],'/');
        }
        //url is http://www.youtube.com/embed/xxxx
        else if(strpos($urls['path'],'embed') == 1){
            $yid = end(explode('/',$urls['path']));
        }
         //url is xxxx only
        else if(strpos($url,'/')===false){
            $yid = $url;
        }
        //http://www.youtube.com/watch?feature=player_embedded&v=m-t4pcO99gI
        //url is http://www.youtube.com/watch?v=xxxx
        else{
            parse_str($urls['query']);
            $yid = $v;
            if(!empty($feature)){
                $yid = end(explode('v=',$urls['query']));
                $arr = explode('&',$yid);
                $yid = $arr[0];
            }
        }
      if($yid) {

        //return embed iframe
        if($return == 'embed'){
            return '<iframe width="'.($width?$width:560).'" height="'.($height?$height:349).'" src="http://www.youtube.com/embed/'.$yid.'?rel='.$rel.'" frameborder="0" ebkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
        }
        //return normal thumb
        else if($return == 'thumb' || $return == 'thumbmed'){
            return 'http://i1.ytimg.com/vi/'.$yid.'/default.jpg';
        }
        //return hqthumb
        else if($return == 'hqthumb' ){
            return 'http://i1.ytimg.com/vi/'.$yid.'/hqdefault.jpg';
        }
        // else return id
        else{
            return $yid;
        }
      }
      else if($vid) {
      $vimeoObject = json_decode(file_get_contents("http://vimeo.com/api/v2/video/".$vid.".json"));
       if (!empty($vimeoObject)) {
          //return embed iframe
          if($return == 'embed'){
          return '<iframe width="'.($width?$width:$vimeoObject[0]->width).'" height="'.($height?$height:$vimeoObject[0]->height).'" src="http://player.vimeo.com/video/'.$vid.'?title=0&byline=0&portrait=0" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
        }
        //return normal thumb
        else if($return == 'thumb'){
          return $vimeoObject[0]->thumbnail_small;
        }
        //return medium thumb
        else if($return == 'thumbmed'){
          return $vimeoObject[0]->thumbnail_medium;
        }
        //return hqthumb
        else if($return == 'hqthumb'){
          return $vimeoObject[0]->thumbnail_large;
        }
        // else return id
        else{
          return $vid;
        }
       }
      }
    }
}