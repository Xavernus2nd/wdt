<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Mathematics Quiz</title>
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
    <?php //temporary navigation to choose topic
      include "connection.php";
      $SQLselect = "SELECT * FROM topic;";
      $run = mysqli_query($DBconn, $SQLselect);
      //to test out the sql and printing the right thing or not
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

<footer>
  <p>Copyright 2023 © Group 12</p>
  <p>Disclaimer: We are not responsible for any damages.</p>
  <p>Contact Admin bingojeans@gmail.com for any inquiries.</p>
</footer>


</body>
</html>