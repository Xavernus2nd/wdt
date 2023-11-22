<?php
    //save answer into student answer table 
    include 'connection.php'; 
    $quesnum = $_GET['quesNo'];
    $quesID = $_GET['quesID'];
    $mode = $_SESSION['mode'];
    $set = $_SESSION['setID'];
    $stdAns = $_GET['studAns'];
    $ans = $_GET['ans'];
    $username = $_SESSION['StudentUsername'];
    //logic:
    //  if the student didnt answer yet, become insert
    //  else if the student alrdy answered and want to change the answer, become update ??
    //  need to use 3 different sqls kah 1- view the student answer table, 2-insert into student answer table, 3-update in student answer table AA
    $SQLupdate = "UPDATE question SET StudentAnswer='$stdAns' WHERE QuestionNo = $quesnum AND SetID = '$set';";
    $run = mysqli_query($DBconn, $SQLupdate);
    if($run) {
        echo "<script>
                window.location.href = 'quizquestion.php?setID=$set&mode=$mode&quesNo=$quesnum&beginquiz=';
            </script>";
    } else {
        echo "<script>
                window.location.href = 'quizquestion.php?setID=$set&mode=$mode&quesNo=$quesnum&beginquiz=';
            </script>";
    }

?>