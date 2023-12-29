<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question Set</title>
    <link rel="stylesheet" href="layout.css">
</head>
<body>
<div id="logo"></div>
    <nav>
    <ul id='navlist'>
    <li><a href="#home">Home</a></li>
    <li class="dropdown">
        <a href="javascript:void(0)" class="dropbtn">Quiz</a>
        <div class="dropdown-content">
        <?php 
        include "connection.php";
        $SQLselect = "SELECT * FROM topic;";
        $run = mysqli_query($DBconn, $SQLselect);
        if (mysqli_num_rows($run) > 0) {
            while ($data = mysqli_fetch_array($run)) {
                echo '<a href="questionset.php?topicID='.$data['TopicID'].'">'.$data['TopicTitle'].'</a>';
                }        
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
    session_start();
    $username = $_SESSION['StudentUsername'];
    if(!isset($_SESSION['StudentUsername'])) {
        ?> <script>
            window.alert("maow");
        </script>
        <?php
    }
    ?>
    <!--to separate navigation and main body-->
    <section class="body-container">
    <?php
    include 'questionsetform.php';
    ?>
    </section>
    <footer>
    <p>Copyright 2023 © Group 12</p>
    <p>Disclaimer: We are not responsible for any damages.</p>
    <p>Contact Admin bingojeans@gmail.com for any inquiries.</p>
    </footer>
</body>
</html>