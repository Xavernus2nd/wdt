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
    <th>No.</th>    
    <th>Student Name</th>
    <th>Remove</th>
</tr>
<?php
include("connection.php");
$classID = $_GET['classID'];
$students = explode(',', $_GET['students']); 


$sql = "SELECT * FROM student WHERE ClassID = $classID AND StudentFullName IN ('".implode("','", $students)."')";
$result = mysqli_query($DBconn, $sql);
if ($result) {
    $i = 1;
    while ($row = mysqli_fetch_array($result)) {
        echo '<tr>';
        echo '<td>' . $i++ . '</td>';
        echo '<td>' . $row['StudentFullName'] . '</td>';
        echo "<td><a href='remove_student.php?id=".$row['StudentFullName']."'>Remove</a></td>";
        echo '</tr>';
    }
} else {
    echo "Error: " . mysqli_error($DBconn);
}

?>

</table>
</body>
</html>