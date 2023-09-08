<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve JSON data and decode it
    //$data = json_decode(file_get_contents("php://input"));

   // Retrieve form data
   $id = $_POST["id"];
   $user_id = (int)$_POST["user_id"];
   $body = $_POST["body"];
   if (strlen($body) > 3) {
        $body .= "\n<small>(Comment added through API)</small>";
    } else {
        echo "Can't add empty comment!!";
        exit;
    }
   

   // Call the add_followup function
   echo add_followup($id, $user_id, $body);

   // Return a response if needed
   // echo "Followup added successfully!";
}

function add_followup($id, $user_id, $body){
// URL of the API endpoint
$url = 'https://mmfss.freshservice.com/api/v2/tickets/'.$id.'/notes';

// Headers for the request
$headers = array(
    'Content-Type: application/json',
    'Authorization: Basic QVRtQ1hMR1FySWVvSk5TM1k1ZDI6WA=='
);

// Data to send in the request body
$data = array(
    'body' => $body,
    'private' => false,
    'user_id' => $user_id
);

// Initialize cURL session
$ch = curl_init($url);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Execute cURL session and capture the response
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    echo 'cURL error: ' . curl_error($ch);
}

// Close cURL session
curl_close($ch);

// Print the API response
// return $response;
$response = json_decode($response, true);

//print_r($response);

if ($response !== null && isset($response['description']) && $response['description'] === 'Validation failed') {
    // Display "Validation failed" message
    //echo "Validation failed";
    
        // Extract and display the 'description' field
        $description = $response['description'];
        echo $description. ' ';

        // Extract and display the 'errors' array
        if (isset($response['errors']) && is_array($response['errors'])) {
            echo "Error: ";
            foreach ($response['errors'] as $error) {
                $field = $error['field'];
                $errorMessage = $error['message'];
                $errorCode = $error['code'];
                echo $field .', '. $errorMessage;
            }
        }
} else 
if ($response !== null && isset($response['conversation']) && $response['conversation']['id'] !== null) {
    // Handle other cases if needed
    //echo "An error occurred: ";
    //print_r($response);
    //echo $conversationId = $response['conversation']['id'];
    echo "Comment added successfully!";
} else {
    echo "An error occurred: ";
    print_r($response);
}
}