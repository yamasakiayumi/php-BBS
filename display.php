<HTML>
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>画像表示</title>
</HEAD>
<BODY>
<FORM method="POST" action="display.php">
	<P>画像の表示</P>
	ID：<INPUT type="text" name="id">
	<INPUT type="submit" name="submit" value="送信">
	<BR><BR>
</FORM>

<?php
$dsn = 'mysql:dbname=co_981_it_99sv_coco_com;host=localhost;charset=utf8';
$user = 'co-981.it.99sv-c';
$password = 'UbygGQd';
$dbLink = new PDO($dsn, $user, $password);

if (count($_POST) > 0 && isset($_POST["submit"])){
	$id = $_POST["id"];
	$sql = "SELECT * FROM IMAGES2 WHERE id = $id";
	$result = $dbLink->query($sql);
	$filedata = $result->fetchAll();
	echo $filedata[0]['MIME'];

	if ($id==""){
		print("IDが入力されていません。<BR>\n");
	} else if(strpos($filedata[0]['MIME'],'image') !== false){
		print("<img src=\"img_get.php?id=" . $id . "\">");
	} else if(strpos($filedata[0]['MIME'],'video') !== false){
		print("<video src=\"img_get.php?id=$id\" width=\"426\" height=\"240\" controls></video>");
	}

}
?>
</BODY>
</HTML>