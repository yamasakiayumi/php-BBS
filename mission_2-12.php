<?php

$dsn = 'データベース名';

$user = 'ユーザ名';
$password = 'パスワード';

try{
	$pdo = new PDO($dsn, $user, $password);


	$sql = 'SELECT * FROM testtable';
	$result = $pdo -> query($sql);

	foreach($result as $row){
		echo $row['id'].',';
		echo $row['name'].'<br>';
	}

}
catch(PDOException $e){
	print('エラーが発生しました。:'.$e->getMessage());
	die();
}
?>