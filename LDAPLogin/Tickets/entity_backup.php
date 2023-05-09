<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SamrtServe Entity Info</title>

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Georama|Audiowide|Sofia|Titillium Web">
<script type="text/javascript" src="jquery-1.7.min.js"></script>
<link rel="stylesheet" href="style.css">
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
body h1 {
font-size: 1.7rem;
letter-spacing: 1.1px;
}
.dataview {
    /*left      : 50%;
    top       : 55%;
    position  : absolute;
    transform : translate(-50%, -50%);
    background: #e6e7e8;
    padding   : 20px;
    border-radius: 5px;
    display:inline-block;
    min-width: 375px;*/
    text-align: center;
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
			echo  	'<div class="box1">Entity ID: #'.$id.'</div>';
			echo	'<div class="box2"><input type="button" onclick="self.close();" value="Close"></div>';
			echo '</div>';
	} else {
			echo "Please enter valid number like <strong>ticket.php?id=23889</strong><br>";
			echo '<input type="button" onclick="self.close();" value="Close">';
	}

$AgentDTLS = getname($id);

echo '<div class="data">'.$AgentDTLS.'</div>';

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
        $updatedString = "";
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
		
		return $updatedString .= '<div class="dataview"><!--Hidden Div-->
            <table class="myFormat" style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="0">
            <tbody>
			    <tr>
                <td>Entity Name :</td>
                <td>'.$out['name'].'</td>
                </tr>
                <tr>
                <td>Entity Code :</td>
                <td>'.$out['UID'].'</td>
                </tr>
                <tr>
                <td>Department : </td>
                <td>'.$out['Dept'].'</td>
                </tr>
                <tr>
                <td>Company :</td>
                <td>'.$out['company'].'</td>
                </tr>
                <tr>
                <td>Branch Name :</td>
                <td>'.$out['branch_name'].'</td>
                </tr>
                <tr>
                <td>Mobile No. : </td>
                <td>'.$out['mobile_phone_number'].'</td>
                </tr>
                <tr>
                <td>Email ID :</td>
                <td>'.$out['primary_email'].'</td>
                </tr>
            </tbody>
            </table>
            </div>';
      }
}

?>
</body>
</html>