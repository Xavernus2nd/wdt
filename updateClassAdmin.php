<?php
include("connection.php");
$updateclass = $_POST['ClassName'];
$classID = $_POST['ClassID'];
$updateusername = $_POST['TeacherUsername'];


$sql = "UPDATE class SET ClassName = '$updateclass', TeacherUsername = '$updateusername' WHERE ClassID = '$classID'";
$exist = "SELECT COUNT(1) AS count FROM teacher WHERE TeacherUsername = '$updateusername'";

$result = mysqli_query($DBconn, $sql);
$result2 = mysqli_query($DBconn, $exist);

$row = mysqli_fetch_assoc($result2);

if ($row['count'] == 1){
      if ($result) {
         echo "<script>alert('Update Successful!');window.location.href='manageClassAdmin.php'</script>";
      } else {
         echo "Update Failed!: " . mysqli_error($DBconn);
      }
   } else {
      echo "<script>alert('Teacher does not exist!');window.location.href='manageClassAdmin.php'</script>";
   }
?>
