<?php

// no direct access
defined('_JEXEC') or die('Restricted access'); 


?>
 <div class="<?=$data['sufix']?>">
 <?
  $locationpage= Jrequest::getVar('view');  
  $locationID= Jrequest::getVar('Itemid');  
	 if (isset($data['id'])){
	 for ($i=0;$i<count($data['id']);$i++){
		  if ($data['id'][$i]==$locationID){
			  $id=$i;
		  }		  
	  }//end for 
	  if (isset($id)){
		  echo $data['text'][$id];
	  }
	  else{
		  echo $data['default'];
	  }
 	}else{
	  echo $data['default'];		
	}

 ?>

 </div>
