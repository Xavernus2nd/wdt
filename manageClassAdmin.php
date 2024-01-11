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
</header>
    
<nav>
    <?php include 'nAdmin.php'; ?>
</nav>

<section class="body-container">
<h2>Manage Class</h2>

<table class = "table">

<tr>
    
    <th>Class ID</th>
    <th>Class Name</th>
    <th>Teacher Name</th>
    <th>Student List</th>
    <th>Delete</th>
    <th>Update</th>
    
</tr>

<?php
include("connection.php");
include("sessionAdmin.php");
$sql = "SELECT class.ClassID, class.TeacherUsername, teacher.TeacherFullName, class.ClassName, GROUP_CONCAT(student.StudentFullName) AS StudentList FROM class LEFT JOIN student ON class.ClassID = student.ClassID LEFT JOIN teacher ON teacher.TeacherUsername = class.TeacherUsername GROUP BY class.ClassID";

$result = mysqli_query($DBconn, $sql);
while ($row = mysqli_fetch_array($result)) {
    echo '<tr>';
    echo '<td>' . $row['ClassID'] . '</td>';
    echo '<td>';
    echo '<form method="post" action="updateClassAdmin.php">';
    echo '<input type="hidden" name="ClassID" value="' . $row['ClassID'] . '">';
    echo '<input type="text" name="ClassName" value="' . $row['ClassName'] . '">';
    echo '</td>';
    echo '<td>';
    echo '<form method="post" action="updateTeacherName.php">';
    echo '<input type="hidden" name="TeacherUsername" value="' . $row['TeacherUsername'] . '">';
    echo '<input type="text" name="TeacherFullName" value="' . $row['TeacherFullName'] . '">';
    echo '</td>';
    echo '<td><a href="studentListAdmin.php?classID=' . $row['ClassID'] . '&students=' . $row['StudentList'] . '">View and Edit</a></td>';
    echo '<td><a href="deleteClassAdmin.php?id=' . $row['ClassID'] . '">Delete</a></td>';
    echo '<td><button class="button" data-id="' . $row['ClassID'] . '">Update</button></td>';
    echo '</tr>';
    echo '</form>';

    //add edit class and teachers name
}
?>

<tfoot>
    <tr>
    <td colspan="6">
        <center>
    <a href = createClassAdmin.php>Create Class</a>
</center>
    </td>
    </tr>
    </tfoot>



</table>

</script>
</section>

<div class="loginTop">
    <a href=logout.php id="logout">LogOut</a>
</div>

<footer>
    <?php include 'footer.php'; ?>
</footer>
</body>
</html>
