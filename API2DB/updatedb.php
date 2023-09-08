<?php
echo ini_get("memory_limit")."<br/>";
ini_set('memory_limit', '256M');
echo ini_get("memory_limit")."<br/>";
require "cURLtoken.php";
require "cURLsetup.php";

$token = GetToken('POST', 'https://api-uat.mmfsl.com/oauth/cc/v1/token', false);
echo $token."<br/>";

$EmpData = FatchData('GET', 'https://api-uat.mmfsl.com/services/v3/EmployeeMaster/GetEmployeeMaster_v2', $token);

//echo $EmpData;
$users = json_decode($EmpData, true);
//echo $users;
//echo count($users['data']);

// echo count($users)."<br/>";
// foreach($users as $o){
//     echo count($o)."<br/>";
// }

echo sizeof($users, COUNT_RECURSIVE) - sizeof($users)."<br/>";

foreach($users as $key=>$arr)
{
   echo "Key - ".$key." Count = ".sizeof($arr)."<br/>";
}


// Slice it, getting the first 10 elements
//$parts = array_slice($users, 0, 10);

// Encode it back to JSON
//echo json_encode($parts);

//$response = callAPI('GET', 'https://mmfss.freshservice.com/api/v2/requesters/'.$id, false);
//$obj = json_decode($response);
//$fname = $obj->requester->first_name;
//$lname = $obj->requester->last_name;
//$AgentName = $fname." ".$lname;
//return $AgentName;

//write json to file

// if (file_put_contents("users.json", $users['']))
//     echo "JSON file created successfully...";
// else 
//     echo "Oops! Error creating json file...";

?>

