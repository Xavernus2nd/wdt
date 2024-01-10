<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result</title>
    <link rel="stylesheet" href="layout.css">
</head>
<body>
    <header>
        <div id="logo"></div>
        <h1>Form 4 SPM Mathematics Quiz</h1>
        <?php include 'profileBT.php';?>
    </header>
    
    <nav>
        <?php include 'nTeacher.php';?>
    </nav>

    <!--showing result and answer-->
    <section class="body-container">
        <?php 
        include 'connection.php';
        include 'sessionTeacher.php';
        include 'answerHistory.php';
        ?>
    </section>
    
    <footer>
    <?php include 'footer.php'; ?>
    </footer>
</body>
</html>