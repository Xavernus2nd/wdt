<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MQ Login Page</title>
    <link rel="stylesheet" href="layout.css">

</head>

<body>
    <div id="logo"></div>

    <nav>
        <?php include 'navbar.php';?>
    </nav>

    <h1>Form 4 SPM Mathematics Quiz</h1>

    <?php include 'loginb.php';?>

    <section class="body-lp">
    <h2>Login</h2>
    <form action="loginprocess.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        <br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
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