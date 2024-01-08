<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question Set</title>
    <link rel="stylesheet" href="layout.css">
</head>
<body>
    <header>
        <div id="logo"></div>
        <h1>Form 4 SPM Mathematics Quiz</h1>
        <?php include 'profileBS.php';?>
    </header>
    
    <nav>
        <?php include 'nStudent.php';?>
    </nav>

    <!--question set form-->
    <section class="body-container">
        <?php
        include 'connection.php';         
        include 'sessionStudent.php';
        include 'questionSetForm.php';
        ?>
    </section>
    <footer>
        <?php include 'footer.php'; ?>
    </footer>
</body>
</html>