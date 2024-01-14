<?php
include("connection.php");

//if (isset($_GET['StudentUsername'], $_GET['ClassID'])) {
  $studentid = $_GET['id'];
  $classID = $_GET['classid'];
  //$id = $_GET['id'];

  $sql = "UPDATE student SET ClassID = NULL WHERE StudentUsername = '$studentid'";
  $result = mysqli_query($DBconn, $sql);
  if ($result) {
    echo "<script>alert('Student removed successfully!');</script>";
    echo "<script>window.open('studentListTeacher.php?classID=$classID', '_self')</script>";
  }else {
     echo "Error removing student!: " . mysqli_error($DBconn);
  }
  echo "Required parameters are missing.";

mysqli_close($DBconn);

?>
