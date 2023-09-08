<?php
$url = 'https://mmfss.freshservice.com/';
$context = stream_context_create([
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ],
]);
$response = file_get_contents($url, false, $context);
echo $response;
?>
