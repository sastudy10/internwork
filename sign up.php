<?php 
  session_start();
  header("Content-type: text/html; charset=utf-8");  	
  $_SESSION['token'] = md5(uniqid(rand(),true)) ;
  $token = $_SESSION['token'];
 
  header('X-FRAME-OPTIONS: SAMEORIGIN');  	
  require_once("db.php");        	
  $errors = array();    				
 
  if(empty($_GET)) {
    echo "トークンエラー";	
    exit();
  }else{
    $urltoken = isset($_GET[urltoken]) ? $_GET[urltoken] : NULL;		
  
    if ($urltoken == ''){
      $errors['urltoken'] = "もう一度登録をやりなおして下さい。";
    }else{
  
      try{
   	    $sql = 'SELECT * FROM preuser';
	      $results = $pdo->query($sql); 		
       
        foreach($results as $row){
          $ntime = strtotime("now");		
          $ctime = strtotime($row['date']);       
        }  
          
          if($row['urltoken'] == $urltoken && $row['flag'] == '0' && $ntime - $ctime <= '86400'){ 
          $mail = $row['mail'];
	        $_SESSION['mail'] = $mail;
         
          }else{
	          $errors['urltoken_timeover'] = "このURLはご利用できません。有効期限が過ぎた等の問題があります。もう一度登録をやりなおして下さい。";
          }  
          $dbh = null;
			
      }catch (PDOException $e){
        print('Error:'.$e->getMessage());
        die();
      
      }	//try & catch
    }	//$urltoken == '' or $urltoken==$row['urltoken']
  }	//$_GET[urltoken] or empty($_GET)


?>
 
<!DOCTYPE html>
<html>
  <head>
    <title>会員登録画面</title>
    <meta charset="utf-8">
  </head>
  <body>
    <h1>会員登録画面</h1>
 
    <?php if (count($errors) === 0): ?>
 
    <form action="mission_6-1_sign upcheck.php" method="post">
 
      <p>メールアドレス：<?=htmlspecialchars($mail, ENT_QUOTES, 'UTF-8')?></p>
      <p>アカウント名：<input type="text" name="account" value="<?= $_POST['account']?>" required></p>
      <p>パスワード：<input type="password" name="password" required></p>
      <p>パスワード確認用：<input type="password" name="password2" required></p>
 
      <input type="hidden" name="token" value="<?=$token?>">
      <input type="submit" value="確認する">
 
    </form>
 
    <?php elseif(count($errors) > 0): ?>
      <?php
        foreach($errors as $value){
	        echo "<p>".$value."</p>";
        }
      ?>
    <?php endif; ?>
 </body>
</html>
