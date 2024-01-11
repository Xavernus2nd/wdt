<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MQ Login Page</title>
    <link rel="stylesheet" href="layout.css">

</head>

<body>

<header>
<div id = "logo"></div>
    <h1>Form 4 SPM Mathematics Quiz</h1>
    <div class="loginTop">
        <a href="register.php" id="register">Register</a>
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


<section class="body-lp">
    <h2>Login</h2>
    <form action="loginProcess.php" method="post">
        <label for="username">Username:</label>
        <input type="text" maxlength="10" minlength='4' id="username" name="username" required pattern="[a-z0-9]+" title="(4-10characters;a-z;0-9)" placeholder="Enter Your Username"><br>
        <br>

        <label for="password">Password:</label>
        <input type="password" id="password" minlength='6' maxlength='15' name="password" required title="(length:6-25)" placeholder='Enter Your Password'><br>
        <input type="checkbox" onclick="passwordEye()">Show Password
        <br>
        <br>

        <label for="identity">Are you a:</label>
        <input type="radio" id="Student" name="identity" value="Student" required>
        <label for="Student">Student</label>
        <input type="radio" id="Teacher" name="identity" value="Teacher" required>
        <label for="Teacher">Teacher</label>
        <input type="radio" id="Admin" name="identity" value="Admin" required>
        <label for="Admin">Admin</label><br>
        <br>

        <button type="submit">Login</button>
    </form>
    <p>Have not registered?</p>
    <a href="register.php">Register here</a>

</section>


<footer>
    <?php include 'footer.php'; ?>
</footer>
    
</body>
</html>