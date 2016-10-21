<?php
defined('_JEXEC') or die('Restricted access');

class modMlCopyringHelper
{
    function getList(&$params)
    {
        // Получаем значение параметров
		$data=array();
		$data['sufix']=$params->get("moduleclass_sfx");
        $data['default'] = $params->get("default_text");
		//$data['frontpage'] = $params->get("frontpage_text");
		for ($i=0;$i<5;$i++){
			if (($params->get("ID".$i)!="")&&($params->get("text".$i)!="")){
				$data['id'][$i]=(int)$params->get("ID".$i);
				$data['text'][$i]=$params->get("text".$i);
				
			}
			else{
				break;
			}
		}
		return $data;
	}
}
?>


