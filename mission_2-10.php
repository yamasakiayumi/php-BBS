<?php

$dsn = 'データベース名';

$user = 'ユーザ名';
$password = 'パスワード';

try{
	$pdo = new PDO($dsn, $user, $password);


	$stmt = $pdo->query('SET NAMES utf8');
	$stmt = $pdo->query('SHOW CREATE TABLE member');

	foreach($stmt as $re){
		print_r($re);
	}

}
catch(PDOException $e){
	print('エラーが発生しました。:'.$e->getMessage());
	die();
}
?>