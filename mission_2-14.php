<?php

$dsn = 'データベース名';

$user = 'ユーザ名';
$password = 'パスワード';

try{
	$pdo = new PDO($dsn, $user, $password);


	$sql = "delete from testtable where id = '111'";
	$result = $pdo -> query($sql);

}
catch(PDOException $e){
	print('エラーが発生しました。:'.$e->getMessage());
	die();
}
?>