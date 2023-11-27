<?php
//show topic title, show question set name, num of questions, mode in table
include 'connection.php';
$topic = $_GET['topicID'];
$_SESSION['topicID'] = $topic;
$SQLtopic = "SELECT TopicTitle FROM topic WHERE TopicID = '$topic';";
$runtopic = mysqli_query($DBconn, $SQLtopic);
$title = mysqli_fetch_array($runtopic);

//count number of questions
$SQLcount = "SELECT COUNT(QuestionID) AS NoOfQues FROM question INNER JOIN question_set ON question.SetID = question_set.SetID INNER JOIN topic ON question_set.TopicID = topic.TopicID where question_set.TopicID = '$topic';";
$runcount = mysqli_query($DBconn, $SQLcount);
$numques = mysqli_num_rows($runcount);

echo $title['TopicTitle'];
echo "
<div id='table-container'>
<table class='tableset' border='1';>
<tr><th id='num'>No.</th>
    <th id='setname'>Question Set</th>
    <th id='quesnum'>No. of Questions</th>
    <th colspan='2' id='mode'>Select Mode</th>
</tr>";
$SQLset = "SELECT * FROM question_set INNER JOIN topic ON question_set.TopicID = topic.TopicID where question_set.TopicID='$topic';";
$run=mysqli_query($DBconn, $SQLset);
$num = 0;
while ($data = mysqli_fetch_array($run)) {
    $num++;
    $setname = $data['SetName'];
    $set = $data['SetID'];
    //$numques = $data['NoOfQuestions'];
    echo "<tr><td>$num</td>
              <td>$setname</td>
              <td>$numques</td>
              <td><a href='question.php?setID=".$set."&&mode=Practice'><button>Practice</button></a></td>
              <td><a href='question.php?setID=".$set."&&mode=Timed'><button>Timed</button></a></td>
        </tr>";
}
echo "<br><br></table></div>";
?>
