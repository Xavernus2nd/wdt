<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MQ Register</title>
    <link rel="stylesheet" href="layout.css">

</head>
<body>


<header>
<div id = "logo"></div>
    <h1>Form 4 SPM Mathematics Quiz</h1>
    <!-- Login and Profile Containers -->
    <div class="loginTop">
        <a href="login.php" id="login">Login</a>
    </div>
</header>

<nav>
    <?php include 'navigation.php';?> 
</nav>

<script>
function passwordEye() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>

<section class='body-lp'>    
<h2>Register</h2>
    <form action="registerProcess.php" method="post">
        <label for="fullname">Full Name:</label>
        <input type="text" maxlength="20" minlength='8' id="fullname" name="fullname" required pattern="[A-Za-z ]+" title="(8-20characters;a-z;A-Z)" placeholder="Enter Your Full Name"><br>
        <br>

        <label for="username">Username:</label>
        <input type="text" maxlength="10" minlength='4' id="username" name="username" required pattern="[a-z0-9]+" title="(4-10characters;a-z;0-9)" placeholder="Enter Your Username"><br>
        <br>

        <label for="password">Password:</label>
        <input type="password" id="password" minlength='6' maxlength='15' name="password" required title='(length:6-25)' placeholder="Enter Your Password">
        <input type="checkbox" onclick="passwordEye()">Show Password
        <br>
        <br>

        <label for="identity">Are you a:</label>
        <input type="radio" id="Student" name="identity" value="Student" required>
        <label for="Student">Student</label>
        <input type="radio" id="Teacher" name="identity" value="Teacher" required>
        <label for="Teacher">Teacher</label><br>
        <br>

        <label for="classID">Join Class (ID):</label>
        <input type="text" inputmode="numeric" pattern="\d+" maxlength="4" id="classID" name="classID" autocapitalize title='(4characters;A-Z;0-9)' placeholder="Enter Your Class ID(Optional)"><br>
        <br>

        <button type="submit">Register</button>
    </form>
<p>Have an account?</p>
<a href="login.php">Log In here</a>

</section>

<footer>
    <?php include 'footer.php'; ?>
</footer>

</body>
</html>