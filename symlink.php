<?php

$targetFolder = $_SERVER['DOCUMENT_ROOT'].'/projects/HMS/storage/app/public';
echo $targetFolder;exit;
$linkFolder = $_SERVER['DOCUMENT_ROOT'].'/projects/HMS/public/storage';
symlink($targetFolder,$linkFolder);
echo 'Symlink process successfully completed';