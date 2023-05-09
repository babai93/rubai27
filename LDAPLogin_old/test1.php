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

//call custom function for formatting json data
echo pretty_print($response);
//Declare the custom function for formatting
function pretty_print($json_data)
{
//Initialize variable for adding space
$space = 0;
$flag = false;
//Using <pre> tag to format alignment and font
echo "<pre>";
//loop for iterating the full json data
for($counter=0; $counter<strlen($json_data); $counter++)
{
//Checking ending second and third brackets
if( $json_data[$counter] == '}' || $json_data[$counter] == ']' )
    {
$space--;
echo "\n";
echo str_repeat(' ', ($space*2));
    }

//Checking for double quote(“) and comma (,)
if( $json_data[$counter] == '"'&& ($json_data[$counter-1] == ',' || $json_data[$counter-2] == ',') )
    {
echo "\n";
echo str_repeat(' ', ($space*2));
    }
if( $json_data[$counter] == '"'&& !$flag )
    {
if( $json_data[$counter-1] == ':' || $json_data[$counter-2] == ':' )
//Add formatting for question and answer
echo '<span style="color:blue;font-weight:bold">';
else
//Add formatting for answer options
echo '<span style="color:red">';
    }
echo $json_data[$counter];
//Checking conditions for adding closing span tag  
if( $json_data[$counter] == '"'&&$flag )
echo '</span>';
if( $json_data[$counter] == '"' )
$flag= !$flag;
//Checking starting second and third brackets
if( $json_data[$counter] == '{' || $json_data[$counter] == '[' )
    {
$space++;
echo "\n";
echo str_repeat(' ', ($space*2));
    }
}
echo "</pre>";
}
?>