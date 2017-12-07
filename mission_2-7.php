<?php

$dsn = 'データベース名';

$user = 'ユーザ名';
$password = 'パスワード';

try{
	$pdo = new PDO($dsn, $user, $password);

}
catch(PDOException $e){
	print('エラーが発生しました。:'.$e->getMessage());
	die();
}
?>