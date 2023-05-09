<?php
// Initiate curl session in a variable (resource)
$curl_handle = curl_init();

$url = "https://mmfss.freshservice.com/api/v2/groups?per_page=100&page=1";

// Set the curl URL option
curl_setopt($curl_handle, CURLOPT_URL, $url);

curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array(
    'Authorization: Basic QVRtQ1hMR1FySWVvSk5TM1k1ZDI6WA==',
    'Content-Type: application/json',
));

// This option will return data as a string instead of direct output
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);

// Execute curl & store data in a variable
$curl_data = curl_exec($curl_handle);

curl_close($curl_handle);

// Decode JSON into PHP array
$response_data = json_decode($curl_data);

// Print all data if needed
// print_r($response_data);
// die();

// All user data exists in 'data' object
$user_data = $response_data->groups;

// Extract only first 5 user data (or 5 array elements)
// $user_data = array_slice($user_data, 0, 4);

// Traverse array and print employee data
$i = 0;
foreach ($user_data as $user) {
    $i=$i+1;
	echo $i." : ".$user->name;
	echo "<br />";
}
?>