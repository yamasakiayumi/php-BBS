<?php
$filename = 'ファイル名';

$fp = fopen($filename, 'a');   // ファイルの追記には'a'を指定する

$count = count(file($filename)) + 1;
$name = htmlspecialchars($_POST["name"]);
$comment = htmlspecialchars($_POST["comment"]);
$num = intval(htmlspecialchars($_POST["number"])); // 整数に変換

$lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($lines as $key => $value) {
    $s = explode("<>", $value);
    if ($s[0] == $num) {
        $lines[$key] = $num . "<>" . $name . "<>" . $comment . "<>" . date('Y年m月d日 h時i分');
        break;
    }
}
fclose($fp);

file_put_contents($filename, implode("\n", $lines));

echo $num . "番のデータを更新しました<br />";
?>

<!DOCTYPE html>
<html lang ="ja">
    <head>
        <meta charset = "UTF-8">
    </head>
    <body>
        <title>にっき</title>

        <b>にっき</b><br /><br />

        <form method="post" action="edit.php">
            編集機能<br />
            編集対象番号：<input type="text" name="editnum" size="4"> <!-- // -->
            <input type = "submit" name="edit" value = "編集"> <!-- // -->
            <!-- <input type="hidden"  name="edit" value="hensyu"><br /> -->
        </form>
        <p align="left">
            以下は登録されたデータです<br><br>
            <?php
            $fname = 'ファイル名';
            $line = file($fname, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            foreach ($line as $value) {
                $element = explode("<>", $value);
                echo "$element[0] ";
                echo "$element[1] ";
                echo "$element[2] ";
                echo "$element[3]<br />";
            }
            ?>
        </p>
    </body>
</html>
