<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Results</title>
    <link rel="stylesheet" href="layout.css">
</head>
<body>
    
<header>
        <div id="logo"></div>
        <h1>Form 4 SPM Mathematics Quiz</h1>
        <?php include 'profileBT.php';?>
</header>

<nav>
    <?php include 'nTeacher.php'; ?>
</nav>

<section class="body-container">

<h2>View Results Page</h2>
    
<table class = table>

<tr>
    <th>No.</th>
    <th>Name</th>
    <th>Class</th>
    <th>Question Set Name</th>
    <th>Score</th>
    <th>Date</th>
    <th>View More</th>
    <th>Comment</th>
</tr>


<?php
include("connection.php");
include("sessionTeacher.php");
$teacherusername = $_SESSION['TeacherUsername'];
$sql = "SELECT a.StudentFullName, b.ClassName, b.TeacherUsername, c.SetName, d.Score, d.DateTime, d.Comment, d.TrialID, d.QuizType, d.SetID
FROM student AS a 
LEFT JOIN class AS b ON a.ClassID = b.ClassID 
LEFT JOIN trial AS d ON d.StudentUsername = a.StudentUsername
LEFT JOIN question_set AS c ON c.SetID = d.SetID
WHERE d.Score IS NOT NULL AND d.DateTime IS NOT NULL AND b.TeacherUsername = '$teacherusername'";


$result = mysqli_query($DBconn, $sql);

if ($result) {
    $i = 1;
    while ($row = mysqli_fetch_array($result)) {
        echo '<tr>';
        echo '<td>' . $i++ . '</td>';
        echo '<td>' . $row['StudentFullName'] . '</td>';
        echo '<td>' . $row['ClassName'] . '</td>';
        echo '<td>' . $row['SetName'] . '</td>';
        echo '<td>' . $row['Score'] . '%</td>';
        echo '<td>' . $row['DateTime'] . '</td>';
        echo '<td>';
        echo '<form id="resultForm" action="viewResultsSpecific.php" method="POST">';
        echo '<input type="hidden" name="TrialID" value="' . $row['TrialID'] . '">';
        echo '<input type="hidden" name="SetID" value="' . $row['SetID'] . '">';
        echo '<input type="hidden" name="QuizType" value="' . $row['QuizType'] . '">';
        echo '<button type="submit" class="button" name="view_specific">View</button></td>';
        echo '</form>';
        echo '<td>';
        echo '<form method="post" action="updateCommentTeacher.php">';
        echo '<input type="hidden" name="TrialID" value="' . $row['TrialID'] . '">';
        echo '<input type="text" name="Comment" value="' . $row['Comment'] . '">';
        echo '<input type="submit" class="button" value="Update">';
        echo '</form>';
        echo '</td>';
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
