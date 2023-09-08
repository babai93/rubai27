<!--filename conversation.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content-type="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartServe Ticket Conversations</title>
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="act_con_style.css">
    <script type="text/javascript" src="jquery-1.7.min.js"></script>
    <script type="text/javascript" src=".\scripts\goclicky.js"></script>
    <script type="text/javascript" src=".\scripts\loading.js"></script>
    <link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.min.css">
</head>
<body>
<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
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
            echo '<div class="box2">
            <form method="post">
            <button class="btn btnb" name="reloadbtn"><i class="fa fa-refresh" aria-hidden="true"></i><span class="btn-text">&nbsp;Reload</span>
            </button>
            <button class="btn btnx" onclick="self.close();"><i class="fa fa-times" aria-hidden="true"></i><span class="btn-text">&nbsp;Close</span>
            </button></form></div>
            </div>';
	} else {
			echo "Please enter valid number like <strong>activity.php?id=23889</strong></br>";
			echo "<a href='./'>back to submit page</a></td></tr>";
	}
    ?>
<?php
$response = callAPI('GET', 'https://mmfss.freshservice.com/api/v2/tickets/'.$id.'/conversations', false);
$assoc_array = json_decode($response, true);

if ($assoc_array['meta']['count'] == 0){
    echo '<div id="panel_activities" class="tab-pane-content selected"><ul class="nobullets">';
    echo '<li><div id="contenthead" class="contenthead"><div id="content" class="content">';
    echo "<h1>No conversations found</h1>";
    echo '</div><li><ul></div></div>';
    //exit;
}

//------------------------ marge json ----------------------//
// if (isset($assoc_array['next_page_url'])) {
//     //echo "next_page_url is present. </br>";
//     $nextPageUrl = $assoc_array["next_page_url"];
//     $nextPagejsonData = callAPI('GET', $nextPageUrl, false);
//     $nextPageData = json_decode($nextPagejsonData, true);
//     //print_r($nextPageData);
//     $assoc_array["conversations"] = array_merge($assoc_array["conversations"], $nextPageData["conversations"]);
// }

if (isset($assoc_array['next_page_url'])) {
    $nextPageUrl = $assoc_array["next_page_url"];
    $nextPagejsonData = callAPI('GET', $nextPageUrl, false);

    if ($nextPagejsonData !== false) {
        $nextPageData = json_decode($nextPagejsonData, true);

        if (isset($nextPageData["conversations"]) && is_array($nextPageData["conversations"])) {
            if (isset($assoc_array["conversations"]) && is_array($assoc_array["conversations"])) {
                $assoc_array["conversations"] = array_merge($assoc_array["conversations"], $nextPageData["conversations"]);
            } else {
                $assoc_array["conversations"] = $nextPageData["conversations"];
            }
        }
    }
}

//-----------------------end marge json --------------------//
?>
<div id="panel_activities" class="tab-pane-content selected"><ul class="nobullets">

<?php foreach (array_reverse($assoc_array['conversations']) as $x => $x_value): ?>
<li>
    <div id="contenthead" class="contenthead">
        <div class="reponderntime">
            <div class="reponder"><?php
                $responder = strtoupper(getAgentNameOnly($x_value['user_id']));
                echo '<div class="executor-icon"><strong>'.mb_substr(($responder), 0, 1).'</strong></div>';
                     echo "<div class'reponder-name'>".$responder."<span style='color:#4d4d4f;'>&nbsp;";
                     echo getreplaysource($x_value['source']);
                     echo '</span></div>';
            ?></div>
            <div class="timeing"><?php echo '<i class="fa fa-clock-o icon-gray" aria-hidden="true">&nbsp;</i>' . getIST($x_value['updated_at']); ?></div>
        </div>
        
        <div id="content" class="content">
            <?php
                if ($x_value['source'] == 5) {
                    echo getcsat($id);
                } else {
                    echo ucfirst(trim($x_value['body']));
                }
            ?>
        </div>
    </div>
    </li>

    <?php endforeach; ?>
</ul></div>
<div class="addnote">
    <?php echo getStatus($id); ?>
</div>
<br>

<script>
function openUrl(id) {
    // Construct the URL with the parameter
    var url = 'relogin.php?id=' + encodeURIComponent(id);
    window.open(url, '_self');
}
</script>

<?php
function getIST($datetime)
{
    if ($datetime === null) { return ""; }
    $datetime = new DateTime($datetime, new DateTimeZone('UTC'));
    $datetime->setTimezone(new DateTimeZone('Asia/Kolkata'));
    return $datetime->format('d-m-Y h:i A'); // Output: 31-08-2023 10:02 PM
}

function getcsat($id) // optimize by ChatGPT
{
    if ($id === null) {
        return "";
    }

    $response = callAPI('GET', 'https://mmfss.freshservice.com/api/v2/tickets/'.$id.'/csat_response', false);
    $assoc_array = json_decode($response, true);

    if (isset($assoc_array['csat_response']['score']['acquired_score'])) {
        $out = $assoc_array['csat_response']['score']['acquired_score'];

        $values = [
            2 => '&#x2B50; &#x2B50;',
            3 => '&#x2B50; &#x2B50; &#x2B50;',
            4 => '&#x2B50; &#x2B50; &#x2B50; &#x2B50;',
            5 => '&#x2B50; &#x2B50; &#x2B50; &#x2B50; &#x2B50;'
        ];

        if (isset($values[$out])) {
            return "Requester has submitted the survey response! " . $values[$out];
        } else {
            $out = $assoc_array['csat_response']['questionnaire_responses'][1]['answers'][0]['answer_text'];
            return "Requester has refused the solution!! Remarks: " . $out;
        }
    } else {
        return "";
    }
}

function getreplaysource($id) // optimize by ChatGPT
{
    $values = [
        0 => 'has replied',
        2 => 'added a note',
        5 => 'has submitted the feedback'
    ];

    return $values[$id] ?? 'has replyed';
}

function getAgentNameOnly($id) // optimize by ChatGPT
{
    $response = callAPI('GET', 'https://mmfss.freshservice.com/api/v2/requesters/'.$id, false);
    $data = json_decode($response);

    if (!isset($data->requester->first_name) || !isset($data->requester->last_name)) {
        return '';
    }

    $AgentName = $data->requester->first_name . ' ' . $data->requester->last_name;
    return $AgentName;
}

function getStatus($id) // optimize by ChatGPT
{
    $statusLabels = [
        2 => 'Open',
        3 => 'Pending',
        4 => 'Resolved',
        5 => 'Closed'
    ];

    $response = callAPI('GET', 'https://mmfss.freshservice.com/api/v2/tickets/'.$id, false);
    $ticketData = json_decode($response, true);

    if (!isset($ticketData['ticket']['status'])) {
        return "Unable to read the Ticket status!!";
    }

    $ticketStatus = $ticketData['ticket']['status'];
    $result = $statusLabels[$ticketStatus] ?? 'null';
    
    $isStatus45 = in_array($ticketStatus, [4, 5]);
    $opacity = $isStatus45 ? 1 : 0;

    $TicketStatusBtn = '<label class="statusmsg" style="opacity: '.$opacity.'">Ticket status is <b>'.$result.'</b>';
    $TicketStatusBtn .= $isStatus45 ? ', adding comment is not allowed.' : '.';
    $TicketStatusBtn .= '</label>';
    
    $disabledAttribute = $isStatus45 ? 'disabled' : '';

    $TicketStatusBtn .= '<button ' . $disabledAttribute . ' type="button" id="myButton" class="btn btn-primary" onclick="openUrl('.$id.')">Add Comment</button>';
    
    return $TicketStatusBtn;
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