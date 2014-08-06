#!/usr/bin/php
<?php

$config = json_decode(file_get_contents(dirname(__FILE__).'/config.json'));
if(!is_object($config) || !$config->gmail->enabled)
        die("-");

$host = $config->gmail->host;
$user = $config->gmail->user;
$pass = $config->gmail->pass;

$inbox = '{'.$host.':993/imap/ssl}INBOX';

$mbox = imap_open($inbox,$user,$pass, NULL, 1, array('DISABLE_AUTHENTICATOR' => 'GSSAPI')) or die('Cannot connect to mailserver: ' . imap_last_error());

$emails = imap_search($mbox,'UNSEEN');
if($emails) {
	echo "#[bg=white]#[fg=red]".count($emails)."#[bg=red]";
} else {
	echo "#[fg=white]0";
}

?>
