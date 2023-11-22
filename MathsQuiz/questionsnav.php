<?php
session_start();
//not used yet lmaoaooa
include 'connection.php';

$set = $_SESSION['setID'];
$mode = $_SESSION['mode'];
$quesnum = $_SESSION['quesNum'];

if (isset($_GET['prev'])) {
    // Handle logic for navigating to the previous question
    // Adjust the numeric part for the previous question
    $quesnum--;

    $_SESSION['quesNum'] = $quesnum;
} elseif (isset($_GET['next'])) {
    // Handle logic for navigating to the next question
    // Adjust the numeric part for the next question
    $quesnum++;

    $_SESSION['quesNum'] = $quesnum;
}

// Redirect back to the printquestion.php page after handling navigation
header("Location: printquestion.php?setID=$set&mode=$mode&quesNum=$quesnum&beginquiz=");
exit;
?>