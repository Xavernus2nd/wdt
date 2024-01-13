<?php
if (isset($_POST["import"])) {
    if($_POST['SelectedTopic'] == "Not Selected"){
        echo "<script>alert('Please select a topic.')</script>";
        echo "<script>window.location.href='addQuestionSet.php'</script>";
    }
}
include 'sessionTeacher.php';
include 'connection.php';
include 'importcsv.php';
$TopicQuery = mysqli_query($DBconn, "SELECT TopicTitle FROM Topic");
$Topiclists = mysqli_fetch_all($TopicQuery, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Question Set</title>
    <link href='layout.css' rel='stylesheet'>
</head>
<body>
    <header>
        <div id = "logo"></div>
        <h1>Form 4 SPM Mathematics Quiz</h1>
        <?php include 'profileBT.php';?>
    </header>
    <nav><?php include "nTeacher.php" ?></nav>
    <section class="body-container">
    <h2>Add New Question Set</h2>
    <center><h3>Submit your CSV file here for a new question set.</h3></center>
    <div class="csvinfo">
        <form action="" method="post" name="uploadcsv" onsubmit="return confirm('Are you sure you want to submit this question set?')" enctype="multipart/form-data">
        <label name="QuestionSetName">Question Set Name:</label>
        <input type="text" name="QuestionSetName" required><br><br>
        <label name="TopicName">Topic:</label>
        <select name="SelectedTopic" class='select' required>
            <option value="Not Selected">Please select a topic</option>
        <?php 
        foreach ($Topiclists as $topic) {
            if ($topic['TopicTitle'] == $_GET['topic']) {
                echo "<option value='$topic[TopicTitle]' selected>$topic[TopicTitle]</option>";
            }
            else
            echo "<option value='$topic[TopicTitle]' >$topic[TopicTitle]</option>";
        }
        ?>
        </select><br><br>
        <label name="csvfile">Add CSV file:</label>
        <input type="file" name="fileToUpload" required><br><br>
        <button type="submit" name="import" class='button'>Upload</button>
    </form>
    </div>
    </section>
    <footer><?php include "footer.php" ?></footer>
</body>
</html>
