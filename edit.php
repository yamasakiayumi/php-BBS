<?php
$filename = 'ファイル名';
$fp = fopen($filename, 'r');

$count = count(file($filename)) + 1;
$num = intval(htmlspecialchars($_POST["edno"])); // 整数に変換
$passed = htmlspecialchars($_POST["passed"]);

if ($count == 1) {
    echo "データが登録されていません";
    fclose($fp);
    exit;
}

if (!$num) {
    echo "不正な値です";
    fclose($fp);
    exit;
}

$lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$s = explode("<>", $lines[$num - 1]);
if ($s[4] == $passed) {
	$str1 = $s[1] . " " . $s[2];
?>

<!DOCTYPE html>
<html lang ="ja">
    <head>
        <meta charset = "UTF-8">
    </head>
    <body>
<title>にっき</title>


<b>にっき</b><br /><br />

<form method="post" action="mission_2-6.php">
　　　名前：<input type="text" name="name" value="<?php echo "$s[1]" ?>"/><br />
　コメント：<input type="text" name="comment" value="<?php echo "$s[2]" ?>" size = "60" /><br />
パスワード：<input type = "password" name = "pass" size="4"><br />
<input type="hidden" id="edit" name="number" value = "<?php echo "$s[0]" ?>"/>
<input type = "submit" name="edit" value = "送信"> 
</form>
<form method="post" action="mission_2-6.php">
削除機能<br />
削除対象番号：<input type="text" name="delno" size="4"><br />
　パスワード：<input type = "password" name = "passdel" size="4"><br />
<input type = "submit" name="delete" value = "削除"><br /><br />
</form>

<form method="post" action="edit.php">
編集機能<br />
編集対象番号：<input type="text" name="edno" size="4"><br />
　パスワード：<input type = "password" name = "passed" size="4"><br />
<input type = "submit" name="edit" value = "編集">
</form>
</body>
</html>

<?php
}
else{
	echo "パスワードが違います。正しいパスワードを入力してください。";
?>
<!DOCTYPE html>
<html lang ="ja">
<head>
<meta charset = "UTF-8">
</head>
<body>
<title>にっき</title>

<form method="post" action="mission_2-6.php">
<b>にっき</b><br /><br />
<form action="mission_2-5.php" method="post">
　　　名前：<input type="text" name="name" ><br />
　コメント：<input type = "text" name ="comment" size="60"><br />
パスワード：<input type = "password" name = "pass" size="4"><br />
<input type="submit" name="write" value="送信"><br /><br />
</form>
<form method="post" action="mission_2-6.php">
削除機能<br />
削除対象番号：<input type="text" name="delno" size="4"><br />
　パスワード：<input type = "password" name = "passdel" size="4"><br />
<input type = "submit" name="delete" value = "削除"><br /><br />
</form>

<form method="post" action="edit.php">
編集機能<br />
編集対象番号：<input type="text" name="edno" size="4"><br />
　パスワード：<input type = "password" name = "passed" size="4"><br />
<input type = "submit" name="edit" value = "編集">
</form>
</body>
</html>

<?php
}
fclose($fp);

?>