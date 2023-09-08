<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SamrtServe Entity Info</title>
    <link rel="icon" type="image/x-icon" href="../favicon.ico">

<script type="text/javascript" src="jquery-1.7.min.js"></script>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="stylepop.css">
<link rel="stylesheet" href="act_con_style.css">
<link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.min.css">
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
            echo    '<div class="box2">
            <button class="btn btnx" onclick="self.close();"><i class="fa fa-times" aria-hidden="true"></i><span class="btn-text">&nbsp;Close</span>
            </div>';
			echo '</div>';
	} else {
			echo "Please enter valid number like <strong>ticket.php?id=23889</strong><br>";
			echo '<input type="button" onclick="self.close();" value="Close">';
	}

$AgentDTLS = getname($id);

echo '<div class="data">'.$AgentDTLS.'</div>';

// optimized by ChatGPT
function getname($id)
{
    if ($id === null) {
        return getDefaultUserData();
    }

    $response = callAPI('GET', 'https://mmfss.freshservice.com/api/v2/requesters/'.$id, false);
    
    if ($response === false) {
        return getDefaultUserData();
    }

    $assoc_array = json_decode($response, true);

    //print_r ($assoc_array);
    $out = extractUserData($assoc_array);

    return generateUserDataHTML($out);
}

function getDefaultUserData() {
    return '<div class="dataview"><!--Hidden Div-->' .
        '<table class="gTable" style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="0">' .
        '<tbody>' .
        '<tr>' .
        '<td width="80px">Entity Name :</td>' .
        '<td colspan="3" rowspan="1">Blank</td>' .
        '</tr>' .
        '<tr>' .
        '<td>Department :</td>' .
        '<td></td>' .
        '<td width="70px">Company :</td>' .
        '<td></td>' .
        '</tr>' .
        '<tr>' .
        '<td>Branch Name :</td>' .
        '<td></td>' .
        '<td>Region :</td>' .
        '<td></td>' .
        '</tr>' .
        '<tr>' .
        '<td>State :</td>' .
        '<td></td>' .
        '<td>Circle :</td>' .
        '<td></td>' .
        '</tr>' .
        '<tr>' .
        '<td>Mobile No. :</td>' .
        '<td></td>' .
        '<td>Entity Code :</td>' .
        '<td></td>' .
        '</tr>' .
        '<tr>' .
        '<td>Email ID :</td>' .
        '<td colspan="3" rowspan="1"></td>' .
        '</tr>' .
        '<tr>' .
        '<td>Designation :</td>' .
        '<td colspan="3" rowspan="1"></td>' .
        '</tr>' .
        '</tbody>' .
        '</table>' .
        '</div>';
}

function extractUserData($assoc_array) {
    return [
        'active' => $assoc_array['requester']['active'],
        'name' => $assoc_array['requester']['first_name'] . ' ' . $assoc_array['requester']['last_name'],
        'UID' => $assoc_array['requester']['custom_fields']['user_id'],
        'Dept' => $assoc_array['requester']['custom_fields']['vertical'],
        'grade' => $assoc_array['requester']['custom_fields']['grade'],
        'company' => $assoc_array['requester']['custom_fields']['company'],
        'job_title' => $assoc_array['requester']['job_title'],
        'branch_name' => $assoc_array['requester']['custom_fields']['branch_name'],
        'mobile_phone_number' => $assoc_array['requester']['mobile_phone_number'],
        'reporting_manager_id' => $assoc_array['requester']['reporting_manager_id'],
        'primary_email' => $assoc_array['requester']['primary_email'],
        'region' => $assoc_array['requester']['custom_fields']['region'],
        'state' => $assoc_array['requester']['custom_fields']['state'],
        'circle' => $assoc_array['requester']['custom_fields']['circle'],
    ];
}

function generateUserDataHTML($data) {
    $ustatus = ($data['active'] != 1) ? "<span data-tooltip='Inactive entity.' data-tooltip-position='bottom'><i class='fa fa-user-times icon-red' aria-hidden='true'></i></span>" : "";

    return '<div class="dataview">
        <table class="gTable" style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="0">
            <tbody>
                <tr>
                    <td width="80px">Entity Name :</td>
                    <td colspan="3" rowspan="1">'.strtoupper($data['name']).' '.$ustatus.'</td>
                </tr>
                <tr>
                    <td>Department :</td>
                    <td>'.$data['Dept'].'</td>
                    <td width="70px">Company :</td>
                    <td>'.$data['company'].'</td>
                </tr>
                <tr>
                    <td>Branch Name :</td>
                    <td>'.$data['branch_name'].'</td>
                    <td>Region :</td>
                    <td>'.$data['region'].'</td>
                </tr>
                <tr>
                    <td>State :</td>
                    <td>'.$data['state'].'</td>
                    <td>Circle :</td>
                    <td>'.$data['circle'].'</td>
                </tr>
                <tr>
                    <td>Mobile No. :</td>
                    <td>'.$data['mobile_phone_number'].'</td>
                    <td>Entity Code :</td>
                    <td>'.$data['UID'].'</td>
                </tr>
                <tr>
                    <td>Email ID :</td>
                    <td colspan="3" rowspan="1">'.$data['primary_email'].'</td>
                </tr>
                <tr>
                    <td>Designation :</td>
                    <td colspan="3" rowspan="1">'.$data['job_title'].' ('.$data['grade'].')</td>
                </tr>
                <tr>
                    <td>RM Name :</td>
                    <td colspan="3" rowspan="1">'.strtoupper(getAgentNameOnly($data['reporting_manager_id'])).'</td>
                </tr>
            </tbody>
        </table>
    </div>';
}

function getAgentNameOnly($id)
{
    if ($id === null) {
        return null; // or any other appropriate value for a null id
    }
    $response = callAPI('GET', 'https://mmfss.freshservice.com/api/v2/requesters/'.$id, false);
    $obj = json_decode($response);
    
    return $obj->requester->first_name . ' ' . $obj->requester->last_name;
}

?>
</body>
</html>