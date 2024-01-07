<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="View_Results.css" rel="stylesheet">
</head>
<body>
<table>
<tr>
    <th>No. </th>
    <th>Question</th>
    <th>Student Answer</th>
    <th>Correct Answer</th>

</tr>

<h2>Topic Title: </h2>
<h2>Question Set: </h2>
<h2>Mode: </h2>
<h2>Time Taken: </h2>
<h2>Date: </h2>
<h2>Score: </h2> <h2>Grade: </h2>


<?php
session_start();
$_SESSION['StudentUsername'] = "peter";
include("connection.php");

if (isset($_GET['SetID'])) {
   $sql = "SELECT * FROM question_set LEFT JOIN trial ON question_set.SetID = trial.SetID WHERE question_set.SetID = trial.SetID";
   $result = mysqli_query($DBconn, $sql);

   if (mysqli_num_rows($result) > 0) {
       while ($row = mysqli_fetch_assoc($result)) {
        $TopicTitle = $row['TopicTitle'];
       $QuestionSet = $row['SetName'];
       $Mode = $row['Mode'];
       $TimeTaken = $row['TimeTaken'];
       $Date = $row['DateTime'];
       $Score = $row['Score'];
       $Grade = $row['Grade'];
       echo '<h2>' . $TopicTitle . '</h2>';
       echo '<h2>' . $QuestionSet . '</h2>';
       echo '<h2>' . $Mode . '</h2>';
       echo '<h2>' . $TimeTaken . '</h2>';
       echo '<h2>' . $Date . '</h2>';
       echo '<h2>' . $Score . '</h2>';
       echo '<h2>' . $Grade . '</h2>';
        echo '<tr>';
        echo '<td>' . $row['QuestionNumber'] . '</td>';
        echo '<td>' . $row['Question'] . '</td>';
        echo '<td>' . $row['StudentAnswer'] . '</td>';
        echo '<td>' . $row['Answer'] . '</td>';
        echo '</tr>';
    }   
    if(!$result){
        echo "Error: " . mysqli_error($DBconn);
    }   
   } else {
       echo "No results found for the specified question set.";
   }
}

mysqli_close($DBconn);


?>

</table>
</body>
</html>
