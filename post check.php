<?php
session_start();
   header("Content-type: text/html; charset=utf-8");
   require_once("db.php");
   $errors = array();

 $sql = "CREATE TABLE IF NOT EXISTS main"
      ."("
      ."id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,"
      ."account varchar(50) ,"
      ."text TEXT,"
      ."range tinyint(1) NOT NULL DEFAULT'0'"
      .");";
 $stmt = $pdo->query($sql);


// ログイン状態のチェック
if (isset($_SESSION["account"])) {
$account = $_SESSION['account'];
}else{
$errors['account'] = "セッションの期限が切れています";
}

if(count($errors) === 0){
 if(empty($_POST)) {
	  header("Location:index.php");
	  exit();
  }else{
    $text = $_POST["text"];
    $ac = $_POST["account"];
    if($ac = $account){
      if($_POST["range"] == "public" ){
        $range = "1";

        $sql = $pdo -> prepare("INSERT INTO main (id,account,text,remind) VALUES (:id,:account,:text,:remind)");
          $sql -> bindParam(':id',$id,PDO::PARAM_STR);
          $sql -> bindParam(':ac',$ac,PDO::PARAM_STR);
          $sql -> bindParam(':text',$text,PDO::PARAM_STR);
          $sql -> bindParam(':range',$range,PDO::PARAM_STR);
        $sql -> execute();              

      }else{
        $rande = "0";

        $sql = $pdo -> prepare("INSERT INTO main (id,account,text,remind) VALUES (:id,:account,:text,:remind)");
          $sql -> bindParam(':id',$id,PDO::PARAM_STR);
          $sql -> bindParam(':ac',$ac,PDO::PARAM_STR);
          $sql -> bindParam(':text',$text,PDO::PARAM_STR);
          $sql -> bindParam(':range',$range,PDO::PARAM_STR);
        $sql -> execute(); 
      }
    }else{$errors['account'] = "アカウントが一致しません。";
  }
  }
}

?>

<!DOCTYPE html>
<html>
  <head>
    <title>投稿確認画面</title>
    <meta charset="utf-8">
	<link rel="stylesheet" href="https...css"/>
 	<link rel="stylesheet" type="text/css" href="main.css"/>
  </head>
  <body>
  <?php if(count($errors) == 0): ?>

    <p>投稿しました</p>
    echo "<div id='tt'>".$_POST['text']."<br></div>";

 
  <?php elseif(count($errors) > 0): ?>
 
   <?php
      foreach($errors as $value){
	      echo "<p>".$value."</p>";
      }
    ?>
  <?php endif; ?>
    <a href = "index.php">メインページへ</a>
 
  </body>
  </html>
