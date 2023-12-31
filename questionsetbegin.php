<?php
date_default_timezone_set("Asia/Kuala_Lumpur"); //Malaysia timezone

$set = $_POST['setID'];
$mode = $_POST['mode'];
$quesnum = 1;
$_POST['currentQuestionNum']=$quesnum;
$username = $_SESSION['StudentUsername'];
$_SESSION['quiz'] = date("Y-m-d h:i:s");
$timestamp = $_SESSION['quiz'];

//reset timer for timed mode
if (isset($_SESSION['countdown_timer'])) {
    unset($_SESSION['countdown_timer']);
}

//fetch set information
$SQLset = "SELECT * FROM question_set INNER JOIN topic ON question_set.TopicID = topic.TopicID where question_set.SetID ='$set';";
$run=mysqli_query($DBconn, $SQLset);
$data=mysqli_fetch_array($run);

//insert trial information into trial table
$SQLinsert = "INSERT INTO trial (StudentUsername, SetID, QuizType, DateTime) VALUES ('$username', '$set', '$mode', '$timestamp');";
$runinsert = mysqli_query($DBconn, $SQLinsert);
$trialID = mysqli_insert_id($DBconn);

?>
<!--display set information and instruction-->
<table class="setinfo" border="0">
    <tr>
        <th>Topic:</th>
        <td><?php echo $data['TopicTitle'];?></td>
    </tr>
    <tr>
        <th>Question Set Name:</th>
        <td><?php echo $data['SetName'];?></td>
    </tr>
    <tr>
        <th>Mode:</th>
        <td><?php echo $mode;?></td>
    </tr>

    <?php
    if ($mode === 'Timed') {
        echo "<tr>
                <th>Total Time:</th> 
                <td>30 minutes</td>
            </tr>";
    }
    ?>
    <tr>
        <th>Instruction:</th>
        <td><div id="instruction"></div></td>
    </tr>
</table>
<h3>Click BEGIN to start the quiz.</h3>

<!--begin button-->
<div class="beginbutton-container">
<form method="post" action="question.php">
    <input type="hidden" name="setID" value="<?php echo $set;?>">
    <input type="hidden" name="trialID" value="<?php echo $trialID;?>">
    <input type="hidden" name="mode" value="<?php echo $mode;?>">
    <input type="hidden" name="quesNo" value="<?php echo $_POST['currentQuestionNum'];?>">
    <button type="submit" name="beginquiz" class="button2" id="beginButton">BEGIN</button> <!--button to start quiz-->
</form>
<!--exit button-->
<form method="post" action="question.php">
    <input type="hidden" name="setID" value="<?php echo $set;?>">
    <input type="hidden" name="trialID" value="<?php echo $trialID;?>">
    <button type="submit" name="exit" class="button2" id="beginButton">EXIT</button> <!--button to delete trial-->
</form>
</div>

<!--script to print instructions for each mode-->
<script>
    instruct('<?php echo $mode;?>');
    function instruct(mode) {
        var instructions = '';
        if(mode==='Practice') {
            instructions = 'Answer all questions. You may take your time in answering.';
        } else if (mode==='Timed') {
            instructions = 'Answer all questions within 30 minutes.';
        }
        document.getElementById("instruction").innerHTML = instructions;
    }
</script>