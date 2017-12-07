<!DOCTYPE html>
<html lang ="ja">
<head>
<meta charset = "UTF-8">
</head>
<body>
<form method="post" action="mission_1-6.php">
<input type ="text" name="form" size = "20"> 
<input type ="submit" value ="送信">
</form>
</body>
</html>


<?php
if(isset($_POST["form"])){  	/*フォームの中身が入力されたときのみ*/
	$form = $_POST["form"];
	$filename = 'ファイル名';
	$fp = fopen($filename, 'a');
	
	fwrite($fp, $form);	/*記入された内容を書き出す*/
	fwrite($fp, "\n");	/*改行*/
	
	fclose($fp);

	echo '「'.$form.'」の書き込みが完了しました。<br />';
}
?>




