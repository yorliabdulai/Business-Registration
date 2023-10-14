<?php
// Turn on output buffering
ob_start();

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the input values from the form
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];
  

  // Validate the input values
  if (empty($email) || empty($password) || empty($confirm_password) || $password !== $confirm_password) {
    echo '<script>alert("Please fill in all the fields and make sure the passwords match");</script>';
    header("Location: signup.php");
    exit;
  }

  // Connect to the database
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "hyperbusinessconsult";
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check for connection errors
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Check if the email already exists in the database
  $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  
  if ($result->num_rows > 0) {
    header("Location: signup.php");
    echo '<script>alert("Email already exists. Please use a different email address.");</script>';
    
    exit;
  }

  // Hash the password
  $password_hash = password_hash($password, PASSWORD_DEFAULT);

  // Insert the user details into the database
  $stmt = $conn->prepare("INSERT INTO users (email, password_hash) VALUES (?, ?)");
  $stmt->bind_param("ss", $email, $password_hash);
  $stmt->execute();

  // Check if the user was added successfully
  if ($stmt->affected_rows === 1) {
    echo '<script>alert("User created successfully!");</script>';
    header("Location: login.php");
  } else {
    echo '<script>alert("Error creating user.");</script>';
    header("Location: signup.php");
  }


  // Close the statement and the database connection
  $stmt->close();
  $conn->close();

}

// Flush the output buffer
ob_end_flush();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <main class="container mx-auto mt-6">
      <h2 class="text-2xl font-bold mb-4">Sign Up</h2>

      <form class="max-w-md mx-auto form-group form-control bg-light" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

        <div class="mb-4">
          <label class="form-label" for="email">Email Address</label>
          <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email address">
        </div>

        <div class="mb-4">
          <label class="form-label" for="password">Password</label>
          <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password">
        </div>

        <div class="mb-4">
          <label class="form-label" for="confirm_password">Confirm Password</label>
          <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm your password">
        </div>

        <div class="d-flex justify-content-center">
          <button type="submit" class="btn btn-primary">Sign Up</button>
        </div>
      </form>
  
    </main>
</body>
</html>


