<?php //temporary navigation to choose topic
include "connection.php";
$SQLselect = "SELECT * FROM topic;";
$run = mysqli_query($DBconn, $SQLselect);
//to test out the sql and printing the right thing or not
//next step: connecting to question page
if (mysqli_num_rows($run) > 0) {
    echo '<ul class="navigation">';
    while ($data = mysqli_fetch_array($run)) {
        echo '<li><a href="questionset.php?topicID='.$data['TopicID'].'">'.$data['TopicTitle'].'</a></li>';
        //posts the url with topic id into questionset
    }
    echo '</ul>';
}
?>