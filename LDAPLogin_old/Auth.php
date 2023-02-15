<?php
    $ldaprdn  = $_POST["username"];
    $ldappass = $_POST["password"];
    $dn = "CN=24003061,DC=mfeka,DC=com";
    $ldapconn = ldap_connect("172.30.0.112", 389) or die("Could not connect to LDAP server.");
    ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

if ($ldapconn)
{
    $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);
    if ($ldapbind) {
        echo "LDAP bind successful...";
    } else {
        echo "LDAP bind failed...";
    }
}

$filter = "(sAMAccountName=$ldaprdn)";
$result = ldap_search($ldapconn, $dn, $filter, array("dn")) or exit("Unable to search LDAP server, response was: " . ldap_error($ldapconn));
$data = ldap_get_entries($ldapconn, $Result);
print_r($data);
?>