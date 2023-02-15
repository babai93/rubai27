<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content="Enterprise Management Solutions">
    <meta name="description" content="">
    <title>SmartServe - Login</title>
    <link rel="shortcut icon" href="favicon/favicon-32x32.png" type="image/x-icon">
    <link rel="icon" href="Cfavicon/favicon-32x32.png" type="image/x-icon">
    <link rel="icon" sizes="192x192" href="favicon/favicon-32x32.png">
    <link href="Content/CSS/grid12.css" rel="stylesheet">
    <link href="Content/CSS/login.min.css" rel="stylesheet">
    <link href="Content/CSS/fonts.min.css" rel="stylesheet">
    <link rel="stylesheet" href="nicepage.css" media="screen">
    <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i">
    <link id="u-page-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cambay:400,400i,700,700i">

    <style> 
        .hold-transition { /* Prevent Selection */
        -webkit-user-select: none; /* Safari */
        -ms-user-select: none; /* IE 10 and IE 11 */
        user-select: none; /* Standard syntax */
        }
    </style>
    
</head>
    <body class="hold-transition" style="margin-bottom: 0px;">
    <form method="post" action="ldap.php" id="form1">
        <div class="wrapper">
        <header class="u-clearfix u-grey-80 u-header u-header" id="sec-a8f2">
            <div class="u-clearfix u-sheet u-sheet-1">
                <a href="index.html" class="u-image u-logo u-image-1" data-image-width="552" data-image-height="232" title="Home">
                <img src="images/SServe500.png" class="u-logo-image u-logo-image-1" style="margin-left: 112px;">
                </a>
            </div>
        </header>
            <div class="content-wrapper">
                <div class="container-fluid">
                    <div class="row" style="margin-top: 50px;">
                        <div class="col-md-4 col-md-offset-2" style="border-right: 10px solid #dc422a;">
                            <img src="images/SServe400.png" style="height: 400px;">
                        </div>
                        <div class="col-md-4">
                            <h3 class="u-text-grey-60" style="font-size: 32px; font-weight: 500; margin: 0px; margin-top: 70px;">
                                <img src="Content/images/key-svgrepo-com.svg" style="height: 28px;"> Sing in</h3>
                            <p style="font-family: 'Georama';" class="login-info" id="lblResult">Use your SSO credential to login</p>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <input name="txtLoginID" type="text" maxlength="20" id="txtLoginID" class="form-control" placeholder="User Name" autocomplete="off" required>
                                        <img src="Content/images/man-user.png" class="form-control-feedback">
                                    </div>
                                    <div class="form-group">
                                    <input name="txtPassword" type="password" id="txtPassword" class="form-control" placeholder="Password" autocomplete="current-password" required>
                                    <img src="Content/images/vintage-key-outline.png" class="form-control-feedback">
                                    </div>
                                    <div class="form-group">
                                        <span id="lblMessage" class="result"></span>
                                    </div>
                                    <input type="submit" name="btnLogin" value="Log in" id="btnLogin" class="btn btn-flat">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer style="position: fixed; bottom: 0; width: 100%;" class="u-align-center u-clearfix u-footer u-grey-80 u-footer" id="sec-1a8c">
            <div class="u-clearfix u-sheet u-valign-middle u-sheet-1">
            <a href="https://www.mahindrafinance.com/" class="u-image u-logo u-image-1" data-image-width="567" data-image-height="40" title="Mahindra Finance" target="_blank">
                <img src="images/mahindra-white.svg" class="u-logo-image u-logo-image-1">
            </a>
            <p class="u-small-text u-text u-text-variant u-text-1"> © 2022 Mahindra &amp; Mahindra Financial Services Sector</p>
            </div>
        </footer>
</form><style type="text/css">
                        html:before {
                            z-index: -2147483646;
                        }
            html:before {
                background: rgba(255,0,0,1);
                opacity: 0.75;
                transition:  opacity 0.85s ease-out;
                position: fixed;
                content: "";
                z-index: 2147483647;
                top: 0;
                left: 0;
                height: 2px;
            }
        </style>
    </body>
</html>