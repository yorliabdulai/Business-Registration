<?php
// Include database connection
include('admin.php');

// Establish mysqli connection
$conn = new mysqli("localhost", "root", "", "hyperbusinessconsult");

if (isset($_GET['id'])) {
    $applicantId = $_GET['id'];

    // Update applicant's status to "Granted"
    $sql = "UPDATE registration_data SET status = 'Granted' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $applicantId);
    $stmt->execute();

    $stmt->close();

    // Redirect back to admin dashboard or a success page
    header('Location: admin.php');
    exit;
} else {
    echo "Invalid request.";
    exit;
}
?>
