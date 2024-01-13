<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Profile Teacher</title>
    <link rel="stylesheet" href="layout.css">
</head>
<body>

<header>
        <div id="logo"></div>
        <h1>Form 4 SPM Mathematics Quiz</h1>
        <div class="loginTop">
            <a href="logout.php" id="logout">Logout</a>
        </div>
</header>

<nav>
    <?php include 'nTeacher.php'; ?>
</nav>

<section class="body-container">
<h2>Manage Profile</h2>
<?php
include("connection.php");
include ("sessionTeacher.php");
$sql = "SELECT a.TeacherUsername, a.TeacherFullName, a.TeacherPassword
FROM teacher as a 
LEFT JOIN class as b on a.TeacherUsername = b.TeacherUsername 
LEFT JOIN question_set as c on a.TeacherUsername = c.TeacherUsername
WHERE a.TeacherUsername = '{$_SESSION['TeacherUsername']}'";


$result = mysqli_query($DBconn,$sql);

if($result === false){
   die('Error: '.mysqli_error($DBconn));
}


$info = mysqli_fetch_assoc($result);

if(isset($_POST['update_profile'])) {
    $teacherusername = $_POST['TeacherUsername']; 
    $teacherfullname = $_POST['TeacherFullName'];
    $teacherpassword = $_POST['TeacherPassword'];

    $updatesql = "UPDATE teacher AS a SET a.TeacherUsername = '$teacherusername', a.TeacherFullName = '$teacherfullname', a.TeacherPassword = '$teacherpassword' WHERE a.TeacherUsername = '$_SESSION[TeacherUsername]'";



    if($updateresult = mysqli_query($DBconn, $updatesql)){
        session_write_close();
        session_start();
        $_SESSION['TeacherUsername'] = $teacherusername; 
        echo "<script>alert('Update Successful!')</script>";
        echo "<script>window.location.href='manageProfileTeacher.php'</script>";
    }
    else{
        echo "<script>alert('Update Failed!')</script>";
        echo "<script>window.location.href='manageProfileTeacher.php'</script>";
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

<div id="manageProfile">
    <div class="content">
    <center>
    <form method = "post" action="">

    <div class="div_bg">
            <div>
                <label>Username</label>
                <input type="text" class="input" maxlength="20" name="TeacherUsername" placeholder="Enter your new username" required value="<?php echo $info['TeacherUsername'] ?>">
            </div>

            <div>
                <label>Full Name</label>
                <input type="text" class="input" name="TeacherFullName" placeholder="Enter your full name" required value="<?php echo $info['TeacherFullName'] ?>">
            </div>

            <div>
                <label>Password</label>
                <input type="password" class="input" id=passwordInput minlength="6" maxlength="8" name="TeacherPassword" placeholder="Enter your new password" required value="<?php echo $info['TeacherPassword'] ?>">
            </div>                      

                <input type="checkbox" onclick="showPassword()">Show Password

            <br>
            <br>
            <div>
                <input type="submit" class="button" name="update_profile" value="Update">
            </div>
        </div>
    </form>
</center>





</form>
    </div>
</section>

<footer>
    <?php include 'footer.php';?>
</footer>
</body>
</html>
