<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SamrtServe Group Info</title>
    <link rel="icon" type="image/x-icon" href="../favicon.ico">

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="stylepop.css">
<link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.min.css">
<!--<script src="js/jquery-3.6.0.js"></script>-->
<script src="jquery-1.7.min.js"></script>
<script type="text/javascript">
function goclicky(entityn)
{
    var x = screen.width/2 - 500/2;
    var y = screen.height/2 - 260/2;
    window.open(entityn.href, 'sharegplus','height=260,width=500,left='+x+',top='+y);
}
</script>
</head>
<body>
<?php
require "cURLsetup.php";

    // Retrieve the URL variables (using PHP).
	$id = 0;
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$id = preg_replace('/[^0-9.]+/', '', $id);
			echo '<div class="flex-container">';
			echo  	'<div class="box1">Group ID: #'.$id.'</div>';
			//echo	'<div class="box2"><input type="button" onclick="self.close();" value="Close"></div>';
            echo    '<div class="box2">
            <button class="btn btnx" onclick="self.close();"><i class="fa fa-times" aria-hidden="true"></i><span class="btn-text">&nbsp;Close</span>
            </div>';
			echo '</div>';
	} else {
			echo "Please enter valid number like <strong>ticket.php?id=23889</strong><br>";
			echo '<input type="button" onclick="self.close();" value="Close">';
	}

    ?>
<style>
    #loading_spinner { 
        display:none;
        font-size: 2rem;
        color: #4d4d4f;
        }
    #container {
        color: white;
        width: 100%;
        height: 75vh;
        display: flex;
        justify-content: center;
        align-items: center;
        }
</style>

<div class="data"><div id="container"><div id="loading_spinner">Loading...</div></div></div>
<input type="hidden" id="bfCache" value="">
<script>
            $('#loading_spinner').show();
            var gid = "<?php echo $id; ?>";
            var post_data = "id="+gid;
            var xhr = $.ajax({
                url: 'group_data.php',
                type: 'POST',
                data: post_data,
                dataType: 'html',
                success: function(data) {
                    $('.data').html(data);
            //Moved the hide event so it waits to run until the prior event completes
            //It hide the spinner immediately, without waiting, until I moved it here
                    $('#loading_spinner').hide();
                },
                error: function() {
                    alert("Something went wrong!");
                }
            });
</script>
</body>
</html>