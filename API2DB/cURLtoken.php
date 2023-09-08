<?php
function GetToken($method, $url, $data){
   $curl = curl_init();
   
   curl_setopt_array($curl, array(
     CURLOPT_URL => $url,
     CURLOPT_RETURNTRANSFER => true,
     CURLOPT_ENCODING => '',
     CURLOPT_MAXREDIRS => 10,
     CURLOPT_TIMEOUT => 0,
     CURLOPT_FOLLOWLOCATION => true,
     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
     CURLOPT_CUSTOMREQUEST => $method,
     CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
     CURLOPT_HTTPHEADER => array(
       'Content-Type: application/x-www-form-urlencoded',
       'Accept: application/json',
       'Authorization: Basic c3hJRzVmS2txOHRoaDI5YW1FTnM3b3Mza0RNeVhFRXF1VjN6dVF0V1Y0UmlHUGU4OkwzWjBhbE8wT3d3akVPbnhZaUZnZGViaW1LbUtLeFRxbjh6OE5ZQzFudlgwd1J4YmNxQjhuaUVFQzRiR3N2R3o='
     ),
   ));

   $response = curl_exec($curl);

   curl_close($curl);
   //return $response;
   $obj = json_decode($response);
   $token = $obj->access_token;
   return $token;
}