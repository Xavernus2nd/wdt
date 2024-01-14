<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Class</title>
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
<h2>Create Class</h2>

<?php
include("connection.php");
include("sessionTeacher.php");

if(isset($_POST['create_class'])) {
    $classname = $_POST['ClassName']; 
    $teacherusername = $_SESSION['TeacherUsername'];
    $sql = "INSERT INTO class (ClassName, TeacherUsername) VALUES ('$classname', '$teacherusername')";
    $result = mysqli_query($DBconn, $sql);
    if($result){
        echo "<script>alert('Class Created!')</script>";
        echo "<script>window.location.href='manageClassTeacher.php'</script>";
    }
    else{
        echo "<script>alert('Class Creation Failed!')</script>";
        echo "<script>window.location.href='manageClassTeacher.php'</script>";
    }
    
      
 
 }


?>

    <div id = "add_student">
    <h1>Create Class</h1>
    <center>
    <form method="post" action="createClassTeacher.php">
        <div class="input data">
            <label>Class Name: </label>
            <input type="text" name="ClassName" value="">
        </div>
        <div class="input data">
            <button type="submit" class="button" name="create_class">Create</button>
        </div>
    </form>
    </center>
    </div>
</section>
<footer>
    <?php include 'footer.php';?>
</footer>
</body>
</html>
