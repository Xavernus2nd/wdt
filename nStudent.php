<ul id='navlist'>
    <li><a href="homeS.php">Home</a></li>
    <li class="dropdown">
        <a href="javascript:void(0)" class="dropbtn">Quiz</a>
        <div class="dropdown-content">
            <?php
                include "connection.php";
                $SQLselect = "SELECT * FROM topic;";
                $run = mysqli_query($DBconn, $SQLselect);
                        
                if (mysqli_num_rows($run) > 0) {
                    while ($data = mysqli_fetch_array($run)) {
                    echo '<a href = "questionset.php?topicID='.$data['TopicID'].'">'.$data['TopicTitle'].'</a>';
                }
            } ?>
        </div>
    </li>
    <li><a href="#Result">viewResultsStudent.php</a></li> 
    <li><a href="contactUsS.php">Contact Us</a></li>
</ul>
