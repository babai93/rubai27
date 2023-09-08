<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SamrtServe Ticket Details</title>
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
	<link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="act_con_style.css">
    <link rel="stylesheet" href="cssmarquee.css">
    <link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.min.css">
    <script type="text/javascript">
    function goclicky(entity)
    {
        var x = screen.width/2 - 500/2;
        var y = screen.height/2 - 260/2;
        window.open(entity.href, 'sharegplus','height=260,width=500,left='+x+',top='+y);
    }

    function goclickya(activity)
    {
        var x = screen.width/2 - 800/2;
        var y = screen.height/2 - 600/2;
        window.open(activity.href, 'sharegplus','height=600,width=800,left='+x+',top='+y);
    }
    function goclickyabout(about)
    {
        var x = screen.width/2 - 690/2;
        var y = screen.height/2 - 310/2;
        window.open(about, 'sharegplus','height=310,width=690,left='+x+',top='+y);
    }
    </script>

    <style>
    body {
        position: relative;
        min-height: 100vh;
        }
    .data {
        padding-bottom: 1.1rem;    /* Footer height */
        }
    #footer {
        color: #4d4d4f;
        font-size: 0.6rem;
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 1rem;            /* Footer height */
        text-align: right;
        }
    .about {
        text-decoration: none;
        color: inherit;
        background-color: transparent;
        border: none;
        cursor: auto;
    }
    .fa-icon {
        transition: font-size 0.3s ease, transform 0.3s ease;
    }
    .fa-icon:hover {
        font-size: 17px;
        cursor: pointer;
        color: #e31837;
    }
    @media (min-width:660px) { .tdwidth { width: 160px; } } 
    /* desktops/laptops */
    @media (max-width:660px) { .tdwidth { width: 110px; font-size: 0.8rem; } } 
    /* mobile devices */
    </style>
    <script>
        //document.getElementById("form_div").onload = function() {inIframe()};
        function inIframe(){
            try {
                const x = window.self !== window.top;
                if (x == false){
                    location.replace("https://smartservice.mahindrafs.com/smartserveq/")
                }
            } catch (e) {
                const x = true;
                location.replace("https://smartservice.mahindrafs.com/smartserveq/")
            }
        }
    </script>
</head>
<body onload="inIframe()">
<!-- </head>
<body> -->
<?php
$title = "SamrtServe Ticket Details";
include "header.php";
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
?>

<?php
require "cURLsetup.php";
date_default_timezone_set('Asia/Kolkata');

    // Retrieve the URL variables (using PHP).
	$id = 0;
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$id = preg_replace('/[^0-9.]+/', '', $id);
			echo '<div class="flex-container">';
			echo  	'<div class="box1">Ticket ID: #<a href="https://smartserve.mahindrafs.com/a/tickets/'.$id.'" target="_blank">'.$id.'</a></div>'; //https://smartserve.mahindrafs.com/a/tickets/108520
            if(isset($_POST['reloadbtn'])) {
                $_SERVER['PHP_SELF'];
            }
            if(isset($_POST['vanotherbtn'])) {
                // Redirect to logout.php with the session ID as a parameter
                header("Location: lite.php");
                exit(); // Make sure to exit after the header redirection
            }
            echo '<div class="box2"><form method="post">
            <button type="submit" class="btn btnb" name="reloadbtn"><i class="fa fa-refresh" aria-hidden="true"></i><span class="btn-text">&nbsp;Reload</span>
            </button>
            <button type="submit" class="btn btnv" name="vanotherbtn"><i class="fa fa-retweet" aria-hidden="true"></i><span class="btn-text">&nbsp;View another</span>
            </button></div></form></div>';
            //$file = "output.txt";  // The name of the text file
            //$currentDateTime = date('d-m-Y H:i:s');
            //file_put_contents($file, "\n".$id."\t".$currentDateTime, FILE_APPEND); // Save the variable to the text file
            //echo "Variable saved to file.";
	} else {
			echo "Please enter valid number like <strong>ticket.php?id=23889</strong></td></tr></td></tr>";
			echo "<a href='./'>back to submit page</a></td></tr>";
	}
    echo '<div class="cssmarquee box2">
    <span class="marqeetitle">&nbsp;&nbsp;<i class="fa fa-bullhorn" aria-hidden="true"></i>
    &nbsp;Announcement:&nbsp;</span>
    <p>Now you can add comment/followup on the Open or Pending Tickets. through the Conversation menu...</p>
    <span class="marqeeabout">&nbsp;&nbsp;<i onclick="goclickyabout(\'about.php\'); return false;" class="fa-icon fa fa-question-circle" aria-hidden="true"></i>
    &nbsp;</span>
    </div>';
