<?php
include("connection.php");

//if (isset($_GET['StudentUsername'], $_GET['ClassID'])) {
  $studentid = $_GET['StudentUsername'];
//  $classID = $_GET['ClassID'];

  $sql = "UPDATE student SET ClassID = NULL WHERE StudentUsername = '$studentid'";
  $result = mysqli_query($DBconn, $sql);
  if ($result) {
     echo "<script>alert('Student Removed!');window.location.href='manageClassAdmin.php'</script>";
  } else {
     echo "Error removing student!: " . mysqli_error($DBconn);
  }
//} else {
  echo "Required parameters are missing.";
//}

mysqli_close($DBconn);

?>