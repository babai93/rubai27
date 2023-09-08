<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartServe Ticket Details</title>
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="jquery-1.7.min.js"></script>
    <script type="text/javascript" src=".\scripts\goclicky.js"></script>
    <script type="text/javascript" src=".\scripts\loading.js"></script>
    <script type="text/javascript" src=".\scripts\hideunhide.js"></script>

    <style>
    body {
        position: relative;
        min-height: 100vh;
        }
    #content-wrap {
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

      /* New Tabs */
      .tabs {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            /* display: flex;
            flex-wrap: wrap;
            flex-direction:row; */
        }
        .tabs label {
            order: 1; /* Put the labels first */
            display: block;
            padding: 0.5rem;
            text-align: center;
            width: 46%;
            cursor: pointer;
            border: 1px solid #4f4f44;
            border-radius: 5px;
            background: #e5e5e5;
            font-weight: bold;
            transition: background ease 0.2s;
        }
        .tabs .tab {
        order: 99; // Put the tabs last
        flex-grow: 1;
            width: 100%;
            display: none;
        /* padding: 1rem; */
        /* background: #fff; */
        }
        .tabs input[type="radio"] {
            display: none;
        }
        .tabs input[type="radio"]:checked + label {
            background: #fff;
            border-bottom: 2px solid #fd264f;
        }
        .tabs input[type="radio"]:checked + label + .tab {
            display: block;
        }

        @media (max-width: 45em) {
        .tabs .tab,
        .tabs label {
            order: initial;
        }
        .tabs label {
            width: 100%;
            margin-right: 0;
            margin-top: 0.2rem;
        }
        }
    
      /* activity sub_contents */
      .sub_contents{
            /*background-color:blue;*/
            margin-top: 1px;
            font-size: 0.8rem;
            margin: 0 0 1px 0;
            border-radius: 0 0 4px 4px;
        }
    </style>
</head>
<body>

<?php
$title = "SamrtServe Ticket Details";

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

include "header.php";
?>
<div id="content-wrap">
<div class="fixed-bottom-left"><a href="./lite.php">Use lite version</a></div>
<article>
    <div class="output">
        <div id="flex">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <div class="flex">
            <label for="tnum">Ticket Number:</label>
            <input style="min-width:250px;" type="text" name="tnum" require>
        </div>
            <input id="ajaxButton" type="submit">
        </form>
        </div>
    </div>
<?php
require "cURLsetup.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $tktno = $_POST['tnum'];
    if (empty($tktno)) {
        echo "<div style='text-align: center;'>";
        echo "Ticket number is empty";
        echo "</div>";
    } else {
        echo "<div style='text-align: center;'>";
        echo "Data for Ticket number #".$tktno = preg_replace('/[^0-9.]+/', '', $tktno);
        echo "</div>";
        getrpt($tktno);
    }
}
?>
</article>
</div>
</body>
</html>


