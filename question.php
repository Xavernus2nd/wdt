<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question</title>
    <link rel="stylesheet" href="layout.css">
</head>
<body>
    <div id="logo"></div>
    <nav>
        <?php include 'nStudent.php';?>
    </nav>

    <h1>Form 4 SPM Mathematics Quiz</h1>
    <?php include 'profileBS.php';?>
    
    <!--questions and answers, calculate score, delete trial-->
    <section class="body-container">
        <?php 
        include 'connection.php';
        include 'sessionStudent.php';
        if (isset($_POST['answer'])) {
            include 'score.php';
        } 
        if (isset($_POST['exit'])) {
            include 'deleteTrial.php';
        }
        else {
            include 'printQuestion.php';
        } ?>
    </section>
    <footer>
        <?php include 'footer.php'; ?>
    </footer>
</body>
</html>