<?php
  session_start();
  header("Content-type: text/html; charset=utf-8");
  require_once("mission_6-1_db.php");

  $sql = "CREATE TABLE IF NOT EXISTS main"
        ."("
        ."id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,"
        ."account varchar(50) ,"
        ."text TEXT," 
        ."remind tinyint(1) NOT NULL DEFAULT'0'" 
        .");";
  $stmt = $pdo->query($sql);

  if (isset($_SESSION["account"])) {
    $account = $_SESSION['account'];
  }

  if(isset($_POST["text"] )){
    if($_POST["remind"] == "yes" ){
      $text = $_POST["text"];
      $remind = "1";

      $sql = $pdo -> prepare("INSERT INTO main (id,account,text,remind) VALUES (:id,:account,:text,:remind)");
        $sql -> bindParam(':id',$id,PDO::PARAM_STR);
        $sql -> bindParam(':account',$account,PDO::PARAM_STR);
        $sql -> bindParam(':text',$text,PDO::PARAM_STR);
        $sql -> bindParam(':remind',$remind,PDO::PARAM_STR);
      $sql -> execute();              

    }else{

        $text = $_POST["text"];
        $remind = "0";

        $sql = $pdo -> prepare("INSERT INTO main (id,account,text,remind) VALUES (:id,:account,:text,:remind)");
          $sql -> bindParam(':id',$id,PDO::PARAM_STR);
          $sql -> bindParam(':account',$account,PDO::PARAM_STR);
          $sql -> bindParam(':text',$text,PDO::PARAM_STR);
          $sql -> bindParam(':remind',$remind,PDO::PARAM_STR);
        $sql -> execute(); 
    }
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <title>メインページ</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.css"/>
    <link rel="stylesheet" type="text/css" href="mission_6-1_main.css"/>
  </head>

  <body>
  <div id="page">

  <header>
  <h1>つれづれメモ</h>

	<?php if($account == ""): ?>
	  
    <form action="mission_6-1_mail To.php" method="post">
 	 	  <button class="button" type="submit">会員登録</button>
	  </form>
	  
    <form action="mission_6-1_login.php" method="post">
	  	<button class="button" type="submit">ログイン</button>
	  </form>
    
    <p>ゲストさん</p>

  <?php elseif($account != ""): ?>
		  <form action="mission_6-1_logout.php" method="post">
		  <button class="button" type="submit">ログアウト</button>
                <?php echo "<p>".htmlspecialchars($account,ENT_QUOTES)."さん</p>"; ?>
	<?php endif; ?>
  </header>


  <div id="main">
    <div id="list">
    <h4>思い出しリスト<br><br></h>
    <ul>
    <?php
      $sql = 'SELECT*FROM main ORDER BY id';
      $results = $pdo -> query($sql);
      foreach($results as $row){
	      $remind = $row['remind'];
	      $text = $row['text'];
      }
      if($remind == '1'){
        $etext = mb_strimwidth($text,0,12,"...");
        echo "▼".$etext;
      }
    ?>
    </ul>
    </div>

  <?php if($account == ""): ?>
    <h2>
    思いついとことをつれづれメモするサイト。<br>
    会員登録でご利用できます。<br>
    </h>
  <?php elseif($account != ""): ?>
    <h2>
    おかえりなさい<?php echo $account."さん";?>。<br>
    ご自由にご利用ください。→
    </h>
    <a href="mission_6-1_toukou.php">新しくメモする</a><br>
  <?php endif; ?>

  <div id="text">
    <h3>みんなのメモ<br><br></h>

    <?php 
	    $sql = 'SELECT*FROM main ORDER BY id';
	    $results = $pdo -> query($sql);
	    foreach($results as $row){
		    if($row['text'] != ""){
	        echo "<div id='tt'>".$row['text']."<br></div>" ;
        }
      }
    ?>

  </div>
  </div>
  </div>

</div>
</body>
</html>