$tDTLS = getTicketDTLS($id);

echo '<div class="data"><table style="margin-top: -10px; text-align: left; width: 100%;" border="0" cellpadding="1" cellspacing="1"><tbody>
'.$tDTLS.'</tbody></table></div>';

function getTicketDTLS($id)
{
	
    $json = callAPI('GET', 'https://mmfss.freshservice.com/api/v2/tickets/'.$id.'?include=tags,requester,requested_for,stats,conversations', false);
    $obj = json_decode($json, true);
    $updatedString = "<div>";
	
    // Requester and Requested for details Optimize by ChatGPT --
    $updatedString .= getUserDetails($obj['ticket']['requester'], 'Requester');
    if ($obj['ticket']['requester']['id'] != $obj['ticket']['requested_for']['id']) {
        $updatedString .= getUserDetails($obj['ticket']['requested_for'], 'Requested for');
    }
 
    // Other ticket details Optimize by ChatGPT --
    $updatedString .= getDetailRow('Subject', $obj['ticket']['subject']);
    $updatedString .= getDetailRow('Type', $obj['ticket']['type']);
    $updatedString .= getDetailRow('Source', getsource($obj['ticket']['source']));
    $updatedString .= getDetailRow('Status', getstatus($obj['ticket']['status']));
    $updatedString .= getDetailRow('Priority', getpriority($obj['ticket']['priority']));
    $updatedString .= getDetailRow('Created on', getIST($obj['ticket']['created_at']));
    $updatedString .= getDetailRow('Resolution due', getIST($obj['ticket']['due_by']));
    
    // Description and attachments Optimize by ChatGPT --
    $updatedString .= getDescriptionAndAttachments($obj['ticket']['description_text'], $obj['ticket']['attachments'], $id);

    //--- calling more APIs for get the Group and Agent names
	
    // Assigned to Group and Agent details Optimize by ChatGPT --
    $updatedString .= getAssignedAgentDetails($obj['ticket']['group_id'], 'Assigned to Group', 'getGroupNameOnly', 'group.php');
    $updatedString .= getAssignedAgentDetails($obj['ticket']['responder_id'], 'Assigned to Agent', 'getAgentNameOnly', 'entity.php');
	
    // Resolved and Closed timestamps Optimize by ChatGPT --
    $updatedString .= getTimestamp('Resolved on', $obj['ticket']['stats']['resolved_at'], $obj['ticket']['status'], [4, 5]);
    $updatedString .= getTimestamp('Closed on', $obj['ticket']['stats']['closed_at'], $obj['ticket']['status'], [5]);

    // Spam status
    if ($obj['ticket']['spam'] === true) {
        $updatedString .= '<tr><td class="tdwidth"><b>Note</b></td><td width="10px">:</td><td>This Ticket is marked as<span style="color:red;"> Spam</span></td></tr>';
    }

    // Category and activities
    $updatedString .= getCategoryAndActivities($id);
	
	//---- Conclude the data
    $updatedString .= '<tr><td class="tdwidth"><b>Activities</b></td><td width="10px">:</td><td> <a href="activity.php?id='.$id.'" onclick="goclickya(this); return false;" target="_blank">Click Here</a></td></tr>';
	$updatedString .= '<tr><td class="tdwidth"><b>Conversation</b></td><td width="10px">:</td><td> <a href="conversation.php?id='.$id.'" onclick="goclickya(this); return false;" target="_blank">Click Here</a></td></tr>';
	$updatedString .="</div>";
	return $updatedString;
}

