<?php
session_start();
if(isset($_POST['submit'])){
    $SelectedTopicCheck['SelectedTopic']=$_POST['SelectedTopic'];
    if($SelectedTopicCheck['SelectedTopic']=="Not Selected"){
        echo "<script>alert('Please select a topic');</script>";
    }
    else{
        $_SESSION['SelectedTopic']=$_POST['SelectedTopic'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Manage Question Set</title>
    <style>
        table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        }
</style>
</head>
<body>
    <h1>View/Manage Question Set</h1>
    <form action="" method="post">
        <select name="SelectedTopic">
            <option value="Not Selected">Please select a topic</option>
        <?php
        $topics = array("Graph","Quad"); //change this to gettopics($conn) later
        foreach ($topics as $topic) {
            echo "<option value='$topic'>$topic</option>";
        }
        ?>
        </select>
        <button type="submit" name="submit">Select Topic</button>
    </form> 
    <?php
    // Check if a specific topic is selected
    if (isset($_SESSION['SelectedTopic'])) {
        // Display question sets for the selected topic
        $questionSets = array("Q1","Q2");       //getQuestionSets($conn, $selectedTopicId)

        echo "<h2>Question Sets for $_SESSION[SelectedTopic]</h2>";
        echo "<button type='button' onclick=\"window.location.href='AddQuestionSet.php'\">Add New Question Set</button>"; //add new question set page
        echo "<table>
                <tr>
                    <th>Question Set ID</th>
                    <th>Question Set Name</th>
                    <th>Number of Questions</th>
                    <th>Submitted By</th>
                    <th>Actions</th>
                </tr>"; //echos the table headers
        echo"<tr>
                <td>1</td>
                <td>Q1</td>
                <td>5</td>
                <td>John</td>
                <td>
                    <form action='' method='post'>
                        <button type='submit' name='edit'>Edit</button>
                        <button type='submit' name='delete'>Delete</button>
                    </form>
                </td>
            </tr>"; //echos the table data
            echo "</table>";
    }
    ?>
</body>
</html>
