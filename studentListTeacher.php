<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <link href="layout.css" rel="stylesheet">
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

<h2>Student List</h2>

    <table class = "table">
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
        echo "<td><a href='removeStudentTeacher.php?StudentUsername=".$row['StudentUsername']."' onclick='return confirm(\"Are you sure you wish to remove this student? This action cannot be reverted\")'>Remove</a></td>";
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
    <a href = "addStudentTeacher.php?classID=<?php echo "$_GET[classID]" ?>">Add Student</a>
</center>
    </td>
    </tr>
    </tfoot>

</table>
</section>

<footer>
    <?php include 'footer.php'; ?>
</footer>
</body>
</html>
