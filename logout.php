<?php
    session_start();
    function logout (){
        unset($_SESSION['username']);
        // header ('Location : index.php');
    }
    logout();
    echo "<script>window.location.href = 'index.php'</script>";

?>
