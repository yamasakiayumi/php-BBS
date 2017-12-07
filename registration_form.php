<?php

$dsn = 'データベース名';
$user = 'ユーザ名';
$password = 'パスワード';

try{
session_start();
 
header("Content-type: text/html; charset=utf-8");
 
//データベース接続
$dbh = new PDO($dsn, $user, $password);
 
//エラーメッセージの初期化
$errors = array();
 
if(empty($_GET)) {
	header("Location: registration_mail_form.php");
	exit();
}else{
	//GETデータを変数に入れる
	$urltoken = isset($_GET[urltoken]) ? $_GET[urltoken] : NULL;
	//メール入力判定
	if ($urltoken == ''){
		$errors['urltoken'] = "もう一度登録をやりなおして下さい。";
	}else{
		try{
			//例外処理を投げる（スロー）ようにする
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			//flagが0の未登録者・仮登録日から24時間以内
			$statement = $dbh->prepare("SELECT mail FROM member WHERE urltoken=(:urltoken) AND flag =0 AND date > now() - interval 24 hour");
			$statement->bindValue(':urltoken', $urltoken, PDO::PARAM_STR);
			$statement->execute();
			
			//レコード件数取得
			$row_count = $statement->rowCount();
			
			//24時間以内に仮登録され、本登録されていないトークンの場合
			if( $row_count ==1){
				$mail_array = $statement->fetch();
				$mail = $mail_array[mail];
				$_SESSION['mail'] = $mail;
			}else{
				$errors['urltoken_timeover'] = "このURLはご利用できません。有効期限が過ぎた等の問題があります。もう一度登録をやりなおして下さい。";
			}
			
			//データベース接続切断
			$dbh = null;
			
		}catch (PDOException $e){
			print('Error:'.$e->getMessage());
			die();
		}
	}
}
 
?>
 
<!DOCTYPE html>
<html>
<head>
<title>会員登録画面</title>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<div class="container">
<b>会員登録画面</b>
 
<?php if (count($errors) === 0): ?>
 
<form action="registration_check.php" method="post">
 
<ul>
	<li class="address">
	<label for="address">address</label>
	<?=htmlspecialchars($mail, ENT_QUOTES, 'UTF-8')?></li>
	<li class="name">
	<label for="name">name</label>
	<input type="text" name="account"></li>
	<li class="pass">
	<label for="pass">password</label>
	<input type="text" name="password"></li>
</ul>
 
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
 </div>
</body>
</html>
	<?php
}
catch(PDOException $e){
	print('エラーが発生しました。:'.$e->getMessage());
	die();
}
?>