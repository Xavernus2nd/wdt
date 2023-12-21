<?php
session_start();
include 'connection.php';
include 'editTopic.php';
include 'deleteTopic.php';
$topicQuery = mysqli_query($DBconn, "SELECT * FROM topic");
$topicResult = mysqli_fetch_all($topicQuery, MYSQLI_ASSOC);
?>
<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Manage Topic</title>
    <link rel="stylesheet" href="layout.css">
    <style>
        table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        }
    </style>
</head>
<body>
    <h2>Manage Topics</h2>
    <center><h2>Topic List</h2></center>
    <?php
    echo "<table class='table'>
            <tr>
                <th>Topic ID</th>
                <th>Topic Name</th>
                <th colspan='2'>Actions</th>
            </tr>";
    foreach($topicResult as $topic){
        echo "<tr>
                <td>$topic[TopicID]</td>
                <td>$topic[TopicTitle]</td>
                <td>
                    <form action='' method='post' onsubmit='return confirm('Are you sure you want to rename this topic?');'>
                        <input type='hidden' name='EditTopicID' value='$topic[TopicID]'>
                        <input type='text' name='EditTopicTitle' placeholder='New Topic Name' required>
                        <button type='submit' name='editTopic' class='button'>Edit</button>
                    </form>
                </td>
                <td>
                    <form action='' method='post' onsubmit='return confirm('Are you sure you want to delete this topic? This action will also delete ALL QUESTION SETS under this topic');'> 
                        <input type='hidden' name='DeleteTopicID' value='$topic[TopicID]'>
                        <button type='submit' name='deleteTopic' class='button'>Delete</button>
                    </form>
                </td>
            </tr>";
    }
    echo "</table>";
    ?>
</body>
</html>