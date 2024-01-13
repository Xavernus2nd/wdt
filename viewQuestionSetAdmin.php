<?php
include "connection.php";
include "sessionAdmin.php";
// Retrieve unapproved question set data from the database
$TopicTitles = mysqli_fetch_all(mysqli_query($DBconn, "SELECT * FROM Topic"), MYSQLI_ASSOC);
if(isset($_GET['TopicID'])){
    $TopicTitleSelected =  mysqli_fetch_assoc(mysqli_query($DBconn, "SELECT * FROM Topic WHERE TopicID = '$_GET[TopicID]'") );
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Question Set</title>
    <link rel="stylesheet" href="layout.css">
</head>
<body>
    <header>
        <div id = "logo"></div>
        <h1>Form 4 SPM Mathematics Quiz</h1>
        <div class="loginTop">
            <a href="logout.php" id="logout">Logout</a>
        </div>
    </header>
    <nav><?php include "nAdmin.php" ?></nav>
    <section class="body-container">
    <h2>View Question Set</h2>
    <?php
    // Display question set details
    if(isset($_GET["QuestionSetID"])){
        $QuestionSetID = $_GET["QuestionSetID"];
        $QuestionsFromSet = mysqli_fetch_all(mysqli_query($DBconn, "SELECT * FROM Question WHERE SetID = '$QuestionSetID'"), MYSQLI_ASSOC);
        $QuestionSet = mysqli_fetch_assoc(mysqli_query($DBconn, "SELECT * FROM Question_Set WHERE SetID = '$QuestionSetID'"));
        $QuestionSetTopic = mysqli_fetch_assoc(mysqli_query($DBconn, "SELECT TopicTitle FROM Topic WHERE TopicID = '$QuestionSet[TopicID]'"));
        $QuestionNumber = mysqli_fetch_assoc(mysqli_query($DBconn, "SELECT QuestionNumber FROM Question WHERE SetID = '$QuestionSetID'"));
        $currentQuestionIndex = isset($_GET['QuestionNumber']) ? $_GET['QuestionNumber'] : 1; //checks if current question number is set, if not set to 0   
        if(!empty($QuestionsFromSet)){
            echo "<div class='aqbox'><center><h2>Question Set: $QuestionSet[SetName]</h2></center>";
            //checks for if action is set and does respective index update
            if(isset($_GET['action'])){
                if($_GET['action'] == 'Previous Question'){
                    if($currentQuestionIndex > 1){
                        $currentQuestionIndex--;
                    }
                }
                else if($_GET['action'] == 'Next Question'){
                    if($currentQuestionIndex < count($QuestionsFromSet)){
                        $currentQuestionIndex++;
                    }
                }
            }
            $currentQuestion = $QuestionsFromSet[$currentQuestionIndex-1];
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
            <input type='hidden' name='action' value=''>
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
            <td>Topic: $QuestionSetTopic[TopicTitle]</td>
            <td>Submitted By: $QuestionSet[TeacherUsername]</td>
            </table><br>";
    }
    }
    ?>
    </section>
    <footer><?php include "footer.php" ?></footer>
</body>
</html>