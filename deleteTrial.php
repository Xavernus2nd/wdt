<?php
$TrialID = $_POST['TrialID'];

//delete student answer first
$SQLdeleteans = "DELETE FROM student_answer WHERE TrialID = '$TrialID';";
$runSQLdeleteans = mysqli_query($DBconn, $SQLdeleteans);

//delete trial (student answer parent)
$SQLdeletetrial = "DELETE FROM trial WHERE TrialID = '$TrialID';";
$runSQLdeletetrial = mysqli_query($DBconn, $SQLdeletetrial);
echo '<script>window.location.href="homeS.php";</script>'; 
?>