function getUserDetails($user, $label) // added by ChatGPT
{
    if ($user['id'] != null) {
        $tUserName = strtoupper($user['name']);
        $tUserID = $user['id'];
        return '<tr><td class="tdwidth"><b>' . $label . '</b></td><td width="10px">:</td><td> <a href="entity.php?id='.$tUserID.'" onclick="goclicky(this); return false;" target="_blank">'.$tUserName.'</a></td></tr>';
    } else {
        return '<tr><td class="tdwidth"><b>' . $label . '</b></td><td width="10px">:</td><td>Blank</td></tr>';
    }
}

function getDetailRow($label, $value) // added by ChatGPT
{
    return '<tr><td class="tdwidth"><b>' . $label . '</b></td><td width="10px">:</td><td>' . $value . '</td></tr>';
}

function getDescriptionAndAttachments($description, $attachments, $id) // added by ChatGPT
{
    $numberOfAttachments = count($attachments);
    if (strlen($description) > 1 || $numberOfAttachments > 0) {
        $description = preg_replace("/CAUTION:.*?safe\./", "", $description);
        $description = str_replace("\n[Text, logo  Description automatically generated]\r", "", $description);
        $description = preg_replace("/\[cid:ima.*?\]/", "", $description);
        $description = preg_replace("/\[cid:.*?\]/", "", $description);
        $description = preg_replace("/---DISCLAIMER[-]+(.*?)---+/s", "", $description);
        $description = preg_replace("/_+/", "", $description);

        $words = explode(" ", $description);
        $trimmedSentence = implode(" ", array_slice($words, 0, 150));

    return '<tr><td class="tdwidth"><b><a href="description.php?id='.$id.'" onclick="goclickya(this); return false;" target="_blank">Description</a></b></td><td width="10px">:</td><td>'.$trimmedSentence.'</td></tr>';
    }
}

function getTimestamp($label, $timestamp, $status, $validStatuses)
{
    if (in_array($status, $validStatuses)) {
        return '<tr><td class="tdwidth"><b>' . $label . '</b></td><td width="10px">:</td><td>' . getIST($timestamp) . '</td></tr>';
    }
    return '';
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
    return $values[$id] ?? 'Default Value';
}

function getstatus($id)
{
    $values = [
        2 => 'Open',
        3 => 'Pending',
        4 => 'Resolved',
        5 => 'Closed'
    ];
    return $values[$id] ?? 'Default Value';
}
function getpriority($id)
{
    $values = [
        1 => 'Low',
        2 => 'Medium',
        3 => 'High',
        4 => 'Urgent'
    ];

    return $values[$id] ?? 'Default Value';
}

function getIST($datetime)
{
    if ($datetime === null) { return ""; }
    $datetime = new DateTime($datetime, new DateTimeZone('UTC'));
    $datetime->setTimezone(new DateTimeZone('Asia/Kolkata'));
    return $datetime->format('d-m-Y h:i A'); // Output: 31-08-2023 10:02 PM
}
function getname($id)
{
    if ($id === null) {
        return [
            'name' => "Blank",
            'UID' => null,
            'Dept' => null,
            'grade' => null,
            'company' => null,
            'job_title' => null,
            'branch_name' => null,
            'mobile_phone_number' => null,
            'reporting_manager_id' => null,
            'primary_email' => null
        ];
    }

    $response = callAPI('GET', 'https://mmfss.freshservice.com/api/v2/requesters/'.$id, false);
    $assoc_array = json_decode($response, true);
    
    $fname = $assoc_array['requester']['first_name'];
    $lname = $assoc_array['requester']['last_name'];
    $fullname = $fname . " " . $lname;

    return [
        'name' => $fullname,
        'UID' => $assoc_array['requester']['custom_fields']['user_id'],
        'Dept' => $assoc_array['requester']['custom_fields']['vertical'],
        'grade' => $assoc_array['requester']['custom_fields']['grade'],
        'company' => $assoc_array['requester']['custom_fields']['company'],
        'job_title' => $assoc_array['requester']['job_title'],
        'branch_name' => $assoc_array['requester']['custom_fields']['branch_name'],
        'mobile_phone_number' => $assoc_array['requester']['mobile_phone_number'],
        'reporting_manager_id' => $assoc_array['requester']['reporting_manager_id'],
        'primary_email' => $assoc_array['requester']['primary_email']
    ];
}
function getAssignedG($id)
{
    if ($id === null) {
        return "Blank";
    }

    $response = callAPI('GET', 'https://mmfss.freshservice.com/api/v2/groups/'.$id, false);
    $assoc_array = json_decode($response, true);
    $name = $assoc_array['group']['name'];

    return $name;
}

