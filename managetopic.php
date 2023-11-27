<?php
session_start();
include 'conn.php';
include 'deleteTopic.php';
include 'editTopic.php';
$topicsql = "SELECT * FROM topic";
$topicQuery = mysqli_query($conn, $topicsql);
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
    <script>
        function deleteTopic(){
            var confirmDelete = confirm("Are you sure you want to delete this topic? This action will also delete ALL QUESTION SETS under this topic");
            if(confirmDelete){
                var doubleconfirm = confirm("Are you REALLY sure you want to delete this topic? This action is irreversible.");
                if(doubleconfirm){
                    return true;
                }
                else{
                    alert("No actions were performed.");
                    return false;
                }
            }
            else{
                alert("No actions were performed.");
                return false;
            }
        }
        function editTopicTitle(){
            var confirmRename = confirm("Are you sure you want to rename this topic?");
            if(confirmRename){
                return true;
            }
            else{
                alert("No actions were performed.");
                return false;
            }
        }
    </script>
</head>
<body>
    <h1>Manage Topics</h1>
    <form action='' method='post' onsubmit='deleteTopic();'>
        <input type='hidden' name='DeleteTopicID'>
        <button type='submit' name=''>Delete</button>
    </form>
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
                    <form action='' method='post' onsubmit='editTopicTitle();'>
                        <input type='hidden' name='EditTopicID' value='$topic[TopicID]'>
                        <input type='text' name='EditTopicTitle' placeholder='New Topic Name'>
                        <button type='submit' name='editTopic'>Edit</button>
                    </form>
                </td>
                <td>
                    <form action='' method='post' onsubmit='deleteTopic();'> <!--this does not work atm-->
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