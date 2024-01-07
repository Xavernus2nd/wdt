<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Results</title>
    <link rel="stylesheet" href="View_Results.css">
</head>
<body>
    
<table id = View_Results_Student>

<tr>

    <div>
    <th>No.</th>
    </div>

    <div>
    <th>Name</th>
    </div>

    <div>
    <th>Class</th>
    </div>

    <div>
    <th>Question Set Name</th>
    </div>

    <div>
    <th>Score</th>
    </div>

    <div>
    <th>Date</th>
    </div>

    <div>
    <th>Comment</th>
    </div>
    
    <div>
    <th>View More</th>
    </div>
</tr>


<?php
include("connection.php");
$sql = "SELECT a.StudentFullName, b.ClassName, c.SetName, d.Score, d.DateTime, d.Comment, d.TrialID
FROM student AS a 
LEFT JOIN class AS b ON a.ClassID = b.ClassID 
LEFT JOIN trial AS d ON d.StudentUsername = a.StudentUsername
LEFT JOIN question_set AS c ON c.SetID = d.SetID
WHERE d.Score IS NOT NULL AND d.DateTime IS NOT NULL";


$result = mysqli_query($DBconn, $sql);

if ($result) {
    $i = 1;
    while ($row = mysqli_fetch_array($result)) {
        echo '<tr>';
        echo '<td>' . $i++ . '</td>';
        echo '<td>' . $row['StudentFullName'] . '</td>';
        echo '<td>' . $row['ClassName'] . '</td>';
        echo '<td>' . $row['SetName'] . '</td>';
        echo '<td>' . $row['Score'] . '</td>';
        echo '<td>' . $row['DateTime'] . '</td>';
        echo '<td>' . $row['Comment'] . '</td>';
        echo "<td><a href='answerhistory.php?id=".$row['TrialID']."'>View</a></td>";

        echo '</tr>';
    }
} else {
    echo "Error: " . mysqli_error($DBconn);
}

?>

</table>

</body>
</html>