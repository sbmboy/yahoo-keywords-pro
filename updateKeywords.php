<?php
if(isset($_POST['ids'])){
  $db=new SQLite3('db.db3',SQLITE3_OPEN_READWRITE);
  $db->exec("begin exclusive transaction");
  foreach ($_POST['ids'] as $key => $value) {
    $sql="UPDATE keywords SET status = '".$db->escapeString($value)."' WHERE rowid = ".intval($key);
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
  <title>筛选关键词</title>
</head>
<body>
<h1>筛选关键词</h1>
<ul>
  <li><a href="./index.php">首页</a></li>
  <li>处理关键词</li>
  <li>筛选关键词</li>
</ul>
<form method="post">
  <table border="1" cellspacing="0" cellpadding="6" bordercolor=#cccccc>
    <tr>
      <th>关键词</th>
      <th>翻译</th>
      <th>类型</th>
      <th>保留</th>
      <th>辅助</th>
    </tr>
  <?php
  $db=new SQLite3('db.db3',SQLITE3_OPEN_READONLY);
  $sql="SELECT rowid,keywords,translate,types FROM keywords WHERE status = 'pending' ORDER BY length ASC LIMIT 0,20";
  $result=$db->query($sql);
  while($row=$result->fetchArray(SQLITE3_ASSOC)){
    echo "<tr><td>{$row['keywords']}</td>";
    echo "<td>{$row['translate']}</td>";
    echo "<td>{$row['types']}</td>";
    echo '<td><label><input type="radio" name="ids['.$row['rowid'].']" value="waiting"> Yes</label>
    <label><input type="radio" name="ids['.$row['rowid'].']" value="trash" checked> No</label></td>';
    echo '<td><a href="https://www.google.com/search?q='.urlencode($row['keywords']).'&tbm=isch" target="_blank">Img</a>
    <a href="https://www.google.com/search?q='.urlencode($row['keywords']).'" target="_blank">Web</a>
    <a href="https://translate.google.cn/#auto/zh-CN/'.urlencode($row['keywords']).'" target="_blank">翻译</a></td></tr>';
  }
  $db->close(); // close datebase
  ?>
  </table>
  <input type="submit" value="submit">
</form>
</body>
</html>
