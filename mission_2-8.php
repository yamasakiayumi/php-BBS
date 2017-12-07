<?php

$dsn = 'データベース名';

$user = 'ユーザ名';
$password = 'パスワード';

try{
	$pdo = new PDO($dsn, $user, $password);

	$sql = "CREATE TABLE IF NOT EXISTS member
		(
			id int AUTO_INCREMENT,
			urltoken VARCHAR(128),
			date DATETIME ,
			account VARCHAR(50) ,
			mail VARCHAR(50) NOT NULL,
			userid VARCHAR(20),
			password VARCHAR(128) ,
			flag TINYINT(1) NOT NULL DEFAULT 0,
			PRIMARY KEY(ID)
		)AUTO_INCREMENT = 1000;";
	$result = $pdo->query($sql);

}
catch(PDOException $e){
	print('エラーが発生しました。:'.$e->getMessage());
	die();
}
?>