<?php

$dsn = 'データベース名';

$user = 'ユーザ名';
$password = 'パスワード';

try{
	$pdo = new PDO($dsn, $user, $password);


	$stmt = $pdo->query('SET NAMES utf8');
	$stmt = $pdo->query('SHOW TABLES');

	foreach($stmt as $re){
		echo $re[0];
		echo '<br />';
	}

}
catch(PDOException $e){
	print('エラーが発生しました。:'.$e->getMessage());
	die();
}
?>