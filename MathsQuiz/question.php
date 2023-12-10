<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div id="logo"></div>
    <nav>
    <ul id='navlist'>
    <li><a href="#home">Home</a></li>
    <li class="dropdown">
        <a href="javascript:void(0)" class="dropbtn">Quiz</a>
        <div class="dropdown-content">
        <?php //temporary navigation to choose topic
        include "connection.php";
        $SQLselect = "SELECT * FROM topic;";
        $run = mysqli_query($DBconn, $SQLselect);
        //next step: connecting to question page
        if (mysqli_num_rows($run) > 0) {
            //echo '<ul class="navlist">';
            while ($data = mysqli_fetch_array($run)) {
                echo '<a href="questionset.php?topicID='.$data['TopicID'].'">'.$data['TopicTitle'].'</a>';
                //posts the url with topic id into questionset
                }
        //echo '</ul>';
        }
        ?>
        
        </div>
    </li>
    <li><a href="#Result">News</a></li>
    <li><a href="#contactus">Contact Us</a></li>
    </ul>
    </nav>

    <h1>Form 4 SPM Mathematics Quiz</h1>
    <?php
    //choose topic -> choose question set and choose mode -> *begin -> answer question* -> show result and answers
    //add isset post beginquiz
    //printquestion.php
    session_start();
    $username = $_SESSION['StudentUsername'];
    $set=$_GET['setID'];
    $mode=$_GET['mode'];
    include 'connection.php';
        include 'questionsetbegin.php';
    ?>
    <footer>
    <p>Copyright 2023 © Group 12</p>
    <p>Disclaimer: We are not responsible for any damages.</p>
    <p>Contact Admin bingojeans@gmail.com for any inquiries.</p>
    </footer>
</body>
</html>