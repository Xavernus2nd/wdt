<?php
$set = $_POST['setID'];
$trialID = $_POST['trialID'];
$username = $_SESSION['StudentUsername'];

//delete student answer first
$SQLdeleteans = "DELETE FROM student_answer WHERE TrialID = '$trialID';";
$runSQLdeleteans = mysqli_query($DBconn, $SQLdeleteans);

//delete trial (student answer parent)
$SQLdeletetrial = "DELETE FROM trial WHERE TrialID = '$trialID';";
$runSQLdeletetrial = mysqli_query($DBconn, $SQLdeletetrial);
echo '<script>alert (You have exited the quiz);</script>';
echo '<script>window.location.href="index.php";</script>'; //to students homepage
?>