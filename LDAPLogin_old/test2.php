<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://mmfss.freshservice.com/api/v2/tickets/1531',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Basic QVRtQ1hMR1FySWVvSk5TM1k1ZDI6IA=='
  ),
));

$response = curl_exec($curl);

curl_close($curl);
//echo $response;


//Encode the json value

$decoded_data = json_decode($response);
header('Content-type: text/javascript');
//Print the json data after decode
echo "The output of JSON data:\n";
echo json_encode($decoded_data, JSON_PRETTY_PRINT);

?>