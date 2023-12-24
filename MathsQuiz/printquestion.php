<?php
include 'connection.php';
date_default_timezone_set('Asia/Kuala_Lumpur');
//javascript to add timer or not (if timed, add)
//need to figure out how to insert into result table for the time -> if no time, time=NULL
//topic, set, question, previous next buttons, question number directory + scrollbar, save answer, submit, exit - DONE

//goals:
//1. show questions in practice mode first (no consider mode) + session + previous next button work - DONE
//2. code for both modes (if else)
//3. countdown for timed - measure the time, show the time limit

$set = $_POST['setID'];
$mode = $_POST['mode'];
$currentQuestionNum = $_POST['quesNo'];
$trialID = $_POST['trialID'];

$username = $_SESSION['StudentUsername'];

//getting the questions from question set
$SQLquestion = "SELECT * FROM question INNER JOIN question_set ON question.SetID = question_set.SetID INNER JOIN topic ON question_set.TopicID = topic.TopicID WHERE question.SetID = '$set' AND question.QuestionNumber = '$currentQuestionNum';";
$run=mysqli_query($DBconn, $SQLquestion);
$data = mysqli_fetch_array($run);

//find total question
$SQLtotal = "SELECT COUNT(Question) as total FROM question WHERE SetID = '$set';";
$runSQLtotal = mysqli_query($DBconn, $SQLtotal);
$totalques = mysqli_fetch_assoc($runSQLtotal)['total'];

//count current number of questions answered
$SQLcount = "SELECT COUNT(StudentAnswer) as count FROM student_answer WHERE TrialID = '$trialID';";
$runSQLcount = mysqli_query($DBconn, $SQLcount);
$count = mysqli_fetch_assoc($runSQLcount)['count'];

//get answer from student_answer table
$SQLanswer = "SELECT * FROM student_answer WHERE TrialID=$trialID AND QuestionID=$data[QuestionID];";
$runanswer = mysqli_query($DBconn, $SQLanswer);
if (mysqli_num_rows($runanswer) > 0) {
    $answerData = mysqli_fetch_array($runanswer);
    $answer = $answerData['StudentAnswer'];
} else {
    $answer = null;
}

//printing topic and set name
echo "Topic: ".$data['TopicTitle'].'<br>';
echo "Question Set: ".$data['SetName'].'<br><br>';

?>

<script>
    function checkAnsweredQues() {
        var answeredQues = <?php echo $count;?>;
        var totalQues = <?php echo $totalques;?>;
        var submitButton = document.getElementById('submit');
        
        if (answeredQues === totalQues) {
            submitButton.disabled = false; // enable submit button
        } else {
            submitButton.disabled = true; // disable submit button
        }
    }
    
    // Call the function to check answered questions on page load
    window.onload = checkAnsweredQues;
