<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question Set</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav>
        <?php include 'tempnav.php'; ?>
    </nav>
    <h1>Choose Question Set</h1>

    <?php
    session_start();
    $username = $_SESSION['StudentUsername'];
    if(!isset($_SESSION['StudentUsername'])) {
        ?> <script>
            window.alert("maow");
        </script>
        <?php
    }
    //choose topic -> *choose question set and choose mode* -> begin -> answer question -> show result and answers
    //if isset, it will process it, if not then form
    //to show form to choose question set je kot lol
    include 'questionsetform.php';
    ?>
</body>
</html>