<?php
session_start();
$id = $_SESSION['id'];
$pass = $_SESSION['pass'];

echo $id;
echo $pass;

?>

<!DOCTYPE html>
<html lang ="ja">
<head>
<meta charset = "UTF-8">
</head>
<body>
<title>にっき</title>

<form method="post" action="mission_3-10_login.php">
<b>ログイン</b><br /><br />
<form action="mission_2-5.php" method="post">
　　　ID：<input type="text" name="id" size="4" value ="<?php echo "$id"?>"><br />
パスワード：<input type = "password" name = "usrpass" size="4" value ="<?php echo "$pass"?>"><br />
<input type="submit" name="write" value="ログイン"><br /><br />
</form>
<br />
<a href="url">新規登録</a>
</body>
</html>
<?php
$id = htmlspecialchars($_POST['id']);
$usrpass = htmlspecialchars($_POST['usrpass']);
$dsn = 'データベース名';
$user = 'ユーザ名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password);

$sql = "SELECT * FROM member WHERE userid = $id";
$result = $pdo->query($sql);
$logindata = $result->fetchAll();
$loginpass = $logindata[0]['password'];

if($loginpass == $usrpass){
	header("Location: mission_3-8_main.php");
	exit();
} else{
	echo "IDまたはパスワードが正しくありません。";
}
?>