</script>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['save'])){
        //when the student click save answer 
        include 'answerprocess.php';

    } 
    else {
        //questions
        if(isset($data["Question"])) {
            if ($mode == 'Timed') {
                echo '<div id="timer">30:00</div>';
                $countdown_timer = isset($_SESSION['countdown_timer']) ? $_SESSION['countdown_timer'] : 1800;
    
                echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        var remainingTime = ' . $countdown_timer . ';
            
                        function updateTimer() {
                            var minutes = Math.floor(remainingTime / 60);
                            var seconds = remainingTime % 60;
            
                            var timerElement = document.getElementById("timer");
            
                            if (timerElement) {
                                timerElement.innerHTML = minutes + ":" + seconds;
            
                                if (remainingTime > 0) {
                                    setTimeout(updateTimer, 1000); // Update every second
                                    remainingTime--;
                                    // Update the session variable with the latest countdown value
                                    fetch("counttime.php", {
                                        method: "POST",
                                        headers: {
                                            "Content-Type": "application/x-www-form-urlencoded",
                                        },
                                        body: "countdown_timer=" + remainingTime,
                                    });
                                } else {
                                    timerElement.innerHTML = "Time\'s up!";
                                    // Update the session variable with the latest countdown value (when times up)
                                    fetch("counttime.php", {
                                        method: "POST",
                                        headers: {
                                            "Content-Type": "application/x-www-form-urlencoded",
                                        },
                                        body: "countdown_timer=0",
                                    });
                                }
                            }
                        }
            
                        // Initial call to start the countdown
                        updateTimer();
                    });
                </script>';
                $timeTaken = 1800 - $countdown_timer;
            } else {
                $timeTaken = null;
            }

            ?>
            <form action="quizquestion.php" method="post">
                Question: <?php echo $currentQuestionNum; ?><br>
                <input type="hidden" name="quesNo" value="<?php echo $currentQuestionNum;?>">
                <input type="hidden" name="trialID" value="<?php echo $trialID;?>">
                <input type="hidden" name="quesID" value="<?php echo $data['QuestionID'];?>">
                <input type="hidden" name="setID" value="<?php echo $data['SetID'];?>">
                <input type="hidden" name="mode" value="<?php echo $mode;?>">
                <?php echo $data['Question'];?> <br>
        
                <input type="radio" name="studAns" <?php if ($answer == $data['OptionA']) {?> checked="checked" <?php } ?> value="<?php echo $data['OptionA'];?>">
                <?php echo $data['OptionA'];?><br>
                <input type="radio" name="studAns" <?php if ($answer == $data['OptionB']) {?> checked="checked" <?php } ?> value="<?php echo $data['OptionB'];?>">
                <?php echo $data['OptionB'];?><br>
                <input type="radio" name="studAns" <?php if ($answer == $data['OptionC']) {?> checked="checked" <?php } ?> value="<?php echo $data['OptionC'];?>">
                <?php echo $data['OptionC'];?><br>
                <input type="radio" name="studAns" <?php if ($answer == $data['OptionD']) {?> checked="checked" <?php } ?> value="<?php echo $data['OptionD'];?>">
                <?php echo $data['OptionD'];?><br>
                <?php //if got saved answer (need to see trial id, question id)
                //sql to find whether the answer alrdy exist?? - got error - bcs they run this when havent saved answer
                
                //if got answer alrdy, check/tick the answer yeahhh - maybe sql answer before form
                ?>
                <button name="save" onclick="checkAnsweredQues()">SAVE ANSWER</button> <!--save answer means they terus update student answer in table with this answer-->
            </form>
            
            <!--answerprocess.php masuk sini kot-->
            <form action="quizquestion.php" method="post">
                <input type="hidden" name="setID" value="<?php echo $set; ?>">
                <input type="hidden" name="trialID" value="<?php echo $trialID; ?>">
                <input type="hidden" name="timeTaken" value="<?php echo $timeTaken; ?>">
                
                <button name='answer' id='submit'>SUBMIT</button> <!--when press this button, the button name is answer -> submit button meaning show the results terus (score.php). send to quizquestion.php-->
                <!--when all questions havent answered, it disables this button-->
                <!--need to calculate number of questions answered, so need sql to count number of questions answered where student_answer ques id == question ques id-->
            </form>
            <!--send the set id, trial id to POST-->
            <form method="post" action="quizquestion.php">
                <input type="hidden" name="setID" value="<?php echo $set;?>">
                <input type="hidden" name="trialID" value="<?php echo $trialID;?>">
                <button type="submit" name="exit">EXIT</button> <!--button to delete trial, send to question.php-->
            </form>

            <?php
            //printing previous and next button
            $nextQuestionNum = $currentQuestionNum + 1;
            $prevQuestionNum = $currentQuestionNum - 1;

       

            echo "<form id='navigationForm' method='post' action=''>";
            if ($prevQuestionNum >= 1) {
                ?>
                <form id='navigationForm' method='post' action=''>
                <input type="hidden" name="setID" value="<?php echo $set;?>">
                <input type="hidden" name="trialID" value="<?php echo $trialID;?>">
                <input type="hidden" name="mode" value="<?php echo $mode;?>">
                <input type="hidden" name="quesNo" value="<?php echo $prevQuestionNum;?>">
                <input type="hidden" name="beginquiz" value="">
                <button onclick="submitForm()">Previous</button>
                </form>
                <?php
            }
            if ($nextQuestionNum <= $totalques ) {
                ?>
                <form id='navigationForm' method='post' action=''>
                <input type="hidden" name="setID" value="<?php echo $set;?>">
                <input type="hidden" name="trialID" value="<?php echo $trialID;?>">
                <input type="hidden" name="mode" value="<?php echo $mode;?>">
                <input type="hidden" name="quesNo" value="<?php echo $nextQuestionNum;?>">
                <input type="hidden" name="beginquiz" value="">
                <button onclick="submitForm()">Next</button>
                <form id='navigationForm' method='post' action=''>
                <?php
            }
            if ($currentQuestionNum == $totalques) {
                echo "<br>You have reached the last question in this set.";
            }
            echo "</form>";
            //submit the form
            echo "<script>
                function submitForm() {
                    document.getElementById('navigationForm').submit();
                }
            </script>";
        }
    }
}

?>