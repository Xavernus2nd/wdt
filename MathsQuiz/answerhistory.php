<?php
//showing question, answer and the correct answer
//if can, i wanna highlight the wrong answers with red background yeah
//show the information in a table bcs why not hahahahhahahha
include 'connection.php';
$trialID = $_POST['trialID'];
//$timeRemaining = $_POST['timeRemaining'];
echo $trialID;
//echo $timeRemaining;

//present the answer in table form
echo '
<div id="table-container">
    <table class="tableset" border="1">
        <tr>
            <th id="num">No.</th>
            <th id="ques">Question</th>
            <th id="stdAns">Student Answer</th>
            <th id="correctAns">Correct Answer</th>
        </tr>';
//fetch data from student answer and question table
$SQLanswer = "SELECT * FROM student_answer INNER JOIN question ON student_answer.QuestionID=question.QuestionID WHERE TrialID=$trialID;";
$run = mysqli_query($DBconn, $SQLanswer);

$num = 0;
while ($data = mysqli_fetch_assoc($run)) {
    $question = $data['Question'];
    $stdAns = $data['StudentAnswer'];
    $correctAns = $data['Answer'];
    $valid = $data['IsCorrect']; //need to find another variable name la bcs valid macam not it
    $num++;

    //add css class for when the answer is wrong
    $rowClass = $valid ? 'correct' : 'wrong';

    echo "<tr class='$rowClass'><td>$num</td>
              <td>$question</td>
              <td>$stdAns</td>
              <td>$correctAns</td>
          </tr>";
}
echo '        
    </table>
</div>';

?>