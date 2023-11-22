<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
    //choose topic -> choose question set and choose mode -> *begin -> answer question* -> show result and answers
    //add isset post beginquiz
    //printquestion.php
    session_start();
    $username = $_SESSION['StudentUsername'];
    $_SESSION['setID']=$_GET['setID'];
    $_SESSION['mode']=$_GET['mode'];
    if (isset($_GET['beginquiz'])) {
        include 'printquestion.php';
    } else {
        include 'questionsetbegin.php';
    }
    ?>
</body>
</html>