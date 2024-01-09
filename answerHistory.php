<?php
$TrialID = $_POST['TrialID'];
$num = 0;

include("connection.php");

$num = 0;

$sql1 = "SELECT * FROM question_set INNER JOIN trial ON question_set.SetID = trial.SetID INNER JOIN topic ON topic.TopicID = question_set.TopicID INNER JOIN student ON student.StudentUsername = trial.StudentUsername WHERE trial.TrialID = $TrialID";

$result1 = mysqli_query($DBconn, $sql1);

if (!$result1) {
    die("Query failed: " . mysqli_error($DBconn));
}

while ($row = mysqli_fetch_assoc($result1)) {
    $TopicTitle = $row['TopicTitle'];
    $SetID = $row['SetID'];
    $QuestionSet = $row['SetName'];
    $Mode = $row['QuizType'];
    $TimeTaken = $row['TimeTaken'];
    $Date = $row['DateTime'];
    $Score = $row['Score'];
    //$Grade = $row['Grade'];

    echo '<h2>' . $TopicTitle . '</h2>';
    echo '<h2>' . $QuestionSet . '</h2>';
    echo '<h2>' . $Mode . '</h2>';
    echo '<h2>' . $TimeTaken . '</h2>';
    echo '<h2>' . $Date . '</h2>';
    echo '<h2>' . $Score . '</h2>';
    //echo '<h2>' . $Grade . '</h2>';
}

//fetch data - if student didn't answer the question, then the student answer will be null
$sql = "SELECT * FROM question LEFT JOIN student_answer ON question.QuestionID = student_answer.QuestionID AND student_answer.TrialID = $TrialID 
        WHERE question.SetID IN (SELECT SetID FROM trial WHERE TrialID = $TrialID);";
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
      <input type='hidden' name='SetID' value='<?php echo $SetID;?>'>
      <input type='hidden' name='Mode' value='<?php echo $Mode;?>'>
      <td><button class="button2">Retake</button></td>
    </form>  
    <td><button onclick="location.href='homeS.php';" class="button2">Home</button></td> <!-- link to student's homepage -->
  </table>
</div>