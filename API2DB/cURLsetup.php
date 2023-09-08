<?php
function FatchData($method, $url, $data){
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
     CURLOPT_HTTPHEADER => array(
       'Authorization: Bearer '.$data
     ),
   ));

   // EXECUTE:
   $result = curl_exec($curl);
   if(!$result){die("Connection Failure");}
   curl_close($curl);
   return $result;
}