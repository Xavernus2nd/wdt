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
                            echo '<a href="questionSet.php?topicID='.$data['TopicID'].'">'.$data['TopicTitle'].'</a>';
                        }
                    } ?>        
                </div>
            </li>
            <li><a href="#Result">News</a></li>
            <li><a href="#contactus">Contact Us</a></li>
        </ul>
    </nav>

    <h1>Form 4 SPM Mathematics Quiz</h1>
    <!--question set begin menu-->
    <section class="body-container">
        <?php
        include 'connection.php';
        session_start();
        $username = $_SESSION['StudentUsername'];
        if(!isset($_SESSION['StudentUsername'])) {
            ?> <script>
                window.alert("Please log in to access this page.");
                window.location.href = 'index.php'; //redirect to main homepage
            </script>
            <?php
        } else {
            include 'questionSetBegin.php';
        } ?>
    </section>
    <footer>
        <?php include 'footer.php'; ?>
    </footer>
</body>
</html>