<?php
//time taken for student
//or show time left for student?? AHHHH

//if time left, then can send time left to score.php as time taken = 30 mins - time left yeah

//set duration in seconds = minute * second
include 'connection.php';
date_default_timezone_set("Asia/Kuala_Lumpur");

?>


<script>
    var timer;
    var timeRemaining;

    document.getElementById('beginButton').addEventListener('click', startTimer);
    function startTimer() {
        // Set the time remaining to 30 minutes
        timeRemaining = 30 * 60;

        // Call updateTimer every second
        timer = setInterval(updateTimer, 1000);

        // Initial call to updateTimer to display the starting time
        updateTimer();
    }

    function updateTimer() {
        // Calculate minutes and seconds
        var minutes = Math.floor(timeRemaining / 60);
        var seconds = timeRemaining % 60;

        // Add leading zeros if needed
        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        // Update the timer display
        document.getElementById("timer").innerText = minutes + ":" + seconds;

        // Decrease the time remaining
        timeRemaining--;

        // Check if the timer has reached zero
        if (timeRemaining < 0) {
            stopTimer();
        }
    }

    function stopTimer() {
        // Clear the interval to stop the timer
        clearInterval(timer);
    }
</script>