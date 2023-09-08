<!-- filename description.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartServe Ticket Description</title>
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="act_con_style.css">
    <script type="text/javascript" src="jquery-1.7.min.js"></script>
    <script type="text/javascript" src=".\scripts\goclicky.js"></script>
    <script type="text/javascript" src=".\scripts\loading.js"></script>
    <link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.min.css">
    <!-- Include jQuery library -->
    <!--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->
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
$tDTLS = getTicketDTLS($id);

echo '<div class="data">';
echo '<div id="panel_activities" class="tab-pane-content selected"><ul class="nobullets">';
echo '<li><div id="contenthead" class="contenthead"><div id="content" class="content">';
echo $tDTLS;
echo '</div><li><ul></div></div>';
echo '</div>';

function getTicketDTLS($id)
{
	$updatedString = "<div>";
    $json = callAPI('GET', 'https://mmfss.freshservice.com/api/v2/tickets/'.$id, false);
    //UAT// $json = callAPI('GET', 'https://mmfss-fs-sandbox.freshservice.com/api/v2/tickets/'.$id, false);
    $obj = json_decode($json, true);

    $descriptionhtml = $obj['ticket']['description'];
    $updatedString .= $descriptionhtml;
    $updatedString .="</div><hr style='border-top: 1px solid #fff;'>";
    // Get the "attachments" array and count its elements
    $attachments = $obj['ticket']['attachments'];
    $numberOfAttachments = count($attachments);
    $updatedString .= "<div class='attachments'>Attachments ($numberOfAttachments)";
    // Loop through each attachment and print its name and id
    $updatedString .= "<div class='docattachments'>";
    foreach ($attachments as $attachment) {
        $updatedString .= "<div>";
        $name = $attachment['name'];
        $id = $attachment['id'];
        $updatedString .= "<big>&#128462;</big>&nbsp; $name &nbsp;
        <a href='https://smartserve.mahindrafs.com/helpdesk/attachments/$id?download=true' download><big>[&#65516;]</big></a>";
        $updatedString .= "</div>";
    }
    $updatedString .= "</div></div>";

    $html = $updatedString;

    $startIndex = strpos($html, '<div style="background-color:yellow;');
    $startIndex1 = strpos($html, "<div style='background-color:yellow;");
    
    // Check if either variation of the div is found
    if ($startIndex !== false || $startIndex1 !== false) {
        // Find the closing tag of the div
        $endIndex = strpos($html, '</div>', max($startIndex, $startIndex1));
        if ($endIndex !== false) {
            // Remove the div from the HTML content
            $html = substr_replace($html, '', max($startIndex, $startIndex1), $endIndex - max($startIndex, $startIndex1) + strlen('</div>'));
        }
    }
    $html = preg_replace('/<font color="Black"><br>[\s\S]*?---DISCLAIMER---[\s\S]*?<\/font>/', '', $html);
    return $html;
}

// https://mmfss-fs-sandbox.freshservice.com/helpdesk/attachments/130000019012?download=true

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo '<footer id="footer">Generated in '.$total_time.' seconds.</footer>';
?>
</body>
</html>