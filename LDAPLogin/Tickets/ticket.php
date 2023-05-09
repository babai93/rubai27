<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SamrtServe Ticket details</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Georama|Titillium Web">
	<link rel="stylesheet" href="style.css">
<script type="text/javascript">
function goclicky(entity)
{
    var x = screen.width/2 - 500/2;
    var y = screen.height/2 - 260/2;
    window.open(entity.href, 'sharegplus','height=260,width=500,left='+x+',top='+y);
}
</script>
<style>
.flex-container {
	display: flex;
	width: 100%;
	background: #4d4d4f;
	text-align: center;
	color: white;
}
.flex-container a {
	color: white;
}

.box1, .box2 {
	flex: 1; /* This will make both boxes take up equal space */
	height: 22px;
	margin: 10px;
}

.box1 {
	/*background-color: #ff0000;*/
	font-size: 18px;
	text-align: left;
}

.box2 {
	/*background-color: #00ff00;*/
	text-align: right;
}
.data {
	margin: 10px;
}
input[type=text], select {
    width: 30% !important;
{
body h1 {
font-size: 1.7rem;
letter-spacing: 1.1px;
}
</style>
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
			echo  	'<div class="box1">Ticket ID: #'.$id.'</div>';
			echo	'<div class="box2"><a href="./">View another Ticket</a></div>';
			echo '</div>';
	} else {
			echo "Please enter valid number like <strong>ticket.php?id=23889</strong><br>";
			echo "<a href='./'>back to submit page</a><br>";
	}

$tDTLS = getTicketDTLS($id);

echo '<div class="data">'.$tDTLS.'</div>';

function getTicketDTLS($id)
{
	$updatedString = "<div>";
    $json = callAPI('GET', 'https://mmfss.freshservice.com/api/v2/tickets/'.$id.'?include=tags,requester,requested_for,stats,conversations', false);

    /*echo"<pre>"; 
    var_dump(json_decode($json, true)); 
    echo"</pre>";
    echo "<br>";*/

    $obj = json_decode($json, true);
	
	if ($obj['ticket']['requester']['id'] == $obj['ticket']['requested_for']['id']) {

    }


	if ($obj['ticket']['requester']['id'] != null){
		$tRequesterName = $obj['ticket']['requester']['name'];
		$tRequesterID = $obj['ticket']['requester']['id'];
        $updatedString .= 'Requester: <a href="entity.php?id='.$tRequesterID.'" onclick="goclicky(this); return false;" target="_blank">'.$tRequesterName.'</a><br>';
	} else {
		$tRequesterName = "Blank";
		$tRequesterID = null;
        $updatedString .= 'Requester: ' .$tRequesterName. '<br>';
	}
	//$updatedString .= 'Requester: ' .$tRequesterName. '<br>';
    if ($obj['ticket']['requester']['id'] != $obj['ticket']['requested_for']['id']) {

        if ($obj['ticket']['requested_for']['id'] != null){
            $tRequestedForName = $obj['ticket']['requested_for']['name'];
            $tRequestedForID = $obj['ticket']['requested_for']['id'];
            $updatedString .= 'Requested for: <a href="entity.php?id='.$tRequestedForID.'" onclick="goclicky(this); return false;" target="_blank">'.$tRequestedForName.'</a><br>';
        } else {
            $tRequestedForName = "Blank";
            $tRequestedForID = null;
            $updatedString .= 'Requested for: ' .$tRequestedForName. '<br>';
        }
        
    }
	//$updatedString .= 'Requested for: ' .$tRequestedForName. '<br>';
	$updatedString .= 'Subject: ' .$obj['ticket']['subject']. '<br>';
	$updatedString .= 'Ticket Type: ' .$obj['ticket']['type']. '<br>';
	$tsource = getsource($obj['ticket']['source']);
	$updatedString .= 'Ticket Source: ' .$tsource. '<br>';
	$tstatus = getstatus($obj['ticket']['status']);
	$updatedString .= 'Ticket Status: ' .$tstatus. '<br>';
	$tpriority = getpriority($obj['ticket']['priority']);
	$updatedString .= 'Ticket Priority: ' .$tpriority. '<br>';
	$tcreatedat = getIST($obj['ticket']['created_at']);
	$updatedString .= 'Ticket Created on: '.$tcreatedat.'<br>';
	$tdue_by = getIST($obj['ticket']['due_by']);
	$updatedString .= 'Ticket Resolution due: '.$tdue_by.'<br>';
	
	//--- calling more APIs for get the Group and Agent names
	
    //---- Group ID ------//
	if ($obj['ticket']['group_id'] != null){
		$tAssignedGID = $obj['ticket']['group_id'];
            $updatedString .= 'Ticket Assigned to Group ID: <a href="group.php?id='.$tAssignedGID.'" onclick="goclicky(this); return false;" target="_blank">'.$tAssignedGID.'</a><br>';
	} else {
		$tAssignedGName = "Blank";
		$tAssignedGID = "Blank";
            $updatedString .= 'Ticket Assigned to Group ID: '.$tAssignedGID.'<br>';
	}
	//$updatedString .= 'Ticket Assigned to Group ID: '.$tAssignedGID.'<br>';
	
    //---- Agent ID ------//
    if ($obj['ticket']['responder_id'] != null){
		$tAssignedAID = $obj['ticket']['responder_id'];
			/*$updatedString .= 'Ticket Assigned to Agent ID: <a href="javascript:void(0);"
					 NAME="Entity Info"  title="Entity Info"
					 onClick=window.open("entity.php?id='.$tAssignedAID.'","Ratting","width=500,height=270,0,status=0,scrollbars=1,toolbar=0,menubar=0,titlebar=0");>
					 '.$tAssignedAID.'</a><br>';*/
            $updatedString .= 'Ticket Assigned to Agent ID: <a href="entity.php?id='.$tAssignedAID.'" onclick="goclicky(this); return false;" target="_blank">'.$tAssignedAID.'</a><br>';
	} else {
		$tAssignedAName = "Blank";
		$tAssignedAID = "Blank";
			$updatedString .= 'Ticket Assigned to Agent ID: '.$tAssignedAID.'<br>';
	}	
	//$updatedString .= 'Ticket Assigned to Agent ID: '.$tAssignedAID.'<br>';
	
	
	/*if ($obj['ticket']['group_id'] != null){
		$tAssignedG = getAssignedG($obj['ticket']['group_id']);
		$tAssignedGName = $tAssignedG;
		$tAssignedGID = $obj['ticket']['group_id'];
	} else {
		$tAssignedGName = "Blank";
		$tAssignedGID = null;
	}
	$updatedString .= 'Ticket Assigned to Group: '.$tAssignedGName.'<br>';
	if ($obj['ticket']['responder_id'] != null){
		$tAssignedA = getname($obj['ticket']['responder_id']);
		$tAssignedAName = $tAssignedA['name'];
	} else {
		$tAssignedAName = "Blank";
	}
	$updatedString .= 'Ticket Assigned to Agent: '.$tAssignedAName.'<br>';*/
	
	//--- END calling more APIs for get the Group and Agent names
	
/*	$obj = json_decode($json);
    $agent_ids = $obj->ticket;
    
    foreach ($agent_ids as $agent_id) {
		
		if (is_array($agent_id) == true){
			print_r($agent_id);
		} else {
			echo $agent_id. '<br>';
		}
    }*/
	
	    if ($obj['ticket']['status'] === 4 || $obj['ticket']['status'] === 5) {
            $tResolvedAt = getIST($obj['ticket']['stats']['resolved_at']);
			$updatedString .= 'Ticket Resolved on: '.$tResolvedAt.'<br>';
        }
        if ($obj['ticket']['status'] === 5) {
            $tClosedAt = getIST($obj['ticket']['stats']['closed_at']);
			$updatedString .= 'Ticket Closed on: '.$tClosedAt.'<br>';
        }
	
	
	//---- Conclude the data
	$updatedString .="</div>";
	return $updatedString;
}

function getsource($id)
{
    $values = [
        1 => 'Email',
        2 => 'Portal',
        3 => 'Phone',
        4 => 'Chat',
        5 => 'Feedback Widget',
        7 => 'AWS CloudWatch',
        14 => 'Alerts',
        15 => 'MS Teams',
        1001 => 'SMS',
        1002 => 'AskMyPal',
        1003 => 'Mobile App'
    ];
    if (isset($values[$id])) {
        $result = $values[$id];
    } else {
        $result = 'Default Value';
    }
    return $result; // return source Value
}
function getstatus($id)
{
    $values = [
        2 => 'Open',
        3 => 'Pending',
        4 => 'Resolved',
        5 => 'Closed'
    ];
    if (isset($values[$id])) {
        $result = $values[$id];
    } else {
        $result = 'Default Value';
    }
    return $result; // return status Value
}
function getpriority($id)
{
    $values = [
        1 => 'Low',
        2 => 'Medium',
        3 => 'High',
        4 => 'Urgent'
    ];
    if (isset($values[$id])) {
        $result = $values[$id];
    } else {
        $result = 'Default Value';
    }
    return $result; // return status Value
}

function getIST($datetime)
{
    $iso_date_time = $datetime;
    $datetime = new DateTime($iso_date_time);
    $datetime->setTimezone(new DateTimeZone('Asia/Kolkata'));
    $ist_date_time = $datetime->format('d-m-Y h:i A');
    return $ist_date_time; // Output: 2023-05-02 16:00:00
}
function getname($id)
{
    if ($id === null) {
        $out['name'] = "Blank";
        $out['UID'] = null;
        $out['Dept'] = null;
        $out['grade'] = null;
        $out['company'] = null;
        $out['job_title'] = null;
        $out['branch_name'] = null;
        $out['mobile_phone_number'] = null;
        $out['reporting_manager_id'] = null;
        $out['primary_email'] = null;
        return $out;
      } else {
        $response = callAPI('GET', 'https://mmfss.freshservice.com/api/v2/requesters/'.$id, false);
        //echo $response;
        $assoc_array = json_decode($response, true);
        $fname = $assoc_array['requester']['first_name'];
        $lname = $assoc_array['requester']['last_name'];
        $fullname = $fname." ".$lname;
        //return $name;
        //-------------------------------//
        $out['name'] = $fullname;
        $out['UID'] = $assoc_array['requester']['custom_fields']['user_id'];
        $out['Dept'] = $assoc_array['requester']['custom_fields']['vertical'];
        $out['grade'] = $assoc_array['requester']['custom_fields']['grade'];
        $out['company'] = $assoc_array['requester']['custom_fields']['company'];
        $out['job_title'] = $assoc_array['requester']['job_title'];
        $out['branch_name'] = $assoc_array['requester']['custom_fields']['branch_name'];
        $out['mobile_phone_number'] = $assoc_array['requester']['mobile_phone_number'];
        $out['reporting_manager_id'] = $assoc_array['requester']['reporting_manager_id'];
        $out['primary_email'] = $assoc_array['requester']['primary_email'];
        return $out;
      }
}
function getAssignedG($id)
{
    if ($id === null) {
        return "Blank";
    } else {
        $response = callAPI('GET', 'https://mmfss.freshservice.com/api/v2/groups/'.$id, false);
        $assoc_array = json_decode($response, true);
        $name = $assoc_array['group']['name'];
        return $name;
    }
}
?>
</body>
</html>