function getAssignedAgentDetails($id, $label, $getAssignedNameOnly, $AssignedURL)
{
    if ($id != null) {
        //$tAssignedName = getAgentNameOnly($id);
        $tAssignedName = call_user_func($getAssignedNameOnly,$id);
        $AssignedURL = $AssignedURL.'?id='.$id;
        return '<tr><td class="tdwidth"><b>' . $label . '</b></td><td width="10px">:</td><td><a href="'.$AssignedURL.'" onclick="goclicky(this); return false;" target="_blank">'.$tAssignedName.'</a></td></tr>';
    } else {
        return '<tr><td class="tdwidth"><b>' . $label . '</b></td><td width="10px">:</td><td>Blank</td></tr>';
    }
}

function getGroupNameOnly($id)
{
    $response = callAPI('GET', 'https://mmfss.freshservice.com/api/v2/groups/'.$id, false);
    $obj = json_decode($response);
    $groupName = $obj->group->name;
    return $groupName;
}

function getAgentNameOnly($id)
{
    $response = callAPI('GET', 'https://mmfss.freshservice.com/api/v2/requesters/'.$id, false);
    $obj = json_decode($response);
    $fname = $obj->requester->first_name;
    $lname = $obj->requester->last_name;
    return strtoupper($fname ." ". $lname);
}

