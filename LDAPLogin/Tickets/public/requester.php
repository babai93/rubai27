<?php
require "cURLsetup.php";
$tGroupMember = getGroupMember(27002411614);

echo $tGroupMember;

function getGroupMember($id)
{
    $json = callAPI('GET', 'https://mmfss.freshservice.com/api/v2/requesters/'.$id, false);
    $obj = json_decode($json);
    $agent_ids = $obj->requester->custom_fields;
    
    foreach ($agent_ids as $agent_id) {
        echo $agent_id . "<br>";
    }
}