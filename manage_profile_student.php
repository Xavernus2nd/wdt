<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Profile</title>
    <link rel="stylesheet" href="manage_profile.css"> 
</head>
<body>


<?php
include("connection.php");
session_start();
$_SESSION['StudentUsername'] = "yun";
$sql = "SELECT a.StudentFullName, a.StudentUsername, a.StudentPassword, b.ClassName, b.ClassID
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

    $updatesql = "UPDATE student AS a SET a.StudentUsername = '$studentusername', a.StudentFullName = '$studentfullname', a.StudentPassword = '$studentpassword' WHERE a.StudentUsername = '$_SESSION[StudentUsername]'";



    if($updateresult = mysqli_query($DBconn, $updatesql)){
        session_write_close();
        $_SESSION['StudentUsername'] = $studentusername; 
        session_start();
        echo "<script>alert('Update Successful!')</script>";
        echo "<script>window.location.href='manage_profile.php'</script>";
    }
    else{
        echo "<script>alert('Update Failed!')</script>";
        echo "<script>window.location.href='manage_profile.php'</script>";
    }
    
      
 
 }
?>

    <div class="content">
    <h1>Manage Profile</h1>
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
                <input type="text" class="input" name="ClassID" value="<?php echo $info['ClassID'] ?>">
            </div>

            <div>
                <label>Class Name</label>
                <input type="text" class="input" name="ClassName" value="<?php echo $info['ClassName'] ?>">
            </div>

            <div>
                <label>Password</label>
                <input type="password" class="input" name="StudentPassword" value="<?php echo $info['StudentPassword'] ?>">
            </div>                      

            <br>
            <br>
            <div>
                <input type="submit" class="btn" name="update_profile" value="Update">
            </div>
        </div>
    </form>
</center>





</form>
</body>
</html>