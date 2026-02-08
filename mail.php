<?php
// the message
$msg = "First line of text\nSecond line of text";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
if(mail("developer1@dioztechsystems.com","My subject",$msg)) {
    echo 'sent';
} else {
    echo 'not';
}
?>