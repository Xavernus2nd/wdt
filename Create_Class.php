<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Class</title>
    <link rel="stylesheet" href="manage_profile.css"> 
</head>
<body>


<?php
include("connection.php");
session_start();
$_SESSION['TeacherUsername'] = "mao";

if(isset($_POST['create_class'])) {
    $classname = $_POST['ClassName']; 
    $teacherusername = $_SESSION['TeacherUsername'];
    $sql = "INSERT INTO class (ClassName, TeacherUsername) VALUES ('$classname', '$teacherusername')";
    $result = mysqli_query($DBconn, $sql);
    if($result){
        echo "<script>alert('Class Created!')</script>";
        echo "<script>window.location.href='Manage_Class_Teacher.php'</script>";
    }
    else{
        echo "<script>alert('Class Creation Failed!')</script>";
        echo "<script>window.location.href='Manage_Class_Teacher.php'</script>";
    }
    
      
 
 }


?>

    <div class="content">
    <h1>Create Class</h1>
    <center>
    <form method="post" action="Create_Class.php">
        <div class="input-group">
            <label>Class Name</label>
            <input type="text" name="ClassName" value="">
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="create_class">Create</button>
        </div>
    </form>
    </center>
    </div>
</body>
</html>