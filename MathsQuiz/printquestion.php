<?php
include 'connection.php';
date_default_timezone_set('Asia/Kuala_Lumpur');

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
    } else {
        //printing topic and set name
        echo "<div class='topic-container'>";
        echo "<h2>".$data['TopicTitle'].'</h2><br>';
        echo "<h4>".$data['SetName'].'</h4><br>';
        echo "</div>";
        //questions
        if(isset($data["Question"])) {
            if ($mode == 'Timed') {
                echo '<div class="topic-container" id="timer">Timer: 30:00</div>';
                $countdown_timer = isset($_SESSION['countdown_timer']) ? $_SESSION['countdown_timer'] : 1800; //1800 is 30 mins

                echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        var remainingTime = ' . $countdown_timer . ';
            
                        function updateTimer() {
                            var minutes = Math.floor(remainingTime / 60);
                            var seconds = remainingTime % 60;
                            var timerElement = document.getElementById("timer");
            
                            if (timerElement) {
                                var formatSeconds = seconds.toString().padStart(2, "0");
                                timerElement.innerHTML = "<b>Timer: " + minutes + ":" + formatSeconds + "</b>";
            
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
                                    alert ("Time is up! Your answers will be submitted automatically.");
                                    // Update the session variable with the latest countdown value (when times up)
                                    fetch("counttime.php", {
                                        method: "POST",
                                        headers: {
                                            "Content-Type": "application/x-www-form-urlencoded",
                                        },
                                        body: "countdown_timer=0",
                                    });
                                    //automatically submit the form
                                    document.getElementById("submit").disabled = false;
                                    document.getElementById("submit").click();
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
            } ?>

            <div class="questiondirect-object">
                <div class="question-object">
                    <form action="quizquestion.php" method="post">
                        Question <?php echo $currentQuestionNum; ?><br>
                        <input type="hidden" name="quesNo" value="<?php echo $currentQuestionNum;?>">
                        <input type="hidden" name="trialID" value="<?php echo $trialID;?>">
                        <input type="hidden" name="quesID" value="<?php echo $data['QuestionID'];?>">
                        <input type="hidden" name="setID" value="<?php echo $data['SetID'];?>">
                        <input type="hidden" name="mode" value="<?php echo $mode;?>">
                        <?php echo $data['Question'];?> <br>
                
                        <table class="answer-container">
                            <tr>
                                <td><input type="radio" name="studAns" <?php if ($answer == $data['OptionA']) {?> checked="checked" <?php } ?> value="<?php echo $data['OptionA'];?>" required="required">
                                a. <?php echo $data['OptionA'];?><br></td>
                                <td><input type="radio" name="studAns" <?php if ($answer == $data['OptionB']) {?> checked="checked" <?php } ?> value="<?php echo $data['OptionB'];?>" required="required">
                                b. <?php echo $data['OptionB'];?><br></td>
                            </tr>
                            <tr>
                                <td><input type="radio" name="studAns" <?php if ($answer == $data['OptionC']) {?> checked="checked" <?php } ?> value="<?php echo $data['OptionC'];?>" required="required">
                                c. <?php echo $data['OptionC'];?><br></td>
                                <td><input type="radio" name="studAns" <?php if ($answer == $data['OptionD']) {?> checked="checked" <?php } ?> value="<?php echo $data['OptionD'];?>" required="required">
                                d. <?php echo $data['OptionD'];?><br></td>
                            </tr>
                        </table>
                        <br>
                        <button name="save" onclick="checkAnsweredQues()">SAVE ANSWER</button>
                    </form>
                </div>
                <div class="directory-container">
                    <div class="scroll-div">
                        <?php
                            include 'quesdirectory.php'; 
                        ?>
                    </div>
                </div>
            </div>
            <div class="button-container">
                <div class="prevnext-object">
                    <tr>
                        <?php
                        //printing previous and next button
                        $nextQuestionNum = $currentQuestionNum + 1;
                        $prevQuestionNum = $currentQuestionNum - 1;
                
                        if ($prevQuestionNum >= 1) {
                            ?>
                            <form id='navigationForm' method='post' action=''>
                            <input type="hidden" name="setID" value="<?php echo $set;?>">
                            <input type="hidden" name="trialID" value="<?php echo $trialID;?>">
                            <input type="hidden" name="mode" value="<?php echo $mode;?>">
                            <input type="hidden" name="quesNo" value="<?php echo $prevQuestionNum;?>">
                            <input type="hidden" name="beginquiz" value="">
                            <td><button class="prev-button" onclick="submitForm()">&#706;</button></td>
                            </form>
                            <?php
                        } else {
                            echo "<p class='empty-button'></p>";
                        }
                        if ($nextQuestionNum <= $totalques ) {
                            ?>
                            <form id='navigationForm' method='post' action=''>
                            <input type="hidden" name="setID" value="<?php echo $set;?>">
                            <input type="hidden" name="trialID" value="<?php echo $trialID;?>">
                            <input type="hidden" name="mode" value="<?php echo $mode;?>">
                            <input type="hidden" name="quesNo" value="<?php echo $nextQuestionNum;?>">
                            <input type="hidden" name="beginquiz" value="">
                            <td><button class="next-button" onclick="submitForm()">&#707;</button></td>
                            </form>
                            <?php
                        } else {
                            echo "<p class='empty-button'></p>";
                        }
                        echo "</form>";
                        //submit the form
                        echo "<script>
                            function submitForm() {
                                document.getElementById('navigationForm').submit();
                            }
                        </script>";

                    ?>
                </div>
                <div class="submitexit-object">
                        <form action="quizquestion.php" method="post">
                            <input type="hidden" name="setID" value="<?php echo $set; ?>">
                            <input type="hidden" name="trialID" value="<?php echo $trialID; ?>">
                            <input type="hidden" name="timeTaken" value="<?php echo $timeTaken; ?>">
                            
                            <td><button name='answer' id='submit'>SUBMIT</button></td> <!--when press this button, the button name is answer -> submit button meaning show the results terus (score.php). send to quizquestion.php-->
                            <!--when all questions havent answered, it disables this button-->
                            <!--need to calculate number of questions answered, so need sql to count number of questions answered where student_answer ques id == question ques id-->
                        </form>
                        <!--send the set id, trial id to POST-->
                        <form method="post" action="quizquestion.php">
                            <input type="hidden" name="setID" value="<?php echo $set;?>">
                            <input type="hidden" name="trialID" value="<?php echo $trialID;?>">
                            <td><button type="submit" name="exit">EXIT</button></td> <!--button to delete trial, send to question.php-->
                        </form>
                </div>
                <?php
            echo "</div>";
        }
    }
}
?>