function getCategoryAndActivities($id) {
//------------------------- category ------------------------//
$jsonData = callAPI('GET', 'https://mmfss.freshservice.com/api/v2/tickets/'.$id.'/activities', false);

$data = json_decode($jsonData, true);

if (isset($data['next_page_url'])) {
    //echo "next_page_url is present. </br>";
    $nextPageUrl = $data["next_page_url"];
    $nextPagejsonData = callAPI('GET', $nextPageUrl, false);
    $nextPageData = json_decode($nextPagejsonData, true);
    //print_r($nextPageData);
    $data["activities"] = array_merge($data["activities"], $nextPageData["activities"]);
}

    //echo "<hr>";
    //print_r($data);

    $matchingData = array();

    foreach ($data['activities'] as $activity) {
        $content = $activity['content'];
        $subContents = $activity['sub_contents'];
        $actor = $activity['actor']['name'];
        $actorid = $activity['actor']['id'];
        $created_at = $activity['created_at'];            

        if (stripos($content, 'added item') !== false || stripos($content, 'Added item') !== false) {
            foreach ($subContents as $subContent) {
                if (strpos($subContent, 'set Service Category as') !== false) {
                    // Remove "added item " from the content
                    //echo "<strong>".$content."</strong>";
                    $content = str_replace('added item ', '', $content);
                    $content = str_replace('Added item ', '', $content);

                    // Remove "set Service Category as " from the sub_content
                    //$subContent = str_replace('set Service Category as ', '', $subContent);

                    // Remove " and Modified Brief Description" from the sub_content
                    //$subContent = str_replace(' and Modified Brief Description', '', $subContent);

                    $onlyServiceCategory = '';
                    $ServiceCategory = '';
                    $subCategory = '';
                    $subCategory1 = '';
                    $subCategory2 = '';


                    $pattern2 = '/set Service Category as (.*?),/';

                    if (preg_match($pattern2, $subContent, $matches)) {
                        $ServiceCategory = $matches[1];
                        //echo "Service Category: $ServiceCategory </br>";
                    } else {
                        $pattern1 = '/set Service Category as (.*?) and Modified Brief Description/';

                        if (preg_match($pattern1, $subContent, $matches)) {
                            $onlyServiceCategory = $matches[1];
                            //echo "Service Category: $ServiceCategory </br>";
                        }
                    }

                    $pattern3 = '/set Sub Category as (.*?) and Modified Brief Description/';

                    if (preg_match($pattern3, $subContent, $matches)) {
                        $subCategory = $matches[1];
                        //echo "Sub Category: $subCategory </br>";
                    }

                    $matchingData[] = array(
                        'content' => $content,
                        'onlyServiceCategory' => $onlyServiceCategory,
                        'ServiceCategory' => $ServiceCategory,
                        'subCategory' => $subCategory,
                        'actor' => $actor,
                        'actorid' => $actorid,
                        'created_at' => $created_at
                    );
                }

                if (strpos($subContent, 'set Application Name as') !== false){

                    // Remove "added item " from the content
                    //echo "<strong>".$content."</strong>";
                    $content = str_replace('added item ', '', $content);
                    $content = str_replace('Added item ', '', $content);

                    if (strpos($subContent, 'set Application Name as ') !== false) {
                        $pattern1 = '/set Application Name as (.*?),/';

                        if (preg_match($pattern1, $subContent, $matches)) {
                            $applicationName = $matches[1];
                            //echo "Application Name: $applicationName </br>";
                        }

                        $pattern2 = '/set Sub Category 1 as (.*?),/';

                        if (preg_match($pattern2, $subContent, $matches)) {
                            $subCategory1 = $matches[1];
                            //echo "Sub Category 1: $subCategory1 </br>";
                        }

                        $pattern3 = '/set Sub Category 2 as (.*?) and Modified Brief Description/';

                        if (preg_match($pattern3, $subContent, $matches)) {
                            $subCategory2 = $matches[1];
                            //echo "Sub Category 2: $subCategory2 </br>";
                        }
                    }
                                

                    $matchingData[] = array(
                        'content' => $content,
                        'applicationName' => $applicationName,
                        'subCategory1' => $subCategory1,
                        'subCategory2' => $subCategory2,
                        'actor' => $actor,
                        'actorid' => $actorid,
                        'created_at' => $created_at
                    );

                }
            }
        } // end checking for 'added item'
    }

    // Print the matching data
    // Optimized by ChatGPT --
    $labelMap = [
        'content' => 'Service Item',
        'sub_content' => 'Service Category',
        'ServiceCategory' => 'Service Category',
        'subCategory' => 'Sub Category',
        'onlyServiceCategory' => 'Service Category',
        'applicationName' => 'Application Name',
        'subCategory1' => 'Sub Category 1',
        'subCategory2' => 'Sub Category 2',
        'created_at' => 'When',
    ];
    
    $updatedString = '';
    
    foreach ($matchingData as $item) {
        foreach ($labelMap as $key => $label) {
            if (isset($item[$key]) && strlen($item[$key]) > 1) {
                if ($key === 'created_at') {
                    $tActionTime = getIST($item[$key]);
                    $updatedString .= "<tr><td class='tdwidth'><b>$label</b></td><td width='10px'>:</td><td>$tActionTime</td></tr>";
                } else {
                    $updatedString .= "<tr><td class='tdwidth'><b>$label</b></td><td width='10px'>:</td><td>{$item[$key]}</td></tr>";
                }
            }
        }
        $actorLink = '<a href="entity.php?id=' . $item['actorid'] . '" onclick="goclicky(this); return false;" target="_blank">' . strtoupper($item['actor']) . '</a>';
        $updatedString .= "<tr><td class='tdwidth'><b>Item added by</b></td><td width='10px'>:</td><td>$actorLink</td></tr>";
    }
    //----------------------- end category ----------------------//
    return $updatedString;
}

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo '<footer id="footer">Generated in '.$total_time.' seconds.</footer>';
?>
</body>
</html>