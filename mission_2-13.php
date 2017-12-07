<?php

$dsn = 'データベース名';

$user = 'ユーザ名';
$password = 'パスワード';

try{
	$pdo = new PDO($dsn, $user, $password);


	$sql = "update testtable set name='tanaka' where id = '110'";
	$result = $pdo -> query($sql);

}
catch(PDOException $e){
	print('エラーが発生しました。:'.$e->getMessage());
	die();
}
?>