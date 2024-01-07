<?php
session_start();
if (!isset($_SESSION['StudentUsername'])) {
    ?>
    <script>
        window.alert("Please log in to access this page.");
        window.location.href = 'login.php'; //redirect to login page
    </script>
<?php } ?>