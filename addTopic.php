<?php
include 'connection.php';
if(isset($_POST['addTopic'])){
    $NewTopicTitle=$_POST['NewTopicTitle'];
    $insertsql = "INSERT INTO Topic VALUES ('DEFAULT', '$NewTopicTitle')";
    if (mysqli_query($DBconn, $insertsql)) {
        echo "<script>alert('Topic added successfully!');</script>";
        header("Refresh:0;");
    } 
    else {
        echo "<script>alert('Error adding topic.');</script>";
        header("Refresh:0;");
    }
}
?>