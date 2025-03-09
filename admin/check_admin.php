<?php
session_start();

// Check if user is logged in and is an admin
function checkAdmin() {
    if (!isset($_SESSION['uemail']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header("Location: ../auth/login.php");
        exit();
    }
}

// Call the check function
checkAdmin();
?> 