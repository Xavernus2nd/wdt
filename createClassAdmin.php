<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Class</title>
    <link rel="stylesheet" href="manageProfile.css"> 
    <link rel="stylesheet" href="layout.css">
</head>
<body>



<nav>
    <?php include 'nAdmin.php'; ?>
</nav>

<section class="body-container">

<?php
include("connection.php");
include("sessionAdmin.php");

if(isset($_POST['create_class'])) {
    $classname = $_POST['ClassName']; 
    $teacherusername = $_POST['TeacherUsername'];
    $sql = "INSERT INTO class (ClassName, TeacherUsername) VALUES ('$classname', '$teacherusername')";
    $result = mysqli_query($DBconn, $sql);
    if($result){
        echo "<script>alert('Class Created!')</script>";
        echo "<script>window.location.href='manageClassAdmin.php'</script>";
    }
    else{
        echo "<script>alert('Class Creation Failed, Teacher Username not Found!')</script>";
        echo "<script>window.location.href='manageClassAdmin.php'</script>";
    }
    
      
 
 }


?>

    <div class="content">
    <h1>Create Class</h1>
    <center>
    <form method="post" action="createClassAdmin.php">
        <div class="input data">
            <label>Class Name: </label>
            <input type="text" name="ClassName" value="">
        </div>

        <div class="input data">
            <label>Teacher Username: </label>
            <input type="text" name="TeacherUsername" value="">
        </div>

        <div class="input data">
            <button type="submit" class="btn" name="create_class">Create</button>
        </div>
    </form>
    </center>
    </div>
</section>
<footer>
    <?php include 'footer.php'; ?>
</footer>
</body>
</html>