<?php
$filename = 'ファイル名';
//echo $filename

$fp = fopen($filename, 'w');

fwrite($fp, 'test');

fclose($fp);

?>