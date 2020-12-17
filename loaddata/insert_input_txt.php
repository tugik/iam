<?php
if ($_POST['']);
$file=fopen('/var/www/iam/loaddata/mes.txt','w+');
fputs($file,$_POST['mes']);
fclose($file);
echo 'Done';
?>