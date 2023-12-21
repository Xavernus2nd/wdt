<?php
include "connection.php";
session_start(); //remember to include session code here

// Retrieve unapproved question set data from the database
$SetToBeApproved = mysqli_fetch_all(mysqli_query($DBconn, "SELECT * FROM Question_Set WHERE SetApprovalStatus = 'PENDING'"), MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Approve Question Set</title>
    <link rel="stylesheet" href="layout.css">
</head>
<body>
    <h2>Approve Question Set</h2>
    <?php
    // Dropdown to select question set to be approved
    echo "<label>Question Set:</label>
    <form action='' method='GET'>
    <select name='QuestionSetID' class='select' onchange='this.form.submit()'>
    <option value=''>Select Question Set</option>";
    foreach($SetToBeApproved as $row){
        echo "<option value='$row[SetID]'>$row[SetName]</option>";
    }
    echo "</select></form><br>";
    // Display question set details
    if(isset($_GET["QuestionSetID"])){
        $QuestionSetID = $_GET["QuestionSetID"];
        $QuestionsFromSet = mysqli_fetch_all(mysqli_query($DBconn, "SELECT * FROM Question WHERE SetID = '$QuestionSetID'"), MYSQLI_ASSOC);
        $QuestionSet = mysqli_fetch_assoc(mysqli_query($DBconn, "SELECT * FROM Question_Set WHERE SetID = '$QuestionSetID'"));
        $QuestionSetTopic = mysqli_fetch_assoc(mysqli_query($DBconn, "SELECT TopicTitle FROM Topic WHERE TopicID = '$QuestionSet[TopicID]'"));
        $QuestionNumber = mysqli_fetch_assoc(mysqli_query($DBconn, "SELECT QuestionNumber FROM Question WHERE SetID = '$QuestionSetID'"));
        $currentQuestionIndex = isset($_GET['QuestionNumber']) ? $_GET['QuestionNumber'] : 0; //checks if current question number is set, if not set to 0   
        if(!empty($QuestionsFromSet)){
            echo "<div class='aqbox'><center><h2>Question Set: $QuestionSet[SetName]</h2></center>";
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
            echo "<div class='aqset'><h3>Question $currentQuestion[QuestionNumber]</h3>
            <p>$currentQuestion[Question]</p>
            <h4>Answer:</h4><div class='aqset'>";
            for ($i = 0; $i <= 3; $i++) {
                $optionArray = array("OptionA", "OptionB", "OptionC", "OptionD");
                $answer = "$optionArray[$i]";
                $isChecked = $currentQuestion[$answer] == $currentQuestion['Answer'] ? "checked" : ""; //checks if answer is correct
                echo "<label>
                <input type='radio' name='answer' value='$currentQuestion[$answer]' $isChecked disabled>
                $currentQuestion[$answer]
              </label><br>";
            }//echos the question number and question
            echo "</div></div>";
            //specific question selection box
            echo "<div class='aqnav'><form action='' method='GET'>
            <input type='hidden' name='QuestionSetID' value='$QuestionSetID'>
            <label>Go to Question:</label>
            <select name='QuestionNumber' class='select' onchange='this.form.submit()'>
            <option value=''>Select Question</option>
            ";
            foreach($QuestionsFromSet as $row){
                echo "<option value='$row[QuestionNumber]'>$row[QuestionNumber]</option>";
            }
            echo "</select></form>";
            //displays the previous and next question buttons
            echo "<form action='' method='GET'> 
            <input type='hidden' name='QuestionSetID' value='$QuestionSetID'>
            <input type='hidden' name='QuestionNumber' value='$currentQuestionIndex'>
            <input type='submit' name='action' class='button' value='Previous Question'>
            <input type='submit' name='action' class='button' value='Next Question'>
            </form></div><br>";
            echo "<center><table class='approveinfotable'>
            <td>Topic Name: $QuestionSetTopic[TopicTitle]</td>
            <td>Submitted By: $QuestionSet[TeacherUsername]</td>
            <table><br>";
            echo "<form action='' method='POST' onsubmit='return confirm(\"Are you sure?\")'>
            <input type='hidden' name='QuestionSetID' value='$QuestionSetID'>
            <input type='submit' name='Approve' class='approve' value='Approve Question Set'>
            <input type='submit' name='Reject' class='reject' value='Reject Question Set'>
            </form></center></div>";
            if (isset($_POST['Approve'])){
                mysqli_query($DBconn, "UPDATE Question_Set SET SetApprovalStatus = 'APPROVED' WHERE SetID = '$QuestionSetID'");
                echo "<script>alert('Question Set Approved!'); window.location.href='ApproveQuestionSet.php'</script>";
                exit();
            }
            else if (isset($_POST['Reject'])){
                mysqli_query($DBconn, "UPDATE Question_Set SET SetApprovalStatus = 'REJECTED' WHERE SetID = '$QuestionSetID'");
                echo "<script>alert('Question Set Rejected!'); window.location.href='ApproveQuestionSet.php'</script>";
                exit();
            }
    }
    }
    ?>
    
</body>
</html>