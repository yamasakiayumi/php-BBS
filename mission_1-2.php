<?php
$filename = '�t�@�C����';
//echo $filename

$fp = fopen($filename, 'w');

fwrite($fp, 'test');

fclose($fp);

?>