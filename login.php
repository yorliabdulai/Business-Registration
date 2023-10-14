<?php
// Turn on output buffering
ob_start();

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get the input values from the form
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Validate the input values
  if (empty($email) || empty($password)) {
    echo '<script>alert("Please fill in all the fields");</script>';
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

  // Prepare the SQL statement with placeholders
  $stmt = $conn->prepare("SELECT id, email, password_hash FROM users WHERE email = ?");

  // Bind the input parameters to the placeholders
  $stmt->bind_param("s", $email);

  // Execute the statement
  $stmt->execute();

  // Fetch the result
  $result = $stmt->get_result();

  // Check if the user is a valid user
  if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    // Verify the password hash
    if (password_verify($password, $row['password_hash'])) {

      // Start a new session and store the user ID
      session_start();
      $_SESSION['user_id'] = $row['id'];

      // Redirect the user to the dashboard page
      header('Location: dashboard.php');
      exit;

    } else {
      echo '<script>alert("Invalid email or password");</script>';
      exit;
    }

  } else {
    echo '<script>alert("Invalid email or password");</script>';
    exit;
  }

  // Close the statement and the database connection
  $stmt->close();
  $conn->close();

}

// Flush the output buffer and send the redirect header
ob_end_flush();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Login</h2>
        <form class="max-w-md mx-auto form-group form-control bg-info" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>

        <div class="mt-4 text-center">
            <span>Don't have an account? <a href="signup.php">Sign up</a></span>
        </div>
    </div>
</body>
</html>


