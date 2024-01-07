<?php
    session_start();
    function logout (){
        unset($_SESSION['username']);
        if (isset($_SESSION['StudentUsername'])) {
            unset($_SESSION['StudentUsername']);
        } else if (isset($_SESSION['TeacherUsername'])) {
            unset($_SESSION['TeacherUsername']);
        } else if (isset($_SESSION['AdminUsername'])) {
            unset($_SESSION['AdminUsername']);
        }
    }
    logout();
    echo "<script>
        window.alert('You have logged out successfully.');
        window.location.href = 'index.php';
        </script>";
?>
