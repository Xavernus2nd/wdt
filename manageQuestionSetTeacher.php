<?php
session_start();
$_SESSION['TeacherUsername']="johndoe"; //for testing purposes
include 'connection.php'; //connection script
include 'deleteQuestionSet.php'; //includes the deletion script
include 'editSetName.php'; //includes the edit script
if(isset($_POST['selecttopic'])){ //checks for if topic is selected and sets the session
    $SelectedTopicCheck['SelectedTopic']=$_POST['SelectedTopic'];
    if($SelectedTopicCheck['SelectedTopic']=="Not Selected"){
        echo "<script>alert('Please select a topic');</script>";
    }
    else{
        $_SESSION['SelectedTopic']=$_POST['SelectedTopic'];
    }
}
if(isset($_SESSION['SelectedTopic'])){ //queries the database for the question sets for the selected topic
    $SelectedTopicId=$_SESSION['SelectedTopic'];
    $result = mysqli_query($DBconn, "SELECT Question_Set.SetID, Question_Set.SetName, COUNT(Question.QuestionID) AS NoOfQuestions, Question_Set.TeacherUsername, Question_Set.TopicID, Topic.TopicTitle FROM Question_Set INNER JOIN Topic ON Question_Set.TopicID = Topic.TopicID LEFT JOIN Question ON Question_Set.SetID = Question.SetID WHERE Topic.TopicTitle = '$_SESSION[SelectedTopic]' GROUP BY Question_Set.SetID");
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
    <title>Teacher Manage Question Set</title>
    <link href='layout.css' rel='stylesheet'>
</head>
<body>
    <h2>View/Manage Question Set</h2>
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
        echo "<button type='button' onclick=\"window.location.href='addQuestionSet.php?topic=$_SESSION[SelectedTopic]'\" class='button'>Add New Question Set</button>"; //add new question set page
        echo "<table class='table'>
                <tr>
                    <th>Question Set ID</th>
                    <th>Question Set Name</th>
                    <th>Number of Questions</th>
                    <th>Submitted By</th>
                    <th colspan='3'>Actions</th>
                </tr>"; //echos the table headers
        foreach($questionSets as $questionSet){
            echo"<tr>
                    <td>$questionSet[SetID]</td>
                    <td>$questionSet[SetName]</td>
                    <td>$questionSet[NoOfQuestions]</td>
                    <td>$questionSet[TeacherUsername]</td>
                    <td>
                        <button action='' method='post' onclick=\"window.location.href='viewQuestionSet.php?TopicID=$questionSet[TopicID]&QuestionSetID=$questionSet[SetID]'\" class='button'>View Question Set</button>
                    </td>
                    <td>
                        <form action='' method='post' onsubmit='return confirm(\"Are you sure you want to rename this question set?\");'>
                            <input type='hidden' name='EditSetID' value='$questionSet[SetID]'>
                            <input type='text' name='NewSetName' placeholder='New Set Name' required>
                            <button type='submit' name='edit' class='button'>Edit Set Name</button>
                        </form>
                    </td>
                    <td>
                        <form action='' method='post' onsubmit='return confirm(\"Are you sure you want to delete this question set?\");'>
                            <input type='hidden' name='DeleteSetID' value='$questionSet[SetID]'>   
                            <button type='submit' name='delete' class='button'>Delete Set</button>
                        </form>
                    </td>
                </tr>"; //echos the table data
    }
        echo "</table>";
}
    ?>
</body>
</html>