<?php
function getrpt($TicketNo)
{
    $response = callAPI('GET', 'https://mmfss.freshservice.com/api/v2/tickets/'.$TicketNo.'?include=tags,requester,requested_for,stats,conversations', false);
    $assoc_array = json_decode($response, true);
    echo '<div class="output">';
    echo '<div class="flexr">';
    echo '<div class="float-child-element">';
    echo '<div class="leftb text_container">';
        echo '<label for="rname">Requester Name:</label>';
        $rself = getname($assoc_array['ticket']['requester_id']);
        $rname = $rself['name'];
        echo "<input type='text' name='rfname' value='$rname' class='icon' readonly>";
        echo '<div><!--Hidden Div-->
		<table class="gTable" style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="0">
        <tbody>
            <tr>
            <td>Entity Code :</td>
            <td>'.$rself['UID'].'</td>
            </tr>
            <tr>
            <td>Department : </td>
            <td>'.$rself['Dept'].'</td>
            </tr>
            <tr>
            <td>Grade : </td>
            <td>'.$rself['grade'].'</td>
            </tr>
            <tr>
            <td>Company :</td>
            <td>'.$rself['company'].'</td>
            </tr>
            <tr>
            <td>Designation :</td>
            <td>'.$rself['job_title'].'</td>
            </tr>
            <tr>
            <td>Branch Name :</td>
            <td>'.$rself['branch_name'].'</td>
            </tr>
            <tr>
            <td>Mobile No. : </td>
            <td>'.$rself['mobile_phone_number'].'</td>
            </tr>
            <tr>
            <td>Email ID :</td>
            <td>'.$rself['primary_email'].'</td>
            </tr>
            <tr>
            <td>RM Name :</td>';
            $rmanager = getname($rself['reporting_manager_id']);
            //echo '<td>'.$rmanager['name'].'</td>';
            echo '<td> <a class="link-articles" href="entity.php?id='
                                .$rself['reporting_manager_id'].'" onclick="goclicky(this); return false;" target="_blank">'.$rmanager['name'].'</td></tr>';
            echo '</tr>
        </tbody>
        </table>
	    </div>';
    echo '</div></div>';
    echo '<div class="float-child-element">';
    
    if ($assoc_array['ticket']['requester_id'] != $assoc_array['ticket']['requested_for_id']){
        echo '<div class="rightb text_container">';
        echo '<label for="rfname">Requested for Name:</label>';
        $rfor = getname($assoc_array['ticket']['requested_for_id']);
        $rfname = $rfor['name'];
        echo "<input type='text' name='rfname' value='$rfname' class='icon' readonly>";
        echo '<div><!--Hidden Div-->
            <table class="gTable" style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="0">
            <tbody>
                <tr>
                <td>Entity Code :</td>
                <td>'.$rfor['UID'].'</td>
                </tr>
                <tr>
                <td>Department : </td>
                <td>'.$rfor['Dept'].'</td>
                </tr>
                <tr>
                <td>Grade : </td>
                <td>'.$rfor['grade'].'</td>
                </tr>
                <tr>
                <td>Company :</td>
                <td>'.$rfor['company'].'</td>
                </tr>
                <tr>
                <td>Designation :</td>
                <td>'.$rfor['job_title'].'</td>
                </tr>
                <tr>
                <td>Branch Name :</td>
                <td>'.$rfor['branch_name'].'</td>
                </tr>
                <tr>
                <td>Mobile No. : </td>
                <td>'.$rfor['mobile_phone_number'].'</td>
                </tr>
                <tr>
                <td>Email ID :</td>
                <td>'.$rfor['primary_email'].'</td>
                </tr>
                <tr>
                <td>RM Name :</td>';
                $rmanager = getname($rfor['reporting_manager_id']);
                echo '<td>'.$rmanager['name'].'</td>
                </tr>
            </tbody>
            </table>
            </div>';
        echo '</div>';
    }
    echo '</div></div>';
    echo '<div class="flexr">';
    echo '<div class="float-child-element">';
    echo '<div class="leftb">';
    echo '<label for="ttype">Ticket Type:</label>';
    echo '<input type="text" name="ttype" value="'.$assoc_array['ticket']['type'].'" readonly>';
    echo '</div></div>';
    echo '<div class="float-child-element">';
    echo '<div class="rightb">';
    echo '<label for="tsource">Ticket Source:</label>';
    $tsource = getsource($assoc_array['ticket']['source']);
    echo "<input type='text' name='tsource' value='$tsource' readonly>";
    echo '</div></div>';
    echo '</div>';
    echo '<div class="flex" id="subject">';
    echo '<label for="tSubject">Ticket Subject:</label>';
    echo '<input type="text" name="tSubject" value="'.$assoc_array['ticket']['subject'].'" readonly>';
    $istspam = $assoc_array['ticket']['spam'];
    if ($istspam == "true"){
        echo "<div id='spam'>Spam</div>";
    }
    echo '</div>';
    echo '<div class="flexr">';
    echo '<div class="float-child-element">';
    echo '<div class="leftb">';
    echo '<label for="tstatus">Ticket Status:</label>';
    $tstatus = getstatus($assoc_array['ticket']['status']);
    echo "<input type='text' name='tstatus' value='$tstatus' readonly>";
    echo '</div></div>';
    echo '<div class="float-child-element">';
    echo '<div class="rightb">';
    echo '<label for="tpriority">Ticket priority:</label>';
    $tpriority = getpriority($assoc_array['ticket']['priority']);
    echo "<input type='text' name='tpriority' value='$tpriority' readonly>";
    echo '</div></div>';
    echo '</div>';
    echo '<div class="flexr">';
    echo '<div class="float-child-element">';
    echo '<div class="leftb">';
    echo '<label for="tCreated">Ticket Created on:</label>';
    $tcreatedat = getIST($assoc_array['ticket']['created_at']);
    echo "<input type='text' name='tCreated' value='$tcreatedat' readonly>";
    echo '</div></div>';
    echo '<div class="float-child-element">';
    echo '<div class="rightb">';
    echo '<label for="tdue_by">Ticket Resolution due:</label>';
    $tdue_by = getIST($assoc_array['ticket']['due_by']);
    echo "<input type='text' name='tdue_by' value='$tdue_by' readonly>";
    echo '</div></div>';
    echo '</div>';
    echo '<div class="flexr">';

    if ($assoc_array['ticket']['group_id'] != null){
        $tAssignedG = getAssignedG($assoc_array['ticket']['group_id']);
        $tGroupMember = getGroupMember($assoc_array['ticket']['group_id']);
        echo '<div class="float-child-element">';
        echo '<div class="leftb text_container">';
        echo '<label for="tAssignedG">Ticket Assigned to Group:</label>';
        echo "<input type='text' name='tAssignedG' value='$tAssignedG' class='icon' readonly>";
                            //-----------------
                            echo "<div><!--Hidden Div-->
                            $tGroupMember</div> <!--Group Member-->";
                            //-----------------
        echo '</div></div>';
    } else {
        $tAssignedG = "Blank";
        $tGroupMember = null;
        echo '<div class="float-child-element">';
        echo '<div class="leftb">';
        echo '<label for="tAssignedG">Ticket Assigned to Group:</label>';
        echo "<input type='text' name='tAssignedG' value='$tAssignedG' readonly>";
        echo '</div></div>';
    }
    $tAssignedA = getname($assoc_array['ticket']['responder_id']);
    $tAssignedAname = $tAssignedA['name'];
        echo '<div class="float-child-element">';
        if ($tAssignedAname == "Blank"){
            echo '<div class="rightb">';
            echo '<label for="tAssignedA">Agent:</label>';
            echo "<input type='text' name='tAssignedA' value='$tAssignedAname' readonly>";
        } else {
            echo '<div class="rightb text_container">';
            echo '<label for="tAssignedA">Agent:</label>';
            echo "<input type='text' name='tAssignedA' value='$tAssignedAname' class='icon' readonly>";
            //-----------------
            echo '<div><!--Hidden Div-->
            <table class="gTable" style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="0">
            <tbody>
                <tr>
                <td>Entity Code :</td>
                <td>'.$tAssignedA['UID'].'</td>
                </tr>
                <tr>
                <td>Department : </td>
                <td>'.$tAssignedA['Dept'].'</td>
                </tr>
                <tr>
                <td>Company :</td>
                <td>'.$tAssignedA['company'].'</td>
                </tr>
                <tr>
                <td>Branch Name :</td>
                <td>'.$tAssignedA['branch_name'].'</td>
                </tr>
                <tr>
                <td>Mobile No. : </td>
                <td>'.$tAssignedA['mobile_phone_number'].'</td>
                </tr>
                <tr>
                <td>Email ID :</td>
                <td>'.$tAssignedA['primary_email'].'</td>
                </tr>
                <tr>
                <td>RM Name :</td>';
                $rmanager = getname($tAssignedA['reporting_manager_id']);
                echo '<td>'.$rmanager['name'].'</td>
                </tr>
            </tbody>
            </table>
            </div>';
            //--------------------
        }
        echo '</div></div>';
    echo '</div>';
        echo '<div class="flex">';
        echo '<label for="tdescription">Ticket description:</label>';
        //echo '<textarea type="text" name="tdescription" value="'.$assoc_array['ticket']['subject'].'" readonly>';
        echo '<textarea name="tdescription" rows="8" cols="90" wrap="soft" style="overflow-y:hidden" readonly>'.$assoc_array['ticket']['description_text'].'</textarea>';
        echo '</div>';
        echo '<br><div class="flexr">';
        echo '<div class="float-child-element">';
        echo '<div class="leftb">';
        echo '<label for="tResolved">Ticket Resolved on:</label>';
        if ($assoc_array['ticket']['status'] === 4 || $assoc_array['ticket']['status'] === 5) {
            $tResolvedAt = getIST($assoc_array['ticket']['stats']['resolved_at']);
        } else {
            $tResolvedAt = "";
        }
        echo "<input type='text' name='tResolved' value='$tResolvedAt' readonly>";
        echo '</div></div>';
        echo '<div class="float-child-element">';
        echo '<div class="rightb">';
        echo '<label for="tClosed">Ticket Closed on:</label>';
        if ($assoc_array['ticket']['status'] === 5) {
            $tClosedAt = getIST($assoc_array['ticket']['stats']['closed_at']);
        } else {
            $tClosedAt = "";
        }
        echo "<input type='text' name='tClosed' value='$tClosedAt' readonly>";
        echo '</div></div>';
    echo '<br></div>';

    // tabs
    echo '<div class="Conversations">'; // div1
    echo '<div class="tabs"><input type="radio" name="tabs" id="tabone" checked="checked">
    <label for="tabone"><span id="labelt">Conversations: <span style="color:orange;">[BETA Stage]</span></span></label>
    <div class="tab">';
                    // conversation start
                    echo "<div class='contains'>";
                    $tconversations = $assoc_array['ticket']['conversations'];
                    if (empty($tconversations)) {
                        echo '<div class="ConversationsData">';
                        echo "<div class='databody' style='margin:auto'>No Conversations</div>";
                        echo '</div>';
                    }
                    foreach($tconversations as $x => $x_value) {
                        echo '<div class="ConversationsData">'; //div7
                            echo '<div class="reponderntime">';    //div8
                                echo '<div class="reponder">';  //div9
                                $respondernameid = ($x_value['user_id']);
                                $respondername = strtoupper(getAgentNameOnly($respondernameid));
                                echo $respondername;
                                echo " <span style='color:#4d4d4f;'>";
                                echo getreplaysource($x_value['source']);
                                echo '</span></div>';   //div9
                                echo '<div class="timeing">';   //div10
                                echo getIST($x_value['updated_at']);
                                echo '</div>';  //div10
                            echo '</div>';  //div8
                            if ($x_value['source'] == 5){
                                $csatscore = getcsat($TicketNo);
                                echo "<div class='databody'>".$csatscore."</div>";
                            } else {
                                echo "<div class='databody'>".$x_value['body_text']."</div>";
                            }
                        echo "<br>";
                        echo '</div>';  //div7
                    }
                    echo "</div>"; //div4
		            // conversation end
                echo '</div>';
                
                echo '<input type="radio" name="tabs" id="tabtwo">
                <label for="tabtwo"><span id="labelt">Activities</span></label>
                <div class="tab">';
                    // activity start
                    echo "<div class='contains'>";
                    $response = callAPI('GET', 'https://mmfss.freshservice.com/api/v2/tickets/'.$TicketNo.'/activities', false);
                    $assoc_array = json_decode($response, true);

                    //------------------------ marge json ----------------------//
                    if (isset($assoc_array['next_page_url'])) {
                        //echo "next_page_url is present. </br>";
                        $nextPageUrl = $assoc_array["next_page_url"];
                        $nextPagejsonData = callAPI('GET', $nextPageUrl, false);
                        $nextPageData = json_decode($nextPagejsonData, true);
                        //print_r($nextPageData);
                        $assoc_array["activities"] = array_merge($assoc_array["activities"], $nextPageData["activities"]);
                    }
                    //-----------------------end marge json --------------------//
                    foreach ($assoc_array['activities'] as $activity){
                        echo '<div class="ConversationsData">';
                            echo '<div class="reponderntime">';
                                echo '<div class="reponder">';
                                    echo $activity['actor']['name'];
                                echo '</div>';
                                echo '<div class="timeing">';
                                    echo getIST($activity['created_at']);
                                echo '</div>';
                            echo '</div>';
                            echo '<div id="content" class="databody">';
                                echo ucfirst(trim($activity['content']));
                                echo '<div id="sub_contents" class="sub_contents">';
                                if (isset($activity['sub_contents'])){
                                    echo '<ul>';
                                    foreach ($activity['sub_contents'] as $sub_content){
                                        echo '<li>'.ucfirst(trim($sub_content)).'</li>';
                                    }
                                    echo '</ul>';
                                }
                                echo '</div>';
                            echo  '</div>';
                        echo "<br>";
                        echo  '</div>';
                    }
                    // activity end  
                echo '</div>'; // div4
            
            echo '</div>';  //div2
    echo '</div>'; // div1

    //raw data
    /*echo "<hr>";
    echo"<pre>"; 
    var_dump(json_decode($response, true)); 
    echo"</pre>";
    echo "<hr>";*/
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

function getreplaysource($id)
{
    $values = [
        0 => 'has replied',
        2 => 'added a note',
        5 => 'has submitted the feedback'
    ];
    if (isset($values[$id])) {
        $result = $values[$id];
    } else {
        $result = 'has Replayed';
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
    if ($datetime === null) { return ""; }
    $datetime = new DateTime($datetime, new DateTimeZone('UTC'));
    $datetime->setTimezone(new DateTimeZone('Asia/Kolkata'));
    return $datetime->format('d-m-Y h:i A'); // Output: 31-08-2023 10:02 PM
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

function getGroupMember($id)
{
    $response = callAPI('GET', 'https://mmfss.freshservice.com/api/v2/groups/'.$id, false);
    $obj = json_decode($response);
    $agent_ids = $obj->group->members;

    $updatedString = '<span id="labelt">Members:</span><br><table class="gTable" style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="0"><tbody>';

        foreach ($agent_ids as $agent_id) {
            $GmemberName = getname($agent_id);
            $updatedString .= "<tr><td>".strtoupper($GmemberName['name'])."</td>";
            //$updatedString .= "<td style='text-align: center;'>".$GmemberName['UID']."</td></tr>";
            $updatedString .= '<td class="grow"> <a class="link-articles" href="entity.php?id='
                                .$agent_id.'" onclick="goclicky(this); return false;" target="_blank">&nbsp;'.$GmemberName['UID'].'&nbsp;</td></tr>';
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

function getcsat($id)
{
    if ($id === null) {
        $result = " ";
        return $result;
      } else {
        $response = callAPI('GET', 'https://mmfss.freshservice.com/api/v2/tickets/'.$id.'/csat_response', false);
        //echo $response;
        $assoc_array = json_decode($response, true);
        $out = $assoc_array['csat_response']['score']['acquired_score'];
   
        $values = [
            2 => '&#x2B50; &#x2B50;',
            3 => '&#x2B50; &#x2B50; &#x2B50;',
            4 => '&#x2B50; &#x2B50; &#x2B50; &#x2B50;',
            5 => '&#x2B50; &#x2B50; &#x2B50; &#x2B50; &#x2B50;'
        ];
        if (isset($values[$out])) {
            $result = "Requester has submitted the survey response,".$values[$out];
        } else {
            $out = $assoc_array['csat_response']['questionnaire_responses'][1]['answers'][0]['answer_text'];
            $result = "Requester has refused the solution!! Remarks: ".$out;
        }
        return $result; // return CSAT Stars
      }
}

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo '<footer id="footer">Generated in '.$total_time.' seconds.</footer>';
?>