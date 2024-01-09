<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mathematics Quiz</title>
    <link rel="stylesheet" href="layout.css">

</head>
<body>

<script>
    // Display an alert when the page loads
    window.onload = function() {
        alert('Login successfully!Its a go! Begin your operation whenever youre ready!');
    };
</script>

<header>
<div id = "logo"></div>
    <h1>Form 4 SPM Mathematics Quiz</h1>
<!-- Logout only for admin -->
    <div class="loginTop">
        <a href="logout.php" id="logout">Logout</a>
    </div>
</header>

<nav>
    <?php include 'nAdmin.php';?> 
</nav>


<section class="body-container">

<h2 style="font-size: 30px;text-shadow: 2px 2px 4px #000000;text-align:center;padding-top: 50px;">Welcome Back To Form 4 SPM Mathematics Quiz System!</p>

<img src="icons8-admin.gif" style="display: block; margin: auto;width:100px;height:100px;">


</section>


<footer>
    <?php include 'footer.php'; ?>
</footer>

</body>
</html>