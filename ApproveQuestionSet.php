<?php
include "conn.php";
session_start(); //remember to include session code here

// Retrieve unapproved question set data from the database
$SetToBeApproved = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM Question_Set WHERE SetApprovalStatus = 'PENDING'"), MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Approve Question Set</title>
    <style>
        table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        }
    </style>
</head>
<body>
    <h1>Approve Question Set</h1>
    <?php
    // Dropdown to select question set to be approved
    echo "<label>Question Set:</label>
    <form action='' method='GET'>
    <select name='QuestionSetID' onchange='this.form.submit()'>
    <option value=''>Select Question Set</option>";
    foreach($SetToBeApproved as $row){
        echo "<option value='$row[SetID]'>$row[SetName]</option>";
    }
    echo "</select></form>";
    // Display question set details
    if(isset($_GET["QuestionSetID"])){
        $QuestionSetID = $_GET["QuestionSetID"];
        $QuestionsFromSet = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM Question WHERE SetID = '$QuestionSetID'"), MYSQLI_ASSOC);
        $QuestionSet = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM Question_Set WHERE SetID = '$QuestionSetID'"));
        $currentQuestionIndex = isset($_GET['QuestionNumber']) ? $_GET['QuestionNumber'] : 0; //checks if current question number is set, if not set to 0   
        if(!empty($QuestionsFromSet)){
            echo "<h2>Question Set: $QuestionSet[SetName]</h2>";
            //checks for if action is set and does respective index update
            if(isset($_GET['action'])){
                if($_GET['action'] == 'Previous Question'){
                    if($currentQuestionIndex > 0){
                        $currentQuestionIndex--;
                    }
                }
                else if($_GET['action'] == 'Next Question'){
                    if($currentQuestionIndex < count($QuestionsFromSet)-1){
                        $currentQuestionIndex++;
                    }
                }
            }
            $currentQuestion = $QuestionsFromSet[$currentQuestionIndex];
            echo "<div><h3>Question $currentQuestion[QuestionNumber]</h3>
            <p>$currentQuestion[Question]</p>
            <div><h4>Answer:</h4>";
            for ($i = 0; $i <= 3; $i++) {
                $optionArray = array("OptionA", "OptionB", "OptionC", "OptionD");
                $answer = "$optionArray[$i]";
                $isChecked = $currentQuestion[$answer] == $currentQuestion['Answer'] ? "checked" : ""; //checks if answer is correct
                echo "<label>
                <input type='radio' name='answer' value='$currentQuestion[$answer]' $isChecked disabled>
                $currentQuestion[$answer]
              </label><br>";
            }
            echo "</div>
            </div>"; //echos the question number and question
            echo "<form action='' method='GET'>
            <input type='hidden' name='QuestionSetID' value='$QuestionSetID'>
            <input type='hidden' name='QuestionNumber' value='$currentQuestionIndex'>
            <input type='submit' name='action' value='Previous Question'>
            <input type='submit' name='action' value='Next Question'>
            </form><br>";
            echo "<table>
            <td>Topic Name: $QuestionSet[TopicID]</td>
            <td>Submitted By: $QuestionSet[TeacherUsername]</td>
            <table>";
            echo "<form action='' method='POST'>
            <input type='hidden' name='QuestionSetID' value='$QuestionSetID'>
            <input type='submit' name='Approve' value='Approve Question Set'>
            <input type='submit' name='Reject' value='Reject Question Set'>
            </form>";
            if (isset($_POST['Approve'])){
                mysqli_query($conn, "UPDATE Question_Set SET SetApprovalStatus = 'APPROVED' WHERE SetID = '$QuestionSetID'");
                echo "<script>alert('Question Set Approved!')</script>; window.location.href='ApproveQuestionSet.php'";
                exit();
            }
            else if (isset($_POST['Reject'])){
                mysqli_query($conn, "UPDATE Question_Set SET SetApprovalStatus = 'REJECTED' WHERE SetID = '$QuestionSetID'");
                echo "<script>alert('Question Set Rejected!')</script>; window.location.href='ApproveQuestionSet.php'";
                exit();
            }
    }
    }
    ?>
    
</body>
</html>