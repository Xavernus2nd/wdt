<?php
include 'connection.php';
if(isset($_POST['deleteTopic'])){
    $deletetopicID=$_POST['DeleteTopicID'];
    $deleteStudentAnswerQuery = mysqli_query($DBconn, "DELETE FROM Student_Answer WHERE QuestionID IN (SELECT QuestionID FROM Question WHERE SetID IN (SELECT SetID FROM Question_Set WHERE topicID='$deletetopicID'))");
    $deleteTopicQuestionQuery = mysqli_query($DBconn, "DELETE FROM Question WHERE SetID IN (SELECT SetID FROM Question_Set WHERE topicID='$deletetopicID')");
    $deleteTrial = mysqli_query($DBconn, "DELETE FROM Trial WHERE SetID IN (SELECT SetID FROM Question_Set WHERE topicID='$deletetopicID')");
    $deleteTopicQuestionSetQuery = mysqli_query($DBconn, "DELETE FROM Question_Set WHERE TopicID='$deletetopicID'");
    $deleteTopicQuery = mysqli_query($DBconn, "DELETE FROM topic WHERE TopicID='$deletetopicID'");
    if ($deleteTopicQuery && $deleteTopicQuestionSetQuery && $deleteTopicQuestionQuery) {
        echo "<script>alert('Topic and all related question set deleted successfully!');</script>";
        header("Refresh:0;");
    }
    else{
        echo "<script>alert('Error deleting topic.');</script>";
        header("Refresh:0;");
    }
}
?>