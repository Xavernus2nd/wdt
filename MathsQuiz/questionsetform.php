<?php
//show topic title, show question set name, num of questions, mode in table
include 'connection.php';
$topic = $_GET['topicID'];
$_SESSION['topicID'] = $topic;
$SQLtopic = "SELECT TopicTitle FROM topic WHERE TopicID = '$topic';";
$runtopic = mysqli_query($DBconn, $SQLtopic);
$title = mysqli_fetch_array($runtopic);

echo $title['TopicTitle'].'<br>';

$SQLset = "SELECT * FROM question_set INNER JOIN topic ON question_set.TopicID = topic.TopicID where question_set.TopicID='$topic' AND SetApprovalStatus='ACCEPTED';";
$run=mysqli_query($DBconn, $SQLset);
$num = 0;
$numset = mysqli_num_rows($run);

//put if statement here if no question set from the topic then say no question set available ok if no probrem

if ($numset > 0) {
    //if there are question sets in the topic
    echo "
    <div id='table-container'>
    <table class='tableset' border='1';>
    <tr><th id='num'>No.</th>
        <th id='setname'>Question Set</th>
        <th id='quesnum'>No. of Questions</th>
        <th colspan='2' id='mode'>Select Mode</th>
    </tr>";
    while ($data = mysqli_fetch_array($run)) {
        $set = $data['SetID'];
        //count number of questions
        $SQLcount = "SELECT Question FROM question where SetID = '$set';";
        $runcount = mysqli_query($DBconn, $SQLcount);
        $numques = mysqli_num_rows($runcount);
        $num++;
        $setname = $data['SetName'];
        //when no num ques, then dont show the table - by right, shudnt happen bcs question sets r approved and must have the questions la
        echo "<tr><td>$num</td>
                  <td>$setname</td>
                  <td>$numques</td>
                  <td>
                    <form action='question.php' method='post'>
                        <input type='hidden' name='setID' value='$set'>
                        <input type='hidden' name='mode' value='Practice'>
                        <button>Practice</button>
                    </form>
                  </td>
                  <td>
                    <form action='question.php' method='post'>
                        <input type='hidden' name='setID' value='$set'>
                        <input type='hidden' name='mode' value='Timed'>
                        <button>Timed</button>
                    </form>
                  </td>
            </tr>";
    }
    echo "<br><br></table></div>";
} else {
    //if there is no question set in the topic, do i want alert or just echo
    echo "<script>
        alert('No question sets');
        window.location.href = 'index.php';
    </script>";
}

?>