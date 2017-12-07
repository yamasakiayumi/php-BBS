<!DOCTYPE html>
<html lang ="ja">
<head>
<meta charset = "UTF-8">
</head>
<body>
form.txtの内容を表示します。<br /><br />
</body>
</html>

<?php
$filename = 'ファイル名';


$fp = fopen($filename, 'r');

while (!feof($fp)){
	$form = fgets($fp);

	echo $form;
	echo "<br>";

}

fclose($fp);

?>