<?php
// header.php

// Start output buffering
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!--<title><?php echo $title; ?></title>-->
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
    #Logout { 
        padding: 5px;
        float:right;
        font-family: "Georama";
    }
    #Logout a {
        color: #fff;
        text-decoration: none;
        background-color: transparent;
    }
    </style>
    <script type="text/javascript" src="jquery-1.7.min.js"></script>
    <script>
        $(function(){
            $('.Logout').click(function(e) {
                e.preventDefault();
        
                // Open link on same page
                document.location.href = '../logout.php';
            });
        });
    </script>
</head>
<!-- <body onload="init();"> -->
<body>
<div class="header" id="parent">
    <div>
        <table width="100%"; border="0">
            <tr>
        <!--<td style="width: 60px;"><img src="./images/SmartServe_sm195-min.png" alt="SmartServe" width="50px">-->
        <?php $image = "./images/SmartServe_sm195-min.png"; ?>
        <td style="width: 60px;"><img src="<?php echo $image;?>" alt="SmartServe" width="50px">
        </td>
        <td>
        <h1><div id="h1contain"><span style="color:#e41729;">Smart</span>Serve</div> Ticket Details</h1>
        </td>
        <td style="width: 60px;">
        <div id="uid"></div>
        <input type="hidden" id="uidd" value="">
        <div id='Logout'><a href="javascript:();" class="Logout">Logout</a></div>
        </td>
    </tr>
    </table>
    </div>
    <script type="text/javascript"> 
        window.addEventListener('message', function(event) {
        // set up references to DOM nodes
            $("#uid").text(event.data);
            $("#uidd").val(event.data);
        });
    </script>
</div>