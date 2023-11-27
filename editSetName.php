<?php
include 'conn.php';
if(isset($_POST['NewSetName'])){
    $NewSetName=$_POST['NewSetName'];
    $targetSetID=$_POST['EditSetID'];
    $TeacherUsername=$_SESSION['TeacherUsername'];
    $editsql = "UPDATE QuestionSet SET SetName = '$NewSetName' WHERE SetID = '$targetSetID' AND TeacherUsername = '$TeacherUsername'";
    $checkTeachersql = "SELECT TeacherUsername FROM QuestionSet WHERE SetID = '$targetSetID'";
    $checkTeacherQuery = mysqli_query($conn, $checkTeachersql);
    $checkTeacher = mysqli_fetch_assoc($checkTeacherQuery);
    $targetSetTeacherName = $checkTeacher['TeacherUsername'];
    if ($TeacherUsername!=$targetSetTeacherName){
        echo "<script>alert('You are not allowed to edit this question set.');</script>";
    }
    else{
        if (mysqli_query($conn, $editsql)) {
            echo "<script>alert('Question set editted successfully!');</script>";
        } 
        else {
            echo "<script>alert('Error updating question set name.');</script>";
        }
    }
}
?>