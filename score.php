<?php
$SetID = $_POST['SetID'];
$TrialID = $_POST['TrialID'];
$TimeTaken = $_POST['TimeTaken'];
$Mode = $_POST['Mode'];
$StudentUsername = $_SESSION['StudentUsername'];
$count = 0;
$i = 0;

//counting number of questions within the set
$SQLnum = "SELECT COUNT(QuestionID) as total FROM question WHERE SetID = '$SetID';";
$runSQLnum = mysqli_query($DBconn, $SQLnum);
$totalques = mysqli_fetch_array($runSQLnum)["total"];

//get IsCorrect, if 1 then count++
$SQLcorrect = "SELECT * FROM student_answer WHERE TrialID = $TrialID";
$runSQLcorrect = mysqli_query($DBconn, $SQLcorrect);

while($result = mysqli_fetch_array($runSQLcorrect)) {
    if ($result['IsCorrect'] == 1) {
        $count++;
    }
}

$score = round(($count/$totalques) *100);

//storing score and time taken into trial table 
$SQLupdate = "UPDATE trial SET Score = $score, TimeTaken = '$TimeTaken' WHERE TrialID = $TrialID;";
$runSQLupdate = mysqli_query($DBconn, $SQLupdate);
?>
<form id="resultForm" action="resultAnswer.php" method="POST">
    <input type="hidden" name="TrialID" value="<?php echo $TrialID;?>">
    <input type="hidden" name="SetID" value="<?php echo $SetID;?>">
    <input type="hidden" name="Mode" value="<?php echo $Mode;?>">
</form>
<script>
    //submit form automatically
    document.getElementById("resultForm").submit();
</script>