<?php
include 'conn.php';
if(isset($_POST['DeleteTopicID'])){
    $deletetopicID=$_POST['DeleteTopicID'];
    $deleteTopicQuestion = mysqli_query($conn, "DELETE FROM Question WHERE SetID IN (SELECT SetID FROM QuestionSet WHERE topicID='$deletetopicID')");
    $deleteTopicQuestionSetQuery = mysqli_query($conn, "DELETE FROM QuestionSet WHERE TopicID='$deletetopicID'");
    $deleteTopicQuery = mysqli_query($conn, "DELETE FROM topic WHERE TopicID='$deletetopicID'");
    if ($deleteTopicQuery && $deleteTopicQuestionSetQuery && $deleteTopicQuestion) {
        echo "<script>alert('Topic and all related question set deleted successfully!');</script>";
    }
    else{
        echo "<script>alert('Error deleting topic.');</script>";
    }
}
?>