<?php
$filename = '�t�@�C����';


$fp = fopen($filename, 'r');
$form = fgets($fp);

echo $form;
echo "<br>";

fclose($fp);

?>