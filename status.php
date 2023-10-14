<?php
include('dashboard');
session_start();
$email = $_SESSION['email'];

// Fetch registration status from the session (immediate display) or database (for future logins)
if (isset($_SESSION['registration_status'])) {
    $registrationStatus = $_SESSION['registration_status'];
} else {
    $status_query = "SELECT registration_status FROM registration_data WHERE email = ?";
    $status_stmt = $conn->prepare($status_query);
    $status_stmt->bind_param("s", $email);
    $status_stmt->execute();
    $status_stmt->bind_result($registrationStatus);
    $status_stmt->fetch();
    $status_stmt->close();
}
?>