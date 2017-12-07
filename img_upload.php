<!DOCTYPE html>
<html lang ="ja">
<HEAD>
	<meta charset="UTF-8">
	<title>画像</title>
</HEAD>
<BODY>
<FORM method="POST" enctype="multipart/form-data" action="img_upload.php">
	<P>画像</P>
	アップロード：<INPUT type="file" name="upfile" size="30"><BR>
	<INPUT type="submit" name="submit" value="送信">
</FORM>

<?php

try{
	if (count($_POST) > 0 && isset($_POST["submit"])){
		$upfile = $_FILES["upfile"]["tmp_name"];
		if ($upfile==""){
			print("ファイルのアップロードができませんでした。<BR>");
			exit;
		}

		// ファイル取得
		$imgdat = file_get_contents($upfile);

		$mime = shell_exec('file -bi '.escapeshellcmd($upfile));
		$mime = trim($mime);
		$mime = preg_replace("/ [^ ]*/", "", $mime);

		// DB接続
		$dsn = 'データベース名';
		$user = 'ユーザ名';
		$password = 'パスワード';
		$dbLink = new PDO($dsn, $user, $password);

		// データ追加
		$sql = "INSERT INTO IMAGES2 (IMG,MIME) VALUES (?,?)";

		$result = $dbLink -> prepare($sql);
		$result ->execute(array($imgdat, $mime));



		print("登録が終了しました<BR>");
		$sql = 'SELECT * FROM IMAGES2';
		$result = $dbLink -> query($sql);

		foreach($result as $row){
			echo $row['ID'].$row['MIME'].' ';
		}	
	}
}
catch(PDOException $e){

	print("SQLの実行に失敗しました<BR>");
	print($e->getMessage()."<BR>");
	die();
}
	?>
	</BODY>
	</HTML>