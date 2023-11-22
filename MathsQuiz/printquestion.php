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

$set = $_SESSION['setID'];
$mode = $_SESSION['mode'];
$currentQuestionNum = $_GET['quesNo'];
$username = $_SESSION['StudentUsername'];
$SQLquestion = "SELECT * FROM question INNER JOIN question_set ON question.SetID = question_set.SetID INNER JOIN topic ON question_set.TopicID = topic.TopicID WHERE question.SetID = '$set' AND question.QuestionNo = '$currentQuestionNum';";
$run=mysqli_query($DBconn, $SQLquestion);
$data = mysqli_fetch_array($run);

//find total question
$SQLtotal = "SELECT COUNT(Question) as total FROM question WHERE SetID = '$set';";
$runSQLtotal = mysqli_query($DBconn, $SQLtotal);
$totalques = mysqli_fetch_assoc($runSQLtotal)['total'];

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['save'])){
        //when the student click save answer IDKKK
        include 'answerprocess.php';
    } else if (isset($_GET['exit'])){
        //when student click exit, go to begin quiz??
        echo '<script>alert (You have exited the quiz);</script>';
        //include 'question.php';
    } else {
        //questions
        if(isset($data["Question"])) {
            //include counttime.php for countdown 

            ?>
            <form action="quizquestion.php" method="GET">
                Question: <?php echo $currentQuestionNum; ?><br>
                <input type="hidden" name="quesNo" value="<?php echo $currentQuestionNum;?>">
                <input type="hidden" name="quesID" value="<?php echo $data['QuestionID'];?>">
                <input type="hidden" name="setID" value="<?php echo $data['SetID'];?>">
                <?php echo $data['Question'];?> <br>
        
                <input type="radio" name="studAns" value="<?php echo $data['OptionA'];?>">
                <?php echo $data['OptionA'];?><br>
                <input type="radio" name="studAns" value="<?php echo $data['OptionB'];?>">
                <?php echo $data['OptionB'];?><br>
                <input type="radio" name="studAns" value="<?php echo $data['OptionC'];?>">
                <?php echo $data['OptionC'];?><br>
                <input type="radio" name="studAns" value="<?php echo $data['OptionD'];?>">
                <?php echo $data['OptionD'];?><br>
                <?php //if got saved answer
                if ($data['StudentAnswer'] != NULL) {
                    echo "Answer saved: ".$data['StudentAnswer']."<br>";
                } ?>
        
                <input type="hidden" name="ans" value="<?php echo $data['Answer']; ?>">
                <button name="save">SAVE ANSWER</button> <!--save answer means they terus update student answer in table with this answer-->
                <!--answerprocess.php masuk sini kot-->
                <button name='answer'>SUBMIT</button> <!--when press this button, the button name is answer -> submit button meaning show the results terus (score.php)-->
                <button name='exit'>EXIT</button> <!--exit to begin quiz page ???-->
            </form>
            <?php
            //printing previous and next button
            $nextQuestionNum = $currentQuestionNum + 1;
            $prevQuestionNum = $currentQuestionNum - 1;
        
            if ($prevQuestionNum > 0) {
                echo "<button><a href = '?setID=$set&mode=$mode&quesNo=$prevQuestionNum&beginquiz='>Previous</a></button>";
            }
            if ($nextQuestionNum <= $totalques ) {
                echo "<button><a href = '?setID=$set&mode=$mode&quesNo=$nextQuestionNum&beginquiz='>Next</a></button>";
            }
            if ($currentQuestionNum == $totalques) {
                echo "<br>You have reached the last question in this set.";
            }
        }
    }
}

?>