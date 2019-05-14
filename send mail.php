<?php
 require_once("mission_6-1_db.php");
  
 $sql = "CREATE TABLE IF NOT EXISTS preuser"
       ."("
       ."id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,"
       ."urltoken varchar(128) ,"
       ."mail varchar(50) ," 
       ."date  DATETIME,"
       ."flag tinyint(1) NOT NULL DEFAULT'0'" 
       .");";
 $stmt = $pdo->query($sql);
?>

<?php
 session_start();
 
 	header("Content-type: text/html; charset=utf-8");
	header('X-FRAME-OPTIONS: SAMEORIGIN');			
	$_SESSION['token'] = md5(uniqid(rand(),true)) ;       
	$token = $_SESSION['token'];				

?>

<!DOCTYPE html>
<html lang = "ja">
  <head>
    <meta charset="UTF-8">
    <title>仮会員登録</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.css"/>
    <link rel="stylesheet" type="text/css" href="bace.css"/>
  </head>
  <body>
    <div class="box1">
    <form action="mission_6-1_mail check.php" method="post" class="form">
	    <div id="errorMessage"></div>
      <label for="mail">メールアドレス:</label>
     	<input type="text" class="textbox" name="mail" required><br>		
      <input type="hidden"  name="token" value=<?php echo $token; ?>>
   	  <button class="button" type="submit">送信</button>
      </div>
    </form>
</body>
</html>
