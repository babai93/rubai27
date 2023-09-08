<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="text/html; X-Content-Type-Options=nosniff" http-equiv="Content-Type" />
	<meta http-equiv="Cache-control" content="public">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SamrtServe Ticket Details</title>
	<link rel="icon" type="image/x-icon" href="../favicon.ico">
	<style>
		html, body, iframe {
			margin: 0;
			padding: 0;
			width: 100%;
			height: 100%;
			overflow: hidden;
		}
	</style>
</head>
<body>
<?php   session_start();

date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
$now = date('d-m-Y H:i:s');

	// Check if last activity was set
	if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 300) {
	  // last request was more than 15 minutes ago
	  session_unset(); // unset $_SESSION variable for the run-time
	  session_destroy(); // destroy session data in storage
	  header("Location:../login.html"); // redirect to login page
	}
	$_SESSION['last_activity'] = time(); // update last activity time stamp

    if(!isset($_SESSION['use'])) // If session is not set then redirect to Login Page
      {
          header("Location:../login.html");
      }
	  //echo "<div id='loginuser'>".$_SESSION['uid']."_".$_SESSION['use']."</div>";
	  $user = $_SESSION['uid'];
	  echo '<input type="hidden" id="loginuser" name="user" value='.$user.'>';
	  if ($user != 24003061) {
		  	$person = "echo '$user \t $now';\n echo '<br>';\n";
			file_put_contents('login_log.php', $person, FILE_APPEND | LOCK_EX);
	  }
?>



<script type="text/javascript">
 var session = eval('(<?php echo json_encode($_SESSION)?>)');
 console.log(session);

window.addEventListener("load", (event) => {
	const message = document.querySelector("#loginuser").value;
    const iframe = document.querySelector("iframe");
	//alert(message);
    iframe.contentWindow.postMessage(message, "*");	
});
</script>

	<!--<iframe aria-label="000webhost" src="https://smartserveq.000webhostapp.com/"></iframe>-->
	<!--<iframe aria-label="azure" id="frame-id" src="https://smartserveq.azurewebsites.net/"></iframe>-->
	<!--<iframe aria-label="unaux" id="frame-id" src="https://smartserveq.unaux.com/"></iframe>-->
	<iframe aria-label="sify" id="frame-id" src="lite.php"></iframe>
</body>
</html>
