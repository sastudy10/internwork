<?php
  session_start();
  header("Content-type: text/html; charset=utf-8");
 
  if ($_POST['token'] != $_SESSION['token']){		
    echo "不正アクセスの可能性があります";
    exit();
  }
  
	header('X-FRAME-OPTIONS: SAMEORIGIN');		
	require_once("db.php");		
	$errors = array();				

	$mail = isset($_POST['mail']) ? $_POST['mail'] : NULL;
      	$date = date('Y/m/d G:i:s');


  if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $mail)){
    $errors['mail_check'] = "メールアドレスの形式が正しくありません。";
  }else{
    $sql = 'SELECT*FROM user'; 
    $results = $pdo -> query($sql);
    
    foreach($results as $row){
      if($row['mail'] == $mail){
        $errors['member_check'] = "このメールアドレスはすでに利用されております。";
      }	//if
    }	//foreach
  }	//if & else


  if(count($errors) === 0){
	
	  $_SESSION['urltoken'] = hash('sha256',uniqid(rand(),1));
    $urltoken = $_SESSION['urltoken'] ;
  	$url = "http://tt-02.99sv-coco.com/mission_6-1_signup.php"."?urltoken=".$urltoken;
    $flag = "0";

    $sql = $pdo -> prepare("INSERT INTO preuser (id,mail,date,flag,urltoken) VALUES (:id,:mail,:date,:flag,:urltoken)");
      $sql -> bindParam(':id',$id,PDO::PARAM_STR);
      $sql -> bindParam(':mail',$mail,PDO::PARAM_STR);
      $sql -> bindParam(':date',$date,PDO::PARAM_STR);
      $sql -> bindParam(':flag',$flag,PDO::PARAM_STR) 
      $sql -> bindParam(':urltoken',$urltoken,PDO::PARAM_STR);
    $sql->execute();
			
    $mailTo = $mail;
    $returnMail = $mail;  	
 
	  $name = "つれづれメモ　登録確認メール";
    $mail = $_POST['mail'];
	  $subject = "ミッション確認";
 
    $body = <<< EOM
    24時間以内に下記のURLからご登録下さい。
    {$url}
    EOM;
 
	  mb_language('ja');
	  mb_internal_encoding('UTF-8');
 
	  $header = 'From: ' . mb_encode_mimeheader($name). ' <' . $mail. '>';
 
	  if (mb_send_mail($mailTo, $subject, $body, $header, '-f'. $returnMail)) {
	
	 	  $_SESSION = array();
	
		
		  if (isset($_COOKIE["PHPSESSID"])) {
			  setcookie("PHPSESSID", '', time() - 1800, '/');
		  }
	
      session_destroy();
 	    $message = "メールをお送りしました。24時間以内にメールに記載されたURLからご登録下さい。";
 	  } else {
		  $errors['mail_error'] = "メールの送信に失敗しました。";
	  }	
  }
 
?>
 
<!DOCTYPE html>
<html>
  <head>
    <title>メール確認画面</title>
    <meta charset="utf-8">
  </head>
  <body>
    <h1>メール確認画面</h1>
 
      <?php if (count($errors) === 0): ?>
        <p><?=$message?></p>
        <?php elseif(count($errors) > 0): ?>
 
        <?php
          foreach($errors as $value){
	          echo "<p>".$value."</p>";
          }
        ?>
      
        <input type="button" value="戻る" onClick="history.back()">
      <?php endif; ?>
 
  </body>
</html>
