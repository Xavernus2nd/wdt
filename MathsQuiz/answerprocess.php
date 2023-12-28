<?php
    //save answer into student answer table 
    include 'connection.php'; 
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

    // Combine variables into array bcs im lazyyy
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

    function insertAns($data) {
        extract($data);
        if ($stdAns == $correctAns) {
            $correct = 1;
        } else {
            $correct = 0;
        }
        $SQLinsertans="INSERT INTO student_answer(TrialID, QuestionID, StudentAnswer, IsCorrect) VALUES ($trialID, $quesID, $stdAns, $correct)";
        $run = mysqli_query($DBconn, $SQLinsertans);
        if($run) {
            ?>
            <form id="redirectForm" action="quizquestion.php" method="post">
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
        } else {
            echo "<script>
                alert('Unsuccessful save');
                //window.location.href = 'index.php';
                //tbh idk where to put it
            </script>";
        }
    }

    function updateAns($data) {
        extract($data);
        if ($stdAns == $correctAns) {
            $correct = 1;
        } else {
            $correct = 0;
        }
        $SQLupdate = "UPDATE student_answer SET StudentAnswer = $stdAns, IsCorrect = $correct WHERE TrialID = $trialID AND QuestionID = $quesID";
        $runSQLupdate = mysqli_query($DBconn, $SQLupdate);
        if($runSQLupdate) {
            ?>
            <form id="redirectForm" action="quizquestion.php" method="post">
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
        } else {
            echo "<script>
                alert('Unsuccessful save');
                //window.location.href = 'index.php';
                //tbh idk where to put it
            </script>";
        }
    }

    //to view the answer if it is existing or not
    $SQLanswer = "SELECT * FROM student_answer WHERE TrialID=$trialID AND QuestionID=$quesID;";
    $runanswer = mysqli_query($DBconn, $SQLanswer);
    //when no answer submitted yet, it wont show the error of warning offset
    if (mysqli_num_rows($runanswer) > 0) {
        //update here
        updateAns($data);
    } else {
        //insert here
        insertAns($data);
    }

?>