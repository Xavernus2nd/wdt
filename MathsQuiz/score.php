<?php
//calculate score and show results and show answers
//this file is onlt to calculate the score, need to create new page just to show the results + answers
//have correct or wrong in student_answer table so can see from there only la
include 'connection.php';
$setID = $_GET['setID'];
$trialID = $_GET['trialID'];
$username = $_SESSION['StudentUsername'];
$count = 0;
$i = 0;

//counting number of questions within the set
$SQLnum = "SELECT COUNT(QuestionID) FROM question WHERE SetID = '$setID';";
$runSQLnum = mysqli_query($DBconn, $SQLnum);
$dataSQLnum = mysqli_fetch_array($runSQLnum);
$totalques = $dataSQLnum["COUNT(QuestionID)"];

//get IsCorrect, if 1 then count++
$SQLcorrect = "SELECT * FROM student_answer WHERE TrialID = $trialID";
$runSQLcorrect = mysqli_query($DBconn, $SQLcorrect);

while($result = mysqli_fetch_array($runSQLcorrect)) {
    if ($result['IsCorrect'] == 1) {
        //when answer is correct
        $count++;
    }
}

$score = round(($count/$totalques) *100);

//storing score into trial table
//need to see if got time or not
$SQLupdate = "UPDATE trial SET Score = $score WHERE TrialID = $trialID;";
$runSQLupdate = mysqli_query($DBconn, $SQLupdate);
//formula = (count student answer/totalques) * 100 , see if can set decimal places

//to results and answer history page yeah
header("Location: resultanswer.php?trialID=$trialID");
exit();  // Ensure that no further code is executed after the header
?>