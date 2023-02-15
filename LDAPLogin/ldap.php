<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Authentication</title>
	<link rel="stylesheet" href="nicepage.css" media="screen">
	<link rel="stylesheet" href="fonts/font.css" media="screen">
    <style>
		body { background-color:#333333; }
		.centered { display: flex; width: 100vw; height: 100vh;	justify-content: center; align-items: center; flex-direction: column; }
		.hold-transition { /* Prevent Selection */
		-webkit-user-select: none; /* Safari */
		-ms-user-select: none; /* IE 10 and IE 11 */
		user-select: none; /* Standard syntax */
		}
	</style>
</head>
<body class="hold-transition">
<div class="centered fontsforweb_Georama">
	<?php
		session_start();
		$ldap_dn = "cn=".$_POST["txtLoginID"].",dc=mfeka,dc=com";
		$ldap_password = $_POST["txtPassword"];
		
		$ldap_con = ldap_connect("172.30.0.112");
		ldap_set_option($ldap_con, LDAP_OPT_PROTOCOL_VERSION, 3);
		ldap_set_option($ldap_con, LDAP_OPT_REFERRALS, 0);

		if(@ldap_bind($ldap_con,$ldap_dn,$ldap_password)) { 
			echo "Authenticated";

			//Run Function - Returns False if Failed or Displayname if True
			$displayName = chkLDAP($_POST["txtLoginID"], $_POST["txtPassword"], $ldap_con, $ldap_dn);
			//echo "<BR>".$displayName; exit;

			$dName = $_POST["txtLoginID"]; // if Username not found!
			if ($displayName !== false) {
				$dName = $displayName;
			}
			$_SESSION['use']=$dName;
			header("Location: /files");
			exit;
		}
		else
			echo '
			<div class="u-align-center u-clearfix u-footer u-grey-80 u-footer" style="height: 100px;">
				<img src="images\Invalid_Credential.png" class="u-logo-image-1">
			</div>
			<div class="u-align-center u-clearfix u-footer u-grey-80 u-footer">
				Invalid Credential
			</div>
			<div class="u-align-center u-clearfix u-footer u-grey-80 u-footer" style="height: 100px;">
				<a href="login.html">Try again</a>
			</div>';

	function chkLDAP($u, $pass, $ldap_con, $ldap_dn) {

		$base_dn = "dc=mfeka,dc=com";
		$filter = "(cn=".$u.")";
		$ldap_user = $ldap_dn;
		$ldap_pass = $pass;
		$connect = $ldap_con;
		ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3);
	
		$bind = ldap_bind($connect, $ldap_user, $ldap_pass);
		$read = ldap_search($connect, $base_dn, $filter);

		$entry = ldap_first_entry($connect, $read);
		
		// Return only displayname
		$info = ldap_get_values($connect, $entry, "displayname"); 
		return $info[0];
	   
		/*/// Complite User Information
		$info = ldap_get_entries($connect, $read);
		echo "<BR>".$info["count"]." entrees retournees<BR><BR>";
		for($ligne = 0; $ligne<$info["count"]; $ligne++)
		{
			for($colonne = 0; $colonne<$info[$ligne]["count"]; $colonne++)
			{
				$data = $info[$ligne][$colonne];
				echo $data.":".$info[$ligne][$data][0]."<BR>";
			}
			echo "<BR>";
		} */
	ldap_close($connect);
	}
	?>
</div>
</body>
</html>