<?php
include 'connection.php';
if(isset($_POST['NewSetName'])){
    $NewSetName=$_POST['NewSetName'];
    $targetSetID=$_POST['EditSetID'];
    $TeacherUsername=$_SESSION['TeacherUsername'];
    $checkTeacher = mysqli_fetch_assoc(mysqli_query($DBconn, "SELECT TeacherUsername FROM Question_Set WHERE SetID = '$targetSetID'"));
    $targetSetTeacherName = $checkTeacher['TeacherUsername'];
    if ($TeacherUsername!=$targetSetTeacherName){
        echo "<script>alert('You are not allowed to edit this question set.');</script>";
    }
    else{
        if (mysqli_query($DBconn, "UPDATE QuestionSet SET SetName = '$NewSetName' WHERE SetID = '$targetSetID' AND TeacherUsername = '$TeacherUsername'")) {
            echo "<script>alert('Question set editted successfully!');</script>";
        } 
        else {
            echo "<script>alert('Error updating question set name.');</script>";
        }
    }
}
?>