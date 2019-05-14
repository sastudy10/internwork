<?php
  session_start();
 
  header("Content-type: text/html; charset=utf-8");
 
  if ($_POST['token'] != $_SESSION['token']){ 	//CSRF対策
	  echo "不正アクセスの可能性あり";
	  exit();
  }
 
  header('X-FRAME-OPTIONS: SAMEORIGIN');		
    function spaceTrim ($str) {    			
	  $str = preg_replace('/^[ 　]+/u', '', $str);
	  $str = preg_replace('/[ 　]+$/u', '', $str);
	  return $str;
  }
 
  $errors = array();		
 
  if(empty($_POST)) {
	  header("Location:sign up.php");
	  exit();
  }else{
	  $account = isset($_POST['account']) ? $_POST['account'] : NULL;
	  $password = isset($_POST['password']) ? $_POST['password'] : NULL;
	  $password2 = isset($_POST['password2']) ? $_POST['password2'] : NULL;
	
	  $account = spaceTrim($account);
	  $password = spaceTrim($password);
    $password2 = spaceTrim($password2);

	  if(mb_strlen($account)>10):
		  $errors['account_length'] = "アカウントは10文字以内で入力して下さい。";
	  endif;
	
	  if ($password != $password2):
		  $errors['password'] = " 確認用パスワードが間違っています。 ";
	    elseif(!preg_match('/^[0-9a-zA-Z]{5,30}$/', $_POST["password"])):
		    $errors['password_length'] = "パスワードは半角英数字の5文字以上30文字以下で入力して下さい。";
	    else:
		    $password_hide = str_repeat('*', strlen($password));
	  endif;
	
  }
 
if(count($errors) === 0){
	$_SESSION['account'] = $account;
	$_SESSION['password'] = $password;
}

?>
 
<!DOCTYPE html>
<html>
  <head>
    <title>会員登録確認画面</title>
    <meta charset="utf-8">
  </head>
  <body>
    <h1>会員登録確認画面</h1>
 
    <?php if (count($errors) === 0): ?>
 
    <form action="mission_6-1_insert.php" method="post">
 
      <p>メールアドレス：<?=htmlspecialchars($_SESSION['mail'], ENT_QUOTES)?></p>
      <p>アカウント名：<?=htmlspecialchars($account, ENT_QUOTES)?></p>
      <p>パスワード：<?=$password_hide?></p>
 
      <input type="button" value="戻る" onClick="history.back()">
      <input type="hidden" name="token" value="<?=$_POST['token']?>">
      <input type="submit" value="登録する">
 
    </form>
 
    <?php elseif(count($errors) > 0): ?>
 
    <?php
      foreach($errors as $value){
	      echo "<p>".$value."</p>";
      }
    ?>
      
    <form action="sign up.php" method="post">
      <input type="hidden" name="account" value="<?=$account?>">
      <input type="button" value="戻る" onClick="history.back()">
    
    <?php endif; ?>
 
  </body>
</html>
