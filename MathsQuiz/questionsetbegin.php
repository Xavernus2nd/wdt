<?php
include 'connection.php';
$set = $_POST['setID'];
$mode = $_POST['mode'];
$quesnum = 1;
$_POST['currentQuestionNum']=$quesnum;
$username = $_SESSION['StudentUsername'];

//set timezone to KL
date_default_timezone_set("Asia/Kuala_Lumpur");
$_SESSION['quiz'] = date("Y-m-d h:i:s");
$timestamp = $_SESSION['quiz'];

//reset timer for timed mode
if (isset($_SESSION['countdown_timer'])) {
    unset($_SESSION['countdown_timer']);
}

$SQLset = "SELECT * FROM question_set INNER JOIN topic ON question_set.TopicID = topic.TopicID where question_set.SetID ='$set';";
$run=mysqli_query($DBconn, $SQLset);
$data=mysqli_fetch_array($run);

//generate trial id - here is generated everytime the user clicks the practice
//must find way for when student exit the question without submitting, it gives a notice and if the student wants to leave, then delete the trial id
$SQLinsert = "INSERT INTO trial (StudentUsername, SetID, QuizType, DateTime) VALUES ('$username', '$set', '$mode', '$timestamp');";
$runinsert = mysqli_query($DBconn, $SQLinsert);
$trialID = mysqli_insert_id($DBconn);

?>
<table class="setinfo" border="0">
    <tr>
        <td>Topic:</td>
        <td><?php echo $data['TopicTitle'];?></td>
    </tr>
    <tr>
        <td>Question Set Name:</td>
        <td><?php echo $data['SetName'];?></td>
    </tr>
    <tr>
        <td>Mode:</td>
        <td><?php echo $mode;?></td>
    </tr>

    <?php
    if ($mode === 'Timed') {
        echo "<tr>
                <td>Total Time:</td> 
                <td>35 minutes</td>
            </tr>";
    }
    ?>
    <tr>
        <td>Instruction:</td>
        <td><div id="instruction"></div></td>
    </tr>
</table>
<h3>Click BEGIN to start the quiz.</h3>

<!--send the set id, trial id, mode, and question no to the url, need to change to POST-->
<form method="post" action="quizquestion.php">
    <input type="hidden" name="setID" value="<?php echo $set;?>">
    <input type="hidden" name="trialID" value="<?php echo $trialID;?>">
    <input type="hidden" name="mode" value="<?php echo $mode;?>">
    <input type="hidden" name="quesNo" value="<?php echo $_POST['currentQuestionNum'];?>">
    <button type="submit" name="beginquiz" id="beginButton">BEGIN</button> <!--button to start quiz, send to question.php, starts timer-->
</form>

<!--send the set id, trial id to POST-->
<form method="post" action="quizquestion.php">
    <input type="hidden" name="setID" value="<?php echo $set;?>">
    <input type="hidden" name="trialID" value="<?php echo $trialID;?>">
    <button type="submit" name="exit" id="beginButton">EXIT</button> <!--button to delete trial, send to question.php-->
</form>

<!--script to print instructions for each mode-->
<script>
    instruct('<?php echo $mode;?>');
    function instruct(mode) {
        var instructions = '';
        if(mode==='Practice') {
            instructions = 'Answer all questions. You may take your time in answering.';
        } else if (mode==='Timed') {
            instructions = 'You are given 5 minutes to read the questions. You may begin answering the quiz after the reading time. Answer all questions within 30 minutes.';
        }
        document.getElementById("instruction").innerHTML = instructions;
    }
</script>
