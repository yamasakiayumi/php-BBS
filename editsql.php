<?php
//セッションスタート
session_start();
$postpass = $_SESSION['pass'];

$num = intval(htmlspecialchars($_POST["edno"])); // 整数に変換
$passed = htmlspecialchars($_POST["passed"]);
$dsn = 'データベース名';
$user = 'ユーザ名';
$password = 'パスワード';

//接続処理
try{
	$pdo = new PDO($dsn, $user, $password);

	$sql = "SELECT * FROM cafediary WHERE id = $num";
	$result = $pdo->query($sql);
	$eddata = $result->fetchAll();

	//パスワードがあっていたとき
	if($eddata[0]['pass'] == $passed){
		//名前,コメント,番号をそれぞれ代入
		$edname = $eddata[0]['name'];
		$eddrinkname = $eddata[0]['drinkname'];
		$edcustom = $eddata[0]['custom'];
		$edid = $eddata[0]['id'];
		?>

		<!-- 入力フォームに代入して表示 -->
		<!DOCTYPE html>
		<html lang ="ja">
		<head>
		<meta charset = "UTF-8">
		<link rel="stylesheet" href="style.css" type="text/css">
		</head>
		<body>
		<title>編集</title>
	
		編集内容を入力してください。(画像は添付のやり直しをお願いします。)

		<form method="post" action="mission_3-10_main.php"  enctype="multipart/form-data">
		<ul>
		<li class="name">
		<label for="name">name</label>
		<input type="text" name="name" value="<?php echo "$edname" ?>"></li>
		<li class="drinkname">
		<label for="drinkname">drinkname</label>
		<input type = "text" name ="drinkname" size="60" value="<?php echo "$eddrinkname" ?>"></li>
		<li class="custom">
		<label for="custom">custom</label>
		<input type = "text" name ="custom" size="60" value="<?php echo "$edcustom" ?>"></li>
		<li class="file">
		<label for="file">image/video</label>
		<input type="file" name="upfile"></li>
		<li class="submit">
		<input type="hidden" id="edit" name="ednumber" value = "<?php echo "$edid" ?>"/>
		<input type="hidden" id="edit" name="edpass" value = "<?php echo "$postpass" ?>"/>
		<input type="submit" id="submit" name="edit" value="edit"></li></ul>
		</form>
		</body>
		</html>

<?php
	}
}
catch(PDOException $e){
	print('エラーが発生しました。:'.$e->getMessage());
	die();
}


?>
