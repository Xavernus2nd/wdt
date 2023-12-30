<?php 
    //connection of database and website
    $DBconn=mysqli_connect('localhost','root','', 'MathsQuiz');
    //output if connection to database fails
    if (!$DBconn) {
        echo "Connection to the database is unsuccessful.";
    }
?>