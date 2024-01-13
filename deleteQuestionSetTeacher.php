<?php //executed when confirmation passes
if (isset($_POST['DeleteSetID'])) { 
    include 'connection.php';
    $deleteSetID=$_POST['DeleteSetID'];
    $TeacherUsername=$_SESSION['TeacherUsername'];
    $checkTeacher = mysqli_fetch_assoc(mysqli_query($DBconn, "SELECT TeacherUsername FROM Question_Set WHERE SetID = '$deleteSetID'"));
    $targetSetTeacherName = $checkTeacher['TeacherUsername'];
    if ($TeacherUsername!=$targetSetTeacherName){
        echo "<script>alert('You are not allowed to delete this question set.');</script>";
        header("Refresh:0;");
    }
    else{
    $deleteStudentAnswerQuery = mysqli_query($DBconn, "DELETE FROM Student_Answer WHERE TrialID IN (SELECT TrialID FROM Trial WHERE SetID='$deleteSetID')");
    $deleteTrialQuery = mysqli_query($DBconn, "DELETE FROM Trial WHERE SetID='$deleteSetID'");
    $deletequestionQuery = mysqli_query($DBconn, "DELETE FROM Question WHERE SetID='$deleteSetID'");
    $deleteQuestionSetQuery = mysqli_query($DBconn, "DELETE FROM Question_Set WHERE SetID='$deleteSetID'");
    if ($deletequestionQuery && $deleteQuestionSetQuery) {
        echo "<script>alert('Question set deleted successfully!');</script>";
        header("Refresh:0;");
    }
    else{
        echo "<script>alert('Error deleting question set.');</script>";
        header("Refresh:0;");
    }
}

}
?>