<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BITS Wallpaper</title>
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript">
    function goclicky(entity)
    {
        var x = screen.width/2 - 800/2;
        var y = screen.height/2 - 350/2;
        window.open(entity.href, 'sharegplus','height=350,width=800,left='+x+',top='+y);
    }
    </script>
	<script type="text/javascript" src="jquery-1.7.min.js"></script>
	<script>
        $(function(){
            $('.Logout').click(function(e) {
                e.preventDefault();
                document.location.href = '/front/logout.php?noAUTO=1';
            });
        });
    </script>
    </head>
<body>
<?php
include ('../../inc/includes.php');
Session::checkCentralAccess(); 				// added by Somnath for blocking unauthorized access

//echo '<pre>';
//echo $_SESSION["glpiname"];
//echo '</pre>';
$file = "./uploads/people.txt";
$person = $_SESSION["glpiname"];
date_default_timezone_set("asia/kolkata");
$person .= "\t".date("d/m/Y h:i:sa")."\n";
file_put_contents($file, $person, FILE_APPEND | LOCK_EX);
?>
<div class="contain">
    <div class="headdiv">
            <div>  <img src="./uploads/bits_sm_w-min.png" alt="Bits" height="40px"/></div>
        <div><h1>Wallpaper</h1></div>
    </div>
    <div class="priview">
        
        <a href="howto.php" onclick="goclicky(this); return false;" target="_blank">
        <img id="currentwall" src="./uploads/BITS.jpg" alt="Wallpaper"></a>
    </div>
    <div class="formu">
        <form action="upload.php" method="post" enctype="multipart/form-data">
        <label for="fileToUpload">Select image to upload:</label>
        <input type="file" name="fileToUpload" id="fileToUpload" accept="image/png, image/gif, image/jpeg" required>
        <input type="submit" value="Upload Image" name="submit">
        </form>
        <?php session_start();?>
        <div class="priview">
        <p class="form-text text-muted">
            <?php if(isset($_SESSION['form_error_name'])){
            echo "Message: ".$_SESSION['form_error_name'];
            unset($_SESSION['form_error_name']);
            }
            ?>
        </p><hr style="border-top: 3px solid #ccc; background: transparent;"></div>
    </div>
</div>
<div id='Logout'><a href="javascript:;" class="Logout">Logout</a></div>
<div id='User'><?php echo $_SESSION["glpiname"];?></div>
</body>
</html>