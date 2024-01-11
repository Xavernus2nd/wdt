<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Results</title>
    <link rel="stylesheet" href="viewResults.css">
    <link rel="stylesheet" href="layout.css">
</head>
<body>

<header>
        <div id="logo"></div>
        <h1>Form 4 SPM Mathematics Quiz</h1>
        <?php include 'profileBS.php';?>
</header>

<nav>
    <?php include 'nStudent.php'; ?>
</nav>

<section class="body-container">

<h2>View Results Page</h2>
    
<table class = "table">

<tr>
    <th>No.</th>
    <th>Question Set Name</th>
    <th>Score</th>
    <th>Date</th>
    <th>Time</th>
    <th>Comment</th>
    <th>View More</th>
</tr>

<?php
include("connection.php");
include("sessionStudent.php");
$studentUsername = $_SESSION['StudentUsername'];


$sql = "SELECT a.StudentFullName, a.StudentUsername, b.ClassName, c.SetName, d.Score, d.DateTime, d.Comment, d.TrialID, d.QuizType, d.SetID, Date(Datetime) AS Date, Time(Datetime) AS Time
FROM student AS a 
LEFT JOIN class AS b ON a.ClassID = b.ClassID 
LEFT JOIN trial AS d ON d.StudentUsername = a.StudentUsername
LEFT JOIN question_set AS c ON c.SetID = d.SetID
WHERE d.Score IS NOT NULL AND d.DateTime IS NOT NULL AND a.StudentUsername = '$studentUsername'";


$result = mysqli_query($DBconn, $sql);

if ($result) {
    $i = 1;
    while ($row = mysqli_fetch_array($result)) {
        echo '<tr>';
        echo '<td>' . $i++ . '</td>';
        echo '<td>' . $row['SetName'] . '</td>';
        echo '<td>' . $row['Score'] . '%</td>';
        echo '<td>' . $row['Date'] . '</td>';
        echo '<td>' . $row['Time'] . '</td>';
        echo '<td>' . $row['Comment'] . '</td>';
        echo '<form id="resultForm" action="resultAnswer.php" method="POST">';
        echo '<input type="hidden" name="TrialID" value="' . $row['TrialID'] . '">';
        echo '<td><button type="submit" class="button" name="view_specific">View</button></td>';
        echo '</form>';
        echo '</tr>';
    }
} else {
    echo "Error: " . mysqli_error($DBconn);
}

?>

</table>
</section>

<footer>
    <?php include 'footer.php'; ?>
</footer>
</body>
</html>
