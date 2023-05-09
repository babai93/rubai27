<!DOCTYPE html>
<html>
<script>
function(){
  function id(v){ return document.getElementById(v); }
  function loadbar() {
    var ovrl = id("overlay"),
        prog = id("progress"),
        stat = id("progstat"),
        img = document.images,
        c = 0,
        tot = img.length;
    if(tot == 0) return doneLoading();

    function imgLoaded(){
      c += 1;
      var perc = ((100/tot*c) << 0) +"%";
      prog.style.width = perc;
      stat.innerHTML = "Loading "+ perc;
      if(c===tot) return doneLoading();
    }
    function doneLoading(){
      ovrl.style.opacity = 0;
      setTimeout(function(){ 
        ovrl.style.display = "none";
      }, 1200);
    }
    for(var i=0; i<tot; i++) {
      var tImg     = new Image();
      tImg.onload  = imgLoaded;
      tImg.onerror = imgLoaded;
      tImg.src     = img[i].src;
    }    
  }
  document.addEventListener('DOMContentLoaded', loadbar, false);
}
</script>
<style>
    #overlay{
    position:fixed;
    z-index:99999;
    top:0;
    left:0;
    bottom:0;
    right:0;
    background:rgba(0,0,0,0.9);
    transition: 1s 0.4s;
    }
    #progress{
    height:1px;
    background:#fff;
    position:absolute;
    width:0;                /* will be increased by JS */
    top:50%;
    }
    #progstat{
    font-size:0.7em;
    letter-spacing: 3px;
    position:absolute;
    top:50%;
    margin-top:-40px;
    width:100%;
    text-align:center;
    color:#fff;
    }
</style>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Georama|Audiowide|Sofia|Titillium Web">
<link rel="stylesheet" href="style.css">
<body>

<!--Start Loading page--
<div id="overlay">
  <div id="progstat"></div>
  <div id="progress"></div>
</div>

<div id="container">
  <img src="http://placehold.it/3000x3000/cf5">
</div>
<!--End Loading page-->
<header>
<h1>SmartServe Ticket details</h1>
</header>

<article>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<div class="flex">
    <label for="tnum">Ticket Number:</label>
    <input type="text" name="tnum">
</div>
  <input type="submit">
</form>
<?php
require "cURLsetup.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $tktno = $_POST['tnum'];
    if (empty($tktno)) {
        echo "Ticket number is empty";
    } else {
        echo "Data for Ticket number #".$tktno = preg_replace('/[^0-9.]+/', '', $tktno)."<br><hr>";
        getrpt($tktno);
    }
}
?>

<script type="text/javascript" src="jquery-1.7.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.text_container').addClass("hidden");

		$('.text_container').click(function() {
			var $this = $(this);

			if ($this.hasClass("hidden")) {
				$(this).removeClass("hidden").addClass("visible");

			} else {
				$(this).removeClass("visible").addClass("hidden");
			}
		});
	});
</script>
</article>
<script type="module">
  // Import the functions you need from the SDKs you need
  import { initializeApp } from "https://www.gstatic.com/firebasejs/9.21.0/firebase-app.js";
  import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.21.0/firebase-analytics.js";
  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries
  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  const firebaseConfig = {
    apiKey: "AIzaSyCGuAZEg_jCTt0sqoBGVr4NOWkWRf4TX9c",
    authDomain: "smartserve-ticket-search.firebaseapp.com",
    projectId: "smartserve-ticket-search",
    storageBucket: "smartserve-ticket-search.appspot.com",
    messagingSenderId: "757642614605",
    appId: "1:757642614605:web:b72d42624c0e4ca1454904",
    measurementId: "G-HNFZX63CRV"
  };
  // Initialize Firebase
  const app = initializeApp(firebaseConfig);
  const analytics = getAnalytics(app);
</script>
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
		<table class="myFormat" style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="0">
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
            echo '<td>'.$rmanager['name'].'</td>
            </tr>
        </tbody>
        </table>
	    </div>';
    echo '</div></div>';
    echo '<div class="float-child-element">';
    echo '<div class="rightb text_container">';
    echo '<label for="rfname">Requested for Name:</label>';
    $rfor = getname($assoc_array['ticket']['requested_for_id']);
    $rfname = $rfor['name'];
    echo "<input type='text' name='rfname' value='$rfname' class='icon' readonly>";
    echo '<div><!--Hidden Div-->
        <table class="myFormat" style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="0">
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
    echo '</div></div>';
    echo '</div>';
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
            <table class="myFormat" style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="0">
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

        echo '<div><span id="labelt">Conversations:</span><br></div>';
    echo '</div>';
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
    $agent_ids = $obj->group->agent_ids;

    $updatedString = '<span id="labelt">Members:</span><br><table class="myFormat" style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="0"><tbody>';

        foreach ($agent_ids as $agent_id) {
            $GmemberName = getname($agent_id);
            $updatedString .= "<tr><td>".$GmemberName['UID']."_".$GmemberName['name']."</td></tr>";
        }
    $updatedString .="</tbody></table>";
    return $updatedString;
}

?>