<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://mmfss.freshservice.com/api/v2/agents', //?query=%22email:\'bhurtiya.aniruddh@mahindra.com\'%22',
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

/*$response = curl_exec($curl);
if (curl_errno($curl)) {
  $error_msg = curl_error($curl);
  echo "API Error: " .$error_msg;
}

curl_close($curl);
//echo $response;
echo $response . PHP_EOL;

//$st = json_decode( $response);
//$st[0]['id'];*/


//var_dump( $st[0]['id']);

$result = json_decode(curl_exec($curl), true);
//echo "<hr>";
//print_r($result);
//echo "<hr>";
curl_close($curl);

$news = $result['agents'];
?>

<?php
  if (!empty($news)) {
          echo '<center><h1><i><u>Query result of Agents</u></i></h1></center>';
          foreach ($news as $post) {
             echo '<h3>Name: ' . $post['first_name'] . " " .$post['last_name']. '</h3>';
             echo '<h3>ID: '.$post['id'].'</h3>';
             echo '<h3>Email ID: ' . $post['email'] . '</h3>';
             echo '<h3>Mobile No: ' . $post['mobile_phone_number'] .'</h3>';
             echo '<hr>';
          }
  }
?>