#!/usr/bin/php
<?php

$config = json_decode(file_get_contents(dirname(__FILE__).'/config.json'));
if(!is_object($config) || !$config->whmcs->enabled)
	die("-");

$url = "https://".$config->whmcs->host."/includes/api.php";
$user = $config->whmcs->user;
$pass = $config->whmcs->pass;

$postfields = array();
$postfields["username"] = $user;
$postfields["password"] = md5($pass);
$postfields["action"] = "gettickets";
$postfields["responsetype"] = "json";

$query_string = "";
foreach ($postfields AS $k=>$v) $query_string .= "$k=".urlencode($v)."&";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
$jsondata = curl_exec($ch);
if (curl_error($ch)) die("Connection Error: ".curl_errno($ch).' - '.curl_error($ch));
curl_close($ch);

$obj = json_decode($jsondata); # Decode JSON String

$count=0;
foreach($obj->tickets->ticket as $ticket) {
	if(preg_match('/(Open|Awaiting|Customer-Reply)/', $ticket->status)) {
		$count++;
	}
}

if($count > 0) {
	echo "#[fg=red]".$count;
} else {
	echo "#[fg=white]0";
}

?>
