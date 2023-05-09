<?php
require "cURLsetup.php";
$tGroupMember = getGroupMember(27000713719);

echo $tGroupMember;

function getGroupMember($id)
{
    $json = callAPI('GET', 'https://mmfss.freshservice.com/api/v2/groups/'.$id, false);
    $obj = json_decode($json);
    $agent_ids = $obj->group->agent_ids;
    
    foreach ($agent_ids as $agent_id) {
        echo $agent_id . "<br>";
    }
}