<?php
$filename = 'ファイル名';


$fp = fopen($filename, 'r');
$form = fgets($fp);

echo $form;
echo "<br>";

fclose($fp);

?>