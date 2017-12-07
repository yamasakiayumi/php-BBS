
<?php
//mission2-2
if(!empty($_POST["name"]) && !empty($_POST["comment"]) && isset($_POST["write"]) && !isset($_POST["id"])){ 

	$name = $_POST['name'];
	$comment = $_POST['comment'];

	$filename = 'ファイル名';
	//ファイルがあれば書き込む前の行数を読み込んで＋１する
	if(file_exists($filename)){
		$count = count( file($filename) );
		$count++;
	}
	//ファイルがなければ番号を1にする
	else{
		$count = 1;
	}

	$fp = fopen($filename, 'a');
//記入された内容を書き出す
	fwrite($fp, $count."<>".$name."<>".$comment."<>".date('Y年m月d日 h時i分')."\n");	

	fclose($fp);
}


//mission2-4
if(isset($_POST["delete"]) && !empty($_POST["delno"])){
	//ファイルから読み込んで配列に格納
	$filedel = file('mission2.txt');
	//削除する番号を取得
	$num = $_POST['delno'];
	//削除する行を配列から消去
	array_splice($filedel,$num - 1, 1, "削除されました\n");
	//ファイルに書き込み
	file_put_contents('mission2.txt', $filedel);
}
//hiddenが入力されていれば
if(isset($_POST["number"])){
	$filename = 'mission2.txt';

	$fp = fopen($filename, 'a');   // ファイルの追記には'a'を指定する

	$count = count(file($filename)) + 1;
	$name = $_POST["name"];
	$comment = $_POST["comment"];
	$num = intval(htmlspecialchars($_POST["number"])); // 整数に変換

	$lines = file($filename);

	foreach ($lines as $key => $value) {
	    $s = explode("<>", $value);
	    if ($s[0] == $num) {
	        $lines[$key] = $num . "<>" . $name . "<>" . $comment . "<>" . date('Y年m月d日 h時i分');
	        break;
	    }
	}
	fclose($fp);

	file_put_contents('mission2.txt', implode("\n", $lines));

	echo $num . "番のデータを更新しました<br />";

}




?>
<!DOCTYPE html>
<html lang ="ja">
<head>
<meta charset = "UTF-8">
</head>
<body>
<title>にっき</title>

<form method="post" action="mission_2-5.php">
<b>にっき</b><br /><br />
<form action="mission_2-5.php" method="post">
　　名前：<input type="text" name="name" ><br />
コメント：<input type = "text" name ="comment" size="60"><br />
<input type="submit" name="write" value="送信">
</form>
<form method="post" action="mission_2-5.php">
削除機能<br />
削除対象番号：<input type="text" name="delno" size="4">
<input type = "submit" name="delete" value = "削除"><br /><br />
</form>

<form method="post" action="edit.php">
編集機能<br />
編集対象番号：<input type="text" name="edno" size="4">
<input type = "submit" name="edit" value = "編集">
</form>
</body>
</html>
<?php
//mission2-3
//ファイルから読み込んで配列に格納
if(file_exists($filename)){ 
	$contents = file($filename);
	foreach($contents as $content){
		//「<>」で分けて違う配列に格納
		$parts = explode("<>", $content);
		foreach($parts as $part){
			//表示させる
			echo $part." ";
		}
		echo "<br />";
	}

}

