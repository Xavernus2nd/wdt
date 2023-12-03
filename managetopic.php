<?php
session_start();
include 'conn.php';
include 'editTopic.php';
include 'deleteTopic.php';
$topicQuery = mysqli_query($conn, "SELECT * FROM topic");
$topicResult = mysqli_fetch_all($topicQuery, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Manage Topic</title>
    <style>
        table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        }
    </style>
</head>
<body>
    <h1>Manage Topics</h1>
    <?php
    echo "<table>
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
                        <button type='submit' name='editTopic'>Edit</button>
                    </form>
                </td>
                <td>
                    <form action='' method='post' onsubmit='return confirm('Are you sure you want to delete this topic? This action will also delete ALL QUESTION SETS under this topic');'> 
                        <input type='hidden' name='DeleteTopicID' value='$topic[TopicID]'>
                        <button type='submit' name='deleteTopic'>Delete</button>
                    </form>
                </td>
            </tr>";
    }
    echo "</table>";
    ?>
</body>
</html>