<?php

/*
|--------------------------------------------------------------------------
| Sending email settings
|--------------------------------------------------------------------------
*/
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'ssl://smtp.mailbox.com';
$config['smtp_user'] = 'mailbox@mailbox.com';
$config['smtp_pass'] = 'password';
$config['smtp_port'] = '465';
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['mailpath'] = './assets/email/';
$config['newline'] = "\r\n";
$config['wordwrap'] = TRUE;

?>