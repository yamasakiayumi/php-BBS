<?php
// DB接続
$dsn = 'データベース名';
$user = 'ユーザ名';
$password = 'パスワード';
$dbLink = new PDO($dsn, $user, $password);

// 画像データ取得
$sql = ("SELECT * FROM IMAGES2 WHERE ID = '" . $_GET['id']."'");
$result = $dbLink -> query($sql);
$row = $result->fetchAll();

// バイナリデータを直接表示
header( "Content-Type: ".$row[0]['MIME'] );
echo $row[0]['IMG'];
?>