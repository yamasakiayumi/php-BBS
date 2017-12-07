<?php
session_start();
 
header("Content-type: text/html; charset=utf-8");
 
?>
 
<!DOCTYPE html>
<html>
<head>
<title>メール登録画面</title>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<div class="container">
<b>メール登録画面</b>
 
<form action="registration_mail_check.php" method="post">
 
<p>メールアドレス：<input type="text" name="mail" size="50"></p>

<input type="submit" value="登録する">
 
</form>
 </div>
</body>
</html>
