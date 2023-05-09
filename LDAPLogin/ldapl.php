<?php

$username = "24003061";
$encrypted_password = "TWFuYTA3MDM=";

// Decode the base64-encoded password
$password = base64_decode($encrypted_password);

echo $password;

// Hash the password using SHA-1
$password_sha1 = "{SHA}" . base64_encode(sha1($password, true));

// Connect to the LDAP server
$ldap_conn = ldap_connect("ssocluster.mfeka.com");

if (!$ldap_conn) {
    die("Unable to connect to LDAP server");
}

// Set LDAP options
ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

// Bind to the LDAP server with the hashed password
$ldap_bind = ldap_bind($ldap_conn, "cn=$username,dc=MFEKA,dc=com", $password_sha1);

if (!$ldap_bind) {
    die("Unable to bind to LDAP server");
}

echo "Login successful";

// Close the LDAP connection
ldap_close($ldap_conn);

?>