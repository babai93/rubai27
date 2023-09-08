<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SamrtServe Ticket Details</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Georama|Audiowide|Sofia|Titillium Web">
    <link rel="stylesheet" href="index_style.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
$title = "SamrtServe Ticket Details";
include "header.php";
?>

<div id="parent">
<!--<div><h1><span style="color:#e41729;">Smart</span>Serve Ticket details</h1></div>-->
    <form id="form_div" action="ticket.php" method="GET">
     <div class="flex_form">
        <label for="id">Ticket Number:</label>
        <input type="text" name="id" required>
    </div>
    <input type="submit">
    </form>
</div>
<div class="fixed-bottom-left"><a href="/index_old.php">Use advance version</a></div>
</body>
</html>