<?php
while(true){
  $dbname='db.db3';
  set_time_limit(0);
  require_once 'conf/config.php';
  $words = array(""," a"," b"," c"," d"," e"," f"," g"," h"," i"," j"," k"," l"," m"," n"," o"," p"," q"," r"," s"," t"," u"," v"," w"," x"," y"," z");
  $db=new SQLite3($dbname,SQLITE3_OPEN_READONLY);
  $sql="select rowid,keywords,grade,length from keywords where status = 'waiting' ORDER by length ASC limit 0,1"; // 获取最短的一条记录
  $post=$db->querySingle($sql,true); // 获取 rowid,keywords,grade
  $db->close();
  $keywords = getAlsoTry($post['keywords']);
  foreach ($keywords as $key ) {
    //insertDatabase($dbname="keywords.db3",$keyword,$types,$source=NULL,$grade=0)
    insertDatabase($dbname,$key,'alsoTry',$post['keywords'],$post['grade']);
  }
  stop(3);
  ob_clean();
  ob_start();
  echo implode("<br>",$keywords);
  echo '<br>';
  ob_end_flush();
  ob_flush();
  flush();
  if(isset($post['keywords'])){
    foreach($words as $word){
      //echo '正在处理: '.$post['keywords'].$word."\n";
      $keywords = getCombobox($post['keywords'].$word);
      foreach ($keywords as $key ) {
        insertDatabase($dbname,$key,'Combobox',$post['keywords'].$word,$post['grade']);
      }
      stop(3);
      ob_clean();
      ob_start();
      echo implode("<br>",$keywords);
      echo '<br>';
      ob_end_flush();
      ob_flush();
      flush();
    }
    $db=new SQLite3($dbname,SQLITE3_OPEN_READWRITE);
    $sql = "UPDATE keywords SET status = 'completed' WHERE rowid = {$post['rowid']}";
    @$db->exec($sql);
  	$db->close();
  }else{
    die("数据库中无待扩展关键词，请检查！");
  }
}
?>
