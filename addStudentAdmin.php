<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link href="layout.css" rel="stylesheet">
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

<?php
include("connection.php");
include("sessionAdmin.php");
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
            echo "<script>window.open('addStudentAdmin.php?classID=$ClassID', '_self')</script>";
        }
        else{
            echo "<script>alert('Class does not exist')</script>";
            echo "<script>window.open('addStudentAdmin.php?classID=$ClassID', '_self')</script>";
        }
    }
    else{
        echo "<script>alert('Student does not exist or already exists in another class')</script>";
        echo "<script>window.open('addStudentAdmin.php?classID=$ClassID', '_self')</script>";
    }
}

?>
<div id = "add_student">
    <h1>Add Student</h1>
    <center>
    <form method="post" action="addStudentAdmin.php">
        <div class="input data">
            <label>Student Username: </label>
            <input type="text" name="StudentUsername" value="">
        </div>

        <input type="hidden" name="ClassID" value="<?php echo $_GET['classID'] ?>">

        <div class="input data">
            <button type="submit" class="button" name="add_student">Add</button>
        </div>
    </form>
    </center>
    </div>
</section>
<div class="loginTop">
    <a href=logout.php id="logout">Logout</a>
</div>
<footer>
    <?php include 'footer.php'; ?>
</footer>

</body>
</html>
