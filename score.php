<?php
$setID = $_POST['setID'];
$trialID = $_POST['trialID'];
$timeTaken = $_POST['timeTaken'];
$mode = $_POST['mode'];
$username = $_SESSION['StudentUsername'];
$count = 0;
$i = 0;

//counting number of questions within the set
$SQLnum = "SELECT COUNT(QuestionID) as total FROM question WHERE SetID = '$setID';";
$runSQLnum = mysqli_query($DBconn, $SQLnum);
$totalques = mysqli_fetch_array($runSQLnum)["total"];

//get IsCorrect, if 1 then count++
$SQLcorrect = "SELECT * FROM student_answer WHERE TrialID = $trialID";
$runSQLcorrect = mysqli_query($DBconn, $SQLcorrect);

while($result = mysqli_fetch_array($runSQLcorrect)) {
    if ($result['IsCorrect'] == 1) {
        $count++;
    }
}

$score = round(($count/$totalques) *100);

//storing score and time taken into trial table 
$SQLupdate = "UPDATE trial SET Score = $score, TimeTaken = '$timeTaken' WHERE TrialID = $trialID;";
$runSQLupdate = mysqli_query($DBconn, $SQLupdate);
?>
<form id="resultForm" action="resultanswer.php" method="POST">
    <input type="hidden" name="trialID" value="<?php echo $trialID;?>">
    <input type="hidden" name="setID" value="<?php echo $setID;?>">
    <input type="hidden" name="mode" value="<?php echo $mode;?>">
</form>
<script>
    //submit form automatically
    document.getElementById("resultForm").submit();
</script>