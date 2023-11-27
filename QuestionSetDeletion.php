<?php //executed when confirmation passes
if (isset($_POST['DeleteSetID'])) { 
    include 'conn.php';
    $deleteSetID=$_POST['DeleteSetID'];
    $deletequestionQuery = mysqli_query($conn, "DELETE FROM Question WHERE SetID='$deleteSetID'");
    $deleteQuestionSetQuery = mysqli_query($conn, "DELETE FROM QuestionSet WHERE SetID='$deleteSetID'");
    if ($deletequestionQuery && $deleteQuestionSetQuery) {
        echo "<script>alert('Question set deleted successfully!');</script>";
    }
    else{
        echo "<script>alert('Error deleting question set.');</script>";
    }

}
?>