<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Class</title>
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
<h2>Manage Class</h2>
        
<table class = "table">

<tr>
    
    <th>Class ID</th>
    <th>Class Name</th>
    <th>Student List</th>
    <th>Delete</th>
    <th>Update</th>

</tr>

<?php
include("connection.php");
include("sessionTeacher.php");
$teacherusername = $_SESSION['TeacherUsername'];

$sql = "SELECT class.ClassID, class.ClassName, class.TeacherUsername, GROUP_CONCAT(student.StudentFullName) AS StudentList FROM class LEFT JOIN student ON class.ClassID = student.ClassID WHERE class.TeacherUsername = '$teacherusername' GROUP BY class.ClassID";

$result = mysqli_query($DBconn, $sql);
while ($row = mysqli_fetch_array($result)) {
    echo '<tbody>';
    echo '<tr>';
    echo '<td>' . $row['ClassID'] . '</td>';
    echo '<td>';
    echo '<form method="post" action="updateClassTeacher.php">';
    echo '<input type="hidden" name="ClassID" value="' . $row['ClassID'] . '">';
    echo '<input type="text" name="ClassName" value="' . $row['ClassName'] . '">';
    echo '</td>';
    echo '<td><a href="studentListTeacher.php?classID=' . $row['ClassID'] . '&students=' . $row['StudentList'] . '">View and Edit</a></td>';
    echo '<td><a href="deleteClassTeacher.php?id=' . $row['ClassID'] . '" onclick = "return confirm(\'Are you sure you wish to delete this class? This action cannot be reverted\')">Delete</a></td>';
    echo '<td><button class="button" data-id="' . $row['ClassName'] . '">Update</button></td>';
    echo '</form>';
    echo '</tr>';
    echo '</tbody>';

}
    ?>

    <tfoot>
    <tr>
    <td colspan="4">
        <center>
    <a href = createClassTeacher.php>Create Class</a>
</center>
    </td>
    </tr>
    </tfoot>




</table>

</script>

</section>
<footer>
    <?php include 'footer.php'; ?>
</footer>
</body>
</html>
