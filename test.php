<?php

$targetFolder = $_SERVER['DOCUMENT_ROOT'].'/storage/app/public';
// echo $targetFolder;exit;
$linkFolder = $_SERVER['DOCUMENT_ROOT'].'/public/storage';
symlink($targetFolder,$linkFolder);
echo 'Symlink process successfully completed';
