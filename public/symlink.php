<?php

$targetFolder = '/home/603359.cloudwaysapps.com/yhmefxgdcm/public_html/public/storage/app/public';
// echo $targetFolder;exit;
$linkFolder = $_SERVER['DOCUMENT_ROOT'].'/storage';
symlink($targetFolder,$linkFolder);
echo 'Symlink process successfully completed';