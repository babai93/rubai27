
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartServe - SOP</title>
    <link rel="shortcut icon" href="../favicon/favicon-32x32.png" type="image/x-icon">
    <link rel="icon" href="../Cfavicon/favicon-32x32.png" type="image/x-icon">
    <link rel="icon" sizes="192x192" href="../favicon/favicon-32x32.png">
    <link rel="stylesheet" href="../nicepage.css" media="screen">
	<link rel="stylesheet" href="../fonts/font.css" media="screen">
    <style>
    html, body, iframe { height: 100%; background-color: #333333;}
    html { overflow: hidden; }
    #Welcome {
        padding: 5px;
        Text-align:left;
        width:80%;
        float:left;
        font-family: "Georama";
        color: #fff;
    }
    #Logout { 
        padding: 5px;
        Text-align:right;
        Width:20%;
        float:right;
        font-family: "Georama";
    }
    a {
        color: #fff;
        text-decoration: none;
        background-color: transparent;
    }
    .hold-transition { /* Prevent Selection */
        -webkit-user-select: none; /* Safari */
        -ms-user-select: none; /* IE 10 and IE 11 */
        user-select: none; /* Standard syntax */
        }
    </style>
</head>
<body class="hold-transition">
<?php   session_start();  ?>
<?php
    if(!isset($_SESSION['use'])) // If session is not set then redirect to Login Page
      {
          header("Location:../login.html");
      }
    echo '<div id="Welcome">Welcome '. $_SESSION['use'] . '</div>';
    echo "<div id='Logout'><a href='../logout.php'>Logout</a> </div>";
    echo '<iframe src="/SOPforSmartService1.3.1.pdf" width="100%" scrolling="yes" frameborder="0"></iframe>'
?>
</body>
</html>