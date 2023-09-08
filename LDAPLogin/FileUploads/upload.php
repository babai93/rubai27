<!-- The complete "upload.php" file now looks like this: -->
<!-- source: https://www.w3schools.com/php/php_file_upload.asp -->
<?php
session_start();
$target_dir = "uploads/";
$target_file_name = "BITS.jpg";
$target_file = $target_dir . $target_file_name; //basename($_FILES["fileToUpload"]["name"]);
//echo $target_file;
//exit();
$_SESSION['form_error_name'] = "";

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  //print_r ($check);
  //exit();
  if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
  } else {
    //echo "This is not an image file.";
    $_SESSION['form_error_name'] .= "This is not an image file.";
    $uploadOk = 0;
  }
}

// Check if file already exists
//if (file_exists($target_file)) {
//  echo "Sorry, file already exists.";
//  $uploadOk = 0;
//}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
  //echo "Sorry, your file is too large.";
  $_SESSION['form_error_name'] .= " Your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
  //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $_SESSION['form_error_name'] .= " Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  //echo "Sorry, your file was not uploaded.";
  $_SESSION['form_error_name'] .= " Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        if(htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])) != $target_file_name){
          $_SESSION['form_error_name'] .= "The file <strong>"
          . htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). 
          "</strong> has been uploaded and renamed as <strong>".$target_file_name. "</strong>";
        } else {
          $_SESSION['form_error_name'] .= "The file <strong>"
          . htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). 
          "</strong> has been uploaded.";
        }
  } else {
    //echo "Sorry, there was an error uploading your file.";
    $_SESSION['form_error_name'] .= " Sorry, there was an error uploading your file.";
  }
}

  //go back to previous page with all previous selections
  $previousPage = $_SERVER['HTTP_REFERER'];
  header("Location: $previousPage")
?>
