<?php
include 'sessionAdmin.php'; //session script
include 'connection.php'; //connection script
include 'deleteQuestionSetAdmin.php'; //includes the deletion script
if(isset($_POST['selecttopic'])){ //checks for if topic is selected and sets the session
    $SelectedTopicCheck['SelectedTopic']=$_POST['SelectedTopic'];
    if($SelectedTopicCheck['SelectedTopic']=="Not Selected"){
        echo "<script>alert('Please select a topic');</script>";
        header("Refresh:0");
    }
    else{
        $_SESSION['SelectedTopic']=$_POST['SelectedTopic'];
    }
}
if(isset($_SESSION['SelectedTopic'])){ //queries the database for the question sets for the selected topic
    $SelectedTopicId=$_SESSION['SelectedTopic'];
    $result = mysqli_query($DBconn, "SELECT Question_Set.SetID, Question_Set.SetName, COUNT(Question.QuestionID) AS NoOfQuestions, Question_Set.TeacherUsername, Question_Set.TopicID, Topic.TopicTitle FROM Question_Set INNER JOIN Topic ON Question_Set.TopicID = Topic.TopicID LEFT JOIN Question ON Question_Set.SetID = Question.SetID WHERE Topic.TopicTitle = '$_SESSION[SelectedTopic]' AND Question_Set.SetApprovalStatus = 'ACCEPTED' GROUP BY Question_Set.SetID");
    $questionSets = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
$TopicQuery = mysqli_query($DBconn, "SELECT TopicTitle FROM Topic");
$Topiclists = mysqli_fetch_all($TopicQuery, MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Manage Question Set</title>
    <link href='layout.css' rel='stylesheet'>
</head>
<body>
    <header>
        <div id = "logo"></div>
        <h1>Form 4 SPM Mathematics Quiz</h1>
        <div class="loginTop">
            <a href="logout.php" id="logout">Logout</a>
        </div>
    </header>
    <nav><?php include "nAdmin.php" ?></nav>
    <section class="body-container">
    <h2>Manage Question Set</h2>
    <form action="" method="post">
        <select name="SelectedTopic" class='select'>
            <option value="Not Selected">Please select a topic</option>
        <?php 
        foreach ($Topiclists as $topic) {
            echo "<option value='$topic[TopicTitle]'>$topic[TopicTitle]</option>";
        }
        ?>
        </select>
        <button type="submit" name="selecttopic" class="button">Select Topic</button>
    </form> 
    <?php
    // Check if a specific topic is selected
    if (isset($_POST['SelectedTopic'])) {
        // Display question sets for the selected topic 
        echo "<h2 style='text-align:center'>Question Sets for $_SESSION[SelectedTopic]</h2>";
        echo "<table class='table'>   
                <tr>
                    <th>Question Set ID</th>
                    <th>Question Set Name</th>
                    <th>Number of Questions</th>
                    <th>Submitted By</th>
                    <th colspan='2'>Actions</th>
                </tr>"; //echos the table headers
        foreach($questionSets as $questionSet){
            echo"<tr>
                    <td>$questionSet[SetID]</td>
                    <td>$questionSet[SetName]</td>
                    <td>$questionSet[NoOfQuestions]</td>
                    <td>$questionSet[TeacherUsername]</td>
                    <td>
                        <button action='' method='post' onclick=\"window.location.href='viewQuestionSetAdmin.php?QuestionSetID=$questionSet[SetID]'\" class='button'>View Question Set</button>
                    </td>
                    <td>
                        <form action='' method='post' onsubmit='return confirm(\"Are you sure you want to delete this question set?\");'>
                            <input type='hidden' name='DeleteSetID' value='$questionSet[SetID]'>   
                            <button type='submit' name='delete' class='button'>Delete</button>
                        </form>
                    </td>
                </tr>"; //echos the table data
    }
        echo "</table>";
}
    ?>
    </section>
    <footer><?php include "footer.php" ?></footer>
</body>
</html>
