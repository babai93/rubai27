<?php
 
// Redirect browser
// header("Location: //filess");
echo '<p id="demo"></p>';
echo '<script>
document.getElementById("demo").innerHTML = "The full URL of this page is:<br>" + window.location.href;
let text = window.location.href;
let nurl = text.replace("call.php", "filess/");
location.replace(nurl);
</script>';
?>