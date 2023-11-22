<?php
//calculate score and show results and show answers
include 'connection.php';
$setID = $_GET['setID'];
$username = $_SESSION['StudentUsername'];
$count = 0;
$i = 0;

//counting number of questions teehee
$SQLnum = "SELECT COUNT(QuestionID) FROM question WHERE SetID = '$setID';";
$runSQLnum = mysqli_query($DBconn, $SQLnum);
$dataSQLnum = mysqli_fetch_array($runSQLnum);
$totalques = $dataSQLnum["COUNT(QuestionID)"];

//the logic: if answer == student answer, count++;
$SQLitem = "SELECT * FROM question WHERE SetID = '$setID';";
$runSQLitem = mysqli_query($DBconn, $SQLitem);

while ($dataSQLitem = mysqli_fetch_array($runSQLitem)){
    $studAns = $dataSQLitem["StudentAnswer"];
    $answer = $dataSQLitem["Answer"];
    if ($answer == $studAns) {
        $count++;
        echo $studAns."<br>";
    } else {
        echo "Wrong answer: ".$studAns."<br>";
    }

}

$score = ($count/$totalques) *100;
echo $totalques."<br>";
echo $count."<br>";
echo $score;

//formula = (count student answer/totalques) * 100 , see if can set decimal places

?>