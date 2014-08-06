#!/usr/bin/php
<?php

require_once dirname(__FILE__) .'/class.uber_api_client.php';

$config = json_decode(file_get_contents(dirname(__FILE__).'/config.json'));
if(!is_object($config) || !$config->uber->enabled)
        die("-");

$url = "https://".$config->uber->host;
$user = $config->uber->user;
$pass = $config->uber->pass;

$queues = array(
        'Support' => '1',
	// 'AnotherQueue' => '33' // add more queues to this array like that
);

$api = new uber_api_client($url, $user, $pass);

$ten_minutes_ago = time() - 600;
$count = 0;

foreach($queues as $queueid)
{
        try
        {
                $tickets = $api->call('support.ticket_list',array(
                                                'type' => 'Open',
                                                'queue' => $queueid,
                                                'limit' => '30',
                ));
        } catch (Exception $e) { print 'Error: '. $e->getMessage() .' ('. $e->getCode() .')' . "\n\n"; }

        foreach($tickets as $ticket)
        {
                if($ticket['client_activity'] > $ten_minutes_ago && strstr($ticket['activity_type'], 'Client')) {
			$count++;
                };
        }
}

if($count > 0) {
        echo "#[fg=red]".$count;
} else {
        echo "#[fg=white]0";
}

