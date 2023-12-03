<?php
session_start();
$_SESSION['TeacherUsername']="johndoe"; //for testing purposes
include 'conn.php'; //connection script
include 'QuestionSetDeletion.php'; //includes the deletion script
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
    $result = mysqli_query($conn, "SELECT QuestionSet.SetID, QuestionSet.SetName, COUNT(Question.QuestionID) AS NoOfQuestions, QuestionSet.TeacherUsername, QuestionSet.TopicID, Topic.TopicTitle FROM QuestionSet INNER JOIN Topic ON QuestionSet.TopicID = Topic.TopicID LEFT JOIN Question ON QuestionSet.SetID = Question.SetID WHERE Topic.TopicTitle = '$_SESSION[SelectedTopic]' GROUP BY QuestionSet.SetID");
    $questionSets = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
$TopicQuery = mysqli_query($conn, "SELECT TopicTitle FROM Topic");
$Topiclists = mysqli_fetch_all($TopicQuery, MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Manage Question Set</title>
    <style>
        table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        }
    </style>
</head>
<body>
    <h1>View/Manage Question Set</h1>
    <form action="" method="post">
        <select name="SelectedTopic">
            <option value="Not Selected">Please select a topic</option>
        <?php 
        foreach ($Topiclists as $topic) {
            echo "<option value='$topic[TopicTitle]'>$topic[TopicTitle]</option>";
        }
        ?>
        </select>
        <button type="submit" name="selecttopic">Select Topic</button>
    </form> 
    <?php
    // Check if a specific topic is selected
    if (isset($_POST['SelectedTopic'])) {
        // Display question sets for the selected topic
        echo "<h2>Question Sets for $_SESSION[SelectedTopic]</h2>";
        echo "<button type='button' onclick=\"window.location.href='AddQuestionSet.php'\">Add New Question Set</button>"; //add new question set page
        echo "<table>
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
                        <form action='' method='post' onsubmit='return confirm('Are you sure you want to rename this question set?');'>
                            <input type='hidden' name='EditSetID' value='$questionSet[SetID]'>
                            <input type='text' name='NewSetName' placeholder='New Set Name' required>
                            <button type='submit' name='edit'>Edit Set Name</button>
                        </form>
                    </td>
                    <td>
                        <form action='' method='post' onsubmit='return confirm('Are you sure you want to delete this question set?');'>
                            <input type='hidden' name='DeleteSetID' value='$questionSet[SetID]'>   
                            <button type='submit' name='delete'>Delete Set</button>
                        </form>
                    </td>
                </tr>"; //echos the table data
    }
        echo "</table>";
}
    ?>
</body>
</html>
