<!-- filename activity.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content-type="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartServe Ticket Activity</title>
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
$response = callAPI('GET', 'https://mmfss.freshservice.com/api/v2/tickets/'.$id.'/activities', false);
$assoc_array = json_decode($response, true);

//------------------------ marge json ----------------------//
if (isset($assoc_array['next_page_url'])) {
    $nextPageUrl = $assoc_array["next_page_url"];
    $nextPagejsonData = callAPI('GET', $nextPageUrl, false);

    if ($nextPagejsonData !== false) {
        $nextPageData = json_decode($nextPagejsonData, true);

        if (isset($nextPageData["activities"]) && is_array($nextPageData["activities"])) {
            if (isset($assoc_array["activities"]) && is_array($assoc_array["activities"])) {
                $assoc_array["activities"] = array_merge($assoc_array["activities"], $nextPageData["activities"]);
            } else {
                $assoc_array["activities"] = $nextPageData["activities"];
            }
        }
    }
}
//-----------------------end marge json --------------------//
?>

<div id="panel_activities" class="tab-pane-content selected">
<ul class="nobullets">

<?php foreach ($assoc_array['activities'] as $activity): ?>
    <li>
        <div id="contenthead" class="contenthead">
            <div class="reponderntime">
                <div class="reponder">
                    <?php
                    $actorName = $activity['actor']['name'];
                    $actorInitial = ($activity['actor']['id'] == 0) ? '<i class="fa fa-cogs" aria-hidden="true"></i>' : '<strong>' . mb_substr($actorName, 0, 1) . '</strong>';
                    echo '<div class="executor-icon">' . $actorInitial . '</div>';
                    echo '<div class="reponder-name">' . $actorName . '</div>';
                    ?>
                </div>
                <div class="timeing">
                    <i class="fa fa-clock-o icon-gray" aria-hidden="true"></i> <?= getIST($activity['created_at']) ?>
                </div>
            </div>
            <div class="content">
                <?= ucfirst(trim($activity['content'])) ?>
            </div>
            <div class="sub_contents">
                <?php if (isset($activity['sub_contents'])): ?>
                    <ul>
                        <?php foreach ($activity['sub_contents'] as $sub_content): ?>
                            <li><?= ucfirst(trim($sub_content)) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </li>
<?php endforeach; ?>

</ul></div><br>

<?php
function getIST($datetime)
{
    if ($datetime === null) { return ""; }
    $datetime = new DateTime($datetime, new DateTimeZone('UTC'));
    $datetime->setTimezone(new DateTimeZone('Asia/Kolkata'));
    return $datetime->format('d-m-Y h:i A'); // Output: 31-08-2023 10:02 PM
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