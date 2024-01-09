<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="manageProfile.css" rel="stylesheet">
</head>
<body>

<?php
include("connection.php");
include("sessionTeacher.php");
if(isset($_POST['add_student'])){
    $StudentUsername = $_POST['StudentUsername'];
    $ClassID = $_POST['ClassID'];

    $query = "UPDATE student SET ClassID = '$ClassID' WHERE StudentUsername = '$StudentUsername'";
    $checkStudent = "SELECT COUNT(1) AS count FROM student WHERE StudentUsername = '$StudentUsername' AND ClassID IS NULL";
    $checkClass = "SELECT COUNT(1) AS count FROM class where ClassID = '$ClassID'";
    $result2 = mysqli_query($DBconn, $checkStudent);
    $result3 = mysqli_query($DBconn, $checkClass);
    $row = mysqli_fetch_assoc($result2);
    $row2 = mysqli_fetch_assoc($result3);

    if ($row['count'] == 1){
        if ($row2['count'] == 1){
            $result = mysqli_query($DBconn, $query);
            echo "<script>alert('Student added successfully')</script>";
            echo "<script>window.open('manageClassTeacher.php', '_self')</script>";
        }
        else{
            echo "<script>alert('Class does not exist')</script>";
            echo "<script>window.open('manageClassTeacher.php', '_self')</script>";
        }
    }
    else{
        echo "<script>alert('Student does not exist')</script>";
        echo "<script>window.open('manageClassTeacher.php', '_self')</script>";
    }
    //if($result == 1){
    //    echo "<script>alert('Student added successfully')</script>";
    //    echo "<script>window.open('Manage_Class_Admin.php', '_self')</script>";

}

?>
<div class="add student">
    <h1>Add Student</h1>
    <center>
    <form method="post" action="addStudentTeacher.php">
        <div class="input data">
            <label>Student Username: </label>
            <input type="text" name="StudentUsername" value="">
        </div>

        <input type="hidden" name="ClassID" value="<?php echo $_GET['classID'] ?>">

        <div class="input data">
            <button type="submit" class="btn" name="add_student">Add</button>
        </div>
    </form>
    </center>
    </div>
</html>