<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Answer Quiz</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php 
    session_start();
    $_SESSION['StudentUsername'] = 'alya';
    if (isset($_POST['answer'])) {
        //need to check whether all questions are answered then only it'll proceed with the score
        include 'score.php';
    } if (isset($_POST['exit'])) {
        include 'deletetrial.php';
    }
    
    else {
        include 'printquestion.php';
        include 'quesdirectory.php'; //this is the directory of the questions - need to put it in div beside print question
    }
    ?>
</body>
</html>