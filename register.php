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

<section class='body-lp'>    
<h2>Register</h2>
    <form action="registerProcess.php" method="post">
        <label for="fullname">Full Name:</label>
        <input type="text" maxlength="20" id="fullname" name="fullname" required><br>
        <br>

        <label for="username">Username:</label>
        <input type="text" maxlength="20" id="username" name="username" required><br>
        <br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <br>

        <label for="identity">Are you a:</label>
        <input type="radio" id="Student" name="identity" value="Student" required>
        <label for="Student">Student</label>
        <input type="radio" id="Teacher" name="identity" value="Teacher" required>
        <label for="Teacher">Teacher</label><br>
        <br>

        <label for="classID">Join Class (ID):</label>
        <input type="text" inputmode="numeric" pattern="\d*" maxlength="10" id="classID" name="classID"><br>
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