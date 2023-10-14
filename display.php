<?php
include('admin.php');

if (isset($_GET['id'])) {
    $applicantId = $_GET['id'];

    // Fetch applicant data
    $sql = "SELECT ghana_card_front, ghana_card_back FROM registration_data WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $applicantId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $applicant = $result->fetch_assoc();
        
        // Display Ghana Card Front
        if (!empty($applicant['ghana_card_front'])) {
            header("Content-type: image/jpeg");
            echo $applicant['ghana_card_front'];
            exit;
        }

        // Display Ghana Card Back
        if (!empty($applicant['ghana_card_back'])) {
            header("Content-type: image/jpeg");
            echo $applicant['ghana_card_back'];
            exit;
        }
    }
}
