<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Logout</title>
  <link rel="stylesheet" type="text/css" href="logout.css">
  <link rel="icon" type="image/x-icon" href="../favicon/favicon.ico">
  <script type="text/javascript">
    function setTitle(text) {
      document.title = text;
    }
  </script>
</head>
<body>
<?php
session_start();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id == 1) {
  killsession("Session Timed Out");
} else {
  session_destroy();
  header("Location: relogin.php?id=$id");
  exit();
}

function killsession($title) {
  session_destroy();
  echo '
    <div class="box">
      <div class="imgbox">
        <img src="../images/stopwatch.svg" alt="Stopwatch">
      </div>
      <div class="modal">
        <div class="box1"><span style="color: red;">' . $title . '</span></div>
        <div>&nbsp;</div>
        <div class="box2"><button type="button" class="btnx" onclick="self.close();"> Close this Window </button></div>
      </div>
    </div>';
  
  echo "<script>setTitle('$title');</script>";
  exit();
}
?>
</body>
</html>
