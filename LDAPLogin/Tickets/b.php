<?php

require "cURLsetup.php";

$get_data = callAPI('GET', 'https://mmfss.freshservice.com/api/v2/tickets/44777', false);
echo $get_data;

$response = json_decode($get_data, true);
//echo $response;
//$errors = $response['response']['errors'];
//$data = $response['response']['data'][0];
echo "<hr>";
echo $data = $response['ticket']['subject'];
