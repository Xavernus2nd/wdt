<?php
include("connection.php");
$updateclass = $_POST['ClassName'];
$classID = $_POST['ClassID'];

$sql = "UPDATE class SET ClassName = '$updateclass' WHERE ClassID = '$classID'";
$result = mysqli_query($DBconn, $sql);
if ($result) {
   echo "<script>alert('Class Name Updated!');window.location.href='manageClassTeacher.php'</script>";
} else {
   echo "Error updating Class Name!: " . mysqli_error($DBconn);
}
?>
