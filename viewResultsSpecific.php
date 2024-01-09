<?php
include("connection.php");

if (isset($_POST['TrialID'])) {
  $trialID = $_POST['TrialID'];
}

$setID = $_POST['SetID'];
$mode = $_POST['QuizType'];
$username = $_POST['StudentUsername'];

$num = 0;

$sql1 = "SELECT * FROM question_set INNER JOIN trial ON question_set.SetID = trial.SetID INNER JOIN topic ON topic.TopicID = question_set.TopicID INNER JOIN student ON student.StudentUsername = trial.StudentUsername WHERE $username = $trialID";

$result1 = mysqli_query($DBconn, $sql1);

if (!$result1) {
    die("Query failed: " . mysqli_error($DBconn));
}

while ($row = mysqli_fetch_assoc($result1)) {
    $TopicTitle = $row['TopicTitle'];
    $QuestionSet = $row['SetName'];
    $Mode = $row['QuizType'];
    $TimeTaken = $row['TimeTaken'];
    $Date = $row['DateTime'];
    $Score = $row['Score'];
    $Grade = $row['Grade'];

    echo '<h2>' . $TopicTitle . '</h2>';
    echo '<h2>' . $QuestionSet . '</h2>';
    echo '<h2>' . $Mode . '</h2>';
    echo '<h2>' . $TimeTaken . '</h2>';
    echo '<h2>' . $Date . '</h2>';
    echo '<h2>' . $Score . '</h2>';
    echo '<h2>' . $Grade . '</h2>';
}

mysqli_close($DBconn);
?>



<?php
include ("connection.php");
if (isset($_POST['TrialID'])) {
  $trialID = $_POST['TrialID'];
}
$setID = $_POST['SetID'];
$mode = $_POST['QuizType'];
$num = 0;

//fetch data - if student didn't answer the question, then the student answer will be null
$sql = "SELECT * FROM question LEFT JOIN student_answer ON question.QuestionID = student_answer.QuestionID AND student_answer.TrialID = $trialID 
        WHERE question.SetID IN (SELECT SetID FROM trial WHERE TrialID = $trialID);";
$run = mysqli_query($DBconn, $sql);

//present the answer in table form
echo '
<div class="result-container">
    <table class="tableset" border="1">
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

    //add css class for the table row
    $rowClass = ($stdAns === NULL) ? 'no-answer' : ($valid ? 'correct' : 'wrong');

    echo "<tr class='$rowClass'><td>$num</td>
              <td>$question</td>
              <td>";
              if ($stdAns === NULL) {
                echo "-";
              } else {
                echo "$stdAns";
              }
    echo "    </td>
              <td>$correctAns</td>
          </tr>";
}
echo '</table>
</div>';
?>
<div class="resultbutton-container">
  <table class="resultbutton-table">
    <form action='question.php' method='post'><tr>
      <input type='hidden' name='SetID' value='<?php echo $setID;?>'>
      <input type='hidden' name='QuizType' value='<?php echo $mode;?>'>
      <td><button class="button2">Retake</button></td>
    </form>
    <td><button class="button2">Home</button></td> <!-- link to student's homepage -->
  </tr></table>
</div>

</body>
</html>
