<?php

// if this page was not called by AJAX, die
// disable for while testing
if (!$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') die('Invalid request');

require "cURLsetup.php";

// get variable sent from client-side page
$id = isset($_POST['id']) ? strip_tags($_POST['id']) :null;

$GroupDTLS = getGroupMember($id);

//echo '<div class="data">'.$GroupDTLS.'</div>';
echo $GroupDTLS;

function getGroupMember($id)
{
    $updatedString = '';
    $response = callAPI('GET', 'https://mmfss.freshservice.com/api/v2/groups/'.$id, false);
    $obj = json_decode($response);
    $groupName = $obj->group->name;
    $agent_ids = $obj->group->members;

    $jsonData = callAPI('GET', 'https://mmfss.freshservice.com/api/v2/ticket_fields', false);

        $decodedJson = json_decode($jsonData, true);
        //$choices = $decodedJson['ticket_fields'][18]['choices'];

        foreach ($decodedJson['ticket_fields'] as $field) {
            if ($field['label'] === 'Assigned to') {
                $choices = $field['choices'];
                break;
            }
        }

        $ids = $agent_ids;
        $levels = array();
        
        foreach ($ids as $id) {
            $level = array_search($id, $choices);
            if ($level !== false) {
                $levels[$id] = $level;
            }
        }

        //return $levels;  // the array of agents of the group

        $updatedString = '<center><span style="font-size: .85rem;">Members of <b>'.$groupName.'</b> Group</span></center><table class="gTable" style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="0"><tbody>';

		foreach ($levels as $agentId => $name) {
			$agent_id_link = '<a href="member.php?id='.$agentId.'" onclick="goclicky(this); return false;" target="_blank">'.strtoupper($name).'</a>';
            $updatedString .= "<tr><td>".$agent_id_link."</td></tr>";
        }
    $updatedString .="</tbody></table>";
    return $updatedString;
}
?>