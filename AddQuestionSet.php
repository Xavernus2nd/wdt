<?php
session_start();
$_SESSION['TeacherUsername']="Teacher1";
include 'conn.php';
include 'importcsv.php';
$TopicQuery = mysqli_query($conn, "SELECT TopicTitle FROM Topic");
$Topiclists = mysqli_fetch_all($TopicQuery, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Question Set</title>
</head>
<body>
    <h1>Add New Question Set</h1>
    <h2>Submit your CSV file here for a new question set.</h2>
    <form action="" method="post" name="uploadcsv" enctype="multipart/form-data">
        <label name="QuestionSetName">Question Set Name:</label>
        <input type="text" name="QuestionSetName" required><br>
        <label name="TopicName">Topic:</label>
        <select name="SelectedTopic">
            <option value="Not Selected">Please select a topic</option>
        <?php 
        foreach ($Topiclists as $topic) {
            echo "<option value='$topic[TopicTitle]'>$topic[TopicTitle]</option>";
        }
        ?>
        </select><br>
        <label name="csvfile">Add CSV file:</label>
        <input type="file" name="fileToUpload" required><br>
        <button type="submit" name="import">Upload</button>
</body>
</html>