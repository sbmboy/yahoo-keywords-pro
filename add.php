<?php
if(isset($_POST['keywords'])&&$_POST['keywords']!=''){
  require_once 'conf/config.php';
  $keywords = explode("\n",trim($_POST['keywords']));
  if(!file_exists('db.db3')) createDatabase('db.db3');
  foreach ($keywords as $key) {
    insertDatabase('db.db3',$key,'add');
  }
  echo '<script>alert("OK");location.href="./index.php"</script>';
}
?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>添加关键词</title>
</head>
<body>
  <h1>添加关键词</h1>
  <ul>
    <li><a href="./index.php">首页</a></li>
    <li>添加关键词</li>
  </ul>
<form action="" method="post">
<textarea name="keywords" rows="8" cols="60"></textarea><br>
<input type="submit" value="submit">
</form>
</body>
</html>
