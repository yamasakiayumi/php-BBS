<!DOCTYPE html>
<html lang ="ja">
<head>
<meta charset = "UTF-8">
</head>
<body>
<form method="post" action="mission_1-4.php">
<input type ="text" name="form1" size = "20"> 
<input type ="submit" value ="送信">
</form>
</body>
</html>


<?php
if(isset($_POST["form1"])){  /*フォームの中身が入力されたときのみ*/
$form = $_POST["form1"];    /*表示する*/

echo $form;
}
?>




