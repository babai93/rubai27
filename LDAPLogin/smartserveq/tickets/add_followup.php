<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content-type="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartServe Ticket Conversations</title>
    <link rel="icon" type="image/x-icon" href="../favicon/favicon.ico">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="act_con_style.css">
    <script src="jquery-1.7.min.js"></script>
    <script src="./scripts/goclicky.js"></script>
    <script src="./scripts/loading.js"></script>
    <link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.min.css">
    <script src="../ckeditor/ckeditor.js"></script>
    <style>
        .cke_chrome{
            /* border-radius: 6px;
            border: 1px solid #e6e7e8;
            border-width: thin;
            background-color: #e6e7e8;  */
            border : 0px !important;
        }
        .cke_contents {
            border-radius: 6px 6px 6px 6px
        }
        /* .cke_inner{
            background: #e6e7e8 !important; 
            border-radius: 6px !important;
        } */
    </style>
</head>
<body>
<?php
require "cURLsetup.php";
session_start();
$time = microtime(true);
$start = $time;
date_default_timezone_set('Asia/Kolkata');
$sessionTimeout = 330;

// Redirect to the login page if not logged in
if (!isset($_SESSION["username"])) {
    header("Location: relogin.php");
    exit();
}

// Check if the session has expired
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > ($sessionTimeout + 1))) {
    session_unset();
    session_destroy();
    header("Location: relogin.php?id=1");
    exit();
}

$_SESSION['LAST_ACTIVITY'] = time();
$uid = preg_replace('/[^0-9.]+/', '', $_SESSION["username"]);

    if(isset($_POST['reloadbtn'])) {
        $_SERVER['PHP_SELF'];
    }
    if(isset($_POST['logout'])) {
        // Redirect to logout.php with the session ID as a parameter
        header("Location: logout.php?id=" . $_SESSION["id"]);
        // Make sure to exit after the header redirection
        exit();
    }
?>
<div class="flex-container">
    <div class="box1">User ID: <?php echo $uid; ?></div>
    <div class="box2">
        <form method="post">
            <button disabled class="btn btnt" id="countdownClock"></button>
            <button class="btn btnb" name="reloadbtn">
                <i class="fa fa-refresh" aria-hidden="true"></i><span class="btn-text">&nbsp;Reload</span>
            </button>
            <button class="btn btnx" name="logout">
                <i class="fa fa-sign-out" aria-hidden="true"></i><span class="btn-text">&nbsp;Logout</span>
            </button>
        </form>
    </div>
</div>
<div id="countdownClock"></div>

<?php
$response = callAPI('GET', 'https://mmfss.freshservice.com/api/v2/requesters?query=user_id:'.$uid.'&include_agents=true', false);
$assoc_array = json_decode($response, true);

// echo '<div style="margin-top: 10px; text-align: center;">~ Under Development ~</div>';
// echo '<hr>';

if (!empty($assoc_array['requesters'][0]['id'])) {
    // echo "ID: " . $assoc_array['requesters'][0]['id'];
    echo '<div style="margin-top: 10px; text-align: center;">';
    echo "Hello " . $assoc_array['requesters'][0]['first_name'] . " " . $assoc_array['requesters'][0]['last_name'];
    echo " you can add comment for Ticket Number: #" . $_SESSION['id']. ' from here';
    echo '</div><hr>';
    echo '<div id="panel_activities" class="tab-pane-content selected"><ul class="nobullets">';
    echo '<li>';
    
    echo '<div id="contenthead" class="contenthead">
            <div id="content" class="content">
                <textarea id="editor" name="editor" placeholder="Enter your replay"></textarea>
            </div>
          </div>';
          echo '<input type="hidden" name="id" id="id" value='.$_SESSION['id'].'>';
          echo '<input type="hidden" name="user_id" id="user_id" value='.$assoc_array['requesters'][0]['id'].'>';
    echo '</li></ul></div>';
    
    echo '<div class="addnote">';
    echo '<p style="font-size: 13px; max-width: 60%" id="responseText"></p>';
        echo getStatus($_SESSION['id']);
    echo '</div>';
} else {
    echo "ID not found in the JSON data.";
    exit;
}

if ($assoc_array['requesters'][0]['id'] == 0) {
    echo '<div id="panel_activities" class="tab-pane-content selected"><ul class="nobullets">';
    echo '<li><div id="contenthead" class="contenthead"><div id="content" class="content">';
    echo "<h1>No conversations found</h1>";
    echo '</div><li><ul></div></div>';
    exit;
}
?>
<script>
    function updateCountdown() {
        var currentTime = Math.floor(Date.now() / 1000);
        var lastActivityTime = <?php echo $_SESSION['LAST_ACTIVITY']; ?>;
        var sessionTimeout = <?php echo $sessionTimeout; ?>;
        var remainingTime = lastActivityTime + sessionTimeout - currentTime;

        if (remainingTime > 0) {
            var minutes = Math.floor(remainingTime / 60);
            var seconds = remainingTime % 60;

            var formattedTime = (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;

            document.getElementById('countdownClock').innerHTML = formattedTime;
        } else {
            document.getElementById('countdownClock').innerHTML = 'Session Timeout: 00:00';
            clearInterval(timerInterval);
            window.location.href = 'logout.php?id=1';
        }
    }

    var timerInterval = setInterval(updateCountdown, 1000);
</script>
<script>
        CKEDITOR.replace('editor');

        document.getElementById('submitBtn').addEventListener('click', function() {
            // Get the CKEditor content
            var editorData = CKEDITOR.instances.editor.getData();
            var id = document.getElementById('id').value;
            var user_id = document.getElementById('user_id').value;

            //alert(editorData);
            var formData = 'id=' + encodeURIComponent(id) + '&user_id=' + encodeURIComponent(user_id) + '&body=' + encodeURIComponent(editorData);
            //console.log(formData);

            // Send the data to the server using AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'process_form.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Handle the server response if needed
                    //console.log(xhr.responseText);
                    document.getElementById('responseText').innerHTML = xhr.responseText;
                    if (xhr.responseText.includes("successfully")){
                        window.location.href = "conversation.php?id=" + id;
                    }
                }
            };
            //xhr.send('id=' + id + '&user_id=' + user_id + '&body=' + encodeURIComponent(editorData));
            xhr.send(formData);
        });
    </script>

<?php
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

    $TicketStatusBtn .= '<button ' . $disabledAttribute . ' type="submit" id="submitBtn" class="btn btn-primary">Add Comment</button>';
    
    return $TicketStatusBtn;
}

function goback($id){
    sleep(5);
    // Redirect to another page
    header("Location: conversation.php?id=" . $id);
    exit; // Make sure to exit to prevent further execution
}

$time = microtime(true);
$finish = $time;
$total_time = round(($finish - $start), 4);
echo '<footer id="footer">Generated in '.$total_time.' seconds.</footer>';
?>
</body>
</html>