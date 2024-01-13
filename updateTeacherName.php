<?php
include("connection.php");
$teacherusername = $_POST['TeacherUsername'];

$sql = "UPDATE teacher SET TeacherUsername = '" . $teacherusername . "'";
   $result = mysqli_query($DBconn, $sql);
if ($result) {
   echo "<script>alert('Update Successful!');window.location.href='manageClassAdmin.php'</script>";
} else {
   echo "Update Failed!: " . mysqli_error($DBconn);
}
?>

