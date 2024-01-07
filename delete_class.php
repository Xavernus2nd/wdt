<?php
include("connection.php");

$id = $_GET['id'];

$sql = "DELETE FROM class WHERE ClassID='$id'";

if (mysqli_query($DBconn,$sql)) {
   echo "<script>alert('Record deleted!');window.location.href='Manage_Class_Admin.php'</script>";
} else {
   echo "Error deleting record: " . mysqli_error($DBconn);
}

mysqli_close($DBconn);
?>
