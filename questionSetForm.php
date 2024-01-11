<?php
$TopicID = $_GET['TopicID'];

//empties out previous session for quiz
if (!empty($_SESSION['quiz'])) {
    unset($_SESSION['quiz']);
    header("Location: questionSet.php?TopicID=".$TopicID);
}

//to get topic title
$SQLtopic = "SELECT TopicTitle FROM topic WHERE TopicID = '$TopicID';";
$runtopic = mysqli_query($DBconn, $SQLtopic);
$title = mysqli_fetch_array($runtopic)['TopicTitle'];
echo '<p style="font-size: 32px; font-weight: bold; margin: 0px;">'.$title.'</p>';

//SQL to get question set information
$SQLset = "SELECT * FROM question_set INNER JOIN topic ON question_set.TopicID = topic.TopicID where question_set.TopicID='$TopicID' AND SetApprovalStatus='ACCEPTED';";
$run=mysqli_query($DBconn, $SQLset);
$num = 0;
$numset = mysqli_num_rows($run);

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
        $SetID = $data['SetID'];
        //count number of questions
        $SQLcount = "SELECT Question FROM question where SetID = '$SetID';";
        $runcount = mysqli_query($DBconn, $SQLcount);
        $numques = mysqli_num_rows($runcount);
        $num++;
        $SetName = $data['SetName'];
        echo "<tr><td>$num</td>
                  <td>$SetName</td>
                  <td>$numques</td>
                  <td>
                    <form action='quizQuestion.php' method='post'>
                        <input type='hidden' name='SetID' value='$SetID'>
                        <input type='hidden' name='Mode' value='Practice'>
                        <button class='mode-button'>Practice</button>
                    </form>
                  </td>
                  <td>
                    <form action='quizQuestion.php' method='post'>
                        <input type='hidden' name='SetID' value='$SetID'>
                        <input type='hidden' name='Mode' value='Timed'>
                        <button class='mode-button'>Timed</button>
                    </form>
                  </td>
            </tr>";
    } echo "<br><br></table></div>";
}    else {
    echo "<script>
        alert('Sorry, no question set available for this topic.');
        window.location.href = 'homeS.php'; //redirect to student homepage
    </script>";
} ?>