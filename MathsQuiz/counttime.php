<?php
include 'connection.php';
date_default_timezone_set("Asia/Kuala_Lumpur");
//$trial = $_POST['trialID'];

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['countdown_timer'])) {
    $_SESSION['countdown_timer'] = max(0, (int)$_POST['countdown_timer']);
}

//1. when quiz starts, time taken duration is initialized as time taken = 00:00 or wtv
//2. display timer = 30:00 - time taken
//3. when student clicks save, next, previous, question directory, the time taken is updated in the trial table as time taken
//4. when student clicks submit, timer is stopped and recorded in trial table
//5. when student clicks exit, timer just stops

//1. when quiz starts, timer duration is initialized
//2. when student clicks save, next, previous, question directory, the timer is updated in the trial table as time taken (shud change to time remaining)
//3. time duration now becomes the time remaining
//4. when student clicks submit, the timer is stopped and recorded in the trial table yeh
//when student clicks exit, timer just stops
?>