<?php
$trialID = $_POST['trialID'];
$setID = $_POST['setID'];
$mode = $_POST['mode'];
$num = 0;

//fetch data - if student didn't answer the question, then the student answer will be null
$sql = "SELECT * FROM question LEFT JOIN student_answer ON question.QuestionID = student_answer.QuestionID AND student_answer.TrialID = $trialID 
        WHERE question.SetID IN (SELECT SetID FROM trial WHERE TrialID = $trialID);";
$run = mysqli_query($DBconn, $sql);

//present the answer in table form
echo '
<div class="answerhistory-container">
<div class="answerhistory-scroll">
    <table class="answerhistory-table" border="1">
        <tr>
            <th id="num">No.</th>
            <th id="ques">Question</th>
            <th id="stdAns">Student Answer</th>
            <th id="correctAns">Correct Answer</th>
        </tr>';

        while ($data = mysqli_fetch_assoc($run)) {
          $question = $data['Question'];
          $stdAns = $data['StudentAnswer'];
          $correctAns = $data['Answer'];
          $valid = $data['IsCorrect']; 
          $num++;
          //add css class for the table row according to the value of $valid or $stdAns
          $rowClass = ($stdAns === NULL) ? 'no-answer' : ($valid ? 'correct' : 'wrong');

          echo "<tr class='$rowClass'>
                  <td>$num</td>
                  <td>$question</td>
                  <td>";
                  if ($stdAns === NULL) {
                    echo "-";
                  } else {
                    echo "$stdAns";
                  }
                  echo "</td>
                  <td>$correctAns</td>
                </tr>";
        }
    echo '</table>
    </div>
</div>';
?>
<!--retake and home button-->
<div class="resultbutton-container">
  <table class="resultbutton-table">
    <form action='quizQuestion.php' method='post'>
      <input type='hidden' name='setID' value='<?php echo $setID;?>'>
      <input type='hidden' name='mode' value='<?php echo $mode;?>'>
      <td><button class="button2">Retake</button></td>
    </form>  
    <td><button onclick="location.href='homeS.php';" class="button2">Home</button></td> <!-- link to student's homepage -->
  </table>
</div>