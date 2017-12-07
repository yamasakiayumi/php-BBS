<?php
$id = htmlspecialchars($_POST['id']);
$usrpass = htmlspecialchars($_POST['usrpass']);
$dsn = 'データベース名';
$user = 'ユーザ名';
$password = 'パスワード';
try{
	$pdo = new PDO($dsn, $user, $password);
	$sql = "SELECT * FROM userlist WHERE id = $id";
	$result = $pdo->query($sql);
	$logindata = $result->fetchAll();
	if($logindata[0]['pass'] == $usrpass){
		$loginname = $logindata[0]['usrname'];
		?>
		<!DOCTYPE html>
		<html lang ="ja">
		<head>
		<meta charset = "UTF-8">
		</head>
		<body>
		<title>推しカフェ</title>

		<form method="post" action="mission_3-7_main.php" enctype="multipart/form-data">
		<b>にっき</b><br /><br />
		<form action="mission_2-5.php" method="post">
		　　　name　<input type="text" name="name" value="<?php echo "$loginname"?>" ><br />
		　shopname　<input type = "text" name ="shopname" size="60"><br />
		　 comment　<input type = "text" name ="comment" size="60"><br />
		image/video　<input type="file" name="file"><br />
		　password　<input type = "password" name = "pass" size="4" ><br />
		<input type="submit" name="write" value="送信"><br /><br />
		</form>
		<form method="post" action="mission_3-7_main.php">
		delete<br />
		post number　<input type="text" name="delno" size="4"><br />
		password　<input type = "password" name = "passdel" size="4"><br />
		<input type = "submit" name="delete" value = "削除"><br /><br />
		</form>

		<form method="post" action="editsql.php">
		edit<br />
		post number　<input type="text" name="edno" size="4"><br />
		password　<input type = "password" name = "passed" size="4"><br />
		<input type = "submit" name="edit" value = "編集">
		<br /><br />

		<a href="url">←戻る</a>
		<br /><br />
		</form>
		</body>
		</html>

		<?php
		//変数定義
		$name = htmlspecialchars($_POST['name']);
		$comment = htmlspecialchars($_POST['comment']);
		$time = date('Y年m月d日 h時i分');
		$pass = htmlspecialchars($_POST["pass"]);

		//テーブルがなければ作成する
		$sql = 'CREATE TABLE IF NOT EXISTS diary
			(
				id int AUTO_INCREMENT,
				name varchar(50),
				com varchar(200),
				time varchar(50),
				pass varchar(20),
				PRIMARY KEY(id)
			);';
		$result = $pdo->query($sql);

		//sqlに送信された内容を入力
		if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["pass"]) && isset($_POST["write"]) && !isset($_POST["id"])){ 

			$sql = "INSERT INTO diary(name,com,time,pass)VALUES(?,?,?,?)";
			$result = $pdo -> prepare($sql);
			$result ->execute(array($name,$comment,$time,$pass));
		}
		
		//削除処理
		$num = intval(htmlspecialchars($_POST['delno']));
		$passdel = htmlspecialchars($_POST["passdel"]);
		
		if(isset($_POST["delete"]) && !empty($_POST["delno"])){
			$sql = "SELECT * FROM diary WHERE id = $num";
			$result = $pdo->query($sql);
			$deldata = $result->fetchAll();
			if($deldata[0]['pass'] == $passdel){
				$sql = "delete from diary where id = $num";
				$result = $pdo -> query($sql);
				echo $deldata[0]['id'].'番を削除しました。以後、'.$deldata[0]['id'].'番は表示されません。<br />';
			}
			else{
				echo 'パスワードが違います。正しいパスワードを入力してください。<br />';
			}
		}

		//編集処理
		if(isset($_POST["number"])){
			$ednum = intval(htmlspecialchars($_POST["number"]));
			$edname = htmlspecialchars($_POST['name']);
			$edcomment = htmlspecialchars($_POST['comment']);
			$edtime = date('Y年m月d日 h時i分');
			$edpass = htmlspecialchars($_POST["pass"]);

			$sql = "update diary set name='$edname', com='$edcomment', time='$edtime', pass='$edpass' where id = $ednum";
			$result = $pdo -> query($sql);

			echo $ednum.'番を編集しました。<br />';
		}

		//結果を出力
		$sql = 'SELECT * FROM diary';
		$result = $pdo -> query($sql);

		foreach($result as $row){
			echo $row['id'].' ';
			echo $row['name'].' ';
			echo $row['com'].' ';
			echo $row['time'].'<br />';
		}	
	}
}
catch(PDOException $e){
	print('エラーが発生しました。:'.$e->getMessage());
	die();
}
?>
