<?php
$filename = 'ƒtƒ@ƒCƒ‹–¼';
//echo $filename

$fp = fopen($filename, 'w');

fwrite($fp, 'test');

fclose($fp);

?>