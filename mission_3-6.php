<!DOCTYPE html>
<html lang ="ja">
<head>
<meta charset = "UTF-8">
</head>
<body>
<title>ユーザー登録</title>

<form method="post" action="mission_3-6.php">
<b>ユーザー登録</b><br /><br />
<form action="mission_2-5.php" method="post">
　　　名前：<input type="text" name="usrname" ><br />
パスワード：<input type = "password" name = "pass" size="4"><br />
<input type="submit" name="write" value="送信"><br /><br />
</form>
</body>
</html>

<?php
//変数定義
$usrname = htmlspecialchars($_POST['usrname']);
$pass = htmlspecialchars($_POST["pass"]);
$dsn = 'データベース名';
$user = 'ユーザ名';
$password = 'パスワード';
$count = 0;

//接続処理
try{
	$pdo = new PDO($dsn, $user, $password);
	
	//テーブルがなければ作成する
	$sql = 'CREATE TABLE IF NOT EXISTS user
		(
			id int AUTO_INCREMENT,
			pass varchar(20),
			PRIMARY KEY(id)
		);';
	$result = $pdo->query($sql);

	//sqlに送信された内容を入力
	if(!empty($_POST["usrname"]) && !empty($_POST["pass"])){ 

		$sql = "INSERT INTO user(pass)VALUES(?)";
		$result = $pdo -> prepare($sql);
		$result ->execute(array($pass));
	
	//結果を出力
		$sql = 'SELECT * FROM user';
		$result = $pdo -> query($sql);

		foreach($result as $row){
			$count++;
		}
		
		$sql = "SELECT * FROM user WHERE id=$count";
		$result = $pdo -> query($sql);
		
		echo $usrname."さんの登録が完了しました。<br />";
		foreach($result as $row){
			echo "ID:".$row['id'].'<br />';
			echo "PASSWORD:".$row['pass'].'<br />';
		}	
	}

	else{
		echo "登録情報が正しくありません。正しく入力してください。";
	}
}
	
catch(PDOException $e){
	print('エラーが発生しました。:'.$e->getMessage());
	die();
}

?>
