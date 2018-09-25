<?php
if(isset($_POST['ids'])&&trim($_POST['ids'])!=''){
  $translate = explode("\n",trim($_POST['translate']));
  $ids = explode(",",trim($_POST['ids']));
  $db=new SQLite3('db.db3',SQLITE3_OPEN_READWRITE);
  $db->exec("begin exclusive transaction");
  for($i=0;$i<count($ids);$i++){
    $sql="UPDATE keywords SET translate = '".$db->escapeString($translate[$i])."' WHERE rowid = ".intval($ids[$i]);
    $result=$db->query($sql);
  }
  $db->exec("end transaction");
  $db->close();
}
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>更新翻译</title>
</head>
<body>
<h1>更新翻译</h1>
<ul>
  <li><a href="./index.php">首页</a></li>
  <li>处理关键词</li>
  <li>更新翻译</li>
</ul>
<ol>
  <?php
  $db=new SQLite3('db.db3',SQLITE3_OPEN_READONLY);
  $sql="SELECT rowid,`keywords` FROM `keywords` WHERE `translate` is NULL ORDER BY length ASC LIMIT 0,50";
  $result=$db->query($sql);
  $ids = array();
  while($row=$result->fetchArray(SQLITE3_ASSOC)){
    echo "<li>{$row['keywords']}</li>";
    $ids [] = $row['rowid'];
  }
  $db->close(); // close datebase
  ?>
</ol>
<form method="post">
  <textarea name="translate" rows="8" cols="60"></textarea><br>
  <input type="hidden" name="ids" value="<?php echo implode(",",$ids); ?>">
  <input type="submit" value="submit">
</form>
</body>
</html>
