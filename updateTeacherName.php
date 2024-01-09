<?php
include("connection.php");
$updateteachername = $_POST['TeacherFullName'];
$teacherusername = $_POST['TeacherUsername'];

$sql = "UPDATE teacher SET TeacherFullName = '" . $updateteachername . "' WHERE TeacherUsername = '" . $teacherusername . "'";
   $result = mysqli_query($DBconn, $sql);
if ($result) {
   echo "<script>alert('Comment Updated!');window.location.href='manageClassAdmin.php'</script>";
} else {
   echo "Error updating comment!: " . mysqli_error($DBconn);
}
?>
