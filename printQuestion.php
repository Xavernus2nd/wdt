<?php
date_default_timezone_set('Asia/Kuala_Lumpur'); //Malaysia timezone
$set = $_POST['setID'];
$mode = $_POST['mode'];
$currentQuestionNum = $_POST['quesNo'];
$trialID = $_POST['trialID'];
$username = $_SESSION['StudentUsername'];

//getting the current question from question set
$SQLquestion = "SELECT * FROM question INNER JOIN question_set ON question.SetID = question_set.SetID INNER JOIN topic ON question_set.TopicID = topic.TopicID WHERE question.SetID = '$set' AND question.QuestionNumber = '$currentQuestionNum';";
$run=mysqli_query($DBconn, $SQLquestion);
$data = mysqli_fetch_array($run);

//count total question
$SQLtotal = "SELECT COUNT(Question) as total FROM question WHERE SetID = '$set';";
$runSQLtotal = mysqli_query($DBconn, $SQLtotal);
$totalques = mysqli_fetch_assoc($runSQLtotal)['total'];

//count current number of questions answered
$SQLcount = "SELECT COUNT(StudentAnswer) as count FROM student_answer WHERE TrialID = '$trialID';";
$runSQLcount = mysqli_query($DBconn, $SQLcount);
$count = mysqli_fetch_assoc($runSQLcount)['count'];

//get answer for current question from student_answer table
$SQLanswer = "SELECT * FROM student_answer WHERE TrialID=$trialID AND QuestionID=$data[QuestionID];";
$runanswer = mysqli_query($DBconn, $SQLanswer);
if (mysqli_num_rows($runanswer) > 0) {
    $answerData = mysqli_fetch_array($runanswer);
    $answer = $answerData['StudentAnswer'];
} else {
    $answer = null;
} ?>

<script>
    function checkAnsweredQues() {
        var answeredQues = <?php echo $count;?>;
        var totalQues = <?php echo $totalques;?>;
        var submitButton = document.getElementById('submit');
        
        if (answeredQues === totalQues) {
            submitButton.disabled = false; //enable submit button
        } else {
            submitButton.disabled = true; //disable submit button
        }
    }
    //check answered questions when page loads
    window.onload = checkAnsweredQues;
