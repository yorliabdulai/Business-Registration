<!-- dashboard.php -->
<?php
session_start();
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ... (previous form data validation and sanitization)
// Get the input values from the form
$full_name = $_POST['fullName'];
$date_of_birth = $_POST['dob'];
$gha_card_number = $_POST['ghaCardNumber'];
$mothers_name = $_POST['mothersName'];
$mothers_place_of_birth = $_POST['mothersPlaceOfBirth'];
$business_name = $_POST['businessName'];
$business_location = $_POST['businessLocation'];
$tin_number = $_POST['tinNumber'];
$district = $_POST['district'];
$region = $_POST['region'];
$telephone = $_POST['telephone'];
$email = $_POST['email'];
$nature_of_business = $_POST['natureOfBusiness'];
$house_number = $_POST['houseNumber'];
$gps_address = $_POST['gpsAddress'];
$box_number = $_POST['boxNumber'];
$landmark = $_POST['landmark'];
$ghana_card_front = $_POST['idCardFront'];
$ghana_card_back = $_POST['idCardBack'];

    // Database connection
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "hyperbusinessconsult";

    // Create a connection
    $conn = new mysqli($host, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if (isset($_SESSION['email'])) {
        $userEmail = $_SESSION['email'];
    
        // Check if the email exists in registration_data table
        $email_check_query = "SELECT registration_status FROM registration_data WHERE email = ?";
        $stmt_check = $conn->prepare($email_check_query);
        $stmt_check->bind_param("s", $userEmail);
        $stmt_check->execute();
        $stmt_check->bind_result($existingStatus);
        $stmt_check->fetch();
        $stmt_check->close();
    
        // Display the registration status if available
        if (!empty($existingStatus)) {
            echo "<div class='alert alert-info'>
                Your registration status: <strong>$existingStatus</strong>
            </div>";
        }
    }
    // Check if the business name already exists in the existing_businesses table
    $check_query = "SELECT business_name FROM existing_businesses WHERE business_name = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("s", $business_name);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Business name already exists
        echo "<div class='alert alert-danger'>
        <strong>Error!</strong> Business name already exists. Please choose a different name.
    </div>";
        $stmt->close();
        $conn->close();
    } else {
        // Business name is unique, proceed with registration
        $stmt->close();
        // Prepare and bind the SQL statement for registration_data table
        $insert_query = "INSERT INTO registration_data (business_name, date_of_birth, house_number, gps_address, box_number, full_name, business_location, tin_number, district, region, telephone, email, landmark, nature_of_business, gha_card_number, mothers_name, mothers_place_of_birth, ghana_card_front, ghana_card_back) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("sssssssssssssssssss", $business_name, $date_of_birth, $house_number, $gps_address, $box_number, $full_name, $business_location, $tin_number, $district, $region, $telephone, $email, $landmark, $nature_of_business, $gha_card_number, $mothers_name, $mothers_place_of_birth, $ghana_card_front, $ghana_card_back);

        // Execute the statement
        if ($stmt->execute()) {
            // Registration successful
            echo "<div class='alert alert-success'>
            <strong>Success!</strong> Your registration was successful, you will hear from Us Soon.
        </div>";
         // Set the registration status in the session for immediate display
    $_SESSION['registration_status'] = $registration_status;
        } else {
            // Registration failed
            echo "Error: " . $stmt->error;
        }

        // Close the connection
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <!-- Add the Bootstrap CSS link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <!-- Navbar -->
    <!-- Add your navigation menu here (e.g., Home, Account, Business Registration, etc.) -->

    <div class="container mt-5">
        <h2>Welcome to Our Registration Panel</h2>
<p>Embark on your business formalization journey by providing the required information in the form below. Accurate details are crucial for a smooth and successful registration process.</p>
        <!-- Business Registration Section -->
        <section id="business-registration" class="my-5">
        <div class="container mt-5">
        <h2 class="text-center mb-4">Business Certificate Request Registration</h2>
        <form  class="max-w-md mx-auto form-group form-control bg-info" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <!-- Bio Data -->
            <div class="mb-3">
                <h3 class="mb-3">Bio Data</h3>
                <label for="fullName" class="form-label">Full Name</label>
                <input type="text" id="fullName" name="fullName" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" id="dob" name="dob" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="ghaCardNumber" class="form-label">GHA Card Number</label>
                <input type="text" id="ghaCardNumber" name="ghaCardNumber" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="mothersName" class="form-label">Mother's Name</label>
                <input type="text" id="mothersName" name="mothersName" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="mothersPlaceOfBirth" class="form-label">Mother's Place of Birth</label>
                <input type="text" id="mothersPlaceOfBirth" name="mothersPlaceOfBirth" class="form-control" required>
            </div>
            
            <!-- Business Details -->
            <div class="mb-3">
                <h3 class="mb-3">Business Details</h3>
                <label for="businessName" class="form-label">Business Name</label>
                <input type="text" id="businessName" name="businessName" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label for="businessLocation" class="form-label">Business Location</label>
                <input type="text" id="businessLocation" name="businessLocation" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="tinNumber" class="form-label">TIN NUMBER</label>
                <input type="text" id="tinNumber" name="tinNumber" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="district" class="form-label">District</label>
                <input type="text" id="district" name="district" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="region" class="form-label">Region</label>
                <input type="text" id="region" name="region" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="telephone" class="form-label">Telephone</label>
                <input type="text" id="telephone" name="telephone" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="natureOfBusiness" class="form-label">Nature of Business</label>
                <input type="text" id="natureOfBusiness" name="natureOfBusiness" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="houseNumber" class="form-label">House Number</label>
                <input type="text" id="houseNumber" name="houseNumber" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="gpsAddress" class="form-label">GPS Address</label>
                <input type="text" id="gpsAddress" name="gpsAddress" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="boxNumber" class="form-label">Box Number</label>
                <input type="text" id="boxNumber" name="boxNumber" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="landmark" class="form-label">Landmark</label>
                <input type="text" id="landmark" name="landmark" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="idCardFront" class="form-label">Upload Ghana Card Front</label>
                <input type="file" id="idCardFront" name="idCardFront" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="idCardBack" class="form-label">Upload Ghana Card Back</label>
                <input type="file" id="idCardBack" name="idCardBack" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

        </section>

        


<!-- Display the registration status on the user dashboard -->
<!-- Inside the user dashboard or confirmation page -->


<!-- Display the registration status on the user dashboard -->
 <!-- Display the registration status on the user dashboard -->
 <div class="container mt-5">
        <h3>Your Registration Status</h3>
        <?php
        if (isset($_SESSION['registration_status'])) {
            $registrationStatus = $_SESSION['registration_status'];
            echo "<p>Your registration status: <strong>$registrationStatus</strong></p>";
        } else {
            echo "<p>Your registration status will be displayed here once your registration is processed.</p>";
        }
        ?>
    </div>

 

        <!-- Other Dashboard Sections -->
        <!-- Add other sections relevant to the user's account and business management -->

    <!-- Add the Bootstrap JavaScript and other scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
