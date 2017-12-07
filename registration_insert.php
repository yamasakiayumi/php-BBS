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
	 
	if(empty($_POST)) {
		header("Location: registration_mail_form.php");
		exit();
	}
	$mail = $_SESSION['mail'];

	$sql = "SELECT * FROM member WHERE mail = '$mail'";
	$result = $dbh->query($sql);
	$makeid = $result->fetchAll();

	$username = $_SESSION['account'];
	$password =  $_SESSION['password'];
	$userid = "S".$makeid[0]['id'];
	 
	//ここでデータベースに登録する
	try{
		//例外処理を投げる（スロー）ようにする
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		//トランザクション開始
		$dbh->beginTransaction();
		
		//memberテーブルに本登録する
		$sql = "update member set urltoken=NULL,account='$username', userid='$userid', password='$password', flag=1 where mail='$mail'";
		$statement = $dbh->query($sql);
		
		// トランザクション完了（コミット）
		$dbh->commit();
			
		//データベース接続切断
		$dbh = null;
		
		//セッション変数を全て解除
		$_SESSION = array();
		
		//セッションクッキーの削除・sessionidとの関係を探れ。つまりはじめのsesssionidを名前でやる
		if (isset($_COOKIE["PHPSESSID"])) {
	    		setcookie("PHPSESSID", '', time() - 1800, '/');
		}
		
	 	//セッションを破棄する
	 	session_destroy();
	 	
	 	/*登録完了のメールを送信*/
		
	}
	catch (PDOException $e){
		//トランザクション取り消し（ロールバック）
		$dbh->rollBack();
		$errors['error'] = "もう一度やりなおして下さい。";
		print('Error:'.$e->getMessage());
	}
	 
	?>
	 
	<!DOCTYPE html>
	<html>
	<head>
	<title>会員登録完了画面</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="style.css" type="text/css">
	</head>
	<body>
	<div class="container">
	<?php if (count($errors) === 0): ?>
	<b>会員登録完了画面</b>
	 
	<p>登録完了いたしました。<br /></p>
	<?php
	echo $username."さんのIDは".$userid."です。<br />";
	?>
	<p><a href="url">ログイン画面</a></p>
	
	 
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