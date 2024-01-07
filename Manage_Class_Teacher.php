<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="Manage_Class.css" rel="stylesheet">
</head>
<body>
        
<table>

<tr>

    <div>
    <th>Class ID</th>
    </div>

    <div>
    <th>Class Name</th>
    </div>

    <div>
    <th>Student List</th>
    </div>

    <div>
    <th>Update</th>
    </div>

</tr>

<?php
session_start();
$_SESSION['TeacherUsername'] = "mao";
include("connection.php");
$teacherusername = $_SESSION['TeacherUsername'];

$sql = "SELECT class.ClassID, class.ClassName, class.TeacherUsername, GROUP_CONCAT(student.StudentFullName) AS StudentList FROM class LEFT JOIN student ON class.ClassID = student.ClassID WHERE class.TeacherUsername = '$teacherusername' GROUP BY class.ClassID";

$result = mysqli_query($DBconn, $sql);
while ($row = mysqli_fetch_array($result)) {
    echo '<tr>';
    echo '<td>' . $row['ClassID'] . '</td>';
    echo '<td>';
    echo '<form method="post" action="update_class.php">';
    echo '<input type="hidden" name="ClassID" value="' . $row['ClassID'] . '">';
    echo '<input type="text" name="ClassName" value="' . $row['ClassName'] . '">';
    echo '</td>';
    echo '<td><a href="student_list.php?classID=' . $row['ClassID'] . '&students=' . $row['StudentList'] . '">View and Edit</a></td>';
   // echo '<td><a href="remove_student.php?StudentFullName=' . $row['StudentList'] . '&classID=' . $row['ClassID'] . '">Remove</a></td>';
    echo '<td><button class="updateBtn" data-id="' . $row['ClassName'] . '">Update</button></td>';
    echo '</form>';
    echo '</tr>';
}
?>


</table>

</script>

</body>
</html>