<?php
session_start();

?>

<!DOCTYPE html>
<html lang ="ja">
<head>
<meta charset = "UTF-8">
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<title>カスタム開発部</title>
<div class="container">
<b>ログイン</b><br /><br />
<form action="mission_3-10_login.php" method="post">
<ul>
	<li class="id">
	<label for="id">ID</label>
	<input type="text" name="userid" size="4"></li>
	<li class="pass">
	<label for="pass">password</label>
	<input type = "password" name = "usrpass" size="4"></li>
	<li class="submit">
	<input type="submit" name="submit" value="ログイン"></li>
</form>
<br />
<a href="url">新規登録</a>
</div>
</body>
</html>
<?php
$userid = htmlspecialchars($_POST['userid']);
$usrpass = htmlspecialchars($_POST['usrpass']);
$dsn = 'データベース名';
$user = 'ユーザ名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password);

$sql = "SELECT * FROM member WHERE userid = '$userid'";
$result = $pdo->query($sql);
$loginpass = $result->fetchAll();
$loginpass = $loginpass[0]['password'];

$_SESSION['id'] = $userid;
$_SESSION['pass'] = $usrpass;

if(isset($_POST['submit'])){
	if($loginpass == $_SESSION['pass']){
		header("Location: mission_3-10_main.php");
		exit();
	} else{
	echo "IDまたはパスワードが正しくありません。";
	}
}
?>