<?php
session_start();
$postpass = $_SESSION['pass'];
$id = htmlspecialchars($_POST['id']);
$usrpass = htmlspecialchars($_POST['usrpass']);
$dsn = 'データベース名';
$user = 'ユーザ名';
$password = 'パスワード';
try{
	$pdo = new PDO($dsn, $user, $password);
?>
	<!DOCTYPE html>
	<html lang ="ja">
	<head>
	<meta charset = "UTF-8">
	</head>
	<body>
	<title>カスタム開発部</title>

	<form method="post" action="mission_3-8_main.php" enctype="multipart/form-data">
	<b>カスタム開発部</b><br /><br />
	　　　name　<input type="text" name="name"><br />
	　drinkname　<input type = "text" name ="drinkname" size="60"><br />
	　 custom　<input type = "text" name ="custom" size="60"><br />
	image/video　<input type="file" name="upfile"><br />
	<input type = "hidden" name = "pass" value="<?php echo "$postpass" ?>" >
	<input type="submit" name="write" value="送信"><br /><br />
	</form>
<br /><br />

	<a href="url">←戻る</a>
	<br /><br />

	</body>
	</html>

	<?php
	//変数定義
	$name = htmlspecialchars($_POST['name']); //名前
	$drinkname = htmlspecialchars($_POST['drinkname']);//ドリンク名
	$custom = htmlspecialchars($_POST['custom']); //カスタム
	$time = date('Y年m月d日 h時i分'); //時間
	$pass = htmlspecialchars($_POST["pass"]); //パスワード
	$upfile = $_FILES["upfile"]["tmp_name"];
	$imgdat = file_get_contents($upfile); //ファイルのバイナリデータ
	//ファイルのタイプ
	$mime = shell_exec('file -bi '.escapeshellcmd($upfile)); 
	$mime = trim($mime);
	$mime = preg_replace("/ [^ ]*/", "", $mime); 

	//テーブルがなければ作成する
	$sql = 'CREATE TABLE IF NOT EXISTS cafediary
		(
			id int AUTO_INCREMENT,
			name varchar(50),
			drinkname varchar(80),
			custom varchar(200),
			time varchar(50),
			pass varchar(20),
			IMG LONGBLOB,
			MIME varchar(20),
			PRIMARY KEY(id)
		);';
	$result = $pdo->query($sql);

	//sqlに送信された内容を入力
	if(!empty($_POST["name"]) && !empty($_POST["drinkname"]) && !empty($_POST["custom"]) && !empty($_POST["pass"]) && isset($_POST["write"]) && !isset($_POST["id"])){ 

		$sql = "INSERT INTO cafediary(name,drinkname,custom,time,pass,IMG,MIME)VALUES(?,?,?,?,?,?,?)";
		$result = $pdo -> prepare($sql);
		$result ->execute(array($name,$drinkname,$custom,$time,$pass,$imgdat,$mime));
	}
	
	//削除処理
	//定義
	$num = intval(htmlspecialchars($_POST['delno']));
	$passdel = htmlspecialchars($_POST["passdel"]);
	
	//DBから削除
	if(isset($_POST["delete"]) && !empty($_POST["delno"])){
		$sql = "SELECT * FROM cafediary WHERE id = $num";
		$result = $pdo->query($sql);
		$deldata = $result->fetchAll();
		if($deldata[0]['pass'] == $passdel){
			$sql = "delete from cafediary where id = $num";
			$result = $pdo -> query($sql);
			echo $deldata[0]['id'].'番を削除しました。以後、'.$deldata[0]['id'].'番は表示されません。<br />';
		}
		else{
			echo 'パスワードが違います。正しいパスワードを入力してください。<br />';
		}
	}

	//編集処理
	if(isset($_POST["edit"])){
		//定義
		$ednum = intval(htmlspecialchars($_POST["ednumber"]));
		$edname = htmlspecialchars($_POST['name']);
		$eddrinkname = htmlspecialchars($_POST['drinkname']);
		$edcustom = htmlspecialchars($_POST['custom']);
		$edtime = date('Y年m月d日 h時i分');
		$edpass = htmlspecialchars($_POST["edpass"]);
		
		$edupfile = $_FILES["upfile"]["tmp_name"];
		$edimgdat = file_get_contents($edupfile); //ファイルのバイナリデータ
		//ファイルのタイプ
		$edmime = shell_exec('file -bi '.escapeshellcmd($edupfile)); 
		$edmime = trim($edmime);
		$edmime = preg_replace("/ [^ ]*/", "", $edmime); 

		//DBをアップデート
		$sql = "update cafediary set name=?, drinkname = ?, custom=?, time=?, pass=?, IMG=?, MIME= ?where id = ?";
		$result = $pdo -> prepare($sql);
		$result ->execute(array($edname,$eddrinkname,$edcustom,$edtime,$edpass,$edimgdat,$edmime,$ednum));

		echo $ednum.'番を編集しました。<br />';
	}

	//結果を出力
	//キャッシュ無効。(画像更新のため)
	header( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
	header( 'Last-Modified: '.gmdate( 'D, d M Y H:i:s' ).' GMT' );

	// HTTP/1.1
	header( 'Cache-Control: no-store, no-cache, must-revalidate' );
	header( 'Cache-Control: post-check=0, pre-check=0', FALSE );

	// HTTP/1.0
	header( 'Pragma: no-cache' );
	//キャッシュ無効プログラム終了

	$sql = 'SELECT * FROM cafediary';
	$result = $pdo -> query($sql);

	foreach($result as $row){
		$postid = $row['id'];
?>
	<p style="display:inline;">
<?php
		echo $postid.'. ';
		echo $row['name'].'<br />';
?>
	<form method="post" action="mission_3-8_main.php" style="display:inline;">
	<input type="text" name="delno" value="<?php echo "$postid" ?>">
	<input type = "hidden" name = "passdel" value="<?php echo "$postpass" ?>" >
	<input type = "submit" name="delete" value = "delete"><br /><br />
	</form>
	<form method="post" action="editsql.php" style="display:inline;">
	<input type = "hidden" name="edno" value="<?php echo "$postid" ?>"><br />
	<input type = "hidden" name = "passed" value="<?php echo "$postpass" ?>" >
	<input type = "submit" name="edit" value = "edit">
	</form>
	</p>
<?php
		echo $row['drinkname'].'<br />';
		echo $row['custom'].'<br />';
		if(strpos($row['MIME'],'image') !== false){
			print("<img src=\"img_get2.php?id=" . $row['id'] . "\"width=\"426\" height=\"240\"><br />");
		} else if(strpos($row['MIME'],'video') !== false){
			print("<video src=\"img_get2.php?id=".$row['id']."\" width=\"426\" height=\"240\" controls></video><br />");
		}
		echo '( '.$row['time'].' )<br /><br />';
	}	
}
catch(PDOException $e){
	print('エラーが発生しました。:'.$e->getMessage());
	die();
}
?>