</script>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['save'])){
        //when the student click save answer 
        include 'answerProcess.php';
    } else {
        //printing topic and set name
        echo "<div class='topic-container'>";
        echo "<p style='font-size: 32px; font-weight: bold;'>".$data['TopicTitle'].'</p><br>';
        echo "<p style='font-size: 24px;'>".$data['SetName'].'</p><br>';
        echo "</div>";

        //question, answer and question directory
        if(isset($data["Question"])) {
            if ($mode == 'Timed') {
                //timer if mode is timed
                echo '<div class="topic-container" id="timer" style="font-size: 22px;">Timer: </div>';
                $countdown_timer = isset($_SESSION['countdown_timer']) ? $_SESSION['countdown_timer'] : 1800; //1800 is 30 mins

                echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        var remainingTime = ' . $countdown_timer . '; //get current session countdown time
            
                        function updateTimer() {
                            var minutes = Math.floor(remainingTime / 60);
                            var seconds = remainingTime % 60;
                            var timerElement = document.getElementById("timer");
            
                            if (timerElement) {
                                var formatSeconds = seconds.toString().padStart(2, "0"); //format seconds to 2 digits 
                                timerElement.innerHTML = "<b>Timer: " + minutes + ":" + formatSeconds + "</b>";
            
                                if (remainingTime > 0) {
                                    setTimeout(updateTimer, 1000); //update timer every 1 second
                                    remainingTime--;
                                    //update session countdown timer value
                                    fetch("countTime.php", {
                                        method: "POST",
                                        headers: {
                                            "Content-Type": "application/x-www-form-urlencoded",
                                        },
                                        body: "countdown_timer=" + remainingTime
                                    });
                                } else {                                
                                    alert ("Time is up! Your answers will be submitted automatically.");
                                    //update session countdown timer value to 0 when time finishes
                                    fetch("countTime.php", {
                                        method: "POST",
                                        headers: {
                                            "Content-Type": "application/x-www-form-urlencoded",
                                        },
                                        body: "countdown_timer=0"
                                    });
                                    //automatically submit the form
                                    document.getElementById("submit").disabled = false;
                                    document.getElementById("submit").click();
                                }
                            }
                        }
                        //initial call to start countdown
                        updateTimer();                    
                    });
                </script>';
                $timeTaken = 1800 - $countdown_timer;
            } else {
                $timeTaken = null;
            } ?>
            <div class="questiondirect-object">
                <div class="question-object">
                    <form action="" method="post">
                        Question <?php echo $currentQuestionNum; ?><br>
                        <input type="hidden" name="quesNo" value="<?php echo $currentQuestionNum;?>">
                        <input type="hidden" name="trialID" value="<?php echo $trialID;?>">
                        <input type="hidden" name="quesID" value="<?php echo $data['QuestionID'];?>">
                        <input type="hidden" name="setID" value="<?php echo $data['SetID'];?>">
                        <input type="hidden" name="mode" value="<?php echo $mode;?>">
                        <?php echo $data['Question'];?> <br>
                
                        <table class="answer-container">
                            <tr>
                                <td class="answer-input"><input type="radio" name="studAns" <?php if ($answer == $data['OptionA']) {?> checked="checked" <?php } ?> value="<?php echo $data['OptionA'];?>" required="required"></td>
                                <td class="answer-label">a. </td>
                                <td class="answer-object"><?php echo $data['OptionA'];?><br></td>

                                <td class="answer-input"><input type="radio" name="studAns" <?php if ($answer == $data['OptionB']) {?> checked="checked" <?php } ?> value="<?php echo $data['OptionB'];?>" required="required"></td>
                                <td class="answer-label">b. </td>
                                <td class="answer-object"><?php echo $data['OptionB'];?><br></td>
                            </tr>
                            <tr>
                                <td class="answer-input"><input type="radio" name="studAns" <?php if ($answer == $data['OptionC']) {?> checked="checked" <?php } ?> value="<?php echo $data['OptionC'];?>" required="required"></td>
                                <td class="answer-label">c. </td>
                                <td class="answer-object"><?php echo $data['OptionC'];?><br></td>

                                <td class="answer-input"><input type="radio" name="studAns" <?php if ($answer == $data['OptionD']) {?> checked="checked" <?php } ?> value="<?php echo $data['OptionD'];?>" required="required"></td>
                                <td class="answer-label">d. </td>
                                <td class="answer-object"><?php echo $data['OptionD'];?><br></td>
                            </tr>
                        </table>
                        <br>
                        <button class="save-button" name="save" onclick="checkAnsweredQues()">SAVE ANSWER</button>
                    </form>
                </div>

                <!--question directory-->
                <div class="directory-container">
                    <div class="scroll-div">
                        <?php
                            include 'quesDirectory.php'; 
                        ?>
                    </div>
                </div>
            </div>

            <!--buttons-->
            <div class="button-container">
                <div class="prevnext-object">
                    <tr>
                        <?php
                        //calculate previous and next question number
                        $nextQuestionNum = $currentQuestionNum + 1;
                        $prevQuestionNum = $currentQuestionNum - 1;
                
                        //previous button
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
                        //next button
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
                        //submit the navigation form
                        echo "<script>
                            function submitForm() {
                                document.getElementById('navigationForm').submit();
                            }
                        </script>";
                    ?>
                </div>
                <div class="submitexit-object">
                    <!--submit button-->
                    <form onsubmit="return confirm('Are you sure to submit the quiz? \nYou will not be able to change your answers.');" action="question.php" method="post">
                        <input type="hidden" name="setID" value="<?php echo $set; ?>">
                        <input type="hidden" name="trialID" value="<?php echo $trialID; ?>">
                        <input type="hidden" name="timeTaken" value="<?php echo $timeTaken; ?>">
                        <input type="hidden" name="mode" value="<?php echo $mode; ?>">                            
                        <button name='answer' id='submit'>SUBMIT</button> 
                        <!--when all questions havent answered, it disables this button-->            
                    </form>
                    <!--exit button-->
                    <form onsubmit="return confirm('Do you want to exit the quiz? \nYour attempt will not be saved.');" method="post" action="question.php">
                        <input type="hidden" name="setID" value="<?php echo $set;?>">
                        <input type="hidden" name="trialID" value="<?php echo $trialID;?>">
                        <button type="submit" name="exit">EXIT</button>
                    </form>
                </div>
            </div>
            <?php
        }
    }
} 
?>