<?php
header( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
header( 'Last-Modified: '.gmdate( 'D, d M Y H:i:s' ).' GMT' );

// HTTP/1.1
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', FALSE );

// HTTP/1.0
header( 'Pragma: no-cache' );
// DB接続
$dsn = 'データベース名';
$user = 'ユーザ名';
$password = 'パスワード';
$dbLink = new PDO($dsn, $user, $password);

// 画像データ取得
$sql = ("SELECT * FROM cafediary WHERE id = '" . $_GET['id']."'");
$result = $dbLink -> query($sql);
$row = $result->fetchAll();

// バイナリデータを直接表示
header( "Content-Type: ".$row[0]['MIME'] );
echo $row[0]['IMG'];
?>