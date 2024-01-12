<?php
include("connection.php");

$id = $_GET['id'];

$sql = "DELETE FROM class WHERE ClassID='$id'";
$removestudent = "UPDATE student SET ClassID = NULL WHERE ClassID = '$id'";
$removestudentresult = mysqli_query($DBconn, $removestudent);

if ($removestudentresult) {
   if (mysqli_query($DBconn,$sql)) {
      echo "<script>alert('Class Deleted!');window.location.href='manageClassTeacher.php'</script>";
   } else {
      echo "Error deleting class! " . mysqli_error($DBconn);
   }
   echo "<script>alert('Class Deleted!');window.location.href='manageClassTeacher.php'</script>";
} else {
   echo "Error deleting class!: " . mysqli_error($DBconn);
}

if (mysqli_query($DBconn,$sql)) {
   echo "<script>alert('Class Deleted!');window.location.href='manageClassTeacher.php'</script>";
} else {
   echo "Error deleting class! " . mysqli_error($DBconn);
}

?>
