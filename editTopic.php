<?php
include 'connection.php';
if(isset($_POST['EditTopicTitle'])){
    $EditTopicName=$_POST['EditTopicTitle'];
    $EditTopicID=$_POST['EditTopicID'];
    $editsql = "UPDATE Topic SET TopicTitle = '$EditTopicName' WHERE TopicID = '$EditTopicID'";
    if (mysqli_query($DBconn, $editsql)) {
        echo "<script>alert('Topic editted successfully!');</script>";
    } 
    else {
        echo "<script>alert('Error updating topic name.');</script>";
    }
}
?>