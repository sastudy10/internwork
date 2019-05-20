<?php
 	session_start();
 	header("Content-type: text/html; charset=utf-8");
 	require_once("db.php");

 	$sql = "CREATE TABLE IF NOT EXISTS main"
      ."("
      ."id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,"
      ."account varchar(50) ,"
      ."text TEXT,"
      ."range tinyint(1) NOT NULL DEFAULT'0'"
      .");";
 	$stmt = $pdo->query($sql);

	if (isset($_SESSION["account"])) {
		$account = $_SESSION['account'];
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>メインページ</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="./css/index.css">
	</head>
	<body>

    <?php if($account == ""): ?>
	<header>
	<ul>
      <li class="link"><a href="#">会員登録</a></li>
	  <li class="link"><a href="#">ログイン</a></li>
	  <li>ゲストさん</li>
	</ul>
	</header>

	<?php elseif($account != ""): ?>
	<header>
	<ul>
      <li class="link"><a href="#">ログアウト</a></li>
      <?php echo "<li>" . htmlspecialchars($account,ENT_QUOTES)."さん</li>"; ?>
	</ul>
	</header>
	<aside>
		<h1><a href="mymemo.php">あなたのメモ </a>a></h1>
		<ul>
		<?php
        $sql = 'SELECT*FROM main ORDER BY id';
        $results = $pdo -> query($sql);
        foreach($results as $row){
            $ac = $row['ac'];
            $range = $row['range'];
            $text = $row['text'];
        }
        if($ac == $account){
        if($range == '0'){
            $etext = mb_strimwidth($text,0,12,"...");
            echo "<li>".$etext."</li>";
        }}
        ?>
	</ul>
	</aside>
	<div id="main">
		<h2> 入力フォーム </h2>

	 	<form action="post_check.php" method="post">
		<textarea name="comment" cols="100" rows="10" required></textarea><br>
   		<input type="hidden" name ="account"  value=<?php echo $account ; ?> >
   		<input type="radio" name="range" value="mine"checked/>非公開
   		<input type="radio" name="range" value="public">公開
   		<input type="submit"  value="メモをする">
  		</form>
	<?php endif; ?>
		<h3>みんなのメモ</h3>
	<?php
	  $sql = 'SELECT*FROM main ORDER BY id';
	  $results = $pdo -> query($sql);
	 foreach($results as $row){
		if($row['text'] != ""){
		if($row['range'] == "1"){
		$ytext = $row['text'];
		echo "<div id='tt'>" . nl2br($ytext) ."</div>" ;
        }}
	 }
?>

	</div>


</body>
</html>
