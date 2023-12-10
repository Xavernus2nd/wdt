<?php
include 'connection.php';
//javascript to add timer or not (if timed, add)
//need to figure out how to insert into result table for the time -> if no time, time=NULL
//topic, set, question, previous next buttons, question number directory + scrollbar, save answer, submit, exit

//goals:
//1. show questions in practice mode first (no consider mode) + session + previous next button work
//2. code for both modes (if else)
//3. countdown for timed - measure the time, show the time limit

//ok need to change 
//question table has no student answer, the answer can just get from the input then compare
//add new table - StudentAnswer table to save the progress lol - can save the answer there la
//where to save the answer and print the saved answer? in here or answerprocess?

$set = $_POST['setID'];
$mode = $_POST['mode'];
$trialID = $_POST['trialID'];
$currentQuestionNum = $_POST['quesNo'];
$username = $_SESSION['StudentUsername'];

include 'counttime.php'; //timer 

//getting the questions from question set
$SQLquestion = "SELECT * FROM question INNER JOIN question_set ON question.SetID = question_set.SetID INNER JOIN topic ON question_set.TopicID = topic.TopicID WHERE question.SetID = '$set' AND question.QuestionNumber = '$currentQuestionNum';";
$run=mysqli_query($DBconn, $SQLquestion);
$data = mysqli_fetch_array($run);

//find total question
$SQLtotal = "SELECT COUNT(Question) as total FROM question WHERE SetID = '$set';";
$runSQLtotal = mysqli_query($DBconn, $SQLtotal);
$totalques = mysqli_fetch_assoc($runSQLtotal)['total'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['save'])){
        //when the student click save answer 
        include 'answerprocess.php';
    } else if (isset($_POST['exit'])){
        //when student click exit, go to begin quiz??
        echo '<script>alert (You have exited the quiz);</script>';
        //include 'question.php';
    } 
    else {
        //questions
        if(isset($data["Question"])) {
            if ($mode == 'Timed') {
                //show timer
                echo '<div id="timer" style="display: none;">Time remaining: '.gmdate("i:s, $quizDuration").'</div>';
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
        
                <input type="radio" name="studAns" value="<?php echo $data['OptionA'];?>">
                <?php echo $data['OptionA'];?><br>
                <input type="radio" name="studAns" value="<?php echo $data['OptionB'];?>">
                <?php echo $data['OptionB'];?><br>
                <input type="radio" name="studAns" value="<?php echo $data['OptionC'];?>">
                <?php echo $data['OptionC'];?><br>
                <input type="radio" name="studAns" value="<?php echo $data['OptionD'];?>">
                <?php echo $data['OptionD'];?><br>
                <?php //if got saved answer (need to see trial id, question id)
                //sql to find whether the answer alrdy exist?? - got error - bcs they run this when havent saved answer
                $SQLanswer = "SELECT * FROM student_answer WHERE TrialID=$trialID AND QuestionID=$data[QuestionID];";
                $runanswer = mysqli_query($DBconn, $SQLanswer);
                //when no answer submitted yet, it wont show the error of warning offset
                if (mysqli_num_rows($runanswer) > 0) {
                    $answerData = mysqli_fetch_array($runanswer);
                    $answer = $answerData['StudentAnswer'];
                    echo "Answer saved: " . $answer . "<br>";
                } else {
                    $answer = null;
                }
                ?>
                <button name="save">SAVE ANSWER</button> <!--save answer means they terus update student answer in table with this answer-->
            </form>
                <!--answerprocess.php masuk sini kot-->
            <form action="quizquestion.php" method="post">
                <input type="hidden" name="setID" value="<?php echo $set; ?>">
                <input type="hidden" name="trialID" value="<?php echo $trialID; ?>">
                <input type="hidden" name="timeRemaining" value="<?php echo $timeRemaining; ?>">
                <button name='answer'>SUBMIT</button> <!--when press this button, the button name is answer -> submit button meaning show the results terus (score.php). send to quizquestion.php-->
            </form>
                <button name='exit'>EXIT</button> <!--exit to begin quiz page ???, when exit -> delete that trial id-->
            <?php
            //printing previous and next button
            $nextQuestionNum = $currentQuestionNum + 1;
            $prevQuestionNum = $currentQuestionNum - 1;

            echo "<form id='navigationForm' method='post' action=''>";
            if ($prevQuestionNum > 0) {
                ?>
                <input type="hidden" name="setID" value="<?php echo $set;?>">
                <input type="hidden" name="trialID" value="<?php echo $trialID;?>">
                <input type="hidden" name="mode" value="<?php echo $mode;?>">
                <input type="hidden" name="quesNo" value="<?php echo $prevQuestionNum;?>">
                <input type="hidden" name="beginquiz" value="">
                <button onclick="submitForm()">Previous</button>
                <?php
            }
            if ($nextQuestionNum <= $totalques ) {
                ?>
                <input type="hidden" name="setID" value="<?php echo $set;?>">
                <input type="hidden" name="trialID" value="<?php echo $trialID;?>">
                <input type="hidden" name="mode" value="<?php echo $mode;?>">
                <input type="hidden" name="quesNo" value="<?php echo $nextQuestionNum;?>">
                <input type="hidden" name="beginquiz" value="">
                <button onclick="submitForm()">Next</button>
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
            </script>";
        }
    }
}

?>