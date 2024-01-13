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
$sql = "SELECT a.StudentFullName, a.StudentUsername, a.StudentPassword, b.ClassName
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
    $studentpassword = $_POST['StudentPassword'];

    $updatesql = "UPDATE student AS a SET a.StudentUsername = '$studentusername', a.StudentFullName = '$studentfullname', a.StudentPassword = '$studentpassword' WHERE a.StudentUsername = '$_SESSION[StudentUsername]'";



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

<script>
   function showPassword() {
       var inputPassword = document.getElementById('passwordInput');
       if (inputPassword.type === "password") {
           inputPassword.type = "text";
       } else {
           inputPassword.type = "password";
       }
   }
</script>

    <div class="content">
    <center>
    <form method = "post" action="">

    <div class="div_bg">

            <div>
                <label>Username</label>
                <input type="text" class="input" maxlength="20" name="StudentUsername" placeholder="Enter your new username" required value="<?php echo $info['StudentUsername'] ?>">
            </div>

            <div>
                <label>Full Name</label>
                <input type="text" class="input" name="StudentFullName" placeholder="Enter your full name" required value="<?php echo $info['StudentFullName'] ?>">
            </div>


            <div>
                <label>Class Name</label>
                <input type="text" class="input" name="ClassName" value=""<?php echo $info['ClassName'] ?>" readonly>
            </div>

            <div>
                <label>Password</label>
                <input type="password" class="input" id="passwordInput" minlength="6" maxlength="8" name="StudentPassword" placeholder="Enter your new password" required value="<?php echo $info['StudentPassword'] ?>">
            </div>   

            <input type="checkbox" onclick="showPassword()">Show Password

            <br>
            <br>
            <div>
                <input type="submit" class="button" name="update_profile" value="Update">
            </div>
        </div>
    </form>
</div>
</center>


</form>

</section>
    </div>
<footer>
    <?php include 'footer.php'; ?>
</footer>
</body>
</html>
