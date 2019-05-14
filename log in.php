<?php
  session_start();
  require_once("mission_6-1_db.php");
  $sql = 'SELECT*FROM user ORDER BY id';
  $results = $pdo -> query($sql);
  foreach($results as $row){
    echo $row['id'].',';
    echo $row['account'].',';
    echo $row['password'].'<br>' ;
  }

  header("Content-type: text/html; charset=utf-8");

  $_SESSION['token'] = md5(uniqid(rand(),true)) ; 	
  $token = $_SESSION['token']; 			
 
  header('X-FRAME-OPTIONS: SAMEORIGIN'); 		
 
?>
 
<!DOCTYPE html>
<html>
  <head>
    <title>ログイン画面</title>
    <meta charset="utf-8">
  </head>

  <body>
    <h1>ログイン画面</h1>
 
    <form action="mission_6-1_logincheck.php" method="post">
 
      <p>アカウント：<input type="text" name="account" size="50"></p>
      <p>パスワード：<input type="text" name="password" size="50"></p>
 
      <input type="hidden" name="token" value="<?=$token?>">
      <input type="submit" value="ログインする">
 
    </form>
    <a haref="sign up.php">新規登録はこちら</a>

  </body>
</html>
