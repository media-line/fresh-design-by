<?php
/**
 * $ModDesc
 * 
 * @version		$Id: helper.php $Revision
 * @package		modules
 * @subpackage	mod_lofflashcontent
 * @copyright	Copyright (C) JAN 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>. All rights reserved.
 * @license		GNU General Public License version 2
 */
// no direct access
defined('_JEXEC') or die ('Restricted access');
  
  class JFormFieldItaddrow extends JFormField {
  	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	var	$_name = 'ItAddRow';
	
	function getInput()
	{
		
		$values = $this->value; 
		$name = $this->name;

		$cname =''.$name.'[]';
		
		$id = str_replace("jform_params_","",$this->id);
		if( !is_array($values) && empty($values) ){
			$values = array();
		}
		$values = !is_array($values) ? array($values):$values;
		$row ='	<style>
	
.serty4 ,.serty_2 {width:400px !important;height:40px; clear:both; font-size:12px}	
.serty5 ,.serty_3 {width:350px !important;}	
.serty_4 {width:50px !important}
.serty_3 {clear:both}	
.row {  width:100%; border:1px solid #CCC; position:relative; float:left}
.remove {display: block; float: left; background: url(remove.png) no-repeat; width: 20px; height: 16px; margin-left: 12px;  position:absolute; right:1px}
.serty2 { width:400px !important;clear:both  }
.serty3 {width:400px !important; clear:both }
.nummer ,.nummer2{ float:left}

.title_c { height:20px; background:#f2f2f2; margin:1px 1px 5px 1px; padding:10px 0 0 5px} 
.title_c div{ float:left} 
.title01 { width:242px; margin:0 10px 0 0}
.fut { width:50px; margin:0 5px 0 0; color:#03F}
.row { padding-left:5px !important; margin:0 0 10px 0;}

.flo {float:left; position:relative; top:5px; margin:0 5px;}
.pane-sliders .content {background:none !important;}


#sortable {}
.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default {
background-image:url(/modules/mod_yandexmap/images/fon_add.jpg) !important;
background-position:top !important ;
background-repeat:no-repeat !important;
background-color:#f6f3e0 !important;	}
#module-form legend { background:#247a65 !important }
#sortable { position:relative !important; z-index:10}
.nerow { z-index:100000  !important; position:absolute; background:#FFF !important; top:-122px; left:-5px; box-shadow: 0 0 10px rgba(0,0,0,0.5); /* Параметры тени */}

.fs-form { 
background-image:url(/modules/mod_yandexmap/images/logo.jpg) !important;
background-position:top right !important ;
background-repeat:no-repeat !important;
background-color:#f6f3e0 !important;	}
.lof-fscontainer { background:#fff !important}
				</style>		
  <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
	
  <script>
  jQuery(function() {
    jQuery( "#sortable" ).sortable({
      placeholder: "ui-state-highlight",  opacity: 0.8
    });
    jQuery( "#sortable" ).disableSelection();
  });
  </script>';?>
        <?
		$i=0;
		$c=0;
		$y=1;
		foreach( $values as $key=> $value ){
       if($c==$i) {
		$row.= '<div class="row ui-state-default"><span class="nummer"></span><div class="title01">Координаты метки</div>
		<input type="text" class="serty2"  value="'.$value.'" name="'.$cname.'">';
		$c=$c+2;
		}		
		if($y==$i) {
		
		$row.= '<div class="title01">Описание</div><textarea class="serty3" name="'.$cname.'">'.$value.'</textarea><span class="remove" title="Удалить"></span></div>';
		$y=$y+2;
		
		}			
		$i++;	
		}
		return '<fieldset class="it-addrow-block" id="sortable"><div><span id="btna-'.$id.'" class="add">Add Row</span></div>'.$row.'</fieldset>';
	}
  }

?>
