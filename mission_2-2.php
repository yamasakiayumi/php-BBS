<!DOCTYPE html>
<html lang ="ja">
<head>
<meta charset = "UTF-8">
</head>
<body>
<title>日々スタバ</title>
<!-- mission1 -->
<form method="post" action="mission_2-2.php">
<b>日々スタバ</b><br /><br />
　　名前：<input type ="text" name="name" size = "20"><br />
コメント：<input type = "text" name ="comment" size="60"><br />
<input type ="submit" value ="送信">
</form>
</body>
</html>

<?php
//mission2
if(isset($_POST["name"]) && isset($_POST["comment"])){ 

	$name = $_POST["name"];
	$comment = $_POST["comment"];

	$filename = 'ファイル名';
	//ファイルがなければ番号を1にする
	if(file_exists($filename)){
		$count = count( file($filename) );
		$count++;
	}
	//それ以外なら書き込む前の行数を読み込んで＋１する
	else{
		$count = 1;
	}

	$fp = fopen($filename, 'a');
//記入された内容を書き出す
	fwrite($fp, $count."<>".$name."<>".$comment."<>".date('Y年m月d日 h時i分')."\n");	

	fclose($fp);
}

?>


