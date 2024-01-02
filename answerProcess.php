<?php
$quesnum = $_POST['quesNo'];
$quesID = $_POST['quesID'];
$mode = $_POST['mode'];
$trialID = $_POST['trialID'];
$set = $_POST['setID'];
$stdAns = $_POST['studAns'];
$correct = 0;
$username = $_SESSION['StudentUsername'];

//get the correct answer from question table
$SQLcorrect = "SELECT * FROM question WHERE QuestionID = $quesID;";
$runSQLcorrect = mysqli_query($DBconn, $SQLcorrect);
$correctAns = mysqli_fetch_array($runSQLcorrect)['Answer'];

//to view the answer if it is existing or not
$SQLanswer = "SELECT * FROM student_answer WHERE TrialID=$trialID AND QuestionID=$quesID;";
$runanswer = mysqli_query($DBconn, $SQLanswer);

//combine variables into array to pass into functions
$data = [
    'DBconn' => $DBconn,
    'trialID' => $trialID,
    'quesID' => $quesID,
    'stdAns' => $stdAns,
    'set' => $set,
    'quesnum' => $quesnum,
    'mode' => $mode,
    'correct' => $correct,
    'correctAns' => $correctAns
];

function runSQL($sql, $data) {
    //run sql query and redirect to current question
    extract($data);
    $run = mysqli_query($DBconn, $sql);
    ?>
    <form id="redirectForm" action="question.php" method="post">
        <input type="hidden" name="setID" value="<?php echo $set; ?>">
        <input type="hidden" name="trialID" value="<?php echo $trialID; ?>">
        <input type="hidden" name="mode" value="<?php echo $mode; ?>">
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
    $sql="INSERT INTO student_answer(TrialID, QuestionID, StudentAnswer, IsCorrect) VALUES ($trialID, $quesID, $stdAns, $correct)";
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
    $sql = "UPDATE student_answer SET StudentAnswer = $stdAns, IsCorrect = $correct WHERE TrialID = $trialID AND QuestionID = $quesID";
    return runSQL($sql, $data);
}
    
if (mysqli_num_rows($runanswer) > 0) {
    //update if there is an existing answer
    updateAns($data);
} else {
    //insert 
    insertAns($data);
} ?>