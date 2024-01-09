<?php
include("connection.php");
$updatecomment = $_POST['Comment'];
$trialID = $_POST['TrialID'];

$sql = "UPDATE trial SET Comment = '$updatecomment' WHERE TrialID = '$trialID'";
$result = mysqli_query($DBconn, $sql);
if ($result) {
   echo "<script>alert('Comment Updated!');window.location.href='viewResultsTeacher.php'</script>";
} else {
   echo "Error updating comment!: " . mysqli_error($DBconn);
}
?>
