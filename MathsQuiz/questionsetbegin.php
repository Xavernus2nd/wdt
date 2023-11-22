<?php
include 'connection.php';
$set = $_SESSION['setID'];
$mode = $_SESSION['mode'];
$quesnum = 1;
$_SESSION['currentQuestionNum']=$quesnum;

$SQLset = "SELECT * FROM question_set INNER JOIN topic ON question_set.TopicID = topic.TopicID where question_set.SetID ='$set';";
$run=mysqli_query($DBconn, $SQLset);
$data=mysqli_fetch_array($run);

$SQLempty = "UPDATE question SET StudentAnswer=NULL;";
$emptying = mysqli_query($DBconn, $SQLempty);

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
    <tr>
        <td>Instruction:</td>
        <td><div id="instruction"></div></td>
    </tr>
</table>
<h3>Click BEGIN to start the quiz.</h3>
<form method="get" action="quizquestion.php">
    <input type="hidden" name="setID" value="<?php echo $set;?>">
    <input type="hidden" name="mode" value="<?php echo $mode;?>">
    <input type="hidden" name="quesNo" value="<?php echo $_SESSION['currentQuestionNum'];?>">
    <button type="submit" name="beginquiz">BEGIN</button> <!--button to start quiz-->
</form>

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