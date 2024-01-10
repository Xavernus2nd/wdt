<?php
$trialID = $_POST['TrialID'];
//$setID = $_POST['setID'];
//$mode = $_POST['mode'];
$num = 0;

include("connection.php");

$num = 0;

$sql1 = "SELECT topic.TopicTitle, question_set.SetID, question_set.SetName, trial.Comment, trial.QuizType, trial.TimeTaken, trial.Score, Date (DateTime) as Date, Time (DateTime) as Time FROM question_set LEFT JOIN trial ON question_set.SetID = trial.SetID LEFT JOIN topic ON topic.TopicID = question_set.TopicID LEFT JOIN student ON student.StudentUsername = trial.StudentUsername WHERE trial.TrialID = $trialID";

$result1 = mysqli_query($DBconn, $sql1);

if (!$result1) {
    die("Query failed: " . mysqli_error($DBconn));
}

while ($row = mysqli_fetch_assoc($result1)) {
    $TopicTitle = $row['TopicTitle'];
    $setID = $row['SetID'];
    $QuestionSet = $row['SetName'];
    $mode = $row['QuizType'];
    $TimeTaken = $row['TimeTaken'];
    $Date = $row['Date'];
    $Time = $row['Time'];
    $Score = $row['Score'];
    $Comment = $row['Comment'];

    //$Grade = $row['Grade'];

    if ($Score >= 90) {
      $Grade = 'A+';
    } else if ($Score >= 80) {
      $Grade = 'A';
    } else if ($Score >= 70) {
      $Grade = 'A-';
    } else if ($Score >= 65) {
      $Grade = 'B+';
    } else if ($Score >= 60) {
      $Grade = 'B';
    } else if ($Score >= 55) {
      $Grade = 'C+';
    } else if ($Score >= 50) {
      $Grade = 'C';
    } else if ($Score >= 45) {
      $Grade = 'D';
    } else if ($Score >= 40) {
      $Grade = 'E';
    } else {
      $Grade = 'F';
    }

    if ($mode == 'practice') {
      if ($TimeTaken == '00:00:00') {
        $mode = 'Practice';
      } else {
        $mode = 'Quiz';
      } 
      $mode = 'Practice';
    } 


    echo '<table>';
    echo '<tr>';
    echo '<th><label>Topic Title: </label></th>';
    echo '<td>' . $TopicTitle . '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<th><label>Question Set: </label></th>';
    echo '<td>' . $QuestionSet . '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<th><label>Mode: </label></th>';
    echo '<td>' . $mode . '</td>';

    if ($mode != 'Practice') {
    echo '<th><label>Time Taken: </label></th>';
    echo '<td>' . $TimeTaken . '</td>';
    echo '</tr>';
    }
    else {


    echo '<th></th>';
    echo '<td></td>';
    echo '</tr>';
  }
    echo '<tr>';
    echo '<th><label>Date: </label></th>';
    echo '<td>' . $Date . '</td>';

    echo '<th><label>Time: </label></th>';
    echo '<td>' . $Time . '</td>';
    echo '</tr>';


    echo '<tr>';
    echo '<th><label>Score: </label></th>';
    echo '<td>' . $Score . '</td>';

    echo '<th><label>Grade: </label></th>';
    echo '<td>' . $Grade . '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<th><label>Comment: </label></th>';
    echo '<td>' . $Comment . '</td>';
    echo '</tr>';
}

echo '</table>';
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
