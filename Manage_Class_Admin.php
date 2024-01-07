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
    <th>Teacher Name</th>
    </div>

    <div>
    <th>Student List</th>
    </div>

    <div>
    <th>Delete</th>
    </div>

    <div>
    <th>Update</th>
    </div>

</tr>

<?php
include("connection.php");
$sql = "SELECT class.ClassID, teacher.TeacherUsername, teacher.TeacherFullName, class.ClassName, GROUP_CONCAT(student.StudentFullName) AS StudentList FROM class LEFT JOIN student ON class.ClassID = student.ClassID LEFT JOIN teacher ON teacher.TeacherUsername = class.TeacherUsername GROUP BY class.ClassID";

$result = mysqli_query($DBconn, $sql);
while ($row = mysqli_fetch_array($result)) {
    echo '<tr>';
    echo '<td>' . $row['ClassID'] . '</td>';
    echo '<td>';
    echo '<form method="post" action="update_classadmin.php">';
    echo '<input type="hidden" name="ClassID" value="' . $row['ClassID'] . '">';
    echo '<input type="text" name="ClassName" value="' . $row['ClassName'] . '">';
    echo '</td>';
    echo '<td>';
    echo '<form method="post" action="update_teachername.php">';
    echo '<input type="hidden" name="TeacherUsername" value="' . $row['TeacherUsername'] . '">';
    echo '<input type="text" name="TeacherFullName" value="' . $row['TeacherFullName'] . '">';
    echo '</td>';
    echo '<td><a href="student_list.php?classID=' . $row['ClassID'] . '&students=' . $row['StudentList'] . '">View and Edit</a></td>';
    echo '<td><a href="delete_class.php?id=' . $row['ClassID'] . '">Delete</a></td>';
    echo '<td><button class="updateBtn" data-id="' . $row['ClassID'] . '" && data-id="' . $row['TeacherUsername'] . '">Update</button></td>';
    echo '</tr>';
    echo '</form>';

    //add edit class and teachers name
}
?>




</table>

</script>

</body>
</html>