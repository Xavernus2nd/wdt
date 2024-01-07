<?php
include("connection.php");

$studentID = $_GET['StudentUsername'];
$classID = $_GET['ClassID'];

$sql = "DELETE FROM class WHERE StudentUsername = '$studentID' AND ClassID = '$classID'";


if (mysqli_query($CBconn,$sql)) {
   echo "<script>alert('Student Removed!');window.location.href='Manage_Class.php'</script>";
} else {
   echo "Error removing student!: " . mysqli_error($DBconn);
}

mysqli_close($DBconn);
?>
