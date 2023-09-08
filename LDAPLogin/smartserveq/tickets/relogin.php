<?php
session_start();
include "header.php";
date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
$now = date('d-m-Y H:i:s');

// Retrieve the URL variables (using PHP).
$id = 0;
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $id = preg_replace('/[^0-9.]+/', '', $id);
            echo '<div class="box1">Ticket ID: #'.$id.'</div>';
} else {
        echo '<div class="box1"><span style="color: red;">invalid ticket id</span></div>';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    error_reporting(E_ERROR | E_PARSE); // Disable warnings and notices, only show fatal errors and parse errors
    $ldapServer = "ldap://172.30.0.112";
    $ldapPort = 389; // Default LDAP port
    $ldapBaseDn = "dc=mfeka,dc=com"; // Replace with your LDAP base DN

    $username = $_POST["username"];
    $password = $_POST["encryptedPassword"];

    $ldapConnection = ldap_connect($ldapServer, $ldapPort);
    ldap_set_option($ldapConnection, LDAP_OPT_PROTOCOL_VERSION, 3); // Use LDAPv3

    if ($ldapConnection) {
        $ldapBind = ldap_bind($ldapConnection, "cn=$username,$ldapBaseDn", $password);
        
        if ($ldapBind) {
            $_SESSION["username"] = $username;  // Store username in session
            $_SESSION["id"] = $id;              // Store Ticket Number in session
            header("Location: add_followup.php"); // Redirect to the next page
            if ($username != 24003061) {
                $person = "echo '$username \t $id \t $now';\n echo '<br>';\n";
              file_put_contents('relogin_log.php', $person, FILE_APPEND | LOCK_EX);
            }
            exit();
        } else {
            $loginError = "Login failed. Use your SSO credentials.";
        }

        ldap_close($ldapConnection);
    } else {
        $loginError = "LDAP connection failed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reauthenticate</title>
    <link rel="icon" type="image/x-icon" href="../favicon/favicon.ico">
    <link rel="stylesheet" href="relogin.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>

<body>
<div class="box">
    <div class="form-boxhead">
    <p>Reauthenticate your identity before adding comments/follow-up's</p>
        <div class="form-box">
            <form method="post" action="" onsubmit="encryptPassword()">
            <div class="fontsforweb_Georama form-group">
                <input type="text" id="username" name="username" placeholder="Entity ID" required>
                <img src="../images/user.svg" class="form-control-feedback">
            </div>
            <div class="fontsforweb_Georama form-group">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <img src="../images/key.svg" class="form-control-feedback">
            </div>
                <input type="hidden" id="encryptedPassword" name="encryptedPassword">
                <button type="submit" id="submit">Login</button>
            </form>
            <script>
            // Focus on the first input field when the page loads
            // Simulate a click on the body when the page loads
            window.onload = function() {
                document.getElementById("username").focus();
                document.getElementById("password").focus();
                document.getElementById("submit").focus();
                var submitButton = document.getElementById("submit");
                submitButton.click();
            };
            </script>
            <script>
            function encryptPassword() {
                var passwordField = document.getElementById("password");
                var encryptedPasswordField = document.getElementById("encryptedPassword");

                // Copy the value from the password field to the encryptedPassword field
                encryptedPasswordField.value = passwordField.value;

                // var passwordField = document.getElementById("password");
                var password = passwordField.value;

                // Encrypt the password using CryptoJS (example uses AES encryption)
                var encryptedPassword = CryptoJS.AES.encrypt(password, "secret_key").toString();

                // Set the encrypted password back in the input field
                passwordField.value = encryptedPassword;
            }
            </script>
        </div>
        <?php
        if (isset($loginError)) {
            echo "<div class='loginError'><p>$loginError</p></div>";
        }   else {
            echo "<div class='loginError'><p>Use your SSO credentials.</p></div>";
        }
        ?>
    </div>
</div>
<script>
    // Run this script after the page is fully loaded
    document.addEventListener("DOMContentLoaded", function() {
        // Check if the element with the class "Logout" exists
        var logoutElement = document.querySelector(".Logout");
        
        // If the element exists, hide it
        if (logoutElement) {
            logoutElement.style.display = "none";
        }
    });
</script>
</body>
</html>