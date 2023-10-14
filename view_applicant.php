<?php
// Include database connection
include('admin.php');

// Establish mysqli connection
$conn = new mysqli("localhost", "root", "", "hyperbusinessconsult");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $applicantId = $_GET['id'];

    // Fetch applicant data
    $sql = "SELECT * FROM registration_data WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $applicantId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $applicant = $result->fetch_assoc();
        // Display applicant data here
    } else {
        echo "Applicant not found.";
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

// Close the mysqli connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Include your CSS and other head elements -->
</head>
<body>
<div class="container">
    <h2 class="text-primary">View Applicant Details</h2>
    <div class="row">
        <div class="col-md-8">
            <?php
            if (isset($applicant)) {
                echo "<div class='card'>";
                echo "<div class='card-body'>";
                echo "<ul class='list-unstyled'>";
                echo "<li><strong>Business Name:</strong> " . $applicant['business_name'] . "</li>";
                echo "<li><strong>Date of Birth:</strong> " . $applicant['date_of_birth'] . "</li>";
                echo "<li><strong>House Number:</strong> " . $applicant['house_number'] . "</li>";
                echo "<li><strong>GPS Address:</strong> " . $applicant['gps_address'] . "</li>";
                echo "<li><strong>Box Number:</strong> " . $applicant['box_number'] . "</li>";
                echo "<li><strong>Full Name:</strong> " . $applicant['full_name'] . "</li>";
                echo "<li><strong>Business Location:</strong> " . $applicant['business_location'] . "</li>";
                echo "<li><strong>TIN Number:</strong> " . $applicant['tin_number'] . "</li>";
                echo "<li><strong>District:</strong> " . $applicant['district'] . "</li>";
                echo "<li><strong>Region:</strong> " . $applicant['region'] . "</li>";
                echo "<li><strong>Telephone:</strong> " . $applicant['telephone'] . "</li>";
                echo "<li><strong>Email Address:</strong> " . $applicant['email'] . "</li>";
                echo "<li><strong>Landmark:</strong> " . $applicant['landmark'] . "</li>";
                echo "<li><strong>Nature of Business:</strong> " . $applicant['nature_of_business'] . "</li>";
                echo "<li><strong>GHA Card Number:</strong> " . $applicant['gha_card_number'] . "</li>";
                echo "<li><strong>Mother's Name:</strong> " . $applicant['mothers_name'] . "</li>";
                echo "<li><strong>Mother's Place of Birth:</strong> " . $applicant['mothers_place_of_birth'] . "</li>";
                echo "<li><strong>Application Status:</strong> " . $applicant['status'] . "</li>";
                echo "</ul>";
                echo "</div>";
                echo "</div>";

                if (!empty($applicant['ghana_card_front'])) {
                    echo "<div class='card mt-3'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>Ghana Card Front</h5>";
                    echo "<img class='img-fluid' src='data:image/jpeg;base64," . base64_encode($applicant['ghana_card_front']) . "' alt='Ghana Card Front'>";
                    echo "</div>";
                    echo "</div>";
                }

                if (!empty($applicant['ghana_card_back'])) {
                    echo "<div class='card mt-3'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>Ghana Card Back</h5>";
                    echo "<img class='img-fluid' src='data:image/jpeg;base64," . base64_encode($applicant['ghana_card_back']) . "' alt='Ghana Card Back'>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p class='text-danger'>Applicant not found.</p>";
            }
            ?>
        </div>
    </div>
</div>


</body>
</html>
