<?php
    //save answer into student answer table 
    include 'connection.php'; 
    $quesnum = $_GET['quesNo'];
    $quesID = $_GET['quesID'];
    $mode = $_GET['mode'];
    $trialID = $_GET['trialID'];
    $set = $_GET['setID'];
    $stdAns = $_GET['studAns'];
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
        //must figure out how to do this by POST
        if($run) {
            echo "<script>
                    window.location.href = 'quizquestion.php?setID=$set&trialID=$trialID&mode=$mode&quesNo=$quesnum&beginquiz=';
                </script>";
        } else {
            echo "<script>
                    window.location.href = 'quizquestion.php?setID=$set&trialID=$trialID&mode=$mode&quesNo=$quesnum&beginquiz=';
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
            echo "<script>
                    window.location.href = 'quizquestion.php?setID=$set&trialID=$trialID&mode=$mode&quesNo=$quesnum&beginquiz=';
                </script>";
        } else {
            echo "<script>
                    window.location.href = 'quizquestion.php?setID=$set&trialID=$trialID&mode=$mode&quesNo=$quesnum&beginquiz=';
                </script>";
        }
    }

    //logic:
    //  if the student didnt answer yet, become insert
    //  else if the student alrdy answered and want to change the answer, become update ??
    //  need to use 3 different sqls kah 1- view the student answer table, 2-insert into student answer table, 3-update in student answer table AA

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