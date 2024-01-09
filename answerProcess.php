<?php
$quesnum = $_POST['quesNo'];
$quesID = $_POST['quesID'];
$Mode = $_POST['Mode'];
$TrialID = $_POST['TrialID'];
$SetID = $_POST['SetID'];
$stdAns = $_POST['studAns'];
$correct = 0;
$StudentUsername = $_SESSION['StudentUsername'];

//get the correct answer from question table
$SQLcorrect = "SELECT * FROM question WHERE QuestionID = $quesID;";
$runSQLcorrect = mysqli_query($DBconn, $SQLcorrect);
$correctAns = mysqli_fetch_array($runSQLcorrect)['Answer'];

//to view the answer if it is existing or not
$SQLanswer = "SELECT * FROM student_answer WHERE TrialID = $TrialID AND QuestionID = $quesID;";
$runanswer = mysqli_query($DBconn, $SQLanswer);

//combine variables into array to pass into functions
$data = [
    'DBconn' => $DBconn,
    'TrialID' => $TrialID,
    'quesID' => $quesID,
    'stdAns' => $stdAns,
    'SetID' => $SetID,
    'quesnum' => $quesnum,
    'Mode' => $Mode,
    'correct' => $correct,
    'correctAns' => $correctAns
];

function runSQL($sql, $data) {
    //run sql query and redirect to current question
    extract($data);
    $run = mysqli_query($DBconn, $sql);
    ?>
    <form id="redirectForm" action="question.php" method="post">
        <input type="hidden" name="SetID" value="<?php echo $SetID; ?>">
        <input type="hidden" name="TrialID" value="<?php echo $TrialID; ?>">
        <input type="hidden" name="Mode" value="<?php echo $Mode; ?>">
        <input type="hidden" name="quesNo" value="<?php echo $quesnum; ?>">
        <input type="hidden" name="beginquiz" value="">
    </form>

    <script>
        document.getElementById('redirectForm').submit();
    </script>
    <?php
}

function insertAns($data) {
    //insert answer into student answer table
    extract($data);
    if ($stdAns == $correctAns) {
        $correct = 1;
    } else {
        $correct = 0;
    }
    $sql="INSERT INTO student_answer(TrialID, QuestionID, StudentAnswer, IsCorrect) 
          VALUES ($TrialID, $quesID, '$stdAns', $correct)";
    return runSQL($sql, $data);
}

function updateAns($data) {
    //update answer into student answer table
    extract($data);
    if ($stdAns == $correctAns) {
        $correct = 1;
    } else {
        $correct = 0;
    }
    $sql = "UPDATE student_answer SET StudentAnswer = $stdAns, IsCorrect = $correct WHERE TrialID = $TrialID AND QuestionID = $quesID";
    return runSQL($sql, $data);
}
    
if (mysqli_num_rows($runanswer) > 0) {
    //update if there is an existing answer
    updateAns($data);
} else {
    //insert 
    insertAns($data);
} ?>