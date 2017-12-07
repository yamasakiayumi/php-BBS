<?php
$filename = 'ƒtƒ@ƒCƒ‹–¼';


$fp = fopen($filename, 'r');
$form = fgets($fp);

echo $form;
echo "<br>";

fclose($fp);

?>