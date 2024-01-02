<?php
include 'connection.php';
date_default_timezone_set("Asia/Kuala_Lumpur");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['countdown_timer'])) {
    $_SESSION['countdown_timer'] = max(0, (int)$_POST['countdown_timer']);
} ?>