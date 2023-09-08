<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SamrtServe Group Info</title>

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Georama|Titillium Web">
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="stylepop.css">
<script type="text/javascript">
function goclicky(entityn)
{
    var x = screen.width/2 - 500/2;
    var y = screen.height/2 - 260/2;
    window.open(entityn.href, 'sharegplus','height=260,width=500,left='+x+',top='+y);
}
</script>
</head>
<body>
<?php
require "cURLsetup.php";

    // Retrieve the URL variables (using PHP).
	$id = 0;
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$id = preg_replace('/[^0-9.]+/', '', $id);
			echo '<div class="flex-container">';
			echo  	'<div class="box1">Entity ID: #'.$id.'</div>';
			//echo	'<div class="box2"><input type="button" onclick="self.close();" value="Close"></div>';
            echo    '<div class="box2"><button class="btnx" onclick="self.close();"> X </button></div>';
			echo '</div>';
	} else {
			echo "Please enter valid number like <strong>ticket.php?id=23889</strong><br>";
			echo '<input type="button" onclick="self.close();" value="Close">';
	}

$GroupDTLS = getGroupMember($id);

echo '<div class="data">'.$GroupDTLS.'</div>';

function getGroupMember($id)
{
    $response = callAPI('GET', 'https://mmfss.freshservice.com/api/v2/groups/'.$id, false);
    $obj = json_decode($response);
    $groupName = $obj->group->name;
    $agent_ids = $obj->group->agent_ids;

    //$assoc_array = json_decode($response, true); // old mathord
    //$groupName = $assoc_array['group']['name'];

    $updatedString = '<span style="font-size: .85rem;">Group Name: '.$groupName.'</span><br><span id="labelt">Members:</span><br><table class="myFormat" style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="0"><tbody>';

		foreach ($agent_ids as $agent_id) {
            $memberName = getAgentNameOnly($agent_id);
			$agent_id_link = '<a href="member.php?id='.$agent_id.'" onclick="goclicky(this); return false;" target="_blank">'.$memberName.'</a>';
            $updatedString .= "<tr><td>".$agent_id_link."</td></tr>";
        }
    $updatedString .="</tbody></table>";
    return $updatedString;
}
function getAgentNameOnly($id)
{
    $response = callAPI('GET', 'https://mmfss.freshservice.com/api/v2/requesters/'.$id, false);
    $obj = json_decode($response);
    $fname = $obj->requester->first_name;
    $lname = $obj->requester->last_name;
    $AgentName = $fname." ".$lname;
    return $AgentName;
}
?>
</body>
</html>