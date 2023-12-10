<?php
//time taken for student
//or show time left for student?? AHHHH

//if time left, then can send time left to score.php as time taken = 30 mins - time left yeah

//set duration in seconds = minute * second
include 'connection.php';
$trialID = $_POST['trialID'];
$quizDuration  = 30 * 60;

//sql to get timestamp of the trial
$SQLtime = "SELECT DateTime FROM trial WHERE TrialID=$trialID;";
$run = mysqli_query($DBconn, $SQLtime);
$quizStartTime  = strtotime(mysqli_fetch_array($run)['DateTime']);

?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var quizStartTime = <?php echo $quizStartTime; ?>;
        var quizDuration = <?php echo $quizDuration; ?>;
        var timeRemaining = Math.max(0, quizDuration - Math.floor((Date.now() / 1000) - quizStartTime));

        function updateCountdown() {
            var timerElement = document.getElementById('timer');

            if (timeRemaining > 0) {
                timeRemaining--;
                var minutes = Math.floor(timeRemaining / 60);
                var seconds = timeRemaining % 60;
                timerElement.innerHTML = 'Time remaining: ' + (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
            } else {
                timerElement.innerHTML = 'Time expired';
                clearInterval(timerInterval);
            }
        }

        // Update the countdown every second
        var timerInterval = setInterval(updateCountdown, 1000);

        // Initial call to set up the countdown
        updateCountdown();

        // Show the timer once it's set up
        document.getElementById('timer').style.display = 'block';
    });
    // Add an event listener for the form submission
    var submitButton = document.getElementsByName('answer')[0]; // Assuming 'answer' is the name of your submit button
    submitButton.addEventListener('click', function () {
        clearInterval(timerInterval); // Stop the timer when submitting
        saveTimeTaken(quizDuration - timeRemaining); // Save time taken to a hidden input
    });
    // Function to save the time taken to a hidden input
    function saveTimeTaken(timeTaken, submitButton) {
        var form = findParentForm(submitButton);
        if (form) {
            var hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'timeTaken';
            hiddenInput.value = timeTaken;
            form.appendChild(hiddenInput);
        }
    }
    // Function to find the closest form element
    function findParentForm(element) {
        while (element) {
            if (element.nodeName === 'FORM') {
                return element;
            }
            element = element.parentElement;
        }
        return null; // If no form is found
    }
</script>