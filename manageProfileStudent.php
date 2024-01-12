<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Profile Student</title>
    <link rel="stylesheet" href="layout.css">
</head>
<body>
<div id = "manageProfile">
<header>
        <div id="logo"></div>
        <h1>Form 4 SPM Mathematics Quiz</h1>
        <?php include 'profileBS.php';?>
</header>

<nav>
    <?php include 'nStudent.php'; ?>
</nav>

<section class="body-container">
<h2>Manage Profile</h2>
<?php
include("connection.php");
include ("sessionStudent.php");
$sql = "SELECT a.StudentFullName, a.StudentUsername, a.StudentPassword
FROM student as a 
LEFT JOIN class as b on a.ClassID = b.ClassID 
LEFT JOIN trial as c on a.StudentUsername = c.StudentUsername
WHERE a.StudentUsername = '{$_SESSION['StudentUsername']}'";


$result = mysqli_query($DBconn,$sql);

if($result === false){
   die('Error: '.mysqli_error($DBconn));
}


$info = mysqli_fetch_assoc($result);

if(isset($_POST['update_profile'])) {
    $studentusername = $_POST['StudentUsername']; 
    $studentfullname = $_POST['StudentFullName'];
    $classid = $_POST['ClassID'];
    $classname = $_POST['ClassName'];
    $studentpassword = $_POST['StudentPassword'];

    $updatesql = "UPDATE student AS a SET a.StudentUsername = '$studentusername', a.StudentFullName = '$studentfullname', a.StudentPassword = '$studentpassword', b.ClassID = '$classid', b.ClassName = '$classname' WHERE a.StudentUsername = '$_SESSION[StudentUsername]'";



    if($updateresult = mysqli_query($DBconn, $updatesql)){
        session_write_close();
        session_start();
        $_SESSION['StudentUsername'] = $studentusername; 

        echo "<script>alert('Update Successful!')</script>";
        echo "<script>window.location.href='manageProfileStudent.php'</script>";
    }
    else{
        echo "<script>alert('Update Failed!')</script>";
        echo "<script>window.location.href='manageProfileStudent.php'</script>";
    }
    
      
 
 }
?>

    <div class="content">
    <center>
    <form method = "post" action="">

    <div class="div_bg">
            <div>
                <label>Username</label>
                <input type="text" class="input" name="StudentUsername" value="<?php echo $info['StudentUsername'] ?>">
            </div>

            <div>
                <label>Full Name</label>
                <input type="text" class="input" name="StudentFullName" value="<?php echo $info['StudentFullName'] ?>">
            </div>

            <div>
                <label>Class ID</label>
                <input type="text" class="input" name="ClassID" value="<?php echo $info['ClassID'] ?>" readonly>
            </div>

            <div>
                <label>Class Name</label>
                <input type="text" class="input" name="ClassName" value="<?php echo $info['ClassName'] ?>" readonly>
            </div>

            <div>
                <label>Password</label>
                <input type="password" class="input" name="StudentPassword" value="<?php echo $info['StudentPassword'] ?>">
            </div>                      

            <br>
            <br>
            <div>
                <input type="submit" class="button" name="update_profile" value="Update">
            </div>
        </div>
    </form>
</center>


</form>

</section>
    </div>
<footer>
    <?php include 'footer.php'; ?>
</footer>
</body>
</html>
