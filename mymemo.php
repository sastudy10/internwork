<?php
session_start();
header("Content-type: text/html; charset=utf-8");
require_once("db.php");


$stmt = $pdo->query($sql);
 // ログイン状態のチェック
if (isset($_SESSION["account"])){
$account = $_SESSION['account'];
}
?>

<!DOCTYPE html>
<html>
  <head>
		<title>メインページ</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="https...css"/>
 		<link rel="stylesheet" type="text/css" href="main.css"/>
	</head>
	<body>
    <?php
    $sql = 'SELECT*FROM main ORDER BY id';
    $results = $pdo -> query($sql);
    foreach($results as $row){
      if($row['text'] != ""){
      if($row['range'] == "0"){
      if($row['ac'] == $account ){
            $text = $row['text'];
            echo "<div id='tt'>" . nl2br($text) ."</div>" ;
      }}}
    }
    ?>
  </body>
</html>
?>
