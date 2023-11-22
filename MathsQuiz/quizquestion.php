<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php 
    session_start();
    $_SESSION['StudentUsername'] = 'alya';
    if (isset($_GET['answer'])) {
        include 'score.php';
    } else {
        include 'printquestion.php';
    }
    ?>
</body>
</html>