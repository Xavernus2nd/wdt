<?php
include("connection.php");
$updateclass = $_POST['ClassName'];
$classID = $_POST['ClassID'];
$updateteachername = $_POST['TeacherFullName'];
$updateusername = $_POST['TeacherUsername'];


$sql = "UPDATE class SET ClassName = '$updateclass' WHERE ClassID = '$classID'";
$sql2 = "UPDATE Class a SET a.TeacherUserName = (SELECT b.TeacherUserName FROM Teacher b WHERE b.TeacherFullName ='$updateteachername') WHERE a.ClassID ='$classID'";
$exist = "SELECT COUNT(1) AS count FROM teacher WHERE TeacherFullName = '$updateteachername'";

$result = mysqli_query($DBconn, $sql);
$result2 = mysqli_query($DBconn, $sql2);
$result3 = mysqli_query($DBconn, $exist);

$row = mysqli_fetch_assoc($result3);

if ($row['count'] == 1){
   if ($result2) {
      echo "<script>alert('Update Successful!');window.location.href='manageClassAdmin.php'</script>";
   } else {
      echo "Error Updating!: " . mysqli_error($DBconn);
   }
if ($result) {
   echo "<script>alert('Update Successful!');window.location.href='manageClassAdmin.php'</script>";
} else {
   echo "Error Updating!: " . mysqli_error($DBconn);
}
}
else{
   echo "<script>alert('Teacher does not exist!');window.location.href='manageClassAdmin.php'</script>";
}
?>
