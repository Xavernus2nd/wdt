<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="viewResults.css" rel="stylesheet">
    <link href="layout.css" rel="stylesheet">
</head>
<body>


<nav>
    <?php include 'nAdmin.php'; ?>
</nav>

<section class="body-container">

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
        echo "<td><a href='removeStudentAdmin.php?StudentUsername=".$row['StudentUsername']."'>Remove</a></td>";
        echo '</tr>';
    }
} else {
    echo "Error: " . mysqli_error($DBconn);
}

?>

<tfoot>
    <tr>
    <td colspan="6">
        <center>
    <a href = "addStudentAdmin.php?classID=<?php echo "$_GET[classID]" ?>">Add Student</a>
</center>
    </td>
    </tr>
    </tfoot>

</table>
</section>
<div class="loginTop">
    <a href="logout.php" id="logout">Logout</a>
</div>
<footer>
    <href href="footer.php"></href>
</footer>
</body>
</html>