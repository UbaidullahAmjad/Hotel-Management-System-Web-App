<?php
// the message
$msg = "First line of text\nSecond line of text";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
$res = mail("cplusoft@gmail.com","My subject",$msg);
if($res){
    echo 'true';exit;
}else{
    echo 'false';exit;
}

?>